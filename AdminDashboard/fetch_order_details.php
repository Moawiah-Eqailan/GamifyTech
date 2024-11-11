<?php
include "model/Orders.php";

header('Content-Type: application/json'); // Set header to return JSON

if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']); // Ensure the order ID is an integer

    $orders = new Order();
    $orderDetails = $orders->viewOrderDetails($orderId); // Fetch order details

    if ($orderDetails !== false && !empty($orderDetails)) {
        // Return success response with order details
        echo json_encode(['success' => true, 'orderDetails' => $orderDetails]);
    } else {
        // Return error response if order details could not be fetched
        echo json_encode(['success' => false, 'message' => 'Error retrieving order details.']);
    }
} else {
    // Return error response if order ID is not provided
    echo json_encode(['success' => false, 'message' => 'Order ID not provided.']);
}
