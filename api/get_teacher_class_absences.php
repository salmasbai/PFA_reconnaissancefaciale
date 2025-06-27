<?php
// get_teacher_class_absences.php - API pour récupérer les absences des étudiants d'une classe pour un professeur

// Activer le rapport d'erreurs pour le débogage (À RETIRER ABSOLUMENT EN PRODUCTION !)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Définit le type de contenu de la réponse comme JSON

require_once '../includes/config.php'; // Inclut le fichier de configuration de la base de données

$response = array('success' => false, 'message' => '', 'students' => [], 'absences' => []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $professeur_id = isset($_POST['professeur_id']) ? intval($_POST['professeur_id']) : 0;
    $classe_id = isset($_POST['classe_id']) ? intval($_POST['classe_id']) : 0;

    if ($professeur_id <= 0 || $classe_id <= 0) {
        $response['message'] = 'ID professeur ou ID classe manquant ou invalide.';
    } else {
        try {
            // Optionnel: Vérifier si le professeur est bien associé à cette classe.
            // Pour l'instant, on se concentre sur l'affichage des absences de la classe sélectionnée.

            // Première requête: récupérer tous les étudiants de la classe spécifiée
            $stmt_students = $pdo->prepare("SELECT id, nom, prenom FROM etudiants WHERE classe_id = ? ORDER BY nom, prenom");
            $stmt_students->execute([$classe_id]);
            $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

            if (empty($students)) {
                $response['success'] = true; // C'est un succès même s'il n'y a pas d'étudiants
                $response['message'] = 'Aucun étudiant trouvé dans cette classe.';
            } else {
                // Collecte les IDs des étudiants pour la requête d'absences
                $student_ids = array_column($students, 'id');
                // Crée des placeholders pour la clause IN (par exemple, ?, ?, ?)
                $placeholders = implode(',', array_fill(0, count($student_ids), '?'));

                // Deuxième requête: récupérer toutes les absences pour ces étudiants
                // Le filtrage par matière et date peut être ajouté ici si l'interface mobile le supporte.
                $stmt_absences = $pdo->prepare("
                    SELECT
                        a.etudiant_id,
                        a.date,
                        a.heure_debut_creneau,
                        a.heure_fin_creneau,
                        a.justifiee,
                        m.nom AS nom_matiere
                    FROM absences a
                    JOIN matieres m ON a.matiere_id = m.id
                    WHERE a.etudiant_id IN ($placeholders)
                    ORDER BY a.date DESC, a.heure_debut_creneau DESC
                ");
                // Exécute la requête avec les IDs des étudiants
                $stmt_absences->execute($student_ids);
                $absences = $stmt_absences->fetchAll(PDO::FETCH_ASSOC);

                $response['success'] = true;
                $response['students'] = $students;
                $response['absences'] = $absences;
                $response['message'] = 'Données d\'absence récupérées avec succès.';
            }

        } catch (PDOException $e) {
            $response['message'] = "Erreur de base de données : " . $e->getMessage();
            error_log("API get_teacher_class_absences error: " . $e->getMessage());
        }
    }
} else {
    $response['message'] = 'Méthode de requête non autorisée. Seules les requêtes POST sont acceptées.';
}

echo json_encode($response);
exit();
?>
