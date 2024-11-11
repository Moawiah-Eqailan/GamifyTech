<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("db_class.php");

class Category {
    private $pdo;
    public function __construct()

    {
        // using the existing PDO (PHP data oject) connection (singlton pattern)
        $this->pdo =  dbConnection::getInstence()->getConnection();
        // echo 'connection yes';
    }    // get all categories and details of each one

    
    public function getAllCategories() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories where is_deleted=0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // get details for certain category
    public function getCategoryById($categoryId) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE is_deleted = 0 AND category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getProductsByCategoryId($categoryId) {
        $stmt = $this->pdo->prepare("SELECT products.*, categories.category_id
            FROM products 
            JOIN categories ON products.category_id = categories.category_id 
            WHERE categories.category_id = ? AND (products.is_deleted = 0 AND categories.is_deleted = 0)");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



?>
