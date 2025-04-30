<?php
require 'connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch messages where user is sender or receiver
$stmt = $pdo->prepare("
SELECT 
  m.*, 
  u1.username AS sender_name, 
  u2.username AS receiver_name, 
  i.title AS item_title,
  o.offer_id IS NOT NULL AS is_offer
FROM Messages m
JOIN User u1 ON m.sender_id = u1.user_id
JOIN User u2 ON m.receiver_id = u2.user_id
LEFT JOIN Item i ON m.item_id = i.item_id
LEFT JOIN Offer_Items oi ON oi.item_id = m.item_id
LEFT JOIN Offer o ON o.offer_id = oi.offer_id AND o.sender_id = m.sender_id
WHERE m.sender_id = :uid OR m.receiver_id = :uid
GROUP BY m.message_id
ORDER BY m.sent_at DESC;

");
$stmt->execute(['uid' => $user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Favorites - Amazing List</title>
  <link rel="stylesheet" href="../CSS/universal-style.css">
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

    <div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <ul>
      <li><a href="favorites.php">Favorites</a></li>
      <li><a href="profile.php">My Profile</a></li>
      <li class="active"><a href="messages.php">Messages</a></li>
      <li><a href="logout.php">Sign Out</a></li>
    </ul>
  </div>

  <!-- Messages Area -->
<!-- Messages Area -->
<div class="messages-section">
  <h2>Messages</h2>

  <?php if (empty($messages)): ?>
    <p>No messages yet.</p>
  <?php else: ?>
    <?php foreach ($messages as $msg): ?>
      <div class="message-card <?= $msg['is_offer'] ? 'offer-highlight' : '' ?>">
        <div class="message-left">
          <span class="message-icon">💬</span>
          <span class="sender"><?= htmlspecialchars($msg['sender_name']) ?></span>
          <span class="item">🔗 <?= htmlspecialchars($msg['item_title']) ?></span>
        </div>
        <div class="message-right">
          <?php if ($msg['is_offer']): ?>
            <span class="offer-label">OFFER</span>
          <?php endif; ?>
          <span class="timestamp"><?= date("m/d/Y g:i A", strtotime($msg['sent_at'])) ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div> <!-- .messages-section -->

      







</body>
</html>