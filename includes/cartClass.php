<?php


require_once "includes/db_class.php";



class Cart {
    private $pdo;
    public function __construct()

    {
        $this->pdo =  dbConnection::getInstence()->getConnection();
    }
    public function addToCart($user_id, $product_id, $quantity) {
    $checkOrderStmt = $this->pdo->prepare("SELECT order_id FROM orders WHERE user_id = ? AND order_status = 'pending'");
    $checkOrderStmt->execute([$user_id]);
    $orderId = $checkOrderStmt->fetchColumn();

    if (!$orderId) {
        $createOrderStmt = $this->pdo->prepare("INSERT INTO orders (user_id, order_date, order_total, order_status) VALUES (?, NOW(), 0, 'pending')");
        $createOrderStmt->execute([$user_id]);
        $orderId = $this->pdo->lastInsertId(); 
    }

    $checkProductStmt = $this->pdo->prepare("SELECT product_price FROM products WHERE product_id = ?");
    $checkProductStmt->execute([$product_id]);
    $productPrice = $checkProductStmt->fetchColumn();

    $checkItemStmt = $this->pdo->prepare("SELECT quantity FROM order_items WHERE order_id = ? AND product_id = ?");
    $checkItemStmt->execute([$orderId, $product_id]);
    $existingQuantity = $checkItemStmt->fetchColumn();

    if ($existingQuantity) {
        $updateItemStmt = $this->pdo->prepare("UPDATE order_items SET quantity = quantity + ? WHERE order_id = ? AND product_id = ?");
        $updateItemStmt->execute([$quantity, $orderId, $product_id]);
    } else {
        $insertItemStmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $insertItemStmt->execute([$orderId, $product_id, $quantity]);
    }

    $newOrderTotal = ($existingQuantity ? $existingQuantity + $quantity : $quantity) * $productPrice;
    $updateOrderTotalStmt = $this->pdo->prepare("UPDATE orders SET order_total = order_total + ? WHERE order_id = ?");
    $updateOrderTotalStmt->execute([$newOrderTotal, $orderId]);

    return true; 
}
    public function getCart($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT orders.order_id, order_items.product_id, order_items.quantity, 
                products.product_name, products.product_picture, products.product_price
            FROM orders
            JOIN order_items ON orders.order_id = order_items.order_id
            JOIN products ON order_items.product_id = products.product_id
            WHERE orders.user_id = ? AND orders.order_status = 'pending'
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCartQuantity($user_id, $product_id, $new_quantity) {
        $checkOrderStmt = $this->pdo->prepare("SELECT order_id FROM orders WHERE user_id = ? AND order_status = 'pending'");
        $checkOrderStmt->execute([$user_id]);
        $orderId = $checkOrderStmt->fetchColumn();
    
        if ($orderId) {
            $updateQuantityStmt = $this->pdo->prepare("UPDATE order_items SET quantity = ? WHERE order_id = ? AND product_id = ?");
            $updateQuantityStmt->execute([$new_quantity, $orderId, $product_id]);
        }
    }
    

    public function removeFromCart($user_id, $product_id) {
        $checkOrderStmt = $this->pdo->prepare("SELECT order_id FROM orders WHERE user_id = ? AND order_status = 'pending'");
        $checkOrderStmt->execute([$user_id]);
        $orderId = $checkOrderStmt->fetchColumn();

        if ($orderId) {
            $deleteItemStmt = $this->pdo->prepare("DELETE FROM order_items WHERE order_id = ? AND product_id = ?");
            $deleteItemStmt->execute([$orderId, $product_id]);

            $checkRemainingItemsStmt = $this->pdo->prepare("SELECT COUNT(*) FROM order_items WHERE order_id = ?");
            $checkRemainingItemsStmt->execute([$orderId]);
            $remainingItemsCount = $checkRemainingItemsStmt->fetchColumn();

            if ($remainingItemsCount == 0) {
                $deleteOrderStmt = $this->pdo->prepare("DELETE FROM orders WHERE order_id = ?");
                $deleteOrderStmt->execute([$orderId]);
            }
        }
    }


    public function checkout($user_id) {
        $checkOrderStmt = $this->pdo->prepare("SELECT order_id FROM orders WHERE user_id = ? AND order_status = 'pending'");
        $checkOrderStmt->execute([$user_id]);
        $orderId = $checkOrderStmt->fetchColumn();
    
        if ($orderId) {
            $updateOrderStmt = $this->pdo->prepare("UPDATE orders SET order_status = 'delivered' WHERE order_id = ?");
            $updateOrderStmt->execute([$orderId]);
            return true; 
        }
    
        return false; 
}



public function getOrderHistory($user_id) {
    $stmt = $this->pdo->prepare("SELECT o.order_id, o.order_date, o.order_total, o.order_status,
                                    oi.product_id, oi.quantity, p.product_name, p.product_picture
                            FROM orders o
                            JOIN order_items oi ON o.order_id = oi.order_id
                            JOIN products p ON oi.product_id = p.product_id
                            WHERE o.user_id = ? AND o.order_status != 'pending'");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getOrderHistoryDetailed($userId) {
    $sql = "
        SELECT 
            o.order_id, o.order_date, o.coupon_id, o.order_total, o.order_status,
            oi.order_item_id, oi.product_id, oi.quantity, p.product_name, p.product_price
        FROM orders AS o
        JOIN order_items AS oi ON o.order_id = oi.order_id
        JOIN products AS p ON oi.product_id = p.product_id
        WHERE o.user_id = :user_id
        ORDER BY o.order_date DESC, o.order_id
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    $orders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Check if this order_id already exists in the orders array
        if (!isset($orders[$row['order_id']])) {    
            $orders[$row['order_id']] = [
                'order_date' => $row['order_date'],
                'coupon_id' => $row['coupon_id'],
                'order_total' => $row['order_total'],
                'order_status' => $row['order_status'],
                'items' => [],
            ];
        }
        
        // Add item to the specific order
        $orders[$row['order_id']]['items'][] = [
            'order_item_id' => $row['order_item_id'],
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'price' => $row['product_price']
        ];
    }

    // Check if there are multiple items with the same order_id
    foreach ($orders as $orderId => $order) {
        $orderItems = $order['items'];
        $orderIds = array_column($orderItems, 'order_item_id');
        
        // Verify if there are duplicate order_item_ids (indicating the same order ID in different items)
        if (count($orderItems) != count(array_unique($orderIds))) {
            // Handle duplicate items if needed (e.g., log an error, notify user)
            echo "Duplicate order_item_id found for order ID $orderId\n";
        }
    }

    return $orders;
}





public function applyCoupon($couponCode, $userId) {
    // Fetch coupon details from the database
    $stmt = $this->pdo->prepare("
        SELECT coupon_discount, coupon_expiry_date 
        FROM coupons 
        WHERE coupon_name = ? 
          AND coupon_status = 1 
          AND is_deleted = 0 
          AND coupon_expiry_date >= NOW()
    ");
    $stmt->execute([$couponCode]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        // Calculate the discount amount on the cart's total price
        $cartItems = $this->getCart($userId);
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item['product_price'] * $item['quantity'];
        }

        // Calculate discount amount
        $discountAmount = ($totalPrice * $coupon['coupon_discount']) / 100;
        $newTotal = $totalPrice - $discountAmount;

        return [
            'success' => true,
            'new_total' => $newTotal,
            'discount' => $discountAmount,
        ];
    }

    return [
        'success' => false,
        'message' => 'Invalid coupon code or coupon expired.',
    ];
}




private function getPendingOrderId($userId) {
    $stmt = $this->pdo->prepare("SELECT order_id FROM orders WHERE user_id = ? AND order_status = 'pending'");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
}



public function placeOrder($userId, $totalAmount, $address, $paymentMethod) {
    try {
        $query = "INSERT INTO orders (user_id, total_amount, address, payment_method, order_date) 
                VALUES (:user_id, :total_amount, :address, :payment_method, NOW())";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":total_amount", $totalAmount);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":payment_method", $paymentMethod);
        $stmt->execute();

        return $this->pdo->lastInsertId();  
    } catch (PDOException $e) {
        throw new Exception("Order placement failed: " . $e->getMessage());
    }
}



function getCartCategoryId($cartProductIds) {
    if (empty($cartProductIds)) {
        return null; 
    }

    $placeholders = implode(',', array_fill(0, count($cartProductIds), '?'));
    $query = "SELECT DISTINCT p.category_id 
              FROM products p
              JOIN order_items oi ON p.product_id = oi.product_id
              WHERE oi.product_id IN ($placeholders) 
              AND p.is_deleted = 0";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($cartProductIds);

    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo "No category found for the provided product IDs: " . implode(', ', $cartProductIds);
    }

    return $category['category_id'] ?? null;
}



}


?>