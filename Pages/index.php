<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Amazing List - Homepage</title>
  <link rel="stylesheet" href="../CSS/style.css">
  <script src="../Script/script.js"></script>
</head>
<body>

    <header class="site-header">
      <div class="header-wrapper">

        <!-- Logo -->
        <div class="logo">
          <a href="./index.php">Amazing List</a>
        </div>


        <!-- Navigation Links -->
        <nav class="nav-links" id="primaryNav">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="buypage.php">Buy</a></li>
            <li><a href="tradepage.php">Trade</a></li>
            <li class="dropdown">
              <a href="javascript:void(0)">Pages ▾</a>
              <ul class="dropdown-menu">
                <li><a href="my-listings.php">My Listings</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="messages.php">Messages</a></li>
              </ul>
            </li>
          </ul>
        </nav>

        <!-- User Profile Dropdown -->
        <div class="user-profile-dropdown" id="userDropdown">
          <button class="user-btn" type="button" onclick="toggleProfileMenu()">
            <?php if (isset($_SESSION['username'])): ?>
              <?= htmlspecialchars($_SESSION['username']) ?> ▾
            <?php else: ?>
              User ▾
            <?php endif; ?>
          </button>
          <ul class="profile-menu" id="profileMenu">
            <?php if (isset($_SESSION['username'])): ?>
              <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
              <li><a href="javascript:void(0)" onclick="openModal()">Sign In</a></li>
              <li><a href="register.php">Register</a></li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- + Add Listing Button -->
        <a href="addlisting.php" class="add-listing-btn"> Add Listing</a>

      </div>
    </header>

  <!-- Hero/Search Section -->

      <div class="hero-image">
      <div class="hero-text">
        <h1 class="hero-title">Buy. Sell. Trade. All in One Place.</h1>
        <p>Discover great deals, connect with buyers, and trade effortlessly on Amazing List</p>
      </div>
    </div>

  <section class="hero-section">
    <div class="hero-content">
      <h1>Find the best deals and trades</h1>
      <div class="search-bar">
        <input 
          type="text" 
          placeholder="Search items or trades..."
          aria-label="Search items or trades">
        <!-- Category Selector -->
        <select aria-label="Category Selector">
          <option value="buy">Buy</option>
          <option value="trade">Trade</option>
        </select>
        <button class="search-btn" type="button">Search</button>
      </div>
    </div>
  </section>

  <!-- Featured Listings Section -->
  <section class="featured-section">
    <h2>Featured Buy Items</h2>
    <div class="featured-listings">
      <!-- Example listing card -->
      <div class="listing-card">
        <img src="../Images/Playstation.webp" alt="Item 1">
        <h3>Playstation 5</h3>
        <p class="listing-price">$250</p>
        <p class="listing-desc">Lightly used, in great condition.</p>
      </div>
      <div class="listing-card">
        <img src="../Images/Mountain Bike.jpg" alt="Item 2">
        <h3>Mountain Bike</h3>
        <p class="listing-price">$400</p>
        <p class="listing-desc">All terrain bike, perfect for trails.</p>
      </div>
      <!-- Add more cards as needed -->
    </div>

    <h2>Featured Trade Items</h2>
    <div class="featured-listings">
      <!-- Example listing card -->
      <div class="listing-card">
        <img src="../Images/Samsung Galaxy 23 Ultra.jpg" alt="Item 3">
        <h3>Samsung Galaxy S22 Ultra</h3>
        <p class="listing-trade">Looking to trade for a tablet.</p>
        <p class="listing-desc">Pristine condition.</p>
      </div>
      <div class="listing-card">
        <img src="../Images/Electric Guitar.webp" alt="Item 4">
        <h3>Electric Guitar</h3>
        <p class="listing-trade">Trade for acoustic guitar or amplifier.</p>
        <p class="listing-desc">Well-maintained, includes case.</p>
      </div>
      <!-- Add more cards as needed -->
    </div>
  </section>

  <!-- Login Modal (initially hidden) -->
  <div id="loginModal" class="modal-overlay">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2>Sign In</h2>
      <form class="login-form" action="login.php" method="POST">
        <label for="loginEmail">Email</label>
        <input type="email" id="loginEmail" name="email" placeholder="example@email.com" required>
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" name="password" placeholder="********" required>
        <div class="login-options">
          <label class="remember-me">
            <input type="checkbox" name="remember" value="1"> Remember me
          </label>
          <a href="#" class="forgot-link">Forgot Password?</a>
        </div>
        <button type="submit" class="login-submit-btn">Log In</button>
        <p class="signup-prompt">
          Don't have an account? <a href="register.php">Sign Up</a>
        </p>
      </form>
    </div>
  </div>

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