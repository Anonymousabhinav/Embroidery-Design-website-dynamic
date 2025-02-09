<?php
require_once 'connection.php';

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
    <title>Kay Kay Embroidery</title>
</head>
<body>
    <?php include_once 'header.php'; ?>
    <div class="header">
        <h1 class="header-text">Products</h1>
        <p class="header-text2">Browse the products</p>
        <div class="header-color"></div>
    </div>

    <main>
        <?php while ($row = mysqli_fetch_assoc($all_product)): ?>
        <div class="card">
            <div class="image">
                <img src="<?php echo htmlspecialchars($row["product_image"]); ?>" alt="<?php echo htmlspecialchars($row["product_name"]); ?>">
            </div>
            <div class="caption">
                <p class="product_name"><?php echo htmlspecialchars($row["product_name"]); ?></p>
                <p class="price"><b>$<?php echo htmlspecialchars($row["price"]); ?></b></p>
                <p class="discount"><b><del>$<?php echo htmlspecialchars($row["discount"]); ?></del></b></p>
            </div>
            <button class="add" data-id="<?php echo $row["product_id"]; ?>" onclick="redirectToPurchase(this)">Buy</button>
        </div>
        <?php endwhile; ?>
    </main>

    <script>
        function redirectToPurchase(button) {
            const productId = button.getAttribute("data-id");
            window.location.href = "neworder.php?productid=" + productId;
        }
    </script>
</body>
</html>
