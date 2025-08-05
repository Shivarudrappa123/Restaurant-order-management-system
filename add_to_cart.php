<?php
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$itemId = isset($data['itemId']) ? (int)$data['itemId'] : 0;

if ($itemId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid item']);
    exit;
}

// Add item to cart in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$itemId])) {
    $_SESSION['cart'][$itemId]++;
} else {
    $_SESSION['cart'][$itemId] = 1;
}

echo json_encode(['success' => true, 'message' => 'Item added to cart']);
?> 