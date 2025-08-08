<?php
include '../database/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = $_POST['hotel_id'];

    // Delete hotel from the database
    $delete_query = "DELETE FROM hotels WHERE hotel_id=?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $hotel_id);

    if ($stmt->execute()) {
        header("Location: manage_hotels.php?success=Hotel deleted successfully");
    } else {
        header("Location: manage_hotels.php?error=Error deleting hotel");
    }
    $stmt->close();
}
?>
