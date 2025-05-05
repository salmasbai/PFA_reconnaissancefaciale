<?php
require_once 'includes/config.php';
echo "<h1>Test de connexion</h1>";
$stmt = $pdo->query("SHOW TABLES");
echo "<p>Connexion réussie. Tables existantes :</p>";
while ($row = $stmt->fetch()) {
    echo "<li>" . $row[0] . "</li>";
}
?>