<?php
include '../database/db.php';

$response = array();

// Get total users
$result = $conn->query("SELECT COUNT(*) as total FROM users");
$row = $result->fetch_assoc();
$response['users'] = $row['total'];

// Get total hotels
$result = $conn->query("SELECT COUNT(*) as total FROM hotels");
$row = $result->fetch_assoc();
$response['hotels'] = $row['total'];

// Get total packages
$result = $conn->query("SELECT COUNT(*) as total FROM packages");
$row = $result->fetch_assoc();
$response['packages'] = $row['total'];

// Get total bookings
$result = $conn->query("SELECT COUNT(*) as total FROM bookings");
$row = $result->fetch_assoc();
$response['bookings'] = $row['total'];

echo json_encode($response);

$conn->close();
?>
