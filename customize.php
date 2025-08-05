<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

// Get item ID from URL
$item_id = isset($_GET['item']) ? (int)$_GET['item'] : 0;

// Fetch item details from database
$sql = "SELECT * FROM menu_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    // Redirect if item not found
    header('Location: menu.php');
    exit();
}

$pageTitle = 'Customize Your Order';
$additionalCss = '<link rel="stylesheet" href="customize.css">';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Order - FoodieHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="customize.css">
</head>

<body>
    <nav class="navbar">
        <div class="nav-content">
            <a href="#" class="logo">FoodieHub</a>
            <ul class="nav-links">
                <li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
                <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="account.php"><i class="fas fa-user"></i> Account</a></li>
                <li><a href="support.php"><i class="fas fa-headset"></i> Support</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <div class="customize-container">
        <div class="item-preview">
            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="preview-image">
            <div class="preview-details">
                <h2>Customize <?php echo htmlspecialchars($item['name']); ?></h2>
                <p class="base-price">Base Price: ₹<?php echo number_format($item['price'], 2); ?></p>
            </div>
        </div>

        <form id="customizationForm">
            <div class="customization-section">
                <h3 class="section-title">Bread Options</h3>
                <div class="option-group">
                    <p class="option-title">Type of Roti</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="roti-type" value="plain" checked>
                            Plain Roti
                        </label>
                        <label>
                            <input type="radio" name="roti-type" value="butter" data-price="10">
                            Butter Roti (+₹10)
                        </label>
                        <label>
                            <input type="radio" name="roti-type" value="garlic" data-price="15">
                            Garlic Roti (+₹15)
                        </label>
                        <label>
                            <input type="radio" name="roti-type" value="missi" data-price="20">
                            Missi Roti (+₹20)
                        </label>
                    </div>
                </div>
            </div>

            <div class="customization-section">
                <h3 class="section-title">Additional Options</h3>
                <div class="option-group">
                    <p class="option-title">Add Extra</p>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="extras" value="ghee" data-price="15">
                            Extra Ghee (+₹15)
                        </label>
                        <label>
                            <input type="checkbox" name="extras" value="butter" data-price="10">
                            Extra Butter (+₹10)
                        </label>
                        <label>
                            <input type="checkbox" name="extras" value="stuffing" data-price="25">
                            Aloo Stuffing (+₹25)
                        </label>
                    </div>
                </div>

                <div class="option-group">
                    <p class="option-title">Spice Level</p>
                    <div class="spice-level">
                        <span>Mild</span>
                        <input type="range" class="spice-slider" min="1" max="5" value="2">
                        <span>Spicy</span>
                    </div>
                </div>
            </div>

            <div class="customization-section">
                <h3 class="section-title">Quantity & Instructions</h3>
                <div class="quantity-control">
                    <button type="button" class="quantity-btn minus">-</button>
                    <input type="number" class="quantity-input" value="1" min="1" max="10">
                    <button type="button" class="quantity-btn plus">+</button>
                </div>
                <textarea class="special-instructions" placeholder="Any special instructions? (Optional)"></textarea>
            </div>

            <div class="price-summary">
                <div class="price-row">
                    <span>Base Price:</span>
                    <span id="basePrice">₹<?php echo number_format($item['price'], 2); ?></span>
                </div>
                <div class="price-row">
                    <span>Add-ons:</span>
                    <span id="addonsPrice">₹0.00</span>
                </div>
                <div class="total-price">
                    <span>Total:</span>
                    <span id="totalPrice">₹<?php echo number_format($item['price'], 2); ?></span>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="add-to-cart">Add to Cart</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='menu.php'">Cancel</button>
            </div>
        </form>
    </div>

    <script src="customize.js"></script>
    <script src="navbar.js"></script>
</body>

</html>