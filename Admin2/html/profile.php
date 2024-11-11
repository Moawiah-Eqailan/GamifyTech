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
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
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
                                    <a class="btn btn-info" href="editProfile.php">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include 'includes/footer.php';
?>