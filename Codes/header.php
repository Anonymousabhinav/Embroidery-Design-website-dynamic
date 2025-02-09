<?php
  require_once 'connection.php';

  // Fetch number of items in the cart
  $sql_cart = "SELECT * FROM cart";
  $all_cart = $conn->query($sql_cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css"> <!-- Assuming your CSS file is header.css -->
    <link rel="stylesheet" href="font/css/all.min.css"> <!-- For Font Awesome icons (cart icon) -->
    <link rel="shortcut icon" href="kaykayembroideries_logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@100;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="rectangle"></div> <!-- Rectangle div -->
        
        <!-- Logo Section -->
        <div class="logo">
            <a href="home.php">
                <img  src="logo.png" alt="Logo">
            </a>
        </div>

        <!-- Navigation Bar -->
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

        <!-- Cart and Logout Section -->
        <div class="cart-and-login">
            <!-- Cart Link with Item Count -->


            <!-- Log out Button -->
            <div class="login-button">
                <a href="login.html">
                    <button type="submit">LOG OUT</button>
                </a>
            </div>
        </div>

    </header>

</body>
</html>
