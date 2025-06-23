<?php require_once '../includes/config.php'; ?>
<?php session_start(); ?>

<?php
// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $type = $_POST['role'];

        try {
            if ($type === 'etudiant') {
                $stmt = $conn->prepare("SELECT * FROM etudiants WHERE email = ?");
            } elseif ($type === 'professeur') {
                $stmt = $conn->prepare("SELECT * FROM professeurs WHERE email = ?");
            } elseif ($type === 'admin') {
                $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ? AND role = 'admin'");
            } else {
                $error = "Type d'utilisateur invalide.";
            }

            if (!isset($error)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows === 1) {
                    $user = $result->fetch_assoc();

                    if (password_verify($password, $user['mot_de_passe'])) {
                        $_SESSION['user'] = $user;
                        $_SESSION['user']['role'] = $type;

                        if ($type === 'etudiant') {
                            header("Location: ../etudiant/dashboard.php");
                        } elseif ($type === 'professeur') {
                            header("Location: ../professeur/dashboard.php");
                        } else {
                            header("Location: ../admin/dashboard.php");
                        }
                        exit();
                    } else {
                        $error = "Mot de passe incorrect.";
                    }
                } else {
                    $error = "Utilisateur introuvable.";
                }
            }
        } catch (Exception $e) {
            $error = "Erreur : " . $e->getMessage();
        } finally {
            if (isset($stmt)) $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - PFA_PROJECT_TEST1</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7fc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            margin-bottom: 1.5rem;
            color: #2c3e50;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 1rem;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 0.7rem;
            margin-top: 0.3rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 1.5rem;
            padding: 0.8rem;
            width: 100%;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error {
            background: #fce4e4;
            color: #d32f2f;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Connexion</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="email">Adresse email :</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Rôle :</label>
        <select name="role" id="role" required>
            <option value="">-- Choisir un rôle --</option>
            <option value="etudiant">Étudiant</option>
            <option value="professeur">Professeur</option>
            <option value="admin">Administrateur</option>
        </select>

        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
