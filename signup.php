<?php
include 'database.php';

$message = ""; // To store messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email already exists
    $check_user = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check_user->bind_param("s", $email);
    $check_user->execute();
    $result = $check_user->get_result();

    if ($result->num_rows > 0) {
        $message = "<p style='color:red;'>Email already registered.</p>";
    } else {
        // Insert user data into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registration successful! Redirecting to login page...');
                window.location.href = 'Login.php';
            </script>";
            exit();
        } else {
            $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
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

        .register-container {
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

        .register-container h1 {
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

        .btn-signup {
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

        .btn-signup:hover {
            background:rgb(180, 207, 215);
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
    <div class="register-container">
    <img src="image/logo.png" alt="Website Logo" class="logo">
        <h1>Sign Up</h1>
        <?php echo $message; ?>
        <form id="signupForm" method="POST" action="signup.php">

            <div class="input-field">
                <div class="input-wrapper">
                    <input type="text" id="name" name="name" class="input-field" placeholder="Name" required>
                    <div id="nameError" class="error"></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="input-field" placeholder="Email" required>
                    <div id="emailError" class="error"></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="tel" id="phone" name="phone" class="input-field" placeholder="Phone Number" required>
                    <div id="phoneError" class="error"></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
                    <div id="passwordError" class="error"></div>
                </div>
            </div>
            <button type="submit" class="btn-signup">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="Login.php">Log in</a>
        </div>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            let isValid = true;

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value.trim();

            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailError');
            const phoneError = document.getElementById('phoneError');
            const passwordError = document.getElementById('passwordError');

            nameError.textContent = '';
            emailError.textContent = '';
            phoneError.textContent = '';
            passwordError.textContent = '';

            if (name === '') {
                nameError.textContent = 'Name is required';
                isValid = false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                emailError.textContent = 'Enter a valid email address';
                isValid = false;
            }

            const phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone)) {
                phoneError.textContent = 'Enter a valid 10-digit phone number';
                isValid = false;
            }

            if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
