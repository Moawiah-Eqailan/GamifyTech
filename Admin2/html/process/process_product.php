<?php
session_start();
require_once '../model/Product.php';
require_once '../model/Category.php';

// Create a new product instance
$productModel = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create a product
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        // Collect product details from the form
        $productName        = $_POST['newProductName'];
        $productDescription = $_POST['newProductDescription'];
        $productCategory    = $_POST['newProductCategory'];
        $productQuantity    = $_POST['newProductQuantity'];
        $productPrice       = $_POST['newProductPrice'];
        $productStatus      = $_POST['newProductStatus'];

        // Set up the target directory and file path for image upload
        $targetDir = "../../../inserted_img/";
        $targetFile = $targetDir . basename($_FILES["newProductImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the image is a valid image type
        $check = getimagesize($_FILES["newProductImage"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check the file size
        if ($_FILES["newProductImage"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If there are no errors, try to upload the file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["newProductImage"]["tmp_name"], $targetFile)) {
                // Save the product details in the database
                $result = $productModel->createProduct($productName, $productDescription, basename($targetFile), $productCategory, $productQuantity, $productPrice, $productStatus);

                if ($result) {
                    $_SESSION['sweetalert'] = [
                        "type" => "success",
                        "message" => "Product added successfully!"
                    ];
                    header("Location: ../products.php");
                    exit();
                } 
               
                else {
                    $_SESSION['sweetalert'] = [
                        "type" => "error",
                        "message" => "Failed to add Prodcut."
                    ];
                }
                header("Location: ../products.php");
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, your file was not uploaded.";
        }
    }

    
    // Edit a product
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    // Collect the ID of the product being edited
    $productId = intval($_POST['product_id']);
    $productName = htmlspecialchars($_POST['newProductName']);
    $productDescription = htmlspecialchars($_POST['newProductDescription']);
    $productCategory = intval($_POST['newProductCategory']);
    $productQuantity = intval($_POST['newProductQuantity']);
    $productPrice = floatval($_POST['newProductPrice']);
    $productStatus = htmlspecialchars($_POST['newProductStatus']);

    // Get the old image name from the form
    $oldImage = htmlspecialchars($_POST['oldImage']); // Ensure you pass this from the edit form

    // Handle image upload
    $targetDir = "../../../inserted_img/";
    $uploadOk = 1;
    $targetFile = $oldImage; // Default to old image

    // Check if a new image is uploaded
    if (!empty($_FILES["newProductImage"]["name"])) {
        $targetFile = $targetDir . basename($_FILES["newProductImage"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the image is a valid image type
        $check = getimagesize($_FILES["newProductImage"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check the file size
        if ($_FILES["newProductImage"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Try to upload the new file if all checks pass
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["newProductImage"]["tmp_name"], $targetFile)) {
                // Successful upload; no need to handle further errors here
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0; // Mark as upload failed
            }
        } else {
            echo "Sorry, your file was not uploaded.";
        }
    }

    // Save the product details in the database
    if ($uploadOk) {
        $result = $productModel->updateProduct($productId, $productName, $productDescription, basename($targetFile), $productCategory, $productQuantity, $productPrice, $productStatus);

        if ($result) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "Product updated successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to add Prodcut."
            ];
        }
        header("Location: ../products.php");
        exit();
    }
}


    // Soft Delete a product
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Collect the ID of the product to be deleted
        $productId = $_POST['product_id'];

        // Call the soft delete method in the Product model
        $result = $productModel->softDeleteProduct($productId);

        if ($result) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "Product deleted successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to add Prodcut."
            ];
        }
        header("Location: ../products.php");
        exit();
    }
}
?>