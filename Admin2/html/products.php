<?php 
session_start();
require_once "includes/header.php";
require_once 'model/Product.php';
require_once 'model/Category.php';
$productModel = new Product();
$products = $productModel->getAllProducts();
?>
<style>
  /* Modal Styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1080;
  left: 0;
  top: 0;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: #f2f7fa;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 100%;
  height: 95%;
  position: relative;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;  /* Stack content vertically */
  justify-content:space-between;  /* Align to the top */
}

/* Close Button */
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: red;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 4px;
}

/* Heading */
h3 {
  text-align: center;
  margin-top: 0;
  margin-bottom: 20px;
  color: #0070da;
}

/* Form Container - Grid with Two Columns */
.form-container {
  display: grid;
  grid-template-columns: 1fr 1fr; /* Two equal columns */
  gap: 20px; /* Space between grid items */
  margin-bottom: 20px;
  align-self: center;
}

/* Form Group */
.form-group {
  display: flex;
  flex-direction: column; /* Align label and input vertically */
}

.form-group label {
  color: #0070da;
  margin-bottom: 5px; /* Space between label and input */
}

.form-group input,
.form-group select {
  padding: 8px;
  width: 100%;
  box-sizing: border-box;
  border-radius: 10px;
  outline: 1px solid #26c6da;
  border: 0;
  font-family: 'Segoe UI', Roboto, sans-serif;
  outline-offset: 3px;
  padding: 10px 1rem;
  transition: 0.25s;
}

.form-group input:focus,
.form-group select:focus {
  outline-offset: 5px;
  background-color: #DFF2EB;
}

/* Save Button Container - Centered */
.save-btn-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  
}

.save-btn {
  font-size: 18px;
  letter-spacing: 2px;
  text-transform: uppercase;
  display: inline-block;
  text-align: center;
  font-weight: bold;
  padding: 0.7em 2em;
  border: 3px solid #26c6da;
  border-radius: 8px;
  position: relative;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.1);
  color: #26c6da;
  text-decoration: none;
  transition: 0.3s ease all;
  z-index: 1;
  width: 30vh;
  position: relative;
}

.save-btn:before {
  transition: 0.5s all ease;
  position: absolute;
  top: 0;
  left: 50%;
  right: 50%;
  bottom: 0;
  opacity: 0;
  content: '';
  background-color: #26c6da;
  z-index: -1;
}

.save-btn:hover,
.save-btn:focus {
  color: white;
}

.save-btn:hover:before,
.save-btn:focus:before {
  transition: 0.5s all ease;
  left: 0;
  right: 0;
  opacity: 1;
}

.save-btn:active {
  transform: scale(0.9);
}

/* Old Image Styling */
.old-image {
  max-width: 30%;
  height: auto;
  border-radius: 10px;
  margin-top: 10px;
}


</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <h2 class="h2">Products Dashboard</h2>
        <button class="add-btn" onclick="openAddModal()">Add product <i class="bi bi-plus-circle"></i></button>
        <div class="row">
            <table class="table tb table-hover text-center"id="myTable" >
                <thead class="t-head">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        
                        <th>Product Image</th>

                        <th>Product Price</th>
                        <th>Product State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
    <?php foreach ($products as $product): ?>
    <tr>
        <td data-label="Product Id"><?= htmlspecialchars($product['product_id']) ?></td>
        <td data-label="Product Name"><?= htmlspecialchars($product['product_name']) ?></td>
      
        <td data-label="Image">
            <img src="../../inserted_img/<?= $product['product_picture'] ?>" alt="Product Image" width="50" style="border-radius:10%;">
        </td>
       
     
        <td data-label="Price"><?= htmlspecialchars($product['product_price']) ?></td>
        <td data-label="Status"><?= $product['product_state'] ?></td>
        <td data-label="Actions">
            <div class="action-buttons">
                <button class="edit-btn" onclick="document.getElementById('editModal<?= $product['product_id'] ?>').style.display='flex'"><i class="bi bi-pencil-square"></i></button>
                <form action="process/process_product.php" method="POST" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="button" class="delete-btn" onclick="confirmDelete(this)"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>

    <!-- Edit Modal for each product -->
    <div id="editModal<?= $product['product_id'] ?>" class="modal">
        <div class="modal-content">
           
            <button class="close-btn delete-btn" onclick="hideModal('editModal<?= $product['product_id'] ?>')">X</button>
            <h3>Edit Product</h3>
            <form id="editForm" enctype="multipart/form-data" method="POST" action="process/process_product.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <input type="hidden" name="oldImage" value="<?= $product['product_picture'] ?>">
                <div class="form-container">
                <div class="form-group">
                    <label for="productName">Product Name:</label>
                    <input type="text" name="newProductName" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="productDescription">Product Description:</label>
                    <input type="text" name="newProductDescription" value="<?= htmlspecialchars($product['product_description']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="productImage">Old Product Image:</label><br>
                    <img src="../../inserted_img/<?= $product['product_picture'] ?>" alt="Old Product Image" class="old-image">
                </div>

                <div class="form-group">
                    <label for="productImage">New Product Image:</label><br>
                    <input type="file" name="newProductImage" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="productCategory">Product Category:</label>
                    <select name="newProductCategory" required>
                        <?php
                            $categoryModel = new Category();
                            $categories = $categoryModel->getAllCategories();
                            foreach ($categories as $category) {
                                $selected = ($category['category_id'] == $product['category_id']) ? 'selected' : '';
                                echo "<option value=\"{$category['category_id']}\" $selected>{$category['category_name']}</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="productQuantity">Product Quantity:</label>
                    <input type="number" name="newProductQuantity" value="<?= htmlspecialchars($product['product_quantity']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="productPrice">Product Price:</label>
                    <input type="number" name="newProductPrice" value="<?= htmlspecialchars($product['product_price']) ?>" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="productStatus">Product Status:</label>
                    <select name="newProductStatus" required>
                        <option value="inStock" <?= ($product['product_state'] == 'inStock') ? 'selected' : ''; ?>>In Stock</option>
                        <option value="outOfStock" <?= ($product['product_state'] == 'outOfStock') ? 'selected' : ''; ?>>Out of Stock</option>
                    </select>
                </div>
                <div class="save-btn-container text-center">
                <button class="save-btn" type="submit">Save</button>
            </form>
            </div>
           
            </div>
            </div>
        <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
    
<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <button class="close-btn delete-btn" onclick="closeAddModal()">X</button>
        <h3>Add Product</h3>
        <form id="addForm" enctype="multipart/form-data" method="POST" action="process/process_product.php">
            <input type="hidden" name="action" value="create">
            <div class="form-container">
            <div class="form-group">
                <label for="newProductName">Product Name:</label>
                <input type="text" id="newProductName" name="newProductName" required>
            </div>

            <div class="form-group">
                <label for="newProductDescription">Product Description:</label>
                <input type="text" id="newProductDescription" name="newProductDescription" required>
            </div>

            <div class="form-group">
                <label for="newProductImage">Product Image:</label>
                <input type="file" id="newProductImage" name="newProductImage" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="newProductCategory">Product Category:</label>
                <select id="newProductCategory" name="newProductCategory" required>
                    <?php
                        $categoryModel = new Category();
                        $categories = $categoryModel->getAllCategories();
                        foreach ($categories as $category) {
                            echo "<option value=\"{$category['category_id']}\">{$category['category_name']}</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="newProductQuantity">Product Quantity:</label>
                <input type="number" id="newProductQuantity" name="newProductQuantity" required>
            </div>

            <div class="form-group">
                <label for="newProductPrice">Product Price:</label>
                <input type="number" id="newProductPrice" name="newProductPrice" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="newProductStatus">Product Status:</label>
                <select id="newProductStatus" name="newProductStatus" required>
                    <option value="1">In Stock</option>
                    <option value="0">Out of Stock</option>
                </select>
            </div>

            
        </form>
        
        </div>
        <div class="save-btn-container">
            <button class="save-btn" type="submit">Add Product</button>
        </div>
    </div>
</div>

</div>
<!-- End of container-fluid and page-wrapper divs -->


<?php 
include "includes/footer.php"; 
?>