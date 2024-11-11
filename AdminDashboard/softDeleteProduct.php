<?php
// soft_delete_Product.php
include "classes/productsClass.php";

$product = new Product();

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'];

echo $product_id;


// Call the soft delete method
if ($product->SoftDeleteProduct($product_id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>