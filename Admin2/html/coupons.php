<?php
session_start();
include("includes/header.php");
require_once 'model/Coupon.php';
$couponModel = new Coupon();
$coupons = $couponModel->getAllCoupons();
?>
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
                            <li class="breadcrumb-item active" aria-current="page">Coupons</li>
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
        <h2 class="h2">Coupons Dashboard</h2>
        <button class="add-btn" onclick="openAddModal()">Add Coupon <i class="bi bi-plus-circle"></i></button>
        <div class="row">
            <table class="table tb table-hover" id="myTable">
                <thead class="t-head">
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
                                    <button class="edit-btn" onclick="openEditCouponModal(<?=$coupon['coupon_id']?>)"><i class="bi bi-pencil-square"></i></button>
                                    <form method="POST" action="process/process_coupon.php" style="display:inline;">
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
<!-- Loop through each coupon -->
<?php foreach ($coupons as $coupon): ?>
<div id="editModal<?= $coupon['coupon_id'] ?>" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="hideModal('editModal<?= $coupon['coupon_id'] ?>')">X</button>
        <h3>Edit Coupon</h3>
        <form id="editForm<?= $coupon['coupon_id'] ?>" action="process/process_coupon.php" method="POST">
            <input type="hidden" name="action" value="edit_coupon">
            <input type="hidden" name="coupon_id" value="<?= htmlspecialchars($coupon['coupon_id']) ?>">

            <div class="form-group">
                <label for="editCouponName<?= $coupon['coupon_id'] ?>">Coupon Name:</label>
                <input type="text" id="editCouponName<?= $coupon['coupon_id'] ?>" name="coupon_name" 
                       value="<?= htmlspecialchars($coupon['coupon_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="editDiscount<?= $coupon['coupon_id'] ?>">Coupon Discount:</label>
                <input type="text" id="editDiscount<?= $coupon['coupon_id'] ?>" name="coupon_discount" 
                       value="<?= htmlspecialchars($coupon['coupon_discount']) ?>" required>
            </div>

            <div class="form-group">
                <label for="editExpiryDate<?= $coupon['coupon_id'] ?>">Deadline:</label>
                <input type="date" id="editExpiryDate<?= $coupon['coupon_id'] ?>" name="coupon_expiry_date" 
                       value="<?= htmlspecialchars($coupon['coupon_expiry_date']) ?>" required>
            </div>

            <div class="form-group">
                <label for="editStatus<?= $coupon['coupon_id'] ?>">Validity:</label>
                <select id="editStatus<?= $coupon['coupon_id'] ?>" name="coupon_status" required>
                    <option value="Valid" <?= ($coupon['coupon_status'] == 'Valid') ? 'selected' : ''; ?>>Valid</option>
                    <option value="Invalid" <?= ($coupon['coupon_status'] == 'Invalid') ? 'selected' : ''; ?>>Invalid</option>
                </select>
            </div>
            <div class="save-btn-container">
            <button class="save-btn" type="submit">Save</button>        
            </div>
            
        </form>
    </div>
</div>
<?php endforeach; ?>


<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeAddModal()">X</button>
        <h3>Add Coupon</h3>
        <form id="addForm" action="process/process_coupon.php" method="POST">
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
            <div class="save-btn-container">
            <button class="save-btn" type="submit">Save</button>        
            </div>
            
        </form>
    </div>
</div>
<?php
include("includes/footer.php");
?>