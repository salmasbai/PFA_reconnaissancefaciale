<?php
// get_student_absences.php - API pour récupérer les absences d'un étudiant spécifique

// Activer le rapport d'erreurs pour le débogage (À RETIRER ABSOLUMENT EN PRODUCTION !)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Définit le type de contenu de la réponse comme JSON

require_once '../includes/config.php'; // Inclut le fichier de configuration de la base de données

$response = array('success' => false, 'message' => '', 'absences' => []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $etudiant_id = isset($_POST['etudiant_id']) ? intval($_POST['etudiant_id']) : 0;

    // --- Ajout de log pour le débogage ---
    error_log("get_student_absences.php: Reçu etudiant_id = " . $etudiant_id);

    if ($etudiant_id <= 0) {
        $response['message'] = 'ID étudiant manquant ou invalide.';
        error_log("get_student_absences.php: ID étudiant invalide ou manquant.");
    } else {
        try {
            // Jointures pour obtenir les noms des matières et les détails des absences
            $stmt = $pdo->prepare("
                SELECT
                    a.date,
                    a.heure_debut_creneau,
                    a.heure_fin_creneau,
                    a.justifiee,
                    m.nom AS nom_matiere
                FROM absences a
                JOIN matieres m ON a.matiere_id = m.id
                WHERE a.etudiant_id = ?
                ORDER BY a.date DESC, a.heure_debut_creneau DESC
            ");
            $stmt->execute([$etudiant_id]);
            $absences = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response['success'] = true;
            $response['absences'] = $absences; // Ajoute les absences à la réponse
            $response['message'] = 'Absences récupérées avec succès.';

            if (empty($absences)) {
                $response['message'] = 'Aucune absence enregistrée pour cet étudiant dans la base de données.';
                error_log("get_student_absences.php: Aucune absence trouvée pour etudiant_id = " . $etudiant_id);
            } else {
                error_log("get_student_absences.php: " . count($absences) . " absences trouvées pour etudiant_id = " . $etudiant_id);
            }

        } catch (PDOException $e) {
            $response['message'] = "Erreur de base de données : " . $e->getMessage();
            error_log("API get_student_absences error: " . $e->getMessage());
        }
    }
} else {
    $response['message'] = 'Méthode de requête non autorisée. Seules les requêtes POST sont acceptées.';
}

echo json_encode($response);
exit();
?>
