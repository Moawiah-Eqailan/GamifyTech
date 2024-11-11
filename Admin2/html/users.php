<?php 
 session_start();
 include "includes/header.php";
 require_once 'model/User.php'; 
 $user = new User();
 $users = $user->getAllUsers();
?>
<!-- ============================================================== -->
<!-- Page wrapper -->
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
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Container fluid -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <h2 class="h2">Users Dashboard</h2>
        <button class="add-btn" onclick="openAddModal()">Add user <i class="bi bi-plus-circle"></i></button>
        <div class="row">
            <table class="table tb table-hover" id="myTable">
                <thead class="t-head">
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>user Role</th>
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
                           
                        
                            <td data-label="Role"><?php echo htmlspecialchars($u['user_role']); ?></td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="openEditModal(<?= $u['user_id'] ?>)"><i class="bi bi-pencil-square"></i></button>
                                    <form method="POST" action="process/process_user.php" style="display: inline;">
                                        <input type="hidden" name="deleteUserId" value="<?php echo $u['user_id']; ?>">
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

<!-- Edit Modal for each user -->
<?php foreach ($users as $u): ?>
<div id="editModal<?= $u['user_id'] ?>" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="hideModal('editModal<?= $u['user_id'] ?>')">X</button>
        <h3>Edit User</h3>
        <form id="editForm<?= $u['user_id'] ?>" method="POST" action="process/process_user.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="editUserId" value="<?= htmlspecialchars($u['user_id']) ?>">

            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" name="editFirstName" value="<?= htmlspecialchars($u['user_first_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" name="editLastName" value="<?= htmlspecialchars($u['user_last_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="editEmail" value="<?= htmlspecialchars($u['user_email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="editGender" required>
                    <option value="male" <?= ($u['user_gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?= ($u['user_gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="birthDate">Birth Date:</label>
                <input type="date" name="editBirthDate" value="<?= htmlspecialchars($u['user_birth_date']) ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="editPhone" value="<?= htmlspecialchars($u['user_phone_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="editAddress" value="<?= htmlspecialchars($u['user_address']) ?>" required>
            </div>

            <div class="form-group">
                <label for="editState">State:</label>
                <select name="editState" required>
                    <option value="active" <?= ($u['user_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="deactivated" <?= ($u['user_status'] == 'deactivated') ? 'selected' : ''; ?>>Deactivated</option>
                </select>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select name="editRole" required>
                    <option value="superAdmin" <?= ($u['user_role'] == 'superAdmin') ? 'selected' : ''; ?>>Super Admin</option>
                    <option value="admin" <?= ($u['user_role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="customer" <?= ($u['user_role'] == 'customer') ? 'selected' : ''; ?>>User</option>
                </select>
            </div>
            <div class="save-btn-container">
                <button class="save-btn" type="submit">Save User</button>
            </div>
            
        </form>
    </div>
</div>
<?php endforeach; ?>


    <!-- Add User Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeAddModal()">X</button>
            <h3>Add New User</h3>
            <form id="addForm" method="POST" action="process/process_user.php">
                <div class="form-group"><label for="newFirstName">First Name:</label><input type="text" id="newFirstName" name="newFirstName" required></div>
                <div class="form-group"><label for="newLastName">Last Name:</label><input type="text" id="newLastName" name="newLastName" required></div>
                <div class="form-group"><label for="newEmail">Email:</label><input type="email" id="newEmail" name="newEmail" required></div>
                <div class="form-group"><label for="newGender">Gender:</label><select id="newGender" name="newGender" required><option value="male">Male</option><option value="female">Female</option></select></div>
                <div class="form-group"><label for="newBirthDate">Birth Date:</label><input type="date" id="newBirthDate" name="newBirthDate" required></div>
                <div class="form-group"><label for="newPhone">Phone Number:</label><input type="text" id="newPhone" name="newPhone" required></div>
                <div class="form-group"><label for="newAddress">Address:</label><input type="text" id="newAddress" name="newAddress" required></div>
                <div class="form-group"><label for="newState">State:</label><select id="newState" name="newState" required><option value="active">Active</option><option value="deactivated">Deactivated</option></select></div>
                <div class="form-group"><label for="newRole">Role:</label><select id="newRole" name="newRole" required><option value="superAdmin">Super Admin</option><option value="admin">Admin</option><option value="customer">User</option></select></div>
                <div class="save-btn-container">
                <button class="save-btn" type="submit">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- End of page-wrapper -->
    

<?php
include "includes/footer.php";
?>