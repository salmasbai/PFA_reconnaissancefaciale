<?php
session_start();
require_once '../includes/config.php'; // Connexion à la base de données

// Inclure le fichier de configuration du mailer
require_once '../includes/mailer_config.php'; // Assurez-vous que ce chemin est correct

$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Fichier de langue

$error_message = '';
$success_message = ''; // Pour les messages sur cette page
$display_form = true; // Contrôle si le formulaire de login est affiché ou le message d'info

// On force le rôle à 'admin' pour cette page de connexion spécifique
$target_role = 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error_message = $lang['login_empty_fields'] ?? 'Veuillez remplir tous les champs.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, nom, prenom, email, password, role FROM utilisateurs WHERE email = ? AND role = ?");
            $stmt->execute([$email, $target_role]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Authentification par mot de passe réussie.
                // NE PAS ÉTABLIR LA SESSION user_id/role ICI, seulement après la 2FA.

                // --- Générer un code 2FA aléatoire (6 chiffres) ---
                $two_factor_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $expiry_time = time() + (5 * 60); // Code valide pour 5 minutes

                // Stocker les informations de l'utilisateur et le code 2FA temporairement en session
                $_SESSION['2fa_temp_user_id'] = $user['id'];
                $_SESSION['2fa_temp_user_email'] = $user['email'];
                $_SESSION['2fa_temp_user_first_name'] = $user['prenom'];
                $_SESSION['2fa_temp_user_last_name'] = $user['nom'];
                $_SESSION['2fa_temp_user_role'] = $user['role']; // 'admin'
                $_SESSION['2fa_code'] = $two_factor_code;
                $_SESSION['2fa_code_expiry'] = $expiry_time;

                // --- Envoi de l'e-mail avec le code 2FA via PHPMailer ---
                try {
                    $mail = configureMailer(); // Utilise votre fonction de configuration PHPMailer
                    $mail->addAddress($user['email'], $user['prenom'] . ' ' . $user['nom']); // Destinataire: l'admin

                    $mail->Subject = ($lang['2fa_email_subject'] ?? 'Votre code de vérification - ENSAO');
                    
                    $mail->isHTML(true); // Définir le format de l'email sur HTML
                    $mail->Body    = "<p>" . ($lang['2fa_email_body_greeting'] ?? 'Bonjour') . " <strong>" . htmlspecialchars($user['prenom'] . ' ' . $user['nom']) . "</strong>,</p>"
                                   . "<p>" . ($lang['2fa_email_body_code_text'] ?? 'Votre code de vérification pour accéder à votre tableau de bord administrateur est :') . "</p>"
                                   . "<h3 style='color: var(--primary);'><strong>" . htmlspecialchars($two_factor_code) . "</strong></h3>"
                                   . "<p>" . ($lang['2fa_email_body_expiry_warning'] ?? 'Ce code est valide pendant 5 minutes.') . "</p>"
                                   . "<p>" . ($lang['2fa_email_body_do_not_share'] ?? 'Ne partagez jamais ce code avec qui que ce soit.') . "</p>"
                                   . "<p>" . ($lang['2fa_email_body_regards'] ?? 'Cordialement,') . "<br>L'équipe ENSAO</p>";
                    
                    $mail->AltBody = ($lang['2fa_email_body_greeting'] ?? 'Bonjour') . " " . htmlspecialchars($user['prenom'] . ' ' . $user['nom']) . ",\n\n"
                                   . ($lang['2fa_email_body_code_text'] ?? 'Votre code de vérification pour accéder à votre tableau de bord administrateur est :') . " " . htmlspecialchars($two_factor_code) . "\n\n"
                                   . ($lang['2fa_email_body_expiry_warning'] ?? 'Ce code est valide pendant 5 minutes.') . "\n"
                                   . ($lang['2fa_email_body_do_not_share'] ?? 'Ne partagez jamais ce code avec qui que ce soit.') . "\n\n"
                                   . ($lang['2fa_email_body_regards'] ?? 'Cordialement,') . "\nL'équipe ENSAO";

                    $mail->send();
                    $success_message = ($lang['2fa_code_sent_info'] ?? 'Un code de vérification a été envoyé à votre adresse e-mail. Veuillez le saisir sur la page suivante.');
                    $display_form = false; // Pour afficher le message d'info

                    // Rediriger vers la page de vérification 2FA par e-mail
                    header("Location: verify_2fa_email.php");
                    exit();

                } catch (Exception $e) {
                    error_log("Admin Login 2FA Email Error: " . $e->getMessage());
                    // Vider les sessions temporaires 2FA si l'email échoue pour éviter des boucles
                    unset($_SESSION['2fa_temp_user_id']);
                    unset($_SESSION['2fa_temp_user_email']);
                    unset($_SESSION['2fa_temp_user_first_name']);
                    unset($_SESSION['2fa_temp_user_last_name']);
                    unset($_SESSION['2fa_temp_user_role']);
                    unset($_SESSION['2fa_code']);
                    unset($_SESSION['2fa_code_expiry']);

                    $error_message = ($lang['2fa_email_send_failure'] ?? 'Échec de l\'envoi du code de vérification. Veuillez réessayer ou contacter l\'administrateur : ') . $mail->ErrorInfo;
                }

            } else {
                $error_message = $lang['login_invalid_credentials'] ?? 'Email ou mot de passe incorrect.';
            }
        } catch (PDOException $e) {
            error_log("Admin Login DB Error: " . $e->getMessage());
            $error_message = $lang['login_db_error'] ?? 'Une erreur est survenue lors de la connexion. Veuillez réessayer plus tard.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['admin_login_title'] ?? 'Connexion Administrateur') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f4f1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .login-container img {
            height: 80px;
            margin-bottom: 25px;
        }
        .login-container h2 {
            color: var(--primary);
            margin-bottom: 30px;
            font-weight: 700;
        }
        .form-floating label {
            color: #6c757d;
        }
        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.25rem rgba(var(--secondary-rgb), .25);
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 12px 0;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        .alert {
            margin-top: 20px;
        }
        .lang-switcher {
            margin-top: 20px;
            font-size: 0.9rem;
        }
        .lang-switcher a {
            color: var(--primary);
            text-decoration: none;
            margin: 0 5px;
        }
        .lang-switcher a:hover {
            text-decoration: underline;
        }
        /* Style pour l'accessibilité */
        body.daltonien-mode {
            filter: grayscale(100%);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="../assets/images/logo_ensao.png" alt="Logo ENSAO">
        
        <h2><?= htmlspecialchars($lang['admin_login_form_title'] ?? 'Connexion Administrateur') ?></h2>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($display_form): // Afficher le formulaire de login ?>
            <form action="admin_login.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="<?= htmlspecialchars($lang['email_placeholder'] ?? 'name@example.com') ?>" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <label for="email"><?= htmlspecialchars($lang['email_label'] ?? 'Adresse E-mail') ?></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="<?= htmlspecialchars($lang['password_placeholder'] ?? 'Mot de passe') ?>" required>
                    <label for="password"><?= htmlspecialchars($lang['password_label'] ?? 'Mot de passe') ?></label>
                </div>

                <p class="text-muted"><?= htmlspecialchars($lang['logging_in_as'] ?? 'Connexion en tant que') ?> : **<?= htmlspecialchars($lang['role_admin'] ?? 'Admin') ?>**</p>

                <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars($lang['login_button'] ?? 'Se connecter') ?></button>
            </form>

        <?php else: // Message d'information après l'envoi du code ?>
            <p>
                <?= htmlspecialchars($lang['2fa_code_sent_info'] ?? 'Un code de vérification a été envoyé à votre adresse e-mail. Veuillez le saisir sur la page suivante pour finaliser la connexion.') ?>
            </p>
            <p class="alert alert-info">
                <?= htmlspecialchars($lang['email_sent_spam_hint'] ?? 'Veuillez également vérifier votre dossier de spam/courrier indésirable si vous ne recevez pas l\'e-mail dans les minutes qui suivent.') ?>
            </p>
            <a href="verify_2fa_email.php" class="btn btn-primary">
                <?= htmlspecialchars($lang['go_to_verification_page'] ?? 'Aller à la page de vérification') ?>
            </a>
        <?php endif; ?>

        <div class="lang-switcher">
            <a href="?lang=fr">FR</a> |
            <a href="?lang=en">EN</a> |
            <a href="?lang=ar">AR</a>
        </div>
        <div class="mt-3">
            <button class="btn btn-sm btn-outline-secondary" id="daltonienModeToggle">
                <i class="bi bi-eye-slash"></i> <?= htmlspecialchars($lang['daltonian_mode'] ?? 'Mode Daltonien') ?>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mode Daltonien
            document.getElementById('daltonienModeToggle')?.addEventListener('click', function() {
                document.body.classList.toggle('daltonien-mode');
                const isDaltonien = document.body.classList.contains('daltonien-mode');
                localStorage.setItem('daltonienMode', isDaltonien);
            });

            if (localStorage.getItem('daltonienMode') === 'true') {
                document.body.classList.add('daltonien-mode');
            }
        });
    </script>
</body>
</html>