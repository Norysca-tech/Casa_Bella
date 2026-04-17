<?php
session_start();
include 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "error: not_logged_in";
    exit();
}

// Get user ID
$user_id = $_SESSION['user_id'];

// Validate POST data
if (!isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'])) {
    echo "error: invalid_data";
    exit();
}

$product_id = intval($_POST['product_id']);
$product_name = $conn->real_escape_string($_POST['product_name']);
$product_price = floatval($_POST['product_price']);

// Check if the product is already in the cart
$checkCart = $conn->prepare("SELECT * FROM cart WHERE product_id = ? AND user_id = ?");
$checkCart->bind_param("ii", $product_id, $user_id);
$checkCart->execute();
$result = $checkCart->get_result();

if ($result->num_rows > 0) {
    // Update quantity if product exists in the cart
    $updateCart = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ? AND user_id = ?");
    $updateCart->bind_param("ii", $product_id, $user_id);
    $updateCart->execute();
    $updateCart->close();
    header("Location: menu.php");
} else {
    // Insert new product into the cart
    $insertCart = $conn->prepare("INSERT INTO cart (product_id, product_name, product_price, user_id, quantity) VALUES (?, ?, ?, ?, 1)");
    $insertCart->bind_param("isdi", $product_id, $product_name, $product_price, $user_id);
    $insertCart->execute();
    $insertCart->close();
    header("Location: menu.php");
}

$checkCart->close();
$conn->close();

header("Location: menu.php");
?>
