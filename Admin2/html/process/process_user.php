<?php
require_once '../model/User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User(); // Create a new User object

    // Check for create user action
    if (isset($_POST['newEmail'])) {
        // First, check if the email already exists
        if ($user->emailExists($_POST['newEmail'])) {
            $_SESSION['sweetalert'] = [
                "type" => "warning",
                "message" => "This email is already in use."
            ];
            // Redirect back to the form with an error message
            header("Location: ../users.php");
            exit; // Stop further processing
        }

        // Prepare data for user creation
        $data = [
            'first_name' => $_POST['newFirstName'],
            'last_name' => $_POST['newLastName'],
            'email' => $_POST['newEmail'],
            'gender' => $_POST['newGender'],
            'birth_date' => $_POST['newBirthDate'],
            'phone' => $_POST['newPhone'],
            'address' => $_POST['newAddress'],
            'state' => $_POST['newState'],
            'role' => $_POST['newRole']
        ];

        // Attempt to create a new user
        if ($user->createUser($data)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "User created successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to create user."
            ];
        }
        header("Location: ../users.php");
        exit();
    }

    if (isset($_POST['deleteUserId'])) {
        $userId = intval($_POST['deleteUserId']);
        $user->softDeleteUser($userId);
        $_SESSION['success'] = "User deleted successfully!";
        header("Location: ../users.php");
        exit();
    }

    // Check for edit user action
    if (isset($_POST['editUserId'])) {
        $data = [
            'user_id' => $_POST['editUserId'],
            'first_name' => $_POST['editFirstName'],
            'last_name' => $_POST['editLastName'],
            'email' => $_POST['editEmail'],
            'gender' => $_POST['editGender'],
            'birth_date' => $_POST['editBirthDate'],
            'phone' => $_POST['editPhone'],
            'address' => $_POST['editAddress'],
            'state' => $_POST['editState'],
            'role' => $_POST['editRole']
        ];

        // Attempt to update the user
        if ($user->updateUser($data)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "User updated successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to update user."
            ];
        }
        header("Location: ../users.php");
        exit();
    }
}
?>
