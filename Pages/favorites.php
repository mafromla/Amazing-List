<?php
require './connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch favorited items for this user
$stmt = $pdo->prepare("
    SELECT Item.item_id, Item.title, Item.price, Item.image_url
    FROM Favorites
    JOIN Item ON Favorites.item_id = Item.item_id
    WHERE Favorites.user_id = :user_id
");
$stmt->execute(['user_id' => $userId]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Favorites - Amazing List</title>
  <link rel="stylesheet" href="../CSS/profile.css">
  <link rel="stylesheet" href="../CSS/favorites.css">

</head>
<body>
<header class="site-header">
      <div class="header-wrapper">

        <!-- Logo -->
        <div class="logo">
          <a href="./index.html">Amazing List</a>
        </div>


        <!-- Navigation Links -->
        <nav class="nav-links" id="primaryNav">
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="buypage.php">Buy</a></li>
            <li><a href="tradepage.php">Trade</a></li>
            <li class="dropdown">
              <a href="javascript:void(0)">Pages ▾</a>
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
        <button class="add-listing-btn" type="button">+ Add Listing</button>

      </div>
    </header>

<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <ul>
      <li class="active"><a href="favorites.php">Favorites</a></li>
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="logout.php">Sign Out</a></li>
    </ul>
  </div>

  <!-- Favorites Section -->
  <div class="listings-grid">
    <?php foreach ($favorites as $item): ?>
      <div class="listing-card">
        <a href="productlisting.php?id=<?= htmlspecialchars($item['item_id']) ?>">
          <img src="../<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
          <div class="listing-info">
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p class="listing-price">$<?= htmlspecialchars($item['price']) ?></p>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>


    <!-- FOOTER (Reused) -->
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