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

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User is not logged in");
        }

        $userId = $_SESSION['user_id']; // Retrieve user_id from session

        // Retrieve and sanitize input data
        $productType = htmlspecialchars(trim($_POST['product_type']));
        $designDescription = htmlspecialchars(trim($_POST['design_description']));
        $fabricType = htmlspecialchars(trim($_POST['fabric_type']));
        $sizeDimensions = htmlspecialchars(trim($_POST['size_dimensions']));
        $quantity = htmlspecialchars(trim($_POST['quantity']));
        $deliveryDate = htmlspecialchars(trim($_POST['delivery_date']));
        $deliveryAddress = htmlspecialchars(trim($_POST['delivery_address']));
        $specialInstructions = htmlspecialchars(trim($_POST['special_instructions']));
        
        // Prepare and execute the insertion query
        $orderQuery = $conn->prepare("
        INSERT INTO customer_orders (
            user_id, product_type, design_description, fabric_type, size_dimensions,
            quantity, delivery_date, delivery_address, special_instructions
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $orderQuery->execute([
            $userId, $productType, $designDescription, $fabricType, $sizeDimensions,
            $quantity, $deliveryDate, $deliveryAddress, $specialInstructions
        ]);

        // Redirect or display a success message
        header('Location: sucessordered.php');
        exit();
    }
} catch (PDOException $e) {
    // Handle connection or query errors
    echo 'Database Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle general errors
    echo 'Error: ' . $e->getMessage();
}
?>







