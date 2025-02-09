<?php
session_start();

// Database connection details
$host = 'localhost';
$db = 'kay_kay_embroidery'; // Ensure this is the correct database name
$user = 'root';
$pass = '';

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $position = htmlspecialchars(trim($_POST['position']));

        // Directory where resumes will be uploaded
        $uploadDir = __DIR__ . '/uploads/';

        // Check if directory exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Check if file is uploaded
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $resume = $_FILES['resume'];
            $targetFile = $uploadDir . basename($resume['name']);
            $uploadOk = true;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Allow only specific file formats
            $validFormats = ['pdf', 'doc', 'docx'];
            if (!in_array($fileType, $validFormats)) {
                echo "Only PDF, DOC, and DOCX files are allowed.";
                $uploadOk = false;
            }

            // Check for any file upload errors
            if ($resume['error'] !== UPLOAD_ERR_OK) {
                echo "Error uploading file.";
                $uploadOk = false;
            }

            // Proceed with file upload if everything is okay
            if ($uploadOk && move_uploaded_file($resume['tmp_name'], $targetFile)) {
                // Prepare SQL to insert application data into the database
                $sql = "INSERT INTO applications (name, email, position, resume_path, created_at) 
                        VALUES (:name, :email, :position, :resume_path, NOW())";

                // Prepare the query
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':resume_path', $targetFile);

                // Execute the query
                if ($stmt->execute()) {
                    $careerId = $conn->lastInsertId(); // Get the last inserted ID, which will be the career_id

                    // Store the career_id in a related table using foreign key (e.g., in a `user_applications` table)
                    $sqlFK = "INSERT INTO user_applications (career_id, user_id) VALUES (:career_id, :user_id)";
                    $stmtFK = $conn->prepare($sqlFK);
                    $stmtFK->bindParam(':career_id', $careerId);
                    $stmtFK->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                    $stmtFK->execute();

                    header('Location: succesapplication.php');
                    exit();
                } else {
                    header('Location: invalidapplication.php');
                    exit();
                }
            } else {
                header('Location: invalidapplication.php');
                exit();
            }
        } else {
            header('Location: invalidapplication.php');
            exit();
        }
    }
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>
