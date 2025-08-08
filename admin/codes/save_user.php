<?php
include '../database/db.php'; // Database connection

$user_id = $_POST['userId'];
$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];

if ($user_id) {
    // Update existing user
    $query = "UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE user_id = '$user_id'";
} else {
    // Insert new user
    $query = "INSERT INTO users (username, email, role) VALUES ('$username', '$email', '$role')";
}

if (mysqli_query($conn, $query)) {
    echo 'User saved successfully';
} else {
    echo 'Error: ' . mysqli_error($conn);
}
?>
