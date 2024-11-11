<?php
class Database {
    private $host = 'localhost'; // Change if your database is hosted elsewhere
    private $db_name = 'gameshop';
    private $username = 'root'; // Your database username
    private $password = ''; // Your database password
    public $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
