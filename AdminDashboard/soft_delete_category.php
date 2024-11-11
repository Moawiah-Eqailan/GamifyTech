<?php
// soft_delete_category.php
include "classes/categoriesClass.php";

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);
$category_id = $data['category_id'];

$category = new category();

// Call the soft delete method
if ($category->SoftDeleteCategory($category_id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>