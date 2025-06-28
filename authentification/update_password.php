<?php
session_start();
require_once '../includes/config.php'; // Votre connexion PDO ($pdo)
// Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
require_once "../lang/" . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr') . ".php"; // Pour les traductions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Validation initiale des champs
    if (empty($token) || empty($new_password) || empty($confirm_password)) {
        // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
        header("Location: reset_password_form.php?token=" . urlencode($token) . "&message=" . urlencode(isset($lang['all_fields_required']) ? $lang['all_fields_required'] : "Tous les champs sont requis."));
        exit();
    }

    if ($new_password !== $confirm_password) {
        // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
        header("Location: reset_password_form.php?token=" . urlencode($token) . "&message=" . urlencode(isset($lang['passwords_do_not_match']) ? $lang['passwords_do_not_match'] : "Les mots de passe ne correspondent pas."));
        exit();
    }

    if (strlen($new_password) < 6) { // Vous pouvez ajuster cette longueur minimale
        // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
        header("Location: reset_password_form.php?token=" . urlencode($token) . "&message=" . urlencode(isset($lang['password_min_length']) ? $lang['password_min_length'] : "Le mot de passe doit contenir au moins 6 caractères."));
        exit();
    }

    try {
        // 1. Vérifier le jeton une dernière fois avant de modifier le mot de passe
        // Cela empêche la réutilisation du lien ou la modification si le jeton a expiré entretemps.
        $stmt = $pdo->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reset_data) {
            // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
            header("Location: forgot_password.php?message=" . urlencode(isset($lang['invalid_reset_token']) ? $lang['invalid_reset_token'] : "Jeton de réinitialisation invalide ou déjà utilisé."));
            exit();
        } elseif (new DateTime() > new DateTime($reset_data['expires_at'])) {
            // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
            header("Location: forgot_password.php?message=" . urlencode(isset($lang['expired_reset_token']) ? $lang['expired_reset_token'] : "Jeton de réinitialisation expiré. Veuillez refaire une demande."));
            exit();
        }

        $user_id = $reset_data['user_id'];

        // 2. Hasher le nouveau mot de passe
        // password_hash() est disponible à partir de PHP 5.5.
        // Si vous êtes sur une version antérieure à 5.5 (ce qui est très peu probable et non recommandé),
        // vous devrez utiliser une fonction de hachage plus ancienne ou un polyfill.
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // 3. Mettre à jour le mot de passe de l'utilisateur dans la table 'utilisateurs'
        $stmt = $pdo->prepare("UPDATE utilisateurs SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        // 4. Supprimer le jeton de réinitialisation de la base de données
        // C'est crucial pour des raisons de sécurité : le jeton ne doit être utilisable qu'une seule fois.
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Rediriger vers la page de connexion avec un message de succès
        // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
        header("Location: login.php?message=" . urlencode(isset($lang['password_reset_success']) ? $lang['password_reset_success'] : "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter."));
        exit();

    } catch (PDOException $e) {
        // Enregistre l'erreur de base de données pour le débogage
        error_log("Database error in update_password.php: " . $e->getMessage());
        // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
        header("Location: reset_password_form.php?token=" . urlencode($token) . "&message=" . urlencode(isset($lang['db_error_occurred']) ? $lang['db_error_occurred'] : "Une erreur est survenue lors de la réinitialisation de votre mot de passe."));
        exit();
    }
} else {
    // Redirige si la page est accédée directement sans méthode POST
    header("Location: forgot_password.php");
    exit();
}