<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$phone = $data['phone'] ?? '';

if (empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Phone number is required.']);
    exit;
}

// Generate a random OTP
$otp = rand(100000, 999999);

// Store OTP in session for verification
$_SESSION['otp'] = $otp;
$_SESSION['otp_phone'] = $phone;

// Here you would send the OTP to the user's phone number using an SMS API
// For demonstration, we'll just simulate sending the OTP
// mail($phone . '@sms.gateway.com', 'Your OTP', 'Your OTP is: ' . $otp); // Example

echo json_encode(['success' => true, 'message' => 'OTP sent to your phone.']);
?> 