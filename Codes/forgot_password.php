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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars(trim($_POST['email']));

        // Check if email exists
        $checkEmailQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmailQuery->execute([$email]);
        $user = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate a unique token
            $token = bin2hex(random_bytes(50));
            $expires = date('U') + 3600; // Token expires in 1 hour

            // Store token in the database
            $insertTokenQuery = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
            $insertTokenQuery->execute([$email, $token, $expires]);

            // Send email with reset link
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            mail($email, 'Password Reset', "Click the following link to reset your password: $resetLink");

            echo 'A password reset link has been sent to your email.';
        } else {
            echo 'Email not found.';
        }
    }
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<form method="POST" action="forgot_password.php">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Link</button>
</form>
