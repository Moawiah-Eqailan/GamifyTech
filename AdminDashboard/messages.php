<?php
include("includes/header.php");
require_once 'model/contactUsClass.php';  // Include the messages model
?>

<style>
    .modal {
        display: none;
        justify-content: center;
        align-items: center;
        overflow: auto;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        text-align: center;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 5px;
        width: 80%;
        max-width: 600px;
    }

    .close-btn {
        background: #db4f4f;
        border: none;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px;
    }
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Contact Messages</h1>

    <div class="table-container">
        <table class="responsive-table col-12" id="myTable">
            <thead>
                <tr>
                    <th>Message ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $messageModel = new messages();
                $messages = $messageModel->getAllMessages();

                if (!empty($messages)) {
                    foreach ($messages as $message) {
                        echo "<tr id='message-row-{$message['contact_us_id']}'>
                                <td data-label='Message ID'>{$message['contact_us_id']}</td>
                                <td data-label='User Name'>{$message['full_name']}</td>
                                <td data-label='Email'>{$message['user_email']}</td>
                                <td data-label='Subject'>{$message['subject']}</td>
                                <td>
                                    <button class='edit-btn' onclick='openMessageModal({$message['contact_us_id']})'>View Message</button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No messages found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal" id="viewMessageModal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeMessageModal()">X</button>
        <h3>Message Details</h3>
        <div id="messageDetailsContainer">
            <p><strong>Sender:</strong> <span id="messageSender"></span></p>
            <p><strong>Email:</strong> <span id="messageEmail"></span></p>
            <p><strong>Subject:</strong> <span id="messageSubject"></span></p>
            <p><strong>Message:</strong><br> <span id="messageText"></span></p>
        </div>
        <button class="close-btn" onclick="closeMessageModal()">Close</button>
    </div>
</div>

<script>
    function openMessageModal(contactUsId) {
        document.getElementById('viewMessageModal').style.display = 'flex';
        fetchMessageDetails(contactUsId);
    }

    function fetchMessageDetails(contactUsId) {
        fetch('fetch_message_details.php?contact_us_id=' + contactUsId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const sender = document.getElementById('messageSender');
                const email = document.getElementById('messageEmail');
                const subject = document.getElementById('messageSubject');
                const text = document.getElementById('messageText');

                if (data.success) {
                    const messageDetails = data.messageDetails; // Single message object
                    sender.innerText = messageDetails.full_name; // Set sender name
                    email.innerText = messageDetails.user_email; // Set email
                    subject.innerText = messageDetails.subject; // Set subject
                    text.innerText = messageDetails.message; // Set message body
                } else {
                    sender.innerText = ''; // Clear previous content
                    email.innerText = '';
                    subject.innerText = '';
                    text.innerText = `Error: ${data.message}`; // Display error message
                }
            })
            .catch(error => {
                const sender = document.getElementById('messageSender');
                const email = document.getElementById('messageEmail');
                const subject = document.getElementById('messageSubject');
                const text = document.getElementById('messageText');

                sender.innerText = ''; // Clear previous content
                email.innerText = '';
                subject.innerText = '';
                text.innerText = 'Error fetching message details: ' + error.message; // Display error
            });
    }

    function closeMessageModal() {
        document.getElementById('viewMessageModal').style.display = 'none';
    }

    // Close modal if clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('viewMessageModal');
        if (event.target === modal) {
            closeMessageModal();
        }
    }
</script>