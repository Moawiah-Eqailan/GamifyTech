<?php
// ob_start();
include 'classes/productsClass.php'; // Make sure you include the correct Product class

// Initialize the Product class
$product = new Product();

if (isset($_POST['addProduct'])) {
    // Retrieve form data
    $name = $_POST['newProductName'];
    $description = $_POST['newProductDescription'];
    $price = $_POST['newProductPrice'];
    $categoryId = $_POST['newProductCategory']; // Make sure category ID is passed correctly
    $quantity = $_POST['newProductQuantity'];

    // Handle image uploading
    $allowedExtension = ['jpg', 'jpeg', 'png', 'gif'];
    if (isset($_FILES['newProductPicture']) && $_FILES['newProductPicture']['error'] == 0) {
        $fileName = $_FILES['newProductPicture']['name'];
        $fileTmpName = $_FILES['newProductPicture']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtension)) {
            $uploadDir = "uploads/products/";

            // Create the directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($fileName);

            // Move uploaded file to the correct directory
            if (move_uploaded_file($fileTmpName, $filePath)) {
                // Add the product using the Product class
                $result = $product->addNewProduct($name, $description, $price, $categoryId, $quantity, $filePath);

                if ($result) {
                    // Redirect with success message
                    header("location: products.php?status=success");
                    exit();
                } else {
                    // Redirect with error message if adding product fails
                    header("location: products.php?status=add_error");
                    exit();
                }
            } else {
                // Redirect with error message if upload fails
                header("location: products.php?status=invalid_picture");
                exit();
            }
        } else {
            // Redirect with invalid file type message
            header("location: products.php?status=invalid_type");
            exit();
        }
    } else {
        // Redirect if no file uploaded or an error occurred during upload
        header("location: products.php?status=no_file");
        exit();
    }
} else {
    // Redirect if form not submitted correctly
    header("location: products.php?status=error");
    exit();
}

// ob_end_flush();
?>
