<?php
session_start();
require_once '../includes/config.php'; // Connexion à la base de données
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php"; // Fichier de langue

// Vérifier si l'utilisateur est connecté et est un professeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') {
    header("Location: ../login.php"); // Rediriger si non connecté ou pas professeur
    exit();
}

$prof_user_id = $_SESSION['user_id'];
$success_message = ''; // Not typically used for viewing pages, but kept for consistency
$error_message = '';

$selected_class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : '';
$selected_start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01'); // Début du mois actuel par défaut
$selected_end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d'); // Aujourd'hui par défaut
$selected_matiere_id = isset($_POST['matiere_id']) ? intval($_POST['matiere_id']) : '';


// Récupérer les classes que le professeur enseigne (celles où il est listé dans l'emploi du temps)
$classes_enseignees = [];
try {
    $stmt_classes = $pdo->prepare("
        SELECT DISTINCT c.id, c.nom_classe
        FROM classes c
        JOIN emploi_du_temps edt ON c.id = edt.classe_id
        WHERE edt.professeur_id = ?
        ORDER BY c.nom_classe
    ");
    $stmt_classes->execute([$prof_user_id]);
    $classes_enseignees = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des classes.';
    error_log("Voir Absences - Load Classes Error: " . $e->getMessage());
}

// Récupérer les matières que le professeur enseigne dans la classe sélectionnée (via emploi du temps)
$matieres_enseignees = [];
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
        $matieres_enseignees = $stmt_matieres->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des matières.';
        error_log("Voir Absences - Load Matieres Error: " . $e->getMessage());
    }
}

// Récupérer les absences en fonction des sélections
$absences_data = [];
if ($selected_class_id && $selected_matiere_id && $selected_start_date && $selected_end_date) {
    try {
        $stmt_absences = $pdo->prepare("
            SELECT
                a.date,
                a.heure_debut_creneau,
                a.heure_fin_creneau,
                a.justifiee,
                e.nom AS etudiant_nom,
                e.prenom AS etudiant_prenom,
                m.nom AS matiere_nom,
                c.nom_classe AS classe_nom
            FROM
                absences a
            JOIN
                etudiants e ON a.etudiant_id = e.id
            JOIN
                matieres m ON a.matiere_id = m.id
            JOIN
                classes c ON e.classe_id = c.id
            WHERE
                e.classe_id = ?
                AND a.matiere_id = ?
                AND a.date BETWEEN ? AND ?
            ORDER BY
                a.date DESC, a.heure_debut_creneau ASC, e.nom ASC
        ");
        $stmt_absences->execute([
            $selected_class_id,
            $selected_matiere_id,
            $selected_start_date,
            $selected_end_date
        ]);
        $absences_data = $stmt_absences->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des absences.';
        error_log("Voir Absences - Load Absences Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['view_absences'] ?? 'Voir les Absences') ?></title>
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
        .status-justified {
            color: green;
            font-weight: bold;
        }
        .status-unjustified {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($lang['view_absences'] ?? 'Voir les Absences') ?></h2>

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

        <form action="" method="POST" id="filterAbsencesForm">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="class_id" class="form-label"><?= htmlspecialchars($lang['select_class'] ?? 'Sélectionner une Classe') ?> :</label>
                    <select class="form-select" id="class_id" name="class_id" required onchange="this.form.submit()">
                        <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                        <?php foreach ($classes_enseignees as $class): ?>
                            <option value="<?= htmlspecialchars($class['id']) ?>" <?= ($selected_class_id == $class['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['nom_classe']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="matiere_id" class="form-label"><?= htmlspecialchars($lang['select_matiere'] ?? 'Sélectionner une Matière') ?> :</label>
                    <select class="form-select" id="matiere_id" name="matiere_id" required onchange="this.form.submit()">
                        <option value="">-- <?= htmlspecialchars($lang['choose'] ?? 'Choisir') ?> --</option>
                        <?php foreach ($matieres_enseignees as $matiere): ?>
                            <option value="<?= htmlspecialchars($matiere['id']) ?>" <?= ($selected_matiere_id == $matiere['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($matiere['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="start_date" class="form-label"><?= htmlspecialchars($lang['start_date'] ?? 'Date de début') ?> :</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($selected_start_date) ?>" required onchange="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label"><?= htmlspecialchars($lang['end_date'] ?? 'Date de fin') ?> :</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($selected_end_date) ?>" required onchange="this.form.submit()">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg"><?= htmlspecialchars($lang['filter_absences'] ?? 'Filtrer les Absences') ?></button>
            </div>
        </form>

        <?php if (!empty($absences_data)): ?>
            <h4 class="mt-4 mb-3"><?= htmlspecialchars($lang['absences_list'] ?? 'Liste des Absences') ?> :</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['student'] ?? 'Étudiant') ?></th>
                            <th><?= htmlspecialchars($lang['class'] ?? 'Classe') ?></th>
                            <th><?= htmlspecialchars($lang['matiere'] ?? 'Matière') ?></th>
                            <th><?= htmlspecialchars($lang['date'] ?? 'Date') ?></th>
                            <th><?= htmlspecialchars($lang['creneau'] ?? 'Créneau') ?></th>
                            <th><?= htmlspecialchars($lang['status'] ?? 'Statut') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absences_data as $absence): ?>
                            <tr>
                                <td><?= htmlspecialchars($absence['etudiant_nom'] . ' ' . $absence['etudiant_prenom']) ?></td>
                                <td><?= htmlspecialchars($absence['classe_nom']) ?></td>
                                <td><?= htmlspecialchars($absence['matiere_nom']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($absence['date']))) ?></td>
                                <td><?= htmlspecialchars(substr($absence['heure_debut_creneau'], 0, 5) . '-' . substr($absence['heure_fin_creneau'], 0, 5)) ?></td>
                                <td>
                                    <?php if ($absence['justifiee']): ?>
                                        <span class="status-justified"><?= htmlspecialchars($lang['justified'] ?? 'Justifiée') ?></span>
                                    <?php else: ?>
                                        <span class="status-unjustified"><?= htmlspecialchars($lang['unjustified'] ?? 'Non Justifiée') ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($selected_class_id && $selected_matiere_id && $selected_start_date && $selected_end_date): ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars($lang['no_absences_found'] ?? 'Aucune absence trouvée pour cette sélection.') ?>
            </div>
        <?php else: ?>
             <div class="alert alert-info mt-4">
                <?= htmlspecialchars($lang['select_filters_to_view_absences'] ?? 'Veuillez sélectionner une classe, une matière et une période pour voir les absences.') ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>