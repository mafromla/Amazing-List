<?php
session_start();
require './connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        u.first_name,
        u.last_name,
        u.username,
        u.email_address,
        u.profile_info,
        u.profile_image_url,
        a.city,
        a.state,
        a.zip_code
    FROM User u
    LEFT JOIN Address a ON u.user_id = a.user_id
    WHERE u.user_id = :user_id
");
$stmt->execute(['user_id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Amazing List</title>
  <link rel="stylesheet" href="../CSS/profile.css">
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
        <li><a href="favorites.php">Favorites</a></li>
        <li class="active"><a href="#">My Profile</a></li>
        <li><a href="logout.php">Sign Out</a></li>
      </ul>
    </div>

    <!-- Profile Form -->
    <div class="profile-section">
      <h2>My Profile</h2>
      <?php if (isset($_GET['updated'])): ?>
		  <p style="color: green; margin-top: 10px;">✅ Profile updated successfully.</p>
			<?php endif; ?>

      <form class="profile-form" action="update-profile.php" method="POST" enctype="multipart/form-data">
        <!-- Profile Image -->
        <label>Profile Image (optional)</label>
        <?php if (!empty($user['profile_image_url'])): ?>
          <img src="<?= htmlspecialchars($user['profile_image_url']) ?>" alt="Profile Picture" style="width: 80px; height: 80px; border-radius: 50px; margin-bottom: 10px;">
        <?php endif; ?>
        <input type="file" name="profile_image">
        
        <label>Username</label>
				<input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>


        <!-- First/Last Name -->
        <label>First Name (optional)</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">

        <label>Last Name (optional)</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">

        <!-- Profile Info -->
        <label>Profile Info (optional)</label>
        <textarea name="profile_info"><?= htmlspecialchars($user['profile_info']) ?></textarea>

        <!-- Email -->
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email_address']) ?>" required>

        <!-- Password fields -->
        <label>New Password (optional)</label>
        <input type="password" name="new_password">

        <label>Current Password (optional)</label>
        <input type="password" name="current_password">

        <button type="submit" class="save-btn">Save Changes</button>
        <a class="view-profile" href="profile.php">👁️ View Profile</a>
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