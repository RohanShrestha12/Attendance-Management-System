<?php
include '../database/db.php';

// Handle form submissions for adding new location
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_location'])) {
    // Your logic for adding a new location goes here
}

// Fetch locations from the database
$locations = []; // Fetch from your database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Locations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Manage Locations</h2>
    <form method="POST" action="">
        <input type="text" name="location_name" placeholder="Location Name" required>
        <button type="submit" name="add_location">Add Location</button>
    </form>
    
    <h3>Existing Locations</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Location ID</th>
                <th>Location Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locations as $location): ?>
                <tr>
                    <td><?= $location['location_id'] ?></td>
                    <td><?= $location['location_name'] ?></td>
                    <td>
                        <a href="edit_location.php?id=<?= $location['location_id'] ?>">Edit</a>
                        <a href="delete_location.php?id=<?= $location['location_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
