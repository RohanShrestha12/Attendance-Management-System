<?php
include '../database/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the form
    $user_id = $_POST['user_id'];

    // Validate user_id
    if (!empty($user_id)) {
        // Prepare an SQL query to delete the user from the database
        $delete_query = "DELETE FROM users WHERE user_id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($delete_query)) {
            // Bind the parameter (i = integer)
            $stmt->bind_param("i", $user_id);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to manage users page with success message
                header("Location: manage_users.php?message=User deleted successfully");
                exit;
            } else {
                // Redirect with error message
                header("Location: manage_users.php?error=Failed to delete user");
                exit;
            }
        } else {
            // Redirect with error message if the query fails
            header("Location: manage_users.php?error=Failed to prepare query");
            exit;
        }
    } else {
        // Redirect with error message if validation fails
        header("Location: manage_users.php?error=Invalid user ID");
        exit;
    }
} else {
    // Redirect if not a POST request
    header("Location: manage_users.php");
    exit;
}
