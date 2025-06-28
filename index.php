<?php
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
// Changement pour compatibilité PHP < 7.0
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once 'includes/config.php';
require_once "lang/" . $lang_code . ".php"; // Utilisation de la concaténation
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ENSAO – <?= htmlspecialchars(isset($lang['title']) ? $lang['title'] : 'Titre par défaut') ?></title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #8c5a2b;
      --secondary: #cfa37b;
      --accent: #b3874c;
    }
    body {
      font-family: 'Roboto', sans-serif;
      scroll-behavior: smooth;
      color: #000;
      padding-top: 70px; /* pour navbar fixed */
    }
    .navbar-brand img {
      height: 48px;
      margin-right: .5rem;
    }
    .navbar-nav .nav-link {
      color: #000;
      font-weight: 500;
    }
    .navbar-nav .nav-link.active {
      color: var(--primary) !important;
    }
    .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    .btn-primary:hover {
      background-color: var(--accent);
      border-color: var(--accent);
    }
    .btn-outline-primary {
      color: var(--primary);
      border-color: var(--primary);
    }
    .btn-outline-primary:hover {
      background-color: var(--primary);
      color: #fff;
    }
    .hero {
      padding: 7rem 0 3rem;
      background: #f9f4f1;
      position: relative;
      overflow: hidden;
      text-align: center;
    }
    .hero h1 {
      font-size: 2.75rem;
      font-weight: 700;
      line-height: 1.2;
    }
    .hero p.lead {
      font-size: 1.25rem;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 1.5rem;
    }
    .carousel-caption {
      background: rgba(0, 0, 0, 0.55);
      border-radius: 8px;
      padding: 0.5rem 1rem;
      animation: fadeInUp 1s ease-in-out;
    }
    .carousel-fade .carousel-item {
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }
    .carousel-fade .carousel-item.active {
      opacity: 1;
    }
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    footer {
      background: var(--primary);
      color: #fff;
      padding: 1.5rem 0;
      text-align: center;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="assets/images/logo_ensao.png" alt="Logo ENSAO" />
      <span class="fw-bold">ENSAO</span>
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#mainNav"
      aria-controls="mainNav"
      aria-expanded="false"
      aria-label="Basculer la navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#"><?= htmlspecialchars(isset($lang['home']) ? $lang['home'] : 'Accueil') ?></a></li> <li class="nav-item"><a class="nav-link" href="#features"><?= htmlspecialchars(isset($lang['features']) ? $lang['features'] : 'Fonctionnalités') ?></a></li> <li class="nav-item"><a class="nav-link" href="#integrations"><?= htmlspecialchars(isset($lang['integrations']) ? $lang['integrations'] : 'Intégrations') ?></a></li> <li class="nav-item"><a class="nav-link" href="#resources"><?= htmlspecialchars(isset($lang['resources']) ? $lang['resources'] : 'Ressources') ?></a></li> </ul>

      <div class="d-flex align-items-center gap-3">
        <a href="#" class="text-dark fs-5"><i class="bi bi-search"></i></a>

        <form id="searchForm" class="d-none ms-2" method="get" action="recherche.php">
        <input type="text" name="q" class="form-control" placeholder="Rechercher..." />
      </form>

        <div class="dropdown">
          <a
            class="dropdown-toggle text-dark text-decoration-none"
            href="#"
            id="langDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          ><?= htmlspecialchars(strtoupper($lang_code)) ?></a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
            <li><a class="dropdown-item" href="?lang=fr">FR – Français</a></li>
            <li><a class="dropdown-item" href="?lang=en">EN – English</a></li>
            <li><a class="dropdown-item" href="?lang=ar">AR – العربية</a></li>
          </ul>
        </div>

        <div class="nav-item">
          <a
            class="btn btn-outline-primary"
            href="authentification/login.php" ><?= htmlspecialchars(isset($lang['login']) ? $lang['login'] : 'Connexion') ?></a> </div>
        </div>
    </div>
  </div>
</nav>

<section class="hero d-flex flex-column align-items-center text-center" id="hero">
  <div class="container">
    <h1 class="mb-3"><?= htmlspecialchars(isset($lang['title']) ? $lang['title'] : 'Titre par défaut') ?></h1> <p class="lead mb-4"><?= htmlspecialchars(isset($lang['subtitle']) ? $lang['subtitle'] : 'Sous-titre par défaut') ?></p> <a href="authentification/login.php" class="btn btn-primary btn-lg me-2 mb-4"><?= htmlspecialchars(isset($lang['start_button']) ? $lang['start_button'] : 'Commencez maintenant') ?></a> <div
      id="carouselENSAO"
      class="carousel slide carousel-fade w-100"
      data-bs-ride="carousel"
      data-bs-interval="5000"
    >
      <div class="carousel-inner rounded-3 shadow">
        <div class="carousel-item active">
          <img
            src="assets/images/campus_ensao.png"
            class="d-block w-100"
            alt="<?= htmlspecialchars(isset($lang['carousel_1']) ? $lang['carousel_1'] : 'Campus ENSAO') ?>" />
          <div class="carousel-caption d-none d-md-block">
            <h5><?= htmlspecialchars(isset($lang['carousel_1']) ? $lang['carousel_1'] : 'Campus ENSAO') ?></h5> </div>
        </div>
        <div class="carousel-item">
          <img
            src="assets/images/etudiants_conference.png"
            class="d-block w-100"
            alt="<?= htmlspecialchars(isset($lang['carousel_2']) ? $lang['carousel_2'] : 'Étudiants en conférence') ?>" />
          <div class="carousel-caption d-none d-md-block">
            <h5><?= htmlspecialchars(isset($lang['carousel_2']) ? $lang['carousel_2'] : 'Étudiants en conférence') ?></h5> </div>
        </div>
      </div>

      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselENSAO"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden"><?= htmlspecialchars(isset($lang['previous']) ? $lang['previous'] : 'Précédent') ?></span> </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselENSAO"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden"><?= htmlspecialchars(isset($lang['next']) ? $lang['next'] : 'Suivant') ?></span> </button>
    </div>
  </div>
</section>

<section class="py-5" id="features">
  <div class="container">
    <h2 class="text-center mb-4"><?= htmlspecialchars(isset($lang['features']) ? $lang['features'] : 'Fonctionnalités') ?></h2> <div class="row g-4">
      <div class="col-md-4">
        <h4><?= htmlspecialchars(isset($lang['feature1_title']) ? $lang['feature1_title'] : 'Titre Fonctionnalité 1') ?></h4> <p><?= htmlspecialchars(isset($lang['feature1_desc']) ? $lang['feature1_desc'] : 'Description Fonctionnalité 1') ?></p> </div>
      <div class="col-md-4">
        <h4><?= htmlspecialchars(isset($lang['feature2_title']) ? $lang['feature2_title'] : 'Titre Fonctionnalité 2') ?></h4> <p><?= htmlspecialchars(isset($lang['feature2_desc']) ? $lang['feature2_desc'] : 'Description Fonctionnalité 2') ?></p> </div>
      <div class="col-md-4">
        <h4><?= htmlspecialchars(isset($lang['feature3_title']) ? $lang['feature3_title'] : 'Titre Fonctionnalité 3') ?></h4> <p><?= htmlspecialchars(isset($lang['feature3_desc']) ? $lang['feature3_desc'] : 'Description Fonctionnalité 3') ?></p> </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light" id="integrations">
  <div class="container">
    <h2 class="text-center mb-4"><?= htmlspecialchars(isset($lang['integrations']) ? $lang['integrations'] : 'Intégrations') ?></h2> <div class="row g-4 text-center">

    <div class="col-md-3 text-center">
      <img src="assets/images/logo_ia.png" alt="Intelligence Artificielle" class="img-fluid mb-2" style="width: 100px;">
    </div>


      <div class="col-md-3">
        <img src="assets/images/logo_bootstrap.png" alt="Bootstrap" class="img-fluid" style="max-height:80px" />
      </div>
      <div class="col-md-3">
        <img src="assets/images/logo_php.png" alt="PHP" class="img-fluid" style="max-height:80px" />
      </div>
      <div class="col-md-3">
        <img src="assets/images/logo_mysql.png" alt="MySQL" class="img-fluid" style="max-height:80px" />
      </div>
      <div class="col-md-12 d-flex justify-content-center">
        <div class="text-center">
          <img src="assets/images/logo_face_recognition.png" alt="Reconnaissance Faciale" class="img-fluid mb-2" style="width: 100px;">
        </div>
      </div>

    </div>
  </div>
</section>

<section class="py-5" id="resources">
  <div class="container">
    <h2 class="text-center mb-4"><?= htmlspecialchars(isset($lang['resources']) ? $lang['resources'] : 'Ressources') ?></h2> <div class="row">
      <div class="col-md-6">
        <h5><?= htmlspecialchars(isset($lang['resources_docs_title']) ? $lang['resources_docs_title'] : 'Documentation') ?></h5> <ul>
          <li><a href="#"><?= htmlspecialchars(isset($lang['resources_docs_item1']) ? $lang['resources_docs_item1'] : 'Guide de démarrage') ?></a></li> <li><a href="#"><?= htmlspecialchars(isset($lang['resources_docs_item2']) ? $lang['resources_docs_item2'] : 'Référence API') ?></a></li> <li><a href="#"><?= htmlspecialchars(isset($lang['resources_docs_item3']) ? $lang['resources_docs_item3'] : 'FAQ') ?></a></li> </ul>
      </div>
      <div class="col-md-6">
        <h5><?= htmlspecialchars(isset($lang['resources_support_title']) ? $lang['resources_support_title'] : 'Support') ?></h5> <ul>
          <li><a href="#"><?= htmlspecialchars(isset($lang['resources_support_item1']) ? $lang['resources_support_item1'] : 'Contactez-nous') ?></a></li> <li><a href="#"><?= htmlspecialchars(isset($lang['resources_support_item2']) ? $lang['resources_support_item2'] : 'Forum') ?></a></li> <li><a href="#"><?= htmlspecialchars(isset($lang['resources_support_item3']) ? $lang['resources_support_item3'] : 'Tutoriels') ?></a></li> </ul>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <small>&copy; <?= date('Y') ?> ENSAO - Tous droits réservés</small>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>