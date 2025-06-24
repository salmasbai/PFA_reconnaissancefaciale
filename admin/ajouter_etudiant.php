<?php
// Inclure votre fichier de configuration de base de données.
// Ce fichier devrait gérer la connexion PDO et les constantes de base de données.
require_once '../includes/config.php';

/* session_start();
// Assurez-vous que seul l'admin accède à cette page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}*/

// L'objet de connexion PDO est maintenant disponible via $pdo depuis config.php

// Initialisation des messages de statut
$message = '';
$message_type = ''; // 'success' ou 'error'

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
        $message_type = 'error';
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
                $target_dir = "uploads/etudiants/" . date('Y') . "/" . date('m') . "/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $unique_filename = uniqid('etud_') . '.' . $file_extension;
                $target_file = $target_dir . $unique_filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    throw new Exception("Erreur lors de l'upload de la photo. Code d'erreur: " . $_FILES['photo']['error']);
                }
                $photo_path = '/' . $target_file;
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
            $message_type = 'error';
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant - ENSAO</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: var(--dark-color);
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .main-content {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--accent-color);
        }

        .form-container {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s ease;
        }

        input[type="file"] {
            width: 100%;
            padding: 0.5rem 0;
        }

        input:focus,
        select:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        button[type="submit"] {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        button[type="submit"]:hover {
            background-color: var(--primary-color);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: var(--secondary-color);
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .form-grid .full-width {
                grid-column: span 2;
            }
        }

        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="main-content">
        <h1>Ajouter un Nouvel Étudiant</h1>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form action="ajouter_etudiant.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" name="nom" id="nom" required value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" name="prenom" id="prenom" required value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="numero_etudiant">Numéro Étudiant:</label>
                        <input type="text" name="numero_etudiant" id="numero_etudiant" required pattern="[A-Za-z0-9]{6,12}" value="<?php echo htmlspecialchars($_POST['numero_etudiant'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="code_massar">Code Massar:</label>
                        <input type="text" name="code_massar" id="code_massar" required pattern="[A-Za-z0-9]{8,20}" value="<?php echo htmlspecialchars($_POST['code_massar'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="numero_apogee">Numéro Apogée:</label>
                        <input type="text" name="numero_apogee" id="numero_apogee" required value="<?php echo htmlspecialchars($_POST['numero_apogee'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="cycle">Cycle:</label>
                        <select name="cycle" id="cycle" required>
                            <option value="">-- Sélectionner un cycle --</option>
                            <option value="CP" <?php echo (isset($_POST['cycle']) && $_POST['cycle'] == 'CP') ? 'selected' : ''; ?>>Cycle Préparatoire</option>
                            <option value="ING" <?php echo (isset($_POST['cycle']) && $_POST['cycle'] == 'ING') ? 'selected' : ''; ?>>Cycle d'Ingénieur</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="classe_id">Classe:</label>
                        <select name="classe_id" id="classe_id" required>
                            <option value="">-- Sélectionner une classe --</option>
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

                    <div class="form-group">
                        <label for="filiere_display">Filière (Automatique):</label>
                        <input type="text" name="filiere_display" id="filiere_display" class="bg-gray-100" readonly value="">
                    </div>

                    <div class="form-group">
                        <label for="niveau_display">Niveau (Automatique):</label>
                        <input type="text" name="niveau_display" id="niveau_display" class="bg-gray-100" readonly value="">
                    </div>

                    <div class="form-group full-width">
                        <label for="photo">Photo:</label>
                        <input type="file" name="photo" id="photo" accept="image/*">
                        <small>Formats acceptés: JPG, PNG (facultatif)</small>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit">Enregistrer l'étudiant</button>
                    </div>
                </div>
            </form>

            <a href="liste_etudiants.php" class="back-link">← Retour à la liste</a>
        </div>
    </div>

    <?php // include '../includes/footer.php'; ?>

    <script>
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

            // Mettre à jour au chargement de la page si une classe est déjà sélectionnée (après erreur de soumission)
            updateFiliereNiveau();

            // Mettre à jour lorsque la sélection de la classe change
            classeSelect.addEventListener('change', updateFiliereNiveau);
        });
    </script>
</body>
</html>
