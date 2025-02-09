<?php

// Connect to the Addtocart database
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "kay_kay_embroidery";

$conn = new mysqli($servername, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    // Sanitize product_id to avoid SQL injection
    $product_id = intval($_GET["id"]);

    // Check if the product is already in the cart
    $sql = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
    $sql->bind_param("i", $product_id);
    $sql->execute();
    $result = $sql->get_result();

    // Get the total number of items in the cart
    $total_cart = "SELECT * FROM cart";
    $total_cart_result = $conn->query($total_cart);
    $cart_num = mysqli_num_rows($total_cart_result);

    if (mysqli_num_rows($result) > 0) {
        // Product already in the cart
        $in_cart = "already In cart";
        echo json_encode(["num_cart" => $cart_num, "in_cart" => $in_cart]);
    } else {
        // Insert product into the cart
        $insert = $conn->prepare("INSERT INTO cart (product_id) VALUES (?)");
        $insert->bind_param("i", $product_id);
        if ($insert->execute()) {
            // Update cart count after insertion
            $cart_num++;
            $in_cart = "added into cart";
            echo json_encode(["num_cart" => $cart_num, "in_cart" => $in_cart]);
        } else {
            echo json_encode(["error" => "Failed to add to cart"]);
        }
    }
}

if (isset($_GET["cart_id"])) {
    // Sanitize product_id for removing from the cart
    $product_id = intval($_GET["cart_id"]);

    // Delete the product from the cart
    $delete = $conn->prepare("DELETE FROM cart WHERE product_id = ?");
    $delete->bind_param("i", $product_id);

    if ($delete->execute()) {
        // Return updated cart number after removal
        $total_cart_result = $conn->query("SELECT * FROM cart");
        $cart_num = mysqli_num_rows($total_cart_result);
        echo json_encode(["num_cart" => $cart_num, "message" => "Removed from cart"]);
    } else {
        echo json_encode(["error" => "Failed to remove from cart"]);
    }
}

?>
