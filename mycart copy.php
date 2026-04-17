<?php
session_start();
require_once "database.php";

$user_id = $_SESSION['user_id']; // Change dynamically if using authentication

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
$sql = "SELECT p.*, c.quantity, c.id AS cart_id FROM products p JOIN cart c ON p.id = c.product_id WHERE c.user_id = $user_id";
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
</head>
<body>
    <header>
        <div class="logo"><h1>Amami</h1></div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Collections</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="nav-icons">
            <a href="liked.php"><i class="fas fa-heart"></i></a>
            <a href="cart.php" class="active"><i class="fas fa-shopping-cart"></i></a>
            <a href="login.php"><i class="fas fa-user"></i></a>
        </div>
    </header>

    <section class="cart-section">
        <h1>Your Shopping Cart</h1>
        <div class="cart-container">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)) { ?>
                        <tr><td colspan="5">Your cart is empty</td></tr>
                    <?php } else { foreach ($products as $product) { ?>
                        <tr>
                            <td><img src="<?= $product['productImage'] ?>" width="50" alt="<?= $product['productName'] ?>"> <?= $product['productName'] ?></td>
                            <td>Rs.<?= number_format($product['productPrice'], 2) ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="cart_id" value="<?= $product['cart_id'] ?>">
                                    <button type="submit" name="update_cart" value="-1">-</button>
                                    <?= $product['quantity'] ?>
                                    <button type="submit" name="update_cart" value="1">+</button>
                                </form>
                            </td>
                            <td>Rs.<?= number_format($product['productPrice'] * $product['quantity'], 2) ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="cart_id" value="<?= $product['cart_id'] ?>">
                                    <button type="submit" name="remove_cart">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <p>Subtotal: Rs.<?= number_format($totalPrice, 2) ?></p>
            <p>Shipping: Rs.<?= ($totalPrice > 0) ? "50.00" : "0.00" ?></p>
            <p>Tax: Rs.<?= number_format($totalPrice * 0.08, 2) ?></p>
            <p class="total">Total: Rs.<?= number_format($totalPrice + ($totalPrice > 0 ? 50 : 0) + ($totalPrice * 0.08), 2) ?></p>
            <button class="btn checkout-btn" <?= ($totalPrice > 0) ? "" : "disabled" ?>>Proceed to Checkout</button>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Amami Jewelry. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
