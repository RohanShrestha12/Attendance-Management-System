<?php
include '../../database/db.php';

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];

$conn->query("UPDATE users SET username='$username', email='$email', role='$role' WHERE user_id=$user_id");
$conn->close();
?>
