<?php
// For displaying errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Ensure session is started at the very beginning

// Inclusion of necessary files
require_once '../includes/config.php';

// Define $lang_code BEFORE requiring the language file
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Language file

// Ensure only admin can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}

$message = "";
$message_type = ""; // 'success' or 'danger'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["password"], $_POST["role"])
        && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["role"])
    ) {
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $role = trim($_POST["role"]);

        try {
            // Check if user already exists
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
            $checkStmt->execute([$email]);

            if ($checkStmt->fetchColumn() > 0) {
                $message = htmlspecialchars($lang['email_already_used'] ?? 'Cet email est déjà utilisé.');
                $message_type = "danger";
            } else {
                $isValid = false;
                $entityId = null;

                // Verification based on role
                if ($role === 'etudiant') {
                    $stmt = $pdo->prepare("SELECT id FROM etudiants WHERE nom = ? AND prenom = ?");
                    $stmt->execute([$nom, $prenom]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result) {
                        $isValid = true;
                        $entityId = $result['id'];
                    }
                } elseif ($role === 'professeur') {
                    $stmt = $pdo->prepare("SELECT id FROM professeurs WHERE nom = ? AND prenom = ? AND email = ?");
                    $stmt->execute([$nom, $prenom, $email]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result) {
                        $isValid = true;
                        $entityId = $result['id'];
                    }
                } elseif ($role === 'admin') {
                    $isValid = true; // Admins don't necessarily need a linked entity
                }

                if ($isValid) {
                    // Insertion into the 'utilisateurs' table
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$nom, $prenom, $email, $password, $role]);
                    $userId = $pdo->lastInsertId();

                    // Update user_id in the linked entity
                    if ($role === 'etudiant') {
                        $updateStmt = $pdo->prepare("UPDATE etudiants SET user_id = ? WHERE id = ?");
                        $updateStmt->execute([$userId, $entityId]);
                    } elseif ($role === 'professeur') {
                        $updateStmt = $pdo->prepare("UPDATE professeurs SET user_id = ? WHERE id = ?");
                        $updateStmt->execute([$userId, $entityId]);
                    }

                    $message = htmlspecialchars($lang['user_added_success'] ?? 'Utilisateur ajouté avec succès et lié à son profil.') . " " . htmlspecialchars($role) . ".";
                    $message_type = "success";
                    // Clear form fields after successful submission
                    $_POST['nom'] = $_POST['prenom'] = $_POST['email'] = $_POST['password'] = '';
                } else {
                    $message = htmlspecialchars($lang['user_not_recognized'] ?? 'Erreur : cet utilisateur n\'est pas reconnu comme') . " " . htmlspecialchars($role) . ".";
                    $message_type = "danger";
                }
            }
        } catch (PDOException $e) {
            $message = htmlspecialchars($lang['error_adding_user'] ?? 'Erreur lors de l\'ajout :') . " " . $e->getMessage();
            $message_type = "danger";
        }
    } else {
        $message = htmlspecialchars($lang['fill_all_fields'] ?? 'Veuillez remplir tous les champs.');
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['add_user_title'] ?? 'Ajouter un utilisateur') ?></title>
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
        .main-content {
            max-width: 800px; /* Adjusted for forms */
            margin: 2rem auto;
            padding: 0 15px;
        }
        .content-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        h1, h2, h3 {
            color: var(--dark-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-label {
            font-weight: 500;
            color: var(--primary);
        }
        footer {
            background: var(--primary);
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        /* Accessibility: Daltonian Mode */
        body.daltonien-mode {
            filter: grayscale(100%);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../admin/admin_dashboard.php">
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
                <li class="nav-item"><a class="nav-link" href="../admin/admin_dashboard.php"><?= htmlspecialchars($lang['dashboard'] ?? 'Tableau de Bord') ?></a></li>
                <li class="nav-item"><a class="nav-link active" href="ajouter_utilisateur.php"><?= htmlspecialchars($lang['add_user'] ?? 'Ajouter Utilisateur') ?></a></li>
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
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['add_new_user'] ?? 'Ajouter un Nouvel Utilisateur') ?></h1>
        <p class="lead"><?= htmlspecialchars($lang['add_user_desc'] ?? 'Créez de nouveaux comptes pour les étudiants, professeurs ou administrateurs.') ?></p>
    </div>
</section>

<main class="container main-content">
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="content-section">
        <form method="post" action="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label"><?= htmlspecialchars($lang['last_name'] ?? 'Nom') ?> :</label>
                    <input type="text" name="nom" id="nom" class="form-control" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label"><?= htmlspecialchars($lang['first_name'] ?? 'Prénom') ?> :</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label"><?= htmlspecialchars($lang['email'] ?? 'Email') ?> :</label>
                    <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label"><?= htmlspecialchars($lang['password'] ?? 'Mot de passe') ?> :</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="col-12 mb-4">
                    <label for="role" class="form-label"><?= htmlspecialchars($lang['role'] ?? 'Rôle') ?> :</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">-- <?= htmlspecialchars($lang['select_role'] ?? 'Sélectionner un rôle') ?> --</option>
                        <option value="etudiant" <?= (isset($_POST['role']) && $_POST['role'] === 'etudiant') ? 'selected' : '' ?>><?= htmlspecialchars($lang['student'] ?? 'Étudiant') ?></option>
                        <option value="professeur" <?= (isset($_POST['role']) && $_POST['role'] === 'professeur') ? 'selected' : '' ?>><?= htmlspecialchars($lang['professor'] ?? 'Professeur') ?></option>
                        <option value="admin" <?= (isset($_POST['role']) && $_POST['role'] === 'admin') ? 'selected' : '' ?>><?= htmlspecialchars($lang['admin'] ?? 'Admin') ?></option>
                    </select>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="bi bi-person-plus-fill me-2"></i> <?= htmlspecialchars($lang['add_user_btn'] ?? 'Ajouter l\'utilisateur') ?>
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center mt-3">
            <a href="admin_dashboard.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i> <?= htmlspecialchars($lang['back_to_dashboard'] ?? 'Retour au tableau de bord') ?>
            </a>
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
    // JavaScript for Daltonian Mode
    document.getElementById('daltonienModeToggle').addEventListener('click', function() {
        document.body.classList.toggle('daltonien-mode');
        const isDaltonien = document.body.classList.contains('daltonien-mode');
        localStorage.setItem('daltonienMode', isDaltonien); // Save preference
    });

    // Check daltonian mode preference on load
    if (localStorage.getItem('daltonienMode') === 'true') {
        document.body.classList.add('daltonien-mode');
    }

    // Language change handler to refresh the page
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