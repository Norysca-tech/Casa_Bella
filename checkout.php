<?php
session_start();
include 'database.php'; // Database connection

$user_id = $_SESSION['user_id']; // Ensure user is logged in

if (!$user_id) {
    echo "<script>alert('Please log in to proceed to checkout!'); window.location='login.php';</script>";
    exit;
}

// Fetch cart items from the database
$sql = "SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.productName, p.productPrice 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = $user_id";

$result = $conn->query($sql);
$cart = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart[] = $row;
    }
} else {
    echo "<h2>Your cart is empty!</h2>";
    exit;
}

// Calculate total amount
$totalPrice = array_sum(array_map(function ($item) {
    return $item['productPrice'] * $item['quantity'];
}, $cart));

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['payment_method'] === "COD") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method'];
    $user_id=$_SESSION['user_id'];

    // Insert order into database
    $orderQuery = "INSERT INTO orders (user_id, customer_name, phone, address, payment_method, total_price) 
                   VALUES ('$user_id', '$name', '$phone', '$address', '$paymentMethod', '$totalPrice')";
    if ($conn->query($orderQuery)) {
        $orderId = $conn->insert_id;

        foreach ($cart as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['productPrice'];
            $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                          VALUES ('$orderId', '$productId', '$quantity', '$price')");
        }

        $conn->query("DELETE FROM cart WHERE user_id = $user_id");
        echo "<script>alert('Order placed successfully!'); window.location='order_confirmation.php';</script>";
    } else {
        echo "<script>alert('Error placing order');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
        <div style="max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h2 style="text-align: center; margin-bottom: 20px;">Checkout</h2>
            
            <table style="width: 100%; border-collapse: collapse; text-align: center; margin-bottom: 20px;">
                <thead style="background: #343a40; color: white;">
                    <tr>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Product</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Price</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Quantity</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                    <tr style="background: #fff;">
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo $item['productName']; ?></td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo $item['productPrice']; ?> RS</td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo $item['quantity']; ?></td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?php echo $item['productPrice'] * $item['quantity']; ?> RS</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <h4 style="text-align: right; margin-bottom: 20px;">Total Price: <strong><?php echo $totalPrice; ?> RS</strong></h4>

        <form id="checkout-form" method="post">
            <input type="hidden" id="totalPrice" value="<?= $totalPrice ?>">
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" id="name" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Phone:</label>
                <input type="text" name="phone" id="phone" required class="form-control">
            </div>
            <div class="mb-3">
                <label>Address:</label>
                <textarea name="address" id="address" required class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Payment Method:</label>
                <select name="payment_method" id="payment_method" class="form-control" onchange="togglePayButton()">
                    <option value="COD">Cash on Delivery</option>
                    <option value="Online">Online Payment</option>
                </select>
            </div>
            <button type="submit" id="codButton" class="btn btn-primary">Place Order</button>
            <button type="button" id="payButton" class="btn btn-success" style="display: none;">Pay with Razorpay</button>
        </form>
    </div>
    <script>
    function togglePayButton() {
        var paymentMethod = document.getElementById("payment_method").value;
        document.getElementById("codButton").style.display = paymentMethod === "COD" ? "block" : "none";
        document.getElementById("payButton").style.display = paymentMethod === "Online" ? "block" : "none";
    }

    $('#payButton').click(function (e) {
    var amount = $('#totalPrice').val() * 100;
    var name = $('#name').val();
    var phone = $('#phone').val();
    var address = $('#address').val();

    if (!amount || !name || !phone || !address) {
        alert('Please fill all fields');
        return;
    }

    var options = {
        "key": "rzp_test_44kONeFWXachHi",
        "amount": amount,
        "currency": "INR",
        "name": "Your Company Name",
        "description": "Payment for your purchase",
        "prefill": {
            "name": name,
            "contact": phone
        },
        "theme": { "color": "#F37254" },
        "handler": function (response) {
            $.post('charge.php', {
                razorpay_payment_id: response.razorpay_payment_id,
                amount: amount,
                name: name,
                phone: phone,
                address: address
            }, function (result) {
                window.location = 'order_confirmation.php';
            }).fail(function () {
                alert('Payment failed!');
            });
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
});

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>

</body>
</html>
