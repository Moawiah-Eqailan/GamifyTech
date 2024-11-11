<?php
session_start();
// require_once 'model/Database.php';
include 'model/User.php';

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $email=trim($_POST['userLoginEmail']);
    $password=trim($_POST['userLoginPassword']);
    // var_dump($email . '  '. $password);
    $user=new User();
    $login=$user->login($email,$password);
        if($login=='success login')
            {
                $userByEmail=$user->getUserByEmail($email);
                $_SESSION['user_id']=$userByEmail['user_id'];
                $_SESSION['email']=$email;
                $_SESSION['user_role']=$userByEmail['user_role'];
                
                header('location: index.php');
                exit();
            
            }else
            {
                $_SESSION['error']=$login;
                header('location: login.php');
                exit();
            }

}else
{
    header('location: login.php');
    exit();
}

// echo $_SESSION['email'];
// echo $_SESSION['password']

?>