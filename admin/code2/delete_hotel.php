<?php
include '../database/db.php';

if (isset($_GET['id'])) {
    $hotel_id = $_GET['id'];
    // Your logic to delete the hotel from the database using $hotel_id
    header("Location: manage_hotels.php");
    exit();
}
?>
