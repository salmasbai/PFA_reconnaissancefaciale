<?php
session_start();
require_once '../includes/config.php'; // Votre connexion PDO ($pdo)
require_once "../lang/" . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr') . ".php"; // Pour les traductions

// Inclusion de votre fichier de configuration du mailer
// Le chemin est relatif à reset_password_process.php qui est dans 'authentication/'
require_once '../includes/mailer_config.php';


// Vous n'avez plus besoin des 'use' ici car ils sont déjà dans mailer_config.php et vous allez appeler la fonction
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;

// Vous n'avez plus besoin de ces require_once non plus, car mailer_config.php s'en occupe
// require_once '../includes/PHPMailer/Exception.php';
// require_once '../includes/PHPMailer/PHPMailer.php';
// require_once '../includes/PHPMailer/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forgot_password.php?message=" . urlencode(isset($lang['invalid_email']) ? $lang['invalid_email'] : "Adresse e-mail invalide."));
        exit();
    }

    try {
        // ... (votre code existant pour vérifier l'email, générer le token, etc.) ...
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            header("Location: forgot_password.php?message=" . urlencode(isset($lang['reset_link_sent_if_exists']) ? $lang['reset_link_sent_if_exists'] : "Si cet email existe dans notre système, un lien de réinitialisation vous a été envoyé."));
            exit();
        }

        $user_id = $user['id'];

        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expires);
        $stmt->execute();


        // 5. Envoyer l'e-mail en utilisant la fonction configureMailer()
        $mail = configureMailer(); // Appelle la fonction pour obtenir une instance de PHPMailer configurée

        // Activez le débogage ici POUR LE TEST, retirez en production
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // $mail->Debugoutput = function($str, $level) { error_log("debug level $level; message: $str"); };


        try {
            // Expéditeur et destinataire (setFrom est déjà dans configureMailer, mais vous pouvez l'écraser si besoin)
            // $mail->setFrom('ouaryemen@gmail.com', 'ENSAO Absence System'); // Inutile si déjà fait dans configureMailer
            $mail->addAddress($email);

            // Contenu de l'e-mail
            $mail->isHTML(false); // E-mail en texte brut
            $mail->Subject = htmlspecialchars(isset($lang['reset_password_subject']) ? $lang['reset_password_subject'] : 'Réinitialisation de votre mot de passe');

            $base_url = "http://" . $_SERVER['HTTP_HOST'] . "/PFA_reconnaissancefaciale";
            $reset_link = $base_url . "/authentification/reset_password_form.php?token=" . $token;

            $mail->Body    = htmlspecialchars(isset($lang['hello']) ? $lang['hello'] : 'Bonjour,') . "\n\n" .
                             htmlspecialchars(isset($lang['reset_password_email_body']) ? $lang['reset_password_email_body'] : 'Vous avez demandé la réinitialisation de votre mot de passe. Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe :') . "\n\n" .
                             $reset_link . "\n\n" .
                             htmlspecialchars(isset($lang['link_expires_in_1_hour']) ? $lang['link_expires_in_1_hour'] : 'Ce lien expirera dans 1 heure.') . "\n\n" .
                             htmlspecialchars(isset($lang['ignore_if_not_requested']) ? $lang['ignore_if_not_requested'] : 'Si vous n\'avez pas demandé cette réinitialisation, veuillez ignorer cet e-mail.') . "\n\n" .
                             htmlspecialchars(isset($lang['sincerely']) ? $lang['sincerely'] : 'Cordialement,') . "\nENSAO Oujda";

            $mail->send();
            header("Location: forgot_password.php?message=" . urlencode(isset($lang['reset_link_sent_if_exists']) ? $lang['reset_link_sent_if_exists'] : "Si cet email existe dans notre système, un lien de réinitialisation vous a été envoyé."));
            exit();

        } catch (Exception $e) {
            // Enregistre l'erreur pour le débogage (consultez vos logs PHP ou le fichier d'erreurs d'Apache)
            error_log("PHPMailer Error in reset_password_process.php: " . $e->getMessage() . " Mailer Info: " . $mail->ErrorInfo);
            header("Location: forgot_password.php?message=" . urlencode(isset($lang['email_send_error']) ? $lang['email_send_error'] : "Erreur lors de l'envoi de l'e-mail. Veuillez réessayer plus tard."));
            exit();
        }

    } catch (PDOException $e) {
        // Enregistre l'erreur de base de données pour le débogage
        error_log("Database error in reset_password_process.php: " . $e->getMessage());
        header("Location: forgot_password.php?message=" . urlencode(isset($lang['db_error_occurred']) ? $lang['db_error_occurred'] : "Une erreur est survenue lors du traitement de votre demande."));
        exit();
    }
} else {
    // Redirige si la page est accédée directement sans méthode POST
    header("Location: forgot_password.php");
    exit();
}