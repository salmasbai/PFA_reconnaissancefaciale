<?php
require_once '../includes/config.php'; // Connexion PDO
/* session_start();

// Assurez-vous que seul l'admin accède à ce dashboard
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f7fc;
        }
        header {
            background-color: #2c3e50;
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
            margin-bottom: 1rem;
            color: #2c3e50;
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
            transition: transform 0.2s;
            text-align: center;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card i {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 1rem;
        }
        .card h3 {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        .card a {
            display: inline-block;
            margin-top: 0.5rem;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h2>PFA_PROJECT_TEST1 - Admin</h2>
        <a href="../authentification/logout.php" style="color: white; text-decoration: none;">Déconnexion</a>
    </header>

    <div class="container">
        <h1>Bienvenue, Admin</h1>
        <div class="grid">
            <div class="card">
                <i class="fas fa-user-plus"></i>
                <h3>Ajouter Étudiant</h3>
                <a href="ajouter_etudiant.php">Accéder</a>
            </div>

            <div class="card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Ajouter Professeur</h3>
                <a href="ajouter_professeur.php">Accéder</a>
            </div>

            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Gestion Utilisateurs</h3>
                <a href="gestion_utilisateurs.php">Accéder</a>
            </div>

            <div class="card">
                <i class="fas fa-layer-group"></i>
                <h3>Gestion des Classes</h3>
                <a href="classes.php">Accéder</a>
            </div>

            <!-- Nouvelle carte pour la Gestion des Filières -->
            <div class="card">
                <i class="fas fa-sitemap"></i> <!-- Icône pour les filières/structures -->
                <h3>Gestion des Filières</h3>
                <a href="gestion_filieres.php">Accéder</a>
            </div>

            <div class="card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Emplois du Temps</h3>
                <a href="emplois_du_temps.php">Accéder</a>
            </div>

            <div class="card">
                <i class="fas fa-file-export"></i>
                <h3>Export Données</h3>
                <a href="export_donnees.php">Accéder</a>
            </div>

            <div class="card">
                <i class="fas fa-cogs"></i>
                <h3>Paramètres</h3>
                <a href="parametres.php">Accéder</a>
            </div>
        </div>
    </div>
</body>
</html>
