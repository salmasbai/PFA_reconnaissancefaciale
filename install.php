<?php
require_once __DIR__ . '/includes/config.php';

try {
    // Création des tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','professeur','etudiant') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    // [Ajouter les autres tables ici...]

    // Création d'un admin par défaut
    $password = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->exec("INSERT IGNORE INTO utilisateurs 
        (nom, prenom, email, password, role) VALUES
        ('Admin', 'System', 'admin@ensao.ma', '$password', 'admin')");

    echo "Installation réussie !";
} catch (PDOException $e) {
    die("Erreur d'installation : " . $e->getMessage());
}
?>