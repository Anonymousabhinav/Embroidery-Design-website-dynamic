<?php
session_start(); // Start session to access user information

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $rating = intval($_POST['rating']);
    $visitReason = htmlspecialchars(trim($_POST['visit-reason']));
    $experience = htmlspecialchars(trim($_POST['experience']));
    $improvement = htmlspecialchars(trim($_POST['improvement']));
    $recommend = htmlspecialchars(trim($_POST['recommend']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($rating) || empty($visitReason) || empty($experience) || empty($improvement) || empty($recommend)) {
        echo "Please fill in all required fields.";
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Get user_id from session (assuming user is logged in and user_id is stored in session)
    $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

    // Database connection details
    $host = 'localhost';
    $db = 'kay_kay_embroidery'; // Ensure this is the correct database name
    $user = 'root';
    $pass = '';

    try {
        // Create a new PDO instance
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the query to insert the feedback data
        $query = "INSERT INTO website_feedback (name, email, rating, visit_reason, experience, improvement, recommend, user_id) 
                  VALUES (:name, :email, :rating, :visit_reason, :experience, :improvement, :recommend, :user_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':visit_reason', $visitReason);
        $stmt->bindParam(':experience', $experience);
        $stmt->bindParam(':improvement', $improvement);
        $stmt->bindParam(':recommend', $recommend);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: successfeedback.php');
            exit();
        } else {
            header('Location: invalidfeedback.php');
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

