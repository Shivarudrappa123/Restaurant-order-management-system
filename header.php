<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Don't require config.php here since it's already included in the main pages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - FoodieHub' : 'FoodieHub'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <?php if (isset($additionalCss)) echo $additionalCss; ?>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <a href="index.php" class="logo">FoodieHub</a>
            <ul class="nav-links">
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
                <li><a href="order.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="account.php"><i class="fas fa-user"></i> My Account</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="account.php"><i class="fas fa-user"></i> Login</a></li>
                <?php endif; ?>
                <li><a href="support.php"><i class="fas fa-headset"></i> Support</a></li>
            </ul>
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
</body>
</html> 