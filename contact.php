<!-- !bootstrap icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
<link rel="stylesheet" href="css/main.css" />
<link rel="stylesheet" href="css/contact.css" />

<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Contact | GamifyTech</title>
<link rel="stylesheet" href="assets/css/contact.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- link for Message sent successfully! & erorr message -->



</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login/login.php");
        exit();
    }

    include('./includes/db_class.php');
    include('./includes/usersClass.php');

    $userId = $_SESSION['user_id'];
    $user = new User();
    $userData = $user->displayUserById($userId);

    if ($userData) {
        $fullName = htmlspecialchars($userData['user_first_name'] . ' ' . $userData['user_last_name']);
        $firstName = htmlspecialchars($userData['user_first_name']);
        $lastName = htmlspecialchars($userData['user_last_name']);
        $email = htmlspecialchars($userData['user_email']);
   
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject']) && isset($_POST['message'])) {
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        if (!empty($subject) && !empty($message)) {
            $db = dbConnection::getInstence();
            $connect = $db->getConnection();

            $stmt = $connect->prepare("INSERT INTO contact_us (user_id, subject, message) VALUES (:userId, :subject, :message)");

            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Message sent successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                });
            </script>";
                exit();
            } else {
                echo "<script>
                 Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                  }).then(() => {
                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                });
               
            </script>";
            }
        }
    }
    ?>
    <!-- ! header start -->
    <?php
    include("includes/header.php");
    ?>
    <!-- ! header end -->




    <!-- ! contact start -->
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-7 order-md-last d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4">Get in touch</h3>
                                    <div id="form-message-warning" class="mb-4"></div>
                                    <div id="form-message-success" class="mb-4">
                                        Your message was sent, thank you!
                                    </div>
                                    <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                                        <div class="row">
                                            <input type="hidden" name="user_first_name" value="<?php echo $firstName; ?>">
                                            <input type="hidden" name="user_last_name" value="<?php echo $lastName; ?>">
                                            <input type="hidden" name="user_email" value="<?php echo $email; ?>">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label" for="name">Full Name</label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder=" <?php echo $fullName; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label" for="email">Email Address</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder=" <?php echo $email; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="subject">Subject</label>
                                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="#">Message</label>
                                                    <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Send Message" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                                <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                                    <h3>Let's get in touch</h3>
                                    <p class="mb-4">We're open for any suggestion or just to have a chat</p>
                                    <div class="dbox w-100 d-flex align-items-start">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-map-marker"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-paper-plane"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Email:</span> <a
                                                    href="mailto:info@yoursite.com">info@yoursite.com</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-globe"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Website</span> <a href="#">yoursite.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ! contact end -->

    <!-- ! policy start -->
    <!-- <section class="policy">
        <div class="container">
            <ul class="policy-list">
                <li class="policy-item">
                    <i class="bi bi-truck"></i>
                    <div class="policy-texts">
                        <strong>FREE DELIVERY</strong>
                        <span>From $59.89</span>
                    </div>
                </li>
                <li class="policy-item">
                    <i class="bi bi-headset"></i>
                    <div class="policy-texts">
                        <strong>SUPPORT 24/7</strong>
                        <span>Online 24 hours</span>
                    </div>
                </li>
                <li class="policy-item">
                    <i class="bi bi-arrow-clockwise"></i>
                    <div class="policy-texts">
                        <strong>30 DAYS RETURN</strong>
                        <span>Simply return it within 30 days</span>
                    </div>
                </li>
                <li class="policy-item">
                    <i class="bi bi-credit-card"></i>
                    <div class="policy-texts">
                        <strong>PAYMENT METHOD</strong>
                        <span>Secure Payment</span>
                    </div>
                </li>
            </ul>
        </div>
    </section> -->
    <!-- ! policy end -->

    <!-- ! footer start -->
    <?php
    include("includes/footer.php");
    ?>
    <!-- ! footer end -->

    <!-- scripts start -->
    <script src="js/main.js" type="module"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mainContact.js"></script>
    <!-- scripts end -->

</body>


</html>