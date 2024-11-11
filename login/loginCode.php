<?php
session_start();
include('../includes/db_class.php');
include ('../includes/usersClass.php');

$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
$hashedPassword= password_hash($password,PASSWORD_DEFAULT);
if (password_verify($password,$hashedPassword)) {
    if ($user->login($email, $password)) {
        header("Location:../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password."; 
        header("Location: login.php");
        exit();
    }
}

}
// if ($user->login($email, $password)) {
//     header("Location:../index.php");
//     exit();
// } else {
//     $_SESSION['error'] = "Invalid email or password."; 
//     header("Location: login.php");
//     exit();
// }

