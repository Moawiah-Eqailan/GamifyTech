<?php
session_start();  // Make sure this is the first line of the script

require_once 'model/User.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'How did you get here without logging in!';
    header("location: login.php");
    exit();
} else {
    include 'includes/header.php';
    $user_id = $_SESSION['user_id'];
    $user = new User();
    $userDetails = $user->getUserById($user_id);
    
    if (!$userDetails) {
        echo "Error fetching user details.";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>User Profile</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="main-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"style=" color: #858796;"><a style=" color: #858796;" href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="img/adminpic.jpg" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4><?= htmlspecialchars($userDetails['user_first_name'] . ' ' . $userDetails['user_last_name']); ?></h4>
                                    <p class="mb-1"><?=$userDetails['user_role']?></p>
                                    <p class=" font-size-sm">
                                      <?=htmlspecialchars($userDetails['user_address']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Example of displaying static data; replace with dynamic if needed -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 ">
                                    <?= htmlspecialchars($userDetails['user_first_name'] . ' ' . $userDetails['user_last_name']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 ">
                                    <?= htmlspecialchars($userDetails['user_email']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 ">
                                    <?= htmlspecialchars($userDetails['user_phone_number']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9">
                                    <?= htmlspecialchars($userDetails['user_address']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-info" href="editAdminProfile.php">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include JavaScript files -->
</body>
</html>
