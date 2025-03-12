<?php
session_start();
require './connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Simple validation
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Prepare a query to fetch user data by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password if user exists
        if ($user && password_verify($password, $user['password'])) {
            // Set session and redirect on successful login
            $_SESSION['user_id'] = $user['id'];
            header("Location: homepage.php"); // Adjust redirect as needed
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
  <div class="login-container">
    <h1>Sign In</h1>
    <?php
    // Display errors if there are any
    if (isset($error)) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    ?>
    <form class="login-form" action="login.php" method="POST">
      <div class="form-group">
        <label for="loginEmail">Email</label>
        <input type="email" id="loginEmail" name="email" placeholder="example@email.com" required>
      </div>
      <div class="form-group">
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" name="password" placeholder="********" required>
      </div>
      <button type="submit" class="login-submit-btn">Log In</button>
    </form>
  </div>
</body>
</html>

