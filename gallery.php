<?php 
session_start();
include 'database.php';

// Get all products for the gallery
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Bella - Food Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* Gallery-specific styles */
        :root {
            --primary-color: #d4af37;
            --secondary-color: #333;
            --light-color: #f8f8f8;
            --dark-color: #222;
            --text-color: #555;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .gallery-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .gallery-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .gallery-header h1 {
            font-size: 3rem;
            color: var(--dark-color);
            margin-bottom: 15px;
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .gallery-header p {
            color: var(--text-color);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .gallery-filter {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
        }
        
        .filter-btn {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 25px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary-color);
            color: white;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }
        
        .gallery-item {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
        }
        
        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        
        .gallery-img-container {
            height: 250px;
            overflow: hidden;
            position: relative;
        }
        
        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }
        
        .gallery-item:hover .gallery-img {
            transform: scale(1.1);
        }
        
        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            z-index: 2;
        }
        
        .gallery-info {
            padding: 20px;
        }
        
        .gallery-info h3 {
            margin: 0 0 10px;
            font-size: 1.4rem;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .gallery-info p {
            color: var(--text-color);
            font-size: 0.95rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .gallery-price {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.3rem;
            display: block;
        }
        
        .view-menu-btn {
            display: block;
            text-align: center;
            margin: 50px auto 0;
            background: var(--dark-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            text-decoration: none;
            max-width: 200px;
        }
        
        .view-menu-btn:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }
            
            .gallery-header h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="gallery-container">
        <div class="gallery-header">
            <h1>Our Culinary Gallery</h1>
            <p>Feast your eyes on our exquisite collection of dishes from around the world</p>
        </div>
        
        <div class="gallery-filter">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="Fast Food">Fast Food</button>
            <button class="filter-btn" data-filter="Indian & Chinese">Indian & Chinese</button>
            <button class="filter-btn" data-filter="Korean">Korean</button>
            <button class="filter-btn" data-filter="Desserts">Desserts</button>
        </div>

        <div class="gallery-grid">
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="gallery-item" data-category="<?php echo $row['category']; ?>">
                    <div class="gallery-img-container">
                        <span class="category-badge"><?php echo $row['category']; ?></span>
                        <img src="<?php echo $row['productImage1']; ?>" alt="<?php echo $row['productName']; ?>" class="gallery-img">
                    </div>
                    <div class="gallery-info">
                        <h3><?php echo $row['productName']; ?></h3>
                        <p><?php echo $row['productDescription']; ?></p>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<p style='grid-column:1/-1;text-align:center;'>No products available in our gallery.</p>";
            }
            ?>
        </div>
        
        <a href="menu.php" class="view-menu-btn">View Full Menu</a>
    </div>

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                const items = document.querySelectorAll('.gallery-item');
                
                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <?php include 'footer.php'; ?>

</body>
</html>