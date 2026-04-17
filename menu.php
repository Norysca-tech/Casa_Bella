<?php 
session_start();
include 'database.php';
$isLoggedIn = isset($_SESSION['user_id']); 

// Function to get unique categories from the database
function getCategories($conn) {
    $query = "SELECT DISTINCT category FROM products";
    $result = mysqli_query($conn, $query);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }
    return $categories;
}

// Function to fetch products based on category
function getProductsByCategory($conn, $category) {
    $query = "SELECT * FROM products WHERE category = '$category'";
    return mysqli_query($conn, $query);
}

$categories = getCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Bella Menu</title>
    <link rel="stylesheet" href="./css/menuEx2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="./css/menu.js"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <?php foreach ($categories as $categoryName) { 
        $result = getProductsByCategory($conn, $categoryName);
    ?>
        <div id="<?php echo strtolower(str_replace(' ', '-', $categoryName)); ?>" class="menu-section">
            <h2><?php echo $categoryName; ?></h2>
            <p>Delicious <?php echo $categoryName; ?> items.</p>
            <div class="menu">
                <div class="menu_box anim">
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="menu_card">
                            <div class="menu_img">
                                <img src="<?php echo $row['productImage1']; ?>" alt="<?php echo $row['productName']; ?>">
                            </div>
                            <div class="menu_text">
                                <h2><?php echo $row['productName']; ?></h2>
                                <p><?php echo $row['productDescription']; ?></p>
                                <p class="price">₹<?php echo $row['productPrice']; ?> <sub><del>₹<?php echo $row['productPriceBeforeDiscount']; ?></del></sub></p>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $row['productName']; ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $row['productPrice']; ?>">
                                    <span class="menu_btn">Qnt 1</span>
                                    <button type="submit" class="menu_btn" <?php if (!$isLoggedIn) echo 'disabled'; ?>>
                                        <?php echo $isLoggedIn ? 'Add to Cart' : 'Login to Add'; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php 
                        }
                    } else {
                        echo "<p>No products available in this category.</p>";
                    }
                    ?>
                </div>
            </div>    
        </div>
    <?php } ?>

    <!-- Category Navigation -->
    <div class="menu-nav">
        <?php foreach ($categories as $categoryName) { ?>
            <button onclick="scrollToSection('<?php echo strtolower(str_replace(' ', '-', $categoryName)); ?>')">
                <?php echo $categoryName; ?>
            </button>
        <?php } ?>
    </div>

    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>

    <?php include 'footer.php'; ?>

</body>
</html>
