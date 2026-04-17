<?php

include 'database.php';

// var_dump($_SESSION['user_id']);
// echo"sdfsdfdsf";die;
// Assuming user is logged in and has a user_id
$user_id = $_SESSION['user_id'] ?? 1; // Replace with session user ID if applicable

// Fetch the total quantity of items in the cart
$cartQuery = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = $user_id";
$res = $conn->query($cartQuery);
$count_row = $res->fetch_assoc();
$cart_count = $count_row['cart_count'] ?? 0; // Default to 0 if no items
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Casa Bella</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="./image/logo.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <style>
    .Image-logo {
        display: flex;
        align-items: center; /* Aligns vertically */
        justify-content: center; /* Centers horizontally */
    }

    .Image-logo img {
        max-height: 60px; /* Adjust based on your logo size */
        width: auto; /* Maintain aspect ratio */
    }
    .logo {
        display: flex;
        align-items: center;
        gap: 10px; /* Adds spacing between the logo and text */
    }

    .logo h1 {
        margin: 0;
        font-size: 24px; /* Adjust as needed */
    }
    .swiper {
        width: 100%;
        height: 650px;
        overflow: hidden;
        position: relative;
    }

    .swiper-wrapper {
        display: flex;
    }

    .swiper-slide {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        min-height: 650px;
    }

    /* Background Blur Effect */
    .swiper-slide::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.3); /* Dark overlay for better contrast */
        backdrop-filter: blur(3px); /* Blur effect */
        z-index: 1;
    }

    /* Slide Images */
    .swiper-slide img {
        width: 100vw;
        height: 100%;
        object-fit: cover;
        position: absolute;
        z-index: 0;
    }

    /* Banner Text */
    .banner-text {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        max-width: 600px;
    }

    .banner-text h1 {
        font-size: 42px;
        font-weight: bold;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    .banner-text p {
        font-size: 18px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
    }

    .banner-text .btn {
        background: #047604;
        color: white;
        padding: 12px 24px;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .banner-text .btn:hover {
        background: rgb(149, 20, 182);
    }

    /* Swiper Navigation and Pagination */
    .swiper-button-next,
    .swiper-button-prev {
        color: white;
    }

    .swiper-pagination-bullet {
        background: white;
        opacity: 0.8;
    }

    .swiper-pagination-bullet-active {
        background: rgb(149, 20, 182);
    }

    header .login-btn {
        background-color: white;
        color:black;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        margin: 7px;
    }

    header .login-btn:hover {
        background-color: #f1f1f1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        nav ul {
            flex-direction: column;
            display: none;
        }

        nav ul.active {
            display: flex;
        }

        .menu-btn {
            display: block;
        }
    }

    @media (min-width: 769px) {
        .menu-btn {
            display: none;
        }
    }

    @media (min-width: 400px) {
        .login-btn {
            background-color: white;
            color: rgb(149, 20, 182);
            border: none;
            padding: 7px 14px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            margin: -13px;
        }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
        <div class="Image-logo">
            <img src="./image/logo.png" alt="Nature Bites Logo">
        </div>
      <!-- <h1>Amami </h1> -->
    </div>
    <!-- <nav> -->
      <ul class="nav-links">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="menu.php" class="nav-link">Menu</a></li>
        <li><a href="about.php" class="nav-link">About Us</a></li>
        <li><a href="gallery.php" class="nav-link">Gallery</a></li>
        <li><a href="contactUs.php" class="nav-link">Contact Us</a></li>
      </ul>
    <!-- </nav> -->
    <div class="actions">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="profile.php"><i class="fas fa-user" title="Profile" style="font-size: 20px; color: black; margin: 3px;"></i></a>
            <a href="mycart.php" class="cart-icon-container">
                <i class="fas fa-shopping-cart" title="Cart" style="font-size: 20px; color: black; margin: 7px;"></i>
                <span id="cart-badge" class="cart-badge" <?php if ($cart_count == 0) echo 'style="display: none;"'; ?>>
                    <?php echo $cart_count; ?>
                </span>
            </a>
            <a href="logout.php" class="login-btn">Logout</a>
            <?php else: ?>
            <a href="#"><i class="fas fa-shopping-cart" title="Cart" style="font-size: 20px; color: black; margin: 7px;"></i></a>
            <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>
    </div>
    <div class="menu-btn">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <script> 
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.querySelector('.menu-btn');
        const navLinks = document.querySelector('.nav-links');
    
        if (menuBtn) {
            menuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
        }
    
        // Highlight Active Nav Link
        const navLinkElements = document.querySelectorAll('.nav-link');
        navLinkElements.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    
        // Category Filtering
        const categoryBtns = document.querySelectorAll('.category-btn');
        const products = document.querySelectorAll('.product');
    
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
    
                const category = this.getAttribute('data-category');
    
                // Show/hide products based on category
                products.forEach(product => {
                    if (category === 'all' || product.getAttribute('data-category') === category) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        });
    });
  </script>

</body>
</html>