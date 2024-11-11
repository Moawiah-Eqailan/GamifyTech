<?php
require_once 'dbConnectionClass.php';

class user
{
    private $pdo;
    public function __construct()

    {
        // using the existing PDO (PHP data oject) connection (singlton pattern)
        $this->pdo =  dbConnection::getInstence()->getConnection();
        // echo 'connection yes';
    }
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * from users WHERE is_deleted = 0 ORDER BY user_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function pageAllUsers($limit = 10, $offset = 0) {
        $query = "
            SELECT * 
            FROM users 
            WHERE is_deleted = 0
            LIMIT :limit OFFSET :offset"; // Limit and offset for pagination

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM users WHERE is_deleted = 0";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn(); // Fetch a single column value
    }



}






?>