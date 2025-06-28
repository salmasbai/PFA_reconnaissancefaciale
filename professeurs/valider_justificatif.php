<?php
session_start();
require_once '../includes/config.php';
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";

// Vérifier si l'utilisateur est connecté et est un professeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'professeur') {
    // Stocke l'URL de la page actuelle dans la session avant la redirection
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: ../authentification/login.php");
    exit();
}

$prof_user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// --- Récupérer les ID de matières enseignées par le professeur ---
$prof_matiere_ids = [];
try {
    $stmt_prof_matieres = $pdo->prepare("SELECT DISTINCT matiere_id FROM emploi_du_temps WHERE professeur_id = ?");
    $stmt_prof_matieres->execute([$prof_user_id]);
    $prof_matiere_ids = $stmt_prof_matieres->fetchAll(PDO::FETCH_COLUMN);

    if (empty($prof_matiere_ids)) {
        $error_message = $lang['no_courses_assigned'] ?? 'Vous n\'avez aucun cours assigné pour valider des justificatifs.';
    }
} catch (PDOException $e) {
    $error_message = $lang['db_error_load_prof_matieres'] ?? 'Erreur de base de données lors du chargement de vos matières enseignées.';
    error_log("Validate Justification - Load Prof Matieres Error: " . $e->getMessage());
}

// Traitement de l'action de validation/rejet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $justificatif_id = isset($_POST['justificatif_id']) ? intval($_POST['justificatif_id']) : 0;
    $action = $_POST['action']; // 'approve' ou 'reject'
    $commentaire = trim($_POST['commentaire'] ?? '');

    if ($justificatif_id === 0) {
        $error_message = $lang['invalid_justification_id'] ?? 'ID de justificatif invalide.';
    } else {
        try {
            $pdo->beginTransaction();

            // 1. Récupérer les détails du justificatif pour vérification et pour obtenir l'absence_id et matiere_id
            $stmt_get_justif = $pdo->prepare("
                SELECT j.etudiant_id, j.absence_id, j.matiere_id, j.statut,
                       a.date, a.heure_debut_creneau, a.heure_fin_creneau
                FROM justificatifs j
                LEFT JOIN absences a ON j.absence_id = a.id
                WHERE j.id = ? AND j.statut = 'en attente'
            ");
            $stmt_get_justif->execute([$justificatif_id]);
            $justif_data = $stmt_get_justif->fetch(PDO::FETCH_ASSOC);

            if (!$justif_data) {
                $error_message = $lang['justification_not_found_or_processed'] ?? 'Justificatif non trouvé ou déjà traité.';
                $pdo->rollBack();
            }
            // Vérification si le professeur est autorisé à valider cette matière
            elseif (!in_array($justif_data['matiere_id'], $prof_matiere_ids)) {
                $error_message = $lang['not_authorized_to_validate'] ?? 'Vous n\'êtes pas autorisé à valider ce justificatif (matière non enseignée).';
                $pdo->rollBack();
            }
            else {
                // 2. Mettre à jour le statut du justificatif
                $new_status = ($action === 'approve') ? 'approuve' : 'rejete';
                $stmt_update_justif = $pdo->prepare("UPDATE justificatifs SET statut = ?, commentaire_admin = ? WHERE id = ?");
                $stmt_update_justif->execute([$new_status, $commentaire, $justificatif_id]);

                // 3. Si approuvé, et si une absence_id est liée, mettre à jour le statut 'justifiee' dans la table 'absences'
                if ($action === 'approve' && $justif_data['absence_id']) {
                    $stmt_update_absence = $pdo->prepare("UPDATE absences SET justifiee = 1 WHERE id = ?");
                    $stmt_update_absence->execute([$justif_data['absence_id']]);
                }

                $pdo->commit();
                $success_message = ($action === 'approve') ?
                    ($lang['justification_approved_success'] ?? 'Justificatif approuvé avec succès.') :
                    ($lang['justification_rejected_success'] ?? 'Justificatif rejeté avec succès.');
            }

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_message = $lang['db_error_validation'] ?? 'Erreur de base de données lors de la validation du justificatif.';
            error_log("Validate Justification Error: " . $e->getMessage());
        }
    }
}


// --- Récupérer les justificatifs en attente et traités pour affichage ---
$justificatifs_en_attente = [];
$justificatifs_traites = [];

if (!empty($prof_matiere_ids)) { // Seulement si le prof enseigne des matières
    try {
        $in_clause = implode(',', array_fill(0, count($prof_matiere_ids), '?'));

        $stmt_justifs = $pdo->prepare("
            SELECT
                j.id AS justificatif_id,
                j.date_absence,
                j.heure_debut_creneau,
                j.heure_fin_creneau,
                j.motif,
                j.chemin_fichier,
                j.date_soumission,
                j.statut,
                j.commentaire_admin,
                e.nom AS etudiant_nom,
                e.prenom AS etudiant_prenom,
                m.nom AS matiere_nom,
                c.nom_classe AS classe_nom
            FROM
                justificatifs j
            JOIN
                etudiants etu ON j.etudiant_id = etu.id
            JOIN
                utilisateurs e ON etu.user_id = e.id
            LEFT JOIN
                matieres m ON j.matiere_id = m.id
            LEFT JOIN
                classes c ON etu.classe_id = c.id
            WHERE
                j.matiere_id IN ($in_clause)
            ORDER BY j.date_soumission DESC
        ");
        $stmt_justifs->execute($prof_matiere_ids);
        $all_justificatifs = $stmt_justifs->fetchAll(PDO::FETCH_ASSOC);

        foreach ($all_justificatifs as $justif) {
            if ($justif['statut'] === 'en attente') {
                $justificatifs_en_attente[] = $justif;
            } else {
                $justificatifs_traites[] = $justif;
            }
        }
    } catch (PDOException $e) {
        $error_message = $lang['db_error_load_justifs'] ?? 'Erreur de base de données lors du chargement des justificatifs.';
        error_log("Load Justificatifs Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['validate_justifications'] ?? 'Valider les Justificatifs') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
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
        .comment-section {
            margin-top: 10px;
            font-size: 0.85em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><i class="bi bi-patch-check-fill me-2"></i> <?= htmlspecialchars($lang['validate_justifications'] ?? 'Valider les Justificatifs') ?></h2>

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

        <h3 class="mb-3 mt-4"><i class="bi bi-hourglass-split me-2 text-warning"></i> <?= htmlspecialchars($lang['pending_justifications'] ?? 'Justificatifs en Attente') ?></h3>
        <?php if (!empty($justificatifs_en_attente)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['student'] ?? 'Étudiant') ?></th>
                            <th><?= htmlspecialchars($lang['class'] ?? 'Classe') ?></th>
                            <th><?= htmlspecialchars($lang['date_absence_short'] ?? 'Date Abs.') ?></th>
                            <th><?= htmlspecialchars($lang['creneau'] ?? 'Créneau') ?></th>
                            <th><?= htmlspecialchars($lang['course'] ?? 'Cours') ?></th>
                            <th><?= htmlspecialchars($lang['motif'] ?? 'Motif') ?></th>
                            <th><?= htmlspecialchars($lang['submission_date_short'] ?? 'Date Soum.') ?></th>
                            <th><?= htmlspecialchars($lang['file'] ?? 'Fichier') ?></th>
                            <th><?= htmlspecialchars($lang['actions'] ?? 'Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($justificatifs_en_attente as $justif): ?>
                            <tr>
                                <td><?= htmlspecialchars($justif['etudiant_nom'] . ' ' . $justif['etudiant_prenom']) ?></td>
                                <td><?= htmlspecialchars($justif['classe_nom'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($justif['date_absence']))) ?></td>
                                <td><?= htmlspecialchars(substr($justif['heure_debut_creneau'], 0, 5) . '-' . substr($justif['heure_fin_creneau'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars($justif['matiere_nom'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($justif['motif'] ?: '-') ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($justif['date_soumission']))) ?></td>
                                <td>
                                    <?php if ($justif['chemin_fichier']): ?>
                                        <a href="../<?= htmlspecialchars($justif['chemin_fichier']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye me-1"></i> <?= htmlspecialchars($lang['view'] ?? 'Voir') ?>
                                        </a>
                                    <?php else: ?>
                                        <?= htmlspecialchars($lang['no_file'] ?? 'Aucun') ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="" method="POST" onsubmit="return confirm('<?= htmlspecialchars($lang['confirm_approve'] ?? 'Confirmer l\'approbation de ce justificatif ?') ?>');">
                                        <input type="hidden" name="justificatif_id" value="<?= htmlspecialchars($justif['justificatif_id']) ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <textarea name="commentaire" class="form-control mb-1" placeholder="<?= htmlspecialchars($lang['optional_comment'] ?? 'Commentaire (optionnel)') ?>" rows="1"></textarea>
                                        <button type="submit" class="btn btn-sm btn-success w-100 mb-1"><i class="bi bi-check-lg"></i> <?= htmlspecialchars($lang['approve'] ?? 'Approuver') ?></button>
                                    </form>
                                    <form action="" method="POST" onsubmit="return confirm('<?= htmlspecialchars($lang['confirm_reject'] ?? 'Confirmer le rejet de ce justificatif ?') ?>');">
                                        <input type="hidden" name="justificatif_id" value="<?= htmlspecialchars($justif['justificatif_id']) ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <textarea name="commentaire" class="form-control mb-1" placeholder="<?= htmlspecialchars($lang['optional_comment'] ?? 'Commentaire (optionnel)') ?>" rows="1"></textarea>
                                        <button type="submit" class="btn btn-sm btn-danger w-100"><i class="bi bi-x-lg"></i> <?= htmlspecialchars($lang['reject'] ?? 'Rejeter') ?></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info"><?= htmlspecialchars($lang['no_pending_justifications'] ?? 'Aucun justificatif en attente de validation pour le moment.') ?></div>
        <?php endif; ?>

        <h3 class="mb-3 mt-4"><i class="bi bi-clock-history me-2 text-info"></i> <?= htmlspecialchars($lang['processed_justifications'] ?? 'Justificatifs Traités') ?></h3>
        <?php if (!empty($justificatifs_traites)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['student'] ?? 'Étudiant') ?></th>
                            <th><?= htmlspecialchars($lang['class'] ?? 'Classe') ?></th>
                            <th><?= htmlspecialchars($lang['date_absence_short'] ?? 'Date Abs.') ?></th>
                            <th><?= htmlspecialchars($lang['creneau'] ?? 'Créneau') ?></th>
                            <th><?= htmlspecialchars($lang['course'] ?? 'Cours') ?></th>
                            <th><?= htmlspecialchars($lang['status'] ?? 'Statut') ?></th>
                            <th><?= htmlspecialchars($lang['admin_comment'] ?? 'Commentaire Prof.') ?></th>
                            <th><?= htmlspecialchars($lang['file'] ?? 'Fichier') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($justificatifs_traites as $justif): ?>
                            <tr>
                                <td><?= htmlspecialchars($justif['etudiant_nom'] . ' ' . $justif['etudiant_prenom']) ?></td>
                                <td><?= htmlspecialchars($justif['classe_nom'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($justif['date_absence']))) ?></td>
                                <td><?= htmlspecialchars(substr($justif['heure_debut_creneau'], 0, 5) . '-' . substr($justif['heure_fin_creneau'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars($justif['matiere_nom'] ?? 'N/A') ?></td>
                                <td>
                                    <?php
                                    $status_class = '';
                                    $status_text = '';
                                    if ($justif['statut'] == 'approuve') {
                                        $status_class = 'badge-status-approved';
                                        $status_text = $lang['approved'] ?? 'Approuvé';
                                    } else { // rejete
                                        $status_class = 'badge-status-rejected';
                                        $status_text = $lang['rejected'] ?? 'Rejeté';
                                    }
                                    echo '<span class="badge ' . $status_class . '">' . htmlspecialchars($status_text) . '</span>';
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($justif['commentaire_admin'] ?: '-') ?></td>
                                <td>
                                    <?php if ($justif['chemin_fichier']): ?>
                                        <a href="../<?= htmlspecialchars($justif['chemin_fichier']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye me-1"></i> <?= htmlspecialchars($lang['view'] ?? 'Voir') ?>
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
            <div class="alert alert-info"><?= htmlspecialchars($lang['no_processed_justifications'] ?? 'Aucun justificatif n\'a été traité pour le moment.') ?></div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>