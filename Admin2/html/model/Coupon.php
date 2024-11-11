<?php
require_once 'Database.php'; 

class Coupon {
    private $conn;



    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }




    public function getAllCoupons() {
        $query = "SELECT * FROM coupons WHERE is_deleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addCoupon($name, $discount, $expiry_date, $status) {
        $query = "INSERT INTO coupons (coupon_name, coupon_discount, coupon_expiry_date, coupon_status) VALUES (:name, :discount, :expiry_date, :status)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }



    public function updateCoupon($id, $name, $discount, $expiry_date, $status) {
        $query = "UPDATE coupons SET coupon_name = :name, coupon_discount = :discount, coupon_expiry_date = :expiry_date, coupon_status = :status WHERE coupon_id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }


    public function deleteCoupon($id) {
    $query = "UPDATE coupons SET is_deleted = 1 WHERE coupon_id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

public function updateExpiredCoupons() {
    $stmt = $this->conn->prepare("UPDATE coupons SET coupon_status = 'Invalid' WHERE coupon_expiry_date < CURDATE() AND 'Valid' = valid");
    $stmt->execute();
    return $stmt->rowCount();
}

// update this copy to github
}
?>