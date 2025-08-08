<?php
include '../database/db.php';

if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    // Your logic to delete the package from the database using $package_id
    header("Location: manage_packages.php");
    exit();
}
?>
