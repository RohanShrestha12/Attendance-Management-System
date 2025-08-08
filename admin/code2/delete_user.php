<?php
include '../database/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    // Your logic to delete the user from the database using $user_id
    header("Location: manage_users.php");
    exit();
}
?>
