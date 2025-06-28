<?php
session_start();
require_once '../includes/config.php'; // Connexion PDO

// Define $lang_code BEFORE requiring the language file
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr'; 
require_once "../lang/{$lang_code}.php"; // Fichier de langue
/*
// Assurez-vous que seul l'admin accède à ce dashboard
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../authentification/login.php'); // Assurez-vous que le chemin est correct
    exit;
}*/
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['admin_dashboard'] ?? 'Tableau de Bord Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
            --dark-blue: #2c3e50; /* from your original header style */
            --light-bg: #f9f4f1; /* from previous provided style */
        }
        body {
            font-family: 'Roboto', sans-serif; /* Changed to Roboto for consistency */
            margin: 0;
            padding: 0;
            background: var(--light-bg); /* Consistent background */
        }
        header {
            background-color: var(--primary); /* Using --primary for header for consistency */
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem; /* Increased margin for spacing */
            color: var(--dark-blue); /* Retained original dark blue for headings */
            text-align: center; /* Center align title */
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s; /* Added box-shadow transition */
            text-align: center;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15); /* Slightly stronger shadow on hover */
        }
        .card i {
            font-size: 2.5rem;
            color: var(--accent); /* Using --accent for icons for consistency */
            margin-bottom: 1rem;
        }
        .card h3 {
            margin-bottom: 0.5rem;
            color: var(--dark-blue);
            font-weight: 700; /* Made card titles bolder */
        }
        .card a {
            display: inline-block;
            margin-top: 0.5rem;
            color: var(--primary); /* Using --primary for links */
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }
        .card a:hover {
            color: var(--accent); /* Using --accent for link hover */
            text-decoration: underline;
        }
        /* Custom styles from previous code for consistency */
        .alert {
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }
    </style>
</head>
<body>
    <header>
        <h2>ENSAO - <?= htmlspecialchars($lang['admin_dashboard_title'] ?? 'Tableau de Bord Administrateur') ?></h2>
        <a href="../authentification/logout.php" style="color: white; text-decoration: none;"><?= htmlspecialchars($lang['logout'] ?? 'Déconnexion') ?></a>
    </header>

    <div class="container">
        <h1><?= htmlspecialchars($lang['welcome_admin'] ?? 'Bienvenue, Admin') ?></h1>
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
                <a href="gestion_classes.php">Accéder</a>
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
    </div>
</body>
</html>