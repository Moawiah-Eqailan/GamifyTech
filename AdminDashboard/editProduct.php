<?php
// Start output buffering if needed
// ob_start();

include 'classes/productsClass.php'; // Ensure this points to the correct location of the Product class

// Initialize the Product class
$product = new Product();

// Check if the form has been submitted to edit a product
if (isset($_POST['editProduct'])) {
    // Retrieve form data
    $id = $_POST['productId']; // Hidden input field for product ID
    $name = $_POST['productName'];
    $description = $_POST['productDescription'];
    $price = $_POST['productPrice'];
    $discount = $_POST['productDiscount'];
    $categoryId = $_POST['productCategory']; // Ensure category ID is passed correctly
    $quantity = $_POST['productQuantity'];

    // Handle image uploading (only if a new image is uploaded)
    $allowedExtension = ['jpg', 'jpeg', 'png', 'gif'];
    $filePath = $_POST['currentPicture']; // Hidden input for the current picture path

    if (isset($_FILES['ProductPicture']) && $_FILES['ProductPicture']['error'] == 0) {
        $fileName = $_FILES['ProductPicture']['name'];
        $fileTmpName = $_FILES['ProductPicture']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if the uploaded file is a valid image type
        if (in_array($fileExtension, $allowedExtension)) {
            $uploadDir = "uploads/updatedProducts/";

            // Create the directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($fileName);

            // Move uploaded file to the correct directory
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                // If upload fails, keep the old picture path
                $filePath = $_POST['currentPicture'];
            }
        } else {
            // Redirect with invalid file type message
            header("location: products.php?status=invalid_type");
            exit();
        }
    }

    // Update the product using the Product class
    $result = $product->updateProduct($id, $name, $description, $price, $discount, $categoryId, $quantity, $filePath);

    if ($result) {
        // Redirect with a success message
        header("location: products.php?status=success_update");
        exit();
    } else {
        // Redirect with an error message if updating the product fails
        header("location: products.php?status=update_error");
        exit();
    }
} else {
    // Redirect if the form is not submitted correctly
    header("location: products.php?status=error");
    exit();
}

// ob_end_flush();
?>
