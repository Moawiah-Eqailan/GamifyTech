<?php
require_once 'Database.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllUsers() {
        $query = "
            SELECT * 
            FROM users 
            WHERE is_deleted = 0
            "; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    public function softDeleteUser($user_id) {
        $query = "UPDATE " . $this->table_name . " SET is_deleted = 1 WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE user_email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Return true if email exists
    }

    public function createUser($data) {
        $query = "INSERT INTO " . $this->table_name . " (user_first_name, user_last_name, user_email, user_gender,user_birth_date, user_phone_number, user_address, user_status, user_role) VALUES (:first_name, :last_name, :email, :gender, :birth_date, :phone, :address, :state, :role)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':state', $data['state']);
        $stmt->bindParam(':role', $data['role']);

        return $stmt->execute();
    }

    public function updateUser($data) {
        $query = "UPDATE " . $this->table_name . " SET 
                  user_first_name = :first_name, 
                  user_last_name = :last_name, 
                  user_email = :email, 
                  user_gender = :gender, 
                 user_birth_date = :birth_date, 
                  user_phone_number = :phone, 
                  user_address = :address, 
                  user_status = :state, 
                  user_role = :role 
                  WHERE user_id = :user_id";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':state', $data['state']);
        $stmt->bindParam(':role', $data['role']);
        echo $data['role'];
        $stmt->bindParam(':user_id', $data['user_id']); // Bind user_id for the WHERE clause
    
        return $stmt->execute(); // Execute and return true/false
    }

    public function login($email, $password) {

        $userData = $this->getUserByEmail($email); 

        if ($userData) {

            if ($password == $userData['user_password']) {
                if (!($userData['user_role'] === 'Admin' || $userData['user_role'] === 'superAdmin')) {
                    return "Unauthorized access: You do not have permission to log in.";
                }
               {

                    return "success login"; 
               }
            } else {
                return "Invalid email or password."; 
            }
        } else {
            return "User not found."; 
        }
    }


    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = :user_id AND is_deleted = 0");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function countActiveUsers() {
        $query = "
            SELECT COUNT(*) 
            FROM users 
            WHERE user_status = 'active' 
            AND is_deleted = 0 
            AND user_role = 'customer'
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>
