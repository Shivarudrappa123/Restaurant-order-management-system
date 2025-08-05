<?php
session_start();
require_once 'config.php';

$pageTitle = 'Your Order';
$additionalCss = '<link rel="stylesheet" href="css/order.css">';

require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - FoodieHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="index.css">
    <style>
        .order-container {
            margin-top: 80px;
            padding: 2rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .order-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .order-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .cart-empty {
            text-align: center;
            padding: 2rem;
            background: #f9f9f9;
            border-radius: 10px;
            margin: 2rem 0;
        }
        
        .cart-empty i {
            font-size: 3rem;
            color: #666;
            margin-bottom: 1rem;
        }
        
        .cart-empty p {
            color: #666;
            margin-bottom: 1rem;
        }
        
        .cart-empty .browse-menu {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .item-customization {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .item-price {
            font-weight: bold;
            color: #333;
        }
        
        .item-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quantity-btn {
            padding: 0.3rem 0.8rem;
            background: #f0f0f0;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .quantity-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 0.3rem;
        }
        
        .remove-item {
            color: #ff4444;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0.5rem;
        }
        
        .order-summary {
            margin-top: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: #666;
        }
        
        .total {
            font-size: 1.2rem;
            color: #333;
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 1rem;
        }
        
        .checkout-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 1rem;
            transition: background-color 0.3s ease;
        }
        
        .checkout-btn:hover {
            background: #444;
        }
        
        @media screen and (max-width: 768px) {
            .order-container {
                padding: 1rem;
            }
            .cart-item {
                flex-direction: column;
                text-align: center;
            }
            .item-image {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            .item-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        .logout-btn {
            color: #ff4444 !important;
            transition: color 0.3s ease;
        }
        
        .logout-btn:hover {
            color: #ff0000 !important;
        }
        
        /* For mobile responsiveness */
        @media screen and (max-width: 768px) {
            .logout-btn {
                width: 100%;
                text-align: center;
                padding: 10px;
            }
        }
    </style>
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


<div class="order-container">
    <div class="order-header">
        <h1 class="order-title">Your Order</h1>
    </div>

    <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="login-prompt">
        <div class="cart-empty">
            <i class="fas fa-user-lock"></i>
            <p>Please login to view your orders</p>
            <a href="account.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="browse-menu">Login</a>
        </div>
    </div>
    <?php else: ?>
    <div id="cartContent">
        <!-- Cart items will be dynamically inserted here -->
    </div>

    <div class="order-summary" id="orderSummary" style="display: none;">
        <h2>Order Summary</h2>
        <div class="summary-item">
            <span>Subtotal:</span>
            <span id="subtotal">₹0.00</span>
        </div>
        <div class="summary-item">
            <span>Tax (5%):</span>
            <span id="tax">₹0.00</span>
        </div>
        <div class="summary-item total">
            <span>Total:</span>
            <span id="total">₹0.00</span>
        </div>
        <button class="checkout-btn">Proceed to Checkout</button>
    </div>
    <?php endif; ?>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Enter Phone Number</h2>
        <form id="checkoutForm">
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            <button type="submit">Send OTP</button>
        </form>
        <div id="otpSection" style="display: none;">
            <h3>Enter OTP</h3>
            <input type="text" id="otp" placeholder="Enter OTP" required>
            <button id="verifyOtpBtn">Verify OTP</button>
        </div>
    </div>
</div>

<script>
    // Function to display cart items
    function displayCart() {
        const cartContent = document.getElementById('cartContent');
        const orderSummary = document.getElementById('orderSummary');
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        if (cartItems.length === 0) {
            cartContent.innerHTML = `
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Your cart is empty</p>
                    <a href="menu.php" class="browse-menu">Browse Menu</a>
                </div>
            `;
            orderSummary.style.display = 'none';
            return;
        }

        let cartHTML = '<div class="cart-items">';
        let subtotal = 0;

        cartItems.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            cartHTML += `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}" class="item-image">
                    <div class="item-details">
                        <h3 class="item-name">${item.name}</h3>
                        <p class="item-customization">${formatCustomizations(item.customizations)}</p>
                        <p class="item-price">₹${item.price.toFixed(2)} x ${item.quantity}</p>
                    </div>
                    <div class="item-actions">
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <input type="number" class="quantity-input" value="${item.quantity}" 
                                min="1" max="10" onchange="updateQuantityInput(${index}, this.value)">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                        <button class="remove-item" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        cartHTML += '</div>';
        cartContent.innerHTML = cartHTML;
        orderSummary.style.display = 'block';

        // Update summary calculations
        const tax = subtotal * 0.05;
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
        document.getElementById('tax').textContent = `${tax.toFixed(2)}`;
        document.getElementById('total').textContent = `₹${total.toFixed(2)}`;
    }

    // Format customizations for display
    function formatCustomizations(customizations) {
        if (!customizations) return '';
        let details = [];
        if (customizations.portion) details.push(`Portion: ${customizations.portion}`);
        if (customizations.spiceLevel) details.push(`Spice: ${customizations.spiceLevel}`);
        if (customizations.extras && customizations.extras.length > 0) {
            details.push(`Extras: ${customizations.extras.join(', ')}`);
        }
        return details.join(' | ');
    }

    // Update item quantity
    function updateQuantity(index, change) {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const newQuantity = cartItems[index].quantity + change;

        if (newQuantity >= 1 && newQuantity <= 10) {
            cartItems[index].quantity = newQuantity;
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            displayCart();
        }
    }

    // Update quantity through input
    function updateQuantityInput(index, value) {
        const quantity = parseInt(value);
        if (quantity >= 1 && quantity <= 10) {
            const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            cartItems[index].quantity = quantity;
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
            displayCart();
        }
    }

    // Remove item from cart
    function removeItem(index) {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems.splice(index, 1);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        displayCart();
    }

    // Initialize cart display
    document.addEventListener('DOMContentLoaded', displayCart);

    // Checkout button event listener
    document.querySelector('.checkout-btn').addEventListener('click', function() {
        const modal = document.getElementById('checkoutModal');
        modal.style.display = "block";
    });

    // Close modal when clicking the close button or outside the modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('checkoutModal');
        const span = document.getElementsByClassName("close")[0];
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });

    // Handle checkout form submission
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const phone = document.getElementById('phone').value;

        // Send OTP to the phone number
        fetch('send_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ phone })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('OTP sent to your phone!');
                document.getElementById('otpSection').style.display = 'block';
            } else {
                alert('Error sending OTP: ' + data.message);
            }
        });
    });

    // Handle OTP verification
    document.getElementById('verifyOtpBtn').addEventListener('click', function() {
        const otp = document.getElementById('otp').value;

        fetch('verify_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'payment.php'; // Redirect to payment page
            } else {
                alert('Invalid OTP: ' + data.message);
            }
        });
    });
</script>

<?php
$additionalJs = '<script src="js/order.js"></script>';
require_once 'footer.php';
?> 
    <script src="navbar.js"></script>
</body>

</html>