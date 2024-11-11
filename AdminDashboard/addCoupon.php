<?php
include "classes/couponsClass.php";



if (isset($_POST['add_coupon'])) {
    // Retrieve form data
    $coupon_name = $_POST['coupon_name'];
    $coupon_discount = $_POST['coupon_discount'];
    $coupon_expiry_date = $_POST['coupon_expiry_date'];
    $coupon_status = $_POST['coupon_status']; // Assuming coupon_status is passed as 1 for active or 0 for inactive

    // echo ($coupon_status." status");

    // Initialize the Coupon class
    $coupon = new coupon();

    // Call the method to add a new coupon
    $result = $coupon->addNewCoupon($coupon_name, $coupon_discount, $coupon_expiry_date, $coupon_status);

    if ($result) {
        // Redirect with a success message
        header("location: coupons.php?status=success");
        exit();
    } else {
        // Redirect with an error message if adding the coupon fails
        header("location: coupons.php?status=error");
        exit();
    }
} else {
    // Redirect if the form is not submitted correctly
    header("location: coupons.php?status=form_error");
    exit();
}

?>