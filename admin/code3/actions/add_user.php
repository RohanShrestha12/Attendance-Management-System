<?php
include '../../database/db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];

$conn->query("INSERT INTO users (username, email, role) VALUES ('$username', '$email', '$role')");
$conn->close();
?>
