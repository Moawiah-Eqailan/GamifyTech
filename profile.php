<?php
session_start();

ob_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login/login.php");
  exit();
}

include('includes/db_class.php');
include('includes/usersClass.php');
include('includes/cartClass.php');

$userId = $_SESSION['user_id'];

$user = new User();

$userData = $user->displayUserById($userId);

if ($userData) {
  $fName = htmlspecialchars($userData['user_first_name']);
  $lName = htmlspecialchars($userData['user_last_name']);
  $fullName = htmlspecialchars($userData['user_first_name'] . ' ' . $userData['user_last_name']);
  $phoneNumber = htmlspecialchars($userData['user_phone_number']);
  $email = htmlspecialchars($userData['user_email']);
  $address = htmlspecialchars($userData['user_address']);
  $gender = htmlspecialchars($userData['user_gender']);
}

$cart = new Cart(); 

$orderHistory = $cart->getOrderHistory($userId);

// Group order items by order_id
$groupedOrders = [];

foreach ($orderHistory as $order) {
    $groupedOrders[$order['order_id']][] = $order;
}

?>

<title>My profile | GamifyTech</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
  body {
    color: #6c757d;
    background-color: #f5f6f8;
  }

  .card-box {
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e7eaed;
    padding: 1.5rem;
    margin-bottom: 24px;
    border-radius: .25rem;
  }

  .avatar-xl {
    height: 6rem;
    width: 6rem;
  }

  .rounded-circle {
    border-radius: 50% !important;
  }

  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #1abc9c;
  }

  .nav-pills .nav-link {
    border-radius: .25rem;
  }

  .navtab-bg li>a {
    background-color: #f7f7f7;
    margin: 0 5px;
  }

  .nav-pills>li>a,
  .nav-tabs>li>a {
    color: #6c757d;
    font-weight: 600;
  }

  .mb-4,
  .my-4 {
    margin-bottom: 2.25rem !important;
  }

  .tab-content {
    padding: 20px 0 0 0;
  }

  .progress-sm {
    height: 5px;
  }

  .m-0 {
    margin: 0 !important;
  }

  .table .thead-light th {
    color: #6c757d;
    background-color: #f1f5f7;
    border-color: #dee2e6;
  }

  .social-list-item {
    height: 2rem;
    width: 2rem;
    line-height: calc(2rem - 4px);
    display: block;
    border: 2px solid #adb5bd;
    border-radius: 50%;
    color: #adb5bd;
  }

  .text-purple {
    color: #6559cc !important;
  }

  .border-purple {
    border-color: #6559cc !important;
  }

  .timeline {
    margin-bottom: 50px;
    position: relative;
  }

  .timeline:before {
    background-color: #dee2e6;
    bottom: 0;
    content: "";
    left: 50%;
    position: absolute;
    top: 30px;
    width: 2px;
    z-index: 0;
  }

  .timeline .time-show {
    margin-bottom: 30px;
    margin-top: 30px;
    position: relative;
  }

  .timeline .timeline-box {
    background: #fff;
    display: block;
    margin: 15px 0;
    position: relative;
    padding: 20px;
  }

  .timeline .timeline-album {
    margin-top: 12px;
  }

  .timeline .timeline-album a {
    display: inline-block;
    margin-right: 5px;
  }

  .timeline .timeline-album img {
    height: 36px;
    width: auto;
    border-radius: 3px;
  }

  @media (min-width: 768px) {
    .timeline .time-show {
      margin-right: -69px;
      text-align: right;
    }

    .timeline .timeline-box {
      margin-left: 45px;
    }

    .timeline .timeline-icon {
      background: #dee2e6;
      border-radius: 50%;
      display: block;
      height: 20px;
      left: -54px;
      margin-top: -10px;
      position: absolute;
      text-align: center;
      top: 50%;
      width: 20px;
    }

    .timeline .timeline-icon i {
      color: #98a6ad;
      font-size: 13px;
      position: absolute;
      left: 4px;
    }

    .timeline .timeline-desk {
      display: table-cell;
      vertical-align: top;
      width: 50%;
    }

    .timeline-item {
      display: table-row;
    }

    .timeline-item:before {
      content: "";
      display: block;
      width: 50%;
    }

    .timeline-item .timeline-desk .arrow {
      border-bottom: 12px solid transparent;
      border-right: 12px solid #fff !important;
      border-top: 12px solid transparent;
      display: block;
      height: 0;
      left: -12px;
      margin-top: -12px;
      position: absolute;
      top: 50%;
      width: 0;
    }

    .timeline-item.timeline-item-left:after {
      content: "";
      display: block;
      width: 50%;
    }

    .timeline-item.timeline-item-left .timeline-desk .arrow-alt {
      border-bottom: 12px solid transparent;
      border-left: 12px solid #fff !important;
      border-top: 12px solid transparent;
      display: block;
      height: 0;
      left: auto;
      margin-top: -12px;
      position: absolute;
      right: -12px;
      top: 50%;
      width: 0;
    }

    .timeline-item.timeline-item-left .timeline-desk .album {
      float: right;
      margin-top: 20px;
    }

    .timeline-item.timeline-item-left .timeline-desk .album a {
      float: right;
      margin-left: 5px;
    }

    .timeline-item.timeline-item-left .timeline-icon {
      left: auto;
      right: -56px;
    }

    .timeline-item.timeline-item-left:before {
      display: none;
    }

    .timeline-item.timeline-item-left .timeline-box {
      margin-right: 45px;
      margin-left: 0;
      text-align: right;
    }
  }

  @media (max-width: 767.98px) {
    .timeline .time-show {
      text-align: center;
      position: relative;
    }

    .timeline .timeline-icon {
      display: none;
    }
  }

  .timeline-sm {
    padding-left: 110px;
  }

  .timeline-sm .timeline-sm-item {
    position: relative;
    padding-bottom: 20px;
    padding-left: 40px;
    border-left: 2px solid #dee2e6;
  }

  .timeline-sm .timeline-sm-item:after {
    content: "";
    display: block;
    position: absolute;
    top: 3px;
    left: -7px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #1abc9c;
  }

  .timeline-sm .timeline-sm-item .timeline-sm-date {
    position: absolute;
    left: -104px;
  }

  @media (max-width: 420px) {
    .timeline-sm {
      padding-left: 0;
    }

    .timeline-sm .timeline-sm-date {
      position: relative !important;
      display: block;
      left: 0 !important;
      margin-bottom: 10px;
    }
  }




  .steps {
    border: 1px solid #e7e7e7
  }

  .steps-header {
    padding: .375rem;
    border-bottom: 1px solid #e7e7e7
  }

  .steps-header .progress {
    height: .25rem
  }

  .steps-body {
    display: table;
    table-layout: fixed;
    width: 100%
  }

  .step {
    display: table-cell;
    position: relative;
    padding: 1rem .75rem;
    -webkit-transition: all 0.25s ease-in-out;
    transition: all 0.25s ease-in-out;
    border-right: 1px dashed #dfdfdf;
    color: rgba(0, 0, 0, 0.65);
    font-weight: 600;
    text-align: center;
    text-decoration: none
  }

  .step:last-child {
    border-right: 0
  }

  .step-indicator {
    display: block;
    position: absolute;
    top: .75rem;
    left: .75rem;
    width: 1.5rem;
    height: 1.5rem;
    border: 1px solid #e7e7e7;
    border-radius: 50%;
    background-color: #fff;
    font-size: .875rem;
    line-height: 1.375rem
  }

  .has-indicator {
    padding-right: 1.5rem;
    padding-left: 2.375rem
  }

  .has-indicator .step-indicator {
    top: 50%;
    margin-top: -.75rem
  }

  .step-icon {
    display: block;
    width: 1.5rem;
    height: 1.5rem;
    margin: 0 auto;
    margin-bottom: .75rem;
    -webkit-transition: all 0.25s ease-in-out;
    transition: all 0.25s ease-in-out;
    color: #888
  }

  .step:hover {
    color: rgba(0, 0, 0, 0.9);
    text-decoration: none
  }

  .step:hover .step-indicator {
    -webkit-transition: all 0.25s ease-in-out;
    transition: all 0.25s ease-in-out;
    border-color: transparent;
    background-color: #f4f4f4
  }

  .step:hover .step-icon {
    color: rgba(0, 0, 0, 0.9)
  }

  .step-active,
  .step-active:hover {
    color: rgba(0, 0, 0, 0.9);
    pointer-events: none;
    cursor: default
  }

  .step-active .step-indicator,
  .step-active:hover .step-indicator {
    border-color: transparent;
    background-color: #5c77fc;
    color: #fff
  }

  .step-active .step-icon,
  .step-active:hover .step-icon {
    color: #5c77fc
  }

  .step-completed .step-indicator,
  .step-completed:hover .step-indicator {
    border-color: transparent;
    background-color: rgba(51, 203, 129, 0.12);
    color: #33cb81;
    line-height: 1.25rem
  }

  .step-completed .step-indicator .feather,
  .step-completed:hover .step-indicator .feather {
    width: .875rem;
    height: .875rem
  }

  @media (max-width: 575.98px) {
    .steps-header {
      display: none
    }

    .steps-body,
    .step {
      display: block
    }

    .step {
      border-right: 0;
      border-bottom: 1px dashed #e7e7e7
    }

    .step:last-child {
      border-bottom: 0
    }

    .has-indicator {
      padding: 1rem .75rem
    }

    .has-indicator .step-indicator {
      display: inline-block;
      position: static;
      margin: 0;
      margin-right: 0.75rem
    }
  }

  .bg-secondary {
    background-color: #f7f7f7 !important;
  }


  .ezy__eporder9 {
    /* Bootstrap variables */
    --bs-body-color: #28303b;
    --bs-body-bg: rgb(255, 255, 255);

    /* Easy Frontend variables */
    --ezy-theme-color: rgb(13, 110, 253);
    --ezy-theme-color-rgb: 13, 110, 253;
    --ezy-card-bg: #f6f6f6;
    --ezy-border-color: rgba(171, 171, 171, 0.2);

    background: var(--bs-body-bg);
    color: var(--bs-body-color);
    overflow: hidden;
    padding: 60px 0;
  }

  @media (min-width: 992px) {
    .ezy__eporder9 {
      padding: 10px 0;
    }
  }

  /* Gray Block Style */
  .gray .ezy__eporder9,
  .ezy__eporder9.gray {
    /* Bootstrap variables */
    --bs-body-bg: rgb(246, 246, 246);

    /* Easy Frontend variables */
    --ezy-card-bg: #fff;
  }

  /* Dark Gray Block Style */
  .dark-gray .ezy__eporder9,
  .ezy__eporder9.dark-gray {
    /* Bootstrap variables */
    --bs-body-color: #ffffff;
    --bs-body-bg: rgb(30, 39, 53);

    /* Easy Frontend variables */
    --ezy-card-bg: rgb(11, 23, 39);
    --ezy-border-color: rgba(155, 155, 155, 0.2);
  }

  /* Dark Block Style */
  .dark .ezy__eporder9,
  .ezy__eporder9.dark {
    --bs-body-color: #ffffff;
    --bs-body-bg: rgb(11, 23, 39);

    /* Easy Frontend variables */
    --ezy-card-bg: rgb(30, 39, 53);
    --ezy-border-color: rgba(155, 155, 155, 0.2);
  }

  /* card */
  .ezy__eporder9-card {
    background-color: #fff;
    border-color: var(--ezy-border-color);
  }

  /* btn */
  .ezy__eporder9-btn {
    color: var(--bs-body-color);
    padding: 7px 20px;
    font-weight: 500;
  }

  .ezy__eporder9-btn:hover {
    color: #fff;
    background-color: var(--ezy-theme-color);
    border-color: var(--ezy-theme-color) !important;
  }

  /* innner card */
  .ezy__eporder9-details {
    width: 100%;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.7;
    opacity: 0.8;
  }

  @media (min-width: 991px) {
    .ezy__eporder9-details {
      max-width: 525px;
    }
  }

  .ezy__eporder9 h3 {
    font-size: 28px;
  }

  @media (min-width: 991px) {
    .ezy__eporder9 h3 {
      font-size: 40px;
    }
  }

  .ezy__eporder9-status {
    padding: 7px 20px;
    border-radius: 6px;
    padding: 8px 25px;
    font-size: 15px;
    min-width: 120px;
    display: inline-block;
    text-align: center;
  }

  .ezy__eporder9-status.completed {
    background-color: rgba(58, 94, 222, 0.08);
    color: rgb(58, 94, 222);
  }

  .ezy__eporder9-status.inprogress {
    background-color: rgba(80, 184, 60, 0.08);
    color: rgba(80, 184, 60, 1);
  }

  .ezy__eporder9-status.failed {
    background-color: rgba(255, 0, 0, 0.08);
    color: rgba(255, 0, 0, 1);
  }

  .ezy__eporder9 a {
    text-decoration: none;
    color: var(--bs-body-color);
  }

  .ezy__eporder9 a:hover {
    color: var(--ezy-theme-color);
  }

  .ezy__eporder9-img {
    border-radius: 10px;
  }

  .ezy__eporder9-line {
    background-color: var(--bs-body-color);
    opacity: 0.08;
  }
</style>

</head>

<body>

  <?php
  include("includes/header.php");
  ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-xl-4">
        <div class="card-box text-center">


          <?php if ($gender === 'male'): ?>
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
          <?php elseif ($gender === 'female'): ?>
            <img src="https://i.pinimg.com/originals/a6/58/32/a65832155622ac173337874f02b218fb.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
          <?php endif; ?>

          <br><br>
          <h4 class="mb-0"><?php echo htmlspecialchars($fullName); ?></h4>



        </div>
      </div>
      <div class="col-lg-8 col-xl-8">
        <div class="card-box">
          <ul class="nav nav-pills navtab-bg">
            <li class="nav-item">
              <a href="#about-me" data-toggle="tab" aria-expanded="true" class="nav-link ml-0 active">
                <i class="mdi mdi-face-profile mr-1"></i>Order History
              </a>
            </li>
            <li class="nav-item">
              <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                <i class="mdi mdi-settings-outline mr-1"></i>Edit info
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane show active" id="about-me">



            <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2>Order History</h2>

        <?php foreach ($groupedOrders as $orderId => $orderItems): ?>
          <div class="card my-3">
            <div class="card-header">
              <h5>Order #<?php echo $orderId; ?></h5>
              <p>Status: <?php echo htmlspecialchars($orderItems[0]['order_status']); ?></p>
            </div>
            <div class="card-body">
              <ul class="list-group">
                <?php foreach ($orderItems as $item): ?>
                  <li class="list-group-item">
                    
                    <p><strong>Product:</strong> <?php echo htmlspecialchars($item['product_name']); ?></p>
                    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($item['quantity']); ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($item['order_total'], 2); ?></p>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>



            </div>




            <div class="tab-pane" id="settings">
              <form action="./includes/user_edit_info.php" method="POST">
                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="firstname">First Name</label>
                      <input type="text" class="form-control" id="firstname" name="firstname"
                        value="<?php echo htmlspecialchars($fName); ?>" placeholder="Enter first name" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lastname">Last Name</label>
                      <input type="text" class="form-control" id="lastname" name="lastname"
                        value="<?php echo htmlspecialchars($lName); ?>" placeholder="Enter last name" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="useremail">Email Address</label>
                      <input type="email" class="form-control" id="useremail" name="useremail"
                        value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter email" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userbio">Address</label>
                      <input class="form-control" id="userbio" name="userbio"
                        value="<?php echo htmlspecialchars($address); ?>" placeholder="Enter your address" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input type="text" class="form-control" id="phone" name="phone"
                        value="<?php echo htmlspecialchars($phoneNumber); ?>" placeholder="Enter phone number" required>
                      <span class="form-text text-muted">
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="userpassword_old">Enter Password</label>
                      <input type="password" class="form-control" placeholder="Enter password" readonly>
                      <small>If you want to change password please <a href="./changePassword.php">click</a> here.</small></span>
                    </div>
                  </div>
                </div>


                <div class="text-right">
                  <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
                    <i class="mdi mdi-content-save"></i>Save
                  </button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php

  ob_end_flush();
  include("includes/footer.php");
  ?>

  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript"></script>
</body>

</html>