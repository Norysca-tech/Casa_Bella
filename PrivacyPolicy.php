<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Policy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            height: 50px;
            margin-right: 10px;
        }


        /* Main Content Styles */
        main {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            padding-top: 120px; /* Adjusted for fixed header */
        }

        /* Styling for Section Containers */
        .content-container {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: center;
            }

            .logo-container {
                margin-bottom: 10px;
            }

            nav {
                text-align: center;
            }

            nav a {
                margin: 5px;
                display: inline-block;
            }

            main {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <div class="content-container">
            <section id="commitment">
                <h2>Our Commitment to Privacy</h2>
                <p>We are dedicated to protecting your personal information and ensuring its security. This policy explains how we collect, use, and safeguard your data.</p>
            </section>
        </div>

        <div class="content-container">
            <section id="why-collect">
                <h2>Why We Collect Your Information</h2>
                <ul>
                    <li>To process and fulfill your orders.</li>
                    <li>To improve our services and provide you with the best experience.</li>
                </ul>
            </section>
        </div>

        <div class="content-container">
            <section id="information">
                <h2>Information We Collect</h2>
                <p>The types of personal information we collect include:</p>
                <ul>
                    <li>Your Name</li>
                    <li>Address</li>
                    <li>Phone Number</li>
                    <li>Email Address</li>
                </ul>
            </section>
        </div>

        <div class="content-container">
            <section id="rights">
                <h2>Your Data Rights</h2>
                <ul>
                    <li><strong>Access & Correction:</strong> You can request to view or correct your data by emailing us.</li>
                    <li><strong>Data Deletion:</strong> To delete your data, go to the "Account" section and select "Delete Account."</li>
                </ul>
            </section>
        </div>

        <div class="content-container">
            <section id="security">
                <h2>Data Security</h2>
                <p>We use secure systems and technology to protect your data from unauthorized access, alteration, or disclosure.</p>
            </section>
        </div>

        <div class="content-container">
            <section id="contact">
                <h2>Contact Us</h2>
                <p><strong>Email:</strong> <a href="mailto:NatureBites11@gmail.com">NatureBites11@gmail.com</a></p>
                <p>Phone: +91 8767944421 / +91 8767922297</p>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>  
</body>
</html>
