<?php
session_start();
// Définir le fuseau horaire par défaut pour toutes les fonctions de date et heure AU DÉBUT DU SCRIPT
date_default_timezone_set('Africa/Casablanca'); // Oujda est dans ce fuseau horaire

error_reporting(E_ALL); // Affiche toutes les erreurs
ini_set('display_errors', 1); // Affiche les erreurs dans le navigateur

// Vérifier si l'utilisateur est connecté et a bien le rôle 'etudiant'
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'etudiant')) {
    header("Location: ../authentification/login.php"); // Chemin corrigé pour la page de connexion
    exit();
}

// Inclure le fichier de configuration de la base de données
require_once '../includes/config.php';

// Récupérer le code de langue de la session ou utiliser le français par défaut
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/" . $lang_code . ".php"; // Utilisation de la concaténation pour compatibilité PHP 5

$message_justification = '';
$message_justification_type = ''; // 'success' or 'danger'

// --------------------------------------------------------------------------------------
// Logique de traitement du formulaire de justification d'absence
// --------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_justification'])) {
    $absence_date_justify = isset($_POST['absence_date_justify']) ? $_POST['absence_date_justify'] : '';
    $justification_file = isset($_FILES['justification_file']) ? $_FILES['justification_file'] : null;

    if (empty($absence_date_justify) || !$justification_file || $justification_file['error'] !== UPLOAD_ERR_OK) {
        $message_justification = isset($lang['missing_justification_data']) ? $lang['missing_justification_data'] : 'Date d\'absence ou fichier de justificatif manquant.';
        $message_justification_type = 'danger';
    } else {
        // Définir le dossier de téléchargement (relatif à la racine du projet)
        $upload_dir_relative_to_root = 'uploads/justifications/';
        $upload_dir_full_path = '../' . $upload_dir_relative_to_root; // Chemin réel sur le serveur

        // Créer le répertoire si il n'existe pas
        if (!is_dir($upload_dir_full_path)) {
            if (!mkdir($upload_dir_full_path, 0777, true)) { // 0777 pour les permissions en dev, à ajuster en prod
                $message_justification = 'Erreur: Impossible de créer le dossier de téléchargement. Vérifiez les permissions du dossier "uploads".';
                $message_justification_type = 'danger';
            }
        }

        if ($message_justification_type !== 'danger') { // Continuer seulement si le dossier a été créé/existe
            $allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
            $max_file_size = 5 * 1024 * 1024; // 5 MB

            if (!in_array($justification_file['type'], $allowed_types)) {
                $message_justification = isset($lang['justification_invalid_file_type']) ? $lang['justification_invalid_file_type'] : 'Type de fichier non autorisé. Seuls les PDF, JPG, PNG sont acceptés.';
                $message_justification_type = 'danger';
            } elseif ($justification_file['size'] > $max_file_size) {
                $message_justification = sprintf(
                    isset($lang['justification_file_too_large']) ? $lang['justification_file_too_large'] : 'Fichier trop volumineux. La taille maximale est de %s Mo.',
                    $max_file_size / (1024 * 1024)
                );
                $message_justification_type = 'danger';
            } else {
                $file_extension = pathinfo($justification_file['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('justif_', true) . '.' . $file_extension;
                $destination_full_path = $upload_dir_full_path . $new_file_name;
                $file_path_for_db = $upload_dir_relative_to_root . $new_file_name; // Chemin à stocker en DB

                if (move_uploaded_file($justification_file['tmp_name'], $destination_full_path)) {
                    try {
                        // Récupérer l'ID de l'étudiant dans la table 'etudiants' à partir de son 'user_id' de session
                        $stmt_get_etudiant_id_for_justif_process = $pdo->prepare("SELECT id FROM etudiants WHERE user_id = ?");
                        $stmt_get_etudiant_id_for_justif_process->execute([$_SESSION['user_id']]);
                        $etudiant_db_id_for_justif_process = $stmt_get_etudiant_id_for_justif_process->fetchColumn();

                        if ($etudiant_db_id_for_justif_process) {
                            // Insérer la demande de justificatif dans la table `justifications_demandes`
                            $stmt_insert_justification = $pdo->prepare("
                                INSERT INTO justifications_demandes (etudiant_id, absence_date, file_path, status)
                                VALUES (?, ?, ?, 'pending')
                            ");
                            $stmt_insert_justification->execute([$etudiant_db_id_for_justif_process, $absence_date_justify, $file_path_for_db]);

                            $message_justification = isset($lang['justification_submit_success']) ? $lang['justification_submit_success'] : 'Votre justificatif a été soumis avec succès et est en attente de validation.';
                            $message_justification_type = 'success';
                        } else {
                            $message_justification = 'Erreur: ID étudiant non trouvé pour l\'utilisateur connecté.';
                            $message_justification_type = 'danger';
                            unlink($destination_full_path); // Supprimer le fichier uploadé si l'insertion DB échoue
                        }

                    } catch (PDOException $e) {
                        $message_justification = isset($lang['justification_submit_error']) ? $lang['justification_submit_error'] : 'Erreur lors de l\'enregistrement du justificatif dans la base de données.';
                        $message_justification_type = 'danger';
                        error_log("Justification DB Error: " . $e->getMessage());
                        unlink($destination_full_path); // Supprimer le fichier uploadé si l'insertion DB échoue
                    }
                } else {
                    $message_justification = isset($lang['justification_upload_error']) ? $lang['justification_upload_error'] : 'Erreur lors du téléchargement du fichier. Veuillez réessayer.';
                    $message_justification_type = 'danger';
                }
            }
        }
    }
}
// Fin de la logique de traitement du formulaire de justification d'absence


// --------------------------------------------------------------------------------------
// Données de l'étudiant récupérées depuis la base de données et session
// --------------------------------------------------------------------------------------
$student_user_id = $_SESSION['user_id'];
$student_name = $_SESSION['user_name'] ?? 'Utilisateur Inconnu'; // Assuming 'user_name' holds full name

// If 'user_name' is not reliable, fetch full name from DB
// Otherwise, remove this block if $_SESSION['user_name'] is always set to full name
if ($student_name === 'Utilisateur Inconnu' && isset($_SESSION['user_first_name']) && isset($_SESSION['user_last_name'])) {
    $student_name = trim($_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']);
}

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
$current_class_name = 'N/A'; // For PDF filename and display

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
$student_class_display = ($student_filiere != 'N/A' ? $student_filiere : '') . ($student_cycle != 'N/A' ? ' - ' . $student_cycle : '');
if ($student_class_display === '') {
    $student_class_display = 'N/A';
}

$current_date = date("d/m/Y");
$current_time = date("H:i");

// --------------------------------------------------------------------------------------
// Récupération des absences récentes et totaux de l'étudiant depuis la base de données
// --------------------------------------------------------------------------------------
$recent_absences = [];
$total_absences = 0;
$justified_absences_count = 0;
$unjustified_absences_count = 0;

try {
    if ($etudiant_entity_id) {
        // Calculer les totaux d'absences
        $stmt_total_abs = $pdo->prepare("SELECT COUNT(*) AS total FROM absences WHERE etudiant_id = ?");
        $stmt_total_abs->execute([$etudiant_entity_id]);
        $total_absences = $stmt_total_abs->fetchColumn();

        $stmt_justified_abs = $pdo->prepare("SELECT COUNT(*) AS total FROM absences WHERE etudiant_id = ? AND justifiee = 1");
        $stmt_justified_abs->execute([$etudiant_entity_id]);
        $justified_absences_count = $stmt_justified_abs->fetchColumn();

        $stmt_unjustified_abs = $pdo->prepare("SELECT COUNT(*) AS total FROM absences WHERE etudiant_id = ? AND justifiee = 0");
        $stmt_unjustified_abs->execute([$etudiant_entity_id]);
        $unjustified_absences_count = $stmt_unjustified_abs->fetchColumn();

        // Récupérer ses absences récentes
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
    error_log("Error fetching student absences: " . $e->getMessage());
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
// Récupération des justificatifs soumis pour affichage
// --------------------------------------------------------------------------------------
$submitted_justifications = [];
try {
    $stmt_get_etudiant_id_for_justif_display = $pdo->prepare("SELECT id FROM etudiants WHERE user_id = ?");
    $stmt_get_etudiant_id_for_justif_display->execute([$_SESSION['user_id']]);
    $etudiant_db_id_for_justif_display = $stmt_get_etudiant_id_for_justif_display->fetchColumn();

    if ($etudiant_db_id_for_justif_display) {
        $stmt_submitted_justifs = $pdo->prepare("
            SELECT id, absence_date, file_path, status, submitted_at
            FROM justifications_demandes
            WHERE etudiant_id = ?
            ORDER BY submitted_at DESC
        ");
        $stmt_submitted_justifs->execute([$etudiant_db_id_for_justif_display]);
        $submitted_justifications = $stmt_submitted_justifs->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log("Error fetching submitted justifications for display: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars(isset($lang['student_dashboard_title']) ? $lang['student_dashboard_title'] : 'Tableau de Bord Étudiant') ?></title>
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
        .navbar-brand img { height: 48px; margin-right: .5rem; }
        .navbar-nav .nav-link { color: #000; font-weight: 500; }
        .navbar-nav .nav-link.active { color: var(--primary) !important; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--accent); border-color: var(--accent); }
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; padding: 3rem 0; margin-bottom: 2rem; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;
        }
        .card { border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); margin-bottom: 1.5rem; }
        .card-header {
            background-color: var(--primary); color: #fff; border-top-left-radius: 10px; border-top-right-radius: 10px; font-weight: bold;
        }
        .content-section {
            background-color: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); margin-bottom: 1.5rem;
        }
        .text-success { color: #28a745 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-info { color: #17a2b8 !important; }

        footer { background: var(--primary); color: #fff; padding: 1.5rem 0; text-align: center; margin-top: 3rem; }

        body.daltonien-mode { filter: grayscale(100%); }

        /* Styles pour les messages de justification */
        .alert-justif-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-justif-danger {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
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

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#"><?= htmlspecialchars(isset($lang['dashboard']) ? $lang['dashboard'] : 'Tableau de Bord') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#records"><?= htmlspecialchars(isset($lang['absence_records']) ? $lang['absence_records'] : 'Historique des Absences') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#schedule"><?= htmlspecialchars(isset($lang['schedule']) ? $lang['schedule'] : 'Emploi du Temps') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#justifications"><?= htmlspecialchars(isset($lang['justifications']) ? $lang['justifications'] : 'Justificatifs') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="#profile"><?= htmlspecialchars(isset($lang['profile']) ? $lang['profile'] : 'Mon Profil') ?></a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a class="dropdown-toggle text-dark text-decoration-none" href="#" id="langDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><?= strtoupper($lang_code) ?></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        <li><a class="dropdown-item" href="?lang=fr">FR – Français</a></li>
                        <li><a class="dropdown-item" href="?lang=en">EN – English</a></li>
                        <li><a class="dropdown-item" href="?lang=ar">AR – العربية</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary" id="daltonienModeToggle">
                    <i class="bi bi-eye-slash"></i> <?= htmlspecialchars(isset($lang['daltonian_mode']) ? $lang['daltonian_mode'] : 'Mode Daltonien') ?>
                </button>
                <a href="../authentification/logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <?= htmlspecialchars(isset($lang['logout']) ? $lang['logout'] : 'Déconnexion') ?></a>
            </div>
        </div>
    </div>
</nav>

<section class="dashboard-header text-center">
    <div class="container">
        <h1 class="display-4 mb-2"><?= htmlspecialchars(isset($lang['welcome_student']) ? $lang['welcome_student'] : 'Bienvenue') ?>, <?= htmlspecialchars($student_name) ?>!</h1>
        <p class="lead"><?= htmlspecialchars(isset($lang['current_class']) ? $lang['current_class'] : 'Votre Classe') ?>: <?= htmlspecialchars($student_class_display) ?></p>
        <p class="mb-0"><?= htmlspecialchars(isset($lang['current_time']) ? $lang['current_time'] : 'Date et Heure Actuelles') ?>: <?= $current_date ?> <?= $current_time ?></p>
    </div>
</section>

<main class="container">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-graph-up me-2"></i> <?= htmlspecialchars(isset($lang['quick_overview']) ? $lang['quick_overview'] : 'Vue d\'ensemble rapide') ?>
                </div>
                <div class="card-body">
                    <p><strong><?= htmlspecialchars(isset($lang['total_absences']) ? $lang['total_absences'] : 'Total Absences') ?>:</strong> <span class="badge bg-warning text-dark"><?= htmlspecialchars($total_absences) ?></span></p>
                    <p><strong><?= htmlspecialchars(isset($lang['justified_absences']) ? $lang['justified_absences'] : 'Absences Justifiées') ?>:</strong> <span class="badge bg-success"><?= htmlspecialchars($justified_absences_count) ?></span></p>
                    <p><strong><?= htmlspecialchars(isset($lang['unjustified_absences']) ? $lang['unjustified_absences'] : 'Absences Non Justifiées') ?>:</strong> <span class="badge bg-danger"><?= htmlspecialchars($unjustified_absences_count) ?></span></p>
                    <hr>
                    <p class="small text-muted"><?= htmlspecialchars(isset($lang['data_updated']) ? $lang['data_updated'] : 'Dernière mise à jour') ?>: <?= $current_date ?></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-bell me-2"></i> <?= htmlspecialchars(isset($lang['notifications']) ? $lang['notifications'] : 'Notifications') ?>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> <?= htmlspecialchars(isset($lang['notification_success']) ? $lang['notification_success'] : 'Votre présence pour "Algorithmique" a été enregistrée.') ?></li>
                        <li class="list-group-item d-flex align-items-center"><i class="bi bi-info-circle-fill text-info me-2"></i> <?= htmlspecialchars(isset($lang['notification_reminder']) ? $lang['notification_reminder'] : 'Rappel: Cours de Réseaux à 14h.') ?></li>
                        <li class="list-group-item d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> <?= htmlspecialchars(isset($lang['notification_unjustified']) ? $lang['notification_unjustified'] : 'Absence non justifiée pour le cours de "Base de Données".') ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="content-section">
                <h3 class="mb-3"><i class="bi bi-person-check me-2"></i> <?= htmlspecialchars(isset($lang['attendance_registration_title']) ? $lang['attendance_registration_title'] : 'Enregistrement des Présences') ?></h3>
                <p class="text-muted"><?= htmlspecialchars(isset($lang['attendance_registration_info1']) ? $lang['attendance_registration_info1'] : 'L\'enregistrement de votre présence aux séances se fait exclusivement via les bornes de reconnaissance faciale installées à l\'entrée des salles de cours ou de l\'établissement.') ?></p>
                <p class="text-muted"><?= htmlspecialchars(isset($lang['attendance_registration_info2']) ? $lang['attendance_registration_info2'] : 'Assurez-vous de vous présenter devant la borne au début de chaque cours pour valider automatiquement votre présence.') ?></p>
                <div class="text-center mt-4">
                    <i class="bi bi-camera-reels-fill text-primary" style="font-size: 4rem;"></i>
                    <p class="mt-2 text-muted"><?= htmlspecialchars(isset($lang['on_site_scanner']) ? $lang['on_site_scanner'] : 'Scanner sur place') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4" id="records">
        <div class="card-header">
            <i class="bi bi-calendar-check me-2"></i> <?= htmlspecialchars(isset($lang['absence_history']) ? $lang['absence_history'] : 'Historique des Absences') ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars(isset($lang['date']) ? $lang['date'] : 'Date') ?></th>
                            <th><?= htmlspecialchars(isset($lang['course']) ? $lang['course'] : 'Cours') ?></th>
                            <th><?= htmlspecialchars(isset($lang['status']) ? $lang['status'] : 'Statut') ?></th>
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
                                                echo '<span class="badge bg-info">' . htmlspecialchars(isset($lang['justified']) ? $lang['justified'] : 'Justifiée') . '</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">' . htmlspecialchars(isset($lang['unjustified']) ? $lang['unjustified'] : 'Non Justifiée') . '</span>';
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center"><?= htmlspecialchars(isset($lang['no_absence_records']) ? $lang['no_absence_records'] : 'Aucun historique d\'absences disponible.') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="#" class="btn btn-outline-primary"><?= htmlspecialchars(isset($lang['view_all_records']) ? $lang['view_all_records'] : 'Voir tout l\'historique') ?></a>
            </div>
        </div>
    </div>

    <div class="content-section" id="schedule">
        <h3 class="mb-3"><i class="bi bi-calendar-week me-2"></i> <?= htmlspecialchars(isset($lang['schedule']) ? $lang['schedule'] : 'Mon Emploi du Temps') ?></h3>
        <p class="text-muted"><?= htmlspecialchars(isset($lang['schedule_desc']) ? $lang['schedule_desc'] : 'Consultez votre emploi du temps hebdomadaire.') ?></p>
        <?php if ($student_classe_id && !empty($student_timetable_data)): ?>
            <div class="table-responsive" id="timetableToDownload">
                <table class="timetable-table">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars(isset($lang['day_slot']) ? $lang['day_slot'] : 'Jour / Créneau') ?></th>
                            <?php foreach ($time_slots as $slot_index => $slot): ?>
                                <th>
                                    <?= htmlspecialchars(isset($lang['slot']) ? $lang['slot'] : 'Créneau') ?> <?= $slot_index + 1 ?><br>
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
                    <i class="bi bi-download me-2"></i> <?= htmlspecialchars(isset($lang['download_schedule']) ? $lang['download_schedule'] : 'Télécharger l\'emploi du temps') ?> (PDF)
                </button>
            </div>
        <?php elseif ($student_classe_id && empty($student_timetable_data)): ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars(isset($lang['no_schedule_for_your_class']) ? $lang['no_schedule_for_your_class'] : 'Aucun emploi du temps n\'est défini pour votre classe pour le moment.') ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars(isset($lang['no_class_assigned']) ? $lang['no_class_assigned'] : 'Votre classe n\'est pas encore attribuée, impossible d\'afficher l\'emploi du temps.') ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="content-section" id="justifications">
        <h3 class="mb-3"><i class="bi bi-file-earmark-arrow-up me-2"></i> <?= htmlspecialchars(isset($lang['justifications']) ? $lang['justifications'] : 'Justificatifs d\'Absence') ?></h3>
        <p class="text-muted"><?= htmlspecialchars(isset($lang['justifications_desc']) ? $lang['justifications_desc'] : 'Téléchargez un justificatif pour vos absences non justifiées.') ?></p>
        <?php if (!empty($message_justification)): ?>
           <div class="alert alert-<?= htmlspecialchars($message_justification_type) ?> alert-justif-<?= htmlspecialchars($message_justification_type) ?>" role="alert">
               <?= htmlspecialchars($message_justification) ?>
           </div>
        <?php endif; ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="absence_date_justify" class="form-label"><?= htmlspecialchars(isset($lang['absence_date']) ? $lang['absence_date'] : 'Date de l\'absence') ?>:</label>
                <input type="date" class="form-control" id="absence_date_justify" name="absence_date_justify" required>
            </div>
            <div class="mb-3">
                <label for="justification_file" class="form-label"><?= htmlspecialchars(isset($lang['upload_justification']) ? $lang['upload_justification'] : 'Télécharger le justificatif') ?> (PDF, JPG, PNG) :</label>
                <input type="file" class="form-control" id="justification_file" name="justification_file" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            <button type="submit" name="submit_justification" class="btn btn-primary"><i class="bi bi-upload me-2"></i> <?= htmlspecialchars(isset($lang['submit_justification']) ? $lang['submit_justification'] : 'Soumettre le justificatif') ?></button>
        </form>
        <h4 class="mt-4"><?= htmlspecialchars(isset($lang['submitted_justifications']) ? $lang['submitted_justifications'] : 'Justificatifs Soumis') ?></h4>
        <ul class="list-group">
            <?php if (!empty($submitted_justifications)): ?>
                <?php foreach ($submitted_justifications as $justif): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Absence du <?= htmlspecialchars($justif['absence_date']) ?> - 
                        <a href="<?= htmlspecialchars('../' . $justif['file_path']) ?>" target="_blank" class="text-decoration-none">
                            <?= htmlspecialchars(basename($justif['file_path'])) ?>
                        </a>
                        <?php
                        $badge_class = 'bg-secondary';
                        $badge_text = htmlspecialchars(isset($lang['pending']) ? $lang['pending'] : 'En attente');
                        if ($justif['status'] === 'approved') {
                            $badge_class = 'bg-success';
                            $badge_text = htmlspecialchars(isset($lang['justification_approved']) ? $lang['justification_approved'] : 'Approuvé');
                        } elseif ($justif['status'] === 'rejected') {
                            $badge_class = 'bg-danger';
                            $badge_text = htmlspecialchars(isset($lang['justification_rejected']) ? $lang['justification_rejected'] : 'Rejeté');
                        }
                        ?>
                        <span class="badge <?= $badge_class ?>"><?= $badge_text ?></span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted mt-2"><?= htmlspecialchars(isset($lang['no_justifications_submitted']) ? $lang['no_justifications_submitted'] : 'Aucun justificatif soumis pour le moment.') ?></p>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card mb-4" id="profile">
        <div class="card-header">
            <i class="bi bi-person-circle me-2"></i> <?= htmlspecialchars(isset($lang['my_profile']) ? $lang['my_profile'] : 'Mon Profil') ?>
        </div>
        <div class="card-body">
            <p><strong><?= htmlspecialchars(isset($lang['name']) ? $lang['name'] : 'Nom Complet') ?>:</strong> <?= htmlspecialchars($student_name) ?></p>
            <p><strong><?= htmlspecialchars(isset($lang['email']) ? $lang['email'] : 'Email') ?>:</b> <?= htmlspecialchars($student_email) ?></p>
            <p><strong><?= htmlspecialchars(isset($lang['id_number']) ? $lang['id_number'] : 'Numéro Étudiant') ?>:</strong> <?= htmlspecialchars($student_numero_etudiant) ?></p>
            <p><strong><?= htmlspecialchars(isset($lang['filiere']) ? $lang['filiere'] : 'Filière') ?>:</strong> <?= htmlspecialchars($student_filiere) ?></p>
            <p><strong><?= htmlspecialchars(isset($lang['cycle']) ? $lang['cycle'] : 'Cycle') ?>:</strong> <?= htmlspecialchars($student_cycle) ?></p>
            <p><strong><?= htmlspecialchars(isset($lang['apogee_code']) ? $lang['apogee_code'] : 'Code Apogée') ?>:</strong> <?= htmlspecialchars($student_numero_apogee) ?></p>
            <p><strong><?= htmlspecialchars(isset($lang['massar_code']) ? $lang['massar_code'] : 'Code Massar') ?>:</strong> <?= htmlspecialchars($student_code_massar) ?></p>

            <?php if (isset($student_photo_path) && $student_photo_path && file_exists('../' . $student_photo_path)): ?>
                <p>
                    <strong><?= htmlspecialchars(isset($lang['profile_picture']) ? $lang['profile_picture'] : 'Photo de profil') ?>:</strong><br>
                    <img src="<?= htmlspecialchars('../' . $student_photo_path) ?>" alt="Photo de profil" class="img-fluid rounded" style="max-width: 150px; height: auto;">
                </p>
            <?php endif; ?>
            <a href="../authentification/change_password.php" class="btn btn-outline-primary"><?= htmlspecialchars(isset($lang['change_password_link']) ? $lang['change_password_link'] : 'Changer mon mot de passe') ?></a>
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