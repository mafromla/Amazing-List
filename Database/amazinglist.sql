CREATE TABLE User (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    username VARCHAR(30) UNIQUE NOT NULL,
    password_hash VARCHAR(128) NOT NULL,
    email_address VARCHAR(320) UNIQUE NOT NULL,
    profile_info TEXT,
    profile_image_url VARCHAR(255)
);

CREATE TABLE Address (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    street_address VARCHAR(255) NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(2) NOT NULL,
    zip_code VARCHAR(5) Not NULL,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);

CREATE TABLE Categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) UNIQUE NOT NULL,
    parent_id INT,
    FOREIGN KEY (parent_id) REFERENCES Categories(category_id) ON DELETE CASCADE
);

CREATE TABLE Item (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,          
    description TEXT NOT NULL,             
    category_id INT NOT NULL,              
    `condition` VARCHAR(100) NOT NULL,
    price INT,
    listing_type ENUM('BUY', 'TRADE') NOT NULL,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_starred BOOLEAN DEFAULT FALSE,
    is_sold BOOLEAN DEFAULT FALSE,
    image_url VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)  
);

CREATE TABLE Offer (
  offer_id INT PRIMARY KEY AUTO_INCREMENT,
  recipient_id INT NOT NULL,
  sender_id INT NOT NULL,
  money_requested INT DEFAULT 0,
  money_offered INT DEFAULT 0,
  status ENUM('pending', 'accepted', 'rejected', 'cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (recipient_id) REFERENCES User(user_id),
  FOREIGN KEY (sender_id) REFERENCES User(user_id)
);


CREATE TABLE Offer_Items (
    offer_item_id INT PRIMARY KEY AUTO_INCREMENT,
    offer_id INT NOT NULL,
    item_id INT NOT NULL,
    role ENUM('REQUESTED', 'OFFERED') NOT NULL,
    FOREIGN KEY (offer_id) REFERENCES Offer(offer_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES Item(item_id) ON DELETE CASCADE
);

CREATE TABLE Meetup (
    meetup_id INT PRIMARY KEY AUTO_INCREMENT,
    offer_id INT NOT NULL,
    halfway_lat DECIMAL(10,6),
    halfway_lng DECIMAL(10,6),
    chosen_lat DECIMAL(10,6),
    chosen_lng DECIMAL(10,6),
    meeting_date VARCHAR(20),
    meeting_time INT,
    completion_status BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (offer_id) REFERENCES Offer(offer_id) ON DELETE CASCADE
);
CREATE TABLE Favorites (
    favorite_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_favorite (user_id, item_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES Item(item_id) ON DELETE CASCADE
);

CREATE TABLE Messages (
    message_id INT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    item_id INT, -- Optional: Link to the item they are messaging about
    message_text TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES Item(item_id) ON DELETE CASCADE
);



-- STEP 1: Insert parent categories (top-level)
INSERT INTO Categories (category_name, parent_id) VALUES
('Electronics', NULL),
('Vehicles', NULL),
('Home & Furniture', NULL),
('Fashion & Accessories', NULL),
('Books, Music & Movies', NULL),
('Sports & Outdoor', NULL),
('Other', NULL);

-- STEP 2: Insert child categories one-by-one with derived tables
-- Electronics subcategories
INSERT INTO Categories (category_name, parent_id)
SELECT 'Mobile Phones', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Laptops & Computers', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Tablets & iPads', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Gaming Consoles & Accessories', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

INSERT INTO Categories (category_name, parent_id)
SELECT 'TVs & Home Entertainment', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Cameras & Photography', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Wearables & Smartwatches', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Electronics';

-- Vehicles subcategories
INSERT INTO Categories (category_name, parent_id)
SELECT 'Cars', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Vehicles';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Motorcycles & Scooters', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Vehicles';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Bicycles', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Vehicles';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Trucks & Commercial Vehicles', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Vehicles';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Auto Parts & Accessories', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Vehicles';

-- Home & Furniture subcategories
INSERT INTO Categories (category_name, parent_id)
SELECT 'Sofas & Seating', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Home & Furniture';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Beds & Mattresses', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Home & Furniture';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Tables & Chairs', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Home & Furniture';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Cabinets & Storage', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Home & Furniture';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Home Decor', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Home & Furniture';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Kitchen & Dining', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Home & Furniture';

-- Fashion & Accessories subcategories (apostrophes escaped)
INSERT INTO Categories (category_name, parent_id)
SELECT 'Men''s Clothing', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Fashion & Accessories';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Women''s Clothing', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Fashion & Accessories';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Shoes', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Fashion & Accessories';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Bags & Wallets', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Fashion & Accessories';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Jewelry & Watches', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Fashion & Accessories';

-- Books, Music & Movies subcategories
INSERT INTO Categories (category_name, parent_id)
SELECT 'Fiction & Non-fiction Books', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Books, Music & Movies';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Textbooks & Study Material', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Books, Music & Movies';

INSERT INTO Categories (category_name, parent_id)
SELECT 'CDs & Vinyl Records', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Books, Music & Movies';

INSERT INTO Categories (category_name, parent_id)
SELECT 'DVDs & Blu-ray', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Books, Music & Movies';

-- Sports & Outdoor subcategories
INSERT INTO Categories (category_name, parent_id)
SELECT 'Exercise Equipment', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Sports & Outdoor';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Camping & Hiking Gear', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Sports & Outdoor';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Sports Apparel & Shoes', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Sports & Outdoor';

INSERT INTO Categories (category_name, parent_id)
SELECT 'Bicycles & Accessories', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Sports & Outdoor';

-- Other
INSERT INTO Categories (category_name, parent_id)
SELECT 'Standalone Items', category_id FROM (SELECT * FROM Categories) AS tmp WHERE category_name = 'Other';