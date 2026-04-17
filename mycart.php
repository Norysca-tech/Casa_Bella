<?php
session_start();
require_once "database.php";

$user_id = $_SESSION['user_id']; // Dynamic user ID from session

// Handle Update Quantity
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_cart"])) {
    $cart_id = intval($_POST["cart_id"]);
    $change = intval($_POST["update_cart"]);

    $sql = "SELECT quantity FROM cart WHERE id = $cart_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQuantity = $row["quantity"] + $change;
        if ($newQuantity > 0) {
            $updateQuery = "UPDATE cart SET quantity = $newQuantity WHERE id = $cart_id";
            $conn->query($updateQuery);
        }
    }
}

// Handle Remove Item
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["remove_cart"])) {
    $cart_id = intval($_POST["cart_id"]);
    $deleteQuery = "DELETE FROM cart WHERE id = $cart_id";
    $conn->query($deleteQuery);
}

// Fetch Cart Data
$sql = "SELECT p.*, c.quantity, c.id AS cart_id 
        FROM products p 
        JOIN cart c ON p.id = c.product_id 
        WHERE c.user_id = $user_id";
$result = $conn->query($sql);

$products = [];
$totalPrice = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
        $totalPrice += $row['productPrice'] * $row['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <style> 
        table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

thead {
    background: #f8f9fa;
    color: #333;
}

th, td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background: #f1f1f1;
}

.cart-item-image {
    width: 60px;
    height: 60px;
    border-radius: 5px;
}

.quantity-input {
    width: 40px;
    text-align: center;
    border: none;
    font-size: 16px;
    font-weight: bold;
    background: transparent;
}

button {
    cursor: pointer;
    border: none;
    padding: 5px 10px;
    margin: 2px;
    font-size: 14px;
    border-radius: 5px;
}

button[name="update_cart"] {
    background: #28a745;
    color: #fff;
}

button[name="update_cart"]:hover {
    background: #218838;
}

.remove-item {
    background: #dc3545;
    color: white;
    padding: 8px 10px;
    border-radius: 50%;
}

.remove-item:hover {
    background: #c82333;
}

    </style>

    <section class="cart-section">
        <h1>Your Shopping Cart</h1>
        <div class="cart-container">
            <div class="cart-items">
                <?php if (empty($products)) : ?>
                    <div class="empty-cart-message">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Your cart is empty</p>
                        <a href="menu.php" class="btn">Shop Now</a>
                    </div>
                <?php else : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td><img src="<?= $product['productImage1'] ?>" class="cart-item-image" alt="<?= $product['productName'] ?>"></td>
                                    <td><?= $product['productName'] ?></td>
                                    <td>Rs.<?= number_format($product['productPrice'], 2) ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="cart_id" value="<?= $product['cart_id'] ?>">
                                            <button type="submit" name="update_cart" value="-1">-</button>
                                            <input type="text" class="quantity-input" value="<?= $product['quantity'] ?>" readonly>
                                            <button type="submit" name="update_cart" value="1">+</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="cart_id" value="<?= $product['cart_id'] ?>">
                                            <button type="submit" name="remove_cart" class="remove-item"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <div class="summary-item"><span>Subtotal</span><span>Rs.<?= number_format($totalPrice, 2) ?></span></div>
                <div class="summary-item"><span>Shipping</span><span>Rs.<?= ($totalPrice > 0) ? '50.00' : '0.00' ?></span></div>
                <div class="summary-item"><span>Tax</span><span>Rs.<?= number_format($totalPrice * 0.08, 2) ?></span></div>
                <div class="summary-item total"><span>Total</span><span>Rs.<?= number_format($totalPrice + ($totalPrice > 0 ? 50 : 0) + ($totalPrice * 0.08), 2) ?></span></div>
                <button class="btn checkout-btn"><a href="checkout.php" class="btn btn-primary" style="text-decoration: none;">Proceed to Checkout</a></button>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>