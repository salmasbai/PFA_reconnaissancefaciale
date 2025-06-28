<?php
session_start();
require_once '../includes/config.php'; // Connexion à la base de données

// Adaptation pour compatibilité PHP < 7.0
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/" . $lang_code . ".php"; // Utilisation de la concaténation

// Vérifier si l'utilisateur est connecté. Si non, rediriger vers la page de connexion.
// login.php est dans le même dossier 'authentification'
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';
$message_type = ''; // 'success' ou 'danger'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_new_password = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : '';

    // 1. Validation des champs vides
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $message = isset($lang['change_password_empty_fields']) ? $lang['change_password_empty_fields'] : 'Veuillez remplir tous les champs.';
        $message_type = 'danger';
    }
    // 2. Vérification de la correspondance des nouveaux mots de passe
    elseif ($new_password !== $confirm_new_password) {
        $message = isset($lang['change_password_mismatch']) ? $lang['change_password_mismatch'] : 'Les nouveaux mots de passe ne correspondent pas.';
        $message_type = 'danger';
    }
    // 3. Vérification de la complexité du nouveau mot de passe (Exemple : longueur min 6 caractères)
    elseif (strlen($new_password) < 6) {
        $message = isset($lang['change_password_short']) ? $lang['change_password_short'] : 'Le nouveau mot de passe doit contenir au moins 6 caractères.';
        $message_type = 'danger';
    }
    else {
        try {
            // Récupérer le hachage du mot de passe actuel de l'utilisateur depuis la base de données
            $stmt = $pdo->prepare("SELECT password AS password_hash FROM utilisateurs WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier si l'utilisateur existe et si le mot de passe actuel est correct
            if ($user && password_verify($current_password, $user['password_hash'])) {
                // Hacher le nouveau mot de passe
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT); // password_hash() nécessite PHP >= 5.5

                // Mettre à jour le mot de passe dans la base de données
                $update_stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                $update_stmt->execute([$new_password_hashed, $_SESSION['user_id']]);

                // --- MODIFICATION ICI : Redirection vers la page de connexion avec un message de succès ---
                // Détruire la session actuelle pour forcer une nouvelle connexion avec le nouveau mot de passe
                session_destroy();
                // Il est recommandé de démarrer une nouvelle session ici pour pouvoir stocker un message $_SESSION
                // Cependant, pour un message dans l'URL (qui est souvent préféré pour les redirections immédiates),
                // session_start() n'est pas strictement nécessaire après session_destroy() si vous n'ajoutez rien à $_SESSION.
                // Si vous voulez être 100% sûr d'avoir une nouvelle session propre pour de futurs messages basés sur $_SESSION:
                session_start();

                // Redirige vers login.php avec un message de succès
                header("Location: login.php?message_type=success&message=" . urlencode(isset($lang['password_change_success_login']) ? $lang['password_change_success_login'] : 'Votre mot de passe a été changé avec succès. Veuillez vous connecter avec le nouveau mot de passe.'));
                exit();

            } else {
                $message = isset($lang['change_password_incorrect_current']) ? $lang['change_password_incorrect_current'] : 'L\'ancien mot de passe est incorrect.';
                $message_type = 'danger';
            }
        } catch (PDOException $e) {
            $message = isset($lang['login_db_error']) ? $lang['login_db_error'] : 'Une erreur de base de données est survenue lors du changement de mot de passe.';
            $message_type = 'danger';
            error_log("Password change error for user ID " . $_SESSION['user_id'] . ": " . $e->getMessage());
        }
    }
}

// REMOVED: La détermination de $dashboard_url est supprimée car nous redirigeons systématiquement.
// Note: $lang_code est toujours disponible car il est défini en début de fichier.
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars(isset($lang['change_password_title']) ? $lang['change_password_title'] : 'Changer le mot de passe') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
        }
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f4f1;
        }
        .container-sm {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="container-sm">
        <h2 class="text-center mb-4"><?= htmlspecialchars(isset($lang['change_password_title']) ? $lang['change_password_title'] : 'Changer le mot de passe') ?></h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= htmlspecialchars($message_type) ?>" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="current_password" class="form-label"><?= htmlspecialchars(isset($lang['current_password']) ? $lang['current_password'] : 'Mot de passe actuel') ?></label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label"><?= htmlspecialchars(isset($lang['new_password']) ? $lang['new_password'] : 'Nouveau mot de passe') ?></label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label"><?= htmlspecialchars(isset($lang['confirm_new_password']) ? $lang['confirm_new_password'] : 'Confirmer le nouveau mot de passe') ?></label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars(isset($lang['save_changes']) ? $lang['save_changes'] : 'Enregistrer les changements') ?></button>
        </form>
        </div>
</body>
</html>