<?php
// includes/mailer_config.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Assurez-vous que ces chemins sont corrects par rapport à 'mailer_config.php'
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

function configureMailer() {
    $mail = new PHPMailer(true); // Passer 'true' permet d'activer les exceptions pour un meilleur débogage

    // Configuration SMTP (à modifier avec VOS PROPRES INFORMATIONS)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Pour Gmail. Si vous utilisez un autre fournisseur, changez ceci (ex: 'smtp.office365.com' pour Outlook)
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ouaryemen@gmail.com'; // <--- TRÈS IMPORTANT : Votre adresse email complète (expéditeur)
    $mail->Password   = 'ploj rfuv hhzl jdvz'; // <--- TRÈS IMPORTANT : Votre mot de passe email ou un mot de passe d'application si vous utilisez Gmail avec 2FA
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utilisez ENCRYPTION_SMTPS pour le port 465 (TLS implicite), ENCRYPTION_STARTTLS pour 587 (TLS explicite)
    $mail->Port       = 587; // Port SMTP (587 est courant pour STARTTLS, 465 pour SMTPS)

    // Expéditeur par défaut de l'email
    $mail->setFrom('votre_email@gmail.com', 'ENSAO Absence System'); // <--- Votre adresse email et le nom qui apparaîtra comme expéditeur

    $mail->isHTML(true); // Le format de l'email sera HTML
    $mail->CharSet = 'UTF-8'; // Encodage des caractères pour supporter toutes les langues

    return $mail;
}
?>