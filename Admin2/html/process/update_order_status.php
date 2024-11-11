<?php
include 'model/Orders.php';
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the request is POST and contains the necessary data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['order_status'])) {
    $orderId = intval($_POST['order_id']); // Ensure the order_id is an integer
    $newStatus = $_POST['order_status'];  // Order status (pending, cancelled, delivered)

    $orders = new Order();
    
    // Validate the order status
    $response = $orders->updateOrderStatus($orderId, $newStatus);
    echo json_encode($response);
} else {
    // Invalid request or missing parameters
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing parameters']);
}
?>
