<?php
// Démarrer la session si besoin
session_start();
$lang = "fr"; // tu pourras plus tard le détecter dynamiquement
?>

<?php include('includes/header.php'); ?> 

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand" href="#">Reconnaissance Faciale</a>
  <button class="btn btn-outline-light ms-auto toggle-dark"><i class="bi bi-moon-fill"></i></button>
</nav>
<header class="container text-center mt-5">
  <h1 class="display-4">Bienvenue sur le système de présence intelligente</h1>
  <p class="lead">Une solution rapide, sécurisée et intelligente pour l'enregistrement des absences.</p>
  <div class="mt-4">
    <a href="/etudiants/dashboard.php" class="btn btn-primary btn-lg mx-2">Espace Étudiant</a>
    <a href="/professeurs/dashboard.php" class="btn btn-success btn-lg mx-2">Espace Professeur</a>
    <a href="/admin/dashboard.php" class="btn btn-warning btn-lg mx-2">Espace Admin</a>
  </div>
</header>

<section class="container mt-5">
  <h2 class="text-center mb-4">Fonctionnalités Clés</h2>
  <div class="row text-center">
    <div class="col-md-4">
      <i class="bi bi-camera-video-fill fs-1 text-primary"></i>
      <h4>Détection en Temps Réel</h4>
      <p>Grâce à YOLO et FaceNet, les visages sont détectés et identifiés instantanément.</p>
    </div>
    <div class="col-md-4">
      <i class="bi bi-shield-lock-fill fs-1 text-success"></i>
      <h4>Sécurité Avancée</h4>
      <p>Authentification avec vérification de vivacité (liveness) et conformité RGPD.</p>
    </div>
    <div class="col-md-4">
      <i class="bi bi-bar-chart-fill fs-1 text-warning"></i>
      <h4>Dashboard Analytique</h4>
      <p>Visualisez les absences en temps réel avec tableaux et graphiques intégrés.</p>
    </div>
  </div>
</section>

<footer class="bg-dark text-center text-white p-3 mt-5">
  © 2025 Reconnaissance Faciale | Projet PFA
</footer>

<!-- JS + Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.querySelector('.toggle-dark').addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
  });
</script>

<style>
  body.dark-mode {
    background-color: #121212;
    color: white;
  }
</style>

</body>
</html>
