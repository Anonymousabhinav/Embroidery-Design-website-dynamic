<?php
// Database connection
$servername = "localhost";
$username = "root";  // Change this to your DB username
$password = "";  // Change this to your DB password
$dbname = "kay_kay_embroidery";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL parameter if it exists
$selected_product_id = isset($_GET['productid']) ? intval($_GET['productid']) : '';

// Fetch product data
$sql = "SELECT product_id, product_name, price FROM product"; // Adjust table and column names as needed
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kay Kay Designs - Order</title>
    <link rel="shortcut icon" href="kaykayembroideries_logo.png" />
    <link rel="stylesheet" href="neworder.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@100;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="rectangle"></div>
    <div class="logo">
        <a href="new home.html">
            <img src="logo.png" alt="Logo">
        </a>
    </div>
    <nav class="navigation">
        <a href="new home.html">Home</a>
        <a href="home.php">Products</a>
        <a href="services.html">Services</a>
        <a href="newgallery.html">Gallery</a>
        <a href="about_us.html">About Us</a>
        <div class="hamburger-content">
            <div class="hamburger" id="hamburger-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <div class="dropdown2" id="dropdown2-menu">
                    <a href="newcustom.html">Custom orders</a>
                    <a href="material.html">Materials</a>
                    <a href="software.html">Design software</a>
                    <a href="view_post.php">Blog</a>
                    <a href="contactus.html">Contact Us</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="login-button">
        <a href="login.html">
            <button type="submit">LOG OUT</button>
        </a>
    </div>

    <div class="container">
        <h1>Purchase Order</h1>
        <p>What would you like to purchase?</p>
    
        <!-- User Details Section -->
        <form action="personorder.php" method="POST">
            <label for="first-name">Your Name</label>
            <div class="name-fields">
                <input type="text" id="first-name" name="first-name" placeholder="First Name" required>
                <input type="text" id="last-name" name="last-name" placeholder="Last Name" required>
            </div>
    
            <label for="email">Your E-mail</label>
            <input type="email" id="email" name="email" placeholder="ex: myname@example.com" required>
    
            <label for="address">Shipping Address</label>
            <input type="text" id="address" name="address" placeholder="Street Address" required>
            <input type="text" id="address2" name="address2" placeholder="Street Address Line 2">
    
            <div class="address-details">
                <input type="text" id="city" name="city" placeholder="City" required>
                <input type="text" id="state" name="state" placeholder="State / Province" required>
                <input type="text" id="zip" name="zip" placeholder="ZIP / Postal Code" required>
            </div>

            <div class="prdctid">
                <label for="productid">Product:</label>
                <select id="prdctid" name="productid" required>
                    <option value="">Select Product</option>
                    <?php
                    // Loop through the result set and create the product options
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row["product_id"] == $selected_product_id) ? "selected" : "";
                            echo "<option value='" . htmlspecialchars($row["product_id"]) . "' $selected>" . htmlspecialchars($row["product_name"]) . " - $" . htmlspecialchars($row["price"]) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No products available</option>";
                    }
                    ?>
                </select>
            </div>
    
            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>
