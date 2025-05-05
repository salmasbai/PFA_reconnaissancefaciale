<?php
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

// Vérification des rôles si nécessaire
$allowedRoles = ['admin', 'professeur', 'etudiant'];
if (isset($requiredRole) && !in_array($_SESSION['user']['role'], $allowedRoles)) {
    header('HTTP/1.0 403 Forbidden');
    die("Accès interdit");
}
?>