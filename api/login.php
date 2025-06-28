<?php
// login.php - API pour la connexion de l'application mobile

// Activer le rapport d'erreurs pour le débogage (À RETIRER ABSOLUMENT EN PRODUCTION !)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Définit le type de contenu de la réponse comme JSON
header('Content-Type: application/json');

// Inclut le fichier de configuration de la base de données (qui doit établir la connexion PDO $pdo)
require_once '../includes/config.php';

// Initialise un tableau pour la réponse JSON, avec un statut d'échec par défaut
$response = array('success' => false, 'message' => '');

// Vérifie si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère et nettoie les données envoyées par l'application Android
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Valide les entrées de base
    if (empty($email) || empty($password) || empty($role)) {
        $response['message'] = "Tous les champs sont obligatoires.";
    } elseif (!in_array($role, ['etudiant', 'professeur', 'admin'])) {
        $response['message'] = "Type d'utilisateur invalide.";
    } else {
        try {
            // Prépare et exécute la requête SQL pour récupérer l'utilisateur par email et rôle
            $stmt = $pdo->prepare("SELECT id, email, password AS password_hash, nom, prenom, role FROM utilisateurs WHERE email = ? AND role = ?");
            $stmt->execute([$email, $role]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la première ligne comme tableau associatif

            // Vérifie si un utilisateur a été trouvé et si le mot de passe correspond
            if ($user && password_verify($password, $user['password_hash'])) {
                // Authentification réussie
                $response['success'] = true;
                $response['message'] = 'Connexion réussie.';
                // Construit les données utilisateur à renvoyer dans la réponse JSON
                $response['user'] = array(
                    'id' => $user['id'], // C'est l'ID de la table utilisateurs
                    'email' => $user['email'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'role' => $user['role']
                );

                // Si l'utilisateur est un étudiant, récupérer des détails supplémentaires depuis la table 'etudiants'
                if ($user['role'] === 'etudiant') {
                    // Assurez-vous de sélectionner l'ID (PRIMARY KEY) de la table 'etudiants' ici
                    // ainsi que toutes les autres colonnes nécessaires.
                    $stmt_details = $pdo->prepare("SELECT id, numero_etudiant, filiere_id, cycle, photo_path, numero_apogee, code_massar, classe_id FROM etudiants WHERE user_id = ?");
                    $stmt_details->execute([$user['id']]);
                    $student_details = $stmt_details->fetch(PDO::FETCH_ASSOC);

                    if ($student_details) {
                        // Ajoute l'ID réel de l'étudiant (de la table etudiants) à la réponse 'user'
                        $response['user']['etudiant_actual_id'] = $student_details['id'];
                        $response['user']['numero_etudiant'] = $student_details['numero_etudiant'];
                        $response['user']['filiere_id'] = $student_details['filiere_id'];
                        $response['user']['cycle'] = $student_details['cycle'];
                        $response['user']['photo_path'] = $student_details['photo_path'];
                        $response['user']['numero_apogee'] = $student_details['numero_apogee'];
                        $response['user']['code_massar'] = $student_details['code_massar'];
                        $response['user']['classe_id'] = $student_details['classe_id'];

                        // Récupère le nom de la filière si filiere_id existe
                        if ($student_details['filiere_id']) {
                            $stmt_filiere_name = $pdo->prepare("SELECT nom_filiere FROM filieres WHERE id = ?");
                            $stmt_filiere_name->execute([$student_details['filiere_id']]);
                            $filiere_name = $stmt_filiere_name->fetchColumn();
                            $response['user']['filiere_name'] = $filiere_name;
                        } else {
                            $response['user']['filiere_name'] = null;
                        }

                        // Récupère le nom de la classe si classe_id existe
                        if ($student_details['classe_id']) {
                            $stmt_classe_name = $pdo->prepare("SELECT nom_classe FROM classes WHERE id = ?");
                            $stmt_classe_name->execute([$student_details['classe_id']]);
                            $classe_name = $stmt_classe_name->fetchColumn();
                            $response['user']['classe_name'] = $classe_name;
                        } else {
                            $response['user']['classe_name'] = null;
                        }
                    } else {
                        // Ce bloc s'exécute si l'utilisateur est un étudiant mais n'a pas d'entrée correspondante dans la table 'etudiants'
                        $response['success'] = false;
                        $response['message'] = "Détails d'étudiant introuvables pour cet utilisateur.";
                    }
                }
            } else {
                // Échec de l'authentification (email, mot de passe ou rôle incorrect)
                $response['message'] = "Email, mot de passe ou rôle incorrect.";
            }
        } catch (PDOException $e) {
            // Capture les erreurs de base de données
            $response['message'] = "Erreur de base de données : " . $e->getMessage();
            error_log("Login API error: " . $e->getMessage()); // Enregistre l'erreur dans les logs du serveur
        }
    }
} else {
    // Si la méthode de requête n'est pas POST
    $response['message'] = 'Méthode de requête non autorisée. Seules les requêtes POST sont acceptées.';
}

// Encode la réponse en JSON et l'affiche
echo json_encode($response);
exit(); // Arrête l'exécution du script après l'envoi de la réponse JSON
?>
