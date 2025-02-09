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

    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        // Verify the token
        $checkTokenQuery = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires >= ?");
        $checkTokenQuery->execute([$token, date('U')]);
        $resetRequest = $checkTokenQuery->fetch(PDO::FETCH_ASSOC);

        if ($resetRequest) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $email = $resetRequest['email'];

                // Update the user's password
                $updatePasswordQuery = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $updatePasswordQuery->execute([$newPassword, $email]);

                // Remove the token from the database
                $deleteTokenQuery = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                $deleteTokenQuery->execute([$token]);

                echo 'Password has been updated. You can now <a href="login.php">log in</a>.';
            }
        } else {
            echo 'Invalid or expired token.';
        }
    }
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($_GET['token']); ?>">
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Reset Password</button>
</form>
