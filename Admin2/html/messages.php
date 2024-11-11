<?php
include 'includes/header.php';
include 'model/contactUsClass.php';  // Include the messages model
$messages = new messages();
$allmessages = $messages->getAllMessages();
?>
<style>
    .modal-content
    {
        width: 50%;
    }
</style>
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
                            <li class="breadcrumb-item active" aria-current="page">Messages</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Start Page Content -->
        <h2 class="h2">Contact Messages Dashboard</h2>
        <div class="row">
            <table class="table tb table-hover" id="myTable">
                <thead class="t-head">
                    <tr>
                        <th>Message ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($allmessages)): ?>
                        <?php foreach ($allmessages as $message): ?>
                            <tr id="message-row-<?php echo htmlspecialchars($message['contact_us_id'] ?? ''); ?>">
                                <td data-label="Message ID"><?php echo htmlspecialchars($message['contact_us_id'] ?? ''); ?></td>
                                <td data-label="User Name"><?php echo htmlspecialchars($message['full_name'] ?? ''); ?></td>
                                <td data-label="Email"><?php echo htmlspecialchars($message['user_email'] ?? ''); ?></td>
                                <td data-label="Subject"><?php echo htmlspecialchars($message['subject'] ?? ''); ?></td>
                                <td>
                                    <button class="edit-btn" 
                                            onclick="openMessageModal(
                                                '<?php echo htmlspecialchars($message['contact_us_id'] ?? ''); ?>',
                                                '<?php echo htmlspecialchars($message['full_name'] ?? ''); ?>',
                                                '<?php echo htmlspecialchars($message['user_email'] ?? ''); ?>',
                                                '<?php echo htmlspecialchars($message['subject'] ?? ''); ?>',
                                                '<?php echo htmlspecialchars($message['message'] ?? ''); ?>'
                                            )">
                                       <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No messages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeMessageModal()">X</button>
            <h3>Message Details</h3>
            <div id="messageDetailsContainer">
                <p><strong>Sender:</strong> <span id="modalSender"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
                <p><strong>Message:</strong><br> <span id="modalMessage"></span></p>
            </div>
            <button class="close-btn" onclick="closeMessageModal()">Close</button>
        </div>
    </div>

    <script>
        function openMessageModal(contactUsId, sender, email, subject, message) {
            // Show the modal
            showModal("viewModal");

            // Populate modal fields with message details
            document.getElementById("modalSender").textContent = sender ?? '';
            document.getElementById("modalEmail").textContent = email ?? '';
            document.getElementById("modalSubject").textContent = subject ?? '';
            document.getElementById("modalMessage").textContent = message ?? '';
        }

        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeMessageModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('viewModal');
            if (event.target === modal) {
                closeMessageModal();
            }
        }
    </script>
</div>    

<?php
include("includes/footer.php");
?>