<?php
session_start();
require_once '../includes/config.php'; // Connexion PDO

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    // Le rôle n'est plus récupéré du POST, il sera déterminé implicitement

    if (empty($email) || empty($password)) { // Validation simplifiée, plus de rôle à valider ici
        $error_message = "L'adresse email et le mot de passe sont obligatoires.";
    } else {
        try {
            // Requête modifiée : Ne filtre plus par 'role' dans la clause WHERE
            $stmt = $pdo->prepare("SELECT id, email, password AS password_hash, nom, prenom, role FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification des identifiants et du rôle
            if ($user && password_verify($password, $user['password_hash'])) {
                // Les informations de session, y compris le rôle, sont stockées APRES validation
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_first_name'] = $user['prenom'];
                $_SESSION['user_last_name'] = $user['nom'];
                $_SESSION['user_role'] = $user['role']; // Le rôle est pris directement de la BDD

                // Si c'est un étudiant, récupérer les détails supplémentaires de la table etudiants
                if ($user['role'] === 'etudiant') {
                    $stmt_details = $pdo->prepare("SELECT numero_etudiant, filiere_id, cycle, photo_path, numero_apogee, code_massar, classe_id FROM etudiants WHERE user_id = ?");
                    $stmt_details->execute([$user['id']]);
                    $student_details = $stmt_details->fetch(PDO::FETCH_ASSOC);

                    if ($student_details) {
                        $_SESSION['student_numero_etudiant'] = $student_details['numero_etudiant'];
                        $_SESSION['student_filiere_id'] = $student_details['filiere_id'];
                        $_SESSION['student_cycle'] = $student_details['cycle'];
                        $_SESSION['student_photo_path'] = $student_details['photo_path'];
                        $_SESSION['student_numero_apogee'] = $student_details['numero_apogee'];
                        $_SESSION['student_code_massar'] = $student_details['code_massar'];
                        $_SESSION['student_classe_id'] = $student_details['classe_id'];

                        if ($student_details['filiere_id']) {
                            $stmt_filiere_name = $pdo->prepare("SELECT nom_filiere FROM filieres WHERE id = ?");
                            $stmt_filiere_name->execute([$student_details['filiere_id']]);
                            $filiere_name = $stmt_filiere_name->fetchColumn();
                            $_SESSION['student_filiere_name'] = isset($filiere_name) ? $filiere_name : null;
                        } else {
                            $_SESSION['student_filiere_name'] = null;
                        }

                        if ($student_details['classe_id']) {
                            $stmt_classe_name = $pdo->prepare("SELECT nom_classe FROM classes WHERE id = ?");
                            $stmt_classe_name->execute([$student_details['classe_id']]);
                            $classe_name = $stmt_classe_name->fetchColumn();
                            $_SESSION['user_class'] = (isset($classe_name) ? $classe_name : '') . ' - ' . (isset($student_details['cycle']) ? $student_details['cycle'] : '');
                        } else {
                            $_SESSION['user_class'] = isset($student_details['cycle']) ? $student_details['cycle'] : null;
                        }
                    }
                }

                // --- Logique de redirection améliorée (VERS LE DASHBOARD) ---
                $redirect_url = '';
                if (isset($_SESSION['redirect_to']) && !empty($_SESSION['redirect_to'])) {
                    $redirect_url = $_SESSION['redirect_to'];
                    unset($_SESSION['redirect_to']); // Supprime l'URL de redirection de la session
                } else {
                    // Rediriger vers le dashboard par défaut pour chaque rôle
                    if ($user['role'] === 'etudiant') {
                        $redirect_url = '../etudiants/dashboard.php';
                    } elseif ($user['role'] === 'professeur') {
                        $redirect_url = '../professeurs/gestion_absences.php'; // Ou dashboard.php si c'est la page par défaut
                    } elseif ($user['role'] === 'admin') {
                        $redirect_url = '../admin/dashboard.php';
                    } else {
                        // Si le rôle n'est pas reconnu ou non géré, rediriger vers login avec un message
                        $redirect_url = 'login.php?message_type=danger&message=' . urlencode("Rôle utilisateur non reconnu. Veuillez contacter l'administrateur.");
                    }
                }
                header("Location: " . $redirect_url);
                exit();

            } else {
                $error_message = "Email ou mot de passe incorrect."; // Message plus générique pour la sécurité
            }
        } catch (PDOException $e) {
            $error_message = "Erreur de base de données : " . $e->getMessage();
            error_log("Login error: " . $e->getMessage());
        }
    }
}

$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/" . $lang_code . ".php"; // Fichier de langue
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars(isset($lang_code) ? $lang_code : 'fr') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars(isset($lang['login']) ? $lang['login'] : 'Connexion') ?></title>
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
        .login-box {
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
        .alert-success { /* Style pour les messages de succès */
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
    <h2><?= htmlspecialchars(isset($lang['login']) ? $lang['login'] : 'Connexion') ?></h2>
    <?php
    // Affichage des messages de succès ou d'erreur, y compris ceux passés par l'URL
    $display_message = '';
    $display_message_type = 'danger'; // Par défaut en danger pour error_message

    if (!empty($error_message)) {
        $display_message = $error_message;
    } elseif (isset($_GET['message']) && !empty($_GET['message'])) {
        $display_message = htmlspecialchars($_GET['message']);
        $display_message_type = isset($_GET['message_type']) ? htmlspecialchars($_GET['message_type']) : 'info'; // Par défaut 'info' si non spécifié
    }

    if (!empty($display_message)):
    ?>
        <div class="alert alert-<?= $display_message_type ?>" role="alert">
            <?= $display_message ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label"><?= htmlspecialchars(isset($lang['email']) ? $lang['email'] : 'Adresse email') ?> :</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : '') ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label"><?= htmlspecialchars(isset($lang['password']) ? $lang['password'] : 'Mot de passe') ?> :</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit"><?= htmlspecialchars(isset($lang['login_button']) ? $lang['login_button'] : 'Se connecter') ?></button>
    </form>
    <p>
        <a href="forgot_password.php"><?= htmlspecialchars(isset($lang['forgot_password']) ? $lang['forgot_password'] : 'Mot de passe oublié ?') ?></a>
    </p>
</div>
</body>
</html>