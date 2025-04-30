<?php
include 'connect.php';

// Check if an ID was passed
if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit;
}

$item_id = intval($_GET['id']);

// Fetch item details from the database
$sql = "
    SELECT Item.*, User.username 
    FROM Item 
    JOIN User ON Item.user_id = User.user_id 
    WHERE Item.item_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Item not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details - Amazing List</title>
  <link rel="stylesheet" href="../css/productlisting.css">
  <script src="../Script/script.js"></script>
</head>
<body>

  <!-- HEADER (Reused) -->
  <header class="site-header">
    <div class="header-wrapper">
      <div class="logo">
        <a href="index.html">Amazing List</a>
      </div>
      <nav id="mainNav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="buypage.php">Buy</a></li>
          <li><a href="tradepage.php">Trade</a></li>
          <li class="dropdown">
            <a href="javascript:void(0)" onclick="toggleDropdownMenu()">Pages ▾</a>
            <ul class="dropdown-menu">
              <li><a href="my-listings.html">My Listings</a></li>
              <li><a href="profile.php">Profile</a></li>
              <li><a href="favorites.php">Favorites</a></li>
              <li><a href="messages.php">Messages</a></li>
            </ul>
          </li>
        </ul>
      </nav>

      <!-- User Profile Dropdown -->
      <div class="user-profile-dropdown" id="userDropdown">
        <button class="user-btn" type="button" onclick="toggleProfileMenu()">User ▾</button>
        <ul class="profile-menu" id="profileMenu">
          <li><a href="javascript:void(0)" onclick="openModal()">Sign In</a></li>
          <li><a href="register.php">Register</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>

      <!-- + Add Listing Button -->
      <button class="add-listing-btn" type="button" onclick="window.location.href='addlisting.php'"> Add Listing</button>
    </div>
  </header>

<!-- Begin Product Details Content -->
<div class="product-details">

  <!-- Gallery Section -->
  <div class="product-gallery">
    <!-- Main Image -->
    <img src="<?php echo '../' . htmlspecialchars($item['image_url']); ?>" alt="Main Product Image" class="main-image">


    <!-- Thumbnail Images (repeating main image for now) -->
    <div class="thumbnail-images">
        <img src="<?php echo '../' . htmlspecialchars($item['image_url']); ?>" alt="Thumbnail 1">
        <img src="<?php echo '../' . htmlspecialchars($item['image_url']); ?>" alt="Thumbnail 2">
        <img src="<?php echo '../' . htmlspecialchars($item['image_url']); ?>" alt="Thumbnail 3">
        <img src="<?php echo '../' . htmlspecialchars($item['image_url']); ?>" alt="Thumbnail 4">
    </div>


  <!-- Product Info Section -->
  <div class="product-info">
    <h1 class="product-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <p class="product-price">$<?php echo htmlspecialchars($item['price']); ?></p>
    <ul class="product-specs">
      <li>Condition: <?php echo htmlspecialchars($item['condition']); ?></li>
    </ul>
    <p class="seller-info">
        Seller: <a href="#"><?php echo htmlspecialchars($item['username']); ?></a>
    </p>

    <p class="product-description">
      <?php echo nl2br(htmlspecialchars($item['description'])); ?>
    </p>
  </div>

  <!-- Reviews & Ratings Section (static for now) -->
  <div class="reviews-section">
    <!-- Average Rating -->
    <div class="average-rating">
      Average Rating: 4.5 ★ (2 reviews)
    </div>

    <!-- List of Reviews -->
    <div class="reviews-list">
      <div class="review">
        <div class="review-header">
          <span>Jason Asano - 01/17/2025</span>
          <span>★★★★★</span>
        </div>
        <div class="review-body">
          I got a great deal on a barely-used Tablet from this seller, super happy with my purchase!
        </div>
      </div>
      <div class="review">
        <div class="review-header">
          <span>Tim Hinton - 2/08/2025</span>
          <span>★★★★☆</span>
        </div>
        <div class="review-body">
          Sold me a good phone but was hard to get in contact with.
        </div>
      </div>
    </div>

    <!-- Add a Review Form -->
    <div class="review-form">
      <h3>Write a Review</h3>
      <form action="#" method="POST">
        <textarea name="review" placeholder="Write your review here..." required></textarea>
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
        <button type="submit">Submit Review</button>
      </form>
    </div>
  </div>

</div>

<!-- FOOTER (copied from template) -->
<footer class="site-footer">
    <div class="footer-content">
      <div class="footer-logo">
        <h2>Amazing List</h2>
      </div>
      <div class="footer-links">
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>
      <div class="footer-social">
        <p>Follow us:</p>
        <ul class="social-links">
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">LinkedIn</a></li>
        </ul>
      </div>
      <div class="footer-newsletter">
        <p>Subscribe to our newsletter:</p>
        <form action="#" method="POST">
          <input type="email" name="email" placeholder="Enter your email" required>
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Amazing List. All rights reserved.</p>
    </div>
  </footer>


</body>
</html>
