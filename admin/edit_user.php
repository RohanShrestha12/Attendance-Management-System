<?php
include '../database/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Validate inputs (you can expand validation based on your requirements)
    if (!empty($user_id) && !empty($username) && !empty($email) && !empty($role)) {
        // Prepare an SQL query to update user data
        $update_query = "UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($update_query)) {
            // Bind parameters (s = string, i = integer)
            $stmt->bind_param("sssi", $username, $email, $role, $user_id);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to manage users page with success message (optional)
                header("Location: manage_users.php?message=User updated successfully");
                exit;
            } else {
                // Redirect with error message
                header("Location: manage_users.php?error=Failed to update user");
                exit;
            }
        } else {
            // Redirect with error message if the query fails
            header("Location: manage_users.php?error=Failed to prepare query");
            exit;
        }
    } else {
        // Redirect with error message if validation fails
        header("Location: manage_users.php?error=Invalid input");
        exit;
    }
} else {
    // Redirect if not a POST request
    header("Location: manage_users.php");
    exit;
}
