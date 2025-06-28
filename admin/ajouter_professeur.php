<?php
session_start(); // Start the session if not already started
require_once '../includes/config.php'; // Connexion PDO

// Define $lang_code BEFORE requiring the language file
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Fichier de langue

// Assurez-vous que seul l'admin accède à cette page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}

$message = '';
$message_type = ''; // 'success' ou 'danger' (Bootstrap equivalent for 'error')

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $telephone = trim($_POST['telephone']);
    $specialite = trim($_POST['specialite']);

    // Générer l'adresse email automatiquement
    $annee_courante_court = date('y'); // Année sur deux chiffres (ex: 23 for 2023)
    // Clean first name and last name for email (lowercase, no spaces, no special characters)
    $prenom_clean = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $prenom)));
    $nom_clean = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $nom)));
    $email = $prenom_clean . '.' . $nom_clean . '.' . $annee_courante_court . '@ump.ac.ma'; // Generated email

    // Validation des données
    if (empty($nom) || empty($prenom)) {
        $message = htmlspecialchars($lang['fill_required_fields'] ?? 'Veuillez remplir tous les champs obligatoires (Nom, Prénom).');
        $message_type = 'danger';
    } else {
        // Début de la transaction pour assurer l'atomicité
        $pdo->beginTransaction();

        try {
            // 1. Vérifier si l'email généré existe déjà dans la table 'utilisateurs'
            $stmt_check_email = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt_check_email->execute([$email]);
            if ($stmt_check_email->fetch()) {
                throw new Exception(htmlspecialchars($lang['email_exists'] ?? 'Un utilisateur avec cette adresse email générée existe déjà') . ": " . htmlspecialchars($email));
            }

            // 2. Créer l'utilisateur dans la table `utilisateurs`
            $default_password = 'password123'; // Define a temporary password
            $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
            $role = 'professeur';

            $stmt_user = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt_user->execute([$nom, $prenom, $email, $hashed_password, $role])) {
                throw new Exception(htmlspecialchars($lang['error_create_user'] ?? 'Erreur lors de la création de l\'utilisateur') . ": " . implode(" | ", $stmt_user->errorInfo()));
            }
            $user_id = $pdo->lastInsertId(); // Retrieve the ID of the new user

            // 3. Insert the professor into the `professeurs` table, linking the user_id
            $stmt_prof = $pdo->prepare("INSERT INTO professeurs (nom, prenom, email, telephone, specialite, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            
            if (!$stmt_prof->execute([$nom, $prenom, $email, $telephone, $specialite, $user_id])) {
                throw new Exception(htmlspecialchars($lang['error_add_professor'] ?? 'Erreur lors de l\'ajout du professeur') . ": " . implode(" | ", $stmt_prof->errorInfo()));
            }

            // If everything went well, commit the transaction
            $pdo->commit();
            $message = htmlspecialchars($lang['professor_added_success'] ?? 'Professeur ajouté avec succès. Un compte utilisateur a été créé (Email généré:') . " " . htmlspecialchars($email) . ", " . htmlspecialchars($lang['default_password'] ?? 'Mot de passe par défaut:') . " " . htmlspecialchars($default_password) . ").";
            $message_type = 'success';
            
            // Reset form fields after success
            $_POST = array(); // Clears the POST array to clear values in the fields

        } catch (Exception $e) {
            // If an error occurs, roll back the transaction
            $pdo->rollBack();
            $message = htmlspecialchars($lang['operation_failed'] ?? 'Opération échouée') . ": " . $e->getMessage();
            $message_type = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['add_professor_title'] ?? 'Ajouter un Professeur') ?></title>
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
            max-width: 900px; /* Adjusted for wider forms */
            margin: 2rem auto;
            padding: 0 15px; /* Use Bootstrap's default padding for containers */
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
        <a class="navbar-brand d-flex align-items-center" href="../admin/dashboard.php">
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
                <li class="nav-item"><a class="nav-link active" href="ajouter_professeur.php"><?= htmlspecialchars($lang['add_professor'] ?? 'Ajouter Professeur') ?></a></li>
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
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['add_new_professor'] ?? 'Ajouter un Nouveau Professeur') ?></h1>
        <p class="lead"><?= htmlspecialchars($lang['add_professor_desc'] ?? 'Remplissez le formulaire ci-dessous pour inscrire un nouveau professeur.') ?></p>
    </div>
</section>

<main class="container main-content">
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="content-section">
        <form method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label"><?= htmlspecialchars($lang['last_name'] ?? 'Nom') ?> *</label>
                    <input type="text" name="nom" id="nom" class="form-control" required value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label"><?= htmlspecialchars($lang['first_name'] ?? 'Prénom') ?> *</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label"><?= htmlspecialchars($lang['phone'] ?? 'Téléphone') ?></label>
                    <input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="specialite" class="form-label"><?= htmlspecialchars($lang['specialty'] ?? 'Spécialité') ?></label>
                    <input type="text" name="specialite" id="specialite" class="form-control" value="<?php echo htmlspecialchars($_POST['specialite'] ?? ''); ?>">
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus me-2"></i> <?= htmlspecialchars($lang['add'] ?? 'Ajouter') ?>
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
    // JavaScript pour le Mode Daltonien
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