<?php
session_start();
include "includes/header.php";
require_once 'model/User.php'; 
$user = new User();

// Get users
$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            color: #FFFECB;
            background-color: #FFFECB;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #000;
            border-radius: 5px;
        }

        .pagination .page-item.active .page-link {
            color: #FFFECB;
            background-color: #FFFECB;
        }

        .pagination .page-item.disabled .page-link {
            color: #FFFECB;
            background-color: #fff;
        }

        .pagination .page-link:hover {
            background-color: #FFFECB;
            color: #fff;
        }
        .nav-link-text {
            color: #FFFECB;
            font-weight: bold;
            }
        .nav-link-text:hover, i:hover
        {
            color: #fff870;
            transform: scale(1.1);
        }
        .modal {
            display: none;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .modal-content {
            background-color: #7AB2D3;
            padding: 20px;
            border-radius: 15px;
            width: 50%;
            text-align: center;
            color: #FFFECB;
        }

        .close-btn {
            background: #db4f4f;
            color: white;
            border: none;
            cursor: pointer;
            float: right;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800" style="color:#858796;">Users Dashboard</h1>

        <div class="row mb-3 ">
            <div>
                <button type="button" class="addbutton"  onclick="openAddModal()">
                    <span class="button__text">Add New User</span>
                    <span class="button__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                        <line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <div class="pt-5 pb-3 table_pro_item">
        <h2>Users Table</h2>
        <table class="responsive-table table_pro_item " id="myTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td data-label="User ID"><?php echo htmlspecialchars($u['user_id']); ?></td>
                    <td data-label="First Name"><?php echo htmlspecialchars($u['user_first_name']); ?></td>
                    <td data-label="Last Name"><?php echo htmlspecialchars($u['user_last_name']); ?></td>
                    <td data-label="Email"><?php echo htmlspecialchars($u['user_email']); ?></td>
                    <td data-label="Gender"><?php echo htmlspecialchars($u['user_gender']); ?></td>
                    <td data-label="Birth Date"><?php echo htmlspecialchars($u['user_birth_date']); ?></td>
                    <td data-label="Phone Number"><?php echo htmlspecialchars($u['user_phone_number']); ?></td>
                    <td data-label="Address"><?php echo htmlspecialchars($u['user_address']); ?></td>
                    <td data-label="State"><?php echo htmlspecialchars($u['user_status']); ?></td>
                    <td data-label="Role"><?php echo htmlspecialchars($u['user_role']); ?></td>
                    <td data-label="Actions">
                        <div class="action-buttons">
                            <button class="edit-btn" onclick="openEditModal(this, <?php echo $u['user_id']; ?>)"><i class="bi bi-pencil-square"></i></button>
                            <form method="POST" action="process_user.php" style="display: inline;">
                                <input type="hidden" name="deleteUserId" value="<?php echo $u['user_id']; ?>">
                                <button class="delete-btn" type="button" onclick="confirmDelete(this)"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <div class="modal" id="editModal">
            <div class="modal-content">
                <button class="close-btn" onclick="closeEditModal()">X</button>
                <h3>Edit User</h3>
                <form id="editForm" method="POST" action="process_user.php">
                    <input type="hidden" id="editUserId" name="editUserId">
                    <div class="form-group"><label for="firstName">First Name:</label><input type="text" id="firstName" name="editFirstName" required></div>
                    <div class="form-group"><label for="lastName">Last Name:</label><input type="text" id="lastName" name="editLastName" required></div>
                    <div class="form-group"><label for="email">Email:</label><input type="email" id="email" name="editEmail" required></div>
                    <div class="form-group"><label for="gender">Gender:</label><select id="gender" name="editGender"><option value="male">Male</option><option value="female">Female</option></select></div>
                    <div class="form-group"><label for="birthDate">Birth Date:</label><input type="date" id="birthDate" name="editBirthDate" required></div>
                    <div class="form-group"><label for="phone">Phone Number:</label><input type="text" id="phone" name="editPhone" required></div>
                    <div class="form-group"><label for="address">Address:</label><input type="text" id="address" name="editAddress" required></div>
                    <div class="form-group"><label for="editState">State:</label><select id="editState" name="editState" required><option value="active">Active</option><option value="deactivated">Deactivated</option></select></div>
                    <div class="form-group"><label for="role">Role:</label><select id="role" name="editRole" required><option value="superAdmin">Super Admin</option><option value="admin">Admin</option><option value="customer">User</option></select></div>
                    <button class="save-btn" type="submit">Save User</button>
                </form>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal" id="addModal">
            <div class="modal-content">
                <button class="close-btn" onclick="closeAddModal()">X</button>
                <h3>Add New User</h3>
                <form id="addForm" method="POST" action="process_user.php">
                    <div class="form-group"><label for="newFirstName">First Name:</label><input type="text" id="newFirstName" name="newFirstName" required></div>
                    <div class="form-group"><label for="newLastName">Last Name:</label><input type="text" id="newLastName" name="newLastName" required></div>
                    <div class="form-group"><label for="newEmail">Email:</label><input type="email" id="newEmail" name="newEmail" required></div>
                    <div class="form-group"><label for="newGender">Gender:</label><select id="newGender" name="newGender" required><option value="male">Male</option><option value="female">Female</option></select></div>
                    <div class="form-group"><label for="newBirthDate">Birth Date:</label><input type="date" id="newBirthDate" name="newBirthDate" required></div>
                    <div class="form-group"><label for="newPhone">Phone Number:</label><input type="text" id="newPhone" name="newPhone" required></div>
                    <div class="form-group"><label for="newAddress">Address:</label><input type="text" id="newAddress" name="newAddress" required></div>
                    <div class="form-group"><label for="newState">State:</label><select id="newState" name="newState" required><option value="active">Active</option><option value="deactivated">Deactivated</option></select></div>
                    <div class="form-group"><label for="newRole">Role:</label><select id="newRole" name="newRole" required><option value="superAdmin">Super Admin</option><option value="admin">Admin</option><option value="customer">User</option></select></div>
                    <button class="save-btn" type="submit">Add User</button>
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
            title: '<?= $_SESSION['sweetalert']['type'] === 'success' ? 'success' : 'Error'; ?>',
            text: '<?= $_SESSION['sweetalert']['message']; ?>',
            confirmButtonColor: '#000',
            iconColor: '<?= $_SESSION['sweetalert']['type'] === 'success' ? '#000' : '#000'; ?>'
        });
        </script>
        <?php
        unset($_SESSION['sweetalert']);
        endif;
        ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openAddModal() {
            $('#addModal').css('display', 'flex');
        }

        function closeAddModal() {
            $('#addModal').css('display', 'none');
        }

        function openEditModal(button, userId) {
            const row = $(button).closest('tr');
            $('#editUserId').val(userId);
            $('#firstName').val(row.find('td:eq(1)').text());
            $('#lastName').val(row.find('td:eq(2)').text());
            $('#email').val(row.find('td:eq(3)').text());
            $('#gender').val(row.find('td:eq(4)').text());
            $('#birthDate').val(row.find('td:eq(5)').text());
            $('#phone').val(row.find('td:eq(6)').text());
            $('#address').val(row.find('td:eq(7)').text());
            $('#editState').val(row.find('td:eq(8)').text());
            $('#role').val(row.find('td:eq(9)').text());
            $('#editModal').css('display', 'flex');
        }

        function closeEditModal() {
            $('#editModal').css('display', 'none');
        }

        function confirmDelete(button) {
    const form = button.closest('form');
    const userId = form.querySelector('input[name="deleteUserId"]').value;

    Swal.fire({
        title: 'Are you sure?',
        text: "This user will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#db4f4f',
        cancelButtonColor: '#000',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
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
