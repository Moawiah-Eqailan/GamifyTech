<?php
session_start();
include("includes/header.php");
require_once 'model/Category.php';

$categoryModel = new Category();
$categories = $categoryModel->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

        .modal {
            display: none;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .modal-content {
            width: 50%;
            text-align: center;
        }
  
        .close-btn {
            background: #db4f4f;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        img {
            max-width: 70px;
            margin-bottom: 10px;
            border-radius: 10%;
        }
        .nav-link-text {
            color: #FFFECB;
            font-weight: bold;
            }
            .topbar-search-btn {
  background: #7AB2D3;
}
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Category Dashboard</h1>

        <div class="">
            <div>
                <button type="button" class="addbutton" onclick="openAddModal()">
                    <span class="button__text">Add Category</span>
                    <span class="button__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none">
                            <line y2="19" y1="5" x2="12" x1="12"></line>
                            <line y2="12" y1="12" x2="19" x1="5"></line>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="pt-5 pb-3 table_pro_item">
                <h2>Category Table</h2>
                <table class="responsive-table" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Category Description</th>
                            <th>Category Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td data-label="Category Id"><?= htmlspecialchars($category['category_id']) ?></td>
                            <td data-label="Category Name"><?= htmlspecialchars($category['category_name']) ?></td>
                            <td data-label="Description"><?= htmlspecialchars($category['category_description']) ?></td>
                            <td data-label="Picture">
                                <img src="../category_img/<?php echo $category['category_picture']; ?>" alt="Category Image" width="50">
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="document.getElementById('editModal<?= $category['category_id'] ?>').style.display='flex'"><i class="bi bi-pencil-square"></i></button>
                                    <form action="process_category.php" method="POST" style="display:inline;">
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
                                <button class="close-btn" onclick="document.getElementById('editModal<?= $category['category_id'] ?>').style.display='none'">X</button>
                                <h2>Edit Category</h2>
                                <form id="editForm" enctype="multipart/form-data" method="POST" action="process_category.php">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                                    <div class="form-group">
                                        <label for="categoryName">Category Name:</label>
                                        <input type="text" name="newCategoryName" value="<?= htmlspecialchars($category['category_name']) ?>" required><br><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryDescription">Category Description:</label>
                                        <input type="text" name="newCategoryDescription" value="<?= htmlspecialchars($category['category_description']) ?>" required><br><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryPicture">Current Category Picture:</label><br>
                                        <input type="hidden" name="oldImage" value="<?= htmlspecialchars($category['category_picture']); ?>">
                                        <img src="../category_img/<?= htmlspecialchars($category['category_picture']) ?>" alt="Current Category Picture">
                                    </div>
                                    <div class="form-group">
                                        <label for="newCategoryImage">New Category Picture:</label><br>
                                        <input type="file" name="newCategoryImage" accept="image/*"><br><br>
                                    </div>
                                    <button class="save-btn" type="submit">Save</button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Add Modal -->
                <div id="addModal" class="modal">
                    <div class="modal-content">
                        <button class="close-btn" onclick="closeAddModal()">X</button>
                        <h2>Add Category</h2>
                        <form id="addForm" enctype="multipart/form-data" method="POST" action="process_category.php">
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
                            <button class="save-btn" type="submit">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Display SweetAlert if there is a message in the session
        if (isset($_SESSION['sweetalert'])): ?>
        <script>
        Swal.fire({
            icon: '<?= $_SESSION['sweetalert']['type']; ?>',
            title: '<?= $_SESSION['sweetalert']['type'] === 'success' ? 'Success' : 'Error'; ?>',
            text: '<?= $_SESSION['sweetalert']['message']; ?>',
            confirmButtonColor: '#000',
            iconColor: '<?= $_SESSION['sweetalert']['type'] === 'success' ? '#000' : '#000'; ?>'
        });
        </script>
        <?php
        unset($_SESSION['sweetalert']);
        endif;
        ?>

    
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
       
       <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
       <script>
       let table = new DataTable('#myTable', {
// options
});
</script>
<script>
            function openAddModal() {
                document.getElementById('addModal').style.display = 'flex';
            }

            function closeAddModal() {
                document.getElementById('addModal').style.display = 'none';
            }

            function confirmDelete(button) {
                const form = button.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#db4f4f',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    </div>
</body>

</html>
