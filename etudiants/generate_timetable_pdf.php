<?php
session_start();
require_once '../includes/config.php'; // Adjust path to your config.php file
require_once '../fpdf/fpdf.php'; // Adjust path to your FPDF library (e.g., '../fpdf/fpdf.php')

// Verify if the user is logged in and has the 'etudiant' role
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'etudiant') {
    header("Location: login.php");
    exit();
}

// Get the class ID from the URL parameter
$classe_id = isset($_GET['classe_id']) ? intval($_GET['classe_id']) : 0;

if ($classe_id === 0) {
    die("ID de classe non spécifié pour la génération du PDF.");
}

// Fetch class name for the PDF title
$classe_nom_display = "Classe Inconnue";
try {
    $stmt_classe = $pdo->prepare("SELECT nom_classe, niveau, filiere FROM classes WHERE id = ?");
    $stmt_classe->execute([$classe_id]);
    $class_info = $stmt_classe->fetch(PDO::FETCH_ASSOC);
    if ($class_info) {
        $classe_nom_display = $class_info['nom_classe'] . ' (' . $class_info['niveau'] . ' ' . $class_info['filiere'] . ')';
    }
} catch (PDOException $e) {
    error_log("Error fetching class name for PDF: " . $e->getMessage());
    // Continue with default name if there's a DB error
}

// Define the time slots and days consistently with your timetable management
$time_slots = [
    ['08:00', '10:00'],
    ['10:00', '12:00'],
    ['14:00', '16:00'],
    ['16:00', '18:00']
];
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

// Fetch timetable data for the selected class
$emploi_du_temps_data = [];
try {
    $stmt_edt = $pdo->prepare("
        SELECT edt.jour_semaine, edt.heure_debut, edt.heure_fin, m.nom AS nom_matiere, CONCAT(u.nom, ' ', u.prenom) AS nom_professeur, edt.salle
        FROM emploi_du_temps edt
        LEFT JOIN matieres m ON edt.matiere_id = m.id
        LEFT JOIN utilisateurs u ON edt.professeur_id = u.id AND u.role = 'professeur'
        WHERE edt.classe_id = ?
        ORDER BY FIELD(jour_semaine, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), heure_debut
    ");
    $stmt_edt->execute([$classe_id]);
    $raw_edt_data = $stmt_edt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize $emploi_du_temps_data with empty slots for all combinations
    foreach ($jours as $jour) {
        foreach ($time_slots as $slot) {
            $slot_key = $slot[0] . '-' . $slot[1];
            $emploi_du_temps_data[$jour][$slot_key] = [
                'matiere' => '',
                'professeur' => '',
                'salle' => ''
            ];
        }
    }

    // Populate $emploi_du_temps_data with fetched values
    foreach ($raw_edt_data as $row) {
        $slot_key = $row['heure_debut'] . '-' . $row['heure_fin'];
        if (isset($emploi_du_temps_data[$row['jour_semaine']][$slot_key])) {
            $emploi_du_temps_data[$row['jour_semaine']][$slot_key]['matiere'] = $row['nom_matiere'];
            $emploi_du_temps_data[$row['jour_semaine']][$slot_key]['professeur'] = $row['nom_professeur'];
            $emploi_du_temps_data[$row['jour_semaine']][$slot_key]['salle'] = $row['salle'];
        }
    }

} catch (PDOException $e) {
    error_log("Error fetching timetable data for PDF: " . $e->getMessage());
    die("Erreur lors de la récupération des données de l'emploi du temps pour le PDF.");
}

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode("Emploi du Temps - " . $classe_nom_display), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, utf8_decode("Généré le: " . date("d/m/Y H:i")), 0, 1, 'R');
$pdf->Ln(5);

// Table Header
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(140, 90, 43); // Primary color: #8c5a2b
$pdf->SetTextColor(255, 255, 255); // White text

$col_width_day = 30; // Width for "Day / Slot" column
$page_width = $pdf->GetPageWidth() - $pdf->GetX() - 10; // Calculate remaining width, assuming default margins
$col_width_slot_total = ($page_width - $col_width_day) / count($time_slots); // Remaining width divided by number of slots

// First row of header
$pdf->Cell($col_width_day, 15, utf8_decode("Jour / Créneau"), 1, 0, 'C', true);
foreach ($time_slots as $slot_index => $slot) {
    $pdf->Cell($col_width_slot_total, 7.5, utf8_decode("Créneau " . ($slot_index + 1)), 'LR', 0, 'C', true);
}
$pdf->Ln(7.5);

// Second row of header (for time ranges)
$pdf->Cell($col_width_day, 7.5, '', 'LBR', 0, 'C', true); // Empty cell below "Jour / Créneau"
foreach ($time_slots as $slot) {
    $pdf->Cell($col_width_slot_total, 7.5, utf8_decode("(" . $slot[0] . "-" . $slot[1] . ")"), 'LRB', 0, 'C', true);
}
$pdf->Ln(7.5);

// Table Rows
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->SetFillColor(255, 255, 255); // White background for content cells

foreach ($jours as $jour) {
    $pdf->Cell($col_width_day, 20, utf8_decode($jour), 1, 0, 'C'); // Day column
    foreach ($time_slots as $slot) {
        $slot_key = $slot[0] . '-' . $slot[1];
        $data = $emploi_du_temps_data[$jour][$slot_key];

        // Combine info for MultiCell
        $cell_content = "";
        if (!empty($data['matiere'])) $cell_content .= $data['matiere'] . "\n";
        if (!empty($data['professeur'])) $cell_content .= $data['professeur'] . "\n";
        if (!empty($data['salle'])) $cell_content .= $data['salle'];

        // Output cell content for each slot
        // MultiCell allows text wrapping within a fixed width
        $x_pos = $pdf->GetX();
        $y_pos = $pdf->GetY();

        $pdf->Rect($x_pos, $y_pos, $col_width_slot_total, 20); // Draw cell border manually

        $pdf->SetXY($x_pos, $y_pos + 1); // Slight padding from top for MultiCell
        $pdf->MultiCell($col_width_slot_total, 4, utf8_decode(trim($cell_content)), 0, 'C'); // No border for MultiCell content
        $pdf->SetXY($x_pos + $col_width_slot_total, $y_pos); // Move cursor to the right edge of the cell for the next one
    }
    $pdf->Ln(20); // Move to the next row (height of 20)
}

// Output the PDF
$pdf->Output('D', 'emploi_du_temps_' . str_replace([' ', '(', ')'], '_', $classe_nom_display) . '.pdf');
exit;
?>