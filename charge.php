<?php
session_start();
include 'database.php'; // Database connection

require 'Payment-main/vendor/autoload.php';

use Razorpay\Api\Api;

// Replace with your Razorpay Key ID and Key Secret
$keyId = 'rzp_test_44kONeFWXachHi';
$keySecret = '6RZqUjyGoKLJDSX7iXB7WhUX';

$api = new Api($keyId, $keySecret);

if (!isset($_POST['razorpay_payment_id']) || !isset($_POST['amount']) || !isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['address'])) {
    $error = "Payment ID, amount, or customer details are missing!";
    file_put_contents('payment.log', date('Y-m-d H:i:s') . " - Error: " . $error . "\n", FILE_APPEND);
    header("Location: payment_failure.php?error=" . urlencode($error));
    exit;
}

$paymentId = $_POST['razorpay_payment_id'];
$amount = $_POST['amount'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$paymentMethod = "Online Payment";
$user_id =  $_SESSION['user_id'];

try {
    // Fetch the payment object
    $payment = $api->payment->fetch($paymentId);

    // Capture the payment
    $payment->capture(['amount' => $amount]);

    $totalPrice = $amount / 100; 
    $orderQuery = "INSERT INTO orders (user_id, customer_name, phone, address, payment_method, total_price) 
                   VALUES ('$user_id', '$name', '$phone', '$address', '$paymentMethod', '$totalPrice')";

    if ($conn->query($orderQuery)) {
        $orderId = $conn->insert_id;

        // Fetch cart items from database
        $cartQuery = "SELECT product_id, quantity, (SELECT productPrice FROM products WHERE id = cart.product_id) AS price FROM cart WHERE user_id = $user_id";
        $result = $conn->query($cartQuery);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                $quantity = $row['quantity'];
                $price = $row['price'];

                // Insert into order_items table
                $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                              VALUES ('$orderId', '$productId', '$quantity', '$price')");
            }
        }

        // Clear the cart after successful order placement
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        // Log success
        file_put_contents('payment.log', date('Y-m-d H:i:s') . " - Success: Payment successful & Order placed: " . $paymentId . "\n", FILE_APPEND);

        header("Location: order_confirmation.php?payment_id=" . $paymentId);
        exit;
    } else {
        throw new Exception("Order placement failed.");
    }

} catch (\Exception $e) {
    $error = "Payment failed: " . $e->getMessage();
    file_put_contents('payment.log', date('Y-m-d H:i:s') . " - Error: " . $error . "\n", FILE_APPEND);
    header("Location: payment_failure.php?error=" . urlencode($error));
    exit;
}
?>
