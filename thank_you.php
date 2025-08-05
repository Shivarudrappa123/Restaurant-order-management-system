<?php
require_once 'config.php'; // This will start the session if not already started

$pageTitle = 'Thank You';
$additionalCss = '<link rel="stylesheet" href="css/thank_you.css">';

require_once 'includes/header.php';
?>

<div class="thank-you-container">
    <h1>Thank You for Your Order!</h1>
    <p>Your payment has been successfully processed.</p>
    <p>We will contact you shortly.</p>
    <a href="index.php" class="cta-button">Go to Home</a>
</div>

<?php
require_once 'includes/footer.php';
?> 