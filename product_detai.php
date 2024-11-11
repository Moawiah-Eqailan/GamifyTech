<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Product Details | GamifyTech</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="trendingProducts.css">
</head>

<body>
    <?php
    require_once 'includes/productsClasss.php';
    $productId = isset($_GET['id']) ? $_GET['id'] : null;

if ($productId) {
    $productObj = new Product();
    $product = $productObj->getProductById($productId);
} else {
    echo "<p>No Product ID provided.</p>";
}
?>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <header>
        <?php include 'includes/header.php'; ?>
    </header>

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            <?= isset($product['product_name']) ? htmlspecialchars($product['product_name']) : 'Product Not Found'; ?>
                        </h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.php"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="index.php">Shop</a></li>
                        <li><?= isset($product['product_name']) ? htmlspecialchars($product['product_name']) : 'Product Not Found'; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Item Details -->
    <?php if ($product): ?>
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <!-- Product Images Section -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img">
                                    <?php $imagePath="inserted_img/".($product['product_picture']);?>
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="category_pic"
                                        id="current" class="product-image">
                                </div>
                            </main>
                        </div>
                    </div>
                    <!-- Product Info Section -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title"><?= htmlspecialchars($product['product_name']); ?></h2>
                            <p class="category"><?= htmlspecialchars($product['category_name']); ?></p>
                            <h3 class="price"><i
                                    class="lni lni-tag"></i><?= htmlspecialchars($product['product_price']); ?> JOD</h3>
                            <p class="info-text"><?= htmlspecialchars($product['product_description']); ?></p>

                            <!-- Bottom Content Section with Buttons -->
                            <div class="bottom-content mt-4">
                                <div class="row align-items-end">
                                    <!-- Add to Cart Button -->
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <form id="add-to-cart-form">
                                            <input type="hidden" name="product_id"
                                                value="<?= htmlspecialchars($product['product_id']); ?>">
                                            <div class = "quantity-div">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="updateQuantity(this, -1)">-</button>
                                            <input type="number" name="quantity" value="<?= $item['quantity']; ?>"
                                                required min="1" class="form-control text-center mx-2">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="updateQuantity(this, 1)">+</button>
                                            </div>
                                            
                                            <div class="btn-div">
                                                <div class="shopbtn">
                                                    <button type="button" class="btn-btn" id="add-to-cart-btn">
                                                        <div class="default-btn">
                                                            <i class="lni lni-cart"></i>
                                                        </div>
                                                        <div class="hover-btn">
                                                            <span>Shop now</span>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="cart-response" class="mt-2"></div>
                                    </div>

                                    <!-- Add to Wishlist Button -->
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <form id="add-to-wishlist-form">
                                            <input type="hidden" name="product_id"
                                                value="<?= htmlspecialchars($product['product_id']); ?>">
                                            <div class="btn-div">
                                                <div class="shopbtn">
                                                    <button type="button" class="btn-btn" id="add-to-wishlist-btn">
                                                        <div class="default-btn">
                                                            <i class="lni lni-heart"></i>
                                                        </div>
                                                        <div class="hover-btn">
                                                            <span>To Wishlist</span>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="wishlist-response" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Add to Cart AJAX
        $('#add-to-cart-btn').on('click', function() {
            const product_id = $('input[name="product_id"]').val();
            const quantity = $('#quantity-hidden').val() || 1;

            $.ajax({
                url: 'cart.php',
                type: 'POST',
                data: {
                    product_id: product_id,
                    quantity: quantity,
                    add_to_cart: true
                },
                success: function(response) {
                    $('#cart-response').html(
                        '<span class="text-success">Item added to cart!</span>');
                    setTimeout(function() {
                        $('#cart-response').fadeOut('slow');
                    }, 2000);
                },
                error: function() {
                    $('#cart-response').html(
                        '<span class="text-danger">Failed to add item to cart. Try again.</span>'
                        );
                }
            });
        });

        // Add to Wishlist AJAX
        $('#add-to-wishlist-btn').on('click', function() {
            const product_id = $('input[name="product_id"]').val();

            $.ajax({
                url: 'wishList.php',
                type: 'POST',
                data: {
                    product_id: product_id,
                    add_to_wishlist: true
                },
                success: function(response) {
                    $('#wishlist-response').html(
                        '<span class="text-success">Item added to wishlist!</span>');
                    setTimeout(function() {
                        $('#wishlist-response').fadeOut('slow');
                    }, 2000);
                },
                error: function() {
                    $('#wishlist-response').html(
                        '<span class="text-danger">Failed to add item to wishlist. Try again.</span>'
                        );
                }
            });
        });
    });
    </script>

    <footer>
        <?php include 'includes/footer.php'; ?>
    </footer>

    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
    function updateQuantity(button, change) {
        const form = button.closest('form');
        const quantityInput = form.querySelector('input[name="quantity"]');

        let currentQuantity = parseInt(quantityInput.value);
        let newQuantity = currentQuantity + change;

        // Ensure quantity is at least 1
        if (newQuantity > 0) {
            quantityInput.value = newQuantity;

            // Submit the form after updating the quantity
            form.submit();
        }
    }
    </script>
    <script type="text/javascript">
    const current = document.getElementById("current");
    const opacity = 0.6;
    const imgs = document.querySelectorAll(".img");
    if (imgs.length) {
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                imgs.forEach(img => img.style.opacity = 1);
                current.src = e.target.src;
                e.target.style.opacity = opacity;
            });
        });
    }
    </script>
</body>

</html>