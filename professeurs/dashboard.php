<?php
session_start(); // DOIT ÊTRE LA PREMIÈRE INSTRUCTION PHP

require_once '../includes/config.php'; // Connexion à la base de données

// Définir la langue AVANT d'inclure le fichier de langue
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Fichier de langue

// --- DÉBUT DU BLOC DE VÉRIFICATION D'AUTHENTIFICATION ET DE REDIRECTION ---
// Vérifier si l'utilisateur est connecté et est un professeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') {
    // Stocke l'URL de la page actuelle dans la session avant la redirection
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: ../authentification/login.php"); // Assurez-vous que le chemin est correct
    exit();
}
// --- FIN DU BLOC DE VÉRIFICATION D'AUTHENTIFICATION ET DE REDIRECTION ---

$prof_user_id = $_SESSION['user_id'];
// Récupérer le nom complet du professeur depuis la session
$prof_first_name = $_SESSION['user_first_name'] ?? '';
$prof_last_name = $_SESSION['user_last_name'] ?? '';
$prof_full_name = trim($prof_first_name . ' ' . $prof_last_name); // Concaténer et nettoyer

// Initialisation des messages
$success_message = '';
$error_message = '';

// --- Récupération des données pour le tableau de bord ---

// 1. Nombre total d'absences gérées par ce professeur (simple comptage)
// Jointures améliorées pour s'assurer que l'absence est liée à une matière et un créneau spécifique enseigné par ce professeur.
$total_absences_managed = 0;
try {
    $stmt_abs_count = $pdo->prepare("
        SELECT COUNT(DISTINCT a.id)
        FROM absences a
        JOIN matieres m ON a.matiere_id = m.id
        JOIN emploi_du_temps edt ON a.matiere_id = edt.matiere_id 
            AND a.heure_debut_creneau = TIME_FORMAT(edt.heure_debut, '%H:%i') 
            AND a.heure_fin_creneau = TIME_FORMAT(edt.heure_fin, '%H:%i')
        WHERE edt.professeur_id = ?
    ");
    $stmt_abs_count->execute([$prof_user_id]);
    $total_absences_managed = $stmt_abs_count->fetchColumn();
} catch (PDOException $e) {
    error_log("Dashboard - Total Absences Count Error: " . $e->getMessage());
    $error_message = ($lang['db_error_abs_count'] ?? 'Erreur lors du comptage des absences.');
}

// 2. Prochaines sessions de cours pour ce professeur
$next_sessions = [];
try {
    // Obtenez le jour de la semaine actuel et futur
    $today = date('N'); // 1 (for Monday) through 7 (for Sunday)
    $jours_map_db = [
        1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi',
        5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'
    ];
    $current_day_name_fr = $jours_map_db[$today];

    // Requête pour les cours d'aujourd'hui (déjà passés ou à venir)
    $stmt_today_sessions = $pdo->prepare("
        SELECT
            edt.heure_debut,
            edt.heure_fin,
            m.nom AS matiere_nom,
            c.nom_classe,
            'Aujourd\'hui' AS session_date_display
        FROM
            emploi_du_temps edt
        JOIN
            matieres m ON edt.matiere_id = m.id
        JOIN
            classes c ON edt.classe_id = c.id
        WHERE
            edt.professeur_id = ?
            AND edt.jour_semaine = ?
        ORDER BY
            edt.heure_debut ASC
    ");
    $stmt_today_sessions->execute([$prof_user_id, $current_day_name_fr]);
    $today_sessions = $stmt_today_sessions->fetchAll(PDO::FETCH_ASSOC);

    // Filtrer pour n'afficher que les sessions à venir ou en cours
    $current_time = date('H:i:s');
    foreach ($today_sessions as $session) {
        if ($session['heure_fin'] > $current_time) { // Comparer l'heure de fin pour inclure les cours en cours
            $next_sessions[] = $session;
        }
    }

    // Si pas de sessions à venir aujourd'hui, chercher la prochaine sur les jours suivants
    if (empty($next_sessions)) {
        // Rechercher dans les 7 prochains jours
        for ($i = 1; $i <= 7; $i++) {
            $future_date_raw = date('Y-m-d', strtotime("+$i day"));
            $future_day_num = date('N', strtotime($future_date_raw));
            $future_day_name_fr = $jours_map_db[$future_day_num];
            $future_date_display = date('d/m/Y', strtotime("+$i day")); // Format pour l'affichage

            $stmt_future_sessions = $pdo->prepare("
                SELECT
                    edt.heure_debut,
                    edt.heure_fin,
                    m.nom AS matiere_nom,
                    c.nom_classe,
                    ? AS session_date_display
                FROM
                    emploi_du_temps edt
                JOIN
                    matieres m ON edt.matiere_id = m.id
                JOIN
                    classes c ON edt.classe_id = c.id
                WHERE
                    edt.professeur_id = ?
                    AND edt.jour_semaine = ?
                ORDER BY
                    edt.heure_debut ASC
            ");
            $stmt_future_sessions->execute([$future_date_display, $prof_user_id, $future_day_name_fr]);
            $found_sessions = $stmt_future_sessions->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($found_sessions)) {
                $next_sessions = array_slice($found_sessions, 0, 3); // Limiter aux 3 premières sessions trouvées
                break; // Arrêter après avoir trouvé des sessions
            }
        }
    }

} catch (PDOException $e) {
    error_log("Dashboard - Next Sessions Error: " . $e->getMessage());
    $error_message = $lang['db_error_schedule'] ?? 'Erreur lors du chargement de l\'emploi du temps.';
}

// 3. Classes attribuées au professeur
$assigned_classes = [];
try {
    $stmt_assigned_classes = $pdo->prepare("
        SELECT DISTINCT c.id, c.nom_classe
        FROM classes c
        JOIN emploi_du_temps edt ON c.id = edt.classe_id
        WHERE edt.professeur_id = ?
        ORDER BY c.nom_classe
    ");
    $stmt_assigned_classes->execute([$prof_user_id]);
    $assigned_classes = $stmt_assigned_classes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Dashboard - Assigned Classes Error: " . $e->getMessage());
    $error_message = $lang['db_error_classes'] ?? 'Erreur lors du chargement de vos classes.';
}

// Date et heure actuelles pour l'affichage
$current_date_display = date("d/m/Y");
$current_time_display = date("H:i");

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['prof_dashboard_title'] ?? 'Tableau de Bord Professeur') ?></title>
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
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
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
        .text-info { color: #17a2b8 !important; }

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
                <li class="nav-item"><a class="nav-link active" href="dashboard.php"><?= htmlspecialchars($lang['home'] ?? 'Accueil') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_absences.php"><?= htmlspecialchars($lang['manage_absences'] ?? 'Gérer les Absences') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="voir_absences.php"><?= htmlspecialchars($lang['view_absences'] ?? 'Visualiser les Absences') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="valider_justificatif.php"><?= htmlspecialchars($lang['validate_justification'] ?? 'Valider les Justificatifs') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="rapports.php"><?= htmlspecialchars($lang['reports'] ?? 'Rapports') ?></a></li>
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
                <a href="../authentification/logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <?= htmlspecialchars($lang['logout'] ?? 'Déconnexion') ?></a>
            </div>
        </div>
    </div>
</nav>

<section class="dashboard-header text-center">
    <div class="container">
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['welcome_prof'] ?? 'Bienvenue') ?>, <?= htmlspecialchars($prof_full_name) ?>!</h1>
        <p class="lead"><?= htmlspecialchars($lang['prof_dashboard_intro'] ?? 'Votre tableau de bord enseignant') ?></p>
        <p class="mb-0"><?= htmlspecialchars($lang['current_time'] ?? 'Date et Heure Actuelles') ?>: <?= $current_date_display ?> <?= $current_time_display ?></p>
    </div>
</section>

<main class="container">
    <?php if ($error_message): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-line me-2"></i> <?= htmlspecialchars($lang['quick_stats'] ?? 'Statistiques Rapides') ?>
                </div>
                <div class="card-body">
                    <p><strong><?= htmlspecialchars($lang['absences_managed'] ?? 'Absences gérées (total)') ?>:</strong> <span class="badge bg-primary"><?= $total_absences_managed ?></span></p>
                    <p><strong><?= htmlspecialchars($lang['classes_assigned'] ?? 'Classes attribuées') ?>:</strong> <span class="badge bg-info"><?= count($assigned_classes) ?></span></p>
                    <p><strong><?= htmlspecialchars($lang['justifications_pending'] ?? 'Justificatifs en attente') ?>:</strong> <span class="badge bg-warning text-dark">0</span> <small>(<?= htmlspecialchars($lang['feature_to_implement'] ?? 'Fonctionnalité à implémenter') ?>)</small></p>
                    <hr>
                    <p class="small text-muted"><?= htmlspecialchars($lang['data_updated'] ?? 'Dernière mise à jour') ?>: <?= $current_date_display ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-hourglass-split me-2"></i> <?= htmlspecialchars($lang['upcoming_sessions'] ?? 'Prochaines Sessions') ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($next_sessions)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($next_sessions as $session): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($session['matiere_nom']) ?></strong> (<?= htmlspecialchars($session['nom_classe']) ?>)
                                        <br><small class="text-muted">
                                            <?= htmlspecialchars($session['session_date_display'] ?? $current_date_display) ?>
                                            de <?= htmlspecialchars(substr($session['heure_debut'], 0, 5)) ?> à <?= htmlspecialchars(substr($session['heure_fin'], 0, 5)) ?>
                                        </small>
                                    </div>
                                    <span class="badge bg-success">
                                        <?= htmlspecialchars($lang['course'] ?? 'Cours') ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted"><?= htmlspecialchars($lang['no_upcoming_sessions'] ?? 'Aucune session de cours à venir dans votre emploi du temps pour les prochains jours.') ?></p>
                    <?php endif; ?>
                    <div class="text-center mt-3">
                        <a href="view_schedule.php" class="btn btn-outline-primary"><i class="bi bi-calendar-week me-2"></i> <?= htmlspecialchars($lang['view_full_schedule'] ?? 'Voir l\'emploi du temps complet') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-section" id="assigned_classes">
        <h3 class="mb-3"><i class="bi bi-journals me-2"></i> <?= htmlspecialchars($lang['your_assigned_classes'] ?? 'Vos Classes Attribuées') ?></h3>
        <?php if (!empty($assigned_classes)): ?>
            <div class="list-group">
                <?php foreach ($assigned_classes as $class): ?>
                    <a href="gestion_absences.php?class_id=<?= htmlspecialchars($class['id']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($class['nom_classe']) ?>
                        <i class="bi bi-arrow-right-circle"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted"><?= htmlspecialchars($lang['no_classes_assigned'] ?? 'Vous n\'avez pas encore de classes attribuées dans l\'emploi du temps.') ?></p>
        <?php endif; ?>
    </div>

    <div class="content-section" id="quick_actions">
        <h3 class="mb-3"><i class="bi bi-lightning me-2"></i> <?= htmlspecialchars($lang['quick_actions'] ?? 'Actions Rapides') ?></h3>
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <div class="col">
                <a href="gestion_absences.php" class="btn btn-primary w-100 py-3">
                    <i class="bi bi-pencil-square me-2"></i> <?= htmlspecialchars($lang['manage_absences_short'] ?? 'Gérer les Absences') ?>
                </a>
            </div>
            <div class="col">
                <a href="valider_justificatif.php" class="btn btn-primary w-100 py-3">
                    <i class="bi bi-file-earmark-check me-2"></i> <?= htmlspecialchars($lang['validate_justifications_short'] ?? 'Valider Justificatifs') ?>
                </a>
            </div>
            <div class="col">
                <a href="voir_absences.php" class="btn btn-primary w-100 py-3">
                    <i class="bi bi-search me-2"></i> <?= htmlspecialchars($lang['view_absences_short'] ?? 'Consulter Absences') ?>
                </a>
            </div>
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