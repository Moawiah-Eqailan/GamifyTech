<?php
// File: model/Product.php
// File: model/Product.php
require_once 'Database.php';

class Product {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Updated getAllProducts method with pagination support
    public function getAllProducts() {
        $query = "
            SELECT p.*, c.category_name as product_category
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.category_id 
            WHERE p.is_deleted = 0
            order by product_id 
            "; // Limit and offset for pagination
    
        $stmt = $this->conn->prepare($query);
   
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get the total number of products
    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total FROM products WHERE is_deleted =0  ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function createProduct($name, $description, $image, $categoryId, $quantity, $price,$discount, $status) {
        $sql = "INSERT INTO products (product_name, product_description, product_picture, category_id, product_quantity, product_price,product_discount, product_state) 
                VALUES (:name, :description, :image, :categoryId, :quantity, :price,:discount,:status)";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $image, $categoryId, $quantity, $price,$discount, $status) {
        $sql = "UPDATE products SET 
                product_name = :name, 
                product_description = :description, 
                product_picture = :image, 
                category_id = :categoryId, 
                product_quantity = :quantity, 
                product_price = :price, 
                product_discount = :discount, 
                product_state = :status 
                WHERE product_id = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function softDeleteProduct($productId) {
        $query = "UPDATE products SET is_deleted = 1 WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getProductById($productId) {
        $query = "SELECT * FROM products WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>