<link rel="stylesheet" href="trendingProducts.css">
<?php
include("includes/header.php");
include("includes/productsClasss.php");
include("includes/categoriesClass.php");
?>

<section id="flashSale" class="trending-product section" style="margin-top: 12px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title"><br><br>
                    <h2>Flash Sale Products</h2>
                    <p>Discover our best-rated products, carefully curated to enhance your gaming experience.</p>
                </div>
            </div>
        </div>
        <?php
        $trendingProductObj = new Product();
        $trendingProducts = $trendingProductObj->fetchFlashSaleProducts();

        if (!empty($trendingProducts)) : ?>
        <div class="container">
            <div class="row">
                <?php foreach ($trendingProducts as $product) : ?>
                <div class="col-md-4">
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
                                        <div class="default-btn" id="heart-icon-<?= htmlspecialchars($product['product_id']); ?>">
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

<?php include("includes/footer.php"); ?>

<script>
    function addToCart(productId) {
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'add_to_cart=true&product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
            alert("Product added to cart!");
        })
        .catch(error => console.error('Error:', error));
    }

    function addToWishlist(productId) {
        const button = document.getElementById('heart-icon-' + productId);
        if (button) {
            button.disabled = true;

            fetch('wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'add_to_wishlist=true&product_id=' + productId
            })
            .then(response => response.json())
        }
    }
</script>
