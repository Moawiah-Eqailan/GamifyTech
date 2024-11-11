<?php
session_start();
require_once '../model/User.php'; // Include your User model

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $userData = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'mobile' => $_POST['mobile'],
        'address' => $_POST['address'],
        'user_id' => $_SESSION['user_id'] // Use the session user_id directly
    ];

    // Create an instance of the User class
    $user = new User();

    // Update user profile with the provided data
    $updateSuccess = $user->updateUser($userData);

    // Check if the update was successful
    if ($updateSuccess) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: ../profile.php");
    } else {
        $_SESSION['error'] = "Failed to update profile!";
        header("Location: ../profile.php");
    }
    exit();
}
?>
