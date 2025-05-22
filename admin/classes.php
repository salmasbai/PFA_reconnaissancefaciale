<?php
require_once '../includes/config.php'; // Connexion PDO

// Traitement : ajout de classe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = $_POST['nom_classe'];
    $niveau = $_POST['niveau'];
    $filiere = $_POST['filiere'];
    $annee_univ = $_POST['annee_universitaire'];

    if ($nom && $niveau && $filiere && $annee_univ) {
        $stmt = $pdo->prepare("INSERT INTO classes (nom_classe, niveau, filiere, annee_universitaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $niveau, $filiere, $annee_univ]);
        $message = "✅ Classe ajoutée avec succès !";
    } else {
        $message = "❌ Tous les champs sont obligatoires.";
    }
}

// Traitement : suppression de classe
if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    $pdo->prepare("DELETE FROM classes WHERE id = ?")->execute([$id]);
    header("Location: classes.php");
    exit;
}

// Récupérer toutes les classes
$classes = $pdo->query("SELECT * FROM classes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des classes</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f2f2f2; }
        h1 { color: #333; text-align: center; }
        form, table { background: #fff; padding: 20px; border-radius: 10px; }
        input, select, button { padding: 8px; margin: 5px 0; width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        .message { background: #dff0d8; color: #3c763d; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .suppr-btn { color: red; text-decoration: none; }
    </style>
</head>
<body>

<h1>🎓 Gestion des Classes</h1>

<?php if (isset($message)): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<!-- Formulaire ajout classe -->
<form method="post">
    <h3>Ajouter une classe</h3>
    <label>Nom de la classe :</label>
    <input type="text" name="nom_classe" required>

    <label>Niveau :</label>
    <select name="niveau" required>
        <option value="">-- Choisir --</option>
        <option value="1ère année">1ère année</option>
        <option value="2ème année">2ème année</option>
        <option value="3ème année">3ème année</option>
    </select>

    <label>Filière :</label>
    <select name="filiere" required>
        <option value="">-- Choisir --</option>
        <option value="Informatique">Informatique</option>
        <option value="Génie Civil">Génie Civil</option>
        <option value="Réseaux">Réseaux</option>
    </select>

    <label>Année universitaire :</label>
    <input type="text" name="annee_universitaire" value="<?= date('Y') . '/' . (date('Y') + 1) ?>" required>

    <button type="submit" name="ajouter">Ajouter la classe</button>
</form>

<!-- Tableau des classes -->
<h3>📋 Liste des classes</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Niveau</th>
        <th>Filière</th>
        <th>Année Univ.</th>
        <th>Action</th>
    </tr>
    <?php foreach ($classes as $classe): ?>
        <tr>
            <td><?= $classe['id'] ?></td>
            <td><?= htmlspecialchars($classe['nom_classe']) ?></td>
            <td><?= htmlspecialchars($classe['niveau']) ?></td>
            <td><?= htmlspecialchars($classe['filiere']) ?></td>
            <td><?= htmlspecialchars($classe['annee_universitaire']) ?></td>
            <td><a href="?supprimer=<?= $classe['id'] ?>" class="suppr-btn" onclick="return confirm('Supprimer cette classe ?')">Supprimer</a></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>