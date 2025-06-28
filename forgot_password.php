<?php
session_start();
require_once 'includes/config.php'; // Connexion à la base de données
require_once 'includes/mailer_config.php'; // Configuration du mailer

// Définir le code de langue pour l'inclusion du fichier de langue
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "lang/{$lang_code}.php";

$message = ''; // Variable pour stocker les messages de succès ou d'erreur
$message_type = ''; // Variable pour définir le type de message ('success' ou 'danger')

// Vérifie si le formulaire a été soumis via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère l'email saisi par l'utilisateur, en supprimant les espaces au début et à la fin
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Valide l'adresse email saisie
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = $lang['forgot_password_invalid_email'] ?? 'Veuillez saisir une adresse email valide.';
        $message_type = 'danger'; // Message d'erreur
    } else {
        try {
            // Prépare une requête pour vérifier si l'email existe dans la table 'utilisateurs'
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]); // Exécute la requête avec l'email fourni
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la ligne de l'utilisateur

            // Si un utilisateur avec cet email est trouvé
            if ($user) {
                $user_id = $user['id']; // Récupère l'ID de l'utilisateur

                // Génère un jeton de réinitialisation unique et sécurisé (64 caractères hexadécimaux)
                $token = bin2hex(random_bytes(32)); 
                // Définit la date d'expiration du jeton (ici, 1 heure après l'heure actuelle)
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); 

                // Met à jour la table 'utilisateurs' avec le nouveau jeton et sa date d'expiration
                $stmt_update_token = $pdo->prepare("UPDATE utilisateurs SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?");
                $stmt_update_token->execute([$token, $expires, $user_id]);

                // Configure et envoie l'email de réinitialisation
                $mail = configureMailer(); // Appelle la fonction de configuration de PHPMailer
                $mail->addAddress($email); // Ajoute l'email de l l'utilisateur comme destinataire
                $mail->Subject = $lang['reset_password_email_subject'] ?? 'Réinitialisation de votre mot de passe ENSAO'; // Sujet de l'email

                // Construit le lien de réinitialisation. Assurez-vous que BASE_URL est définie dans includes/config.php
                // Exemple: define('BASE_URL', 'http://localhost/PFA_reconnaissancefaciale/');
                $reset_link = BASE_URL . 'reset_password.php?token=' . $token; 

                // Corps de l'email au format HTML
                $mail->Body    = '
                    <h2>' . ($lang['reset_password_email_title'] ?? 'Réinitialisation de votre mot de passe') . '</h2>
                    <p>' . ($lang['reset_password_email_text1'] ?? 'Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le lien ci-dessous pour continuer :') . '</p>
                    <p><a href="' . htmlspecialchars($reset_link) . '">' . htmlspecialchars($reset_link) . '</a></p>
                    <p>' . ($lang['reset_password_email_text2'] ?? 'Ce lien expirera dans 1 heure.') . '</p>
                    <p>' . ($lang['reset_password_email_text3'] ?? 'Si vous n\'avez pas demandé cela, veuillez ignorer cet email.') . '</p>
                    <p>ENSAO Absence System</p>
                ';
                // Corps de l'email au format texte brut (pour les clients de messagerie qui ne supportent pas HTML)
                $mail->AltBody = ($lang['reset_password_email_alttext'] ?? 'Pour réinitialiser votre mot de passe, visitez : ') . $reset_link;

                $mail->send(); // Envoie l'email
                $message = $lang['forgot_password_success_email'] ?? 'Un lien de réinitialisation du mot de passe a été envoyé à votre adresse email.';
                $message_type = 'success'; // Message de succès

            } else {
                // Si l'email n'est pas trouvé, pour des raisons de sécurité, on donne le même message de succès.
                // Cela évite d'indiquer si un email est enregistré ou non, empêchant ainsi l'énumération d'emails.
                $message = $lang['forgot_password_success_email'] ?? 'Un lien de réinitialisation du mot de passe a été envoyé à votre adresse email.';
                $message_type = 'success';
            }
        } catch (Exception $e) {
            // Gère les erreurs spécifiques à PHPMailer
            $message = ($lang['email_send_error'] ?? 'Erreur lors de l\'envoi de l\'email : ') . " " . $mail->ErrorInfo;
            $message_type = 'danger';
            error_log("Mailer Error: " . $e->getMessage()); // Enregistre l'erreur dans les logs du serveur
        } catch (PDOException $e) {
            // Gère les erreurs de base de données
            $message = $lang['login_db_error'] ?? 'Une erreur de base de données est survenue.';
            $message_type = 'danger';
            error_log("Forgot password DB error: " . $e->getMessage()); // Enregistre l'erreur dans les logs
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['forgot_password_title'] ?? 'Mot de passe oublié') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Styles CSS similaires à votre page de connexion */
        :root { --primary: #8c5a2b; --secondary: #cfa37b; --accent: #b3874c; }
        body { font-family: 'Roboto', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f9f4f1; }
        .container-sm { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--accent); border-color: var(--accent); }
    </style>
</head>
<body>
    <div class="container-sm">
        <h2 class="text-center mb-4"><?= htmlspecialchars($lang['forgot_password_title'] ?? 'Mot de passe oublié') ?></h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= htmlspecialchars($message_type) ?>" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <p class="text-center"><?= htmlspecialchars($lang['forgot_password_instructions'] ?? 'Veuillez saisir votre adresse email académique. Vous recevrez un lien pour réinitialiser votre mot de passe.') ?></p>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label"><?= htmlspecialchars($lang['email_academic'] ?? 'Email Académique') ?></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars($lang['send_reset_link'] ?? 'Envoyer le lien de réinitialisation') ?></button>
        </form>
        <p class="text-center mt-3">
            <a href="etudiants/login.php"><?= htmlspecialchars($lang['back_to_login'] ?? 'Retour à la connexion') ?></a>
        </p>
    </div>
</body>
</html>