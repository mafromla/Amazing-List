<?php
include 'connect.php';

// Determine sort method
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'date';

$orderByClause = "ORDER BY Item.created_at DESC"; // Default to newest first

if ($sortBy === 'priceLow') {
    $orderByClause = "ORDER BY Item.price ASC";
} elseif ($sortBy === 'priceHigh') {
    $orderByClause = "ORDER BY Item.price DESC";
}

// Fetch items listed for sale (BUY) with dynamic sorting
$sql = "
    SELECT 
        Item.item_id, Item.title, Item.price, Item.image_url, Item.user_id,
        Address.city, Address.state, Address.zip_code
    FROM Item
    JOIN Address ON Item.user_id = Address.user_id
    WHERE Item.listing_type = 'BUY'
    $orderByClause
";

$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="listing-card">';
        
        echo '<a href="productlisting.php?id=' . $row['item_id'] . '">';
        echo '<img src="../' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '">';
        echo '<div class="listing-info">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="listing-location">' . htmlspecialchars($row['city']) . ', ' . htmlspecialchars($row['state']) . ' ' . htmlspecialchars($row['zip_code']) . '</p>';
        echo '<p class="listing-price">$' . htmlspecialchars($row['price']) . '</p>';
        echo '</div>'; 
        echo '</a>'; 
    
        // Heart and Message buttons
        echo '<div class="listing-actions">';
        echo '<a href="favorites.php?item_id=' . $row['item_id'] . '" class="favorite-btn" title="Add to Favorites">❤️</a>';
        echo '<a href="message.php?seller_id=' . $row['user_id'] . '&item_id=' . $row['item_id'] . '" class="message-btn" title="Message Seller">💬</a>';
        echo '</div>'; 
    
        echo '</div>';
    }
    
} else {
    echo "<p>No new listings available.</p>";
}
?>
