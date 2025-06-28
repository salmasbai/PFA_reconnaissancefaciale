<?php
session_start();
require_once '../includes/config.php';
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// Vérifier si l'utilisateur est connecté et est un professeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: ../authentification/login.php");
    exit();
}

$prof_user_id = $_SESSION['user_id'];
$message = '';
$selected_classe_id = isset($_POST['classe_id']) ? intval($_POST['classe_id']) : (isset($_GET['classe_id']) ? intval($_GET['classe_id']) : '');
$emploi_du_temps_data = [];
$prof_full_name = $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];

// Récupération des classes AUQUELLES CE PROFESSEUR EST ASSIGNÉ
$classes = [];
try {
    $stmt_classes = $pdo->prepare("
        SELECT DISTINCT c.id, c.nom_classe, c.niveau, c.filiere
        FROM classes c
        JOIN emploi_du_temps edt ON c.id = edt.classe_id
        WHERE edt.professeur_id = ?
        ORDER BY c.nom_classe
    ");
    $stmt_classes->execute([$prof_user_id]);
    $classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

    // Si aucune classe n'est sélectionnée mais qu'il y en a, pré-sélectionner la première
    if (empty($selected_classe_id) && !empty($classes)) {
        $selected_classe_id = $classes[0]['id'];
    }

} catch (PDOException $e) {
    $message = ($lang['db_error_load_classes'] ?? 'Erreur de base de données lors du chargement des classes : ') . $e->getMessage();
    error_log("View Schedule - Load Classes Error: " . $e->getMessage());
}

// Charger l'emploi du temps existant pour la classe sélectionnée et le professeur
if ($selected_classe_id) {
    try {
        $stmt_edt = $pdo->prepare("
            SELECT edt.*, m.nom AS nom_matiere, CONCAT(u.nom, ' ', u.prenom) AS nom_professeur
            FROM emploi_du_temps edt
            LEFT JOIN matieres m ON edt.matiere_id = m.id
            LEFT JOIN utilisateurs u ON edt.professeur_id = u.id AND u.role = 'professeur'
            WHERE edt.classe_id = ? AND edt.professeur_id = ?
            ORDER BY FIELD(jour_semaine, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), heure_debut
        ");
        $stmt_edt->execute([$selected_classe_id, $prof_user_id]);
        $raw_edt_data = $stmt_edt->fetchAll(PDO::FETCH_ASSOC);

        // Re-organiser les données pour un accès facile dans le tableau HTML
        foreach ($raw_edt_data as $row) {
            $emploi_du_temps_data[$row['jour_semaine']][] = $row;
        }

    } catch (PDOException $e) {
        $message = ($lang['db_error_load_schedule'] ?? 'Erreur de base de données lors du chargement de l\'emploi du temps : ') . $e->getMessage();
        error_log("View Schedule - Load EDT Error: " . $e->getMessage());
    }
}

// Définir des créneaux horaires fixes si votre EDT a des créneaux standard
$time_slots = [
    ['08:00', '10:00'],
    ['10:00', '12:00'],
    ['14:00', '16:00'],
    ['16:00', '18:00']
];
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']; // Vous pouvez ajouter Samedi, Dimanche si besoin

?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['view_schedule'] ?? 'Visualiser l\'Emploi du Temps') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8c5a2b;
            --secondary: #cfa37b;
            --accent: #b3874c;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f4f1;
            color: #333;
            padding-top: 70px; /* Pour la barre de navigation fixe */
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
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .content-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: bold;
            color: var(--primary);
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden; /* Pour que les coins arrondis fonctionnent avec border-collapse */
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 8px;
            text-align: center;
            font-size: 14px;
            vertical-align: middle;
        }
        th {
            background-color: var(--secondary);
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        footer {
            background: var(--primary);
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 3rem;
        }
        body.daltonien-mode {
            filter: grayscale(100%);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/images/logo_ensao.png" alt="Logo ENSAO" />
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
                <li class="nav-item"><a class="nav-link" href="prof_dashboard.php"><?= htmlspecialchars($lang['home'] ?? 'Accueil') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="gestion_absences.php"><?= htmlspecialchars($lang['manage_absences'] ?? 'Gérer les Absences') ?></a></li>
                <li class="nav-item"><a class="nav-link active" href="view_schedule.php"><?= htmlspecialchars($lang['view_absences'] ?? 'Visualiser l\'emploi du temps') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="valider_justificatif.php"><?= htmlspecialchars($lang['validate_justification'] ?? 'Valider les Justificatifs') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="rapports.php"><?= htmlspecialchars($lang['reports'] ?? 'Rapports') ?></a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a
                        class="dropdown-toggle text-dark text-decoration-none"
                        href="#"
                        id="langDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    ><?= strtoupper($lang_code) ?></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                        <li><a class="dropdown-item" href="?lang=fr">FR – Français</a></li>
                        <li><a class="dropdown-item" href="?lang=en">EN – English</a></li>
                        <li><a class="dropdown-item" href="?lang=ar">AR – العربية</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary" id="daltonienModeToggle">
                    <i class="bi bi-eye-slash"></i> <?= htmlspecialchars($lang['daltonian_mode'] ?? 'Mode Daltonien') ?>
                </button>
                <a href="../authentification/logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> <?= htmlspecialchars($lang['logout'] ?? 'Déconnexion') ?></a>
            </div>
        </div>
    </div>
</nav>

<section class="dashboard-header text-center">
    <div class="container">
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['view_schedule'] ?? 'Visualiser l\'Emploi du Temps') ?></h1>
        <p class="lead"><?= htmlspecialchars($lang['schedule_for_prof'] ?? 'Emploi du temps pour ') ?> <?= htmlspecialchars($prof_full_name) ?></p>
    </div>
</section>

<main class="container content-section">
    <?php if (!empty($message)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post" id="selectClassForm" class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label for="classe_id" class="form-label"><?= htmlspecialchars($lang['select_class'] ?? 'Sélectionner une Classe') ?> :</label>
            </div>
            <div class="col-md-8">
                <select name="classe_id" id="classe_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- <?= htmlspecialchars($lang['choose_a_class'] ?? 'Choisir une classe') ?> --</option>
                    <?php foreach ($classes as $classe): ?>
                        <option value="<?= htmlspecialchars($classe['id']) ?>" <?= ($selected_classe_id == $classe['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($classe['nom_classe'] . ' (' . $classe['niveau'] . ' ' . $classe['filiere'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <?php if ($selected_classe_id && !empty($emploi_du_temps_data)): ?>
        <?php
            // Trouver le nom de la classe sélectionnée pour l'affichage du titre
            $current_class_name = '';
            foreach ($classes as $c) {
                if ($c['id'] == $selected_classe_id) {
                    $current_class_name = $c['nom_classe'];
                    break;
                }
            }
        ?>
        <h3 class="mb-3 text-center"><?= htmlspecialchars($lang['schedule_for'] ?? 'Emploi du temps pour') ?> <span class="text-primary"><?= htmlspecialchars($current_class_name) ?></span></h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><?= htmlspecialchars($lang['day_slot'] ?? 'Jour / Créneau') ?></th>
                        <?php foreach ($time_slots as $slot_index => $slot): ?>
                            <th>
                                <?= htmlspecialchars($lang['slot'] ?? 'Créneau') ?> <?= $slot_index + 1 ?><br>
                                <small>(<?= htmlspecialchars($slot[0] . '-' . $slot[1]) ?>)</small>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jours as $jour): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($jour) ?></strong></td>
                            <?php foreach ($time_slots as $slot_index => $slot):
                                $found_entry = null;
                                if (isset($emploi_du_temps_data[$jour])) {
                                    foreach ($emploi_du_temps_data[$jour] as $edt_entry) {
                                        // Comparaison directe des heures formatées de la DB avec les slots fixes
                                        if (substr($edt_entry['heure_debut'], 0, 5) == $slot[0] && substr($edt_entry['heure_fin'], 0, 5) == $slot[1]) {
                                            $found_entry = $edt_entry;
                                            break;
                                        }
                                    }
                                }
                            ?>
                                <td>
                                    <?php if ($found_entry): ?>
                                        <strong><?= htmlspecialchars($found_entry['nom_matiere'] ?? 'N/A') ?></strong><br>
                                        <small><?= htmlspecialchars($found_entry['nom_professeur'] ?? 'N/A') ?></small><br>
                                        <small class="text-muted"><?= htmlspecialchars($found_entry['salle'] ?? 'N/A') ?></small>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <button type="button" class="btn btn-primary" id="downloadPdfButton">
                <i class="bi bi-download me-2"></i> <?= htmlspecialchars($lang['download_schedule'] ?? 'Télécharger l\'emploi du temps') ?> (PDF)
            </button>
        </div>
    <?php elseif ($selected_classe_id && empty($emploi_du_temps_data)): ?>
        <div class="alert alert-info mt-4">
            <?= htmlspecialchars($lang['no_schedule_for_class_prof'] ?? 'Aucun emploi du temps trouvé pour cette classe et votre profil d\'enseignant.') ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-4">
            <?= htmlspecialchars($lang['select_class_to_view_schedule'] ?? 'Veuillez sélectionner une classe pour visualiser son emploi du temps.') ?>
        </div>
    <?php endif; ?>
</main>

<footer>
    <div class="container">
        <small>&copy; <?= date('Y') ?> ENSAO - Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    // JavaScript pour le Mode Daltonien
    document.getElementById('daltonienModeToggle').addEventListener('click', function() {
        document.body.classList.toggle('daltonien-mode');
        const isDaltonien = document.body.classList.contains('daltonien-mode');
        localStorage.setItem('daltonienMode', isDaltonien); // Sauvegarder la préférence
    });

    // Vérifier la préférence du mode daltonien au chargement
    if (localStorage.getItem('daltonienMode') === 'true') {
        document.body.classList.add('daltonien-mode');
    }

    // Gestion des changements de langue pour rafraîchir la page
    document.querySelectorAll('.dropdown-item[href*="?lang="]').forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const url = new URL(window.location.href);
            url.searchParams.set('lang', this.getAttribute('href').split('lang=')[1]);
            window.location.href = url.toString();
        });
    });

    // Gestionnaire d'événement pour le bouton de téléchargement PDF
    document.getElementById('downloadPdfButton').addEventListener('click', function() {
        console.log('Bouton de téléchargement cliqué.'); // Debugging

        const input = document.querySelector('.table-responsive'); // Sélectionnez la div contenant le tableau

        if (!input) {
            console.error('Élément .table-responsive introuvable. Impossible de capturer.');
            alert('Erreur: L\'élément à télécharger est introuvable sur la page.');
            return;
        }

        // Ajout d'un petit délai pour s'assurer que tout est rendu
        setTimeout(() => {
            if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
                console.error('html2canvas ou jspdf n\'est pas chargé correctement.');
                alert('Erreur: Les bibliothèques de génération PDF ne sont pas prêtes. Veuillez réessayer.');
                return;
            }

            html2canvas(input, {
                scale: 2, // Augmente la résolution de la capture pour une meilleure qualité
                useCORS: true // Important si vous avez des images ou polices de domaines différents
            }).then(canvas => {
                console.log('html2canvas a capturé le canvas.'); // Debugging
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf; // Accès correct à jsPDF
                const pdf = new jsPDF({
                    orientation: 'landscape', // Paysage pour un tableau large
                    unit: 'mm', // Utilisez des millimètres pour des dimensions plus standard
                    format: 'a4'
                });

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();

                const imgWidth = canvas.width;
                const imgHeight = canvas.height;

                // Calculer le ratio d'aspect pour conserver les proportions
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const finalImgWidth = imgWidth * ratio * 0.9; // Ajustement pour une petite marge
                const finalImgHeight = imgHeight * ratio * 0.9; // Ajustement pour une petite marge

                // Centrer l'image sur la page
                const posX = (pdfWidth - finalImgWidth) / 2;
                const posY = (pdfHeight - finalImgHeight) / 2;

                pdf.addImage(imgData, 'PNG', posX, posY, finalImgWidth, finalImgHeight);

                // Obtenez le nom de la classe pour le nom de fichier
                const selectElement = document.getElementById('classe_id');
                const selectedClassName = selectElement.options[selectElement.selectedIndex].text.split('(')[0].trim();
                const fileName = `emploi_du_temps_${selectedClassName || 'selectionnee'}.pdf`;

                pdf.save(fileName);
                console.log('PDF sauvegardé : ' + fileName); // Debugging

            }).catch(error => {
                console.error('Erreur lors de la génération du PDF:', error);
                alert('Une erreur est survenue lors du téléchargement du PDF. Veuillez vérifier la console pour plus de détails.');
            });
        }, 300); // Délai de 300ms
    });
</script>
</body>
</html>