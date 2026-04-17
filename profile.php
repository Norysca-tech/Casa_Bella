<?php
session_start();
include 'database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user = $user_query->get_result()->fetch_assoc();

// Fetch order history
$order_query = $conn->prepare("SELECT orders.id AS order_id, orders.order_date, orders.status, orders.total_price, 
           GROUP_CONCAT(products.productName SEPARATOR ', ') AS product_names
    FROM orders
    JOIN order_items ON orders.id = order_items.order_id
    JOIN products ON order_items.product_id = products.id
    WHERE orders.user_id = ?
    GROUP BY orders.id
    ORDER BY orders.id DESC");
$order_query->bind_param("i", $user_id);
$order_query->execute();
$orders = $order_query->get_result();

// Handle password update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new password and confirmation
    if ($new_password !== $confirm_password) {
        $password_error = "New passwords don't match";
    } elseif (strlen($new_password) < 8) {
        $password_error = "Password must be at least 8 characters";
    } else {
        // Fetch user password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user_password = $stmt->get_result()->fetch_assoc();

        // Verify current password
        if ($user_password['password']) {
            if (password_verify($current_password, $user_password['password'])) {
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_hashed_password, $user_id);
                if ($update_stmt->execute()) {
                    $password_success = "Password updated successfully!";
                } else {
                    $password_error = "Error updating password.";
                }
            } else {
                $password_error = "Incorrect current password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color:rgb(229, 93, 14);
            --primary-dark: #ff6f61;
            --primary-light: #e1f0ff;
            --secondary-color: #00b4a0;
            --text-primary: #12263f;
            --text-secondary: #6e84a3;
            --divider-color: #e3ebf6;
            --success-color: #00d97e;
            --warning-color: #f6c343;
            --error-color: #e63757;
            --info-color: #ff6f61;
            --background: #f9fbfd;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.1);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .profile-section {
            padding: 2rem 0;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-header h1 {
            font-size: 2rem;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .profile-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--divider-color);
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid var(--primary-light);
            box-shadow: var(--shadow-sm);
        }

        .profile-info h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .profile-detail {
            margin: 0.5rem 0;
            color: var(--text-secondary);
        }

        .profile-detail strong {
            color: var(--text-primary);
        }

        .btn {
            display: inline-block;
            background: var(--primary-color);
            color: var(--white);
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 1rem;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-light);
        }

        .order-history {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--divider-color);
        }

        .order-history h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--divider-color);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            min-width: 600px;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--divider-color);
        }

        th {
            background: var(--primary-color);
            color: var(--white);
            font-weight: 500;
            position: sticky;
            top: 0;
        }

        tr:hover {
            background: var(--primary-light);
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending { background: #fff8e1; color: #ff8f00; }
        .status-processing { background: #e3f2fd; color: #1976d2; }
        .status-shipped { background: #e8f5e9; color: #388e3c; }
        .status-delivered { background: #e0f7fa; color: #00838f; }
        .status-cancelled { background: #ffebee; color: #d32f2f; }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(3px);
        }

        .modal-content {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--radius-md);
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
            position: relative;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
            transition: color 0.2s ease;
        }

        .close:hover {
            color: var(--error-color);
        }

        .modal-title {
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--divider-color);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.9rem;
            transition: border 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(44, 123, 229, 0.2);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .alert i {
            margin-right: 0.5rem;
        }

        .alert-success {
            background: #e6f7ee;
            color: #007a4e;
            border-left: 3px solid var(--success-color);
        }

        .alert-error {
            background: #ffebef;
            color: #cc1f3a;
            border-left: 3px solid var(--error-color);
        }

        .no-orders {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
            
            th, td {
                padding: 0.5rem;
                font-size: 0.85rem;
            }
            
            .profile-header h1 {
                font-size: 1.5rem;
            }
            
            .profile-info h2 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .profile-card, .order-history {
                padding: 1rem;
            }
            
            .modal-content {
                padding: 1.5rem 1rem;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container profile-section">
    <div class="profile-header">
        <h1>My Account</h1>
        <p>Welcome back, <?= htmlspecialchars($user['name']) ?>!</p>
    </div>

    <div class="profile-grid">
        <div class="profile-card">
            <div class="profile-info">
                <img src="image/users.jpg" class="profile-pic" alt="Profile Picture">
                <h2><?= htmlspecialchars($user['name']) ?></h2>
                <p class="profile-detail">Email: <strong><?= htmlspecialchars($user['email']) ?></strong></p>
                <p class="profile-detail">Phone: <strong><?= htmlspecialchars($user['phone']) ?></strong></p>
                <button onclick="openModal()" class="btn">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </div>
        </div>

        <div class="order-history">
            <h3><i class="fas fa-history"></i> Order History</h3>
            <div class="table-responsive">
                <?php if ($orders->num_rows > 0) { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Products</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $order_no = $orders->num_rows;
                            while ($order = $orders->fetch_assoc()) { 
                                $status_class = "status-" . strtolower($order['status']);
                            ?>
                                <tr>
                                    <td><?= $order_no-- ?></td>
                                    <td><?= htmlspecialchars($order['product_names']) ?></td>
                                    <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                                    <td><span class="status-badge <?= $status_class ?>"><?= $order['status'] ?></span></td>
                                    <td>$<?= number_format($order['total_price'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="no-orders">
                        <i class="fas fa-box-open" style="font-size: 3rem; color: var(--primary-light); margin-bottom: 1rem;"></i>
                        <h4>No Orders Yet</h4>
                        <p>You haven't placed any orders yet. Start shopping now!</p>
                        <a href="products.php" class="btn">Browse Products</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 class="modal-title">Change Password</h3>
        
        <?php if (isset($password_success)) { ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= $password_success ?>
            </div>
        <?php } ?>
        
        <?php if (isset($password_error)) { ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= $password_error ?>
            </div>
        <?php } ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
                <small style="display: block; margin-top: 0.25rem; color: var(--text-secondary);">Minimum 8 characters</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            
            <button type="submit" name="update_password" class="btn">
                <i class="fas fa-save"></i> Update Password
            </button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    function openModal() {
        document.getElementById("passwordModal").style.display = "flex";
        // Clear any previous messages when opening modal
        document.querySelectorAll('.alert').forEach(el => el.style.display = 'none');
    }

    function closeModal() {
        document.getElementById("passwordModal").style.display = "none";
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('passwordModal');
        if (event.target == modal) {
            closeModal();
        }
    }

    // Password visibility toggle (optional enhancement)
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
            
            const toggle = document.createElement('span');
            toggle.innerHTML = '<i class="fas fa-eye"></i>';
            toggle.style.position = 'absolute';
            toggle.style.right = '10px';
            toggle.style.top = '50%';
            toggle.style.transform = 'translateY(-50%)';
            toggle.style.cursor = 'pointer';
            toggle.style.color = 'var(--text-secondary)';
            wrapper.appendChild(toggle);
            
            toggle.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    toggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    input.type = 'password';
                    toggle.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    });
</script>

</body>
</html>

<?php 
$conn->close();
?>