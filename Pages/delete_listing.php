<?php
session_start();
include 'connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to delete a listing.";
    exit;
}

if (!isset($_POST['item_id'])) {
    echo "Invalid request.";
    exit;
}

$item_id = intval($_POST['item_id']);
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM Item WHERE item_id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$item_id, $user_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "You do not have permission to delete this listing.";
    exit;
}

$sql = "DELETE FROM Item WHERE item_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$item_id]);

header("Location: index.php");
exit;
?>