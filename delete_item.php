<?php
session_start();
include("includes/wishlistClass.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist_id'])) {
    $wishlist_id = (int) $_POST['wishlist_id'];
    $wishlist = new Wishlist();

    // Attempt soft deletion
    $success = $wishlist->softDeleteItem($wishlist_id);

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Item deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete the item.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
