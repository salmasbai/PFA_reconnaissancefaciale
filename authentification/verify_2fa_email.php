<?php
session_start();
require_once '../includes/config.php'; // Connexion à la base de données

$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

$error_message = '';

// Protection : S'assurer que l'utilisateur est "en attente" de 2FA par email
// Ces sessions sont définies dans admin_login.php après la saisie du mot de passe
if (!isset($_SESSION['2fa_temp_user_id']) || $_SESSION['2fa_temp_user_role'] !== 'admin' || !isset($_SESSION['2fa_code']) || !isset($_SESSION['2fa_code_expiry'])) {
    // Si la session 2FA n'est pas en attente ou n'est pas pour un admin, rediriger vers la connexion admin
    header("Location: admin_login.php?message_type=danger&message=" . urlencode($lang['2fa_access_denied'] ?? 'Accès refusé. Veuillez vous reconnecter.'));
    exit();
}

// Vérifier si le code a expiré
if (time() > $_SESSION['2fa_code_expiry']) {
    session_unset(); // Nettoyer toutes les variables de session
    session_destroy(); // Détruire la session
    header("Location: admin_login.php?message_type=danger&message=" . urlencode($lang['2fa_code_expired'] ?? 'Le code de vérification a expiré. Veuillez vous reconnecter.'));
    exit();
}

$user_email_display = $_SESSION['2fa_temp_user_email']; // Pour l'affichage

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = trim($_POST['code'] ?? '');

    if (empty($entered_code)) {
        $error_message = $lang['2fa_code_required'] ?? 'Veuillez entrer le code de vérification.';
    } elseif ($entered_code === $_SESSION['2fa_code']) {
        // Code correct. Finaliser la connexion.
        // Transférer les infos de session temporaires vers les sessions permanentes
        $_SESSION['user_id'] = $_SESSION['2fa_temp_user_id'];
        $_SESSION['user_email'] = $_SESSION['2fa_temp_user_email'];
        $_SESSION['user_first_name'] = $_SESSION['2fa_temp_user_first_name'];
        $_SESSION['user_last_name'] = $_SESSION['2fa_temp_user_last_name'];
        $_SESSION['user_role'] = $_SESSION['2fa_temp_user_role'];

        // Nettoyer les variables de session temporaires de 2FA
        unset($_SESSION['2fa_temp_user_id']);
        unset($_SESSION['2fa_temp_user_email']);
        unset($_SESSION['2fa_temp_user_first_name']);
        unset($_SESSION['2fa_temp_user_last_name']);
        unset($_SESSION['2fa_temp_user_role']);
        unset($_SESSION['2fa_code']);
        unset($_SESSION['2fa_code_expiry']);

        // Rediriger vers le tableau de bord admin
        $redirect_to_dashboard = '../admin/dashboard.php';

        // Si une URL de redirection était stockée avant le processus 2FA, elle est prioritaire
        if (isset($_SESSION['redirect_to']) && !empty($_SESSION['redirect_to'])) {
            $redirect_to_dashboard = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
        }

        header("Location: " . $redirect_to_dashboard);
        exit();

    } else {
        $error_message = $lang['2fa_code_invalid'] ?? 'Code de vérification invalide. Veuillez réessayer.';
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['2fa_email_verify_title'] ?? 'Vérification 2FA par E-mail') ?></title>
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
        .verify-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .verify-container img.logo {
            height: 70px;
            margin-bottom: 25px;
        }
        .verify-container h2 {
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
        /* Style pour l'accessibilité */
        body.daltonien-mode {
            filter: grayscale(100%);
        }
    </style>
</head>
<body>

    <div class="verify-container">
        <img src="../assets/images/logo_ensao.png" alt="Logo ENSAO" class="logo">
        <h2><?= htmlspecialchars($lang['2fa_email_verify_heading'] ?? 'Vérification à Deux Étapes') ?></h2>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>
        <p class="mb-4">
            <?= htmlspecialchars($lang['2fa_email_verify_instructions1'] ?? 'Un code de vérification a été envoyé à') ?>
            <strong><?= htmlspecialchars($user_email_display) ?></strong>.
            <?= htmlspecialchars($lang['2fa_email_verify_instructions2'] ?? 'Veuillez le saisir ci-dessous.') ?>
        </p>
        <p class="mb-4 text-muted small">
            <?= htmlspecialchars($lang['2fa_code_expiry_info'] ?? 'Le code est valide pendant 5 minutes.') ?>
        </p>

        <form action="verify_2fa_email.php" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="code" name="code" placeholder="<?= htmlspecialchars($lang['2fa_code_placeholder'] ?? 'Code de vérification') ?>" required pattern="[0-9]{6}">
                <label for="code"><?= htmlspecialchars($lang['2fa_code_label'] ?? 'Code à 6 chiffres') ?></label>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-shield-check me-2"></i> <?= htmlspecialchars($lang['verify_code'] ?? 'Vérifier le Code') ?>
            </button>
        </form>

        <div class="mt-3">
            <a href="../authentification/logout.php" class="btn btn-link text-danger"><?= htmlspecialchars($lang['logout'] ?? 'Déconnexion') ?></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mode Daltonien (à inclure si la page utilise ce style)
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