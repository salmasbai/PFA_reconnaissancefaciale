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
$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['user_name'] ?? 'Utilisateur Inconnu';
$student_email = $_SESSION['user_email'] ?? 'N/A';

// Informations spécifiques à l'étudiant, si elles existent en session
$student_numero_etudiant = $_SESSION['student_numero_etudiant'] ?? 'N/A';
$student_filiere = $_SESSION['student_filiere'] ?? 'N/A';
$student_cycle = $_SESSION['student_cycle'] ?? 'N/A';
$student_photo_path = $_SESSION['student_photo_path'] ?? null; // Chemin de la photo pour l'inscription faciale initiale
$student_numero_apogee = $_SESSION['student_numero_apogee'] ?? 'N/A';
$student_code_massar = $_SESSION['student_code_massar'] ?? 'N/A';

// La "classe" pour l'affichage, combinant filière et cycle
$student_class = $student_filiere . ' - ' . $student_cycle;

// Date et heure actuelles pour l'affichage
$current_date = date("d/m/Y");
$current_time = date("H:i");

// --------------------------------------------------------------------------------------
// Récupération des absences récentes de l'étudiant depuis la base de données
// --------------------------------------------------------------------------------------
$recent_absences = [];
try {
    // D'abord, récupérer l'ID de l'étudiant dans la table 'etudiants' à partir de son 'user_id'
    $stmt_get_student_entity_id = $pdo->prepare("SELECT id FROM etudiants WHERE user_id = ?");
    $stmt_get_student_entity_id->execute([$student_id]);
    $etudiant_entity_id = $stmt_get_student_entity_id->fetchColumn(); // Récupère seulement la valeur de la première colonne

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
    error_log("Error fetching student absences for user ID " . $student_id . ": " . $e->getMessage());
    // $error_message_db = $lang['db_fetch_error'] ?? 'Impossible de récupérer les données des absences.';
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
        <div class="text-center">
            <img src="https://via.placeholder.com/600x300?text=Emploi+du+Temps" class="img-fluid rounded mb-3" alt="Emploi du Temps Placeholder">
            <a href="#" class="btn btn-outline-primary"><i class="bi bi-download me-2"></i> <?= htmlspecialchars($lang['download_schedule'] ?? 'Télécharger l\'emploi du temps') ?></a>
        </div>
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
            <p><strong><?= htmlspecialchars($lang['email'] ?? 'Email') ?>:</strong> <?= htmlspecialchars($student_email) ?></p>
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
</script>
</body>
</html>