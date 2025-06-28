<?php
// get_prof_classes.php - API pour récupérer les classes associées à un professeur pour l'application mobile

// Activer le rapport d'erreurs pour le débogage (À RETIRER ABSOLUMENT EN PRODUCTION !)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Définit le type de contenu de la réponse comme JSON

require_once '../includes/config.php'; // Inclut le fichier de configuration de la base de données

$response = array('success' => false, 'message' => '', 'classes' => []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $professeur_id = isset($_POST['professeur_id']) ? intval($_POST['professeur_id']) : 0;

    if ($professeur_id <= 0) {
        $response['message'] = 'ID professeur manquant ou invalide.';
    } else {
        try {
            // Requête pour récupérer les classes où le professeur enseigne (via emploi_du_temps)
            // Utilise DISTINCT pour éviter les doublons si un professeur est lié à une classe via plusieurs matières/créneaux
            $stmt = $pdo->prepare("
                SELECT DISTINCT c.id, c.nom_classe
                FROM classes c
                JOIN emploi_du_temps edt ON c.id = edt.classe_id
                WHERE edt.professeur_id = ?
                ORDER BY c.nom_classe ASC
            ");
            $stmt->execute([$professeur_id]);
            $classes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes

            $response['success'] = true;
            $response['classes'] = $classes;
            $response['message'] = 'Classes récupérées avec succès.';

            if (empty($classes)) {
                $response['message'] = 'Aucune classe trouvée pour ce professeur.';
            }

        } catch (PDOException $e) {
            $response['message'] = "Erreur de base de données : " . $e->getMessage();
            error_log("API get_prof_classes error: " . $e->getMessage());
        }
    }
} else {
    $response['message'] = 'Méthode de requête non autorisée. Seules les requêtes POST sont acceptées.';
}

echo json_encode($response);
exit();
?>
