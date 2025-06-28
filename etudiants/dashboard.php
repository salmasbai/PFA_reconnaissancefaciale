<?php
session_start();
// Vérifier si l'utilisateur est connecté et a bien le rôle 'etudiant'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'etudiant') {
    header("Location: login.php"); // Rediriger vers la page de connexion si non authentifié ou mauvais rôle
    exit();
}

// Inclure le fichier de configuration de la base de données
require_once '../includes/config.php';

// Récupérer le code de langue de la session ou utiliser le français par défaut
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// --------------------------------------------------------------------------------------
// Données de l'étudiant récupérées depuis la session (définies lors de la connexion)
// --------------------------------------------------------------------------------------
$student_user_id = $_SESSION['user_id']; // Renamed to avoid confusion with etudiant.id
$student_name = $_SESSION['user_name'] ?? 'Utilisateur Inconnu';
$student_email = $_SESSION['user_email'] ?? 'N/A';

// Fetch detailed student info from 'etudiants' table based on user_id
$etudiant_entity_id = null;
$student_numero_etudiant = 'N/A';
$student_filiere = 'N/A';
$student_cycle = 'N/A';
$student_photo_path = null;
$student_numero_apogee = 'N/A';
$student_code_massar = 'N/A';
$student_classe_id = null; // Initialize student_classe_id
$current_class_name = 'N/A'; // For PDF filename

try {
    $stmt_student_details = $pdo->prepare("
        SELECT e.id, e.numero_etudiant, e.photo_path, e.code_massar, e.numero_apogee, e.cycle, c.id AS classe_id, c.nom_classe, f.nom_filiere
        FROM etudiants e
        LEFT JOIN classes c ON e.classe_id = c.id
        LEFT JOIN filieres f ON e.filiere_id = f.id
        WHERE e.user_id = ?
    ");
    $stmt_student_details->execute([$student_user_id]);
    $student_data = $stmt_student_details->fetch(PDO::FETCH_ASSOC);

    if ($student_data) {
        $etudiant_entity_id = $student_data['id']; // This is the ID from the 'etudiants' table
        $student_numero_etudiant = $student_data['numero_etudiant'];
        $student_filiere = $student_data['nom_filiere'];
        $student_cycle = $student_data['cycle'];
        $student_photo_path = $student_data['photo_path'];
        $student_numero_apogee = $student_data['numero_apogee'];
        $student_code_massar = $student_data['code_massar'];
        $student_classe_id = $student_data['classe_id']; // Store classe_id in a variable
        $current_class_name = $student_data['nom_classe'] ?? 'N/A'; // Get class name for PDF filename
    }
} catch (PDOException $e) {
    error_log("Error fetching student details for user ID " . $student_user_id . ": " . $e->getMessage());
    // Handle error gracefully
}

// The "classe" for display, combining filière and cycle
$student_class = ($student_filiere != 'N/A' ? $student_filiere : '') . ($student_cycle != 'N/A' ? ' - ' . $student_cycle : '');
if ($student_class === '') {
    $student_class = 'N/A';
}

// Date et heure actuelles pour l'affichage
$current_date = date("d/m/Y");
$current_time = date("H:i");

// --------------------------------------------------------------------------------------
// Récupération des absences récentes de l'étudiant depuis la base de données
// --------------------------------------------------------------------------------------
$recent_absences = [];
try {
    if ($etudiant_entity_id) {
        // Si l'ID de l'entité étudiant est trouvé, récupérer ses absences
        $stmt_absences = $pdo->prepare("SELECT a.date, m.nom AS matiere_nom, a.justifiee
                                         FROM absences a
                                         JOIN matieres m ON a.matiere_id = m.id
                                         WHERE a.etudiant_id = ?
                                         ORDER BY a.date DESC
                                         LIMIT 5"); // Limiter aux 5 dernières absences
        $stmt_absences->execute([$etudiant_entity_id]);
        $recent_absences = $stmt_absences->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    // Gérer l'erreur de base de données pour les absences
    error_log("Error fetching student absences for user ID " . $student_user_id . ": " . $e->getMessage());
}

// --- Fetch Timetable Data for display and PDF (if student has a class) ---
$student_timetable_data = [];
$time_slots = [
    ['08:00', '10:00'],
    ['10:00', '12:00'],
    ['14:00', '16:00'],
    ['16:00', '18:00']
];
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

if ($student_classe_id) {
    try {
        $stmt_edt = $pdo->prepare("
            SELECT edt.jour_semaine, edt.heure_debut, edt.heure_fin, m.nom AS nom_matiere, CONCAT(u.nom, ' ', u.prenom) AS nom_professeur, edt.salle
            FROM emploi_du_temps edt
            LEFT JOIN matieres m ON edt.matiere_id = m.id
            LEFT JOIN utilisateurs u ON edt.professeur_id = u.id AND u.role = 'professeur'
            WHERE edt.classe_id = ?
            ORDER BY FIELD(jour_semaine, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), heure_debut
        ");
        $stmt_edt->execute([$student_classe_id]);
        $raw_edt_data = $stmt_edt->fetchAll(PDO::FETCH_ASSOC);

        // Initialize $student_timetable_data with empty slots for all combinations
        foreach ($jours as $jour) {
            foreach ($time_slots as $slot) {
                $slot_key = $slot[0] . '-' . $slot[1];
                $student_timetable_data[$jour][$slot_key] = [
                    'matiere' => '',
                    'professeur' => '',
                    'salle' => ''
                ];
            }
        }

        // Populate $student_timetable_data with fetched values
        foreach ($raw_edt_data as $row) {
            $slot_key = substr($row['heure_debut'], 0, 5) . '-' . substr($row['heure_fin'], 0, 5);
            if (isset($student_timetable_data[$row['jour_semaine']][$slot_key])) {
                $student_timetable_data[$row['jour_semaine']][$slot_key]['matiere'] = $row['nom_matiere'];
                $student_timetable_data[$row['jour_semaine']][$slot_key]['professeur'] = $row['nom_professeur'];
                $student_timetable_data[$row['jour_semaine']][$slot_key]['salle'] = $row['salle'];
            }
        }

    } catch (PDOException $e) {
        error_log("Error fetching student timetable data: " . $e->getMessage());
    }
}

// --------------------------------------------------------------------------------------
// Contenu HTML du Tableau de Bord Étudiant
// --------------------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['student_dashboard_title'] ?? 'Tableau de Bord Étudiant') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f4f1;
            color: #333;
            padding-top: 70px; /* Pour la barre de navigation fixe */
        }
        .navbar-brand img {
            height: 48px;
            margin-right: .5rem;
        }
        .navbar-nav .nav-link {
            color: #000;
            font-weight: 500;
        }
        .navbar-nav .nav-link.active {
            color: var(--primary) !important;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: var(--primary);
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-weight: bold;
        }
        /* Style pour les sections de contenu */
        .content-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        .text-success { color: #28a745 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-info { color: #17a2b8 !important; } /* Pour les justificatifs */

        footer {
            background: var(--primary);
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        /* Accessibilité : Mode Daltonien */
        body.daltonien-mode {
            filter: grayscale(100%);
        }
        /* Timetable table styling */
        .timetable-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden; /* For rounded corners with border-collapse */
        }
        .timetable-table th, .timetable-table td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            text-align: center;
            font-size: 13px;
            vertical-align: middle;
        }
        .timetable-table th {
            background-color: var(--secondary);
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }
        .timetable-table tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        .timetable-table tr:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/images/logo_ensao.png" alt="Logo ENSAO" />
            <span class="fw-bold">ENSAO</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNav"
            aria-controls="mainNav"
            aria-expanded="false"
            aria-label="Basculer la navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#"><?= htmlspecialchars($lang['dashboard'] ?? 'Tableau de Bord') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#records"><?= htmlspecialchars($lang['absence_records'] ?? 'Historique des Absences') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#schedule"><?= htmlspecialchars($lang['schedule'] ?? 'Emploi du Temps') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#justifications"><?= htmlspecialchars($lang['justifications'] ?? 'Justificatifs') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#profile"><?= htmlspecialchars($lang['profile'] ?? 'Mon Profil') ?></a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a
                        class="dropdown-toggle text-dark text-decoration-none"
                        href="#"
                        id="langDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    ><?= strtoupper($lang_code) ?></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        <li><a class="dropdown-item" href="?lang=fr">FR – Français</a></li>
                        <li><a class="dropdown-item" href="?lang=en">EN – English</a></li>
                        <li><a class="dropdown-item" href="?lang=ar">AR – العربية</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary" id="daltonienModeToggle">
                    <i class="bi bi-eye-slash"></i> <?= htmlspecialchars($lang['daltonian_mode'] ?? 'Mode Daltonien') ?>
                </button>
                <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <?= htmlspecialchars($lang['logout'] ?? 'Déconnexion') ?></a>
            </div>
        </div>
    </div>
</nav>

<section class="dashboard-header text-center">
    <div class="container">
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['welcome_student'] ?? 'Bienvenue') ?>, <?= htmlspecialchars($student_name) ?>!</h1>
        <p class="lead"><?= htmlspecialchars($lang['current_class'] ?? 'Votre Classe') ?>: <?= htmlspecialchars($student_class) ?></p>
        <p class="mb-0"><?= htmlspecialchars($lang['current_time'] ?? 'Date et Heure Actuelles') ?>: <?= $current_date ?> <?= $current_time ?></p>
    </div>
</section>

<main class="container">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-graph-up me-2"></i> <?= htmlspecialchars($lang['quick_overview'] ?? 'Vue d\'ensemble rapide') ?>
                </div>
                <div class="card-body">
                    <p><strong><?= htmlspecialchars($lang['total_absences'] ?? 'Total Absences') ?>:</strong> <span class="badge bg-warning text-dark">5</span></p>
                    <p><strong><?= htmlspecialchars($lang['justified_absences'] ?? 'Absences Justifiées') ?>:</strong> <span class="badge bg-success">3</span></p>
                    <p><strong><?= htmlspecialchars($lang['unjustified_absences'] ?? 'Absences Non Justifiées') ?>:</strong> <span class="badge bg-danger">2</span></p>
                    <hr>
                    <p class="small text-muted"><?= htmlspecialchars($lang['data_updated'] ?? 'Dernière mise à jour') ?>: <?= $current_date ?></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-bell me-2"></i> <?= htmlspecialchars($lang['notifications'] ?? 'Notifications') ?>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> <?= htmlspecialchars($lang['notification_success'] ?? 'Votre présence pour "Algorithmique" a été enregistrée.') ?></li>
                        <li class="list-group-item d-flex align-items-center"><i class="bi bi-info-circle-fill text-info me-2"></i> <?= htmlspecialchars($lang['notification_reminder'] ?? 'Rappel: Cours de Réseaux à 14h.') ?></li>
                        <li class="list-group-item d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> <?= htmlspecialchars($lang['notification_unjustified'] ?? 'Absence non justifiée pour le cours de "Base de Données".') ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="content-section">
                <h3 class="mb-3"><i class="bi bi-person-bounding-box me-2"></i> <?= htmlspecialchars($lang['facial_enrollment_title'] ?? 'Enregistrement Facial Initial') ?></h3>
                <p class="text-muted"><?= htmlspecialchars($lang['facial_enrollment_desc'] ?? 'Si ce n\'est pas déjà fait, veuillez enregistrer vos photos faciales pour la reconnaissance automatique des présences.') ?></p>
                <div class="text-center">
                    <img src="https://via.placeholder.com/300x200?text=Selfie+Dynamique" class="img-fluid rounded mb-3" alt="Selfie Dynamique Placeholder">
                    <p class="small text-muted"><?= htmlspecialchars($lang['facial_enrollment_instruction'] ?? 'Suivez les instructions à l\'écran (tournez la tête, clignez des yeux) pour capturer vos images.') ?></p>
                    <button class="btn btn-primary"><i class="bi bi-camera me-2"></i> <?= htmlspecialchars($lang['start_enrollment'] ?? 'Démarrer l\'enregistrement') ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4" id="records">
        <div class="card-header">
            <i class="bi bi-calendar-check me-2"></i> <?= htmlspecialchars($lang['absence_history'] ?? 'Historique des Absences') ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['date'] ?? 'Date') ?></th>
                            <th><?= htmlspecialchars($lang['course'] ?? 'Cours') ?></th>
                            <th><?= htmlspecialchars($lang['status'] ?? 'Statut') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_absences)): ?>
                            <?php foreach ($recent_absences as $absence): ?>
                                <tr>
                                    <td><?= htmlspecialchars($absence['date']) ?></td>
                                    <td><?= htmlspecialchars($absence['matiere_nom']) ?></td>
                                    <td>
                                        <?php
                                            // 'justifiee' est un tinyint(1) dans votre DB
                                            if ($absence['justifiee'] == 1) {
                                                echo '<span class="badge bg-info">' . htmlspecialchars($lang['justified'] ?? 'Justifiée') . '</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">' . htmlspecialchars($lang['unjustified'] ?? 'Non Justifiée') . '</span>';
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center"><?= htmlspecialchars($lang['no_absence_records'] ?? 'Aucun historique d\'absences disponible.') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="#" class="btn btn-outline-primary"><?= htmlspecialchars($lang['view_all_records'] ?? 'Voir tout l\'historique') ?></a>
            </div>
        </div>
    </div>

    <div class="content-section" id="schedule">
        <h3 class="mb-3"><i class="bi bi-calendar-week me-2"></i> <?= htmlspecialchars($lang['schedule'] ?? 'Mon Emploi du Temps') ?></h3>
        <p class="text-muted"><?= htmlspecialchars($lang['schedule_desc'] ?? 'Consultez votre emploi du temps hebdomadaire.') ?></p>
        <?php if ($student_classe_id && !empty($student_timetable_data)): ?>
            <div class="table-responsive" id="timetableToDownload">
                <table class="timetable-table">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['day_slot'] ?? 'Jour / Créneau') ?></th>
                            <?php foreach ($time_slots as $slot_index => $slot): ?>
                                <th>
                                    <?= htmlspecialchars($lang['slot'] ?? 'Créneau') ?> <?= $slot_index + 1 ?><br>
                                    <small>(<?= htmlspecialchars($slot[0] . '-' . $slot[1]) ?>)</small>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jours as $jour): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($jour) ?></strong></td>
                                <?php foreach ($time_slots as $slot):
                                    $slot_key = $slot[0] . '-' . $slot[1];
                                    $data = $student_timetable_data[$jour][$slot_key];
                                ?>
                                    <td>
                                        <?php if (!empty($data['matiere'])): ?>
                                            <strong><?= htmlspecialchars($data['matiere']) ?></strong><br>
                                            <small><?= htmlspecialchars($data['professeur']) ?></small><br>
                                            <small class="text-muted"><?= htmlspecialchars($data['salle']) ?></small>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-outline-primary" id="downloadPdfButton">
                    <i class="bi bi-download me-2"></i> <?= htmlspecialchars($lang['download_schedule'] ?? 'Télécharger l\'emploi du temps') ?> (PDF)
                </button>
            </div>
        <?php elseif ($student_classe_id && empty($student_timetable_data)): ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars($lang['no_schedule_for_your_class'] ?? 'Aucun emploi du temps n\'est défini pour votre classe pour le moment.') ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars($lang['no_class_assigned'] ?? 'Votre classe n\'est pas encore attribuée, impossible d\'afficher l\'emploi du temps.') ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="content-section" id="justifications">
        <h3 class="mb-3"><i class="bi bi-file-earmark-arrow-up me-2"></i> <?= htmlspecialchars($lang['justifications'] ?? 'Justificatifs d\'Absence') ?></h3>
        <p class="text-muted"><?= htmlspecialchars($lang['justifications_desc'] ?? 'Téléchargez un justificatif pour vos absences non justifiées.') ?></p>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="absence_date_justify" class="form-label"><?= htmlspecialchars($lang['absence_date'] ?? 'Date de l\'absence') ?>:</label>
                <input type="date" class="form-control" id="absence_date_justify" name="absence_date_justify" required>
            </div>
            <div class="mb-3">
                <label for="justification_file" class="form-label"><?= htmlspecialchars($lang['upload_justification'] ?? 'Télécharger le justificatif') ?> (PDF, JPG, PNG) :</label>
                <input type="file" class="form-control" id="justification_file" name="justification_file" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-2"></i> <?= htmlspecialchars($lang['submit_justification'] ?? 'Soumettre le justificatif') ?></button>
        </form>
        <h4 class="mt-4"><?= htmlspecialchars($lang['submitted_justifications'] ?? 'Justificatifs Soumis') ?></h4>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Absence du 2025-05-18 - Certificat médical.pdf
                <span class="badge bg-warning text-dark"><?= htmlspecialchars($lang['pending'] ?? 'En attente') ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Absence du 2025-05-10 - Raison familiale.pdf
                <span class="badge bg-success"><?= htmlspecialchars($lang['approved'] ?? 'Approuvé') ?></span>
            </li>
        </ul>
    </div>

    <div class="card mb-4" id="profile">
        <div class="card-header">
            <i class="bi bi-person-circle me-2"></i> <?= htmlspecialchars($lang['my_profile'] ?? 'Mon Profil') ?>
        </div>
        <div class="card-body">
            <p><strong><?= htmlspecialchars($lang['name'] ?? 'Nom Complet') ?>:</strong> <?= htmlspecialchars($student_name) ?></p>
            <p><strong><?= htmlspecialchars($lang['email'] ?? 'Email') ?>:</b> <?= htmlspecialchars($student_email) ?></p>
            <p><strong><?= htmlspecialchars($lang['id_number'] ?? 'Numéro Étudiant') ?>:</strong> <?= htmlspecialchars($student_numero_etudiant) ?></p>
            <p><strong><?= htmlspecialchars($lang['filiere'] ?? 'Filière') ?>:</strong> <?= htmlspecialchars($student_filiere) ?></p>
            <p><strong><?= htmlspecialchars($lang['cycle'] ?? 'Cycle') ?>:</strong> <?= htmlspecialchars($student_cycle) ?></p>
            <p><strong><?= htmlspecialchars($lang['apogee_code'] ?? 'Code Apogée') ?>:</strong> <?= htmlspecialchars($student_numero_apogee) ?></p>
            <p><strong><?= htmlspecialchars($lang['massar_code'] ?? 'Code Massar') ?>:</strong> <?= htmlspecialchars($student_code_massar) ?></p>

            <?php if ($student_photo_path && file_exists('../' . $student_photo_path)): ?>
                <p>
                    <strong><?= htmlspecialchars($lang['profile_picture'] ?? 'Photo de profil') ?>:</strong><br>
                    <img src="<?= htmlspecialchars('../' . $student_photo_path) ?>" alt="Photo de profil" class="img-fluid rounded" style="max-width: 150px; height: auto;">
                </p>
            <?php endif; ?>
            <a href="change_password.php" class="btn btn-outline-primary"><?= htmlspecialchars($lang['change_password_link'] ?? 'Changer mon mot de passe') ?></a>
            <button class="btn btn-outline-secondary mt-2"><?= htmlspecialchars($lang['edit_profile'] ?? 'Modifier le Profil') ?></button>
        </div>
    </div>

</main>

<footer>
    <div class="container">
        <small>&copy; <?= date('Y') ?> ENSAO - Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    // JavaScript pour le Mode Daltonien
    document.getElementById('daltonienModeToggle').addEventListener('click', function() {
        document.body.classList.toggle('daltonien-mode');
        const isDaltonien = document.body.classList.contains('daltonien-mode');
        localStorage.setItem('daltonienMode', isDaltonien); // Sauvegarder la préférence
    });

    // Vérifier la préférence du mode daltonien au chargement
    if (localStorage.getItem('daltonienMode') === 'true') {
        document.body.classList.add('daltonien-mode');
    }

    // Gestion des changements de langue pour rafraîchir la page
    document.querySelectorAll('.dropdown-item[href*="?lang="]').forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const url = new URL(window.location.href);
            url.searchParams.set('lang', this.getAttribute('href').split('lang=')[1]);
            window.location.href = url.toString();
        });
    });

    // JavaScript for PDF download using html2canvas and jsPDF
    document.getElementById('downloadPdfButton').addEventListener('click', function() {
        const input = document.getElementById('timetableToDownload'); // Element to capture

        if (!input) {
            console.error('Element #timetableToDownload not found. Cannot capture.');
            alert('Error: The timetable element to download was not found on the page.');
            return;
        }

        // Add a small delay to ensure all content is rendered
        setTimeout(() => {
            if (typeof html2canvas === 'undefined' || typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
                console.error('html2canvas or jspdf is not loaded correctly.');
                alert('Error: PDF generation libraries are not ready. Please try again.');
                return;
            }

            html2canvas(input, {
                scale: 2, // Increase resolution for better quality
                useCORS: true // Important if you have images or fonts from different origins
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf; // Correct way to access jsPDF
                const pdf = new jsPDF({
                    orientation: 'landscape', // Landscape for wide table
                    unit: 'mm', // Use millimeters for standard dimensions
                    format: 'a4'
                });

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();

                const imgWidth = canvas.width;
                const imgHeight = canvas.height;

                // Calculate aspect ratio to maintain proportions
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const finalImgWidth = imgWidth * ratio * 0.9; // Adjusted for a small margin
                const finalImgHeight = imgHeight * ratio * 0.9; // Adjusted for a small margin

                // Center the image on the page
                const posX = (pdfWidth - finalImgWidth) / 2;
                const posY = (pdfHeight - finalImgHeight) / 2;

                pdf.addImage(imgData, 'PNG', posX, posY, finalImgWidth, finalImgHeight);

                // Get the class name for the filename
                const classNameForFilename = "<?= htmlspecialchars($current_class_name) ?>";
                const fileName = `emploi_du_temps_${classNameForFilename || 'etudiant'}.pdf`;

                pdf.save(fileName);
                console.log('PDF saved: ' + fileName);

            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('An error occurred while downloading the PDF. Please check the console for more details.');
            });
        }, 300); // 300ms delay
    });
</script>
</body>
</html>