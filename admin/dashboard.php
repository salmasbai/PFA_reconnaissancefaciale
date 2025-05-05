<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/header.php';
?>

<div class="main-content">
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?> 👋</h1>
    <p>Vous êtes connecté en tant que <strong><?= htmlspecialchars($_SESSION['role']) ?></strong>.</p>
    <a href="logout.php">Se déconnecter</a>
</div>

<?php require_once '../includes/footer.php'; ?>
