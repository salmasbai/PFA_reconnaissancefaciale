<?php
require_once '../includes/config.php';

// Récupération des classes
$classes = $pdo->query("SELECT * FROM classes ORDER BY nom_classe")->fetchAll(PDO::FETCH_ASSOC);

// Récupération des professeurs
$professeurs = $pdo->query("SELECT id, nom, prenom FROM professeurs ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Enregistrement de l'emploi du temps
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $classe_id = $_POST['classe_id'];
    
    // Supprimer l'ancien emploi du temps de cette classe
    $pdo->prepare("DELETE FROM emploi_du_temps WHERE classe_id = ?")->execute([$classe_id]);

    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
    $creneaux = ['1', '2', '3', '4'];

    foreach ($jours as $jour) {
        foreach ($creneaux as $creneau) {
            $prefix = $jour . '_' . $creneau;
            $matiere = $_POST[$prefix . '_matiere'] ?? '';
            $enseignant = $_POST[$prefix . '_enseignant'] ?? '';
            $salle = $_POST[$prefix . '_salle'] ?? '';
            $heure_debut = $_POST[$prefix . '_debut'] ?? '';
            $heure_fin = $_POST[$prefix . '_fin'] ?? '';

            if ($matiere || $enseignant || $salle) {
                $stmt = $pdo->prepare("INSERT INTO emploi_du_temps 
                    (classe_id, jour_semaine, heure_debut, heure_fin, matiere, enseignant, salle) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$classe_id, $jour, $heure_debut, $heure_fin, $matiere, $enseignant, $salle]);
            }
        }
    }

    $message = "✅ Emploi du temps enregistré avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du Temps</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: center; font-size: 14px; }
        input, select { width: 90%; font-size: 12px; }
        .message { background: #d4edda; padding: 10px; margin: 10px 0; color: #155724; }
    </style>
</head>
<body>

<h2>🕘 Saisie de l'emploi du temps</h2>

<?php if (isset($message)): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="post">
    <label for="classe_id">Classe :</label>
    <select name="classe_id" required>
        <option value="">-- Choisir une classe --</option>
        <?php foreach ($classes as $classe): ?>
            <option value="<?= $classe['id'] ?>"><?= $classe['nom_classe'] ?> - <?= $classe['niveau'] ?> - <?= $classe['filiere'] ?></option>
        <?php endforeach; ?>
    </select>

    <table>
        <tr>
            <th>Jour / Créneau</th>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <th>Créneau <?= $i ?><br><small>(Matière / Enseignant / Salle / Heure)</small></th>
            <?php endfor; ?>
        </tr>

        <?php
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        foreach ($jours as $jour):
        ?>
            <tr>
                <td><strong><?= $jour ?></strong></td>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <td>
                        <input type="text" name="<?= $jour . '_' . $i ?>_matiere" placeholder="Matière"><br>

                        <!-- Select enseignants -->
                        <select name="<?= $jour . '_' . $i ?>_enseignant">
                            <option value="">-- Enseignant --</option>
                            <?php foreach ($professeurs as $prof): ?>
                                <option value="<?= htmlspecialchars($prof['nom'] . ' ' . $prof['prenom']) ?>">
                                    <?= htmlspecialchars($prof['nom'] . ' ' . $prof['prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>

                        <input type="text" name="<?= $jour . '_' . $i ?>_salle" placeholder="Salle"><br>
                        <input type="time" name="<?= $jour . '_' . $i ?>_debut" placeholder="Début">
                        <input type="time" name="<?= $jour . '_' . $i ?>_fin" placeholder="Fin">
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <button type="submit" name="save">💾 Enregistrer</button>
</form>

</body>
</html>
