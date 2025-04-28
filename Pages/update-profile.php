<?php
session_start();
require './connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// 1. Sanitize form inputs
$firstName     = trim($_POST['first_name']);
$lastName      = trim($_POST['last_name']);
$username      = trim($_POST['username']);
$email         = trim($_POST['email']);
$profileInfo   = trim($_POST['profile_info']);
$newPassword   = $_POST['new_password'];
$currentPass   = $_POST['current_password'];
$city          = trim($_POST['city'] ?? '');
$state         = trim($_POST['state'] ?? '');
$zip           = trim($_POST['zip_code'] ?? '');
$errors = [];

// 2. Check required fields
if (empty($username) || empty($email)) {
    $errors[] = "Username and email are required.";
}

// 3. Check for username/email uniqueness (except current user)
$checkStmt = $pdo->prepare("SELECT * FROM User WHERE (username = :username OR email_address = :email) AND user_id != :user_id");
$checkStmt->execute([
    'username' => $username,
    'email'    => $email,
    'user_id'  => $userId
]);
if ($checkStmt->rowCount() > 0) {
    $errors[] = "Username or email is already taken.";
}

// 4. If no errors, proceed
if (empty($errors)) {
    $updatePassword = '';
    $params = [
        'first_name'      => $firstName,
        'last_name'       => $lastName,
        'username'        => $username,
        'email_address'   => $email,
        'profile_info'    => $profileInfo,
        'user_id'         => $userId
    ];

    if (!empty($newPassword)) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePassword = ", password_hash = :password_hash";
        $params['password_hash'] = $hashed;
    }

    // Handles profile image (Its optional)
    $imageUrl = '';
    if (!empty($_FILES['profile_image']['name'])) {
        $targetDir = 'uploads/';
        $filename = uniqid() . '_' . basename($_FILES['profile_image']['name']);
        $targetFile = $targetDir . $filename;

        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            $imageUrl = $targetFile;
        }
    }

    if ($imageUrl) {
        $updateImage = ", profile_image_url = :profile_image_url";
        $params['profile_image_url'] = $imageUrl;
    } else {
        $updateImage = '';
    }

    // 5. Update User table
    $updateUser = $pdo->prepare("
        UPDATE User 
        SET 
            first_name = :first_name,
            last_name = :last_name,
            username = :username,
            email_address = :email_address,
            profile_info = :profile_info
            $updatePassword
            $updateImage
        WHERE user_id = :user_id
    ");
    $updateUser->execute($params);

    // 6. Update Address table 
    $stmt = $pdo->prepare("SELECT * FROM Address WHERE user_id = ?");
    $stmt->execute([$userId]);

    if ($stmt->rowCount()) {
        // Update
        $pdo->prepare("UPDATE Address SET city = ?, state = ?, zip_code = ? WHERE user_id = ?")
            ->execute([$city, $state, $zip, $userId]);
    } else if (!empty($city) || !empty($state) || !empty($zip)) {
        // Insert (just in case Address row doesn't exist)
        $pdo->prepare("INSERT INTO Address (user_id, city, state, zip_code) VALUES (?, ?, ?, ?)")
            ->execute([$userId, $city, $state, $zip]);
    }

    // 7. Redirect back to profile
    header("Location: profile.php?updated=1");
    exit;
} else {
    // Show error if needed (for now, just print for debug)
    echo "<h3>Error:</h3><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><a href='profile.php'>Back to profile</a>";
}
?>