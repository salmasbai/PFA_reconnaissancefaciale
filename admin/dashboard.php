<?php
session_start();
require_once '../includes/config.php'; // Connexion PDO

// Define $lang_code BEFORE requiring the language file
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr'; 
require_once "../lang/{$lang_code}.php"; // Fichier de langue

// Assurez-vous que seul l'admin accède à ce dashboard
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../authentification/login.php'); // Assurez-vous que le chemin est correct
    exit;
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['admin_dashboard'] ?? 'Tableau de Bord Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
            --dark-blue: #2c3e50;
            --light-bg: #f9f4f1;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            color: #333;
            padding-top: 70px; /* For fixed navbar */
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
        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        h1 {
            font-size: 2.5rem; /* Larger for main title */
            margin-bottom: 1.5rem;
            color: #fff; /* White for header section */
            text-align: center;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08); /* Consistent shadow */
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
            border: none; /* Remove default card border */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }
        .card i {
            font-size: 3rem; /* Slightly larger icon */
            color: var(--accent);
            margin-bottom: 1rem;
        }
        .card h3 {
            margin-bottom: 0.5rem;
            color: var(--dark-blue);
            font-weight: 700;
        }
        .card a {
            display: inline-block;
            margin-top: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }
        .card a:hover {
            color: var(--accent);
            text-decoration: underline;
        }
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
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['welcome_admin'] ?? 'Bienvenue') ?>, Admin!</h1>
        <p class="lead"><?= htmlspecialchars($lang['admin_portal_desc'] ?? 'Gérez les utilisateurs, les cours et les données d\'absence.') ?></p>
    </div>
</section>

<main class="container">
    <div class="grid">
        <div class="card">
            <i class="fas fa-user-plus"></i>
            <h3><?= htmlspecialchars($lang['add_student'] ?? 'Ajouter Étudiant') ?></h3>
            <a href="ajouter_etudiant.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-chalkboard-teacher"></i>
            <h3><?= htmlspecialchars($lang['add_professor'] ?? 'Ajouter Professeur') ?></h3>
            <a href="ajouter_professeur.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-users"></i>
            <h3><?= htmlspecialchars($lang['manage_users'] ?? 'Gestion Utilisateurs') ?></h3>
            <a href="gestion_utilisateurs.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-layer-group"></i>
            <h3><?= htmlspecialchars($lang['manage_classes'] ?? 'Gestion des Classes') ?></h3>
            <a href="gestion_classes.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-sitemap"></i>
            <h3><?= htmlspecialchars($lang['manage_filieres'] ?? 'Gestion des Filières') ?></h3>
            <a href="gestion_filieres.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-book"></i>
            <h3><?= htmlspecialchars($lang['manage_matieres'] ?? 'Gestion des Matières') ?></h3>
            <a href="gestion_matieres.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-calendar-alt"></i>
            <h3><?= htmlspecialchars($lang['timetables'] ?? 'Emplois du Temps') ?></h3>
            <a href="emplois_du_temps.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-file-export"></i>
            <h3><?= htmlspecialchars($lang['export_data'] ?? 'Export Données') ?></h3>
            <a href="export_donnees.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
        </div>

        <div class="card">
            <i class="fas fa-cogs"></i>
            <h3><?= htmlspecialchars($lang['settings'] ?? 'Paramètres') ?></h3>
            <a href="parametres.php"><?= htmlspecialchars($lang['access'] ?? 'Accéder') ?></a>
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