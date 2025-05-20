<?php require_once 'includes/config.php'; ?>
<?php
session_start();

// Load configuration and establish connection



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify all required fields are present
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
        die("All fields are required!");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['role'];

    try {
        if ($type === 'etudiant') {
            $stmt = $conn->prepare("SELECT * FROM etudiants WHERE email = ?");
        } elseif ($type === 'professeur') {
            $stmt = $conn->prepare("SELECT * FROM professeurs WHERE email = ?");
        } else {
            die("Invalid user type.");
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['type'] = $type;

                header("Location: " . ($type === 'etudiant' ? 
                      "etudiant/dashboard.php" : "professeur/dashboard.php"));
                exit();
            } else {
                die("Incorrect password.");
            }
        } else {
            die("User not found.");
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    } finally {
        if (isset($stmt)) $stmt->close();
        // Don't close $conn here if you need it for other scripts
    }
} else {
    header("Location: login_form.php");
    exit();
}
?>