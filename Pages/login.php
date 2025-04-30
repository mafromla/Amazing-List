<?php
session_start();
require './connect.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Match to new User table + column names
        $stmt = $pdo->prepare("SELECT * FROM User WHERE email_address = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session and redirect
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php"); // Adjust if needed
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Amazing List</title>
  <link rel="stylesheet" href="../CSS/style.css">
  <script src="../Script/script.js"></script>
</head>
<body>
  <!-- Trigger Button for Sign In Modal -->
  <button type="button" onclick="openModal()" class="open-modal-btn">Sign In</button>

  <!-- Login Modal (initially hidden) -->
  <div id="loginModal" class="modal-overlay">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2>Sign In</h2>
      <?php
      // Display errors if there are any
      if (isset($error)) {
          echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
      }
      ?>
      <form class="login-form" onsubmit="return false;">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="example@email.com">

        <label for="password">Password</label>
        <input type="password" id="password" placeholder="********">

        <div class="login-options">
          <label class="remember-me">
            <input type="checkbox" > Remember me
          </label>
          <a href="#" class="forgot-link">Forgot Password?</a>
        </div>

        <button type="submit" class="login-submit-btn">Log In</button>

        <p class="signup-prompt">
          Don't have an account? <a href="register.html">Sign Up</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
</html>
