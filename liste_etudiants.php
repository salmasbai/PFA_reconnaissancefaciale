<?php 
require_once 'includes/config.php';

// Récupération des étudiants depuis la base de données
try {
    $stmt = $pdo->query("SELECT * FROM etudiants ORDER BY id");
} catch (PDOException $e) {
    die("Erreur lors de la récupération des étudiants: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <h1>Liste des Étudiants</h1>
    
    <?php if ($stmt->rowCount() > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Code Massar</th>
                <th>Numéro Apogée</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Filière</th>
                <th>Cycle</th>
                <th>Numéro Étudiant</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($etudiant = $stmt->fetch()): ?>
            <tr>
                <td>
                    <?php if (!empty($etudiant['photo_path'])): ?>
                        <img src="<?= BASE_URL . ltrim($etudiant['photo_path'], '/') ?>" alt="Photo étudiant">
                    <?php else: ?>
                        <img src="<?= BASE_URL ?>assets/images/avatar_default.jpg" alt="Photo par défaut">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($etudiant['code_massar'] ?? '') ?></td>
                <td><?= htmlspecialchars($etudiant['numero_apogee'] ?? '') ?></td>
                <td><?= htmlspecialchars($etudiant['nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($etudiant['prenom'] ?? '') ?></td>
                <td><?= htmlspecialchars($etudiant['filiere'] ?? '') ?></td>
                <td><?= htmlspecialchars($etudiant['cycle'] ?? '') ?></td>
                <td><?= htmlspecialchars($etudiant['numero_etudiant'] ?? '') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Aucun étudiant trouvé dans la base de données.</p>
    <?php endif; ?>

    <a href="ajouter_etudiant.php">Ajouter un étudiant</a>
</body>
</html>