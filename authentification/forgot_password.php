<?php
session_start();
// Changement ici : Remplacement de '??' par la syntaxe compatible PHP 5
require_once '../includes/config.php'; // Pour la connexion PDO si nécessaire pour les messages
require_once "../lang/" . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr') . ".php"; // Pour les traductions

$message = ''; // Pour afficher des messages de succès ou d'erreur

if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars(isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr') ?>"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(isset($lang['forgot_password']) ? $lang['forgot_password'] : 'Mot de passe oublié ?') ?> - ENSAO</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .login-box { /* Utilisation de la même classe pour le style */
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
        <h2><?= htmlspecialchars(isset($lang['forgot_password']) ? $lang['forgot_password'] : 'Mot de passe oublié ?') ?></h2> <?php if (!empty($message)): ?>
            <div class="alert <?= strpos($message, 'succès') !== false || strpos($message, 'envoyé') !== false ? 'alert-success' : 'alert' ?>" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <p><?= htmlspecialchars(isset($lang['enter_email_for_reset']) ? $lang['enter_email_for_reset'] : 'Veuillez entrer votre adresse e-mail pour recevoir un lien de réinitialisation de mot de passe.') ?></p> <form action="reset_password_process.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label"><?= htmlspecialchars(isset($lang['email']) ? $lang['email'] : 'Adresse e-mail') ?> :</label> <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit"><?= htmlspecialchars(isset($lang['send_reset_link']) ? $lang['send_reset_link'] : 'Envoyer le lien de réinitialisation') ?></button> </form>
        <p>
            <a href="login.php"><?= htmlspecialchars(isset($lang['back_to_login']) ? $lang['back_to_login'] : 'Retour à la connexion') ?></a> </p>
    </div>
</body>
</html>