<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant - ENSAO</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: var(--dark-color);
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .main-content {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--accent-color);
        }
        
        .form-container {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--primary-color);
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s ease;
        }
        
        input[type="file"] {
            width: 100%;
            padding: 0.5rem 0;
        }
        
        input:focus,
        select:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        button[type="submit"] {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }
        
        button[type="submit"]:hover {
            background-color: var(--primary-color);
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="main-content">
        <h1>Ajouter un Nouvel Étudiant</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'includes/functions.php';
            
            // Traitement du formulaire
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'prenom' => $_POST['prenom'] ?? '',
                'code_massar' => $_POST['code_massar'] ?? '',
                'numero_apogee' => $_POST['numero_apogee'] ?? '',
                'filiere' => $_POST['filiere'] ?? '',
                'cycle' => $_POST['cycle'] ?? '',
                'numero_etudiant' => $_POST['numero_etudiant'] ?? ''
            ];
            
            // Validation
            $errors = validateStudentData($data);
            
            if (empty($errors)) {
                // Traitement de la photo
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $photoPath = uploadPhoto($_FILES['photo']);
                    if ($photoPath) {
                        // Insertion en base
                        $stmt = $pdo->prepare("INSERT INTO etudiants 
                            (nom, prenom, code_massar, numero_apogee, filiere, cycle, numero_etudiant, photo_path) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        
                        if ($stmt->execute(
                            $data['nom'],
                            $data['prenom'],
                            $data['code_massar'],
                            $data['numero_apogee'],
                            $data['filiere'],
                            $data['cycle'],
                            $data['numero_etudiant'],
                            $photoPath
                        ])) {
                            echo '<div class="success-message">Étudiant ajouté avec succès!</div>';
                        }
                    }
                } else {
                    echo '<div class="error-message">Veuillez sélectionner une photo valide</div>';
                }
            } else {
                echo '<div class="error-message">'.implode('<br>', $errors).'</div>';
            }
        }
        ?>
        
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                
                <div class="form-group">
                    <label for="code_massar">Code Massar:</label>
                    <input type="text" id="code_massar" name="code_massar" required pattern="[A-Za-z0-9]{8,20}">
                </div>
                
                <div class="form-group">
                    <label for="numero_apogee">Numéro Apogée:</label>
                    <input type="text" id="numero_apogee" name="numero_apogee" required>
                </div>
                
                <div class="form-group">
                    <label for="filiere">Filière:</label>
                    <select id="filiere" name="filiere" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="GI">Génie Informatique</option>
                        <option value="GEM">Génie Électromécanique</option>
                        <option value="GTR">Génie Télécoms et Réseaux</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="cycle">Cycle:</label>
                    <select id="cycle" name="cycle" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="CP">Cycle Préparatoire</option>
                        <option value="ING">Cycle d'Ingénieur</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="numero_etudiant">Numéro Étudiant:</label>
                    <input type="text" id="numero_etudiant" name="numero_etudiant" required pattern="[A-Za-z0-9]{6,12}">
                </div>
                
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    <small>Formats acceptés: JPG, PNG (max 2MB)</small>
                </div>
                
                <button type="submit">Enregistrer l'étudiant</button>
            </form>
            
            <a href="liste_etudiants.php" class="back-link">← Retour à la liste</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>