<?php
include("includes/header.php");
include "model/Orders.php";

$orders = new Order();
$allOrders = $orders->getAllOrders();

$orderDetails = []; // Initialize the orderDetails array
$orderDetailsError = ""; // Initialize error message

// Check if an order ID is provided for fetching details
if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']); // Ensure the order ID is an integer
    $orderDetails = $orders->viewOrderDetails($orderId); // Fetch order details

    if ($orderDetails === false || empty($orderDetails)) {
        $orderDetailsError = "Error retrieving order details.";
    }
}
?>

<style>
    /* Your existing styles here... */
    .modal {
        display: none;
        justify-content: center;
        align-items: center;
        overflow: auto;
        position: fixed; /* Fix position for the modal */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    }

    .modal-content {
        text-align: center;
        margin: auto;
        background: white; /* Background for modal content */
        padding: 20px;
        border-radius: 5px; /* Rounded corners */
        width: 80%; /* Responsive width */
        max-width: 600px; /* Max width for large screens */
    }

    .close-btn {
        background: #db4f4f;
        border: none;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px;
    }

    /* Other styles... */
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Orders dashboard</h1>

    <div class="table-container">
        <table class="responsive-table col-12" id="myTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Order Date</th>
                    <th>Order Total</th>
                    <th>Order Coupon</th>
                    <th>Discount</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($allOrders)): ?>
                    <?php foreach ($allOrders as $order): ?>
                        <tr id="order-row-<?php echo htmlspecialchars($order['order_id']); ?>">
                            <td data-label="Order ID"><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td data-label="User Name"><?php echo htmlspecialchars($order['user_name']); ?></td>
                            <td data-label="Order Date"><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td data-label="Order Total"><?php echo htmlspecialchars($order['order_total']); ?></td>
                            <td data-label="Order Coupon"><?php echo htmlspecialchars($order['order_coupon']); ?></td>
                            <td data-label="Discount"><?php echo htmlspecialchars($order['order_discount']); ?>%</td>
                            <td data-label="Order Status"><?php echo htmlspecialchars($order['order_status']); ?></td>
                            <td>
                                <button class="edit-btn" 
                                        onclick="openOrderModal('<?php echo htmlspecialchars($order['order_id']); ?>')">
                                    View Order
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
        <div id="orderDetailsContainer">
            <?php if ($orderDetailsError): ?>
                <p><?php echo htmlspecialchars($orderDetailsError); ?></p>
            <?php elseif (!empty($orderDetails)): 
                $grandTotal = 0; // Initialize grand total for the order
            ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Items from Order</h4>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderDetails as $item): 
                                        $itemTotal = $item['price'] * $item['product_quantity'];
                                        $grandTotal += $itemTotal;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['product_quantity']); ?></td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                        <td>$<?php echo number_format($itemTotal, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                                        <td>$<?php echo number_format($grandTotal, 2); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <p>No order details available.</p>
            <?php endif; ?>
        </div>
        <button class="close-btn" onclick="closeEditModal()">Close</button>
    </div>
</div>

<script>
    function openOrderModal(orderId) {
        // Open the modal
        document.getElementById('viewModal').style.display = 'flex';
        
        // Fetch order details via AJAX
        fetchOrderDetails(orderId);
    }

    function fetchOrderDetails(orderId) {
        fetch('fetch_order_details.php?order_id=' + orderId)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('orderDetailsContainer');
                container.innerHTML = ''; // Clear previous content

                if (data.success) {
                    let tableHTML = `
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                    
                    let grandTotal = 0;

                    data.orderDetails.forEach(item => {
                        const itemTotal = item.price * item.product_quantity;
                        grandTotal += itemTotal;

                        tableHTML += `
                            <tr>
                                <td>${item.product_name}</td>
                                <td>${item.product_quantity}</td>
                                <td>$${item.price.toFixed(2)}</td>
                                <td>$${itemTotal.toFixed(2)}</td>
                            </tr>`;
                    });

                    tableHTML += `
                        <tr>
                            <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                            <td>$${grandTotal.toFixed(2)}</td>
                        </tr>
                    </tbody>
                    </table>
                    </div>`;

                    container.innerHTML = tableHTML;
                } else {
                    container.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(error => {
                const container = document.getElementById('orderDetailsContainer');
                container.innerHTML = `<p>Error fetching order details.</p>`;
            });
    }

    function closeEditModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    // Close modal if clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('viewModal');
        if (event.target === modal) {
            closeEditModal();
        }
    }
</script>
