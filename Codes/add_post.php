<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Add New Blog Post</h2>
        <form action="add_post.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Post Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>

        <?php
        // Include the database connection
        include 'db_connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $image = $_FILES['image']['name'];

            // Target directory where the image will be saved
            $target_dir = "uploads3/";

            // Check if the directory exists, if not create it
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
            }

            $target_file = $target_dir . basename($image);

            // Move the uploaded image to the target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Insert post into the database
                $sql = "INSERT INTO posts (title, content, image_url) VALUES ('$title', '$content', '$target_file')";
                
                if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success mt-3">New post added successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger mt-3">Error: ' . $sql . '<br>' . $conn->error . '</div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-3">Error uploading image.</div>';
            }

            $conn->close();
        }
        ?>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
