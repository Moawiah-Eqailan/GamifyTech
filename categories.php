<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- !bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="./assets/css/test.css" />
    <!-- !Glide.js Css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css" />
    <meta name="description"
        content="GameTech is your ultimate destination for gaming enthusiasts, providing high-quality gaming devices to enhance your gaming experience. Learn more about our mission and meet our team." />

    <title>Products Categories | GamifyTech</title>
    <?php
          include("includes/categoriesClass.php");

          $categoryObj = new Category();
          $categories = $categoryObj->getAllCategories();
    ?>
</head>

<body>
    <section class="categories">
        <div class="container">
            <div class="section-title">
                <h2>Products Categories</h2>
            </div>

            <?php if (!empty($categories)) : ?>
                <ul class="category-list">
                    <?php foreach ($categories as $category) : ?>
                        <li class="category-item">
                            <a href="#">
                                <img src="<?= htmlspecialchars($category['category_picture']); ?>" alt="category_pic" class="category-image">
                                <span class="category-title"><?= htmlspecialchars($category['category_name']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </section>
    <!-- ! category end-->

</body>

</html>