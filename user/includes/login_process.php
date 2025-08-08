<?php
session_start();
include '../../database/db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to find the user (check both customer and admin roles)
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Check password (assuming it's not hashed)
        if ($password == $user['password']) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on the role
            if ($user['role'] == 'admin') {
                header("Location: ../../admin/admin_dashboard.php"); // Admin dashboard
            } elseif ($user['role'] == 'customer') {
                header("Location: ../index.php"); // User dashboard
            }
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password');window.location.href='../index.php';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found');window.location.href='../index.php';</script>";
    }
}
?>
