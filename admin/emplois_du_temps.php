<?php
session_start();
require_once '../includes/config.php';
$lang_code = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
require_once "../lang/{$lang_code}.php";
/*
// Assurez-vous que seul l'admin accède à cette page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}*/

$message = '';
$selected_classe_id = isset($_POST['classe_id']) ? intval($_POST['classe_id']) : (isset($_GET['classe_id']) ? intval($_GET['classe_id']) : '');
$emploi_du_temps_data = [];

// Récupération des classes
try {
    $classes = $pdo->query("SELECT id, nom_classe, niveau, filiere FROM classes ORDER BY nom_classe")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Erreur de base de données lors du chargement des classes: " . $e->getMessage();
    error_log("Emploi du temps - Load Classes Error: " . $e->getMessage());
}

// Récupération des professeurs
try {
    $professeurs = $pdo->query("SELECT id, nom, prenom FROM utilisateurs WHERE role = 'professeur' ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Erreur de base de données lors du chargement des professeurs: " . $e->getMessage();
    error_log("Emploi du temps - Load Professors Error: " . $e->getMessage());
}

// Récupération des matières associées à la classe sélectionnée
$matieres_for_selected_class = [];
if ($selected_classe_id) {
    try {
        $stmt_matieres = $pdo->prepare("
            SELECT m.id, m.nom
            FROM matieres m
            JOIN classe_matiere cm ON m.id = cm.matiere_id
            WHERE cm.classe_id = ?
            ORDER BY m.nom
        ");
        $stmt_matieres->execute([$selected_classe_id]);
        $matieres_for_selected_class = $stmt_matieres->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Erreur de base de données lors du chargement des matières de la classe: " . $e->getMessage();
        error_log("Emploi du temps - Load Matieres for Class Error: " . $e->getMessage());
    }
}


// Enregistrement de l'emploi du temps
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $classe_id_post = isset($_POST['classe_id']) ? intval($_POST['classe_id']) : 0;
    
    if ($classe_id_post === 0) {
        $message = "Veuillez sélectionner une classe pour enregistrer l'emploi du temps.";
    } else {
        try {
            $pdo->beginTransaction();

            // Supprimer l'ancien emploi du temps de cette classe
            $pdo->prepare("DELETE FROM emploi_du_temps WHERE classe_id = ?")->execute([$classe_id_post]);

            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']; // Vous pouvez ajouter Samedi, Dimanche si besoin
            $creneaux = ['1', '2', '3', '4']; // Définir les créneaux horaires si fixes

            foreach ($jours as $jour) {
                foreach ($creneaux as $creneau) {
                    $prefix = $jour . '_' . $creneau;
                    $matiere_id = empty($_POST[$prefix . '_matiere_id']) ? NULL : intval($_POST[$prefix . '_matiere_id']);
                    $professeur_id = empty($_POST[$prefix . '_professeur_id']) ? NULL : intval($_POST[$prefix . '_professeur_id']);
                    $salle = trim($_POST[$prefix . '_salle'] ?? '');
                    $heure_debut = trim($_POST[$prefix . '_debut'] ?? '');
                    $heure_fin = trim($_POST[$prefix . '_fin'] ?? '');

                    // N'insérer que si au moins une des informations clés est présente
                    if ($matiere_id || $professeur_id || $salle || $heure_debut || $heure_fin) {
                        $stmt = $pdo->prepare("INSERT INTO emploi_du_temps 
                            (classe_id, jour_semaine, heure_debut, heure_fin, matiere_id, professeur_id, salle) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$classe_id_post, $jour, $heure_debut, $heure_fin, $matiere_id, $professeur_id, $salle]);
                    }
                }
            }

            $pdo->commit();
            $message = "✅ Emploi du temps enregistré avec succès.";
            $selected_classe_id = $classe_id_post; // Garder la classe sélectionnée après enregistrement
        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = "❌ Erreur lors de l'enregistrement de l'emploi du temps: " . $e->getMessage();
            error_log("Emploi du temps - Save Error: " . $e->getMessage());
        }
    }
}

// Charger l'emploi du temps existant pour la classe sélectionnée
if ($selected_classe_id) {
    try {
        $stmt_edt = $pdo->prepare("
            SELECT edt.*, m.nom AS nom_matiere, CONCAT(u.nom, ' ', u.prenom) AS nom_professeur
            FROM emploi_du_temps edt
            LEFT JOIN matieres m ON edt.matiere_id = m.id
            LEFT JOIN utilisateurs u ON edt.professeur_id = u.id AND u.role = 'professeur'
            WHERE edt.classe_id = ?
            ORDER BY FIELD(jour_semaine, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), heure_debut
        ");
        $stmt_edt->execute([$selected_classe_id]);
        $raw_edt_data = $stmt_edt->fetchAll(PDO::FETCH_ASSOC);

        // Re-organiser les données pour un accès facile dans le tableau HTML
        foreach ($raw_edt_data as $row) {
            $key = $row['jour_semaine'] . '_' . $row['heure_debut'] . '_' . $row['heure_fin']; // Clé unique pour le créneau
            $emploi_du_temps_data[$row['jour_semaine']][] = $row;
        }

    } catch (PDOException $e) {
        $message = "Erreur de base de données lors du chargement de l'emploi du temps: " . $e->getMessage();
        error_log("Emploi du temps - Load EDT Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang_code) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENSAO – <?= htmlspecialchars($lang['timetables'] ?? 'Emplois du Temps') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: var(--secondary);
            color: #fff;
        }
        input[type="text"], input[type="time"], select {
            width: 90%;
            font-size: 12px;
            padding: 4px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .small-text {
            font-size: 0.75em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($lang['timetables'] ?? 'Gestion des Emplois du Temps') ?></h2>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post" id="edtForm">
            <div class="mb-3 row">
                <label for="classe_id" class="col-sm-2 col-form-label"><?= htmlspecialchars($lang['select_class'] ?? 'Classe') ?> :</label>
                <div class="col-sm-10">
                    <select name="classe_id" id="classe_id" class="form-select" required onchange="this.form.submit()">
                        <option value="">-- <?= htmlspecialchars($lang['choose_a_class'] ?? 'Choisir une classe') ?> --</option>
                        <?php foreach ($classes as $classe): ?>
                            <option value="<?= htmlspecialchars($classe['id']) ?>" <?= ($selected_classe_id == $classe['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($classe['nom_classe'] . ' (' . $classe['niveau'] . ' ' . $classe['filiere'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <?php if ($selected_classe_id && !empty($matieres_for_selected_class) && !empty($professeurs)): ?>
            <form method="post">
                <input type="hidden" name="classe_id" value="<?= htmlspecialchars($selected_classe_id) ?>">
                <table>
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($lang['day_slot'] ?? 'Jour / Créneau') ?></th>
                            <?php
                            // Définir des créneaux horaires fixes si votre EDT a des créneaux standard
                            // Sinon, vous pourriez générer des lignes dynamiquement basées sur l'EDT existant.
                            // Pour simplifier l'interface de saisie, on garde des créneaux fixes ici.
                            $time_slots = [
                                ['08:00', '10:00'],
                                ['10:00', '12:00'],
                                ['14:00', '16:00'],
                                ['16:00', '18:00']
                            ];
                            foreach ($time_slots as $slot_index => $slot):
                            ?>
                                <th>
                                    <?= htmlspecialchars($lang['slot'] ?? 'Créneau') ?> <?= $slot_index + 1 ?><br>
                                    <small class="small-text">(<?= htmlspecialchars($slot[0] . '-' . $slot[1]) ?>)</small><br>
                                    <small class="small-text">(<?= htmlspecialchars($lang['matiere_prof_room'] ?? 'Matière / Prof. / Salle') ?>)</small>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                        foreach ($jours as $jour):
                        ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($jour) ?></strong></td>
                                <?php
                                foreach ($time_slots as $slot_index => $slot):
                                    $current_matiere_id = null;
                                    $current_professeur_id = null;
                                    $current_salle = '';
                                    $current_heure_debut = $slot[0];
                                    $current_heure_fin = $slot[1];

                                    // Chercher les données existantes pour ce créneau
                                    if (isset($emploi_du_temps_data[$jour])) {
                                        foreach ($emploi_du_temps_data[$jour] as $edt_entry) {
                                            if ($edt_entry['heure_debut'] == $slot[0] && $edt_entry['heure_fin'] == $slot[1]) {
                                                $current_matiere_id = $edt_entry['matiere_id'];
                                                $current_professeur_id = $edt_entry['professeur_id'];
                                                $current_salle = $edt_entry['salle'];
                                                break;
                                            }
                                        }
                                    }
                                ?>
                                    <td>
                                        <input type="hidden" name="<?= htmlspecialchars($jour . '_' . ($slot_index + 1)) ?>_debut" value="<?= htmlspecialchars($slot[0]) ?>">
                                        <input type="hidden" name="<?= htmlspecialchars($jour . '_' . ($slot_index + 1)) ?>_fin" value="<?= htmlspecialchars($slot[1]) ?>">

                                        <select name="<?= htmlspecialchars($jour . '_' . ($slot_index + 1)) ?>_matiere_id">
                                            <option value="">-- <?= htmlspecialchars($lang['matiere'] ?? 'Matière') ?> --</option>
                                            <?php foreach ($matieres_for_selected_class as $matiere): ?>
                                                <option value="<?= htmlspecialchars($matiere['id']) ?>"
                                                    <?= ($current_matiere_id == $matiere['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($matiere['nom']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select><br>

                                        <select name="<?= htmlspecialchars($jour . '_' . ($slot_index + 1)) ?>_professeur_id">
                                            <option value="">-- <?= htmlspecialchars($lang['professor'] ?? 'Professeur') ?> --</option>
                                            <?php foreach ($professeurs as $prof): ?>
                                                <option value="<?= htmlspecialchars($prof['id']) ?>"
                                                    <?= ($current_professeur_id == $prof['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($prof['nom'] . ' ' . $prof['prenom']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select><br>

                                        <input type="text" name="<?= htmlspecialchars($jour . '_' . ($slot_index + 1)) ?>_salle" placeholder="<?= htmlspecialchars($lang['room'] ?? 'Salle') ?>" value="<?= htmlspecialchars($current_salle) ?>">
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <br>
                <button type="submit" name="save" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-save me-2"></i> <?= htmlspecialchars($lang['save_timetable'] ?? 'Enregistrer l\'emploi du temps') ?>
                </button>
            </form>
        <?php elseif ($selected_classe_id): ?>
            <div class="alert alert-info mt-4">
                <?= htmlspecialchars($lang['no_matieres_for_class_or_professors'] ?? 'Veuillez associer des matières à cette classe et/ou des professeurs existent dans le système.') ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>