<?php
include 'db_connect.php';

// Validate post_id
if (!isset($_GET['post_id'])) {
    die("No post ID provided.");
}

$post_id = $_GET['post_id'];

// Fetch the specific post
$post_sql = "SELECT * FROM posts WHERE post_id = $post_id";
$post_result = $conn->query($post_sql);
if (!$post_result) {
    die("Error fetching post: " . $conn->error);
}

$post = $post_result->fetch_assoc();
if (!$post) {
    die("No post found.");
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $comment_content = $_POST['comment_content'];

    $comment_sql = "INSERT INTO comments (post_id, user_name, content) VALUES ($post_id, '$user_name', '$comment_content')";
    if ($conn->query($comment_sql) === TRUE) {
        echo "Comment added!";
    } else {
        echo "Error: " . $comment_sql . "<br>" . $conn->error;
    }
}

// Fetch all comments for the post
$comment_sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
$comment_result = $conn->query($comment_sql);
if (!$comment_result) {
    die("Error fetching comments: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $post['title']; ?></title>
    <link rel="stylesheet" href="post_details.css">
    <link rel="stylesheet" href="blog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@100;400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="rectangle"></div>
    <div class="logo">
        <a href="new home.html">
            <img src="logo.png" >
        </a>
    </div>
    <nav class="navigation">
        <a href="new home.html">Home</a>
        <a href="newproduct.html">Products</a>
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
                    <a href="blog.html">Blog</a>
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

        <div class="post-container">
        <!-- Post Title -->
        <h1 class="post-title"><?php echo $post['title']; ?></h1>
        
        <!-- Post Image -->
        <img src="<?php echo $post['image_url']; ?>" class="post-image" alt="Post Image"><br>
        
        <!-- Post Content -->
        <p class="post-content"><?php echo $post['content']; ?></p>
        
        <!-- Post Date -->
        <p class="posted-on">Posted on: <?php echo $post['created_at']; ?></p>

        <hr>

        <!-- Comments Section -->
        <h2 class="comments-title">Comments</h2>
        <div class="comments-section">
            <?php
            if ($comment_result->num_rows > 0) {
                while ($comment = $comment_result->fetch_assoc()) {
                    echo '<div class="comment">';
                    echo "<strong>" . $comment['user_name'] . "</strong><br>";
                    echo "<p>" . $comment['content'] . "</p>";
                    echo "<p class='comment-date'>Posted on: " . $comment['created_at'] . "</p>";
                    echo "<hr>";
                    echo '</div>';
                }
            } else {
                echo '<p>No comments yet.</p>';
            }
            ?>
        </div>

        <hr>

        <!-- Comment Form -->
        <h3 class="comment-form-title">Add a Comment</h3>
        <form action="post_details.php?post_id=<?php echo $post_id; ?>" method="POST" class="comment-form">
            <label for="user_name">Your Name:</label>
            <input type="text" name="user_name" class="input-text" required><br>

            <label for="comment_content">Comment:</label>
            <textarea name="comment_content" class="textarea-comment" required></textarea><br>

            <input type="submit" value="Submit" class="submit-button">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
