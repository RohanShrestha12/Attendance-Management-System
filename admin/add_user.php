<?php
include '../database/db.php'; // Include your database connection

// Capture the data from the form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


// Default role is 'customer'
$role = 'customer';

// Insert the user into the database
$query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
$result = mysqli_query($conn, $query);

if ($result) {
    // Registration success
    echo "<script>alert('Registration successful!');window.location.href='manage_users.php';</script>";
} else {
    // Registration failed
    echo "<script>alert('Registration failed. Please try again.');window.location.href='signup.php';</script>";
}
?>
