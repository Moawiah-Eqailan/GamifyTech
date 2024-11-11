<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
session_start();
require_once "includes/db_class.php"; 
require_once "includes/cartClass.php";
require_once "includes/productsClasss.php";

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit(); 
}

$cart = new Cart();
$cartItems = $cart->getCart($user_id);
$totalPrice = 0; 
$discountAmount = 0;
$finalTotal = 0; 

// foreach ($cartItems as $item) {
//     $totalPrice += $item['product_price'] * $item['quantity']; 
// }

// Check if the form to add to the cart was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    try {
        if ($cart->addToCart($user_id, $product_id, $quantity)){
            echo "<script>alert('Product added to cart successfully!');</script>";
            $cartItems = $cart->getCart($user_id);
            header ("Location: cart.php?message=item added ");
        }
    } catch (Exception $e) {
        echo "<script>alert('Error adding product to cart: " . $e->getMessage() . "');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];

    try {
        $cart->removeFromCart($user_id, $product_id);
    } catch (Exception $e) {
        echo "<script>alert('Error removing item from cart: " . $e->getMessage() . "');</script>";
    }

    $cartItems = $cart->getCart($user_id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = (int)$_POST['quantity'];

    try {
        $cart->updateCartQuantity($user_id, $product_id, $new_quantity);
    } catch (Exception $e) {
        echo "<script>alert('Error updating quantity: " . $e->getMessage() . "');</script>";
    }

    $cartItems = $cart->getCart($user_id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['coupon_code'])){
    $user_id = $_SESSION['user_id'];
    $couponCode = $_POST['coupon_code'];

    
    $result = $cart->applyCoupon($couponCode, $user_id);



    if ($result['success']) {

        $discountAmount = $result['discount'];
        $finalTotal = $totalPrice - $discountAmount;
    
    }else{
        echo "<div class='alert alert-danger'>" . $result['message'] . "</div>";
    }
}


foreach ($cartItems as $item) {
    $totalPrice += $item['product_price'] * $item['quantity']; 
}

$finalTotal = $totalPrice - $discountAmount;
$_SESSION['final_total'] = $finalTotal;

?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="./assets/css/quantity.css">

<link rel ="stylesheet" href = "trendingProducts.css">

<?php include("includes/header.php"); ?>
<style>
    html { color:black !important; }
    a { color: black; }


    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>

<section class="bg-light my-5">
    <div class="container">
        <div class="row">
            <!-- cart -->
            <div class="col-lg-9">
                <div class="card border shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Your Shopping Cart</h4>
                        <?php if (!empty($cartItems)): ?>
                            <?php foreach ($cartItems as $item): ?>
                                <div class="row align-items-center gy-3 mb-4 p-3 border-bottom">
                                    <div class="col-lg-5 col-md-6 col-12">
                                        <div class="d-flex align-items-center">
                                            <?php
                                            $imagePath="inserted_img/".($item['product_picture']);?>
                                            <img width="130px" src="<?php echo $imagePath; ?>" alt="category_pic" class="category-image">
                                            <div>
                                                <h6 class="mb-1"><?= htmlspecialchars($item['product_name']); ?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-6 d-flex align-items-center">
                                    <form method="POST" action="cart.php" class="d-flex align-items-center w-100">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                        <input type="hidden" name="update_quantity" value="1">
                                        <button type="button" class="btn btn-outline-secondary btn-sm px-2" onclick="updateQuantity(this, -1)" style="min-width: 32px;">-</button>
                                        <input type="number" name="quantity" value="<?= $item['quantity']; ?>" required min="1" 
                                            class="form-control text-center mx-2 border-secondary" style="max-width: 60px;" >
                                        <button  type="button" class="btn btn-outline-secondary btn-sm px-2" onclick="updateQuantity(this, 1)" style="min-width: 32px;">+</button>
                                        </form>
                                        </div>

                                    <div class="col-lg-2 col-md-3 col-6 text-end text-md-center">
                                        <span class="h6 item-price" da  ta-price="<?= htmlspecialchars($item['product_price']); ?>"><?= htmlspecialchars($item['product_price']); ?> JD</span>
                                        <span class="text-muted">per item</span>
                                    </div>

                                    <div class="col-lg-2 col-md-12 text-md-center text-end mt-2 mt-md-0">
                                            <form method="POST" action="cart.php" onsubmit="return false;">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                                                <input type="hidden" name="remove_from_cart" value="1"><button type="submit" 
                                                    class="btn btn-danger btn-sm py-1 w-100 shadow-sm rounded-pill font-weight-bold" 
                                                    onclick="confirmDeletion(this.form)" 
                                                    style="max-width: 120px; font-size: 0.9em;">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>

                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center p-4">No items in your Cart</div>
                        <?php endif; ?>
                    </div>

                    <!-- Delivery Information -->
                    <div class="card-footer text-center">
                        <p class="mb-0"><i class="fas fa-truck text-muted fa-lg"></i> Free Delivery within 1-2 weeks</p>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="col-lg-3">
                <div class="card shadow-0 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total price:</p>
                            <p class="mb-2 total-price"><?php echo number_format($totalPrice, 2) . " JD"; ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2 text-success">- <span class="discount-amount"><?php echo number_format($discountAmount, 2); ?></span> JD</p>
                        </div>
                        
                        <hr />
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Final Total:</p>
                            <p class="mb-2 fw-bold final-total"><?php echo number_format($finalTotal, 2) . " JD"; ?></p>
                        </div>
                        <div class="mt-4">
                            <form method="POST" action="cart.php" class="d-flex flex-column align-items-center">
                                <input type="text" name="coupon_code" placeholder="Enter coupon code" class="form-control text-center py-2 mb-2 shadow-sm rounded-pill" style="max-width: 300px;" required />
                                <button type="submit" name="apply_coupon" class="btn btn-primary w-100 py-2 rounded-pill font-weight-bold shadow-sm" style="max-width: 300px;">Apply Coupon</button>
                            </form>
                        </div>

                        <div class="mt-4 d-flex flex-column align-items-center">
                            <a href="checkout.php" class="btn btn-success w-100 py-2 rounded-pill shadow-sm font-weight-bold mb-3" style="max-width: 300px;">Make Purchase</a>
                            <a href="index.php" class="btn btn-outline-secondary w-100 py-2 rounded-pill font-weight-bold shadow-sm" style="max-width: 300px;">Back to shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  <!-- cart + summary -->
  <section>
    <div class="container my-5">
      <header class="mb-4">
        <h3>Recommended products</h3>
      </header>
     

      <?php
      $cartProductIds = array_column($cartItems, 'product_id'); 


      if (!empty($cartProductIds)) {
          $cartObj = new Cart(); 
          $currentCategoryId = $cartObj->getCartCategoryId($cartProductIds); 

       
          if ($currentCategoryId) {
              $recomendedProductsObj = new Product();
              $recommendedProducts = $recomendedProductsObj->getRecommendedProducts($currentCategoryId, $cartProductIds); 

              if (!empty($recommendedProducts)) : ?>
                  <div class="row">
                      <?php foreach ($recommendedProducts as $product) : ?>
                          <div class="col-lg-3 col-md-6 col-12">
                              <div class="single-product">
                                  <div class="product-image">
                                      <?php $imagePath = "inserted_img/" . htmlspecialchars($product['product_picture']); ?>
                                      <img src="<?php echo $imagePath; ?>" alt="product_img">
                                      <?php if ($product['product_discount'] > 0) : ?>
                                          <div class="product-discount">
                                              <span>-<?= htmlspecialchars($product['product_discount']); ?>%</span>
                                          </div>
                                      <?php endif; ?>
                                      <div class="btn-div">
                                          <div class="shopbtn">
                                              <button class="btn-btn" onclick="window.location.href='productDetails.php?id=<?= htmlspecialchars($product['product_id']); ?>'">
                                                  <div class="default-btn">
                                                      <i class="lni lni-eye"></i>
                                                  </div>
                                                  <div class="hover-btn">
                                                      <span>Quick View</span>
                                                  </div>
                                              </button>
                                          </div>
                                          <div class="shopbtn">
                                              <button class="btn-btn" onclick="window.location.href='productDetails.php?id=<?= htmlspecialchars($product['product_id']); ?>'">
                                                  <div class="default-btn">
                                                      <i class="lni lni-cart"></i>
                                                  </div>
                                                  <div class="hover-btn">
                                                      <span>Shop now</span>
                                                  </div>
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="product-info">
                                      <h6 class="title">
                                          <?= htmlspecialchars($product['product_name']); ?>
                                      </h6>
                                      <div class="price">
                                          <span><?php echo htmlspecialchars($product['product_price']); ?> JOD</span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
              <?php else : ?>
                  <p>No products available.</p>
              <?php endif;
          } else {
              echo "<p>No category found for the products in the cart.</p>";
          }
      } else {
          echo "<p>No products in your cart.</p>";
      }
      ?>
    </div>
</section>

<script>
   function updateQuantity(button, change) {
    const form = button.closest('form');
    const quantityInput = form.querySelector('input[name="quantity"]');
    
    let currentQuantity = parseInt(quantityInput.value);
    let newQuantity = currentQuantity + change;

    if (newQuantity > 0) {
        quantityInput.value = newQuantity;
        form.submit(); // Trigger form submission for backend update

        // Call function to update total price and discount dynamically on the frontend
        updateTotalPrice();
    }
}

function updateTotalPrice() {
    let totalPrice = 0;

    // Loop through all items and calculate the total price
    document.querySelectorAll('.cart-item').forEach(item => {
        const price = parseFloat(item.dataset.price); // Assuming each item has a data-price attribute
        const quantity = parseInt(item.querySelector('input[name="quantity"]').value); // Get the current quantity
        totalPrice += price * quantity; // Add item total price
    });

    // Assuming discountRate is passed dynamically via PHP (see below)
    let discountAmount = calculateDiscount(totalPrice);
    let finalTotal = totalPrice - discountAmount;

    // Update displayed prices
    document.querySelector('.total-price').textContent = totalPrice.toFixed(2) + " JD";
    document.querySelector('.discount-amount').textContent = discountAmount.toFixed(2);
    document.querySelector('.final-total').textContent = finalTotal.toFixed(2) + " JD";
}

function calculateDiscount(totalPrice) {
    // Adjust the discount rate dynamically, this should be passed by PHP
    let discountRate = <?= isset($discountAmount) ? $discountAmount / $totalPrice : 0; ?>;
    return totalPrice * discountRate;
}


    function confirmDeletion(form) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Item will delete from cart",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

<?php include("includes/footer.php");
