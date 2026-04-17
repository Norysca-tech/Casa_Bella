<?php
session_start();
include 'database.php'; // Ensure this file has your database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['email'] = $email;
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];

            header("Location: index.php"); // Redirect to homepage
            exit();
        } else {
            header("Location: login.php?error=Incorrect password");
            exit();
        }
    } else {
        header("Location: login.php?error=User not found");
        exit();
    }
    $conn->close();
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

        .login-container {
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

        .login-container h1 {
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

        .login-button {
            background: #eeeeee;
            color: black;
            border: none;
            padding: 12px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .login-button:hover {
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
    <div class="login-container">
        <img src="image/logo.png" alt="Website Logo" class="logo">
        <h1>Login</h1>
        
        <form method="POST" action="login.php">
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fas fa-user icon"></i>
                </div>
            </div>
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fas fa-lock icon"></i>
                </div>
            </div>
            <div class="options">
                <div class="remember-me">
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">Remember Me</label>
                </div>
                <a href="forget_password.php" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
        <a href="signup.php" class="register-link">Create an Account? Register</a>
        <div class="back-home-btn">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
