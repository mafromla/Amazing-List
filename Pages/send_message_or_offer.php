<?php
session_start();
require './connect.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderId = $_SESSION['user_id'];
    $receiverId = intval($_POST['receiver_id']);
    $itemId = intval($_POST['item_id']);
    $listingType = $_POST['listing_type'];
    $messageText = trim($_POST['message_text']);
    $offerText = isset($_POST['offer_text']) ? trim($_POST['offer_text']) : null;
    $offerAmount = isset($_POST['offer_amount']) ? floatval($_POST['offer_amount']) : null;

    try {
        // Always insert a message
        $stmt = $pdo->prepare("
            INSERT INTO Messages (sender_id, receiver_id, item_id, message_text)
            VALUES (:sender_id, :receiver_id, :item_id, :message_text)
        ");
        $stmt->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'item_id' => $itemId,
            'message_text' => $messageText
        ]);

        // If it's a TRADE listing and offer is filled
        if ($listingType === 'TRADE' && (!empty($offerText) || $offerAmount > 0)) {
            // Insert offer
            $stmtOffer = $pdo->prepare("
                INSERT INTO Offer (recipient_id, money_requested, money_offered)
                VALUES (:recipient_id, 0, :money_offered)
            ");
            $stmtOffer->execute([
                'recipient_id' => $receiverId,
                'money_offered' => $offerAmount ?? 0
            ]);

            $offerId = $pdo->lastInsertId();

            // Insert into Offer_Items table for the trade
            $stmtOfferItems = $pdo->prepare("
                INSERT INTO Offer_Items (offer_id, item_id, role)
                VALUES (:offer_id, :item_id, 'OFFERED')
            ");
            $stmtOfferItems->execute([
                'offer_id' => $offerId,
                'item_id' => $itemId
            ]);
        }

        // Redirect back after successful message
        header('Location: buypage.php');
        exit;

    } catch (PDOException $e) {
        echo "Error sending message: " . $e->getMessage();
    }
}
?>
