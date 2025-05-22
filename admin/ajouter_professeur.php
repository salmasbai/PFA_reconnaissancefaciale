<?php
require_once '../includes/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $specialite = trim($_POST['specialite']);

    if ($nom && $prenom && $email) {
        $stmt = $pdo->prepare("INSERT INTO professeurs (nom, prenom, email, telephone, specialite)
                               VALUES (?, ?, ?, ?, ?)");
        try {
            $stmt->execute([$nom, $prenom, $email, $telephone, $specialite]);
            $message = "✅ Professeur ajouté avec succès.";
        } catch (PDOException $e) {
            $message = "❌ Erreur : " . $e->getMessage();
        }
    } else {
        $message = "⚠️ Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Professeur</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, select { padding: 5px; width: 300px; margin-bottom: 10px; }
        label { display: block; margin-top: 10px; }
        button { padding: 8px 20px; font-size: 16px; }
        .message { margin: 10px 0; padding: 10px; background: #f0f0f0; border-left: 5px solid #007BFF; }
    </style>
</head>
<body>

    <h2>👨‍🏫 Ajouter un Professeur</h2>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="nom">Nom *</label>
        <input type="text" name="nom" required>

        <label for="prenom">Prénom *</label>
        <input type="text" name="prenom" required>

        <label for="email">Email *</label>
        <input type="email" name="email" required>

        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone">

        <label for="specialite">Spécialité</label>
        <input type="text" name="specialite">

        <br><br>
        <button type="submit">Ajouter</button>
    </form>

</body>
</html>
