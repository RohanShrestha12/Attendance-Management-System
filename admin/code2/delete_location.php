<?php
include '../database/db.php';

if (isset($_GET['id'])) {
    $location_id = $_GET['id'];
    // Your logic to delete the location from the database using $location_id
    header("Location: manage_locations.php");
    exit();
}
?>
