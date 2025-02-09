<?php
// Database connection details for kay_kay_embroidery
$host = 'localhost'; 
$db = 'kay_kay_embroidery';  // Database for users, orders, and products
$user = 'root'; 
$pass = ''; 

// Data Source Name (DSN) for the kay_kay_embroidery database
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// Options for PDO connection
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Create PDO instance for the database
try {
    $pdo = new PDO($dsn, $user, $pass, $options);  // Database connection
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Retrieve form data
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$productId = $_POST['productid'];

// Check if user exists in the users table
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
$userId = $stmt->fetchColumn();

if (!$userId) {
    error_log("User not found: $email");
    header('Location: invalidorder.php?error=user_not_found');
    exit();
}

// Check if the product exists in the products table
$stmt = $pdo->prepare('SELECT * FROM product WHERE product_id = ?');
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    error_log("Product not found: $productId");
    header('Location: invalidorder.php?error=product_not_found');
    exit();
}

// Insert the order into the orders table
$stmt = $pdo->prepare('
    INSERT INTO orders (user_id, product_id, first_name, last_name, email, address, address2, city, state, zip, quantity)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
');
$stmt->execute([$userId, $productId, $firstName, $lastName, $email, $address, $address2, $city, $state, $zip, 1]);

header('Location: succesorder.php');
exit();
?>
