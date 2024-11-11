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
    public function updateOrderStatus($orderId, $newStatus) {
        // Define allowed values for the ENUM column in the database
        $allowedStatuses = ['pending', 'cancelled', 'delivered'];
    
        // Validate that the new status is one of the allowed values
        if (!in_array($newStatus, $allowedStatuses)) {
            return ['success' => false, 'message' => 'Invalid order status provided'];
        }
    
        try {
            // Prepare the SQL query to update the order status
            $query = "UPDATE orders SET order_status = :newStatus WHERE order_id = :orderId";
            $stmt = $this->conn->prepare($query);
    
            // Bind the parameters to prevent SQL injection
            $stmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    
            // Execute the query
            $stmt->execute();
    
            // Check if any rows were updated (this also means the order exists)
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Order status updated successfully'];
            } else {
                // If no rows were updated, the order ID might not exist
                return ['success' => false, 'message' => 'Order ID not found or status is the same'];
            }
        } catch (PDOException $e) {
            // Log and return the database error
            error_log("Error: " . $e->getMessage()); // You can log the error for debugging
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
    public function getTotalSales() {
        $query = "SELECT SUM(order_total) AS total_sales
                  FROM orders               
                WHERE order_status IN ('delivered', 'pending')"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sales'] ? (float)$result['total_sales'] : 0; 
    }

    public function getOrderCount() {
        $query = "SELECT COUNT(order_id) AS total_orders FROM orders";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_orders'] ? (int)$result['total_orders'] : 0; // Return total orders or 0 if none
    }

    // public function getLastMonthSales() {
    //     $query = "
    //         SELECT 
    //             DATE_FORMAT(order_date, '%Y-%m') AS month, 
    //             SUM(order_total) AS total_sales 
    //         FROM orders 
    //         WHERE order_date >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01')
    //         AND order_date < DATE_FORMAT(CURDATE(), '%Y-%m-01')
    //         GROUP BY month
    //     ";
    
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
    
    //     $lastMonthSales = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return [
    //         'month' => $lastMonthSales['month'] ?? null,
    //         'total_sales' => $lastMonthSales['total_sales'] ? (float)$lastMonthSales['total_sales'] : 0,
    //     ];
    // }
    

    
    

    




}
// $order=new order();
// var_dump($order->getTotalSales());


?>