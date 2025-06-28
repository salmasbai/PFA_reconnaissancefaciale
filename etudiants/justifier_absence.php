<?php
session_start();
require_once '../includes/config.php';
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// Vérifier si l'utilisateur est connecté et a bien le rôle 'etudiant'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'etudiant') {
    header("Location: ../authentification/login.php"); // Assurez-vous que le chemin est correct
    exit();
}

$etudiant_user_id = $_SESSION['user_id'];
$etudiant_entity_id = null;
$error_message = '';
$success_message = '';

// Récupérer l'ID de l'entité étudiant depuis la table `etudiants`
try {
    $stmt_get_student_entity_id = $pdo->prepare("SELECT id, classe_id FROM etudiants WHERE user_id = ?");
    $stmt_get_student_entity_id->execute([$etudiant_user_id]);
    $student_data = $stmt_get_student_entity_id->fetch(PDO::FETCH_ASSOC);

    if ($student_data) {
        $etudiant_entity_id = $student_data['id'];
        $student_classe_id = $student_data['classe_id']; // ID de la classe de l'étudiant
    } else {
        $error_message = $lang['student_data_not_found'] ?? 'Données de l\'étudiant introuvables.';
    }
} catch (PDOException $e) {
    $error_message = $lang['db_error'] ?? 'Erreur de base de données lors du chargement des données de l\'étudiant.';
    error_log("Justify Absences - Student Data Error: " . $e->getMessage());
}

// Variables pour pré-remplir le formulaire si un ID d'absence est passé (depuis le dashboard)
$prefill_absence_id = null;
$prefill_date = '';
$prefill_creneau = '';
$prefill_matiere_id = '';

if (isset($_GET['justify_absence_id']) && $etudiant_entity_id) {
    $prefill_absence_id = intval($_GET['justify_absence_id']);
    try {
        $stmt_prefill = $pdo->prepare("
            SELECT a.date, a.heure_debut_creneau, a.heure_fin_creneau, a.matiere_id, m.nom AS matiere_nom
            FROM absences a
            JOIN matieres m ON a.matiere_id = m.id
            WHERE a.id = ? AND a.etudiant_id = ? AND a.justifiee = 0
        ");
        $stmt_prefill->execute([$prefill_absence_id, $etudiant_entity_id]);
        $absence_to_justify = $stmt_prefill->fetch(PDO::FETCH_ASSOC);

        if ($absence_to_justify) {
            $prefill_date = $absence_to_justify['date'];
            $prefill_creneau = substr($absence_to_justify['heure_debut_creneau'], 0, 5) . '-' . substr($absence_to_justify['heure_fin_creneau'], 0, 5);
            $prefill_matiere_id = $absence_to_justify['matiere_id'];
        } else {
            $error_message = $lang['absence_not_found_or_justified'] ?? 'Absence non trouvée ou déjà justifiée.';
            $prefill_absence_id = null; // Reset if not found or already justified
        }
    } catch (PDOException $e) {
        $error_message = $lang['db_error_load_absence'] ?? 'Erreur lors du chargement des détails de l\'absence.';
        error_log("Justify Absences - Prefill Error: " . $e->getMessage());
    }
}


// Récupérer les créneaux et matières de l'emploi du temps de l'étudiant pour la date sélectionnée
$creneaux_edt_data = [];
$matieres_edt_for_date = [];
if ($etudiant_entity_id && $student_classe_id && !empty($prefill_date)) {
    try {
        $jour_semaine_num = date('N', strtotime($prefill_date)); // 1 (pour Lundi) à 7 (pour Dimanche)
        $jours_map = [
            1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi',
            5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'
        ];
        $jour_actuel = $jours_map[$jour_semaine_num];

        $stmt_edt_data = $pdo->prepare("
            SELECT DISTINCT
                edt.matiere_id,
                m.nom AS matiere_nom,
                TIME_FORMAT(edt.heure_debut, '%H:%i') AS heure_debut_formatted,
                TIME_FORMAT(edt.heure_fin, '%H:%i') AS heure_fin_formatted
            FROM
                emploi_du_temps edt
            JOIN
                matieres m ON edt.matiere_id = m.id
            WHERE
                edt.classe_id = ? AND edt.jour_semaine = ?
            ORDER BY edt.heure_debut
        ");
        $stmt_edt_data->execute([$student_classe_id, $jour_actuel]);
        $edt_entries = $stmt_edt_data->fetchAll(PDO::FETCH_ASSOC);

        foreach ($edt_entries as $entry) {
            $creneau_key = $entry['heure_debut_formatted'] . '-' . $entry['heure_fin_formatted'];
            $creneaux_edt_data[$creneau_key] = [
                'matiere_id' => $entry['matiere_id'],
                'matiere_nom' => $entry['matiere_nom'],
                'heure_debut' => $entry['heure_debut_formatted'],
                'heure_fin' => $entry['heure_fin_formatted']
            ];
            // Ajouter la matière à une liste pour le sélecteur si on ne pré-remplit pas par créneau
            $matieres_edt_for_date[$entry['matiere_id']] = $entry['matiere_nom'];
        }

    } catch (PDOException $e) {
        $error_message = $lang['db_error_load_edt'] ?? 'Erreur lors du chargement de l\'emploi du temps.';
        error_log("Justify Absences - Load EDT Error: " . $e->getMessage());
    }
}


// --- Traitement de la soumission du justificatif ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_justification']) && $etudiant_entity_id) {
    $absence_date = trim($_POST['absence_date_justify']);
    $creneau_str = trim($_POST['creneau_justify']);
    $matiere_id = intval($_POST['matiere_justify']);
    $motif = trim($_POST['motif_justification'] ?? '');
    $absence_id_to_link = empty($_POST['absence_id_link']) ? NULL : intval($_POST['absence_id_link']);

    // Extraire heure_debut et heure_fin du créneau
    list($heure_debut_creneau, $heure_fin_creneau) = explode('-', $creneau_str);

    if (empty($absence_date) || empty($creneau_str) || empty($matiere_id) || empty($_FILES['justification_file']['name'])) {
        $error_message = $lang['fill_all_fields_justify'] ?? 'Veuillez remplir tous les champs et télécharger un fichier.';
    } else {
        $file = $_FILES['justification_file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array($fileExt, $allowed)) {
            $error_message = $lang['invalid_file_type'] ?? 'Type de fichier non autorisé. Seuls PDF, JPG, JPEG, PNG sont acceptés.';
        } elseif ($fileSize > 5000000) { // 5MB limit
            $error_message = $lang['file_too_large'] ?? 'Le fichier est trop volumineux (max 5MB).';
        } elseif ($fileError !== 0) {
            $error_message = $lang['upload_error'] ?? 'Une erreur est survenue lors du téléchargement du fichier.';
        } else {
            $upload_dir = '../uploads/justificatifs/' . date('Y/m/') . $etudiant_entity_id . '/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $fileNewName = uniqid('', true) . '.' . $fileExt;
            $filePath = $upload_dir . $fileNewName;

            if (move_uploaded_file($fileTmpName, $filePath)) {
                try {
                    $pdo->beginTransaction();

                    // Insérer le justificatif
                    $stmt_insert_justif = $pdo->prepare("
                        INSERT INTO justificatifs (etudiant_id, absence_id, date_absence, heure_debut_creneau, heure_fin_creneau, matiere_id, motif, chemin_fichier, statut)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'en attente')
                    ");
                    $stmt_insert_justif->execute([
                        $etudiant_entity_id,
                        $absence_id_to_link, // Sera NULL si l'absence n'est pas pré-remplie
                        $absence_date,
                        $heure_debut_creneau,
                        $heure_fin_creneau,
                        $matiere_id,
                        $motif,
                        str_replace('../', '', $filePath) // Stocker le chemin relatif à la racine du site
                    ]);

                    // Si l'absence_id est fournie, mettre à jour le statut de l'absence à "justifié"
                    // et lier le justificatif à cette absence (si ce n'est pas déjà fait par le champ absence_id)
                    // Note: Le statut 'justifiee' dans 'absences' est mis à jour par le professeur.
                    // Ici, nous indiquons que l'étudiant a SOUMIS un justificatif.
                    // L'admin devra valider ce justificatif et c'est l'admin qui mettra à jour 'justifiee' à 1
                    // dans la table 'absences'. Pour l'instant, on ne touche pas à 'absences.justifiee' ici.
                    // if ($absence_id_to_link) {
                    //    // Potentiellement mettre à jour `absences.justifiee` à `1` ici si la justification est automatique,
                    //    // mais généralement, cela nécessite une validation admin.
                    //    // Nous allons laisser cela au panneau admin pour le moment.
                    // }

                    $pdo->commit();
                    $success_message = $lang['justification_submitted_success'] ?? 'Justificatif soumis avec succès. Il est en attente de validation.';

                    // Réinitialiser les champs du formulaire après succès
                    $prefill_date = '';
                    $prefill_creneau = '';
                    $prefill_matiere_id = '';
                    $prefill_absence_id = null;


                } catch (PDOException $e) {
                    $pdo->rollBack();
                    $error_message = $lang['db_error_submit_justify'] ?? 'Erreur de base de données lors de la soumission du justificatif.';
                    error_log("Submit Justification Error: " . $e->getMessage());
                    unlink($filePath); // Supprimer le fichier téléchargé en cas d'erreur DB
                }
            } else {
                $error_message = $lang['file_move_error'] ?? 'Impossible de déplacer le fichier téléchargé.';
            }
        }
    }
}

// Récupérer les absences non justifiées de l'étudiant pour l'affichage
$unjustified_absences = [];
if ($etudiant_entity_id) {
    try {
        $stmt_unjustified = $pdo->prepare("
            SELECT
                a.id AS absence_id,
                a.date,
                a.heure_debut_creneau,
                a.heure_fin_creneau,
                m.nom AS matiere_nom
            FROM
                absences a
            JOIN
                matieres m ON a.matiere_id = m.id
            WHERE
                a.etudiant_id = ? AND a.justifiee = 0
            ORDER BY a.date DESC, a.heure_debut_creneau DESC
        ");
        $stmt_unjustified->execute([$etudiant_entity_id]);
        $unjustified_absences = $stmt_unjustified->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message_absences = $lang['db_error_load_unjustified'] ?? 'Erreur lors du chargement des absences non justifiées.';
        error_log("Justify Absences - Load Unjustified Absences Error: " . $e->getMessage());
    }
}

// Récupérer les justificatifs soumis par l'étudiant
$submitted_justifications = [];
if ($etudiant_entity_id) {
    try {
        $stmt_submitted_justif = $pdo->prepare("
            SELECT
                j.id,
                j.date_absence,
                j.heure_debut_creneau,
                j.heure_fin_creneau,
                m.nom AS matiere_nom,
                j.statut,
                j.chemin_fichier,
                j.date_soumission
            FROM
                justificatifs j
            LEFT JOIN
                matieres m ON j.matiere_id = m.id
            WHERE
                j.etudiant_id = ?
            ORDER BY j.date_soumission DESC
        ");
        $stmt_submitted_justif->execute([$etudiant_entity_id]);
        $submitted_justifications = $stmt_submitted_justif->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message_justifs = $lang['db_error_load_submitted_justifs'] ?? 'Erreur lors du chargement des justificatifs soumis.';
        error_log("Justify Absences - Load Submitted Justifications Error: " . $e->getMessage());
    }
}

// Standard créneaux pour le sélecteur
$standard_creneaux_list = [
    ['start' => '08:00', 'end' => '10:00', 'label' => 'Créneau 1 (08:00-10:00)'],
    ['start' => '10:00', 'end' => '12:00', 'label' => 'Créneau 2 (10:00-12:00)'],
    ['start' => '14:00', 'end' => '16:00', 'label' => 'Créneau 3 (14:00-16:00)'],
    ['start' => '16:00', 'end' => '18:00', 'label' => 'Créneau 4 (16:00-18:00)']
];

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['justify_absences'] ?? 'Justifier une Absence') ?></title>
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
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        .form-label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: var(--secondary);
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .alert {
            margin-bottom: 1.5rem;
        }
        .badge-status-pending { background-color: #ffc107; color: #000; } /* yellow */
        .badge-status-approved { background-color: #28a745; color: #fff; } /* green */
        .badge-status-rejected { background-color: #dc3545; color: #fff; } /* red */
        .list-group-item.justified-header {
            background-color: var(--primary);
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><i class="bi bi-file-earmark-arrow-up me-2"></i> <?= htmlspecialchars($lang['justify_absences'] ?? 'Justifier une Absence') ?></h2>

        <?php if ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?= htmlspecialchars($lang['submit_justification_form'] ?? 'Soumettre un Justificatif') ?></h4>
            </div>
            <div class="card-body">
                <form action="justifier_absences.php" method="POST" enctype="multipart/form-data">
                    <?php if ($prefill_absence_id): ?>
                        <input type="hidden" name="absence_id_link" value="<?= htmlspecialchars($prefill_absence_id) ?>">
                        <div class="alert alert-info">
                            <?= htmlspecialchars($lang['justifying_for_absence'] ?? 'Vous êtes en train de justifier l\'absence sélectionnée.') ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="absence_date_justify" class="form-label"><?= htmlspecialchars($lang['absence_date'] ?? 'Date de l\'absence') ?>:</label>
                        <input type="date" class="form-control" id="absence_date_justify" name="absence_date_justify" value="<?= htmlspecialchars($prefill_date) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="creneau_justify" class="form-label"><?= htmlspecialchars($lang['creneau'] ?? 'Créneau') ?>:</label>
                        <select class="form-select" id="creneau_justify" name="creneau_justify" required>
                            <option value="">-- <?= htmlspecialchars($lang['select_creneau'] ?? 'Sélectionner le Créneau') ?> --</option>
                            <?php
                            foreach ($standard_creneaux_list as $creneau_data) {
                                $creneau_value = $creneau_data['start'] . '-' . $creneau_data['end'];
                                $creneau_label = $creneau_data['label'];
                                $is_selected = ($prefill_creneau == $creneau_value) ? 'selected' : '';

                                // Afficher seulement les créneaux où l'étudiant a un cours selon l'EDT pour la date sélectionnée
                                // Le plus précis serait de les filtrer par l'EDT de l'étudiant ET que ce soit une absence non justifiée
                                // Pour simplifier pour le moment, on liste les créneaux standard et ceux de l'EDT de la date sélectionnée
                                if (isset($creneaux_edt_data[$creneau_value])) {
                                    $matiere_nom_for_creneau = $creneaux_edt_data[$creneau_value]['matiere_nom'];
                                    echo '<option value="' . htmlspecialchars($creneau_value) . '" ' . $is_selected . ' data-matiere-id="' . htmlspecialchars($creneaux_edt_data[$creneau_value]['matiere_id']) . '">' . htmlspecialchars($creneau_label . ' - ' . $matiere_nom_for_creneau) . '</option>';
                                } else {
                                    // Option non sélectionnable si pas dans l'EDT ou non pertinent, sauf si c'est la valeur pré-remplie
                                    // if ($is_selected) {
                                    //     echo '<option value="' . htmlspecialchars($creneau_value) . '" ' . $is_selected . ' disabled>' . htmlspecialchars($creneau_label) . ' (Non disponible dans EDT)</option>';
                                    // }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="matiere_justify" class="form-label"><?= htmlspecialchars($lang['course_concerned'] ?? 'Matière Concernée') ?>:</label>
                        <select class="form-select" id="matiere_justify" name="matiere_justify" required>
                            <option value="">-- <?= htmlspecialchars($lang['select_course'] ?? 'Sélectionner une matière') ?> --</option>
                            <?php if (!empty($matieres_edt_for_date)): ?>
                                <?php foreach ($matieres_edt_for_date as $id => $name): ?>
                                    <option value="<?= htmlspecialchars($id) ?>" <?= ($prefill_matiere_id == $id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($name) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="form-text text-muted"><?= htmlspecialchars($lang['matiere_auto_fill'] ?? 'La matière sera automatiquement sélectionnée ou filtrée en fonction de la date et du créneau.') ?></small>
                    </div>


                    <div class="mb-3">
                        <label for="motif_justification" class="form-label"><?= htmlspecialchars($lang['reason_for_absence'] ?? 'Motif de l\'absence (optionnel)') ?>:</label>
                        <textarea class="form-control" id="motif_justification" name="motif_justification" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="justification_file" class="form-label"><?= htmlspecialchars($lang['upload_justification_file'] ?? 'Télécharger le justificatif') ?> (PDF, JPG, PNG) :</label>
                        <input type="file" class="form-control" id="justification_file" name="justification_file" accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="form-text text-muted"><?= htmlspecialchars($lang['max_file_size'] ?? 'Taille max: 5MB.') ?></small>
                    </div>

                    <button type="submit" name="submit_justification" class="btn btn-primary"><i class="bi bi-upload me-2"></i> <?= htmlspecialchars($lang['submit_justification_button'] ?? 'Soumettre le justificatif') ?></button>
                </form>
            </div>
        </div>

        <h3 class="mb-3 mt-4"><i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> <?= htmlspecialchars($lang['unjustified_absences_list'] ?? 'Vos Absences Non Justifiées') ?></h3>
        <?php if (!empty($unjustified_absences)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['date'] ?? 'Date') ?></th>
                            <th><?= htmlspecialchars($lang['creneau'] ?? 'Créneau') ?></th>
                            <th><?= htmlspecialchars($lang['course'] ?? 'Cours') ?></th>
                            <th><?= htmlspecialchars($lang['action'] ?? 'Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unjustified_absences as $absence): ?>
                            <tr>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($absence['date']))) ?></td>
                                <td><?= htmlspecialchars(substr($absence['heure_debut_creneau'], 0, 5) . '-' . substr($absence['heure_fin_creneau'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars($absence['matiere_nom']) ?></td>
                                <td>
                                    <a href="justifier_absences.php?justify_absence_id=<?= htmlspecialchars($absence['absence_id']) ?>" class="btn btn-sm btn-outline-primary">
                                        <?= htmlspecialchars($lang['justify'] ?? 'Justifier') ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info"><?= htmlspecialchars($lang['no_unjustified_absences'] ?? 'Vous n\'avez aucune absence non justifiée en attente de soumission de justificatif.') ?></div>
        <?php endif; ?>

        <h3 class="mb-3 mt-4"><i class="bi bi-file-earmark-check-fill me-2 text-info"></i> <?= htmlspecialchars($lang['submitted_justifications'] ?? 'Vos Justificatifs Soumis') ?></h3>
        <?php if (!empty($submitted_justifications)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['date_absence_short'] ?? 'Date Abs.') ?></th>
                            <th><?= htmlspecialchars($lang['creneau'] ?? 'Créneau') ?></th>
                            <th><?= htmlspecialchars($lang['course'] ?? 'Cours') ?></th>
                            <th><?= htmlspecialchars($lang['submission_date'] ?? 'Date Soumission') ?></th>
                            <th><?= htmlspecialchars($lang['status'] ?? 'Statut') ?></th>
                            <th><?= htmlspecialchars($lang['file'] ?? 'Fichier') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submitted_justifications as $justif): ?>
                            <tr>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($justif['date_absence']))) ?></td>
                                <td><?= htmlspecialchars(substr($justif['heure_debut_creneau'], 0, 5) . '-' . substr($justif['heure_fin_creneau'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars($justif['matiere_nom'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($justif['date_soumission']))) ?></td>
                                <td>
                                    <?php
                                    $status_class = '';
                                    $status_text = '';
                                    if ($justif['statut'] == 'en attente') {
                                        $status_class = 'badge-status-pending';
                                        $status_text = $lang['pending'] ?? 'En attente';
                                    } elseif ($justif['statut'] == 'approuve') {
                                        $status_class = 'badge-status-approved';
                                        $status_text = $lang['approved'] ?? 'Approuvé';
                                    } else { // rejete
                                        $status_class = 'badge-status-rejected';
                                        $status_text = $lang['rejected'] ?? 'Rejeté';
                                    }
                                    echo '<span class="badge ' . $status_class . '">' . htmlspecialchars($status_text) . '</span>';
                                    ?>
                                </td>
                                <td>
                                    <?php if ($justif['chemin_fichier']): ?>
                                        <a href="../<?= htmlspecialchars($justif['chemin_fichier']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-file-earmark-arrow-down me-1"></i> <?= htmlspecialchars($lang['view_file'] ?? 'Voir') ?>
                                        </a>
                                    <?php else: ?>
                                        <?= htmlspecialchars($lang['no_file'] ?? 'Aucun') ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info"><?= htmlspecialchars($lang['no_justifications_submitted'] ?? 'Vous n\'avez soumis aucun justificatif pour le moment.') ?></div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const absenceDateInput = document.getElementById('absence_date_justify');
            const creneauSelect = document.getElementById('creneau_justify');
            const matiereSelect = document.getElementById('matiere_justify');

            // Function to update matières based on selected date and creneau
            function updateMatiereOptions() {
                const selectedDate = absenceDateInput.value;
                const selectedCreneau = creneauSelect.value; // Format "HH:MM-HH:MM"

                // Clear previous options
                matiereSelect.innerHTML = '<option value="">-- ' + (<?= json_encode($lang['select_course'] ?? 'Sélectionner une matière') ?>) + ' --</option>';

                if (selectedDate && selectedCreneau) {
                    // This part would typically make an AJAX call to fetch dynamic matière options
                    // based on the student's EDT for the selected date and creneau.
                    // For now, it will use the PHP-preloaded $creneaux_edt_data to filter
                    // for the selected creneau.
                    const creneauxData = <?= json_encode($creneaux_edt_data) ?>;
                    if (creneauxData[selectedCreneau]) {
                        const matiere = creneauxData[selectedCreneau];
                        const option = document.createElement('option');
                        option.value = matiere.matiere_id;
                        option.textContent = matiere.matiere_nom;
                        option.selected = true; // Automatically select the found matière
                        matiereSelect.appendChild(option);
                    } else {
                        // console.log("No matière found for this creneau in EDT.");
                    }
                }
            }

            // Initial call if form is pre-filled
            if (absenceDateInput.value && creneauSelect.value) {
                updateMatiereOptions();
            }

            // Event listeners for changes
            absenceDateInput.addEventListener('change', updateMatiereOptions);
            creneauSelect.addEventListener('change', updateMatiereOptions);

            // If a justify_absence_id was passed, force the matiere select to update once DOM is ready
            <?php if ($prefill_absence_id && $prefill_date && $prefill_creneau): ?>
                // Ensure date and creneau are set before calling updateMatiereOptions
                absenceDateInput.value = '<?= htmlspecialchars($prefill_date) ?>';
                creneauSelect.value = '<?= htmlspecialchars($prefill_creneau) ?>';
                updateMatiereOptions();
            <?php endif; ?>
        });
    </script>
</body>
</html>