<?php
include 'database.php';

$message = ""; // Message for status updates

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify'])) {
        // Step 1: Verify Email & Phone
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            session_start();
            $_SESSION['reset_email'] = $email; // Store email for next step
            header("Location: reset_password.php");
            exit();
        } else {
            $message = "<p style='color:red;'>Invalid email or phone number.</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(133deg,rgb(221, 220, 222),rgba(213, 208, 223, 0.77));
        }

        .container {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-field {
            margin-bottom: 15px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-wrapper .icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: black;
            font-size: 16px;
        }

        .input-wrapper input {
            width: 85%;
            padding: 12px 40px 12px 15px;
            border: 2px solid black;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
        }

        .input-wrapper input:focus {
            border-color: #36D1DC;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            color: #333;
        }

        .forgot-password {
            color: black;
            cursor: pointer;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-submit {
            background: black;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background:rgb(215, 195, 180);
        }

        .register-link {
            font-size: 14px;
            color: black;
            display: block;
            margin-top: 15px;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .back-home-btn {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <img src="image/logo.png" alt="Website Logo" class="logo">
        <h1>Forgot Password</h1>
        <?php echo $message; ?>
        <form method="POST" action="forget_password.php">
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="email" name="email" class="input-field" placeholder="Enter your Email" required>
                    <div id="emailError" class="error"></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="tel" name="phone" class="input-field" placeholder="Enter your Phone Number" required>
                    <div id="phoneError" class="error"></div>
                </div>
            </div>
            
            <button type="submit" name="verify" class="btn-submit">Verify</button>
        </form>
    </div>
</body>
</html>
