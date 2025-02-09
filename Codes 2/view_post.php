<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kay Kay Designs - Blog</title>
    <link rel="shortcut icon" href="kaykayembroideries_logo.png" />
    <link rel="stylesheet" href="blog2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@100;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="rectangle"></div>
    <div class="logo">
        <a href="new home.html">
            <img src="logo.png">
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

    <div class="abtrectangle">
        <h2>Blog</h2>
        <p>Daily News and updates</p>
        <video src="blgvdo.mp4" loop autoplay muted>
            Your browser does not support the video tag.
        </video>
    </div>



    <?php
    include 'db_connect.php';
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post-wrapper'>";
            echo "<h2 class='post-title'>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Post Image' class='post-image'>"; // Use class for styles
            echo "<p class='post-content'>" . htmlspecialchars($row['content']) . "</p>";
            echo "<p1 class='created-at'>Posted on: " . $row['created_at'] . "</p1>";
            echo "<a href='post_details.php?post_id=" . $row['post_id'] . "'>View Comments</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts found.</p>";
    }
    
    

    $conn->close();
    ?>

<div class="rect">
            <img src="logo.png">
            <a href="faqs">
            <h2 class="t">FAQs</h2>
            </a>
            <a href="testimonial.html">
            <h2 class="t2">Tesimonials</h2>
            </a>
            <a href="privacy">
            <h2 class="t3">Privacy Policy</h2>
            </a>
            <a href="termsconditon.html">
            <h2 class="t4">Terms and Conditions</h2>
            </a>
            <a href="carrers.html">
            <h2 class="t5">Carrers</h2>
            </a>
            <h2 class="imp">Follow Us</h2>
            <div class="insta">
                <a href="https://www.instagram.com/embroiderywithkay/">
                <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
            <div class="face">
                <a href="https://www.facebook.com/people/Kay-Kay-Embroideries/100065631066576/?_rdr">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
            <div class="linkin">
                <a href="https://www.linkedin.com/company/kaykayembroideries/?originalSubdomain=in">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </div>

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>
