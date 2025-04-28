<?php
require './connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if item_id was provided
if (!isset($_GET['item_id'])) {
    die('No item selected.');
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_GET['item_id']);

// Insert into Favorites table
try {
    $stmt = $pdo->prepare("INSERT INTO Favorites (user_id, item_id) VALUES (:user_id, :item_id)");
    $stmt->execute([
        'user_id' => $user_id,
        'item_id' => $item_id
    ]);
} catch (PDOException $e) {
    // Ignore duplicate favorites
}

// Redirect back to where user came from
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>