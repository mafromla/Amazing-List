<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buy - Amazing List</title>
  <link rel="stylesheet" href="../CSS/buy.css">
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
      <button class="add-listing-btn" type="button" onclick="window.location.href='addlisting.php'"> Add Listing</button>
    </div>
  </header>

  <!-- HERO SECTION with image link -->
  <section class="hero-section">
    <div class="hero-content">
      <h1>For Sale</h1>
      <p>Find the best deals in town!</p>
    </div>
  </section>

  <!-- SEARCH BAR SECTION -->
  <section class="search-bar-section">
    <div class="search-bar-container">
      <input type="text" placeholder="Keywords" aria-label="Keywords">
      <input type="text" placeholder="Location" aria-label="Location">
      <button class="search-btn" type="button">Search</button>
    </div>
  </section>

  <!-- MAIN CONTAINER: FILTER PANEL + LISTINGS -->
  <div class="main-container">
    <!-- FILTER PANEL -->
    <aside class="filter-panel">
      <h2>Filters</h2>

      <!-- Categories Section -->
      <div class="filter-categories">
        <h3>Electronics</h3>
        <ul>
          <li><a href="#">Mobile Phones</a></li>
          <li><a href="#">Laptops &amp; Computers</a></li>
          <li><a href="#">Tablets &amp; iPads</a></li>
          <li><a href="#">Gaming Consoles &amp; Accessories</a></li>
          <li><a href="#">TVs &amp; Home Entertainment</a></li>
          <li><a href="#">Cameras &amp; Photography</a></li>
          <li><a href="#">Wearables &amp; Smartwatches</a></li>
        </ul>
        <h3>Vehicles</h3>
        <ul>
          <li><a href="#">Cars</a></li>
          <li><a href="#">Motorcycles &amp; Scooters</a></li>
          <li><a href="#">Bicycles</a></li>
          <li><a href="#">Trucks &amp; Commercial Vehicles</a></li>
          <li><a href="#">Auto Parts &amp; Accessories</a></li>
        </ul>
        <h3>Home &amp; Furniture</h3>
        <ul>
          <li><a href="#">Sofas &amp; Seating</a></li>
          <li><a href="#">Beds &amp; Mattresses</a></li>
          <li><a href="#">Tables &amp; Chairs</a></li>
          <li><a href="#">Cabinets &amp; Storage</a></li>
          <li><a href="#">Home Decor</a></li>
          <li><a href="#">Kitchen &amp; Dining</a></li>
        </ul>
        <h3>Fashion &amp; Accessories</h3>
        <ul>
          <li><a href="#">Men's Clothing</a></li>
          <li><a href="#">Women's Clothing</a></li>
          <li><a href="#">Shoes</a></li>
          <li><a href="#">Bags &amp; Wallets</a></li>
          <li><a href="#">Jewelry &amp; Watches</a></li>
        </ul>
        <h3>Books, Music &amp; Movies</h3>
        <ul>
          <li><a href="#">Fiction &amp; Non-fiction Books</a></li>
          <li><a href="#">Textbooks &amp; Study Material</a></li>
          <li><a href="#">CDs &amp; Vinyl Records</a></li>
          <li><a href="#">DVDs &amp; Blu-ray</a></li>
        </ul>
        <h3>Sports &amp; Outdoor</h3>
        <ul>
          <li><a href="#">Exercise Equipment</a></li>
          <li><a href="#">Camping &amp; Hiking Gear</a></li>
          <li><a href="#">Sports Apparel &amp; Shoes</a></li>
          <li><a href="#">Bicycles &amp; Accessories</a></li>
        </ul>
        <h3>Other</h3>
        <ul>
          <li><a href="#">Standalone Items</a></li>
        </ul>
      </div>

      <!-- Additional Filters -->
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

    <!-- LISTINGS AREA -->
    <section class="listings-area">
      <!-- Listings Header: Sort & Results Info -->
      <div class="listings-header">
        <span>Showing 1-7 of 20 results</span>
        <div class="sort-dropdown">
          <label for="sortBy">Sort by</label>
          <select id="sortBy" onchange="sortItems()">
            <option value="date">Date</option>
            <option value="priceLow">Price: Low to High</option>
            <option value="priceHigh">Price: High to Low</option>
         </select>

        </div>
      </div>
      <!-- Grid of Listing Cards -->
      <div class="listings-grid">
        <!-- Listing Card 1 -->
        <div class="listing-card">
          <a href="productlisting.html">
            <img src="../Images/Macbook pro.jpg" alt="Apple MacBook Pro 15">
            <div class="listing-info">
              <h3>Apple MacBook Pro 15"</h3>
              <p class="listing-location">Minneapolis, MN</p>
              <p class="listing-price">$1200</p>
            </div>
            <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>
          </a>
        </div>
        <!-- Listing Card 2 -->
        <div class="listing-card">
          <a href="product-details2.html">
            <img src="../Images/Red Rising.jpg" alt="Red Rising">
            <div class="listing-info">
              <h3>Red Rising</h3>
              <p class="listing-location">St Paul, MN</p>
              <p class="listing-price">$10</p>
            </div>
            <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>

          </a>
        </div>

        <div class="listing-card">
            <a href="product-details3.html">
              <img src="../Images/Canon mar ii.jpg" alt="Canon Mark II">
              <div class="listing-info">
                <h3>Canon Mark II</h3>
                <p class="listing-location">Eagan, MN</p>
                <p class="listing-price">$400</p>
              </div>
              <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>
            </a>
          </div>

          <div class="listing-card">
            <a href="product-details4.html">
              <img src="../Images/20241212_121127.jpg" alt="Xbox Controller">
              <div class="listing-info">
                <h3>Xbox Controller</h3>
                <p class="listing-location">Bloomington, MN</p>
                <p class="listing-price">$20</p>
              </div>
              <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>
            </a>
          </div>

          <div class="listing-card">
            <a href="product-details5.html">
              <img src="../Images/Playstation.webp" alt="Playstation 5">
              <div class="listing-info">
                <h3>Playstation 5</h3>
                <p class="listing-location">Bloomington, MN</p>
                <p class="listing-price">$250</p>
              </div>
              <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>
            </a>
          </div>

          <div class="listing-card">
            <a href="product-details6.html">
              <img src="../Images/Mountain Bike.jpg" alt="Mountain Bike">
              <div class="listing-info">
                <h3>Mountain Bike</h3>
                <p class="listing-location">Bloomington, MN</p>
                <p class="listing-price">$400</p>
              </div>
              <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>
            </a>
          </div>

          <div class="listing-card">
            <a href="product-details7.html">
              <img src="../Images/Iphone 15.jpg" alt="iPhone 15">
              <div class="listing-info">
                <h3>iPhone 15</h3>
                <p class="listing-location">Maple Grove, MN</p>
                <p class="listing-price">$700</p>
              </div>
              <div class="listing-actions">
              <form action="favorites.php" method="POST" style="display:inline;">
                  <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                  <button type="submit" class="favorite-btn" title="Add to Favorites">❤️</button>
              </form>
              <a href="message.php?seller_id=<?php echo $row['user_id']; ?>&item_id=<?php echo $row['item_id']; ?>" class="message-btn" title="Message Seller">
                  💬
              </a>
          </div>
            </a>
          </div>
      
    <?php include 'fetch-buy-listings.php'; ?>

      </div>
    </section>
  </div>


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


  <!-- MESSAGE MODAL -->
  <div id="messageModal" class="message-modal-overlay" style="display: none;">
    <div class="message-modal-content">
      <span class="close-btn-message" onclick="closeMessageModal()">&times;</span>
      <h2>Contact Seller</h2>
      <form action="send_message_or_offer.php" method="POST">
        <input type="hidden" name="receiver_id" id="receiverId">
        <input type="hidden" name="item_id" id="itemId">
        <input type="hidden" name="listing_type" id="listingType">

        <textarea name="message_text" placeholder="Write your message here..." required></textarea>

        <div id="offerSection" style="display: none;">
          <h3>Make an Offer</h3>
          <textarea name="offer_text" placeholder="Describe your trade offer..."></textarea>
          <input type="number" name="offer_amount" placeholder="Optional Cash Amount ($)">
        </div>

        <button type="submit">Send</button>
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