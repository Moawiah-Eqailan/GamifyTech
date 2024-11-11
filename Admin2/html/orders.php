<?php
include "includes/header.php";
include "model/Orders.php";
$orders = new Order();
$allOrders = $orders->getAllOrders();
?>
<style>
      .save-btn-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    
  }

  .modal-content {
  width: 30%;
  }
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <h2 class="h2">Orders Dashboard</h2>
        <div class="row">
            <table class="table tb table-hover text-center" id="myTable">
                <thead class="t-head">
                <tr>
                    <th>Order ID</th>
                   
                    <th>Order Date</th>
                    <th>Order Total</th>
                
                 
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($allOrders)): ?>
                    <?php foreach ($allOrders as $order): ?>
                        <tr id="order-row-<?php echo htmlspecialchars($order['order_id']); ?>">
                            <td data-label="Order ID"><?php echo htmlspecialchars($order['order_id']); ?></td>
                           
                            <td data-label="Order Date"><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td data-label="Order Total"><?php echo htmlspecialchars($order['order_total']); ?></td>
                            
                           
                            <td data-label="Order Status" id="status-<?php echo htmlspecialchars($order['order_id']); ?>">
                                <?php echo htmlspecialchars($order['order_status']); ?>
                            </td>
                            <td>
                                <button class="edit-btn"
                                        onclick="openOrderModal(
                                            '<?php echo htmlspecialchars($order['order_id']); ?>',
                                            '<?php echo htmlspecialchars($order['user_name']); ?>',
                                            '<?php echo htmlspecialchars($order['order_date']); ?>',
                                            '<?php echo htmlspecialchars($order['order_total']); ?>',
                                            '<?php echo htmlspecialchars($order['order_status']); ?>',
                                            '<?php echo htmlspecialchars($order['order_discount']); ?>'
                                        )">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="edit-status-btn edit-btn "
                                        onclick="openEditStatusModal(
                                            '<?php echo htmlspecialchars($order['order_id']); ?>',
                                            '<?php echo htmlspecialchars($order['order_status']); ?>'
                                        )">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No orders found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeEditModal()">X</button>
            <h3>Order Details</h3>
            <div>
                <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
                <p><strong>User Name:</strong> <span id="modalUserName"></span></p>
                <p><strong>Order Date:</strong> <span id="modalOrderDate"></span></p>
                <p><strong>Order Total:</strong> <span id="modalOrderTotal"></span></p>
                <p><strong>Order Status:</strong> <span id="modalOrderStatus"></span></p>
                <p><strong>Order Discount:</strong> <span id="modalOrderDiscount"></span></p>
            </div>
            <div id="orderDetailsContainer">
                <!-- Order details will be populated here via JavaScript -->
            </div>
            <button class="close-btn" onclick="closeEditModal()">Close</button>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div class="modal" id="editStatusModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeEditStatusModal()">X</button>
            <h3>Edit Order Status</h3>
            <form id="editStatusForm">
                <input type="hidden" id="editOrderId" name="order_id">
                <label for="orderStatus">Order Status:</label>
                <select id="editOrderStatus" name="order_status">
                    <option value="Pending">Pending</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="delivered">delivered</option>
                 
                </select>
                <br><br>
                <div class="save-btn-container">
                <button type="submit" class="save-btn">Save</button>    
                </div>
                
            </form>
        </div>
    </div>

</div>

<script>
    function openOrderModal(orderId, userName, orderDate, orderTotal, orderStatus, orderDiscount) {
        document.getElementById("modalOrderId").textContent = orderId;
        document.getElementById("modalUserName").textContent = userName;
        document.getElementById("modalOrderDate").textContent = orderDate;
        document.getElementById("modalOrderTotal").textContent = "$" + orderTotal;
        document.getElementById("modalOrderStatus").textContent = orderStatus;
        document.getElementById("modalOrderDiscount").textContent = orderDiscount + "%";

        showModal("viewModal", orderId);
    }

    function openEditStatusModal(orderId, currentStatus) {
    document.getElementById('editOrderId').value = orderId;
    document.getElementById('editOrderStatus').value = currentStatus;
    showModal("editStatusModal");
}


    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    function closeEditStatusModal() {
        document.getElementById('editStatusModal').style.display = 'none';
    }

    // Handle form submission for updating order status
    document.getElementById('editStatusForm').addEventListener('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    fetch('process/update_order_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const orderId = formData.get('order_id');
        const newStatus = formData.get('order_status');

        // Close the modal first
        closeEditStatusModal();

        if (data.success) {
            // Update status on the page
            document.getElementById('status-' + orderId).textContent = newStatus;

            // Show success SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Order status has been updated successfully.',
                confirmButtonText: 'OK'
            });
        } else {
            // Show error SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to update order status.',
                confirmButtonText: 'Try Again'
            });
        }
    })
    .catch(error => {
        // Close the modal first
        closeEditStatusModal();

        // Show SweetAlert for fetch error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating the order status.',
            confirmButtonText: 'OK'
        });
    });
});


</script>

<?php
include("includes/footer.php");
?>