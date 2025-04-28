<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Capture and sanitize form input
    $firstName      = trim($_POST['firstName']);
    $lastName       = trim($_POST['lastName']);
    $username       = trim($_POST['username']);
    $email          = trim($_POST['email']);
    $password       = $_POST['password'];
    $passwordRepeat = $_POST['psw-repeat'];
    $streetAddress  = !empty($_POST['streetAddress']) ? trim($_POST['streetAddress']) : null;
    $city           = trim($_POST['city']);
    $state          = trim($_POST['state']);
    $zip            = trim($_POST['zip']);

    $errors = [];

    // Step 2: Validate
    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) ||
        empty($password) || empty($passwordRepeat) || empty($city) || empty($state) || empty($zip)) {
        $errors[] = "Please fill in all required fields.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if ($password !== $passwordRepeat) {
        $errors[] = "Passwords do not match.";
    }

    // Step 3: Check for duplicate username/email
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE username = :username OR email_address = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);

        if ($stmt->rowCount() > 0) {
            $errors[] = "Username or email already exists.";
        } else {
            // Step 4: Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Step 5: Insert into User table
            $stmt = $pdo->prepare("INSERT INTO User 
                (first_name, last_name, username, password_hash, email_address)
                VALUES (:first_name, :last_name, :username, :password_hash, :email)");

            $result = $stmt->execute([
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'username'      => $username,
                'password_hash' => $hashedPassword,
                'email'         => $email
            ]);

            if ($result) {
                $user_id = $pdo->lastInsertId(); // Get new user ID

                // Step 6: Insert into Address table
                $stmt = $pdo->prepare("INSERT INTO Address 
                    (user_id, street_address, city, state, zip_code)
                    VALUES (:user_id, :street_address, :city, :state, :zip_code)");

                $stmt->execute([
                    'user_id'        => $user_id,
                    'street_address' => $streetAddress,
                    'city'           => $city,
                    'state'          => $state,
                    'zip_code'       => $zip
                ]);

                // Step 7: Store session and redirect
                $_SESSION['user_id'] = $user_id;
                header("Location: index.html");
                exit;
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Amazing List</title>
  <link rel="stylesheet" href="../CSS/register.css">
  <link rel="stylesheet" href="../CSS/style.css">
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
      <button class="add-listing-btn" type="button">+ Add Listing</button>
    </div>
  </header>

  <div class="signup-container">
    <h1>Create Your Account</h1>
    <?php
    if (!empty($errors)) {
        echo '<ul style="color: red;">';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
    }
    ?>
    <!-- The form posts back to register.php -->
    <form class="signup-form" action="register.php" method="POST">
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
      </div>
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
      </div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="psw" name="password" placeholder="Enter a secure password" required>
      </div>
      <div class="form-group">
        <label for="psw-repeat">Confirm Password</label>
        <input type="password" id="psw-repeat" name="psw-repeat" placeholder="Repeat your password" required>
      </div>
      <div class="form-group">
        <label for="city">City</label>
        <input type="text" id="city" name="city" placeholder="Enter your city" required>
      </div>
      <div class="form-group">
        <label for="state">State</label>
        <input type="text" id="state" name="state" placeholder="Enter your state" required>
      </div>
      <div class="form-group">
        <label for="zip">Zip Code</label>
        <input type="text" id="zip" name="zip" placeholder="Enter your zip code" required>
      </div>
      <button type="submit" class="signup-btn">Sign Up</button>
    </form>
  </div>



  <!-- Login Modal (Reused) -->
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
