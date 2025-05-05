<?php
function validateStudentData(array $data): array {
    $errors = [];
    
    // Validation du nom
    if (empty($data['nom'])) {
        $errors[] = "Le nom est obligatoire";
    } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/u', $data['nom'])) {
        $errors[] = "Le nom contient des caractères invalides";
    }

    // Validation du prénom
    if (empty($data['prenom'])) {
        $errors[] = "Le prénom est obligatoire";
    } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/u', $data['prenom'])) {
        $errors[] = "Le prénom contient des caractères invalides";
    }

    // Validation Code Massar
    if (empty($data['code_massar'])) {
        $errors[] = "Le code Massar est obligatoire";
    } elseif (!preg_match('/^[A-Za-z]\d{7,8}$/', $data['code_massar'])) {
        $errors[] = "Format Code Massar invalide (ex: E12345678)";
    }

    // Validation Numéro Apogée
    if (empty($data['numero_apogee'])) {
        $errors[] = "Le numéro Apogée est obligatoire";
    } elseif (!preg_match('/^[A-Z]{2}\d{6}$/', $data['numero_apogee'])) {
        $errors[] = "Format numéro Apogée invalide (ex: XX123456)";
    }

    // Validation Filière
    $filieresValides = ['GI', 'GEM', 'GTR'];
    if (empty($data['filiere']) || !in_array($data['filiere'], $filieresValides)) {
        $errors[] = "Veuillez sélectionner une filière valide";
    }

    // Validation Cycle
    if (empty($data['cycle']) || !in_array($data['cycle'], ['CP', 'ING'])) {
        $errors[] = "Veuillez sélectionner un cycle valide";
    }

    // Validation Numéro Étudiant
    if (empty($data['numero_etudiant'])) {
        $errors[] = "Le numéro étudiant est obligatoire";
    } elseif (!preg_match('/^[A-Za-z0-9]{6,12}$/', $data['numero_etudiant'])) {
        $errors[] = "Format numéro étudiant invalide (6-12 caractères alphanumériques)";
    }

    return $errors;
}

function uploadPhoto(array $file, ?string $codeMassar = null): ?string {
    // Vérification erreur upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // Validation type MIME
    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!array_key_exists($fileType, $allowedTypes)) {
        return null;
    }

    // Taille maximale (2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        return null;
    }

    // Création dossier upload
    $uploadDir = __DIR__ . '/../uploads/etudiants/' . date('Y/m/');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Génération nom sécurisé
    $extension = $allowedTypes[$fileType];
    $prefix = $codeMassar ? preg_replace('/[^A-Za-z0-9]/', '_', $codeMassar) : 'etud';
    $filename = sprintf(
        '%s_%s.%s',
        $prefix,
        bin2hex(random_bytes(4)),
        $extension
    );

    $destination = $uploadDir . $filename;

    // Déplacement fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return '/uploads/etudiants/' . date('Y/m/') . $filename;
    }

    return null;
}

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function ajouterUtilisateur($conn){
    if(isset($_POST["nom"])&& isset($_POST["prenom"])&& isset($_POST["email"])&& isset($_POST["password"])
    && isset($_POST["nom"])&& isset($_POST["role"])){
        $nom= $_POST["nom"];
        $prenom= $_POST["prenom"];
        $email= $_POST["email"];
        $password=password_hash( $_POST["password"],password_default);
        $role= $_POST["role"];
        $sql= "INSERT INTO utilisateurs (nom ,  prenom, email ,password,role) VALUES('$nom','$prenom','$email','$password','$role')";
        if($conn->query($sql)===TRUE){
            echo "utilisateurs ajouter avec succées!";
        }
        else {
            echo "erreur: ". $sql ."<br>".$conn->error;
        }
     }
}
?>