<?php
// Fetch users from database
include('db.php');
$result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0) {
    echo "<h3 class='text-center mt-4'>Manage Users</h3>";
    echo "<button class='btn btn-primary mb-3' id='addUserBtn' data-bs-toggle='modal' data-bs-target='#addUserModal'>Add User</button>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead><tbody>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>
                <button class='btn btn-warning editBtn' data-id='" . $row['user_id'] . "'>Edit</button>
                <button class='btn btn-danger deleteBtn' data-id='" . $row['user_id'] . "'>Delete</button>
              </td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>No users found</p>";
}
?>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add user AJAX
    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        $.post('add_user.php', $(this).serialize(), function(response) {
            $('#addUserModal').modal('hide');
            $('#content-area').load('users.php');
        });
    });

    // Edit user functionality
    // Similar approach for edit and delete
</script>
