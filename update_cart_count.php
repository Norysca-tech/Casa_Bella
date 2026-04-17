<?php
session_start();
include 'database.php';

$user_id = $_SESSION['user_id']; // Default user_id (Change as per session)

$cartQuery = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$count_row = $result->fetch_assoc();

$cart_count = $count_row['cart_count'] ?? 0;
echo $cart_count;
?>
