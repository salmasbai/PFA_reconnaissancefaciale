<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth_middleware.php';

$matiereId = filter_input(INPUT_GET, 'matiere_id', FILTER_VALIDATE_INT);
$stmt = $pdo->prepare("SELECT * FROM matieres WHERE id = ? AND professeur_id = ?");
$stmt->execute([$matiereId, $_SESSION['user']['id']]);
$matiere = $stmt->fetch();

if (!$matiere) {
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement du formulaire d'absence
}

$stmt = $pdo->prepare("
    SELECT e.* FROM etudiants e
    JOIN etudiant_matiere em ON e.id = em.etudiant_id
    WHERE em.matiere_id = ?
");
$stmt->execute([$matiereId]);
$etudiants = $stmt->fetchAll();

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="card">
    <div class="card-header">
        Saisie des absences - <?= htmlspecialchars($matiere['nom']) ?>
    </div>
    <div class="card-body">
        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Présent</th>
                        <th>Commentaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($etudiants as $etudiant): ?>
                    <tr>
                        <td><?= htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']) ?></td>
                        <td>
                            <input type="checkbox" name="presence[<?= $etudiant['id'] ?>]" checked>
                        </td>
                        <td>
                            <input type="text" name="comment[<?= $etudiant['id'] ?>]" class="form-control">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>