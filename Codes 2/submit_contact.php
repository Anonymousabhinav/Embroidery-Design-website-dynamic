<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $firstName = htmlspecialchars(trim($_POST['first-name']));
    $lastName = htmlspecialchars(trim($_POST['last-name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Check if user is logged in and retrieve user_id
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        $userId = NULL; // or handle the case when user is not logged in
    }

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        echo "Please fill in all required fields.";
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Database connection details
    $host = 'localhost';
    $db = 'kay_kay_embroidery'; // Ensure this is the correct database name
    $user = 'root';
    $pass = '';

    try {
        // Create a new PDO instance
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query to insert the contact form data
        $query = "INSERT INTO contact_messages (first_name, last_name, email, subject, message, user_id) 
                VALUES (:first_name, :last_name, :email, :subject, :message, :user_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: contactsuccess.php');
            exit();
        } else {
            header('Location: invalidcontact.php');
            exit();
        }

    } catch (PDOException $e) {
        // Handle connection errors
        echo 'Connection failed: ' . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
