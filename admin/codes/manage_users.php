<?php
// Database connection
include '../database/db.php'; // Include your database connection

// Fetch users
$result = $conn->query("SELECT * FROM users");
$total_users = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add your Bootstrap CSS path -->
</head>
<body>

<div class="container mt-5">
    <h2>Manage Users</h2>
    <h5>Total Users: <?php echo $total_users; ?></h5>
    
    <button id="addBtn" class="btn btn-primary mb-3">Add User</button>
    
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['role']}</td>
                        <td>
                            <button class='btn btn-warning editUserBtn' data-id='{$row['user_id']}'>Edit</button>
                            <button class='btn btn-danger deleteUserBtn' data-id='{$row['user_id']}'>Delete</button>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include Modals -->
<?php include 'modals.php'; ?>

<script src="path/to/jquery.js"></script> <!-- Add your jQuery path -->
<script src="path/to/bootstrap.js"></script> <!-- Add your Bootstrap JS path -->
<script src="path/to/manage_users.js"></script> <!-- Your JS file for managing users -->
</body>
</html>
