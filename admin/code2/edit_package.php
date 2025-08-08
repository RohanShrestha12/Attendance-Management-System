<?php
include '../database/db.php';

if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    // Fetch package data for the given $package_id

    // Handle form submissions for editing package
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Your logic to update the package data in the database
        header("Location: manage_packages.php");
        exit();
    }
}

// Fetch package data for the form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
</head>
<body>
<form method="POST" action="">
    <input type="text" name="package_name" placeholder="Package Name" value="<?= $package_name ?>" required>
    <button type="submit">Update Package</button>
</form>
</body>
</html>
