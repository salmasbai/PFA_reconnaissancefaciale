<?php
session_start();
// Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
require_once '../includes/config.php'; // Votre connexion PDO ($pdo)
require_once "../lang/" . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr') . ".php"; // Pour les traductions

$token = isset($_GET['token']) ? $_GET['token'] : '';
$message = ''; // Pour afficher les messages de succès ou d'erreur

if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}

$is_token_valid = false;
$user_id_from_token = null;

if (empty($token)) {
    // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
    $message = htmlspecialchars(isset($lang['missing_reset_token']) ? $lang['missing_reset_token'] : "Jeton de réinitialisation manquant.");
} else {
    try {
        // Vérifier le jeton dans la base de données
        // Ici, nous utilisons $pdo qui vient de ../includes/config.php
        $stmt = $pdo->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le jeton existe et n'est pas expiré
        if (!$reset_data) {
            // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
            $message = htmlspecialchars(isset($lang['invalid_reset_token']) ? $lang['invalid_reset_token'] : "Jeton de réinitialisation invalide ou déjà utilisé.");
        } elseif (new DateTime() > new DateTime($reset_data['expires_at'])) {
            // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
            $message = htmlspecialchars(isset($lang['expired_reset_token']) ? $lang['expired_reset_token'] : "Jeton de réinitialisation expiré. Veuillez refaire une demande.");
        } else {
            $is_token_valid = true;
            $user_id_from_token = $reset_data['user_id'];
        }

    } catch (PDOException $e) {
        error_log("Database error in reset_password_form.php: " . $e->getMessage());
        // Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
        $message = htmlspecialchars(isset($lang['db_error_occurred']) ? $lang['db_error_occurred'] : "Une erreur est survenue lors de la vérification du jeton.");
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars(isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(isset($lang['set_new_password']) ? $lang['set_new_password'] : 'Définir un nouveau mot de passe') ?> - ENSAO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
            --light-bg: #f9f4f1;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .login-box { /* Réutilisation du style de votre page de connexion */
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 1.5rem;
            color: var(--primary);
            text-align: center;
            font-weight: 700;
        }
        label {
            display: block;
            margin-top: 1rem;
            color: #333;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 0.7rem;
            margin-top: 0.3rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        input:focus, select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(179, 135, 76, 0.25);
        }
        button {
            margin-top: 1.5rem;
            padding: 0.8rem;
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.2s, border-color 0.2s;
        }
        button:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        .alert {
            background: #f8d7da;
            color: #721c24;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .login-box p {
            text-align: center;
            margin-top: 1rem;
        }
        .login-box p a {
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
        }
        .login-box p a:hover {
            color: var(--accent);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2><?= htmlspecialchars(isset($lang['set_new_password']) ? $lang['set_new_password'] : 'Définir un nouveau mot de passe') ?></h2>
        <?php if (!empty($message)): ?>
            <div class="alert <?= strpos($message, 'succès') !== false ? 'alert-success' : 'alert' ?>" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <?php if ($is_token_valid): // N'affiche le formulaire que si le jeton est valide ?>
            <form action="update_password.php" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
                <div class="mb-3">
                    <label for="new_password" class="form-label"><?= htmlspecialchars(isset($lang['new_password']) ? $lang['new_password'] : 'Nouveau mot de passe') ?> :</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label"><?= htmlspecialchars(isset($lang['confirm_password']) ? $lang['confirm_password'] : 'Confirmer le mot de passe') ?> :</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="6">
                </div>
                <button type="submit"><?= htmlspecialchars(isset($lang['reset_password_button']) ? $lang['reset_password_button'] : 'Réinitialiser le mot de passe') ?></button>
            </form>
        <?php else: // Si le jeton est invalide ou manquant, proposer de redemander un lien ?>
            <p><a href="forgot_password.php"><?= htmlspecialchars(isset($lang['request_new_reset_link']) ? $lang['request_new_reset_link'] : 'Demander un nouveau lien de réinitialisation') ?></a></p>
        <?php endif; ?>
        <p>
            <a href="login.php"><?= htmlspecialchars(isset($lang['back_to_login']) ? $lang['back_to_login'] : 'Retour à la connexion') ?></a>
        </p>
    </div>
</body>
</html>