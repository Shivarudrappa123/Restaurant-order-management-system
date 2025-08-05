<?php
require_once 'config.php';

$pageTitle = 'Order Form';
$additionalCss = '<link rel="stylesheet" href="order_form.css">';
require_once 'header.php';

// Get item details from URL parameters
$itemName = isset($_GET['item']) ? $_GET['item'] : 'Item';
$itemPrice = isset($_GET['price']) ? $_GET['price'] : '0';
$itemImage = isset($_GET['image']) ? $_GET['image'] : '';
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : '1';
$customizations = isset($_GET['customizations']) ? json_decode($_GET['customizations'], true) : null;

?>

<div class="order-form-container">
    <h1>Place Your Order</h1>
    <div class="selected-item">
        <img src="<?php echo htmlspecialchars($itemImage); ?>" alt="<?php echo htmlspecialchars($itemName); ?>" class="item-image">
        <h2><?php echo htmlspecialchars($itemName); ?></h2>
        <p>Price: ₹<span id="itemPrice"><?php echo htmlspecialchars($itemPrice); ?></span></p>
    </div>
    <form id="orderForm" method="POST" action="process_order.php">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

        <label for="tableNumber">Select Table:</label>
        <select id="tableNumber" name="tableNumber" required>
            <option value="" disabled selected>Select a table</option>
            <?php for ($i = 1; $i <= 15; $i++): ?>
                <option value="<?php echo $i; ?>">Table <?php echo $i; ?></option>
            <?php endfor; ?>
        </select>

        <!-- Add hidden inputs for item details -->
        <input type="hidden" name="itemName" value="<?php echo htmlspecialchars($itemName); ?>">
        <input type="hidden" name="itemPrice" value="<?php echo htmlspecialchars($itemPrice); ?>">

        <button type="submit" onclick="alert('Order placed successfully!');">Proceed</button>
    </form>
</div>

<div class="order-details">
    <!-- ... existing item details ... -->
    
    <?php if ($customizations): ?>
    <div class="customization-details">
        <h3>Customizations:</h3>
        <ul>
            <li>Roti Type: <?php echo htmlspecialchars(ucfirst($customizations['rotiType'])); ?></li>
            <?php if (!empty($customizations['extras'])): ?>
            <li>Extras: <?php echo htmlspecialchars(implode(', ', array_map('ucfirst', $customizations['extras']))); ?></li>
            <?php endif; ?>
            <li>Spice Level: <?php echo htmlspecialchars($customizations['spiceLevel']); ?>/5</li>
            <?php if (!empty($customizations['instructions'])): ?>
            <li>Special Instructions: <?php echo htmlspecialchars($customizations['instructions']); ?></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
