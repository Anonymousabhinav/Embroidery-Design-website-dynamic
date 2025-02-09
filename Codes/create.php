<?php
session_start();

// Database connection details
$host = 'localhost';
$db = 'kay_kay_embroidery';
$user = 'root';
$pass = '';

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve and sanitize input data
        $firstname = htmlspecialchars(trim($_POST['firstname']));
        $lastname = htmlspecialchars(trim($_POST['lastname']));
        $username = htmlspecialchars(trim($_POST['username']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = $_POST['createpassword'];
        $password2 = $_POST['confirmingpassword'];

        // Check if passwords match
        if ($password !== $password2) {
            echo 'Passwords do not match.';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Check if user already exists
            $checkQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $checkQuery->execute([$email]);

            if ($checkQuery->rowCount() > 0) {
                echo 'Email already exists.';
            } else {
                // Insert into users table
                $userQuery = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)");
                if ($userQuery->execute([$firstname, $lastname, $username, $email, $hashedPassword])) {
                    // Redirect to the registration success page
                    header('Location: login.html');
                    exit();
                } else {
                    echo 'Failed to insert data.';
                }
            }
        }
    }
} catch (PDOException $e) {
    // Handle query errors
    echo 'Error: ' . $e->getMessage();
}
?>

