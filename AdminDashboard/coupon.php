<?php
session_start();
include("includes/header.php");
require_once 'model/Coupon.php';

$couponModel = new Coupon();
$coupons = $couponModel->getAllCoupons();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
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
            cursor: pointer;
            border: none;
            padding: 10px;
        }
        .button1 {
            background: #000;
        }
        .button__text {
            color: white;
        }
        .table_pro_item {
            padding-top: 5rem;
            padding-bottom: 3rem;
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
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Coupon dashboard</h1>

        <div class="">
            <div>
                <button type="button" class="addbutton" onclick="openAddModal()">
                    <span class="button__text">Add Coupon</span>
                    <span class="button__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                            <line y2="19" y1="5" x2="12" x1="12"></line>
                            <line y2="12" y1="12" x2="19" x1="5"></line>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="table_pro_item">
                <h2>Coupon Table</h2>
                <table class="responsive-table" id="myTable">
                    <thead>
                        <tr>
                            <th>Coupon Id</th>
                            <th>Coupon Name</th>
                            <th>Coupon Discount</th>
                            <th>Deadline</th>
                            <th>Validity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $coupon): ?>
                        <tr>
                            <td><?= htmlspecialchars($coupon['coupon_id']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_name']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_discount']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_expiry_date']); ?></td>
                            <td><?= htmlspecialchars($coupon['coupon_status']); ?></td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="openEditModal(this)"><i class="bi bi-pencil-square"></i></button>
                                    <form method="POST" action="process_coupon.php" style="display:inline;">
                                        <input type="hidden" name="action" value="delete_coupon">
                                        <input type="hidden" name="coupon_id" value="<?= htmlspecialchars($coupon['coupon_id']); ?>">
                                        <button class="delete-btn" type="button" onclick="confirmDelete(this)"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Modal, Edit Modal, Footer, and Scripts here -->
    </div> <!-- End of Content Wrapper -->
    
    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeEditModal()">X</button>
            <h2>Edit Coupon</h2>
            <form id="editForm" action="process_coupon.php" method="POST">
                <input type="hidden" name="action" value="edit_coupon">
                <input type="hidden" id="editCouponId" name="coupon_id" required>
                <div class="form-group">
                    <label for="editCouponName">Coupon Name:</label>
                    <input type="text" id="editCouponName" name="coupon_name">
                </div>
                <div class="form-group">
                    <label for="editDiscount">Coupon Discount:</label>
                    <input type="text" id="editDiscount" name="coupon_discount">
                </div>
                <div class="form-group">
                    <label for="editExpiryDate">Deadline:</label>
                    <input type="date" id="editExpiryDate" name="coupon_expiry_date">
                </div>
                <div class="form-group">
                    <label for="editStatus">Validity:</label>
                    <select id="editStatus" name="coupon_status">
                        <option value="Valid">Valid</option>
                        <option value="Invalid">Invalid</option>
                    </select>
                </div>
                <button class="save-btn" type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeAddModal()">X</button>
            <h2>Add Coupon</h2>
            <form id="addForm" action="process_coupon.php" method="POST">
                <input type="hidden" name="action" value="add_coupon">
                <div class="form-group">
                    <label for="coupon_name">Coupon Name:</label>
                    <input type="text" id="coupon_name" name="coupon_name">
                </div>
                <div class="form-group">
                    <label for="coupon_discount">Coupon Discount:</label>
                    <input type="text" id="coupon_discount" name="coupon_discount">
                </div>
                <div class="form-group">
                    <label for="coupon_expiry_date">Deadline:</label>
                    <input type="date" id="coupon_expiry_date" name="coupon_expiry_date">
                </div>
                <div class="form-group">
                    <label for="coupon_status">Validity:</label>
                    <select id="coupon_status" name="coupon_status">
                        <option value="Valid">Valid</option>
                        <option value="Invalid">Invalid</option>
                    </select>
                </div>
                <button class="save-btn" type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
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
    <?php unset($_SESSION['sweetalert']); endif; ?>

    <script>
        function confirmDelete(button) {
            const form = button.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won’t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000',
                cancelButtonColor: '#db4f4f',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function openEditModal(button) {
            const row = button.closest('tr');
            const cells = row.getElementsByTagName('td');
            document.getElementById('editCouponId').value = cells[0].innerText;
            document.getElementById('editCouponName').value = cells[1].innerText;
            document.getElementById('editDiscount').value = cells[2].innerText;
            document.getElementById('editExpiryDate').value = cells[3].innerText;
            document.getElementById('editStatus').value = cells[4].innerText;
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function openAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }

        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
       
       <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
       <script>
       let table = new DataTable('#myTable', {
// options
});
</script>
</body>

</html>
