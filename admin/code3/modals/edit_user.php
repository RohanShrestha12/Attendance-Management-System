<!-- modals/edit_user.php -->
<?php
include '../../database/db.php';
$user_id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
$user = $result->fetch_assoc();
?>

<div class="modal-dialog">
    <div class="modal-content">
        <form id="editUserForm">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form fields -->
                <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?= $user['username']; ?>" required>
                </div>
                <!-- Additional fields like email and role -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= $user['email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                        <!-- Add more roles if needed -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#editUserForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'actions/edit_user.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#editModal').modal('hide');
                loadContent('manage_users.php');
            }
        });
    });
</script>
