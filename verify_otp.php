<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$otp = $data['otp'] ?? '';

if (empty($otp)) {
    echo json_encode(['success' => false, 'message' => 'OTP is required.']);
    exit;
}

// Check if the OTP matches
if (isset($_SESSION['otp']) && $otp == $_SESSION['otp']) {
    // OTP is valid, proceed to payment
    unset($_SESSION['otp']); // Clear OTP from session
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid OTP.']);
}
?> 