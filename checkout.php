<?php
session_start();
require_once "includes/db_class.php"; 
require_once "includes/cartClass.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$cart = new Cart();
$cartItems = $cart->getCart($user_id);






if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $paymentMethod = $_POST['payment_method'] ?? '';
    if ($cart->checkout($user_id, $paymentMethod)) {
        unset($_SESSION['final_total']);
        header("Location: thanks.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>There was an error processing your order. Please try again.</div>";
    }
}

$finalTotal = $_SESSION['final_total'] ?? 0;
// $quantity = $item['quantity'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- <link rel = "stylesheet" href = "assets/css/checkout.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .total-price {
            font-weight: bold;
            font-size: 1.2em;
        }

        
    </style>
    
</head>
<body>
<?php
  include("includes/header.php");
  ?>
<section class="h-100 h-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-7">
                                <h5 class="mb-3"><a href="index.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="mb-1">Shopping cart</p>
                                        <p class="mb-0">You have <?= count($cartItems); ?> product in your cart</p>
                                    </div>
                                </div>

                                <?php foreach ($cartItems as $item): ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center"><?php
                                                $imagePath="inserted_img/".($item['product_picture']);?>

<img src="<?php echo $imagePath; ?>" alt="category_pic" class="category-image" style="width: 65px;">

                                                
                                                    <div class="ms-3">
                                                        <h5><?= htmlspecialchars($item['product_name']); ?></h5>
                                                        <p class="small mb-0"><?= htmlspecialchars($item['quantity']); ?> x <?= htmlspecialchars($item['product_price']); ?> JD</p>
                                                    </div>
                                                </div>
                                                <div style="width: 80px;">
                                                    <h5 class="mb-0"><?= htmlspecialchars($item['quantity'] * $item['product_price']); ?> JD</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                            <div class="col-lg-5">

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="mb-0">Payment Details</h5>
                                        <form method="POST">
                                            <div class="mb-4">
                                                <label class="form-label">Select Payment Method:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" value="card" id="paymentCard" checked>
                                                    <label class="form-check-label" for="paymentCard">
                                                    Cash on Delivery
                                                    </label>
                                                </div>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" value="cash" id="paymentCash">
                                                    <label class="form-check-label" for="paymentCash">
                                                        Cash on Delivery
                                                    </label>
                                                </div> -->
                                            </div>

                                            <!-- <div id="cardDetails" class="mb-4">
                                                <div class="form-outline mb-4">
                                                    <input type="text" id="typeName" class="form-control" placeholder="Cardholder's Name" required />
                                                    <label class="form-label" for="typeName">Cardholder's Name</label>
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <input type="text" id="typeText" class="form-control" placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" required />
                                                    <label class="form-label" for="typeText">Card Number</label>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="form-outline">
                                                            <input type="text" id="typeExp" class="form-control" placeholder="MM/YYYY" minlength="7" maxlength="7" required />
                                                            <label class="form-label" for="typeExp">Expiration</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-outline">
                                                            <input type="password" id="typeCvv" class="form-control" placeholder="&#9679;&#9679;&#9679;" minlength="3" maxlength="3" required />
                                                            <label class="form-label" for="typeCvv">CVV</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between">
                                                <p class="total-price">Total:</p>
                                                <p class="total-price"><?php echo number_format($finalTotal, 2) . " JD"; ?></p>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                            <button type="submit" name="checkout" class="btn btn-primary btn-block btn-lg" onclick="ordersubmit(this)">
                                                <div class="d-flex justify-content-between">
                                                    <span>Proceed to checkout</span>
                                                    <span><i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                </div>
                                            </button>
                                </div>
                                       </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
    //     radio.addEventListener('change', function () {
    //         const cardDetails = document.getElementById('cardDetails');
    //         if (this.value === 'card') {
    //             cardDetails.style.display = 'block';
    //         } else {
    //             cardDetails.style.display = 'none';
    //         }
    //     });
    // });
</script>
</body>
</html>