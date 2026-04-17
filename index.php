<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Bella website</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="logo" href="/image/logo.png">
    <style>
            /* Custom scrollbar for horizontal scrolling */
            .menu .menu_box,
            .cust .cust_box {
                scrollbar-width: thin;
                scrollbar-color: #facc22 transparent;
            }

            .menu .menu_box::-webkit-scrollbar,
            .cust .cust_box::-webkit-scrollbar {
                height: 6px;
            }

            .menu .menu_box::-webkit-scrollbar-track,
            .cust .cust_box::-webkit-scrollbar-track {
                background: transparent;
            }

            .menu .menu_box::-webkit-scrollbar-thumb,
            .cust .cust_box::-webkit-scrollbar-thumb {
                background-color: #facc22;
                border-radius: 6px;
            }

            /* Active state for dragging */
            .menu .menu_box.active,
            .cust .cust_box.active {
                cursor: grabbing;
                cursor: -webkit-grabbing;
            }

            /* Home Section Responsive Fixes */
            #Home {
                padding: 40px 5%;
            }
            
            #Home .main {
                display: flex;
                flex-direction: column;
                gap: 30px;
                align-items: center;
            }
            
            #Home .main_text {
                width: 100%;
            }
            
            #Home .main_text h1 {
                font-size: 2rem;
                line-height: 1.3;
                margin-bottom: 15px;
            }
            
            #Home .main_text p {
                font-size: 1rem;
                line-height: 1.6;
                margin-bottom: 20px;
                max-width: 100%;
            }
            
            #Home .main_image {
                width: 100%;
                max-width: 500px;
            }
            
            #Home .main_image img {
                width: 100%;
                height: auto;
                border-radius: 10px;
            }
            
            /* About Section Responsive Fixes */
            .about {
                padding: 40px 5%;
            }
            
            .about_main {
                margin-top: 140px;
                display: flex;
                flex-direction: column;
                gap: 30px;
                align-items: center;
            }
            
            .about_image {
                width: 100%;
                max-width: 500px;
            }
            
            .about_image img {
                width: 100%;
                height: auto;
                border-radius: 10px;
            }
            
            .about_text {
                width: 100%;
            }
            
            .about_text h1 {
                font-size: 1.8rem;
                margin-bottom: 15px;
            }
            
            .about_text h3 {
                font-size: 1.3rem;
                margin-bottom: 15px;
            }
            
            .about_text p {
                font-size: 1rem;
                line-height: 1.6;
                margin-bottom: 20px;
                max-width: 100%;
            }
            
            .about_services {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
            }
            
            .about_services .s_1 {
                flex: 1 1 150px;
                text-align: center;
                padding: 15px;
                background: #f8f8f8;
                border-radius: 8px;
            }

            /* Menu Section Responsive Fixes */
            .menu {
                padding: 40px 5%;
            }
            
            .menu h1 {
                margin-bottom: 30px;
            }
            
            .menu_box {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 30px;
                padding-bottom: 20px;
            }
            
            .menu_card {
                background: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                transition: transform 0.3s;
            }
            
            .menu_card:hover {
                transform: translateY(-5px);
            }
            
            .menu_img {
                height: 200px;
                overflow: hidden;
            }
            
            .menu_img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s;
            }
            
            .menu_card:hover .menu_img img {
                transform: scale(1.05);
            }
            
            .menu_text {
                padding: 20px;
            }
            
            .menu_text h2 {
                margin-bottom: 10px;
                font-size: 1.3rem;
            }
            
            .menu_text p {
                margin-bottom: 15px;
                font-size: 0.9rem;
                color: #555;
            }
            
            .price {
                font-weight: bold;
                color: #d4af37;
                font-size: 1.2rem;
            }
            
            .menu_view_all {
                text-align: center;
                margin-top: 30px;
            }
            
            .view_all_btn {
                display: inline-block;
                padding: 10px 30px;
                background: #333;
                color: white;
                border-radius: 30px;
                transition: all 0.3s;
            }
            
            .view_all_btn:hover {
                background: #d4af37;
                transform: translateY(-3px);
            }
            
            /* Responsive additions for menu and reviews */
            @media (min-width: 768px) {
                /* Home Section */
                #Home .main {
                    flex-direction: row;
                    text-align: left;
                }
                
                #Home .main_text {
                    order: 1;
                    margin-top: 0;
                    padding-right: 30px;
                }
                
                #Home .main_image {
                    order: 2;
                    margin-bottom: 0;
                }
                
                #Home .main_text h1 {
                    font-size: 2.5rem;
                }
                
                #Home .main_text p {
                    font-size: 1rem;
                }
                
                /* About Section */
                .about_main {
                    flex-direction: row;
                }
                
                .about_text {
                    text-align: left;
                    padding-left: 150px;
                }
                
                .about_services .s_1 {
                    flex: 0 0 auto;
                    margin-bottom: 0;
                }
            }
            
            @media (min-width: 992px) {
                #Home .main_text h1 {
                    font-size: 3rem;
                }
                
                #Home .main_text p {
                    font-size: 1.1rem;
                }
                
                .about_text h1 {
                    font-size: 2.2rem;
                }
            }

            @media (max-width: 992px) {
                .menu .menu_box {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                }
                .cust .cust_box {
                    display: flex;
                    overflow-x: auto;
                    scroll-snap-type: x mandatory;
                    -webkit-overflow-scrolling: touch;
                    grid-template-columns: unset;
                    padding-bottom: 20px;
                    margin-top: 161px;
                }
                .cust .cust_box .cust_card {
                    flex: 0 0 80%;
                    scroll-snap-align: start;
                    margin: 0 10px;
                }
                .cust .cust_1, 
                .cust .cust_2 {
                    display: none;
                }
            }

            @media (max-width: 768px) {
                .menu {
                    height: auto;
                    padding: 50px 0;
                }
                .menu .menu_box {
                    display: flex;
                    overflow-x: auto;
                    scroll-snap-type: x mandatory;
                    -webkit-overflow-scrolling: touch;
                    grid-template-columns: unset;
                    padding-bottom: 20px;
                }
                .menu .menu_box .menu_card {
                    flex: 0 0 85%;
                    scroll-snap-align: start;
                    margin: 0 10px;
                    height: auto;
                    padding: 20px;
                }
                .menu .menu_box .menu_card .menu_img {
                    width: 100%;
                    height: 200px;
                }
                .menu .menu_box .menu_card .menu_text p {
                    width: 100%;
                    padding: 0;
                }
                .menu_view_all {
                    text-align: center;
                    margin: 20px 0;
                }
                
                .cust .cust_box .cust_card {
                    height: 380px;
                }
            }

            @media (max-width: 480px) {
                .menu .menu_box .menu_card .menu_text h2 {
                    font-size: 24px;
                }
                .menu .menu_box .menu_card {
                    flex: 0 0 90%;
                }
                .cust .cust_box .cust_card {
                    flex: 0 0 90%;
                    height: 350px;
                }
                .cust .cust_box .cust_card .cust_img img {
                    width: 120px;
                    height: 120px;
                }
            }

            
    </style>
</head>
<body>

    <?php include 'header.php'; ?>
    
    <!-- Home Section -->
    <section id="Home">
        <div class="main anim">
            <div class="main_text">
                <h1>Get Fresh<span> Food</span><br>in a Easy Way</h1>
                <p>
                    Enjoy delicious food at our restaurant! Our menu features a variety of tasty options,
                    from classic indian to Chinese. We use indian spices and cook with love. Come visit our site 
                    for breakfast, lunch, or dinner - there's something for everyone!Embark on a gastronomic adventure
                    with us! Our menu is carefully curated to provide a flavorful experience that will transport your taste 
                    buds to new heights. Whether you're in the mood for something spicy, sweet, or savory, we've got you covered.
                </p>
            </div>

            <div class="main_image">
                <img src="image/main_img.png">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <div class="about">
        <div class="about_main">
            <div class="about_image">
                <img src="image/about.png">
            </div>
            <div class="about_text">
                <h1><span>About</span>Us</h1>
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
                        <i class="fa-solid fa-headset"></i>
                        <h6>24 x 7 Services</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Section (made responsive) -->
    <div class="menu">
        <h1>Our<span> Menu</span></h1>
        <div class="menu_box">
            <div class="menu_card">
                <div class="menu_img">
                    <img src="image/menu_1.jpg">
                </div>
                <div class="menu_text">
                    <h2>Spicy Chicken Burger</h2>
                    <p>Indulge in a burger made with a spicy and crispy 
                       Chicken Patty, Chipotle Sauce, Tomatos & Lettuce.
                    </p>
                    <p class="price">₹199<sub><del>₹230</del></sub></p>
                </div>
            </div>
            
            <div class="menu_card">
                <div class="menu_img">
                    <img src="image/chilli chic.jpg">
                </div>
                <div class="menu_text">
                    <h2>Chilli Chicken</h2>
                    <p>
                        Spice, sizzle, repeat: the 
                        irresistible charm of chili chicken!
                    </p>
                    <p class="price">₹250<sub><del>₹299</del></sub></p>
                </div>
            </div>
            
            <div class="menu_card">
                <div class="menu_img">
                    <img src="image/menu_21.jpg">
                </div>
                <div class="menu_text">
                    <h2>Pancake</h2>
                    <p>
                        Golden brown, fluffy, and drizzled 
                        with love. Sweet Bliss!!
                    </p>
                    <p class="price">₹99<sub><del>₹120</del></sub></p>
                </div>
            </div>
        </div>
        <div class="menu_view_all">
            <a href="menu.php" class="view_all_btn">View All</a>
        </div>
    </div>

    <!-- Banner (unchanged) -->
    <div class="banner">
        <h1> Special offer</h1>
        <div class="banner_center">
            <h2>50%<br><span> Off</span></h2>
        </div>
    </div>

    <div class="gallery" id="gallery">
        <h1>Popular<span> Gallery</span></h1>
        <div class="gallery_box" id="slider">
            <div class="gallery_image"><img src="image/chilli chic.jpg" /></div>
            <div class="gallery_image"><img src="image/gallary_2.jpg" /></div>
            <div class="gallery_image"><img src="image/gallary_3.webp" /></div>
            <div class="gallery_image"><img src="image/menu_21.jpg" /></div>
            <div class="gallery_image"><img src="image/menu_22.jpg" /></div>
            <div class="gallery_image"><img src="image/fluffPancake.jpeg" /></div>
            <div class="gallery_image"><img src="image/burger2.jpeg" /></div>
            <div class="gallery_image"><img src="image/chilliPaneer.jpeg" /></div>
            <div class="gallery_image"><img src="image/biryani.jpeg" /></div>
            <div class="gallery_image"><img src="image/croissant.jpeg" /></div>
            <div class="gallery_image"><img src="image/fishCakeSoup.jpeg" /></div>
            <div class="gallery_image"><img src="image/gallery_15.webp" /></div>
            <div class="gallery_image"><img src="image/Gyeran Mari(egg).jpeg" /></div>
            <div class="gallery_image"><img src="image/kfc.jpeg" /></div>
            <div class="gallery_image"><img src="image/kimchi.jpg" /></div>
            <div class="gallery_image"><img src="image/kimchiBokkeumpbap.jpeg" /></div>
            <div class="gallery_image"><img src="image/kimchiJjigae.jpeg" /></div>
        </div>
    </div>

    <script>
        const slider = document.getElementById('slider');
        let isDragging = false;
        let startX;
        let scrollLeft;

        // Handle drag start
        slider.addEventListener('mousedown', (e) => {
            isDragging = true;
            slider.classList.add('dragging');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        // Handle dragging
        slider.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Adjust scroll speed
            slider.scrollLeft = scrollLeft - walk;
        });

        // Handle drag end
        slider.addEventListener('mouseup', () => {
            isDragging = false;
            slider.classList.remove('dragging');
        });

        slider.addEventListener('mouseleave', () => {
            isDragging = false;
            slider.classList.remove('dragging');
        });

        // Infinite slider
        let cloneImages = [...slider.children];
        cloneImages.forEach((item) => slider.appendChild(item.cloneNode(true)));

        function autoSlide() {
            if (!isDragging) {
                slider.scrollLeft += 1; // Adjust speed
                if (slider.scrollLeft >= slider.scrollWidth / 2) {
                    slider.scrollLeft = 0; // Loop back
                }
            }
            requestAnimationFrame(autoSlide);
        }

        autoSlide();
    </script>

    <!-- Customer Reviews (made responsive) -->
    <div class="cust">
        <h1>Customer<span> Reviews</span></h1>
        
        <div class="cust_1"></div>
        <div class="cust_2"></div>
        
        <div class="cust_box">
            <div class="cust_card">
                <div class="cust_img">
                    <img src="image/follow_5.jpg">
                </div>
                <div class="cust_tag">
                    <h2>Sofia Miller</h2>
                    <p class="info">
                        Amazing flavors and generous portions!
                        Wow, the spices are just right! Their 
                        food is so flavorful and aromatic.
                    </p>
                </div>
                <div class="stars">★★★★</div>
            </div>

            <div class="cust_card">
                <div class="cust_img">
                    <img src="image/follow_10.jpg">
                </div>
                <div class="cust_tag">
                    <h2>Michael John</h2>
                    <p class="info">
                        My go-to for a quick and delicious meal!
                        Their food never disappoints. Ordered online 
                        and was impressed with the easy process and 
                        delicious food!
                    </p>
                </div>
                <div class="stars">★★★★★</div>
            </div>

            <div class="cust_card">
                <div class="cust_img">
                    <img src="image/follow_6.jpg">
                </div>
                <div class="cust_tag">
                    <h2>Andrew lopez</h2>
                    <p class="info">
                        I was blown away by the incredible flavors and 
                        generous portions, can't wait to order back!
                        Best food I've had in a long time!
                    </p>
                </div>
                <div class="stars">★★★★</div>
            </div>

            <div class="cust_card">
                <div class="cust_img">
                    <img src="image/follow_2.png">
                </div>
                <div class="cust_tag">
                    <h2>Lexi Rivera</h2>
                    <p class="info">
                        Authentic Chinese flavors and friendly 
                        service! Feels like a home-cooked meal.
                        Flavors were amazing, highly recommended!
                    </p>
                </div>
                <div class="stars">★★★★★</div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
    
    <script>
        // Improved slider functionality for menu and reviews
        document.addEventListener('DOMContentLoaded', function() {
            // Menu slider touch events
            const menuBox = document.querySelector('.menu .menu_box');
            if (menuBox) {
                setupHorizontalScroll(menuBox);
            }
            
            // Reviews slider touch events
            const custBox = document.querySelector('.cust .cust_box');
            if (custBox) {
                setupHorizontalScroll(custBox);
            }
            
            function setupHorizontalScroll(element) {
                let isDown = false;
                let startX;
                let scrollLeft;

                element.addEventListener('mousedown', (e) => {
                    isDown = true;
                    element.classList.add('active');
                    startX = e.pageX - element.offsetLeft;
                    scrollLeft = element.scrollLeft;
                });

                element.addEventListener('mouseleave', () => {
                    isDown = false;
                    element.classList.remove('active');
                });

                element.addEventListener('mouseup', () => {
                    isDown = false;
                    element.classList.remove('active');
                });

                element.addEventListener('mousemove', (e) => {
                    if(!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - element.offsetLeft;
                    const walk = (x - startX) * 2;
                    element.scrollLeft = scrollLeft - walk;
                });

                // Touch events for mobile
                element.addEventListener('touchstart', (e) => {
                    isDown = true;
                    startX = e.touches[0].pageX - element.offsetLeft;
                    scrollLeft = element.scrollLeft;
                });

                element.addEventListener('touchend', () => {
                    isDown = false;
                });

                element.addEventListener('touchmove', (e) => {
                    if(!isDown) return;
                    e.preventDefault();
                    const x = e.touches[0].pageX - element.offsetLeft;
                    const walk = (x - startX) * 2;
                    element.scrollLeft = scrollLeft - walk;
                });
            }
        });
    </script>
    
</body>
</html>