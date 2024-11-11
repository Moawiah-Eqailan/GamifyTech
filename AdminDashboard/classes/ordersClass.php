<?php
require_once "dbConnectionClass.php";


class order
{

    private $pdo;

    public function __construct()
    {
        // Using the existing PDO connection (singleton pattern)
        $this->pdo = dbConnection::getInstence()->getConnection();
    }

    public function getAllOrders() {
        $stmt = $this->pdo->prepare("
            SELECT o.order_id,CONCAT(u.user_first_name,' ' ,u.user_last_name) as user_name,c.coupon_name as order_coupon,c.coupon_discount as order_discount, o.order_date ,o.order_total, o.order_status
            from orders o
            JOIN users u on u.user_id=o.user_id
            JOIN coupons c on c.coupon_id=o.coupon_id
            ORDER BY o.order_id



        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}


?>