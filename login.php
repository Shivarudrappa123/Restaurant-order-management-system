<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is already logged in
if (isset($_SESSION['user_id'])) {
    // Check for redirect in localStorage using JavaScript
    echo "<script>
        var redirectUrl = localStorage.getItem('redirect_after_login');
        if (redirectUrl) {
            localStorage.removeItem('redirect_after_login');
            window.location.href = redirectUrl;
        } else {
            window.location.href = 'menu.php';
        }
    </script>";
    exit();
}

// Your login form and processing logic here
// After successful login:
if ($login_successful) {
    $_SESSION['user_id'] = $user_id; // Set your session
    echo "<script>
        var redirectUrl = localStorage.getItem('redirect_after_login');
        if (redirectUrl) {
            localStorage.removeItem('redirect_after_login');
            window.location.href = redirectUrl;
        } else {
            window.location.href = 'menu.php';
        }
    </script>";
    exit();
}
?> 