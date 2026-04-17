<footer>
    <style> 
        /* General Styles */
        footer {
            background-color: #eeeeee;
            color: black;
            padding: 60px 20px 30px;
            font-family: 'Poppins', sans-serif;
        }

        .footer_main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            gap: 20px;
        }

        .footer_tag {
            flex: 1;
            min-width: 200px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .footer_tag h2 {
            font-size: 1.4rem;
            margin-bottom: 20px;
            color: #ff6f61;
            position: relative;
            padding-bottom: 10px;
        }

        .footer_tag h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: #facc22;
        }

        .footer_tag p {
            margin: 12px 0;
            line-height: 1.7;
            color: #555555;
            font-size: 0.95rem;
        }

        .footer_tag a {
            display: block;
            color: #555555;
            text-decoration: none;
            margin: 12px 0;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .footer_tag a:hover {
            color: #ff6f61;
        }

        .social_icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social_icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #f5f5f5;
            color: #555555;
            border-radius: 50%;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social_icons a:hover {
            background: #facc22;
            color: white;
        }

        .copyright {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.1);
            color: #777777;
            font-size: 0.9rem;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .footer_main {
                flex-direction: column;
                gap: 15px;
            }
            
            .footer_tag {
                width: 100%;
                text-align: center;
            }
            
            .footer_tag h2::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .social_icons {
                justify-content: center;
            }
        }
    </style>
    
    <div class="footer_main">
        <div class="footer_tag">
            <h2>Location</h2>
            <p><i class="fas fa-map-marker-alt"></i> The Casa Bella</p>
            <p>123, Sector 4, MG Road</p>
            <p>Mumbai, Maharashtra</p>
            <p>400067 (India)</p>
        </div>

        <div class="footer_tag">
            <h2>Quick Links</h2>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="About.php"><i class="fas fa-info-circle"></i> About</a>
            <a href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
            <a href="contactUs.php"><i class="fas fa-envelope"></i> Contact Us</a>
        </div>

        <div class="footer_tag">
            <h2>Contact</h2>
            <p><i class="fas fa-phone"></i> +91 8956321023</p>
            <p><i class="fas fa-phone"></i> +91 8956321024</p>
            <p><i class="fas fa-envelope"></i> casabella@gmail.com</p>
            <p><i class="fas fa-clock"></i> Open: 10AM - 11PM</p>
        </div>

        <div class="footer_tag">
            <h2>Our Services</h2>
            <p><i class="fas fa-truck"></i> Fast Delivery</p>
            <p><i class="fas fa-wallet"></i> Easy Payments</p>
            <p><i class="fas fa-headset"></i> 24 x 7 Service</p>
        </div>

        <div class="footer_tag">
            <h2>Follow Us</h2>
            <div class="social_icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
    
    <div class="copyright">
        <p>&copy; 2025 Casa Bella Restaurant. All Rights Reserved.</p>
    </div>
</footer>