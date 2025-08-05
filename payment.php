<?php
require_once 'config.php';

$pageTitle = 'Payment';
$additionalCss = '<link rel="stylesheet" href="payment.css">';
require_once 'header.php';

// Retrieve phone and table number from session storage
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$tableNumber = isset($_SESSION['tableNumber']) ? $_SESSION['tableNumber'] : '';
$itemName = isset($_SESSION['itemName']) ? $_SESSION['itemName'] : 'Item';
$itemPrice = isset($_SESSION['itemPrice']) ? $_SESSION['itemPrice'] : '0';
$itemImage = isset($_SESSION['itemImage']) ? $_SESSION['itemImage'] : '';

?>

<div class="payment-container">
    <h1>Payment</h1>
    <p>Please complete your payment to finalize your order.</p>
    <div class="selected-item">
        <img src="<?php echo htmlspecialchars($itemImage); ?>" alt="<?php echo htmlspecialchars($itemName); ?>" class="item-image">
        <h2><?php echo htmlspecialchars($itemName); ?></h2>
        <p>Price: ₹<span id="itemPrice"><?php echo htmlspecialchars($itemPrice); ?></span></p>
    </div>
    <p>Phone Number: <strong><?php echo htmlspecialchars($phone); ?></strong></p>
    <p>Table Number: <strong><?php echo htmlspecialchars($tableNumber); ?></strong></p>

    <form id="paymentForm">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($itemPrice); ?>" readonly> <!-- Use the item price -->

        <button type="button" id="rzp-button1">Pay Now</button>
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('rzp-button1').onclick = function(e) {
        var options = {
            "key": "YOUR_RAZORPAY_KEY", // Enter the Key ID generated from the Dashboard
            "amount": document.getElementById('amount').value * 100, // Amount is in currency subunits
            "currency": "INR",
            "name": "FoodieHub",
            "description": "Order Payment",
            "image": "https://example.com/your_logo", // Your logo
            "handler": function (response){
                alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                // Redirect to thank you page
                window.location.href = 'thank_you.php';
            },
            "prefill": {
                "name": "Customer Name",
                "email": "customer@example.com",
                "contact": "<?php echo htmlspecialchars($phone); ?>" // Use the phone number from the form
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    }
</script>


 
