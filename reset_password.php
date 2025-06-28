<?php
session_start();
require_once 'includes/config.php'; // Connexion à la base de données

// Définir le code de langue pour l'inclusion du fichier de langue
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "lang/{$lang_code}.php";

$message = ''; // Variable pour stocker les messages de succès ou d'erreur
$message_type = ''; // Variable pour définir le type de message ('success' ou 'danger')
$token_valid = false; // Indicateur pour savoir si le jeton est valide

// Récupérer le jeton de réinitialisation de l'URL (via le paramètre GET 'token')
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Vérifie si un jeton est manquant dans l'URL
if (empty($token)) {
    $message = $lang['reset_password_no_token'] ?? 'Jeton de réinitialisation manquant.';
    $message_type = 'danger';
} else {
    try {
        // Prépare une requête pour vérifier si le jeton existe dans la DB et n'est pas expiré
        // 'NOW()' est une fonction SQL qui retourne la date et l'heure actuelles du serveur
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE reset_token = ? AND reset_token_expires_at > NOW()");
        $stmt->execute([$token]); // Exécute la requête avec le jeton fourni
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la ligne de l'utilisateur

        // Si un utilisateur est trouvé avec ce jeton valide et non expiré
        if ($user) {
            $token_valid = true; // Le jeton est valide, on peut afficher le formulaire
            $user_id = $user['id']; // Récupère l'ID de l'utilisateur

            // Si le formulaire de nouveau mot de passe a été soumis
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
                $confirm_new_password = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : '';

                // 1. Validation des champs vides
                if (empty($new_password) || empty($confirm_new_password)) {
                    $message = $lang['change_password_empty_fields'] ?? 'Veuillez remplir tous les champs.';
                    $message_type = 'danger';
                }
                // 2. Vérification de la correspondance des nouveaux mots de passe
                elseif ($new_password !== $confirm_new_password) {
                    $message = $lang['change_password_mismatch'] ?? 'Les nouveaux mots de passe ne correspondent pas.';
                    $message_type = 'danger';
                }
                // 3. Vérification de la complexité du nouveau mot de passe (Exemple : longueur min 6 caractères)
                elseif (strlen($new_password) < 6) {
                    $message = $lang['change_password_short'] ?? 'Le nouveau mot de passe doit contenir au moins 6 caractères.';
                    $message_type = 'danger';
                }
                else {
                    // Hacher le nouveau mot de passe de manière sécurisée
                    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

                    // Mettre à jour le mot de passe dans la base de données
                    // et invalider le jeton en le mettant à NULL et en effaçant sa date d'expiration
                    $update_stmt = $pdo->prepare("UPDATE utilisateurs SET password = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?");
                    $update_stmt->execute([$new_password_hashed, $user_id]);

                    $message = $lang['reset_password_success'] ?? 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.';
                    $message_type = 'success';
                    $token_valid = false; // Le jeton n'est plus valide après la réinitialisation, le formulaire ne doit plus s'afficher

                }
            }
        } else {
            // Si aucun utilisateur n'est trouvé pour ce jeton ou s'il est expiré
            $message = $lang['reset_password_invalid_or_expired'] ?? 'Jeton de réinitialisation invalide ou expiré.';
            $message_type = 'danger';
        }
    } catch (PDOException $e) {
        // Gère les erreurs de base de données
        $message = $lang['login_db_error'] ?? 'Une erreur de base de données est survenue.';
        $message_type = 'danger';
        error_log("Reset password DB error: " . $e->getMessage()); // Enregistre l'erreur dans les logs
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['reset_password_title'] ?? 'Réinitialiser le mot de passe') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Styles CSS similaires aux pages de connexion/mot de passe oublié */
        :root { --primary: #8c5a2b; --secondary: #cfa37b; --accent: #b3874c; }
        body { font-family: 'Roboto', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f9f4f1; }
        .container-sm { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--accent); border-color: var(--accent); }
    </style>
</head>
<body>
    <div class="container-sm">
        <h2 class="text-center mb-4"><?= htmlspecialchars($lang['reset_password_title'] ?? 'Réinitialiser le mot de passe') ?></h2>
        <?php if ($message): // Affiche les messages (succès, erreur, jeton invalide/manquant) ?>
            <div class="alert alert-<?= htmlspecialchars($message_type) ?>" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php 
        // Affiche le formulaire de nouveau mot de passe UNIQUEMENT si le jeton est valide
        // et qu'il n'y a pas déjà eu un message de succès (pour éviter de réafficher le form après réinitialisation réussie)
        if ($token_valid && $message_type !== 'success'): 
        ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="new_password" class="form-label"><?= htmlspecialchars($lang['new_password'] ?? 'Nouveau mot de passe') ?></label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_new_password" class="form-label"><?= htmlspecialchars($lang['confirm_new_password'] ?? 'Confirmer le nouveau mot de passe') ?></label>
                    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars($lang['reset_my_password'] ?? 'Réinitialiser mon mot de passe') ?></button>
            </form>
        <?php endif; ?>

        <p class="text-center mt-3">
            <a href="etudiants/login.php"><?= htmlspecialchars($lang['back_to_login'] ?? 'Retour à la connexion') ?></a>
        </p>
    </div>
</body>
</html>