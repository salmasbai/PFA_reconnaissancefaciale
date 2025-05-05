<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth_middleware.php';

// Récupération des données selon le rôle
$user = $_SESSION['user'];
$data = [];

if ($user['role'] === 'professeur') {
    $stmt = $pdo->prepare("SELECT * FROM matieres WHERE professeur_id = ?");
    $stmt->execute([$user['id']]);
    $data['matieres'] = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($user['prenom'] . ' ' . htmlspecialchars($user['nom']) )?></h5>
                <p class="card-text"><?= ucfirst($user['role']) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php if($user['role'] === 'professeur'): ?>
            <div class="card">
                <div class="card-header">Vos matières</div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach($data['matieres'] as $matiere): ?>
                            <a href="<?= BASE_URL ?>professeurs/saisie_absences.php?matiere_id=<?= $matiere['id'] ?>" 
                               class="list-group-item list-group-item-action">
                                <?= htmlspecialchars($matiere['nom']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>