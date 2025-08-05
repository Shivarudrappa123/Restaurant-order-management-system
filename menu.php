<?php
session_start();
require_once 'config.php';
require_once 'check_auth.php';

$pageTitle = 'Menu';
$additionalCss = '<link rel="stylesheet" href="menu.css">';

// Fetch menu items from database
$sql = "SELECT * FROM menu_items ORDER BY category";
$result = $conn->query($sql);
$menuItems = [];
while ($row = $result->fetch_assoc()) {
    $menuItems[] = $row;
}

require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - FoodieHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="index.css">
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
                <li><a href="support.html"><i class="fas fa-headset"></i> Support</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
<div class="menu-container">
    <div class="menu-header">
        <h1 class="menu-title">Our Menu</h1>
        <p class="menu-description">Discover our delicious selection of dishes</p>
    </div>

    <div class="category-tabs">
        <button class="category-tab active">All</button>
        <button class="category-tab">Starters</button>
        <button class="category-tab">Main Course</button>
        <button class="category-tab">Desserts</button>
        <button class="category-tab">Beverages</button>
    </div>

    <div class="menu-grid">
        <?php foreach ($menuItems as $item): ?>
        <div class="menu-item" data-category="<?php echo strtolower($item['category']); ?>">
            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-image">
            <div class="item-info">
                <h3 class="item-title"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                <div class="item-footer">
                    <span class="item-price">₹<?php echo number_format($item['price'], 2); ?></span>
                    <div class="button-group">
                        <a href="order_form.php?item=<?php echo urlencode($item['name']); ?>&price=<?php echo $item['price']; ?>&image=<?php echo urlencode($item['image_url']); ?>" class="order-now">Order Now</a>
                        <?php if ($item['is_customizable']): ?>
                        <a href="customize.php?item=<?php echo $item['id']; ?>" class="customize-btn">Customize</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
</div>

<?php
$additionalJs = '<script src="menu.js"></script>';
require_once 'footer.php';
?>
    <script src="navbar.js"></script>
</body>
</html>