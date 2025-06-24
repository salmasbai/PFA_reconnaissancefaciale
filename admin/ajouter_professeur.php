<?php
require_once '../includes/config.php'; // Connexion PDO

/* session_start();
// Assurez-vous que seul l'admin accède à cette page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}*/

$message = '';
$message_type = ''; // 'success' ou 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    // L'email ne sera plus récupéré du POST, mais généré automatiquement
    $telephone = trim($_POST['telephone']);
    $specialite = trim($_POST['specialite']);

    // Générer l'adresse email automatiquement
    $annee_courante_court = date('y'); // Année sur deux chiffres (ex: 23 pour 2023)
    // Clean first name and last name for email (lowercase, no spaces, no special characters)
    $prenom_clean = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $prenom)));
    $nom_clean = strtolower(str_replace(' ', '', preg_replace('/[^A-Za-z0-9\-]/', '', $nom)));
    $email = $prenom_clean . '.' . $nom_clean . '.' . $annee_courante_court . '@ump.ac.ma'; // Generated email

    // Validation des données
    if (empty($nom) || empty($prenom)) { // L'email n'est plus un champ à valider ici, car il est généré.
        $message = "⚠️ Veuillez remplir tous les champs obligatoires (Nom, Prénom).";
        $message_type = 'error';
    } else {
        // Début de la transaction pour assurer l'atomicité
        $pdo->beginTransaction();

        try {
            // 1. Vérifier si l'email généré existe déjà dans la table 'utilisateurs'
            $stmt_check_email = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt_check_email->execute([$email]);
            if ($stmt_check_email->fetch()) {
                throw new Exception("Un utilisateur avec cette adresse email générée existe déjà: " . htmlspecialchars($email));
            }

            // 2. Créer l'utilisateur dans la table `utilisateurs`
            $default_password = 'password123'; // Define a temporary password
            $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
            $role = 'professeur';

            $stmt_user = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt_user->execute([$nom, $prenom, $email, $hashed_password, $role])) {
                throw new Exception("Error creating user: " . implode(" | ", $stmt_user->errorInfo()));
            }
            $user_id = $pdo->lastInsertId(); // Retrieve the ID of the new user

            // 3. Insert the professor into the `professeurs` table, linking the user_id
            $stmt_prof = $pdo->prepare("INSERT INTO professeurs (nom, prenom, email, telephone, specialite, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            
            if (!$stmt_prof->execute([$nom, $prenom, $email, $telephone, $specialite, $user_id])) {
                throw new Exception("Error adding professor: " . implode(" | ", $stmt_prof->errorInfo()));
            }

            // If everything went well, commit the transaction
            $pdo->commit();
            $message = "✅ Professeur ajouté avec succès. Un compte utilisateur a été créé (Email généré: " . htmlspecialchars($email) . ", Mot de passe par défaut: " . htmlspecialchars($default_password) . ").";
            $message_type = 'success';
            
            // Reset form fields after success
            $_POST = array(); // Clears the POST array to clear values in the fields

        } catch (Exception $e) {
            // If an error occurs, roll back the transaction
            $pdo->rollBack();
            $message = "❌ Operation failed: " . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Professeur</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f5f7fa; color: #333; }
        .container { max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
        label { display: block; margin-top: 15px; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
        input[type="text"], input[type="email"] {
            width: calc(100% - 20px); /* Adjust for padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Include padding in width */
        }
        input:focus { border-color: #3498db; outline: none; box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); }
        button {
            padding: 12px 25px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        button:hover { background-color: #2c3e50; }
        .message { margin: 15px 0; padding: 15px; border-radius: 5px; text-align: center; font-weight: bold; }
        .message.success { background-color: #d4edda; color: #155724; border-left: 5px solid #28a745; }
        .message.error { background-color: #f8d7da; color: #721c24; border-left: 5px solid #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h2>👨‍🏫 Ajouter un Professeur</h2>

        <?php if ($message): ?>
            <div class="message <?= $message_type === 'success' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="nom">Nom *</label>
            <input type="text" name="nom" id="nom" required value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">

            <label for="prenom">Prénom *</label>
            <input type="text" name="prenom" id="prenom" required value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">

            <!-- The email field is removed as it's now automatically generated -->
            <!-- <label for="email">Email *</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"> -->

            <label for="telephone">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="<?php echo htmlspecialchars($_POST['telephone'] ?? ''); ?>">

            <label for="specialite">Spécialité</label>
            <input type="text" name="specialite" id="specialite" value="<?php echo htmlspecialchars($_POST['specialite'] ?? ''); ?>">

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
