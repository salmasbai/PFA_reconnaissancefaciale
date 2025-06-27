<?php
session_start();
// ... autres require_once ...

// --- Début du code à ajouter/modifier dans VOS PAGES PROTÉGÉES ---
// Stocke l'URL de la page actuelle dans la session avant la redirection
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') { // Exemple pour professeur
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI']; // Stocke l'URL complète
    header("Location: ../authentification/login.php"); // Assurez-vous que le chemin est correct
    exit();
}
// --- Fin du code à ajouter/modifier ---


session_start();
require_once '../includes/config.php'; // Connexion à la base de données
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Fichier de langue

// Vérifier si l'utilisateur est connecté et est un professeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') {
    header("Location: ../authentification/login.php"); // Rediriger si non connecté ou pas professeur
    exit();
}

$prof_user_id = $_SESSION['user_id'];
// Utilisation de professeur_id pour les requêtes, comme discuté précédemment et supposé DB à jour
// Si votre colonne `emploi_du_temps.professeur_id` n'est PAS en place, utilisez $prof_full_name à la place de $prof_user_id
// $prof_full_name = $_SESSION['user_last_name'] . ' ' . $_SESSION['user_first_name'];


$success_message = '';
$error_message = '';
$selected_class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : '';
$selected_date = isset($_POST['absence_date']) ? $_POST['absence_date'] : date('Y-m-d');
$selected_creneau = isset($_POST['creneau']) ? $_POST['creneau'] : ''; // Format: "HH:MM-HH:MM"
$selected_matiere_id = isset($_POST['matiere_id']) ? intval($_POST['matiere_id']) : '';

// Définir les 4 créneaux standard avec leurs heures de début/fin
// Utiliser des formats HH:MM pour la comparaison, plus courant pour l'affichage et la saisie.
$standard_creneaux = [
    ['start' => '08:00', 'end' => '10:00', 'label' => 'Créneau 1 (08:00-10:00)'],
    ['start' => '10:00', 'end' => '12:00', 'label' => 'Créneau 2 (10:00-12:00)'],
    ['start' => '14:00', 'end' => '16:00', 'label' => 'Créneau 3 (14:00-16:00)'],
    ['start' => '16:00', 'end' => '18:00', 'label' => 'Créneau 4 (16:00-18:00)']
];

// Récupérer les classes
try {
    $stmt_classes = $pdo->query("SELECT id, nom_classe FROM classes ORDER BY nom_classe");
    $classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des classes.';
    error_log("Gestion Absences - Load Classes Error: " . $e->getMessage());
}

// Récupérer les matières et les détails de l'emploi du temps pour la classe, la date et le PROFESSEUR sélectionné
$matieres_for_selection = [];
$creneaux_edt_data = []; // Pour stocker les matières par créneau selon l'EDT
if ($selected_class_id && $selected_date) {
    try {
        $jour_semaine_num = date('N', strtotime($selected_date)); // 1 (pour Lundi) à 7 (pour Dimanche)
        $jours_map = [
            1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi',
            5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'
        ];
        $jour_actuel = $jours_map[$jour_semaine_num];

        // Requête ajustée pour récupérer directement les heures HH:MM
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
                edt.classe_id = ? AND edt.jour_semaine = ? AND edt.professeur_id = ?
            ORDER BY edt.heure_debut
        ");
        $stmt_edt_data->execute([$selected_class_id, $jour_actuel, $prof_user_id]); // Utilise prof_user_id
        $edt_entries = $stmt_edt_data->fetchAll(PDO::FETCH_ASSOC);

        // Organiser les matières par créneau pour les menus déroulants
        foreach ($edt_entries as $entry) {
            $creneau_key = $entry['heure_debut_formatted'] . '-' . $entry['heure_fin_formatted'];
            $creneaux_edt_data[$creneau_key] = [
                'matiere_id' => $entry['matiere_id'],
                'matiere_nom' => $entry['matiere_nom'],
                'heure_debut' => $entry['heure_debut_formatted'],
                'heure_fin' => $entry['heure_fin_formatted']
            ];
        }

        // Si un créneau est sélectionné, alors la matière sera automatiquement déterminée par l'EDT
        if ($selected_creneau) {
            if (isset($creneaux_edt_data[$selected_creneau])) {
                $matieres_for_selection[] = [
                    'id' => $creneaux_edt_data[$selected_creneau]['matiere_id'],
                    'nom' => $creneaux_edt_data[$selected_creneau]['matiere_nom']
                ];
                // Pré-sélectionner cette matière
                $selected_matiere_id = $creneaux_edt_data[$selected_creneau]['matiere_id'];
            } else {
                // Si le créneau sélectionné n'a pas de matière dans l'EDT pour ce prof
                // Cela peut arriver si l'utilisateur change de date après avoir sélectionné un créneau.
                // Réinitialiser $selected_matiere_id et $selected_creneau pour éviter des problèmes d'affichage.
                $selected_matiere_id = '';
                $selected_creneau = '';
                $error_message = $lang['no_matiere_for_creneau'] ?? 'Aucune matière assignée à ce créneau dans votre emploi du temps.';
            }
        }

    } catch (PDOException $e) {
        $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des matières de l\'emploi du temps.';
        error_log("Gestion Absences - Load EDT Matieres Error: " . $e->getMessage());
    }
}

// Traitement de la soumission du formulaire d'absences
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_absences'])) {
    $selected_class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : '';
    $selected_matiere_id = isset($_POST['matiere_id']) ? intval($_POST['matiere_id']) : '';
    $selected_date = isset($_POST['absence_date']) ? $_POST['absence_date'] : date('Y-m-d');
    $selected_creneau_post = isset($_POST['creneau']) ? $_POST['creneau'] : ''; // Créneau au format "HH:MM-HH:MM"
    $absent_students = isset($_POST['absent_students']) ? $_POST['absent_students'] : []; // Array of student_id
    $justified_absences = isset($_POST['justified_absences']) ? $_POST['justified_absences'] : []; // Array of student_id for justified

    if (empty($selected_class_id) || empty($selected_matiere_id) || empty($selected_date) || empty($selected_creneau_post)) {
        $error_message = $lang['form_empty_fields'] ?? 'Veuillez sélectionner une classe, une matière, une date et un créneau.';
    } else {
        // Extraire heure_debut et heure_fin du créneau
        list($heure_debut_creneau, $heure_fin_creneau) = explode('-', $selected_creneau_post);

        try {
            $pdo->beginTransaction();

            // Supprimer les absences existantes pour cette matière, date, créneau et les étudiants de cette classe
            $stmt_delete = $pdo->prepare("
                DELETE FROM absences
                WHERE matiere_id = ?
                AND date = ?
                AND heure_debut_creneau = ?
                AND heure_fin_creneau = ?
                AND etudiant_id IN (SELECT id FROM etudiants WHERE classe_id = ?)
            ");
            $stmt_delete->execute([
                $selected_matiere_id,
                $selected_date,
                $heure_debut_creneau,
                $heure_fin_creneau,
                $selected_class_id
            ]);

            if (!empty($absent_students)) {
                $stmt_insert = $pdo->prepare("INSERT INTO absences (etudiant_id, matiere_id, date, heure_debut_creneau, heure_fin_creneau, justifiee) VALUES (?, ?, ?, ?, ?, ?)");
                foreach ($absent_students as $student_id) {
                    $is_justified = in_array($student_id, $justified_absences) ? 1 : 0;
                    $stmt_insert->execute([
                        $student_id,
                        $selected_matiere_id,
                        $selected_date,
                        $heure_debut_creneau,
                        $heure_fin_creneau,
                        $is_justified
                    ]);
                }
            }

            $pdo->commit();
            $success_message = $lang['absences_saved_success'] ?? 'Absences enregistrées avec succès.';

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_message = $lang['db_error_save'] ?? 'Une erreur est survenue lors de l\'enregistrement des absences.';
            error_log("Save Absences Error: " . $e->getMessage());
        }
    }
}

// Récupérer les étudiants de la classe sélectionnée et leurs absences existantes pour le créneau
$students_in_class = [];
$existing_absences = [];
if ($selected_class_id) {
    try {
        $stmt_students = $pdo->prepare("SELECT id, nom, prenom FROM etudiants WHERE classe_id = ? ORDER BY nom, prenom");
        $stmt_students->execute([$selected_class_id]);
        $students_in_class = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

        if ($selected_matiere_id && $selected_date && $selected_creneau) {
            list($heure_debut_creneau_load, $heure_fin_creneau_load) = explode('-', $selected_creneau);

            $stmt_existing_abs = $pdo->prepare("
                SELECT etudiant_id, justifiee
                FROM absences
                WHERE etudiant_id IN (SELECT id FROM etudiants WHERE classe_id = ?)
                AND matiere_id = ?
                AND date = ?
                AND heure_debut_creneau = ?
                AND heure_fin_creneau = ?
            ");
            $stmt_existing_abs->execute([
                $selected_class_id,
                $selected_matiere_id,
                $selected_date,
                $heure_debut_creneau_load,
                $heure_fin_creneau_load
            ]);
            foreach ($stmt_existing_abs->fetchAll(PDO::FETCH_ASSOC) as $abs) {
                $existing_absences[$abs['etudiant_id']] = $abs['justifiee'];
            }
        }
    } catch (PDOException $e) {
        $error_message = $lang['db_error_load_students'] ?? 'Erreur lors du chargement des étudiants ou des absences existantes.';
        error_log("Load Students/Absences Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['manage_absences'] ?? 'Gestion des Absences') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .form-label {
            font-weight: bold;
        }
        .student-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .student-item {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .student-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($lang['manage_absences'] ?? 'Gestion des Absences') ?></h2>

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

        <form action="" method="POST" id="absenceForm">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="class_id" class="form-label"><?= htmlspecialchars($lang['select_class'] ?? 'Sélectionner une Classe') ?> :</label>
                    <select class="form-select" id="class_id" name="class_id" required onchange="this.form.submit()">
                        <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= htmlspecialchars($class['id']) ?>" <?= ($selected_class_id == $class['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['nom_classe']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="absence_date" class="form-label"><?= htmlspecialchars($lang['select_date'] ?? 'Sélectionner la Date') ?> :</label>
                    <input type="date" class="form-control" id="absence_date" name="absence_date" value="<?= htmlspecialchars($selected_date) ?>" required onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <label for="creneau" class="form-label"><?= htmlspecialchars($lang['select_creneau'] ?? 'Sélectionner le Créneau') ?> :</label>
                    <select class="form-select" id="creneau" name="creneau" required onchange="this.form.submit()">
                        <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                        <?php foreach ($standard_creneaux as $creneau_data):
                            // Assurez-vous que les heures dans $creneaux_edt_data sont au format HH:MM
                            $creneau_value = $creneau_data['start'] . '-' . $creneau_data['end'];
                            // N'afficher ce créneau que s'il est trouvé dans l'emploi du temps pour ce prof/classe/jour
                            if (isset($creneaux_edt_data[$creneau_value])) :
                        ?>
                            <option value="<?= htmlspecialchars($creneau_value) ?>" <?= ($selected_creneau == $creneau_value) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($creneau_data['label'] . ' - ' . $creneaux_edt_data[$creneau_value]['matiere_nom']) ?>
                            </option>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </select>
                </div>
                 <div class="col-md-3">
                    <label for="matiere_id" class="form-label"><?= htmlspecialchars($lang['selected_matiere'] ?? 'Matière du Créneau') ?> :</label>
                    <select class="form-select" id="matiere_id" name="matiere_id" required>
                        <?php if (empty($matieres_for_selection) || !$selected_creneau): ?>
                             <option value="">-- <?= htmlspecialchars($lang['choose_creneau_first'] ?? 'Choisir un créneau') ?> --</option>
                        <?php else: ?>
                            <?php foreach ($matieres_for_selection as $matiere): ?>
                                <option value="<?= htmlspecialchars($matiere['id']) ?>" selected>
                                    <?= htmlspecialchars($matiere['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <small class="form-text text-muted">
                        <?= htmlspecialchars($lang['matiere_auto_selected'] ?? 'La matière est automatiquement sélectionnée en fonction du créneau et de l\'emploi du temps.') ?>
                    </small>
                </div>
            </div>

            <?php if (!empty($selected_class_id) && !empty($selected_date) && empty($creneaux_edt_data)): ?>
                <div class="alert alert-warning mt-4">
                    <?= htmlspecialchars($lang['no_edt_for_class_date_prof'] ?? 'Aucun emploi du temps trouvé pour cette classe, cette date et votre profil d\'enseignant.') ?>
                </div>
            <?php elseif (!empty($selected_class_id) && !empty($selected_date) && !empty($selected_creneau) && empty($matieres_for_selection)): ?>
                 <div class="alert alert-warning mt-4">
                    <?= htmlspecialchars($lang['no_matiere_for_creneau'] ?? 'Aucune matière assignée à ce créneau dans votre emploi du temps.') ?>
                </div>
            <?php elseif (!empty($students_in_class) && !empty($selected_matiere_id) && !empty($selected_creneau)): ?>
                <h4 class="mt-4 mb-3"><?= htmlspecialchars($lang['students_in_class'] ?? 'Étudiants de la Classe') ?> :</h4>
                <div class="student-list">
                    <?php foreach ($students_in_class as $student): ?>
                        <?php
                        $is_absent = isset($existing_absences[$student['id']]);
                        $is_justified = $is_absent && $existing_absences[$student['id']] == 1;
                        ?>
                        <div class="student-item">
                            <div>
                                <input type="checkbox" id="student_<?= htmlspecialchars($student['id']) ?>" name="absent_students[]" value="<?= htmlspecialchars($student['id']) ?>" class="form-check-input me-2" <?= $is_absent ? 'checked' : '' ?>>
                                <label for="student_<?= htmlspecialchars($student['id']) ?>"><?= htmlspecialchars($student['nom'] . ' ' . $student['prenom']) ?></label>
                            </div>
                            <div>
                                <input type="checkbox" id="justified_<?= htmlspecialchars($student['id']) ?>" name="justified_absences[]" value="<?= htmlspecialchars($student['id']) ?>" class="form-check-input me-2" <?= $is_justified ? 'checked' : '' ?> <?= $is_absent ? '' : 'disabled' ?>>
                                <label for="justified_<?= htmlspecialchars($student['id']) ?>"><?= htmlspecialchars($lang['justified'] ?? 'Justifiée') ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" name="save_absences" class="btn btn-primary btn-lg"><?= htmlspecialchars($lang['save_absences'] ?? 'Enregistrer les Absences') ?></button>
                </div>
            <?php elseif ($selected_class_id && empty($students_in_class)): ?>
                <div class="alert alert-info mt-4">
                    <?= htmlspecialchars($lang['no_students_in_class'] ?? 'Aucun étudiant trouvé pour cette classe.') ?>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const absenceForm = document.getElementById('absenceForm');
            if (absenceForm) {
                absenceForm.addEventListener('change', function(event) {
                    const target = event.target;

                    // If a student absence checkbox is changed
                    if (target.matches('input[name="absent_students[]"]')) {
                        const studentId = target.value;
                        const justifiedCheckbox = document.getElementById('justified_' + studentId);
                        if (justifiedCheckbox) {
                            justifiedCheckbox.disabled = !target.checked;
                            if (!target.checked) {
                                justifiedCheckbox.checked = false; // Uncheck if student is not absent
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>