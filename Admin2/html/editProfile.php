<?php
// ob_start(); // Start output buffering
session_start(); // Ensure the session is started

require_once 'model/User.php';
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'How did you get here without logging in!';
    header("location: login.php");
    exit();
} else {
    include 'includes/header.php'; // Include your header file
    $user_id = $_SESSION['user_id'];
    $user = new User();
    $userDetails = $user->getUserById($user_id);
    
    if (!$userDetails) {
        echo "Error fetching user details.";
        exit();
    }
}
?>
<div class="page-wrapper">
<div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="img/adminpic.jpg" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?php echo htmlspecialchars($userDetails['user_first_name'] . ' ' . $userDetails['user_last_name']); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="POST" action="process/updateProfile.php"> <!-- Assuming you have an update profile script -->
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">First Name</h6>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($userDetails['user_first_name']); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Last Name</h6>
                                </div>
                                <div class="col-sm-9 ">
                                    <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($userDetails['user_last_name']); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 ">
                                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($userDetails['user_email']); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 ">
                                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($userDetails['user_phone_number']); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 ">
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($userDetails['user_address']); ?>">
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 ">
                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
        </div>
</div>










<?php

include 'includes/footer.php';
?>