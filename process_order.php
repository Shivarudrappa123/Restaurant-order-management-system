<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $phone = $_POST['phone'];
    $tableNumber = $_POST['tableNumber'];
    $itemName = $_POST['itemName'];
    $itemPrice = $_POST['itemPrice'];
    
    try {
        // Prepare SQL statement
        $sql = "INSERT INTO orderrequest (phone, table_number, item_name, item_price, order_status) 
                VALUES (?, ?, ?, ?, 'pending')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $phone, $tableNumber, $itemName, $itemPrice);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to menu with success message
            header("Location: menu.php?success=1");
            exit();
        } else {
            throw new Exception("Error processing order");
        }
    } catch (Exception $e) {
        // Redirect back with error
        header("Location: menu.php?error=1");
        exit();
    }
}
?> 