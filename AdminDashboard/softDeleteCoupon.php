<?php
// soft_delete_category.php
include "classes/couponsClass.php";

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);
$coupon_id = $data['coupon_id'];

$coupon = new coupon();

// Call the soft delete method
if ($coupon->SoftDeleteCoupon($coupon_id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>