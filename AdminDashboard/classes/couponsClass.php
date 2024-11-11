<?php
require_once "dbConnectionClass.php";

class coupon
{
    private $pdo;
    public function __construct()

    {
        // using the existing PDO (PHP data oject) connection (singlton pattern)
        $this->pdo =  dbConnection::getInstence()->getConnection();
        // echo 'connection yes';
    }
    public function getAllCoupons()
    {
        $stmt = $this->pdo->query("SELECT * from coupons WHERE is_deleted = 0 ORDER BY coupon_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addNewCoupon($name,$discount,$expiryDate,$status)
    {
        $stmt =$this->pdo->prepare("INSERT INTO coupons(coupon_name, coupon_discount, coupon_expiry_date, coupon_status)VALUES(?,?,?,?)");
        return $stmt->execute([$name,$discount,$expiryDate,$status]);
    }
    public function SoftDeleteCoupon($id)
    {
        $stmt = $this->pdo->prepare("UPDATE coupons SET is_deleted = 1 WHERE coupon_id = ?");
        return $stmt->execute([$id]);
    }
}

?>