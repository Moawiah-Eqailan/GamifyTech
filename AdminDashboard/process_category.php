<?php
session_start();
require_once 'model/Category.php';

// Create a new category instance
$categoryModel = new Category();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        // Create a category
        if (isset($_POST['action']) && $_POST['action'] === 'create') {
            // Collect category details from the form
            $categoryName = $_POST['newCategoryName'];
            $categoryDescription = $_POST['newCategoryDescription'];
    
            // Handle image upload
            $targetDir = "../category_img/";
            $targetFile = $targetDir . basename($_FILES["newCategoryImage"]["name"]);
            $uploadOk = 1;
    
            // Check if the image is a valid image type
            $check = getimagesize($_FILES["newCategoryImage"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }
    
            // Additional checks for file size and type...
            // (add your checks here)
    
            // If there are no errors, try to upload the file
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["newCategoryImage"]["tmp_name"], $targetFile)) {
                    // Save the category details in the database
                    $result = $categoryModel->addCategory($categoryName, $categoryDescription, basename($targetFile));
    
                    if ($result) {
                        $_SESSION['sweetalert'] = [
                            "type" => "success",
                            "message" => "Category added successfully!"
                        ];
                    } else {
                        $_SESSION['sweetalert'] = [
                            "type" => "error",
                            "message" => "Failed to add category."
                        ];
                    }
                    header("Location: categories.php");
                    exit();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, your file was not uploaded.";
            }
        }
    
        // Edit a category
        if (isset($_POST['action']) && $_POST['action'] === 'edit') {
            $categoryId = intval($_POST['category_id']);
            $categoryName = htmlspecialchars($_POST['newCategoryName']);
            $categoryDescription = htmlspecialchars($_POST['newCategoryDescription']);
    
            // Get the old image name from the form
            $oldImage = htmlspecialchars($_POST['oldImage']); // Pass this from the edit form
    
            // Handle image upload
            $targetDir = "../category_img/";
            $uploadOk = 1;
            $targetFile = $oldImage; // Default to old image
    
            // Check if a new image is uploaded
            if (!empty($_FILES["newCategoryImage"]["name"])) {
                $targetFile = $targetDir . basename($_FILES["newCategoryImage"]["name"]);
                // Additional image checks...
    
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["newCategoryImage"]["tmp_name"], $targetFile)) {
                        // Successful upload
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        $uploadOk = 0; // Mark as upload failed
                    }
                }
            }
    
            // Save the category details in the database
            if ($uploadOk) {
                $result = $categoryModel->updateCategory($categoryId, $categoryName, $categoryDescription, basename($targetFile));
    
                if ($result) {
                    $_SESSION['sweetalert'] = [
                        "type" => "success",
                        "message" => "Category updated successfully!"
                    ];
                } else {
                    $_SESSION['sweetalert'] = [
                        "type" => "error",
                        "message" => "Failed to update category."
                    ];
                }
                header("Location: categories.php");
                exit();
            }
        }
   
    

    // Soft Delete a category
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Collect the ID of the category to be deleted
        $categoryId = intval($_POST['category_id']);

        // Call the soft delete method in the Category model
        $result = $categoryModel->softDeleteCategory($categoryId);

        // Set session message based on the result
        $_SESSION['sweetalert'] = $result
            ? ["type" => "success", "message" => "Category deleted successfully!"]
            : ["type" => "error", "message" => "Failed to delete category."];
        header("Location: categories.php");
        exit();
    }
}


?>
