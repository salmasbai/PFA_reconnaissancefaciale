<?php
// Pour afficher les erreurs pendant le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

$message = "";
$messageClass = "";

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
            // Vérifier si l'utilisateur existe déjà
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
            $checkStmt->execute([$email]);

            if ($checkStmt->fetchColumn() > 0) {
                $message = "Cet email est déjà utilisé.";
                $messageClass = "error-message";
            } else {
                $isValid = false;
                $entityId = null;

                // Vérification selon le rôle
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
                    $isValid = true;
                }

                if ($isValid) {
                    // Insertion dans la table utilisateurs
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$nom, $prenom, $email, $password, $role]);
                    $userId = $pdo->lastInsertId();

                    // Mise à jour du user_id dans l'entité liée
                    if ($role === 'etudiant') {
                        $updateStmt = $pdo->prepare("UPDATE etudiants SET user_id = ? WHERE id = ?");
                        $updateStmt->execute([$userId, $entityId]);
                    } elseif ($role === 'professeur') {
                        $updateStmt = $pdo->prepare("UPDATE professeurs SET user_id = ? WHERE id = ?");
                        $updateStmt->execute([$userId, $entityId]);
                    }

                    $message = "Utilisateur ajouté avec succès et lié à son profil $role.";
                    $messageClass = "success-message";
                } else {
                    $message = "Erreur : cet utilisateur n'est pas reconnu comme $role.";
                    $messageClass = "error-message";
                }
            }
        } catch (PDOException $e) {
            $message = "Erreur lors de l'ajout : " . $e->getMessage();
            $messageClass = "error-message";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $messageClass = "error-message";
    }
}
?>

<!-- HTML + Formulaire -->

<style>
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
    }

    .success-message {
        color: green;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .error-message {
        color: red;
        font-weight: bold;
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
    }

    button {
        margin-top: 20px;
        padding: 10px 20px;
    }
</style>

<div class="container">
    <h2>Ajouter un utilisateur</h2>

    <?php if (!empty($message)): ?>
        <div class="<?= $messageClass ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Rôle :</label>
        <select name="role" id="role" required>
            <option value="">-- Sélectionner un rôle --</option>
            <option value="etudiant">Étudiant</option>
            <option value="professeur">Professeur</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Ajouter l'utilisateur</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
