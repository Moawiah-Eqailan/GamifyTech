<?php

class User {
    private $pdo;
    public function __construct()

    {
        // using the existing PDO (PHP data oject) connection (singlton pattern)
        $this->pdo =  dbConnection::getInstence()->getConnection();
        // echo 'connection yes';
    }

    public function register($firstName, $lastName, $email, $password, $gender, $dob, $address, $phoneNumber) {
        $sql = "INSERT INTO users (user_first_name, user_last_name, user_gender, user_birth_date, user_address, user_phone_number, user_email, user_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $lastName);
        $stmt->bindParam(3, $gender);
        $stmt->bindParam(4, $dob);
        $stmt->bindParam(5, $address);
        $stmt->bindParam(6, $phoneNumber);
        $stmt->bindParam(7, $email);
        $stmt->bindParam(8, $password);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE user_email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        
        if ($user) {
            if (password_verify($password, $user['user_password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_email'] = $user['user_email'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    

    public function displayUserById($user_id) {
        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function resetPassword($email, $newPassword, $confirmPassword) {
        if ($newPassword !== $confirmPassword) {
            return ["error" => "The password does not match."];
        }
    
        $sql = "UPDATE users SET user_password = :password WHERE user_email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':email', $email);
    
        if ($stmt->execute()) {
            return ["success" => "The password has been updated successfully."];
        } else {
            return ["error" => "An error occurred while updating the password."];
        }
    }
    

};

