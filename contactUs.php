
<?php
session_start();
?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Casa Bella</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3)), url('image/blog_9.jpeg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }
        .contact-section {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .contact-content {
            position: relative;
            z-index: 1;
            max-width: 600px;
            font-size: larger;
            line-height: 25px
        }

        

    </style>
</head>
<body>
    
    <div class="contact-section">
        <div class="overlay"></div>
        <div class="contact-content">
            <h1>Contact Us</h1><br><br><br>
            <h2>We're here to serve you</h2><br>
            <p>Our team is dedicated to providing you with the best dining experience. Feel free to reach out with any questions.</p><br><br><br>

            <div class="contact-hours">
                <!-- <p><strong>Monday - Friday:</strong> 11 a.m. - 10 p.m.</p>
                <p><strong>Saturday:</strong> 10 a.m. - 11 p.m.</p>
                <p><strong>Sunday:</strong> 10 a.m. - 9 p.m.</p><br><br><br> -->
                <p><strong>Monday - Saturday:</strong> 11 a.m. - 10 p.m.</p>
                <p><strong>Email:</strong> casabella@gmail.com</p>
                <p><strong>Contact No:</strong> +91 8956321023/+91 8956321023</p>
            </div>

            <!-- <div class="contact-buttons">
                <a href="#" class="call-btn">Call 8956321023</a>
                
            </div> -->
        </div>
    </div>

    <?php include 'footer.php';  ?>