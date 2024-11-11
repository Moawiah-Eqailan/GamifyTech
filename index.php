<?php

include("includes/header.php");
include("includes/productsClasss.php");
include("includes/categoriesClass.php");

?>
<!-- <link rel="stylesheet" href="assets/css/test.css"> -->
<link rel="stylesheet" href="cat.css">
<link rel="stylesheet" href="trendingProducts.css">
<title>GamifyTech</title>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<style>
    .hero-slider {
        width: 100%;
        height: 500px;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }

    .single-slider {
        background-size: cover;
        background-position: center;
        height: 100%;
        border-radius: 12px;
    }

    .swiper-pagination-bullet {
        background: #333;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #333;
    }

    /* Container for the entire section */
    .random-products.section {
        padding: 60px 0;
    }

    /* Each product card */
    .random-product-card {
        position: relative;
        background-size: cover;
        background-position: center;
        height: 350px;
        display: flex;
        align-items: flex-end;
        margin: 15px 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .random-product-card:hover {
        transform: scale(1.02);
    }

    /* Overlay for text content */
    .product-content {
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        width: 100%;
        text-align: center;
    }

    /* Product title styling */
    .product-title {
        color: #fff;
        font-size: 24px;
        margin: 0 0 10px;
        font-weight: 600;
    }

    /* Button styling */
    .product-btn {
        display: inline-flex;
        align-items: center;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #007bff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .product-btn i {
        margin-right: 8px;
    }

    .product-btn:hover {
        background-color: #0056b3;
    }
</style>
</head>

<body>
    <!-- Preloader -->
    <!-- <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div> -->

    <!-- /End Preloader -->

    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-8 col-12 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            <?php
                            $highestDiscountProductsObj = new product();
                            $highestProducts = $highestDiscountProductsObj->fetchHighestDiscountProducts();
                            if (!empty($highestProducts)) :
                                foreach ($highestProducts as $highestProduct) :
                                    $imagePath = "inserted_img/" . ($highestProduct['product_picture']);

                                    $calculateSaving = $highestProduct['product_price'] * ($highestProduct['product_discount'] / 100);
                                    $priceAfterDiscount = $highestProduct['product_price'] * (1 - $highestProduct['product_discount'] / 100);
                            ?>
                                    <!-- Start Single Slider -->
                                    <div class="single-slider" style="background-image: url('<?php echo $imagePath; ?>');">
                                        <div class="content">
                                            <h2><?= htmlspecialchars($highestProduct['product_name']); ?></h2>
                                            <h3><span>Now Only</span> <?= htmlspecialchars($priceAfterDiscount); ?> JOD</h3>
                                            <div class="button">
                                                <a href="productDetails.php?id=<?= htmlspecialchars($highestProduct['product_id']); ?>" class="btn">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Slider -->
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="hero-small-banner style2">
                        <?php
                        $highestDiscountProduct = new product();
                        $discountProduct = $highestDiscountProduct->fetchHighestDiscountProduct();

                        if (!empty($discountProduct)) :
                            $calculateSaving = sprintf("%.2f", $discountProduct['product_price'] * ($discountProduct['product_discount'] / 100));
                            $priceAfterDiscount = sprintf("%.2f", $discountProduct['product_price'] * (1 - $discountProduct['product_discount'] / 100));
                        ?>
                            <div class="content">
                                <h2>Flash Sale!</h2>
                                <h3><?= $discountProduct['product_discount'] ?>%</h3>
                                <p>Saving up to <?= $calculateSaving; ?> JOD on <?= htmlspecialchars($discountProduct['product_name']); ?></p>
                                <h3>Now Only: <?= $priceAfterDiscount; ?> JOD</h3>
                                <div class="button">
                                    <a class="btn" href="flashSale.php?id=<?= htmlspecialchars($discountProduct['product_id']); ?>">Explore Now</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="content">
                                <h2>No Discounts Available</h2>
                                <p>Check back later for great deals!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- End Small Banner -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- categories -->

    <section class="categories">

        <section class="categories" id="product_Categories">
            <div class="section-title">
                <h2>Product Categories</h2>
            </div>

            <?php
            $categoryObj = new Category();
            $categories = $categoryObj->getAllCategories();
            if (!empty($categories)) :
            ?>


                <ul class="category-list cat-container">
                    <?php foreach ($categories as $category) : ?>
                        <?php
                        $productsOfCategory = $categoryObj->getProductsByCategoryId($category['category_id']);
                        $imagePath_cat = "category_img/" . urlencode($category['category_picture']);
                        ?>
                        <li class="category-item">
                            <a href="productsOfCategory.php?id=<?= htmlspecialchars($category['category_id']); ?>">
                                <div class="category-image-container">
                                    <img src="<?php echo $imagePath_cat; ?>" alt="category_pic" class="category-image">
                                </div>
                                <span class="category-title"
                                    style="font-size: 30px;"><?= htmlspecialchars($category['category_name']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </section>


        <!-- end category -->


        <!-- Start Banner Area -->
        <section id="new-arrival" class="random-products section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>New Arrivals</h2>
                            <p>Discover our new products, carefully curated to enhance your gaming experience.
                            </p>
                        </div>
                    </div>
                </div>
                <?php
                $newArrival = new Product();
                $new = $newArrival->lastProduct();

                if (!empty($new)) : ?>
                    <div class="row">
                        <?php foreach ($new as $product) :
                            $imagePath = "inserted_img/" . htmlspecialchars($product['product_picture']); ?>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="random-product-card" style="background-image: url('<?php echo $imagePath; ?>');">
                                    <div class="product-content">
                                        <h2 class="product-title"><?= htmlspecialchars($product['product_name']); ?></h2>

                                        <div class="price ">
                                            <span style="color:white"><?= htmlspecialchars($product['product_price']); ?>
                                                JOD</span>
                                        </div>

                                        <div class="btn-div">
                                            <div class="shopbtn">
                                                <button class="btn-btn"
                                                    onclick="window.location.href='productDetails.php?id=<?= htmlspecialchars($product['product_id']); ?>'">
                                                    <div class="default-btn">
                                                        <i class="lni lni-eye"></i>
                                                    </div>
                                                    <div class="hover-btn">
                                                        <span>Quick View</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="shopbtn">
                                                <button class="btn-btn"
                                                    onclick="addToCart(<?= htmlspecialchars($product['product_id']); ?>)">
                                                    <div class="default-btn">
                                                        <i class="lni lni-cart"></i>
                                                    </div>
                                                    <div class="hover-btn">
                                                        <span>Shop now</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="shopbtn">
                                                <button class="btn-btn"
                                                    onclick="addToWishlist(<?= htmlspecialchars($product['product_id']); ?>)">
                                                    <div class="default-btn"
                                                        id="heart-icon-<?= htmlspecialchars($product['product_id']); ?>">
                                                        <i class="lni lni-heart"></i>
                                                    </div>
                                                    <div class="hover-btn">
                                                        <span>Add to wish list</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <?php if ($product['product_discount'] > 0) : ?>
                            <div class="product-discount">
                                <span>-<?= htmlspecialchars($product['product_discount']); ?>%</span>
                            </div>
                            <?php endif; ?> -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="col-12">
                        <p>No products available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- End Banner Area -->



        <!-- Start top selling Area -->
        <section id="trend_product" class="trending-product section" ">
            <div class=" container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Top Selling Products</h2>
                        <p>Discover our best-rated products, carefully curated to enhance your gaming experience.
                        </p>
                    </div>
                </div>
            </div>
            <?php
            $trendingProductObj = new Product();
            $trendingProducts = $trendingProductObj->fetchTopSellingProducts();

            if (!empty($trendingProducts)) : ?>
                <div class="row">
                    <?php foreach ($trendingProducts as $product) : ?>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-product">
                                <div class="product-image">
                                    <?php $imagePath = "inserted_img/" . ($product['product_picture']); ?>
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="product_img">
                                    <?php if ($product['product_discount'] > 0) : ?>
                                        <div class="product-discount">
                                            <span>-<?= htmlspecialchars($product['product_discount']); ?>%</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="btn-div">
                                        <div class="shopbtn">
                                            <button class="btn-btn"
                                                onclick="window.location.href='productDetails.php?id=<?= htmlspecialchars($product['product_id']); ?>'">
                                                <div class="default-btn">
                                                    <i class="lni lni-eye"></i>
                                                </div>
                                                <div class="hover-btn">
                                                    <span>Quick View</span>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="shopbtn">
                                            <button class="btn-btn"
                                                onclick="addToCart(<?= htmlspecialchars($product['product_id']); ?>)">
                                                <div class="default-btn">
                                                    <i class="lni lni-cart"></i>
                                                </div>
                                                <div class="hover-btn">
                                                    <span>Shop now</span>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="shopbtn">
                                            <button class="btn-btn"
                                                onclick="addToWishlist(<?= htmlspecialchars($product['product_id']); ?>)">
                                                <div class="default-btn"
                                                    id="heart-icon-<?= htmlspecialchars($product['product_id']); ?>">
                                                    <i class="lni lni-heart"></i>
                                                </div>
                                                <div class="hover-btn">
                                                    <span>Add to wish list</span>
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
            <?php endif; ?>
            </div>
        </section>

        <!-- End top selling Area -->





        <!-- Start Shipping Info -->
        <section class="shipping-info">
            <div class="container">
                <ul>
                    <!-- Free Shipping -->
                    <li>
                        <div class="media-icon">
                            <i class="lni lni-delivery"></i>
                        </div>
                        <div class="media-body">
                            <h5>Free Shipping</h5>
                            <span>On order over 20 JOD</span>
                        </div>
                    </li>
                    <!-- Money Return -->
                    <li>
                        <div class="media-icon">
                            <i class="lni lni-support"></i>
                        </div>
                        <div class="media-body">
                            <h5>24/7 Support.</h5>
                            <span>Live Chat Or Call.</span>
                        </div>
                    </li>
                    <!-- Support 24/7 -->
                    <li>
                        <div class="media-icon">
                            <i class="lni lni-credit-cards"></i>
                        </div>
                        <div class="media-body">
                            <h5>Online Payment.</h5>
                            <span>Secure Payment Services.</span>
                        </div>
                    </li>
                    <!-- Safe Payment -->
                    <li>
                        <div class="media-icon">
                            <i class="lni lni-reload"></i>
                        </div>
                        <div class="media-body">
                            <h5>Easy Return.</h5>
                            <span>Hassle Free Shopping.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- End Shipping Info -->

        <?php
        include("includes/footer.php");
        ?>

        <!-- ========================= JS here ========================= -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/tiny-slider.js"></script>
        <script src="assets/js/glightbox.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script type="text/javascript"></script>
        <script>
            //========= Hero Slider 
            tns({
                container: '.hero-slider',
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 0,
                items: 1,
                nav: false,
                controls: true,
                controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            });

            //======== Brand Slider
            tns({
                container: '.brands-logo-carousel',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 15,
                nav: false,
                controls: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    540: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
        </script>

        <script>
            setInterval(function() {
                // إعادة تحميل القسم
                location.reload();
            }, 1800000); // 1800000 ميلي ثانية = 30 دقيقة
        </script>


        <script>
            var swiper = new Swiper('.swiper-container', {
                loop: true, // تفعيل التكرار التلقائي للسلايدر
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                autoplay: {
                    delay: 3000, // تأخير لمدة 3 ثواني قبل الانتقال التلقائي
                    disableOnInteraction: false, // السماح للمستخدمين بالتفاعل دون إيقاف التشغيل التلقائي
                },
            });
        </script>

        <script>
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
        </script>
        </script>
        <!-- add to wish list -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function addToWishlist(productId) {
                const button = document.getElementById('heart-icon-' + productId); // احصل على الزر
                button.disabled = true; // تعطيل الزر

                fetch('wishlist.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'add_to_wishlist=true&product_id=' + productId
                    })
                    .then(response => response.json())
                // .then(data => {
                //     if (data.success) {
                //         Swal.fire({
                //             icon: 'success',
                //             title: 'Success',
                //             text: data.message,
                //             confirmButtonText: 'OK'
                //         });

                //         // تغيير اللون إلى الأحمر
                //         button.classList.add('added-to-wishlist');
                //     } else {
                //         Swal.fire({
                //             icon: 'info',
                //             title: 'Already Added',
                //             text: data.message,
                //             confirmButtonText: 'OK'
                //         });
                //     }
                // })
                // .catch(error => {
                //     console.error('Error:', error);
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Error',
                //         text: 'An error occurred while adding to wishlist.',
                //         confirmButtonText: 'OK'
                //     });
                // });
            }


            // add to cart
            function addToCart(productId) {

                fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'add_to_cart=true&product_id=' + productId
                })

            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>