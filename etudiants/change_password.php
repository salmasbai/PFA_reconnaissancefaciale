<?php
session_start();
require_once '../includes/config.php'; // Connexion à la base de données
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// Vérifier si l'utilisateur est connecté et est un étudiant
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'etudiant') {
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
        try {
            // Récupérer le hachage du mot de passe actuel de l'utilisateur depuis la base de données
            $stmt = $pdo->prepare("SELECT password AS password_hash FROM utilisateurs WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier si l'utilisateur existe et si le mot de passe actuel est correct
            if ($user && password_verify($current_password, $user['password_hash'])) {
                // Hacher le nouveau mot de passe
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la base de données
                $update_stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                $update_stmt->execute([$new_password_hashed, $_SESSION['user_id']]);

                $message = $lang['change_password_success'] ?? 'Votre mot de passe a été changé avec succès.';
                $message_type = 'success';

                // Optionnel : Vous pouvez rediriger l'utilisateur après un succès pour éviter la resoumission du formulaire
                // header("Location: dashboard.php?message=" . urlencode($message) . "&type=" . $message_type);
                // exit();

            } else {
                $message = $lang['change_password_incorrect_current'] ?? 'L\'ancien mot de passe est incorrect.';
                $message_type = 'danger';
            }
        } catch (PDOException $e) {
            $message = $lang['login_db_error'] ?? 'Une erreur de base de données est survenue lors du changement de mot de passe.';
            $message_type = 'danger';
            error_log("Password change error for user ID " . $_SESSION['user_id'] . ": " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['change_password_title'] ?? 'Changer le mot de passe') ?></title>
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
        <h2 class="text-center mb-4"><?= htmlspecialchars($lang['change_password_title'] ?? 'Changer le mot de passe') ?></h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= htmlspecialchars($message_type) ?>" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="current_password" class="form-label"><?= htmlspecialchars($lang['current_password'] ?? 'Mot de passe actuel') ?></label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label"><?= htmlspecialchars($lang['new_password'] ?? 'Nouveau mot de passe') ?></label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label"><?= htmlspecialchars($lang['confirm_new_password'] ?? 'Confirmer le nouveau mot de passe') ?></label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars($lang['save_changes'] ?? 'Enregistrer les changements') ?></button>
        </form>
        <p class="text-center mt-3">
            <a href="dashboard.php"><?= htmlspecialchars($lang['back_to_dashboard'] ?? 'Retour au tableau de bord') ?></a>
        </p>
    </div>
</body>
</html>