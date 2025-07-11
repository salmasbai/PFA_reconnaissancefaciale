<?php
// Inclure votre fichier de configuration de base de données.
// Ce fichier devrait gérer la connexion PDO et les constantes de base de données.
require_once '../includes/config.php';

/* session_start();
// Assurez-vous que seul l'admin accède à cette page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../authentification/login.php');
    exit;
}*/

// L'objet de connexion PDO est maintenant disponible via $pdo depuis config.php

// Initialisation des messages de statut (non utilisés pour l'exportation directe, mais pour la cohérence)
// Ces messages sont principalement pour l'affichage HTML avant l'exportation.
$message = '';
$message_type = '';

// Définition du mot de passe par défaut pour les nouveaux utilisateurs
// ATTENTION: Ce mot de passe est en clair ici. C'est le mot de passe initial généré.
// Il doit être souligné que les utilisateurs DOIVENT le changer à la première connexion.
$DEFAULT_PASSWORD = 'password123'; // Le mot de passe temporaire généré lors de la création d'utilisateur

// --- Logique de traitement de l'exportation ---
if (isset($_POST['export'])) {
    $export_type = $_POST['export_type'] ?? '';
    $annee_universitaire = $_POST['annee_universitaire'] ?? '';
    $classe_id = $_POST['classe'] ?? ''; // ID de la classe si sélectionnée

    // Nettoyage et validation des entrées. Pour PDO, les paramètres sont sécurisés par le prepare/execute.
    // Cependant, htmlspecialchars est une bonne pratique pour éviter l'injection XSS dans les noms de fichiers ou affichages.
    $annee_universitaire_safe = htmlspecialchars($annee_universitaire);
    $classe_id_safe = htmlspecialchars($classe_id);

    // Génération du nom de fichier
    $filename = "export_donnees_" . $export_type . "_" . date('Ymd_His') . ".csv";

    // En-têtes HTTP pour le téléchargement du fichier CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Ouvrir le flux de sortie pour écrire le CSV
    $output = fopen('php://output', 'w');

    switch ($export_type) {
        case 'classes_summary':
            // En-têtes pour le résumé des classes
            fputcsv($output, ['ID Classe', 'Nom Classe', 'Niveau', 'Filiere Classe', 'Annee Universitaire', 'Nombre Etudiants Inscrits']);

            // Requête SQL pour obtenir le résumé des classes
            // Utilise LEFT JOIN avec `etudiants` pour compter les étudiants
            // Utilise LEFT JOIN avec `filieres` pour récupérer le nom de la filière
            $sql = "SELECT c.id AS class_id, c.nom_classe, c.niveau, f.nom_filiere AS filiere_classe, c.annee_universitaire, COUNT(e.id) AS total_etudiants
                    FROM classes c
                    LEFT JOIN etudiants e ON c.id = e.classe_id
                    LEFT JOIN filieres f ON c.filiere_id = f.id";

            $conditions = [];
            $params = [];
            if (!empty($annee_universitaire_safe)) {
                $conditions[] = "c.annee_universitaire = :annee_universitaire";
                $params[':annee_universitaire'] = $annee_universitaire_safe;
            }
            if (!empty($classe_id_safe)) {
                $conditions[] = "c.id = :classe_id";
                $params[':classe_id'] = $classe_id_safe;
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            $sql .= " GROUP BY c.id, c.nom_classe, c.niveau, f.nom_filiere, c.annee_universitaire"; // Group by tous les champs sélectionnés

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;

        case 'absences_summary':
            // En-têtes pour le résumé des absences
            fputcsv($output, ['ID Absence', 'Nom Etudiant', 'Prenom Etudiant', 'Classe', 'Matiere', 'Date Absence', 'Justifiee']);

            // Requête SQL pour obtenir les absences avec filtres
            // Joins avec etudiants, matieres et classes (via etudiants.classe_id)
            $sql = "SELECT a.id, e.nom AS nom_etudiant, e.prenom AS prenom_etudiant, cl.nom_classe, m.nom AS nom_matiere, a.date, a.justifiee
                    FROM absences a
                    JOIN etudiants e ON a.etudiant_id = e.id
                    JOIN matieres m ON a.matiere_id = m.id
                    LEFT JOIN classes cl ON e.classe_id = cl.id"; // LEFT JOIN si un étudiant pourrait ne pas avoir de classe

            $conditions = [];
            $params = [];
            if (!empty($annee_universitaire_safe)) {
                $conditions[] = "cl.annee_universitaire = :annee_universitaire";
                $params[':annee_universitaire'] = $annee_universitaire_safe;
            }
            if (!empty($classe_id_safe)) {
                $conditions[] = "cl.id = :classe_id";
                $params[':classe_id'] = $classe_id_safe;
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            $sql .= " ORDER BY a.date DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;

        case 'admin_activity_log':
            // En-têtes pour le journal d'activité admin (exemple simple)
            fputcsv($output, ['ID Log', 'Utilisateur (ID)', 'Type Action', 'Description', 'Timestamp']);

            // Requête SQL pour obtenir le journal d'activité.
            // IMPORTANT : Cette table `admin_activity_log` doit exister et être alimentée par votre application.
            $sql = "SELECT id, user_id, action_type, description, timestamp
                    FROM admin_activity_log";

            // Pas de filtres par année/classe dans cet exemple, mais vous pouvez les ajouter si votre table de logs le permet.
            // $conditions = [];
            // $params = [];
            // if (!empty($annee_universitaire_safe)) {
            //     $conditions[] = "YEAR(timestamp) = :annee_universitaire"; // Exemple si timestamp est DATETIME
            //     $params[':annee_universitaire'] = $annee_universitaire_safe;
            // }
            // if (!empty($conditions)) {
            //     $sql .= " WHERE " . implode(' AND ', $conditions);
            // }
            $sql .= " ORDER BY timestamp DESC";

            $stmt = $pdo->prepare($sql);
            // $stmt->execute($params); // Exécuter avec les paramètres si des conditions sont ajoutées

            // Pour l'instant, sans filtres pour ce cas, juste un execute simple
            $stmt->execute();


            if ($stmt->rowCount() > 0) { // Vérifier si des lignes ont été trouvées
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    fputcsv($output, $row);
                }
            } else {
                fputcsv($output, ['Aucune donnée trouvée dans le journal d\'activité.']);
            }
            break;
        
        case 'student_accounts_by_class':
            // En-têtes pour la liste des comptes étudiants avec mot de passe initial
            fputcsv($output, ['Nom', 'Prénom', 'Email', 'Mot de Passe Initial', 'Classe', 'Niveau Classe', 'Filière Classe', 'Année Universitaire']);

            $sql = "SELECT u.nom, u.prenom, u.email, :default_password AS default_password, 
                           c.nom_classe, c.niveau, f.nom_filiere AS filiere_classe, c.annee_universitaire
                    FROM etudiants e
                    JOIN utilisateurs u ON e.user_id = u.id
                    JOIN classes c ON e.classe_id = c.id
                    JOIN filieres f ON c.filiere_id = f.id
                    WHERE u.role = 'etudiant'";

            $conditions = [];
            $params = [];
            $params[':default_password'] = $DEFAULT_PASSWORD; // Le mot de passe par défaut est une constante PDO
            
            if (!empty($annee_universitaire_safe)) {
                $conditions[] = "c.annee_universitaire = :annee_universitaire";
                $params[':annee_universitaire'] = $annee_universitaire_safe;
            }
            if (!empty($classe_id_safe)) {
                $conditions[] = "c.id = :classe_id";
                $params[':classe_id'] = (int)$classe_id_safe; // Cast en int pour l'ID
            }

            if (!empty($conditions)) {
                $sql .= " AND " . implode(' AND ', $conditions);
            }
            $sql .= " ORDER BY c.nom_classe, u.nom, u.prenom";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;

        case 'professor_accounts':
            // En-têtes pour la liste des comptes professeurs avec mot de passe initial
            fputcsv($output, ['Nom', 'Prénom', 'Email', 'Mot de Passe Initial', 'Spécialité']);

            $sql = "SELECT u.nom, u.prenom, u.email, :default_password AS default_password, p.specialite
                    FROM professeurs p
                    JOIN utilisateurs u ON p.user_id = u.id
                    WHERE u.role = 'professeur'
                    ORDER BY u.nom, u.prenom";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':default_password', $DEFAULT_PASSWORD, PDO::PARAM_STR); // BindValue car c'est une constante, pas une variable de l'utilisateur
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;

        case 'all_student_details':
            // En-têtes pour la liste complète des détails des étudiants
            fputcsv($output, [
                'ID Etudiant', 'Nom', 'Prénom', 'Numéro Etudiant', 'Code Massar', 'Numéro Apogée',
                'Cycle', 'Nom Classe', 'Niveau Classe', 'Filière', 'Année Universitaire', 'Email Utilisateur', 'Photo Path'
            ]);

            $sql = "SELECT 
                        e.id, e.nom, e.prenom, e.numero_etudiant, e.code_massar, e.numero_apogee,
                        e.cycle, c.nom_classe, c.niveau, f.nom_filiere AS filiere_nom, c.annee_universitaire,
                        u.email AS user_email, e.photo_path
                    FROM etudiants e
                    LEFT JOIN classes c ON e.classe_id = c.id
                    LEFT JOIN filieres f ON e.filiere_id = f.id
                    LEFT JOIN utilisateurs u ON e.user_id = u.id";

            $conditions = [];
            $params = [];
            if (!empty($annee_universitaire_safe)) {
                $conditions[] = "c.annee_universitaire = :annee_universitaire";
                $params[':annee_universitaire'] = $annee_universitaire_safe;
            }
            if (!empty($classe_id_safe)) {
                $conditions[] = "c.id = :classe_id";
                $params[':classe_id'] = (int)$classe_id_safe;
            }

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            $sql .= " ORDER BY c.nom_classe, e.nom, e.prenom";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;

        case 'timetables':
            // Pour le tri des jours de la semaine (MySQL-specific FIELD function)
            $day_order_csv_friendly = [
                'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'
            ];
            $day_order_sql = "'" . implode("', '", $day_order_csv_friendly) . "'"; // Pour la clause FIELD()

            // Si une classe spécifique est sélectionnée, on tente une présentation par grille (jours verticaux, heures horizontales)
            if (!empty($classe_id_safe)) {
                // Récupérer les informations de la classe pour le titre
                $stmt_class_info = $pdo->prepare("SELECT nom_classe, annee_universitaire, niveau, f.nom_filiere AS filiere_nom
                                                  FROM classes c JOIN filieres f ON c.filiere_id = f.id WHERE c.id = :classe_id");
                $stmt_class_info->execute([':classe_id' => (int)$classe_id_safe]);
                $class_info = $stmt_class_info->fetch(PDO::FETCH_ASSOC);

                if ($class_info) {
                    // Ajouter des informations d'en-tête pour la classe spécifique
                    fputcsv($output, [""]); // Ligne vide pour la séparation
                    fputcsv($output, ["Emploi du Temps pour la Classe:", $class_info['nom_classe']]);
                    fputcsv($output, ["Niveau:", $class_info['niveau']]);
                    fputcsv($output, ["Filière:", $class_info['filiere_nom']]);
                    fputcsv($output, ["Année Universitaire:", $class_info['annee_universitaire']]);
                    fputcsv($output, [""]); // Ligne vide pour la séparation

                    // Récupérer tous les cours pour cette classe
                    $sql_lessons = "SELECT edt.jour_semaine, edt.heure_debut, edt.heure_fin, edt.matiere, edt.enseignant, edt.salle
                                    FROM emploi_du_temps edt
                                    WHERE edt.classe_id = :classe_id
                                    ORDER BY FIELD(edt.jour_semaine, $day_order_sql), edt.heure_debut";
                    $stmt_lessons = $pdo->prepare($sql_lessons);
                    $stmt_lessons->execute([':classe_id' => (int)$classe_id_safe]);
                    $lessons_raw = $stmt_lessons->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($lessons_raw)) {
                        // Organiser les leçons dans une grille pour le format souhaité (jours verticaux, heures horizontales)
                        $timetable_grid = [];
                        $all_unique_time_slots = [];

                        foreach ($lessons_raw as $lesson) {
                            $time_slot_key = substr($lesson['heure_debut'], 0, 5) . '-' . substr($lesson['heure_fin'], 0, 5);
                            
                            // Concaténer le contenu de la cellule
                            $cell_content = $lesson['matiere'];
                            if (!empty($lesson['enseignant'])) $cell_content .= " (" . $lesson['enseignant'] . ")";
                            if (!empty($lesson['salle'])) $cell_content .= " [" . $lesson['salle'] . "]";
                            
                            // Si plusieurs cours dans le même créneau, ajoutez une nouvelle ligne
                            if (isset($timetable_grid[$lesson['jour_semaine']][$time_slot_key])) {
                                $timetable_grid[$lesson['jour_semaine']][$time_slot_key] .= "\n" . $cell_content;
                            } else {
                                $timetable_grid[$lesson['jour_semaine']][$time_slot_key] = $cell_content;
                            }
                            
                            $all_unique_time_slots[$time_slot_key] = true;
                        }
                        
                        ksort($all_unique_time_slots); // Tri des créneaux horaires
                        $all_unique_time_slots = array_keys($all_unique_time_slots);

                        // En-tête du tableau CSV : Jour + toutes les heures uniques
                        fputcsv($output, array_merge(['Jour'], $all_unique_time_slots));

                        // Remplir les lignes pour chaque jour
                        foreach ($day_order_csv_friendly as $day) {
                            $row_data = [$day]; // Commence la ligne avec le nom du jour
                            foreach ($all_unique_time_slots as $time_slot) {
                                // Récupère le contenu de la cellule pour ce jour et ce créneau horaire
                                $row_data[] = isset($timetable_grid[$day][$time_slot]) ? $timetable_grid[$day][$time_slot] : '';
                            }
                            fputcsv($output, $row_data);
                        }
                    } else {
                        fputcsv($output, ["Aucun emploi du temps trouvé pour cette classe."]);
                    }
                } else {
                    fputcsv($output, ["Classe non trouvée pour l'exportation de l'emploi du temps."]);
                }
            } else { // Si aucune classe spécifique n'est sélectionnée (toutes les classes)
                // Exportation linéaire avec séparateurs de classe
                fputcsv($output, [
                    'Nom Classe', 'Niveau Classe', 'Filière Classe', 'Année Universitaire',
                    'Jour Semaine', 'Heure Début', 'Heure Fin', 'Matière', 'Enseignant (Prof)', 'Salle'
                ]);

                $sql = "SELECT 
                            c.nom_classe, c.niveau, f.nom_filiere AS filiere_classe, c.annee_universitaire,
                            edt.jour_semaine, edt.heure_debut, edt.heure_fin, edt.matiere, edt.enseignant, edt.salle
                        FROM emploi_du_temps edt
                        JOIN classes c ON edt.classe_id = c.id
                        LEFT JOIN filieres f ON c.filiere_id = f.id"; // Jointure pour la filière de la classe

                $conditions = [];
                $params = [];
                if (!empty($annee_universitaire_safe)) {
                    $conditions[] = "c.annee_universitaire = :annee_universitaire";
                    $params[':annee_universitaire'] = $annee_universitaire_safe;
                }

                if (!empty($conditions)) {
                    $sql .= " WHERE " . implode(' AND ', $conditions);
                }
                $sql .= " ORDER BY c.nom_classe, FIELD(edt.jour_semaine, $day_order_sql), edt.heure_debut";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);

                $current_class_name = '';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['nom_classe'] !== $current_class_name) {
                        if ($current_class_name !== '') {
                            fputcsv($output, [""]); // Ligne vide pour séparer les classes
                            fputcsv($output, ["--- Emploi du temps pour " . $row['nom_classe'] . " ---"]); // Séparateur clair
                            fputcsv($output, [""]);
                            fputcsv($output, [
                                'Nom Classe', 'Niveau Classe', 'Filière Classe', 'Année Universitaire',
                                'Jour Semaine', 'Heure Début', 'Heure Fin', 'Matière', 'Enseignant (Prof)', 'Salle'
                            ]); // Ré-afficher les en-têtes
                        }
                        $current_class_name = $row['nom_classe'];
                    }
                    fputcsv($output, $row);
                }
            }
            break;

        default:
            fputcsv($output, ['Erreur', 'Type d\'exportation non valide.']);
            break;
    }

    fclose($output);
    exit(); // Important pour arrêter l'exécution après l'exportation du fichier
}

// --- Récupération des données pour les listes déroulantes du formulaire ---
// Ces requêtes utilisent $pdo car nous avons basculé vers PDO.
$annees_universitaires = [];
$stmt_annees = $pdo->query("SELECT DISTINCT annee_universitaire FROM classes WHERE annee_universitaire IS NOT NULL AND annee_universitaire != '' ORDER BY annee_universitaire DESC");
if ($stmt_annees) {
    while ($row = $stmt_annees->fetch(PDO::FETCH_ASSOC)) {
        $annees_universitaires[] = $row['annee_universitaire'];
    }
}

$classes = [];
$stmt_classes_form = $pdo->query("SELECT id, nom_classe FROM classes ORDER BY nom_classe ASC");
if ($stmt_classes_form) {
    while ($row = $stmt_classes_form->fetch(PDO::FETCH_ASSOC)) {
        $classes[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportation des Données Administrateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        h1 {
            color: #1f2937;
            font-size: 1.875rem; /* 30px */
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4b5563;
            font-weight: 600;
            text-align: left;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            box-sizing: border-box; /* Ensures padding doesn't increase width */
            font-size: 1rem;
            color: #374151;
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
        }
        button:hover {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Exportation des Données</h1>
        <form action="export_donnees.php" method="POST">
            <div class="mb-4">
                <label for="export_type">Type de données à exporter :</label>
                <select name="export_type" id="export_type" class="rounded-md">
                    <option value="classes_summary">Résumé des Classes</option>
                    <option value="absences_summary">Résumé des Absences</option>
                    <option value="all_student_details">Liste des Étudiants (Détails Complets)</option>
                    <option value="timetables">Emplois du Temps (par Classe)</option>
                    <option value="student_accounts_by_class">Comptes Étudiants (Email/Mdp initial)</option>
                    <option value="professor_accounts">Comptes Professeurs (Email/Mdp initial)</option>
                    <option value="admin_activity_log">Journal d'Activité Admin</option>
                </select>
            </div>

            <div class="mb-4" id="filters_section">
                <label for="annee_universitaire">Filtrer par Année Universitaire :</label>
                <select name="annee_universitaire" id="annee_universitaire" class="rounded-md">
                    <option value="">Toutes les Années</option>
                    <?php foreach ($annees_universitaires as $annee): ?>
                        <option value="<?php echo htmlspecialchars($annee); ?>"><?php echo htmlspecialchars($annee); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4" id="classe_filter_group">
                <label for="classe">Filtrer par Classe :</label>
                <select name="classe" id="classe" class="rounded-md">
                    <option value="">Toutes les Classes</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo htmlspecialchars($class['id']); ?>"><?php echo htmlspecialchars($class['nom_classe']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="export" class="rounded-md">Exporter les Données</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const exportTypeSelect = document.getElementById('export_type');
            const filtersSection = document.getElementById('filters_section');
            const classeFilterGroup = document.getElementById('classe_filter_group');

            function toggleFilters() {
                const selectedType = exportTypeSelect.value;
                // Les filtres d'année et de classe sont pertinents pour ces types d'exportation
                if (selectedType === 'student_accounts_by_class' || 
                    selectedType === 'absences_summary' || 
                    selectedType === 'classes_summary' ||
                    selectedType === 'all_student_details' || 
                    selectedType === 'timetables') { 
                    filtersSection.style.display = 'block'; // Afficher le filtre d'année
                    classeFilterGroup.style.display = 'block'; // Afficher le filtre de classe
                } else {
                    filtersSection.style.display = 'none'; // Cacher le filtre d'année
                    classeFilterGroup.style.display = 'none'; // Cacher le filtre de classe
                }
            }

            // Appel initial pour définir la visibilité correcte des filtres au chargement de la page
            toggleFilters();

            // Ajouter un écouteur d'événements pour les changements dans le type d'exportation
            exportTypeSelect.addEventListener('change', toggleFilters);
        });
    </script>
</body>
</html>
