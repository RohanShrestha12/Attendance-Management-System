<!-- modals/add_user.php -->
<div class="modal-dialog">
    <div class="modal-content">
        <form id="addUserForm">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form fields -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <!-- Additional fields like email and role -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <!-- Add more roles if needed -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#addUserForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'actions/add_user.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#addModal').modal('hide');
                loadContent('manage_users.php');
            }
        });
    });
</script>
