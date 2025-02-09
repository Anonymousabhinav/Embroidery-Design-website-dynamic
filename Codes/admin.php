<?php
session_start();
require_once 'connection.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: home.php'); // Redirect to home if not an admin
    exit;
}

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    $stmt = $conn->prepare("INSERT INTO product (product_name, product_image, price, discount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $product_name, $product_image, $price, $discount);
    $stmt->execute();
}

// Handle product removal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
}

// Fetch products
$sql = "SELECT * FROM product";
$all_product = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Panel</h1>

    <h2>Add Product</h2>
    <form method="POST">
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="text" name="product_image" placeholder="Product Image URL" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" step="0.01" name="discount" placeholder="Discount">
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <h2>Remove Product</h2>
    <form method="POST">
        <select name="product_id" required>
            <option value="">Select Product</option>
            <?php while($row = mysqli_fetch_assoc($all_product)): ?>
                <option value="<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="remove_product">Remove Product</button>
    </form>

    <h2>Current Products</h2>
    <ul>
        <?php
        $all_product->data_seek(0); // Reset the pointer to the beginning
        while($row = mysqli_fetch_assoc($all_product)): ?>
            <li><?php echo $row['product_name']; ?> - $<?php echo $row['price']; ?> <img src="<?php echo $row['product_image']; ?>" width="50"></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
