<?php
session_start();
?>

<?php include 'header.php';  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
    <link rel="stylesheet" href="./css/about.css">
    <link rel="logo" href="image/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <!-- Nav Bar -->
    

     <!-- Banner -->
     <div class="banner_bg">
        <h1>About <span> Us</span></h1>
     </div>

     <!-- About -->

     <div class="about">
        <div class="about_main">
            <div class="about_image">
                <img src="image/about.png">
            </div>
            <div class="about_text">
                
                <h3>Why food choose us?</h3>
                <p>Welcome to Casa Bella Restaurant, where the love of food and 
                   family comes together. Our story began with a passion for sharing 
                   the flavors and traditions of India and China with our community. 
                   With years of experience in the culinary industry, our chefs and 
                   owners set out to craft a menu that blends the bold spices of India
                   with the delicate nuances of Chinese cuisine. From our slow-cooked 
                   curries to our hand-crafted noodles, every dish is made with love and care.
                </p>
                <div class="about_services">
                    <div class="s_1">
                        <i class="fa-solid fa-truck-fast"></i>
                        <h6>Fast Delivery</h6>
                    </div>
    
                    <div class="s_1">
                        <i class="fa-brands fa-amazon-pay"></i>
                        <h6>Easy Payment</h6>
                    </div>
    
                    <div class="s_1">
                        <i class="fa-solid fa-headset"></i>
                        <h6>24 x 7 Services</h6>
                    </div>
                </div>
    
            </div>
    
        </div>
    
    </div>

    <!-- Footer -->

    <?php include 'footer.php';  ?>
</body>
</html>

    

   


