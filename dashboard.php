<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // If not logged in and trying to login
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Check admin credentials (hardcoded for this example)
        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $error = "Invalid credentials!";
        }
    }
    
    // Show login form if not logged in
    if (!isset($_SESSION['admin_logged_in'])) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin Login</title>
            <style>
                .login-container {
                    max-width: 400px;
                    margin: 100px auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }
                .error { color: red; }
            </style>
        </head>
        <body>
            <div class="login-container">
                <h2>Admin Login</h2>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
                <form method="POST">
                    <p>
                        <label>Username:</label><br>
                        <input type="text" name="username" required>
                    </p>
                    <p>
                        <label>Password:</label><br>
                        <input type="password" name="password" required>
                    </p>
                    <button type="submit">Login</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

// Admin is logged in, show dashboard
$pageTitle = 'Admin Dashboard';
// require_once 'header.php';

// Handle order status updates
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $stmt = $conn->prepare("UPDATE orderrequest SET order_status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
}

// Fetch orders
$sql = "SELECT * FROM orderrequest ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<div class="dashboard-container">
    <div class="header-actions">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <table class="orders-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Item</th>
                <th>Price</th>
                <th>Table</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td>₹<?php echo htmlspecialchars($row['item_price']); ?></td>
                <td><?php echo htmlspecialchars($row['table_number']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                        <select name="new_status">
                            <option value="pending" <?php echo $row['order_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="processing" <?php echo $row['order_status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                            <option value="completed" <?php echo $row['order_status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo $row['order_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<style>
.dashboard-container {
    padding: 30px;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
}

.header-actions h1 {
    color: #2c3e50;
    font-size: 2.2em;
    margin: 0;
}

.logout-btn {
    padding: 12px 25px;
    background-color: #dc3545;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
}

.logout-btn:hover {
    background-color: #c82333;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.orders-table th, .orders-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.orders-table th {
    background-color: #4a90e2;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9em;
    letter-spacing: 0.5px;
}

.orders-table tr:last-child td {
    border-bottom: none;
}

.orders-table tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}

.orders-table select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: white;
    margin-right: 10px;
    font-size: 0.9em;
}

.orders-table button[name="update_status"] {
    padding: 8px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.orders-table button[name="update_status"]:hover {
    background-color: #218838;
    transform: translateY(-1px);
}

/* Status colors */
.orders-table td:nth-child(6) {
    font-weight: bold;
}

.orders-table tr td:nth-child(6):contains('pending') {
    color: #ffc107;
}

.orders-table tr td:nth-child(6):contains('processing') {
    color: #17a2b8;
}

.orders-table tr td:nth-child(6):contains('completed') {
    color: #28a745;
}

.orders-table tr td:nth-child(6):contains('cancelled') {
    color: #dc3545;
}

/* Login form styling */
.login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.login-container h2 {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 30px;
}

.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
}

.login-container button[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #4a90e2;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1.1em;
    cursor: pointer;
    transition: all 0.3s ease;
}

.login-container button[type="submit"]:hover {
    background-color: #357abd;
    transform: translateY(-2px);
}

.error {
    color: #dc3545;
    background-color: #ffe6e6;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

/* Responsive design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 15px;
    }
    
    .header-actions {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .orders-table {
        display: block;
        overflow-x: auto;
    }
    
    .orders-table th, 
    .orders-table td {
        padding: 10px;
    }
}
</style>
