<?php
session_start();
require_once '../includes/config.php'; // Connexion PDO

$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// Protection : S'assurer que l'utilisateur est bien un admin connecté avant d'afficher le lien
// Cette page est le " sas " après la connexion réussie.
// Nous nous assurons que les infos de session sont là et que le rôle est admin.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Si l'utilisateur n'est pas un admin connecté, le rediriger vers la page de login admin
    header("Location: admin_login.php?message_type=danger&message=" . urlencode($lang['access_denied'] ?? 'Accès refusé. Veuillez vous connecter en tant qu\'administrateur.'));
    exit();
}

// L'administrateur est connecté, nous pouvons lui montrer le lien.
$admin_full_name = $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];
$dashboard_url = '../admin/dashboard.php'; // Chemin vers le dashboard admin
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['admin_access_link_title'] ?? 'Lien d\'Accès Admin') ?></title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 550px;
            text-align: center;
        }
        .container img {
            height: 80px;
            margin-bottom: 25px;
        }
        .container h2 {
            color: var(--primary);
            margin-bottom: 20px;
            font-weight: 700;
        }
        .container p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            text-decoration: none;
            color: white; /* S'assurer que le texte du bouton est blanc */
        }
        .btn-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        .alert {
            margin-top: 20px;
        }
        /* Style pour l'accessibilité */
        body.daltonien-mode {
            filter: grayscale(100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../assets/images/logo_ensao.png" alt="Logo ENSAO">
        <h2><?= htmlspecialchars($lang['admin_welcome_heading'] ?? 'Bienvenue, Administrateur !') ?></h2>
        <p>
            <?= htmlspecialchars($lang['admin_click_link_text'] ?? 'Veuillez cliquer sur le bouton ci-dessous pour accéder à votre tableau de bord.') ?>
        </p>
        <a href="<?= htmlspecialchars($dashboard_url) ?>" class="btn btn-primary">
            <i class="bi bi-box-arrow-right me-2"></i> <?= htmlspecialchars($lang['go_to_dashboard'] ?? 'Accéder au Tableau de Bord') ?>
        </a>
        <div class="mt-4">
            <a href="logout.php" class="btn btn-link text-danger">
                <i class="bi bi-x-circle me-1"></i> <?= htmlspecialchars($lang['logout'] ?? 'Déconnexion') ?>
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mode Daltonien (à inclure si la page utilise ce style)
            document.getElementById('daltonienModeToggle')?.addEventListener('click', function() {
                document.body.classList.toggle('daltonien-mode');
                const isDaltonien = document.body.classList.contains('daltonien-mode');
                localStorage.setItem('daltonienMode', isDaltonien);
            });

            if (localStorage.getItem('daltonienMode') === 'true') {
                document.body.classList.add('daltonien-mode');
            }
        });
    </script>
</body>
</html>