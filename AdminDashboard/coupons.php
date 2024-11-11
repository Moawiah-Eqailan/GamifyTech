<?php
 include("includes/header.php");
 include "classes/couponsClass.php";
 $coupons = new coupon();
 $allCoupons=$coupons->getAllCoupons();

?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">coupons dashboard</h1>

                    <div class="row">
                        <div>
                            <button type="button" class="button1" onclick="openAddModal()">
                                <span class="button__text">Add coupon</span>
                                <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                              </button>
                        </div>
                        <div class="pt-5 pb-3 col-12 table_pro_item">
                         
    <table class="responsive-table" id="couponsTable">
        <thead>
            <tr>
                <th>coupon ID</th>
                <th>coupon name</th>
                <th>Coupon discount</th>
                <th>coupon expiry date</th>
                <th>coupon status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
                                    if ($allCoupons)
                                    {
                                        foreach($allCoupons as $coupon)
                                        {
                                            echo"<tr id='coupon-row-{$coupon['coupon_id']}'>
                        <td data-label='coupon ID'>{$coupon['coupon_id']}</td>
                        <td data-label='coupon  Name'>{$coupon['coupon_name']}</td>
                        <td data-label='coupon discount'>{$coupon['coupon_discount']}</td>
                        <td data-label='coupon expiry date'>
                            {$coupon['coupon_expiry_date']}
                        </td>
                        <td data-label='coupon status'>
                            {$coupon['coupon_status']}
                        </td>
                       
                  
                        <td data-label='Actions'>
                            <div class='action-buttons'>
                                <button class='edit-btn' onclick='openEditModal({$coupon['coupon_id']})'>Edit</button>
                                <button class='delete-btn' onclick='softDeleteCoupon({$coupon['coupon_id']})'>Delete</button>
                            </div>
                        </td>
                        
                    </tr>";
                                        }

                                    } else 
                                    {
                                        echo "<tr?><td colspan='6'>no coupons found.</td></tr>";
                                    }
                                    ?>
            
        </tbody>
    </table>
                        </div>
                </div>
                <!-- /.container-fluid -->
    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeEditModal()">X</button>
            <h3>Edit User</h3>
            <form id="editForm">
                <div class="form-group">
                    <label for="edit_coupon_name">coupon name:</label>
                    <input type="text" id="edit_coupon_name" name="edit_coupon_name">
                </div>
                <div class="form-group">
                    <label for="edit_coupon_discount">coupon discount:</label>
                    <input type="number" id="edit_coupon_discount" name="edit_coupon_discount">
                </div>
                <div class="form-group">
                    <label for="update_coupon_expiry_date">coupon expiry date:</label>
                    <input type="date" id="update_coupon_expiry_date" name="update_coupon_expiry_date">
                </div>
                <div class="form-group">
                    <label for="update_coupon_status">coupon status:</label>
             <select name="update_coupon_status" id="update_coupon_status">
               <option value="valid">valid</option>
               <option value="expired">expired</option>
            
  </select>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

        <!-- Add coupon Modal -->
        <div class="modal" id="addModal">
            <div class="modal-content">
                <button class="close-btn" onclick="closeAddModal()">X</button>
                <h3>Add New coupon</h3>
                <form id="addForm"method="POST" action="addCoupon.php">
                    <div class="form-group">
                        <label for="coupon_name">coupon Name:</label>
                        <input type="text" id="coupon_name" name="coupon_name">
                    </div>
                    <div class="form-group">
                        <label for="coupon_discount">discount percentage:</label>
                        <input type="number" id="coupon_discount" name="coupon_discount">
                    </div>
                    <div class="form-group">
                        <label for="coupon_expiry_date">expiry_date:</label>
                        <input type="date" id="coupon_expiry_date" name="coupon_expiry_date">
                    </div>
                    <div class="form-group">
                        <label for="coupon_status">coupon status:</label>
                        <select name="coupon_status" id="coupon_status">
                          <option value="valid">valid</option>
                          <option value="expired">expired</option>
                        </select>
                    </div>
                    <button class="btn save-btn" type="submit"name="add_coupon" >add coupon</button>
                   
                    
                </form>
            </div>
        </div>


            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
            let table = new DataTable('#couponsTable');

</script>

    <script>
        function softDeleteCategory(couponId) {
    if (confirm("Are you sure you want to delete this coupon?")) {
        fetch('softDeleteCoupon.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ coupon_id: couponId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optionally hide the deleted coupon row from the table
                document.getElementById(`coupon-row-${couponId}`).remove();
                alert("coupon deleted successfully!");
            } else {
                alert("Failed to delete the coupon.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while deleting the coupon.");
        });
    }
}
    </script>
</body>

</html>