<?php 
session_start();
include "includes/header.php"; 
require_once 'model/Category.php';
$categoryModel = new Category();
$categories = $categoryModel->getAllCategories();
?>
<style>
    .old-image {
  max-width: 30%;
  height: 80px;
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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
        <h2 class="h2">Categories Dashboard</h2>
        <button class="add-btn" onclick="openAddModal()">Add Category <i class="bi bi-plus-circle"></i></button>
        <div class="row">
            <table class="table tb table-hover" id="myTable">
                <thead class="t-head">
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Category Picture</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td data-label="Category Id"><?= htmlspecialchars($category['category_id']) ?></td>
                            <td data-label="Category Name"><?= htmlspecialchars($category['category_name']) ?></td>
                          
                            <td data-label="Picture">
                                <img src="../../category_img/<?php echo $category['category_picture']; ?>" alt="Category Image" width="50">
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="document.getElementById('editModal<?= $category['category_id'] ?>').style.display='flex'"><i class="bi bi-pencil-square"></i></button>
                                    <form action="process/process_category.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['category_id']); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="button" class="delete-btn" onclick="confirmDelete(this)"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for each category -->
                        <div id="editModal<?= $category['category_id'] ?>" class="modal">
                            <div class="modal-content">
                                <button class="close-btn" onclick="closeModal('editModal<?= $category['category_id'] ?>')">X</button>
                                <h3>Edit Category</h3>
                                <form id="editForm" enctype="multipart/form-data" method="POST" action="process/process_category.php">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                                    <input type="hidden" name="oldImage" value="<?= htmlspecialchars($category['category_picture']) ?>">

                                    <div class="form-group">
                                        <label for="categoryName">Category Name:</label>
                                        <input type="text" name="newCategoryName" value="<?= htmlspecialchars($category['category_name']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="categoryDescription">Category Description:</label>
                                        <input type="text" name="newCategoryDescription" value="<?= htmlspecialchars($category['category_description']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="oldCategoryImage">Current Category Image:</label><br>
                                        <input type="hidden" name="oldImage" value="<?= htmlspecialchars($category['category_picture']); ?>">
                                        <img src="../../category_img/<?= htmlspecialchars($category['category_picture']) ?>" alt="Current Category Picture" class="old-image">
                                    </div>

                                    <div class="form-group">
                                        <label for="newCategoryImage">New Category Image:</label><br>
                                        <input type="file" name="newCategoryImage" accept="image/*">
                                    </div>

                                    <div class="form-group">
                                        <label for="parentCategory">Parent Category:</label>
                                        <select name="newParentCategory" required>
                                            <option value="">Select Parent Category</option>
                                            <?php
                                                $categoryModel = new Category();
                                                $categories = $categoryModel->getAllCategories();
                                                foreach ($categories as $parentCategory) {
                                                    $selected = ($parentCategory['category_id'] == $category['category_id']) ? 'selected' : '';
                                                    echo "<option value=\"{$parentCategory['category_id']}\" $selected>{$parentCategory['category_name']}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="save-btn-container">
                                    <button class="save-btn" type="submit">Save</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div> 
    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeModal('addModal')">X</button>
            <h3>Add Category</h3>
            <form id="addForm" enctype="multipart/form-data" method="POST" action="process/process_category.php">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <label for="newCategoryName">Category Name:</label>
                    <input type="text" id="newCategoryName" name="newCategoryName" required><br><br>
                </div>
                <div class="form-group">
                    <label for="newCategoryDescription">Category Description:</label>
                    <input type="text" id="newCategoryDescription" name="newCategoryDescription" required><br><br>
                </div>
                <div class="form-group">
                    <label for="newCategoryImage">Category Picture:</label>
                    <input type="file" id="newCategoryImage" name="newCategoryImage" accept="image/*" required><br><br>
                </div>
                <div class="save-btn-container">
                <button class="save-btn" type="submit">Add Category</button>
                </div>
            </form>
        </div>
    </div>
<?php 
include "includes/footer.php"; 
?>