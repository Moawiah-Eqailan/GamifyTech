<?php
include("includes/categoriesClass.php");
$categoryObj = new Category();

// Check if category_id is in the URL and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryId = intval($_GET['id']);

    // Fetch products for the category
    $products = $categoryObj->getProductsByCategoryId($categoryId);

    // Fetch category details if you want to display category info
    $categoryDetails = $categoryObj->getCategoryById($categoryId);
} else {
    echo "Category ID is missing or invalid.";
    exit;
}
?>
<?php
include ('includes/header.php'); 
?>
    <title>Products | GamifyTech</title>
    <link rel="stylesheet" href="trendingProducts.css">
</head>
<body>
<div class="section-title mt-30">
    <h2><?= htmlspecialchars($categoryDetails['category_name'] ?? 'Unknown'); ?></h2>
</div>
<section id="productsOfCategory" class="trending-product section">
    <div class="container">
        <!-- <div class="row">
           
        </div> -->
        
        <?php if (!empty($products)) : ?>
            <div class="row">
                <?php foreach ($products as $product) : ?>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="single-product">
                        <div class="product-image">
                            <?php 
                            $imagePath = "inserted_img/" . htmlspecialchars($product['product_picture'] ?? 'default.png'); 
                            ?>
                            <img src="<?= $imagePath; ?>" alt="Product Image">
                            
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
                                <span><?= htmlspecialchars($product['product_price']); ?> JOD</span>
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

<?php
  include("includes/footer.php");
  ?>
</body>


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

</html>
