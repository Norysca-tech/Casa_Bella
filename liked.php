<?php
session_start();
?>
<?php include 'header.php'; ?>

  <section class="liked-section">
    <h1>Your Liked Products</h1>
    <div class="liked-container">
      <div class="products-container" id="liked-products">
        <!-- Liked products will be dynamically added here -->
        <div class="empty-liked-message" id="empty-liked-message">
          <i class="fas fa-heart"></i>
          <p>You haven't liked any products yet</p>
          <a href="collections.html" class="btn">Explore Collections</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>