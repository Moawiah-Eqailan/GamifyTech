<?php
require_once 'dbConnectionClass.php';


class Product
{
    private $pdo;

    public function __construct()
    {
        // Using the existing PDO connection (singleton pattern)
        $this->pdo = dbConnection::getInstence()->getConnection();
    }

    public function getAllProducts() {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.category_id 
           WHERE p.is_deleted=0
           order by p.product_id
        
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new product
    public function addNewProduct($name, $description, $price, $categoryId, $quantity, $picturePath)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO products (product_name, product_description, product_price, category_id, product_quantity, product_picture) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $description, $price, $categoryId, $quantity, $picturePath]);
    }

    // Update product
    public function updateProduct($id, $name, $description, $price, $discount, $categoryId, $quantity, $picture)
    {
        if ($picture) {
            $stmt = $this->pdo->prepare("
                UPDATE products 
                SET 
                    product_name = ?, 
                    product_description = ?, 
                    product_price = ?, 
                    product_discount = ?, 
                    category_id = ?, 
                    product_quantity = ?, 
                    product_picture = ? 
                WHERE product_id = ?
                
            ");
            
            return $stmt->execute([$name, $description, $price, $discount, $categoryId, $quantity, $picture, $id]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE products 
                SET 
                    product_name = ?, 
                    product_description = ?, 
                    product_price = ?, 
                    product_discount = ?, 
                    category_id = ?, 
                    product_quantity = ? 
                WHERE product_id = ?
            ");
            
            return $stmt->execute([$name, $description, $price, $discount, $categoryId, $quantity, $id]);
        }
    }

    // Soft-delete product
    public function SoftDeleteProduct($id)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET is_deleted = 1 WHERE product_id = ?");
        return $stmt->execute([$id]);
    }
}


// $product=new Product();
// $id
// $product->SoftDeleteProduct($id);



?>