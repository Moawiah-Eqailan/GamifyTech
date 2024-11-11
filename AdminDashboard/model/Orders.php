<?php
require_once "Database.php";


class order
{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getAllOrders() {
        $query = "
           SELECT o.order_id,CONCAT(u.user_first_name,' ' ,u.user_last_name) as user_name,c.coupon_name as order_coupon,c.coupon_discount as order_discount, o.order_date ,o.order_total, o.order_status
            from orders o
            JOIN users u on u.user_id=o.user_id
            JOIN coupons c on c.coupon_id=o.coupon_id
            ORDER BY o.order_id
";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function viewOrderDetails($orderId)
    {
       try {
    $query = "SELECT p.product_name as product_name ,oi.quantity as product_quantity ,p.product_price as price,(p.product_price * oi.quantity ) as total
    FROM order_items oi
    JOIN products p on oi.product_id= p.product_id
    where oi.order_id =:order_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the result after successful execution
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the exception message or handle it as needed
    echo "Error: " . $e->getMessage();
    return false;  // Return false or an appropriate response in case of an error
}

    }

    




}
// $order=new order();
// $order->viewOrderDetails(2);


?>