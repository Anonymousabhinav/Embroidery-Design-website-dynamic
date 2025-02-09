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
        $email = htmlspecialchars(trim($_POST['email']));
        $password = $_POST['password'];

        // Debugging: Check if form data is being received
        echo "Email: $email<br>";
        echo "Password (input): $password<br>";

        // Prepare and execute the query to check user credentials
        $loginQuery = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $loginQuery->execute([$email]);

        // Fetch the user data
        $user = $loginQuery->fetch(PDO::FETCH_ASSOC);

        // Debugging: Check if the user data is fetched
        if ($user) {
            echo "User found: " . $user['username'] . "<br>";

            // Check if the password matches
            if (password_verify($password, $user['password'])) {
                echo "Password verified successfully<br>";

                // Store user data in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to another page
                header('Location: new home.html');
                exit();
            } else {
                header('Location: invalidlogin.php');
                exit();
            }
        } else {
            header('Location: invalidlogin.php');
            exit();
        }

    }
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>
