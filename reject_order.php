<?php
session_start();
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);
$orderId = $data['id'];

// Update order status to rejected
$stmt = $conn->prepare("UPDATE orders SET status = 'rejected' WHERE id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to reject order.']);
}
?> 