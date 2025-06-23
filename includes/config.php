<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_etudiants');
define('DB_USER', 'root');
define('DB_PASS', ''); // Mot de passe vide par défaut avec XAMPP

// Connexion PDO
try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', // <-- Changer ici
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Configuration de sécurité
/*session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // À activer uniquement en HTTPS
ini_set('session.use_strict_mode', 1);
ini_set('session.sid_length', 128);
ini_set('session.hash_function', 'sha256');*/

// Configuration des chemins
define('BASE_URL', 'http://localhost:8080/PFA_project_TEST1/');  
define('UPLOAD_DIR', realpath(__DIR__ . '/../uploads/etudiants/') . DIRECTORY_SEPARATOR);

// Protection contre les attaques XSS
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
?>