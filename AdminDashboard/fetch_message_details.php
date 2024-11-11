<?php
require_once 'model/messages.php';  // Ensure this path is correct

header('Content-Type: application/json'); // Ensure response is JSON

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['contact_us_id'])) {
    $contactUsId = intval($_GET['contact_us_id']); // Sanitize input

    $messageModel = new messages();
    $messageDetails = $messageModel->getMessageDetails($contactUsId);

    if ($messageDetails) {
        // Return success response
        echo json_encode(['success' => true, 'messageDetails' => $messageDetails]);
    } else {
        // Return error response if no details found
        echo json_encode(['success' => false, 'message' => 'No message found.']);
    }
} else {
    // Return error response if ID is not provided
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
