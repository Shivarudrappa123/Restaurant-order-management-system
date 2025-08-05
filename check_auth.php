<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Store the intended destination URL
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: account.php");
    exit();
}

// Optional: Check if the session hasn't expired
$session_lifetime = 3600; // 1 hour
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_lifetime)) {
    session_unset();
    session_destroy();
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: account.php?msg=session_expired");
    exit();
}
$_SESSION['last_activity'] = time();
?> 