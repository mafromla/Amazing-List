<?php
require './connect.php';
session_start();

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate session
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        // Validate required fields
        $required = ['title', 'description', 'condition', 'listing_type', 'category_id'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Required field '$field' is missing");
            }
        }

        // Sanitize inputs
        $userId = $_SESSION['user_id'];
        $categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $condition = htmlspecialchars($_POST['condition']);
        $listingType = htmlspecialchars($_POST['listing_type']);
        $price = isset($_POST['price']) ? filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;

        // Handle file upload
        $imageUrl = null;
        if (!empty($_FILES['listing_image']['name'])) {
            $targetDir = "uploads/"; // Correct relative path
            $maxSize = 2 * 1024 * 1024; // 2MB limit
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Ensure upload folder exists
            if (!file_exists('../' . $targetDir)) {
                mkdir('../' . $targetDir, 0755, true);
            }

            // Validate file
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['listing_image']['tmp_name']);
            finfo_close($fileInfo);

            if (!in_array($mimeType, $allowedTypes)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and GIF allowed.");
            }

            if ($_FILES['listing_image']['size'] > $maxSize) {
                throw new Exception("File size exceeds 2MB limit.");
            }

            // Save file
            $extension = pathinfo($_FILES['listing_image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('img_', true) . '.' . $extension;
            $targetFile = '../' . $targetDir . $filename; // Save outside Pages folder

            if (!move_uploaded_file($_FILES['listing_image']['tmp_name'], $targetFile)) {
                throw new Exception("Failed to upload image.");
            }

            $imageUrl = $targetDir . $filename; // Save relative path like uploads/filename.jpg
        }

        // Validate price for Buy listings
        if ($listingType === 'BUY' && (!isset($price) || $price <= 0)) {
            throw new Exception("Price is required for Buy listings.");
        }

        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO Item 
                (user_id, title, description, image_url, category_id, `condition`, price, listing_type)
            VALUES 
                (:user_id, :title, :description, :image_url, :category_id, :condition, :price, :listing_type)
        ");

        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'image_url' => $imageUrl,
            'category_id' => $categoryId,
            'condition' => $condition,
            'price' => $listingType === 'BUY' ? $price : null,
            'listing_type' => $listingType
        ]);

        header("Location: my-listings.php?success=1");
        exit;

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        header("Location: addlisting.php?error=database");
        exit;
    } catch (Exception $e) {
        error_log("Application error: " . $e->getMessage());
        header("Location: addlisting.php?error=" . urlencode($e->getMessage()));
        exit;
    }
}

// Invalid request fallback
http_response_code(400);
header("Location: addlisting.php");
exit;
?>
