<?php
// ob_start();
include 'classes/categoriesClass.php';

if (isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $description = $_POST['category_description'];

    // Handle image uploading
    $allowedExtension = ['jpg', 'jpeg', 'png', 'gif'];
    if (isset($_FILES['category_picture']) && $_FILES['category_picture']['error'] == 0) {
        $fileName = $_FILES['category_picture']['name'];
        $fileTmpName = $_FILES['category_picture']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtension)) {
            $uploadDir = "uploads/categories/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($fileName);

            if (move_uploaded_file($fileTmpName, $filePath)) {
                $category = new category();
                $category->addNewCategory($name, $description, $filePath,1);

                // Redirect with success message
                header("location: categories.php?status=success");
                exit();
            } else {
                // Redirect with error message if upload fails
                header("location: categories.php?status=invalid_picture");
                exit();
            }
        } else {
            // Redirect with invalid file type message
            header("location: categories.php?status=invalid_type");
            exit();
        }
    } else {
        // Redirect if no file uploaded or an error occurred during upload
        header("location: categories.php?status=no_file");
        exit();
    }
} else {
    // Redirect if form not submitted correctly
    header("location: categories.php?status=error");
    exit();
}

//  ob_end_flush();
?>