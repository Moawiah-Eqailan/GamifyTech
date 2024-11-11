<!DOCTYPE html>
<html class="no-js" lang="en">
<?php
require_once 'includes/productsClasss.php';
$productId = isset($_GET['id']) ? $_GET['id'] : null;
if ($productId) {
    $productObj = new Product();
    $product = $productObj->getProductById($productId);
} else {
    echo "No Product ID provided.";
}
?>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Product Details | GamifyTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="trendingProducts.css">

    <style>


    </style>
</head>

<body>
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

    <?php include("includes/header.php"); ?>

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title"><?= htmlspecialchars($product['product_name']); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
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
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title"><?= $product['product_name']; ?></h2>
                            <p class="category"><?= $product['category_name']; ?></p>
                            <?php
                            $originalPrice = $product['product_price'];
                            $discount = $product['product_discount'];
                            $discountedPrice = $originalPrice - ($originalPrice * ($discount / 100));
                            ?>
                            <h3>
                                <?php if ($discount > 0): ?>
                                <span style="text-decoration: line-through; color: #888;"><?= $originalPrice; ?>
                                    JOD</span>
                                <span
                                    style="color: #ff0000; font-weight: bold;"><?= number_format($discountedPrice, 2); ?>
                                    JOD</span>
                                <?php else: ?>
                                <span><?= $originalPrice; ?> JOD</span>
                                <?php endif; ?>
                            </h3>
                            <p class="info-text"><?= $product['product_description']; ?></p>

                            <!-- Quantity Selector -->
                            <div class="quantity-selector">
                                <button class="quantity-btn" onclick="decreaseQuantity()">−</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" />
                                <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <!-- Shop Now Button -->
                                <div class="shop-now-btn">
                                    <button onclick="addToCart(<?= htmlspecialchars($product['product_id']); ?>)">
                                        <div class="default-btn"><i class="lni lni-cart"></i> Shop now</div>
                                    </button>
                                </div>

                                <!-- Add to Wishlist Button -->
                                <div class="add-to-wishlist-btn">
                                    <button onclick="addToWishlist(<?= htmlspecialchars($product['product_id']); ?>)">
                                        <div class="default-btn"><i class="lni lni-heart"></i> Add to wishlist</div>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->

    <?php include("includes/footer.php"); ?>

    <!-- ========================= JS here ========================= -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/tiny-slider.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
   function addToWishlist(productId) {
    // Send POST request to wishlist.php
    fetch('wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'add_to_wishlist=true&product_id=' + productId 
    })
    .then(response => {
        // Parse response as JSON
        return response.json();
    })
    .then(data => {
        // Check if the item was successfully added to the wishlist
        if (data.success) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: 'Item added to wishlist!',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            // Show error message if the item could not be added
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.message || "Something went wrong!"  // Use the response message or default one
            });
        }
        console.log(data, "wishlist data");
    })
    .catch(error => {
        console.error("Error:", error);  // Log the error
        Swal.fire({
            icon: 'success',
            title: 'Added to Wishlist',
            text: 'Product successfully added to wishlist.',
            confirmButtonText: 'OK'
        });
    });
}

    function addToCart(productId) {
        // console.log("test dattttttttt");
        const quantity = document.getElementById("quantity").value;

        fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'add_to_cart=true&product_id=' + productId + '&quantity=' + quantity
            })
            .then(response => {
                response.json()
                console.log(response, "res");
                console.log(response.data);

            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart',
                    text: 'Product successfully added to cart.',
                    confirmButtonText: 'OK'
                });
                console.log(data, "dattttttttt");

            })
            .catch(error => {
                console.log("err");

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding to cart.',
                    confirmButtonText: 'OK'
                });
            });
    }

    function increaseQuantity() {
        const quantityInput = document.getElementById("quantity");
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById("quantity");
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }
    </script>
</body>

</html>