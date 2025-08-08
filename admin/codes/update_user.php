<?php
include '../database/db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $user_id = $_POST['user_id'];
    $username = $_POST['username']
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE user_id=?");
    $stmt->bind_param("sssi", $username, $email, $role, $user_id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $stmt->error;
    }
    $stmt->close();
}
?>
