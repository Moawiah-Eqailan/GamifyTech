<?php
session_start();
require_once 'model/Coupon.php';

$couponModel = new Coupon();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add_coupon') {
        // Adding a new coupon
        $name = $_POST['coupon_name'];
        $discount = $_POST['coupon_discount'];
        $expiry_date = $_POST['coupon_expiry_date'];
        $status = $_POST['coupon_status'];

        if ($couponModel->addCoupon( $name, $discount, $expiry_date, $status)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "Coupon added successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to add coupon."
            ];
        }
        header("Location: coupon.php");
        exit();
    } elseif ($_POST['action'] === 'edit_coupon') {
        // Editing an existing coupon
        $id = $_POST['coupon_id'];
        $name = $_POST['coupon_name'];
        $discount = $_POST['coupon_discount'];
        $expiry_date = $_POST['coupon_expiry_date'];
        $status = $_POST['coupon_status'];

        if ($couponModel->updateCoupon($id,$name, $discount, $expiry_date, $status)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "Coupon updated successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to update coupon."
            ];
        }
        header("Location: coupon.php");
        exit();
    } elseif ($_POST['action'] === 'delete_coupon') {
        // Deleting a coupon (soft delete)
        $id = $_POST['coupon_id'];

        if ($couponModel->deleteCoupon($id)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "Coupon deleted successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to delete coupon."
            ];
        }
        header("Location: coupon.php");
        exit();
    }
}
?>