<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// ob_start();
include 'categories.php';

if (isset($_POST['edit_category'])) {
    // Retrieve the category ID from the hidden input
    $id = $_POST['category_id'];
    $name = $_POST['categoryName'];
    $description = $_POST['categoryDescription'];

    // Create an instance of the category class
    $categoryInstance = new category();

    // Handle image uploading
    $allowedExtension = ['jpg', 'jpeg', 'png', 'gif'];
    $filePath = null;

    // Check if a new file was uploaded
    if (isset($_FILES['category_picture']) && $_FILES['category_picture']['error'] == 0) {
        $fileName = $_FILES['category_picture']['name'];
        $fileTmpName = $_FILES['category_picture']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtension)) {
            $uploadDir = "uploads/updatedCategories/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($fileName);

            if (!move_uploaded_file($fileTmpName, $filePath)) {
                // Handle upload error
                header("location: categories.php?status=wrong_picture");
                exit();
            }
        } else {
            // Redirect with invalid file type message
            header("location: categories.php?status=invalid_picture_type");
            exit();
        }
    } else {
        // If no new picture is uploaded, retain the old picture
        $existingCategory = $categoryInstance->getCategoryById($id);
        $filePath = $existingCategory['category_picture']; // Keep existing picture
    }

    // Sanitize inputs to avoid SQL injection issues
    $sanitized_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $sanitized_description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    // Pass the sanitized variables to the update function
    if ($categoryInstance->updateCategory($id, $sanitized_name, $sanitized_description, $filePath, 1)) {
        // Redirect with success message (only once)
        header("Location: categories.php?status=success_update");
        exit();
    } else {
        header("Location: categories.php?status=error_updating");
        exit();
    }

} else {
    // Redirect if form not submitted correctly
    header("location: categories.php?status=error_updating");
    exit();
}

// ob_end_flush();