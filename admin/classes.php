<?php
session_start();
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
$message_type = ''; // 'success' or 'danger'

// Traitement : ajout de classe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = trim($_POST['nom_classe']);
    $niveau = trim($_POST['niveau']);
    $filiere_id = trim($_POST['filiere_id']); // Changed to filiere_id to match DB schema
    $annee_univ = trim($_POST['annee_universitaire']);

    if ($nom && $niveau && $filiere_id && $annee_univ) {
        try {
            $stmt = $pdo->prepare("INSERT INTO classes (nom_classe, niveau, filiere_id, annee_universitaire) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $niveau, $filiere_id, $annee_univ]);
            $message = htmlspecialchars($lang['class_added_success'] ?? 'Classe ajoutée avec succès !');
            $message_type = 'success';
            // Clear form fields on success
            $_POST = array();
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { // Integrity constraint violation (e.g., duplicate entry)
                $message = htmlspecialchars($lang['class_exists_error'] ?? 'Erreur : Une classe avec ce nom et année universitaire existe déjà.');
            } else {
                $message = htmlspecialchars($lang['db_error'] ?? 'Erreur de base de données :') . " " . $e->getMessage();
            }
            $message_type = 'danger';
        }
    } else {
        $message = htmlspecialchars($lang['all_fields_required'] ?? 'Tous les champs sont obligatoires.');
        $message_type = 'danger';
    }
}

// Traitement : suppression de classe
if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    try {
        $pdo->prepare("DELETE FROM classes WHERE id = ?")->execute([$id]);
        $_SESSION['message'] = htmlspecialchars($lang['class_deleted_success'] ?? 'Classe supprimée avec succès !');
        $_SESSION['message_type'] = 'success';
    } catch (PDOException $e) {
        $_SESSION['message'] = htmlspecialchars($lang['delete_class_error'] ?? 'Erreur lors de la suppression de la classe :') . " " . $e->getMessage();
        $_SESSION['message_type'] = 'danger';
    }
    header("Location: gestion_classes.php"); // Redirect to the same page to show message
    exit;
}

// Check for session messages (after redirection for delete)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']); // Clear message after displaying
    unset($_SESSION['message_type']);
}

// Retrieve existing 'filieres' for the dropdown
$filieres = $pdo->query("SELECT id, nom_filiere FROM filieres ORDER BY nom_filiere ASC")->fetchAll(PDO::FETCH_ASSOC);


// Récupérer toutes les classes
// Join with filieres table to display filiere name instead of ID
$classes = $pdo->query("SELECT c.*, f.nom_filiere FROM classes c JOIN filieres f ON c.filiere_id = f.id ORDER BY c.nom_classe DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['manage_classes_title'] ?? 'Gestion des Classes') ?></title>
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
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 15px;
        }
        .content-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 2rem; /* Increased for spacing between sections */
        }
        h1, h2, h3 {
            color: var(--dark-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center; /* Center align headings */
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
                <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php"><?= htmlspecialchars($lang['dashboard'] ?? 'Tableau de Bord') ?></a></li>
                <li class="nav-item"><a class="nav-link active" href="gestion_classes.php"><?= htmlspecialchars($lang['manage_classes'] ?? 'Gestion des Classes') ?></a></li>
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
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['manage_classes_heading'] ?? 'Gestion des Classes') ?></h1>
        <p class="lead"><?= htmlspecialchars($lang['manage_classes_desc'] ?? 'Ajoutez, consultez ou supprimez les classes de l\'ENSAO.') ?></p>
    </div>
</section>

<main class="container main-content">
    <?php if ($message): ?>
        <div class="alert alert-<?= $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="content-section">
        <h2 class="mb-4"><i class="bi bi-plus-circle me-2"></i> <?= htmlspecialchars($lang['add_class'] ?? 'Ajouter une classe') ?></h2>
        <form method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom_classe" class="form-label"><?= htmlspecialchars($lang['class_name'] ?? 'Nom de la classe') ?> :</label>
                    <input type="text" name="nom_classe" id="nom_classe" class="form-control" required value="<?= htmlspecialchars($_POST['nom_classe'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="niveau" class="form-label"><?= htmlspecialchars($lang['level'] ?? 'Niveau') ?> :</label>
                    <select name="niveau" id="niveau" class="form-select" required>
                        <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                        <option value="1ère année" <?= (isset($_POST['niveau']) && $_POST['niveau'] == '1ère année') ? 'selected' : '' ?>>1<?= htmlspecialchars($lang['st_year'] ?? 'ère année') ?></option>
                        <option value="2ème année" <?= (isset($_POST['niveau']) && $_POST['niveau'] == '2ème année') ? 'selected' : '' ?>>2<?= htmlspecialchars($lang['nd_year'] ?? 'ème année') ?></option>
                        <option value="3ème année" <?= (isset($_POST['niveau']) && $_POST['niveau'] == '3ème année') ? 'selected' : '' ?>>3<?= htmlspecialchars($lang['rd_year'] ?? 'ème année') ?></option>
                        <option value="4ème année" <?= (isset($_POST['niveau']) && $_POST['niveau'] == '4ème année') ? 'selected' : '' ?>>4<?= htmlspecialchars($lang['th_year'] ?? 'ème année') ?></option>
                        <option value="5ème année" <?= (isset($_POST['niveau']) && $_POST['niveau'] == '5ème année') ? 'selected' : '' ?>>5<?= htmlspecialchars($lang['th_year'] ?? 'ème année') ?></option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="filiere_id" class="form-label"><?= htmlspecialchars($lang['filiere'] ?? 'Filière') ?> :</label>
                    <select name="filiere_id" id="filiere_id" class="form-select" required>
                        <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                        <?php foreach ($filieres as $filiere_item): ?>
                            <option value="<?= htmlspecialchars($filiere_item['id']) ?>" <?= (isset($_POST['filiere_id']) && $_POST['filiere_id'] == $filiere_item['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($filiere_item['nom_filiere']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="annee_universitaire" class="form-label"><?= htmlspecialchars($lang['academic_year'] ?? 'Année universitaire') ?> :</label>
                    <input type="text" name="annee_universitaire" id="annee_universitaire" class="form-control" value="<?= htmlspecialchars($_POST['annee_universitaire'] ?? (date('Y') . '/' . (date('Y') + 1))) ?>" required>
                </div>

                <div class="col-12 mt-3 text-center">
                    <button type="submit" name="ajouter" class="btn btn-primary w-50">
                        <i class="bi bi-plus-lg me-2"></i> <?= htmlspecialchars($lang['add_class_btn'] ?? 'Ajouter la classe') ?>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="content-section">
        <h2 class="mb-4"><i class="bi bi-list-ul me-2"></i> <?= htmlspecialchars($lang['class_list'] ?? 'Liste des classes') ?></h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= htmlspecialchars($lang['id'] ?? 'ID') ?></th>
                        <th><?= htmlspecialchars($lang['name'] ?? 'Nom') ?></th>
                        <th><?= htmlspecialchars($lang['level'] ?? 'Niveau') ?></th>
                        <th><?= htmlspecialchars($lang['filiere'] ?? 'Filière') ?></th>
                        <th><?= htmlspecialchars($lang['academic_year_short'] ?? 'Année Univ.') ?></th>
                        <th><?= htmlspecialchars($lang['action'] ?? 'Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($classes)): ?>
                        <tr>
                            <td colspan="6" class="text-center"><?= htmlspecialchars($lang['no_classes_found'] ?? 'Aucune classe trouvée.') ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($classes as $classe): ?>
                            <tr>
                                <td><?= htmlspecialchars($classe['id']) ?></td>
                                <td><?= htmlspecialchars($classe['nom_classe']) ?></td>
                                <td><?= htmlspecialchars($classe['niveau']) ?></td>
                                <td><?= htmlspecialchars($classe['nom_filiere']) ?></td>
                                <td><?= htmlspecialchars($classe['annee_universitaire']) ?></td>
                                <td>
                                    <a href="?supprimer=<?= htmlspecialchars($classe['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?= htmlspecialchars($lang['confirm_delete_class'] ?? 'Êtes-vous sûr de vouloir supprimer cette classe ?') ?>')">
                                        <i class="bi bi-trash me-1"></i> <?= htmlspecialchars($lang['delete'] ?? 'Supprimer') ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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