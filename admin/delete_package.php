<?php
include '../database/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_id = $_POST['package_id'];

    // Delete hotel from the database
    $delete_query = "DELETE FROM packages WHERE package_id=?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $package_id);

    if ($stmt->execute()) {
        header("Location: manage_packages.php?success=Hotel deleted successfully");
    } else {
        header("Location: manage_packages.php?error=Error deleting hotel");
    }
    $stmt->close();
}
?>
