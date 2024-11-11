<?php
require_once 'Database.php';

class messages {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllMessages() {
        $query = "
            SELECT 
                c.contact_us_id,
                concat(u.user_first_name, ' ', u.user_last_name) as full_name,
                u.user_email,
                c.subject
            FROM 
                contact_us c
            JOIN 
                users u ON c.user_id = u.user_id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageDetails($contactUsId) {
        $query = "
            SELECT 
                c.contact_us_id, 
                concat(u.user_first_name, ' ', u.user_last_name) as full_name,
                u.user_email,
                c.subject, 
                c.message
            FROM 
                contact_us c
            JOIN 
                users u ON c.user_id = u.user_id
            WHERE 
                c.contact_us_id = :contact_us_id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':contact_us_id', $contactUsId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single message
    }
}
