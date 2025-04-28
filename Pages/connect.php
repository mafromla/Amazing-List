<?php
// connect.php - Database connection file for XAMPP default settings

$host = 'localhost';
$dbname = 'amazinglist'; // Your created database name
$username = 'root';      
$password = '';          // Default XAMPP password is empty

try {
    // Create a new PDO instance with UTF-8 encoding
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set error reporting mode to Exception for easier debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
