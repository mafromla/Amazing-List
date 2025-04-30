<?php
session_start();
require './connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderId     = $_SESSION['user_id'];
    $receiverId   = intval($_POST['receiver_id']);
    $itemId       = intval($_POST['item_id']);
    $listingType  = $_POST['listing_type'];
    $messageText  = trim($_POST['message_text']);
    $offerText    = isset($_POST['offer_text']) ? trim($_POST['offer_text']) : null;
    $offerAmount  = isset($_POST['offer_amount']) ? floatval($_POST['offer_amount']) : 0;
    $offeredItemId = isset($_POST['offered_item_id']) ? intval($_POST['offered_item_id']) : null;

    try {
        // 1. Optional message
        if (!empty($messageText)) {
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
        }

        // 2. If it's a TRADE offer
        if ($listingType === 'TRADE' && (!empty($offerText) || $offerAmount > 0 || $offeredItemId)) {

            // Insert Offer
            $stmtOffer = $pdo->prepare("
                INSERT INTO Offer (sender_id, recipient_id, money_requested, money_offered, status)
                VALUES (:sender_id, :recipient_id, 0, :money_offered, 'pending')
            ");
            $stmtOffer->execute([
                'sender_id' => $senderId,
                'recipient_id' => $receiverId,
                'money_offered' => $offerAmount
            ]);

            $offerId = $pdo->lastInsertId();

            // Requested item (receiver's item)
            $stmt = $pdo->prepare("
                INSERT INTO Offer_Items (offer_id, item_id, role)
                VALUES (:offer_id, :item_id, 'REQUESTED')
            ");
            $stmt->execute([
                'offer_id' => $offerId,
                'item_id' => $itemId
            ]);

            // Optional: Offered item (sender's item)
            if (!empty($offeredItemId)) {
                $stmt = $pdo->prepare("
                    INSERT INTO Offer_Items (offer_id, item_id, role)
                    VALUES (:offer_id, :item_id, 'OFFERED')
                ");
                $stmt->execute([
                    'offer_id' => $offerId,
                    'item_id' => $offeredItemId
                ]);
            }
        }

        header('Location: buypage.php?sent=1');
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
