<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require './connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Listing - Amazing List</title>
  <link rel="stylesheet" href="../CSS/style.css"> 
  <link rel="stylesheet" href="../CSS/addlisting.css">
</head>
<body>

<header class="site-header">
  <div class="header-wrapper">
    <div class="logo"><a href="index.html">Amazing List</a></div>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="buypage.php">Buy</a></li>
        <li><a href="tradepage.php">Trade</a></li>
        <li class="dropdown">
          <a href="#">Pages ▾</a>
          <ul class="dropdown-menu">
            <li><a href="my-listings.php">My Listings</a></li>
            <li><a href="favorites.php">Favorites</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="profile.php">Profile</a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <button class="add-listing-btn" type="button" onclick="window.location.href='new-listing.php'">+ New Listing</button>
  </div>
</header>

<main class="add-listing-page">
  <form action="process-listing.php" method="POST" enctype="multipart/form-data" class="add-listing-form">
    <h1>Add Listing</h1>

<!-- Replace the entire category section with this -->
<label for="category_id">Category</label>
<select name="category_id" id="category_id" required>
  <option value="">— Select Category —</option>
  <?php
  // Fetch grouped categories (parent > child)
  $stmt = $pdo->query("
    SELECT 
      p.category_name AS parent_name,
      c.category_id AS child_id,
      c.category_name AS child_name
    FROM Categories c
    LEFT JOIN Categories p ON c.parent_id = p.category_id
    WHERE c.parent_id IS NOT NULL
    ORDER BY p.category_name, c.category_name
  ");
  
  $grouped = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $grouped[$row['parent_name']][] = $row;
  }

  foreach ($grouped as $parent => $subcategories) {
    echo '<optgroup label="' . htmlspecialchars($parent) . '">';
    foreach ($subcategories as $sub) {
      echo '<option value="' . $sub['child_id'] . '">' 
           . htmlspecialchars($sub['child_name']) . '</option>';
    }
    echo '</optgroup>';
  }
  ?>
</select>



    <!-- Title -->
    <label for="title">Title</label>
    <input type="text" name="title" id="title" maxlength="255" required>

    <!-- Description -->
    <label for="description">Description</label>
    <textarea name="description" id="description" maxlength="1000" required></textarea>

    <!-- Condition -->
    <label for="condition">Condition</label>
    <select name="condition" id="condition" required>
      <option value="New">New</option>
      <option value="Like New">Like New</option>
      <option value="Used">Used</option>
      <option value="Damaged">Damaged</option>
    </select>

    <!-- Listing Type -->
    <label for="listing_type">Listing Type</label>
    <select name="listing_type" id="listing_type" required>
      <option value="BUY">Buy</option>
      <option value="TRADE">Trade</option>
    </select>

    <!-- Price -->
    <label for="price">Price (Only if Buy)</label>
    <input type="number" name="price" id="price" step="0.01" min="0">

    <!-- Image -->
    <label for="listing_image">Image (optional)</label>
    <input type="file" name="listing_image" id="listing_image">

    <!-- Submit Button -->
    <button type="submit" class="add-listing-btn-submit">Submit Listing</button>
  </form>
</main>

<footer class="site-footer">
  <div class="footer-content">
    <div class="footer-logo"><h2>Amazing List</h2></div>
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
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 Amazing List. All rights reserved.</p>
  </div>
</footer>

</body>
</html>