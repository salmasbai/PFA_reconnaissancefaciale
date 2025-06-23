<?php
session_start();
require_once '../includes/config.php'; // Connexion à la base de données
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        $error_message = $lang['login_empty_fields'] ?? 'Veuillez remplir tous les champs.';
    } else {
        try {
            // **MODIFICATION CLÉ ICI : u.role = 'professeur'**
            $stmt = $pdo->prepare("SELECT u.id, u.email, u.password AS password_hash, u.nom AS last_name, u.prenom AS first_name, u.role,
                                           p.specialite
                                   FROM utilisateurs u
                                   LEFT JOIN professeurs p ON u.id = p.user_id
                                   WHERE u.email = ? AND u.role = 'professeur'"); // <-- Rôle spécifique au professeur
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Authentification réussie
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_first_name'] = $user['first_name'];
                $_SESSION['user_last_name'] = $user['last_name'];
                $_SESSION['user_role'] = $user['role'];

                // Informations spécifiques au professeur
                $_SESSION['teacher_speciality'] = $user['specialite'];

                header("Location: dashboard.php"); // Redirection vers le tableau de bord du professeur
                exit();
            } else {
                $error_message = $lang['login_invalid_credentials'] ?? 'Email ou mot de passe incorrect.';
            }
        } catch (PDOException $e) {
            $error_message = $lang['login_db_error'] ?? 'Une erreur de base de données est survenue.';
            error_log("Login error (teacher): " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['login_teacher'] ?? 'Connexion Professeur') ?></title>
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
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
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
    <div class="login-container">
        <h2 class="text-center mb-4"><?= htmlspecialchars($lang['login_teacher'] ?? 'Connexion Professeur') ?></h2>
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label"><?= htmlspecialchars($lang['email_academic'] ?? 'Email Académique') ?></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><?= htmlspecialchars($lang['password'] ?? 'Mot de passe') ?></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars($lang['login'] ?? 'Se connecter') ?></button>
        </form>
        <p class="text-center mt-3">
            <a href="#"><?= htmlspecialchars($lang['forgot_password'] ?? 'Mot de passe oublié ?') ?></a>
        </p>
        <p class="text-center mt-2">
            <a href="change_password.php"><?= htmlspecialchars($lang['change_initial_password'] ?? 'Changer mon mot de passe initial') ?></a>
        </p>
    </div>
</body>
</html>