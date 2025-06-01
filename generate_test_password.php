<?php
// generate_test_password.php

// ----------------------------------------------------------------------
// CHOISISSEZ UN MOT DE PASSE EN CLAIR FACILE À RETENIR POUR LE TEST !
// Par exemple : 'TestPassword123'
$mot_de_passe_clair_pour_le_test = 'TestPassword123';
// ----------------------------------------------------------------------

$mot_de_passe_hache_a_copier = password_hash($mot_de_passe_clair_pour_le_test, PASSWORD_DEFAULT);

echo "<h1>Générateur de Mot de Passe de Test</h1>";
echo "<p>Ceci est une page temporaire pour le débogage. Ne pas utiliser en production.</p>";
echo "<hr>";

echo "<h3>Mot de passe en clair à utiliser pour la connexion :</h3>";
echo "<strong>" . htmlspecialchars($mot_de_passe_clair_pour_le_test) . "</strong>";
echo "<p>(Copiez/Saisissez ce mot de passe exactement dans le formulaire de connexion)</p>";

echo "<h3>Hachage à copier-coller dans votre base de données (colonne 'password' de la table 'utilisateurs') :</h3>";
echo "<strong>" . htmlspecialchars($mot_de_passe_hache_a_copier) . "</strong>";
echo "<p>(Ceci est le long texte que vous allez coller dans PHPMyAdmin)</p>";

echo "<hr>";
echo "<p>Supprimez ce fichier une fois le débogage terminé.</p>";
?>