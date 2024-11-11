<?php
require_once ("db_class.php");

class Product {
    private $pdo;
    public function __construct()

    {
        // using the existing PDO (PHP data oject) connection (singlton pattern)
        $this->pdo =  dbConnection::getInstence()->getConnection();
        // echo 'connection yes';
    }

    public function getTotalProducts() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE is_deleted = 0");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
        // Fetch all products
        public function getAllProducts($page = 1, $productsPerPage = 8) {
            // Calculate the offset based on the current page
            $offset = ($page - 1) * $productsPerPage;
        
            $stmt = $this->pdo->prepare("
                SELECT products.*, categories.category_name
                FROM products
                JOIN categories ON products.category_id = categories.category_id
                WHERE products.is_deleted = 0
                LIMIT :limit OFFSET :offset
            ");
            
            // Bind the limit and offset to the query
            $stmt->bindParam(':limit', $productsPerPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            
            // Execute the query
            $stmt->execute();
        
            // Return the fetched products
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

    public function getProductById($productId) {
        $stmt = $this->pdo->prepare("
        SELECT products.*, categories.category_name
        FROM products
        JOIN categories ON products.category_id = categories.category_id
        WHERE products.is_deleted = 0 AND product_id = ?
    ");
    
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch products by categories
    public function getProductsBycategories($categoriesId) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE products.is_deleted = 0 AND category_id = ?");
        $stmt->execute([$categoriesId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //fetch trending products based on rating
    public function fetchTrendingProducts() {
        $stmt = $this->pdo->prepare("
            SELECT products.*, categories.category_name
            FROM products
            JOIN categories ON products.category_id = categories.category_id
            WHERE products.is_deleted = 0
            ORDER BY products.product_rate DESC
            LIMIT 8
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
        public function fetchHighestDiscountProducts() {
        $stmt = $this->pdo->prepare("
            SELECT products.*, categories.category_name
        FROM products
        JOIN categories ON products.category_id = categories.category_id
        WHERE products.is_deleted = 0
        ORDER BY products.product_quantity 
        LIMIT 3
        ");
        $stmt->execute();
        $fetch=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $fetch;
    }

    public function lastProduct() {
        $stmt = $this->pdo->prepare("
            SELECT * 
            FROM products 
            WHERE products.is_deleted = 0 
            ORDER BY product_id DESC 
            LIMIT 2
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    public function fetchHighestDiscountProduct() {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE products.is_deleted = 0 ORDER BY product_discount DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function fetchFlashSaleProducts() {
        $stmt = $this->pdo->prepare("
            SELECT products.*, categories.category_name AS product_category 
            FROM products 
            JOIN categories ON products.category_id = categories.category_id 
            WHERE products.product_discount > 0 AND products.is_deleted = 0
            ORDER BY products.product_discount DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function fetchRandomProducts($limit = 2) {
        $stmt = $this->pdo->prepare("SELECT * FROM products ORDER BY RAND() LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //function to get recommended products
    function getRecommendedProducts($categoryId, $cartProductIds) {
        if (empty($cartProductIds)) {
            return [];
        }
    
        $placeholders = implode(',', array_fill(0, count($cartProductIds), '?'));
        $query = "SELECT * FROM products 
                  WHERE category_id = ? 
                  AND product_id NOT IN ($placeholders) 
                  AND is_deleted = 0
                  LIMIT 4";

        $stmt = $this->pdo->prepare($query);
    
        $params = array_merge([$categoryId], $cartProductIds);
    
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchTopSellingProducts() {
        $stmt = $this->pdo->prepare("
            SELECT products.*, categories.category_name, SUM(order_items.quantity) AS total_sold
            FROM products
            JOIN order_items ON products.product_id = order_items.product_id
            JOIN categories ON products.category_id = categories.category_id
            WHERE products.is_deleted = 0
            GROUP BY products.product_id
            ORDER BY total_sold DESC
            LIMIT 8
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}

?>