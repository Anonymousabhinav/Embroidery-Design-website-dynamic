<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    // Handle image upload
    $target_dir = "uploads2/"; // Directory to store uploaded images
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Prepare SQL statement
        $sql = "INSERT INTO product (product_name, product_image, price, discount) VALUES (?, ?, ?, ?)";
        
        // Prepare and bind
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdd", $product_name, $target_file, $price, $discount);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, your file was not uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image" accept="image/*" required><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="discount">Discount:</label>
        <input type="number" id="discount" name="discount" step="0.01"><br><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>
