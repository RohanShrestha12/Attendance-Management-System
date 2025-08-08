<?php
include '../database/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_id = $_POST['package_id'];
    $package_name = $_POST['package_name'];
    $description = $_POST['description'];
    $amenitites = $_POST['amenities'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    // Update hotel in the database
    $update_query = "UPDATE packages SET package_name=?, duration=?, description=?, amenities=?, price=? WHERE package_id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sissii", $package_name, $duration,  $description, $amenitites,$price, $package_id);

    if ($stmt->execute()) {
        header("Location: manage_packages.php?success=package updated successfully");
    } else {
        header("Location: manage_packages.php?error=Error updating Package");
    }
    $stmt->close();
}
?>
