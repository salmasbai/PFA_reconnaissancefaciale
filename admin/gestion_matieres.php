<?php
session_start();
require_once '../includes/config.php';
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";
/*
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}*/

$success_message = '';
$error_message = '';
$edit_matiere = null;

// Récupérer toutes les classes pour le sélecteur d'association
try {
    $stmt_classes = $pdo->query("SELECT id, nom_classe FROM classes ORDER BY nom_classe");
    $all_classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des classes.';
    error_log("Gestion Matieres - Load Classes Error: " . $e->getMessage());
}

// --- Traitement des actions (Ajout, Modification, Suppression) ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_matiere'])) {
        $nom = trim($_POST['nom']);
        $code = trim($_POST['code']);
        $selected_classes = isset($_POST['classes']) ? (array)$_POST['classes'] : [];

        if (empty($nom) || empty($code)) {
            $error_message = $lang['form_empty_fields'] ?? 'Veuillez remplir le nom et le code de la matière.';
        } else {
            try {
                $pdo->beginTransaction();

                // Insérer la matière
                $stmt = $pdo->prepare("INSERT INTO matieres (nom, code) VALUES (?, ?)");
                $stmt->execute([$nom, $code]);
                $matiere_id = $pdo->lastInsertId();

                // Lier la matière aux classes sélectionnées
                if (!empty($selected_classes)) {
                    $stmt_link = $pdo->prepare("INSERT INTO classe_matiere (classe_id, matiere_id) VALUES (?, ?)");
                    foreach ($selected_classes as $classe_id) {
                        $stmt_link->execute([$classe_id, $matiere_id]);
                    }
                }

                $pdo->commit();
                $success_message = $lang['matiere_added_success'] ?? 'Matière ajoutée avec succès.';
            } catch (PDOException $e) {
                $pdo->rollBack();
                if ($e->getCode() == '23000') {
                    $error_message = $lang['matiere_exists_error'] ?? 'Une matière avec ce code existe déjà.';
                } else {
                    $error_message = $lang['db_error_add'] ?? 'Erreur lors de l\'ajout de la matière.';
                    error_log("Add Matiere Error: " . $e->getMessage());
                }
            }
        }
    } elseif (isset($_POST['update_matiere'])) {
        $id = intval($_POST['id']);
        $nom = trim($_POST['nom']);
        $code = trim($_POST['code']);
        $selected_classes = isset($_POST['classes']) ? (array)$_POST['classes'] : [];

        if (empty($nom) || empty($code) || empty($id)) {
            $error_message = $lang['form_empty_fields'] ?? 'Veuillez remplir tous les champs nécessaires pour la modification.';
        } else {
            try {
                $pdo->beginTransaction();

                // Mettre à jour la matière
                $stmt = $pdo->prepare("UPDATE matieres SET nom = ?, code = ? WHERE id = ?");
                $stmt->execute([$nom, $code, $id]);

                // Mettre à jour les liens classe_matiere
                $stmt_delete_links = $pdo->prepare("DELETE FROM classe_matiere WHERE matiere_id = ?");
                $stmt_delete_links->execute([$id]);

                if (!empty($selected_classes)) {
                    $stmt_insert_links = $pdo->prepare("INSERT INTO classe_matiere (classe_id, matiere_id) VALUES (?, ?)");
                    foreach ($selected_classes as $classe_id) {
                        $stmt_insert_links->execute([$classe_id, $id]);
                    }
                }

                $pdo->commit();
                $success_message = $lang['matiere_updated_success'] ?? 'Matière mise à jour avec succès.';
                $edit_matiere = null; // Sortir du mode édition
            } catch (PDOException $e) {
                $pdo->rollBack();
                if ($e->getCode() == '23000') {
                    $error_message = $lang['matiere_exists_error'] ?? 'Une matière avec ce code existe déjà.';
                } else {
                    $error_message = $lang['db_error_update'] ?? 'Erreur lors de la mise à jour de la matière.';
                    error_log("Update Matiere Error: " . $e->getMessage());
                }
            }
        }
    } elseif (isset($_POST['delete_matiere'])) {
        $id = intval($_POST['id']);
        try {
            $pdo->beginTransaction();
            // Supprimer les liens dans classe_matiere en premier
            $stmt_delete_links = $pdo->prepare("DELETE FROM classe_matiere WHERE matiere_id = ?");
            $stmt_delete_links->execute([$id]);

            // Ensuite, supprimer la matière elle-même
            $stmt = $pdo->prepare("DELETE FROM matieres WHERE id = ?");
            $stmt->execute([$id]);

            $pdo->commit();
            $success_message = $lang['matiere_deleted_success'] ?? 'Matière supprimée avec succès.';
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_message = $lang['db_error_delete'] ?? 'Erreur lors de la suppression de la matière. Assurez-vous qu\'elle n\'est pas utilisée ailleurs (ex: emploi du temps, absences).';
            error_log("Delete Matiere Error: " . $e->getMessage());
        }
    }
}

// --- Mode Édition (Si un ID est passé via GET pour édition) ---
$matiere_classes = []; // Classes associées à la matière en édition
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $matiere_id = intval($_GET['id']);
    try {
        $stmt = $pdo->prepare("SELECT id, nom, code FROM matieres WHERE id = ?");
        $stmt->execute([$matiere_id]);
        $edit_matiere = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($edit_matiere) {
            // Récupérer les classes déjà associées à cette matière
            $stmt_matiere_classes = $pdo->prepare("SELECT classe_id FROM classe_matiere WHERE matiere_id = ?");
            $stmt_matiere_classes->execute([$matiere_id]);
            $matiere_classes = array_column($stmt_matiere_classes->fetchAll(PDO::FETCH_ASSOC), 'classe_id');
        } else {
            $error_message = $lang['matiere_not_found'] ?? 'Matière non trouvée pour édition.';
        }
    } catch (PDOException $e) {
        $error_message = $lang['db_error_load'] ?? 'Erreur lors du chargement de la matière pour édition.';
        error_log("Load Matiere for Edit Error: " . $e->getMessage());
    }
}

// --- Récupérer toutes les matières pour l'affichage (avec leurs classes associées) ---
$matieres = [];
try {
    $stmt_matieres = $pdo->query("SELECT id, nom, code FROM matieres ORDER BY nom");
    $matieres = $stmt_matieres->fetchAll(PDO::FETCH_ASSOC);

    // Pour chaque matière, récupérer les noms des classes associées
    foreach ($matieres as $key => $matiere) {
        $stmt_linked_classes = $pdo->prepare("
            SELECT c.nom_classe
            FROM classe_matiere cm
            JOIN classes c ON cm.classe_id = c.id
            WHERE cm.matiere_id = ?
            ORDER BY c.nom_classe
        ");
        $stmt_linked_classes->execute([$matiere['id']]);
        $matieres[$key]['linked_classes'] = array_column($stmt_linked_classes->fetchAll(PDO::FETCH_ASSOC), 'nom_classe');
    }

} catch (PDOException $e) {
    $error_message = $lang['db_error'] ?? 'Une erreur de base de données est survenue lors du chargement des matières.';
    error_log("Gestion Matieres - Load All Matieres Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['manage_matieres'] ?? 'Gestion des Matières') ?></title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($lang['manage_matieres'] ?? 'Gestion des Matières') ?></h2>

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
                <h4 class="mb-0"><?= htmlspecialchars($edit_matiere ? ($lang['edit_matiere'] ?? 'Modifier une Matière') : ($lang['add_matiere'] ?? 'Ajouter une Matière')) ?></h4>
            </div>
            <div class="card-body">
                <form action="gestion_matieres.php" method="POST">
                    <?php if ($edit_matiere): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($edit_matiere['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="nom" class="form-label"><?= htmlspecialchars($lang['matiere_name'] ?? 'Nom de la Matière') ?> :</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($edit_matiere['nom'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label"><?= htmlspecialchars($lang['matiere_code'] ?? 'Code de la Matière') ?> :</label>
                        <input type="text" class="form-control" id="code" name="code" value="<?= htmlspecialchars($edit_matiere['code'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?= htmlspecialchars($lang['classes_concerned'] ?? 'Classes Concernées') ?> :</label>
                        <div class="form-check-scrollable" style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                            <?php foreach ($all_classes as $class): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="classes[]" value="<?= htmlspecialchars($class['id']) ?>" id="class_<?= htmlspecialchars($class['id']) ?>"
                                        <?php if ($edit_matiere && in_array($class['id'], $matiere_classes)) echo 'checked'; ?>>
                                    <label class="form-check-label" for="class_<?= htmlspecialchars($class['id']) ?>">
                                        <?= htmlspecialchars($class['nom_classe']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if ($edit_matiere): ?>
                        <button type="submit" name="update_matiere" class="btn btn-primary"><?= htmlspecialchars($lang['update'] ?? 'Mettre à jour') ?></button>
                        <a href="gestion_matieres.php" class="btn btn-outline-primary ms-2"><?= htmlspecialchars($lang['cancel'] ?? 'Annuler') ?></a>
                    <?php else: ?>
                        <button type="submit" name="add_matiere" class="btn btn-primary"><?= htmlspecialchars($lang['add'] ?? 'Ajouter') ?></button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <h3 class="mb-3"><?= htmlspecialchars($lang['current_matieres'] ?? 'Matières Actuelles') ?></h3>
        <?php if (!empty($matieres)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['id'] ?? 'ID') ?></th>
                            <th><?= htmlspecialchars($lang['matiere_name'] ?? 'Nom de la Matière') ?></th>
                            <th><?= htmlspecialchars($lang['matiere_code'] ?? 'Code') ?></th>
                            <th><?= htmlspecialchars($lang['classes_concerned_short'] ?? 'Classes') ?></th>
                            <th><?= htmlspecialchars($lang['actions'] ?? 'Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matieres as $matiere): ?>
                            <tr>
                                <td><?= htmlspecialchars($matiere['id']) ?></td>
                                <td><?= htmlspecialchars($matiere['nom']) ?></td>
                                <td><?= htmlspecialchars($matiere['code']) ?></td>
                                <td><?= !empty($matiere['linked_classes']) ? htmlspecialchars(implode(', ', $matiere['linked_classes'])) : ($lang['no_classes_assigned'] ?? 'Aucune') ?></td>
                                <td>
                                    <a href="gestion_matieres.php?action=edit&id=<?= htmlspecialchars($matiere['id']) ?>" class="btn btn-sm btn-outline-primary me-1"><?= htmlspecialchars($lang['edit'] ?? 'Modifier') ?></a>
                                    <form action="gestion_matieres.php" method="POST" class="d-inline" onsubmit="return confirm('<?= htmlspecialchars($lang['confirm_delete_matiere'] ?? 'Êtes-vous sûr de vouloir supprimer cette matière ?') ?>');">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($matiere['id']) ?>">
                                        <button type="submit" name="delete_matiere" class="btn btn-sm btn-danger"><?= htmlspecialchars($lang['delete'] ?? 'Supprimer') ?></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info"><?= htmlspecialchars($lang['no_matieres'] ?? 'Aucune matière enregistrée pour le moment.') ?></div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>