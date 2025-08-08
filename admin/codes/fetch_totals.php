<?php
include 'database/db.php'; // Database connection

// Queries to fetch totals
$query_users = "SELECT COUNT(*) AS total_users FROM users";
$query_locations = "SELECT COUNT(*) AS total_locations FROM locations";
$query_hotels = "SELECT COUNT(*) AS total_hotels FROM hotels";
$query_packages = "SELECT COUNT(*) AS total_packages FROM packages";

// Execute queries
$result_users = mysqli_query($conn, $query_users);
$result_locations = mysqli_query($conn, $query_locations);
$result_hotels = mysqli_query($conn, $query_hotels);
$result_packages = mysqli_query($conn, $query_packages);

// Fetch data
$total_users = mysqli_fetch_assoc($result_users)['total_users'];
$total_locations = mysqli_fetch_assoc($result_locations)['total_locations'];
$total_hotels = mysqli_fetch_assoc($result_hotels)['total_hotels'];
$total_packages = mysqli_fetch_assoc($result_packages)['total_packages'];

// Return data as JSON
echo json_encode([
    'total_users' => $total_users,
    'total_locations' => $total_locations,
    'total_hotels' => $total_hotels,
    'total_packages' => $total_packages
]);
?>
