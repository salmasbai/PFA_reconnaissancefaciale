<?php
// Inclure votre fichier de configuration de base de données et d'authentification ici
// Par exemple : include_once 'config.php';
// Assurez-vous que l'utilisateur est authentifié et a les droits d'administrateur.

// --- Configuration de la base de données ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gestion_etudiants');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Initialisation des messages de statut
$message = '';
$message_type = ''; // 'success' ou 'error'

// Déterminer l'année universitaire actuelle/prochaine pour la création de classes
$current_year = date('Y');
$next_year = $current_year + 1;
$annee_universitaire_auto = $current_year . '/' . $next_year;

// --- Traitement de l'ajout d'une filière et création de classes ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_filiere'])) {
    $nom_filiere = $_POST['nom_filiere'] ?? '';
    $type_filiere = $_POST['type_filiere'] ?? '';

    if (empty($nom_filiere) || empty($type_filiere)) {
        $message = "Le nom et le type de la filière sont obligatoires.";
        $message_type = 'error';
    } else {
        // Début de la transaction pour assurer l'atomicité
        $conn->begin_transaction();
        try {
            // 1. Insérer la nouvelle filière
            $stmt_filiere = $conn->prepare("INSERT INTO filieres (nom_filiere, type_filiere) VALUES (?, ?)");
            $stmt_filiere->bind_param("ss", $nom_filiere, $type_filiere);
            if (!$stmt_filiere->execute()) {
                throw new Exception("Erreur lors de l'ajout de la filière : " . $stmt_filiere->error);
            }
            $filiere_id = $stmt_filiere->insert_id;
            $stmt_filiere->close();

            // 2. Créer automatiquement les classes associées
            $niveaux_a_creer = [];
            $prefixe_classe = '';
            if ($type_filiere == 'prepa') {
                $niveaux_a_creer = ['1ère année', '2ème année'];
                $prefixe_classe = 'CP'; // Ex: "CP ITIRC1", "CP ITIRC2"
            } else { // 'ingenieur' ou 'autre'
                $niveaux_a_creer = ['1ère année', '2ème année', '3ème année'];
                $prefixe_classe = strtoupper(substr($nom_filiere, 0, 3)); // Ex: "GI1", "GTR2"
            }

            foreach ($niveaux_a_creer as $index => $niveau) {
                // Création d'un nom de classe simple basé sur la filière et le niveau
                $nom_classe = $nom_filiere . ($index + 1); // Ex: "GI1", "GI2", "GI3"
                if ($type_filiere == 'prepa') {
                    $nom_classe = $nom_filiere . ' ' . ($index + 1); // Ex: "Prepa Maths 1", "Prepa Maths 2"
                } else {
                    $nom_classe = $nom_filiere . ($index + 1); // Ex: "GI1", "GI2", "GI3"
                }


                $stmt_class = $conn->prepare("INSERT INTO classes (nom_classe, niveau, filiere_id, annee_universitaire) VALUES (?, ?, ?, ?)");
                $stmt_class->bind_param("siss", $nom_classe, $niveau, $filiere_id, $annee_universitaire_auto);
                if (!$stmt_class->execute()) {
                    throw new Exception("Erreur lors de la création de la classe " . $nom_classe . " : " . $stmt_class->error);
                }
                $stmt_class->close();
            }

            $conn->commit();
            $message = "La filière '" . htmlspecialchars($nom_filiere) . "' et ses classes associées ont été ajoutées avec succès !";
            $message_type = 'success';
            $_POST = array(); // Nettoyer le formulaire
        } catch (Exception $e) {
            $conn->rollback();
            $message = "Échec de l'ajout de la filière : " . $e->getMessage();
            $message_type = 'error';
        }
    }
}

// --- Récupération des filières existantes pour l'affichage ---
$filieres = [];
$result = $conn->query("SELECT id, nom_filiere, type_filiere FROM filieres ORDER BY nom_filiere ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $filieres[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Filières</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Aligner en haut pour un meilleur affichage des listes */
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Plus large pour les listes */
            width: 100%;
            text-align: left;
        }
        h1 {
            color: #1f2937;
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4b5563;
            font-weight: 600;
        }
        input[type="text"], select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            box-sizing: border-box;
            font-size: 1rem;
            color: #374151;
        }
        .message {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 600;
        }
        .message.success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .message.error {
            background-color: #fee2e2;
            color: #991b1b;
        }
        button {
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            color: white;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1.125rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin-top: 1.5rem;
        }
        button:hover {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        th, td {
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
        }
        td {
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Filières</h1>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h2 class="text-xl font-bold mb-4 text-center">Ajouter une Nouvelle Filière</h2>
        <form action="gestion_filieres.php" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="nom_filiere">Nom de la Filière :</label>
                    <input type="text" name="nom_filiere" id="nom_filiere" class="rounded-md" required value="<?php echo htmlspecialchars($_POST['nom_filiere'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="type_filiere">Type de Filière :</label>
                    <select name="type_filiere" id="type_filiere" class="rounded-md" required>
                        <option value="">Sélectionner un type</option>
                        <option value="prepa" <?php echo (isset($_POST['type_filiere']) && $_POST['type_filiere'] == 'prepa') ? 'selected' : ''; ?>>Classe Préparatoire (2 niveaux)</option>
                        <option value="ingenieur" <?php echo (isset($_POST['type_filiere']) && $_POST['type_filiere'] == 'ingenieur') ? 'selected' : ''; ?>>Cycle Ingénieur (3 niveaux)</option>
                        <option value="autre" <?php echo (isset($_POST['type_filiere']) && $_POST['type_filiere'] == 'autre') ? 'selected' : ''; ?>>Autre (3 niveaux)</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="add_filiere">Ajouter la Filière et Créer les Classes</button>
        </form>

        <h2 class="text-xl font-bold mt-8 mb-4 text-center">Filières Existantes</h2>
        <?php if (!empty($filieres)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Filière</th>
                        <th>Type</th>
                        <!-- Ajoutez d'autres colonnes si nécessaire (ex: actions de suppression/édition) -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filieres as $filiere): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($filiere['id']); ?></td>
                            <td><?php echo htmlspecialchars($filiere['nom_filiere']); ?></td>
                            <td><?php echo htmlspecialchars($filiere['type_filiere']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-gray-600">Aucune filière n'a été ajoutée pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
