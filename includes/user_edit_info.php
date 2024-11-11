<?php
require("db_class.php");
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['firstname'];
    $lName = $_POST['lastname'];
    $email = $_POST['useremail'];
    $address = $_POST['userbio'];
    $phoneNumber = $_POST['phone'];
    $password = $_POST['userpassword'];
    $user_id = $_POST['user_id'];

    $db = dbConnection::getInstence();
    $connect = $db->getConnection();
    $sql = "UPDATE `users` SET user_first_name = :first_name, user_last_name = :last_name, user_email = :email, 
            user_address = :address, user_phone_number = :phone, user_password = :password WHERE user_id = :user_id";

    $stmt = $connect->prepare($sql);

    $stmt->bindParam(':first_name', $name);
    $stmt->bindParam(':last_name', $lName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phoneNumber);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);


    if ($stmt->execute()) {
        // echo "Name: $name, Last Name: $lName, Email: $email, Address: $address, Phone: $phoneNumber, Password: $password, User ID: $user_id";
        header("Location: /NextLevelTech%20main%20main/profile.php");

        exit();
    } else {
        print_r($stmt->errorInfo());
        echo "Error executing query.";
    }
}
