<?php

include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_name = $_POST['package_name'];
    $duration= $_POST['duration'];
    $amenities = $_POST['amenities'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $query = "INSERT INTO packages (package_name,duration,description ,amenities,price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sissi', $package_name, $duration, $description, $amenities, $price);

    if ($stmt->execute()) {
        header("Location: manage_packages.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

