<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme Absences ENSAO</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 60px;
            margin-right: 15px;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav li {
            margin-left: 2rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem;
            border-bottom: 2px solid transparent;
            transition: 0.3s;
        }

        nav a:hover {
            border-bottom: 2px solid var(--accent-color);
        }

        .main-content {
            text-align: center;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
        }

        h1::after {
            content: '';
            width: 80px;
            height: 3px;
            background: var(--accent-color);
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .auth-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .auth-box {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 300px;
            transition: 0.3s ease;
        }

        .auth-box:hover {
            transform: translateY(-5px);
        }

        .auth-box h2 {
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: var(--secondary-color);
            color: #fff;
            border: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: var(--primary-color);
        }

        footer {
            background: var(--dark-color);
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="assets/images/logo_ensao.png" alt="ENSAO Logo" class="logo">
                <h2>ENSAO</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="info.php">Informations</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="aide.php">Aide</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">
        <h1>Bienvenue sur la plateforme d'absences</h1>
        <p>Gérez facilement vos absences à l'ENSAO</p>
        <div class="auth-container">
            <div class="auth-box">
                <h2>Étudiant</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="email_etudiant">Email</label>
                        <input type="email" id="email_etudiant" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password_etudiant">Mot de passe</label>
                        <input type="password" id="password_etudiant" name="password" required>
                    </div>
                    <input type="hidden" name="role" value="etudiant">
                    <button type="submit">Se connecter</button>
                </form>
            </div>
            <div class="auth-box">
                <h2>Professeur</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="email_prof">Email</label>
                        <input type="email" id="email_prof" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password_prof">Mot de passe</label>
                        <input type="password" id="password_prof" name="password" required>
                    </div>
                    <input type="hidden" name="role" value="professeur">
                    <button type="submit">Se connecter</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> ENSAO - Tous droits réservés</p>
    </footer>
</body>
</html>
