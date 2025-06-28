<?php
session_start();
// Inclure votre fichier de configuration de base de données.
// Ce fichier devrait gérer la connexion PDO et les constantes de base de données.
require_once '../includes/config.php';

// Define $lang_code BEFORE requiring the language file
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Fichier de langue

// Assurez-vous que seul l'admin accède à cette page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}

// L'objet de connexion PDO est maintenant disponible via $pdo depuis config.php

// Initialisation des messages de statut
$message = '';
$message_type = ''; // 'success' ou 'danger' (Bootstrap equivalent for 'error')

// --- Traitement de l'ajout de l'étudiant ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $numero_etudiant = $_POST['numero_etudiant'] ?? '';
    $code_massar = $_POST['code_massar'] ?? '';
    $numero_apogee = $_POST['numero_apogee'] ?? '';
    $cycle = $_POST['cycle'] ?? '';
    $classe_id = $_POST['classe_id'] ?? '';

    // Générer l'adresse email automatiquement
    $annee_courante_court = date('y'); // Année sur deux chiffres (ex: 23 pour 2023)
    // Nettoyer le nom et prénom pour l'email (minuscules, pas d'espaces, pas de caractères spéciaux)
    $prenom_clean = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $prenom)));
    $nom_clean = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $nom)));
    $email_etudiant = $prenom_clean . '.' . $nom_clean . '.' . $annee_courante_court . '@ump.ac.ma';

    // Validation des données
    if (empty($nom) || empty($prenom) || empty($numero_etudiant) || empty($code_massar) || empty($numero_apogee) || empty($cycle) || empty($classe_id)) {
        $message = "Tous les champs obligatoires (sauf photo) doivent être remplis.";
        $message_type = 'danger';
    } else {
        // Début de la transaction pour assurer l'atomicité
        $pdo->beginTransaction();

        try {
            // 1. Récupérer la filiere_id associée à la classe_id sélectionnée
            $filiere_id = null;
            $stmt_get_filiere = $pdo->prepare("SELECT filiere_id FROM classes WHERE id = ?");
            $stmt_get_filiere->execute([$classe_id]);
            $filiere_id_from_class = $stmt_get_filiere->fetchColumn();
            if ($filiere_id_from_class === false) {
                throw new Exception("Impossible de trouver la filière associée à la classe sélectionnée.");
            }
            $filiere_id = $filiere_id_from_class;

            // 2. Gestion de l'upload de photo
            $photo_path = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Ensure the path is relative to the web root for access
                $target_dir_base = 'uploads/etudiants/' . date('Y') . '/' . date('m') . '/';
                $target_dir = '../' . $target_dir_base; // Path for server-side operations

                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $unique_filename = uniqid('etud_') . '.' . $file_extension;
                $target_file = $target_dir . $unique_filename;
                $photo_path_db = '/' . $target_dir_base . $unique_filename; // Path to store in DB

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    throw new Exception("Erreur lors de l'upload de la photo. Code d'erreur: " . $_FILES['photo']['error']);
                }
                $photo_path = $photo_path_db;
            } else if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                throw new Exception("Erreur lors de l'upload de la photo : " . $_FILES['photo']['error']);
            }

            // 3. Vérifier si l'email généré existe déjà dans la table 'utilisateurs'
            $stmt_check_email = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt_check_email->execute([$email_etudiant]);
            if ($stmt_check_email->fetch()) {
                throw new Exception("Un utilisateur avec cette adresse email générée existe déjà: " . htmlspecialchars($email_etudiant));
            }

            // 4. Créer l'utilisateur dans la table `utilisateurs`
            $default_password = 'password123'; // Définir un mot de passe temporaire
            $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
            $role = 'etudiant';

            $stmt_user = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt_user->execute([$nom, $prenom, $email_etudiant, $hashed_password, $role])) {
                throw new Exception("Erreur lors de la création de l'utilisateur : " . implode(" | ", $stmt_user->errorInfo()));
            }
            $user_id = $pdo->lastInsertId(); // Récupérer l'ID du nouvel utilisateur

            // 5. Insérer l'étudiant dans la table `etudiants`, en liant l'user_id
            $stmt_etudiant = $pdo->prepare("INSERT INTO etudiants (nom, prenom, numero_etudiant, photo_path, code_massar, numero_apogee, filiere_id, cycle, classe_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            if (!$stmt_etudiant->execute([$nom, $prenom, $numero_etudiant, $photo_path, $code_massar, $numero_apogee, $filiere_id, $cycle, $classe_id, $user_id])) {
                throw new Exception("Erreur lors de l'ajout de l'étudiant : " . implode(" | ", $stmt_etudiant->errorInfo()));
            }

            // Si tout s'est bien passé, valider la transaction
            $pdo->commit();
            $message = "L'étudiant a été ajouté avec succès, et un compte utilisateur a été créé (Email généré: " . htmlspecialchars($email_etudiant) . ", Mot de passe par défaut: " . htmlspecialchars($default_password) . ").";
            $message_type = 'success';
            
            // Réinitialiser les champs du formulaire sauf classe_id et cycle pour une meilleure UX
            $_POST['nom'] = $_POST['prenom'] = $_POST['numero_etudiant'] = '';
            $_POST['code_massar'] = $_POST['numero_apogee'] = '';

        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            $message = "Échec de l'opération : " . $e->getMessage();
            $message_type = 'danger';
        }
    }
}

// --- Récupération des classes existantes pour les listes déroulantes du formulaire ---
$classes = [];
$classes_data_js = [];
$stmt_classes = $pdo->query("SELECT c.id, c.nom_classe, c.niveau, f.nom_filiere AS filiere_nom, c.annee_universitaire, f.id AS filiere_id
                             FROM classes c
                             JOIN filieres f ON c.filiere_id = f.id
                             ORDER BY c.nom_classe ASC");
if ($stmt_classes) {
    while ($row = $stmt_classes->fetch(PDO::FETCH_ASSOC)) {
        $classes[] = $row;
        $classes_data_js[$row['id']] = [
            'niveau' => $row['niveau'],
            'filiere_nom' => $row['filiere_nom'],
            'filiere_id' => $row['filiere_id'],
            'annee_universitaire' => $row['annee_universitaire']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['add_student_title'] ?? 'Ajouter un Étudiant') ?></title>
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
        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
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
                <li class="nav-item"><a class="nav-link active" href="ajouter_etudiant.php"><?= htmlspecialchars($lang['add_student'] ?? 'Ajouter Étudiant') ?></a></li>
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
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['add_new_student'] ?? 'Ajouter un Nouvel Étudiant') ?></h1>
        <p class="lead"><?= htmlspecialchars($lang['add_student_desc'] ?? 'Remplissez le formulaire ci-dessous pour inscrire un nouvel étudiant.') ?></p>
    </div>
</section>

<main class="container main-content">
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="content-section">
        <form action="ajouter_etudiant.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label"><?= htmlspecialchars($lang['last_name'] ?? 'Nom') ?>:</label>
                    <input type="text" name="nom" id="nom" class="form-control" required value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label"><?= htmlspecialchars($lang['first_name'] ?? 'Prénom') ?>:</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="numero_etudiant" class="form-label"><?= htmlspecialchars($lang['student_id_number'] ?? 'Numéro Étudiant') ?>:</label>
                    <input type="text" name="numero_etudiant" id="numero_etudiant" class="form-control" required pattern="[A-Za-z0-9]{6,12}" value="<?php echo htmlspecialchars($_POST['numero_etudiant'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="code_massar" class="form-label"><?= htmlspecialchars($lang['massar_code'] ?? 'Code Massar') ?>:</label>
                    <input type="text" name="code_massar" id="code_massar" class="form-control" required pattern="[A-Za-z0-9]{8,20}" value="<?php echo htmlspecialchars($_POST['code_massar'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="numero_apogee" class="form-label"><?= htmlspecialchars($lang['apogee_code'] ?? 'Numéro Apogée') ?>:</label>
                    <input type="text" name="numero_apogee" id="numero_apogee" class="form-control" required value="<?php echo htmlspecialchars($_POST['numero_apogee'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cycle" class="form-label"><?= htmlspecialchars($lang['cycle'] ?? 'Cycle') ?>:</label>
                    <select name="cycle" id="cycle" class="form-select" required>
                        <option value="">-- <?= htmlspecialchars($lang['select_cycle'] ?? 'Sélectionner un cycle') ?> --</option>
                        <option value="CP" <?php echo (isset($_POST['cycle']) && $_POST['cycle'] == 'CP') ? 'selected' : ''; ?>>Cycle Préparatoire</option>
                        <option value="ING" <?php echo (isset($_POST['cycle']) && $_POST['cycle'] == 'ING') ? 'selected' : ''; ?>>Cycle d'Ingénieur</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="classe_id" class="form-label"><?= htmlspecialchars($lang['class'] ?? 'Classe') ?>:</label>
                    <select name="classe_id" id="classe_id" class="form-select" required>
                        <option value="">-- <?= htmlspecialchars($lang['select_class'] ?? 'Sélectionner une classe') ?> --</option>
                        <?php foreach ($classes as $class): ?>
                            <option
                                value="<?php echo htmlspecialchars($class['id']); ?>"
                                data-niveau="<?php echo htmlspecialchars($class['niveau']); ?>"
                                data-filiere_nom="<?php echo htmlspecialchars($class['filiere_nom']); ?>"
                                data-filiere_id="<?php echo htmlspecialchars($class['filiere_id']); ?>"
                                <?php echo (isset($_POST['classe_id']) && $_POST['classe_id'] == $class['id']) ? 'selected' : ''; ?>
                            >
                                <?php echo htmlspecialchars($class['nom_classe'] . ' (' . $class['annee_universitaire'] . ' - ' . $class['filiere_nom'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="filiere_display" class="form-label"><?= htmlspecialchars($lang['filiere_auto'] ?? 'Filière (Automatique)') ?>:</label>
                    <input type="text" name="filiere_display" id="filiere_display" class="form-control" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="niveau_display" class="form-label"><?= htmlspecialchars($lang['level_auto'] ?? 'Niveau (Automatique)') ?>:</label>
                    <input type="text" name="niveau_display" id="niveau_display" class="form-control" readonly>
                </div>

                <div class="col-12 mb-4">
                    <label for="photo" class="form-label"><?= htmlspecialchars($lang['photo'] ?? 'Photo') ?>:</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                    <small class="form-text text-muted"><?= htmlspecialchars($lang['photo_formats'] ?? 'Formats acceptés: JPG, PNG (facultatif)') ?></small>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-person-plus me-2"></i> <?= htmlspecialchars($lang['register_student'] ?? 'Enregistrer l\'étudiant') ?></button>
                </div>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="admin_dashboard.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i> <?= htmlspecialchars($lang['back_to_dashboard'] ?? 'Retour au tableau de bord') ?></a>
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

    // Passer les données des classes du PHP au JavaScript
    const classesData = <?php echo json_encode($classes_data_js); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const classeSelect = document.getElementById('classe_id');
        const filiereDisplayInput = document.getElementById('filiere_display');
        const niveauDisplayInput = document.getElementById('niveau_display');

        function updateFiliereNiveau() {
            const selectedClassId = classeSelect.value;
            if (selectedClassId && classesData[selectedClassId]) {
                filiereDisplayInput.value = classesData[selectedClassId].filiere_nom;
                niveauDisplayInput.value = classesData[selectedClassId].niveau;
            } else {
                filiereDisplayInput.value = '';
                niveauDisplayInput.value = '';
            }
        }

        // Update on page load if a class is already selected (after submission error)
        updateFiliereNiveau();

        // Update when class selection changes
        classeSelect.addEventListener('change', updateFiliereNiveau);
    });
</script>
</body>
</html>