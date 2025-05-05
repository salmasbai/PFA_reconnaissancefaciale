<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

$message = "";
$messageClass = "";

// Traitement de l'ajout d'utilisateur
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
            // Vérification de l'existence de l'email
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
            $checkStmt->execute([$email]);
            if ($checkStmt->fetchColumn() > 0) {
                $message = "Cet email est déjà utilisé.";
                $messageClass = "error-message";
            } else {
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $password, $role]);
                $message = "Utilisateur ajouté avec succès !";
                $messageClass = "success-message";
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
<div class="main-content">
    <h1>Ajouter un Nouvel Utilisateur</h1>

    <?php if (!empty($message)) : ?>
        <div class="<?= $messageClass ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form action="" method="POST">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" placeholder="Entrez le nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" placeholder="Entrez le prénom" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" placeholder="exemple@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" placeholder="Entrez le mot de passe" required>
            </div>

            <div class="form-group">
                <label for="role">Rôle :</label>
                <select name="role" id="role" required>
                    <option value="">-- Sélectionnez un rôle --</option>
                    <option value="admin">Admin</option>
                    <option value="etudiant">Étudiant</option>
                    <option value="professeur">Professeur</option>
                </select>
            </div>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
