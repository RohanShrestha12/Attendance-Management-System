<?php
include '../database/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_query = "SELECT * FROM users";
                $result = $conn->query($user_query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary btn-edit' data-id='" . $row['user_id'] . "' data-username='" . $row['username'] . "' data-email='" . $row['email'] . "' data-role='" . $row['role'] . "'>Edit</button> ";
                    echo "<button class='btn btn-danger btn-delete' data-id='" . $row['user_id'] . "'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).on('click', '.btn-edit', function() {
            var userId = $(this).data('id');
            var username = $(this).data('username');
            var email = $(this).data('email');
            var role = $(this).data('role');
            
            $('#modalTitle').text("Edit User");
            $('#userId').val(userId);
            $('#username').val(username);
            $('#email').val(email);
            $('#role').val(role);
            $('#saveBtn').text("Save Changes");
            $('#addModal').modal('show');
        });

        $(document).on('click', '.btn-delete', function() {
            var userId = $(this).data('id');
            if (confirm("Are you sure you want to delete this user?")) {
                // Handle deletion via AJAX or by submitting a form
            }
        });
    </script>
</body>
</html>
