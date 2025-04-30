<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trade - Amazing List</title>
  <link rel="stylesheet" href="../CSS/trade.css">
  <script src="../Script/script.js"></script>
</head>
<body>

  <!-- HEADER (Reused) -->
  <header class="site-header">
    <div class="header-wrapper">
      <div class="logo">
        <a href="index.php">Amazing List</a>
      </div>
      <nav id="mainNav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="buypage.php">Buy</a></li>
          <li><a href="tradepage.php">Trade</a></li>
          <li class="dropdown">
            <a href="#">Pages ▾</a>
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
      <button class="add-listing-btn" type="button" onclick="window.location.href='addlisting.php'"> Add Listing</button>
    </div>
  </header>

  <!-- HERO SECTION with image link (Reused) -->
  <section class="hero-section">
    <div class="hero-content">
      <h1>Trade Items</h1>
      <p>Find the best trade deals in town!</p>
    </div>
  </section>

  <!-- SEARCH BAR SECTION (Reused)-->
  <section class="search-bar-section">
    <div class="search-bar-container">
      <input type="text" placeholder="Keywords" aria-label="Keywords">
      <input type="text" placeholder="Location" aria-label="Location">
      <button class="search-btn" type="button">Search</button>
    </div>
  </section>

  <!-- MAIN CONTAINER: FILTER PANEL + LISTINGS -->
  <div class="main-container">
  <aside class="filter-panel">
    <h2>Filters</h2>
    <div class="filter-group">
      <label for="priceMin">Price (min)</label>
      <input type="number" id="priceMin" placeholder="0">
    </div>
    <div class="filter-group">
      <label for="priceMax">Price (max)</label>
      <input type="number" id="priceMax" placeholder="1000">
    </div>
    <div class="filter-group">
      <label for="condition">Condition</label>
      <select id="condition">
        <option value="">Any</option>
        <option value="new">New</option>
        <option value="used">Used</option>
        <option value="poor">Poor</option>
      </select>
    </div>
    <button class="filter-btn" type="button">Apply Filters</button>
  </aside>

  <section class="listings-area">
    <div class="listings-header">
      <span>Showing trade items</span>
      <div class="sort-dropdown">
        <label for="sortBy">Sort by</label>
        <select id="sortBy">
          <option value="date">Date</option>
          <option value="priceLow">Price: Low to High</option>
          <option value="priceHigh">Price: High to Low</option>
        </select>
      </div>
    </div>


    <div class="listing-card">
            <a href="product-details1.html">
              <img src="../Images/Samsung Galaxy 23 Ultra.jpg" alt="Samsung Galaxy S22 Ultra">
              <div class="listing-info">
                <h3>Samsung Galaxy S22 Ultra</h3>
                <p class="listing-location">St Cloud, MN</p>
                <p class="listing-price">$0 (Trade)</p>
              </div>
            </a>
            <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                💬
              </a>
            </div>
          </div>



    <div class="listings-grid">
      <?php include 'fetch-trade-listings.php'; ?>
    </div>
  </section>
</div>

  <!-- Login Modal (initially hidden (Reused)) -->
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

<!-- MESSAGE MODAL -->
<div id="messageModal" class="message-modal-overlay" style="display: none;">
  <div class="modal-content-modern">
    <span class="close-btn" onclick="closeMessageModal()">&times;</span>
    <h2 class="modal-title">Contact Seller</h2>
    <form class="message-form" action="send_message_or_offer.php" method="POST">
      <input type="hidden" name="receiver_id" id="receiverId">
      <input type="hidden" name="item_id" id="itemId">
      <input type="hidden" name="listing_type" id="listingType">

      <textarea class="modal-textarea" name="message_text" placeholder="Write your message here..." required></textarea>

      <div id="offerSection" style="display: none;">
        <h3 class="modal-subtitle">Make an Offer</h3>
        <textarea class="modal-textarea" name="offer_text" placeholder="Describe your trade offer..."></textarea>
        <input type="number" name="offer_amount" class="modal-input" placeholder="Optional Cash Amount ($)">
      </div>

      <button type="submit" class="modal-submit-btn">Send</button>
    </form>
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