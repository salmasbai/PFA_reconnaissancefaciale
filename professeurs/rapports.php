<?php
session_start();
require_once '../includes/config.php';

// Inclure le fichier de configuration du mailer
require_once '../includes/mailer_config.php'; // Chemin relatif depuis rapports.php

$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// Vérifier si l'utilisateur est connecté et est un professeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: ../authentification/login.php");
    exit();
}

$prof_user_id = $_SESSION['user_id'];
$prof_full_name = $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];

$success_message = '';
$error_message = '';
$message_status = ''; // Pour gérer les messages de succès/erreur pour l'envoi d'e-mail

$selected_class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : '';
$selected_matiere_id = isset($_POST['matiere_id']) ? intval($_POST['matiere_id']) : '';

$classes = [];
$matieres = [];
$absences_by_student = [];

// Récupérer les classes que le professeur enseigne (à partir de l'emploi du temps)
try {
    $stmt_classes = $pdo->prepare("
        SELECT DISTINCT c.id, c.nom_classe
        FROM classes c
        JOIN emploi_du_temps edt ON c.id = edt.classe_id
        WHERE edt.professeur_id = ?
        ORDER BY c.nom_classe
    ");
    $stmt_classes->execute([$prof_user_id]);
    $classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

    // Si une classe n'est pas déjà sélectionnée, mais qu'il y en a, sélectionnez la première
    if (empty($selected_class_id) && !empty($classes)) {
        $selected_class_id = $classes[0]['id'];
    }

} catch (PDOException $e) {
    $error_message = ($lang['db_error_load_classes'] ?? "Erreur de base de données lors du chargement des classes : ") . $e->getMessage();
    error_log("Rapports - Load Classes Error: " . $e->getMessage());
}

// Récupérer les matières que le professeur enseigne dans la classe sélectionnée
if ($selected_class_id) {
    try {
        $stmt_matieres = $pdo->prepare("
            SELECT DISTINCT m.id, m.nom
            FROM matieres m
            JOIN emploi_du_temps edt ON m.id = edt.matiere_id
            WHERE edt.professeur_id = ? AND edt.classe_id = ?
            ORDER BY m.nom
        ");
        $stmt_matieres->execute([$prof_user_id, $selected_class_id]);
        $matieres = $stmt_matieres->fetchAll(PDO::FETCH_ASSOC);

        // Si une matière n'est pas déjà sélectionnée, mais qu'il y en a, sélectionnez la première
        if (empty($selected_matiere_id) && !empty($matieres)) {
            $selected_matiere_id = $matieres[0]['id'];
        }

    } catch (PDOException $e) {
        $error_message = ($lang['db_error_load_materials'] ?? "Erreur de base de données lors du chargement des matières : ") . $e->getMessage();
        error_log("Rapports - Load Matieres Error: " . $e->getMessage());
    }
}

// Récupérer les absences par étudiant pour la classe et la matière sélectionnées
if ($selected_class_id && $selected_matiere_id) {
    try {
        $stmt_absences = $pdo->prepare("
            SELECT
                e.id AS etudiant_id,
                e.nom AS etudiant_nom,
                e.prenom AS etudiant_prenom,
                u.email AS etudiant_email,
                COUNT(a.id) AS total_absences
            FROM
                etudiants e
            JOIN
                absences a ON e.id = a.etudiant_id
            JOIN
                utilisateurs u ON e.user_id = u.id
            WHERE
                e.classe_id = ? AND a.matiere_id = ?
            GROUP BY
                e.id, e.nom, e.prenom, u.email
            HAVING
                COUNT(a.id) > 0
            ORDER BY
                total_absences DESC, e.nom, e.prenom
        ");
        $stmt_absences->execute([$selected_class_id, $selected_matiere_id]);
        $absences_by_student = $stmt_absences->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error_message = ($lang['db_error_load_absences'] ?? "Erreur de base de données lors du chargement des absences : ") . $e->getMessage();
        error_log("Rapports - Load Absences Error: " . $e->getMessage());
    }
}

// Traitement de l'envoi d'avertissement par email AVEC PHPMailer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_warning'])) {
    $student_id_to_warn = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
    $student_email_to_warn = isset($_POST['student_email']) ? trim($_POST['student_email']) : '';
    $student_full_name_to_warn = isset($_POST['student_full_name']) ? trim($_POST['student_full_name']) : '';
    $matiere_nom_for_warning = isset($_POST['matiere_nom']) ? trim($_POST['matiere_nom']) : '';
    $num_absences_for_warning = isset($_POST['num_absences']) ? intval($_POST['num_absences']) : 0;

    if ($student_id_to_warn && !empty($student_email_to_warn) && $num_absences_for_warning > 0) {
        // Appeler la fonction configureMailer() de votre fichier mailer_config.php
        $mail = configureMailer();

        try {
            // Ajouter le destinataire spécifique pour cet avertissement
            $mail->addAddress($student_email_to_warn, $student_full_name_to_warn);

            // Définir le contenu de l'e-mail
            $mail->Subject = ($lang['warning_email_subject'] ?? 'Avertissement d\'Absence - Matière : ') . htmlspecialchars($matiere_nom_for_warning);

            // Corps du message HTML
            $mail->Body    = "<p>" . ($lang['warning_email_body_intro'] ?? 'Cher(e) ') . "<strong>" . htmlspecialchars($student_full_name_to_warn) . "</strong>,</p>" .
                            "<p>" . ($lang['warning_email_body_line1'] ?? "Nous vous informons de vos absences répétées au cours de ") . "<strong>" . htmlspecialchars($matiere_nom_for_warning) . "</strong>.</p>" .
                            "<p>" . ($lang['warning_email_body_line2'] ?? "Vous avez un total de ") . "<strong>" . htmlspecialchars($num_absences_for_warning) . "</strong> " . ($lang['warning_email_body_absences'] ?? "absences") . " " . ($lang['warning_email_body_period'] ?? "à ce jour (celles-ci peuvent inclure des absences non encore justifiées).") . "</p>" .
                            "<p>" . ($lang['warning_email_body_line3'] ?? "Veuillez prendre les mesures nécessaires pour régulariser votre situation et assister régulièrement aux cours.") . "</p>" .
                            "<p>" . ($lang['warning_email_body_regards'] ?? "Cordialement,") . "<br>" .
                            "<strong>" . htmlspecialchars($prof_full_name) . "</strong><br>" .
                            "ENSAO</p>";
            
            // Corps du message en texte brut (pour les clients mail ne supportant pas HTML)
            $mail->AltBody = ($lang['warning_email_body_intro'] ?? 'Cher(e) ') . htmlspecialchars($student_full_name_to_warn) . ",\n\n" .
                            ($lang['warning_email_body_line1'] ?? "Nous vous informons de vos absences répétées au cours de ") . htmlspecialchars($matiere_nom_for_warning) . ".\n" .
                            ($lang['warning_email_body_line2'] ?? "Vous avez un total de ") . htmlspecialchars($num_absences_for_warning) . " " . ($lang['warning_email_body_absences'] ?? "absences") . " " . ($lang['warning_email_body_period'] ?? "à ce jour (celles-ci peuvent inclure des absences non encore justifiées).") . "\n\n" .
                            ($lang['warning_email_body_line3'] ?? "Veuillez prendre les mesures nécessaires pour régulariser votre situation et assister régulièrement aux cours.") . "\n\n" .
                            ($lang['warning_email_body_regards'] ?? "Cordialement,") . "\n" .
                            htmlspecialchars($prof_full_name) . "\n" .
                            "ENSAO";

            $mail->send();
            $message_status = 'success';
            $success_message = ($lang['warning_sent_success'] ?? 'Avertissement envoyé avec succès à ') . htmlspecialchars($student_full_name_to_warn) . '.';

            // Enregistrer l'avertissement dans la base de données
            try {
                $stmt_record_warning = $pdo->prepare("
                    INSERT INTO avertissements (etudiant_id, professeur_id, matiere_id, nombre_absences, message_avertissement, statut)
                    VALUES (?, ?, ?, ?, ?, 'envoye')
                ");
                $stmt_record_warning->execute([
                    $student_id_to_warn,
                    $prof_user_id,
                    $selected_matiere_id,
                    $num_absences_for_warning,
                    $mail->Body // Enregistre le contenu HTML du message
                ]);
            } catch (PDOException $e) {
                error_log("Rapports - Error recording warning: " . $e->getMessage());
                if ($message_status === 'success') {
                     $error_message .= " " . ($lang['db_error_record_warning'] ?? 'Erreur lors de l\'enregistrement de l\'avertissement en base de données.');
                } else {
                     $error_message = ($lang['db_error_record_warning'] ?? 'Erreur lors de l\'enregistrement de l\'avertissement en base de données.') . $e->getMessage();
                }
            }

        } catch (Exception $e) {
            $message_status = 'error';
            $error_message = ($lang['warning_sent_failure'] ?? 'Échec de l\'envoi de l\'avertissement à ') . htmlspecialchars($student_full_name_to_warn) . ". Erreur: {$mail->ErrorInfo}. " . ($lang['mail_config_error'] ?? 'Veuillez vérifier la configuration SMTP.');
            error_log("Rapports - Mail sending failed to " . $student_email_to_warn . ": " . $e->getMessage());

            // Enregistrer l'échec d'envoi
            try {
                $stmt_record_warning = $pdo->prepare("
                    INSERT INTO avertissements (etudiant_id, professeur_id, matiere_id, nombre_absences, message_avertissement, statut)
                    VALUES (?, ?, ?, ?, ?, 'echec')
                ");
                $stmt_record_warning->execute([
                    $student_id_to_warn,
                    $prof_user_id,
                    $selected_matiere_id,
                    $num_absences_for_warning,
                    $mail->Body . " (Échec: {$mail->ErrorInfo})" // Enregistre le contenu HTML + l'erreur
                ]);
            } catch (PDOException $e) {
                error_log("Rapports - Error recording failed warning: " . $e->getMessage());
            }
        }
    } else {
        $message_status = 'error';
        $error_message = $lang['warning_missing_info'] ?? 'Informations manquantes pour envoyer l\'avertissement.';
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['reports'] ?? 'Rapports') ?></title>
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
            padding-bottom: 20px;
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
            overflow: hidden;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 8px;
            text-align: left;
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
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .text-center {
            text-align: center;
        }
        /* Style pour l'accessibilité */
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
                <li class="nav-item"><a class="nav-link" href="voir_absences.php"><?= htmlspecialchars($lang['view_absences'] ?? 'Visualiser les Absences') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="valider_justificatif.php"><?= htmlspecialchars($lang['validate_justification'] ?? 'Valider les Justificatifs') ?></a></li>
                <li class="nav-item"><a class="nav-link active" href="rapports.php"><?= htmlspecialchars($lang['reports'] ?? 'Rapports') ?></a></li>
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
        <h1 class="display-4 mb-2"><?= htmlspecialchars($lang['reports_title'] ?? 'Rapports et Avertissements') ?></h1>
        <p class="lead"><?= htmlspecialchars($lang['welcome_prof'] ?? 'Bienvenue') ?>, <?= htmlspecialchars($prof_full_name) ?>!</p>
    </div>
</section>

<main class="container content-section">
    <?php if ($success_message): ?>
        <div class="message success alert alert-success alert-dismissible fade show" role="alert">
            <span><?= htmlspecialchars($success_message) ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="message error alert alert-danger alert-dismissible fade show" role="alert">
            <span><?= htmlspecialchars($error_message) ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="class_id" class="form-label"><i class="bi bi-mortarboard me-1"></i> <?= htmlspecialchars($lang['select_class'] ?? 'Sélectionner une Classe') ?> :</label>
                <select class="form-select" id="class_id" name="class_id" onchange="this.form.submit()">
                    <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= htmlspecialchars($class['id']) ?>" <?= ($selected_class_id == $class['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['nom_classe']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="matiere_id" class="form-label"><i class="bi bi-book me-1"></i> <?= htmlspecialchars($lang['select_material'] ?? 'Sélectionner une Matière') ?> :</label>
                <select class="form-select" id="matiere_id" name="matiere_id" onchange="this.form.submit()" <?= empty($matieres) ? 'disabled' : '' ?>>
                    <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                    <?php foreach ($matieres as $matiere): ?>
                        <option value="<?= htmlspecialchars($matiere['id']) ?>" <?= ($selected_matiere_id == $matiere['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($matiere['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <?php if ($selected_class_id && $selected_matiere_id): ?>
        <h4 class="mt-4 mb-3"><?= htmlspecialchars($lang['students_absences_in_material'] ?? 'Absences des étudiants dans') ?> "<?= htmlspecialchars($matieres[array_search($selected_matiere_id, array_column($matieres, 'id'))]['nom'] ?? '') ?>" :</h4>

        <?php if (!empty($absences_by_student)): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['student_name'] ?? 'Nom de l\'étudiant') ?></th>
                            <th class="text-center"><?= htmlspecialchars($lang['total_absences'] ?? 'Nombre d\'absences') ?></th>
                            <th class="text-center"><?= htmlspecialchars($lang['actions'] ?? 'Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absences_by_student as $student_abs): ?>
                            <tr>
                                <td><?= htmlspecialchars($student_abs['etudiant_nom'] . ' ' . $student_abs['etudiant_prenom']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($student_abs['total_absences']) ?></td>
                                <td class="text-center">
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="class_id" value="<?= htmlspecialchars($selected_class_id) ?>">
                                        <input type="hidden" name="matiere_id" value="<?= htmlspecialchars($selected_matiere_id) ?>">
                                        <input type="hidden" name="student_id" value="<?= htmlspecialchars($student_abs['etudiant_id']) ?>">
                                        <input type="hidden" name="student_email" value="<?= htmlspecialchars($student_abs['etudiant_email']) ?>">
                                        <input type="hidden" name="student_full_name" value="<?= htmlspecialchars($student_abs['etudiant_nom'] . ' ' . $student_abs['etudiant_prenom']) ?>">
                                        <input type="hidden" name="matiere_nom" value="<?= htmlspecialchars($matieres[array_search($selected_matiere_id, array_column($matieres, 'id'))]['nom'] ?? '') ?>">
                                        <input type="hidden" name="num_absences" value="<?= htmlspecialchars($student_abs['total_absences']) ?>">
                                        <button type="submit" name="send_warning" class="btn btn-danger btn-sm">
                                            <i class="bi bi-exclamation-triangle me-1"></i> <?= htmlspecialchars($lang['send_warning'] ?? 'Envoyer Avertissement') ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-3">
                <?= htmlspecialchars($lang['no_absences_for_criteria'] ?? 'Aucune absence enregistrée pour cette classe et cette matière, ou tous les étudiants sont présents.') ?>
            </div>
        <?php endif; ?>

    <?php elseif (empty($classes)): ?>
        <div class="alert alert-info mt-4">
            <?= htmlspecialchars($lang['no_classes_assigned_to_prof'] ?? 'Aucune classe n\'est assignée à votre profil d\'enseignant dans l\'emploi du temps.') ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-4">
            <?= htmlspecialchars($lang['select_class_and_material'] ?? 'Veuillez sélectionner une classe et une matière pour voir les rapports d\'absences.') ?>
        </div>
    <?php endif; ?>
</main>

<footer>
    <div class="container">
        <small>&copy; <?= date('Y') ?> ENSAO - Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
</script>
</body>
</html>