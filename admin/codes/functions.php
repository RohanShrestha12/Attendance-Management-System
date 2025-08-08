<?php
include 'db.php';

// Function to get all users
function getUsers() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'customer'");
    return $result;
}

// Function to add a new user
function addUser($username, $email, $password, $role = 'customer') {
    global $conn;
    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    return mysqli_query($conn, $query);
}

// Function to get all hotels
function getHotels() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM hotels");
}

// Function to add a new hotel
function addHotel($hotel_name, $location, $price) {
    global $conn;
    $query = "INSERT INTO hotels (hotel_name, location, price_per_night) VALUES ('$hotel_name', '$location', '$price')";
    return mysqli_query($conn, $query);
}

// Similarly, add functions for packages, locations, and bookings
function getPackages() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM packages");
}

function addPackage($package_name, $description, $price) {
    global $conn;
    $query = "INSERT INTO packages (package_name, description, price) VALUES ('$package_name', '$description', '$price')";
    return mysqli_query($conn, $query);
}

function getLocations() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM locations");
}

function addLocation($location_name, $category) {
    global $conn;
    $query = "INSERT INTO locations (location_name, category) VALUES ('$location_name', '$category')";
    return mysqli_query($conn, $query);
}

function getBookings() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM bookings");
}

function updateBookingStatus($booking_id, $status) {
    global $conn;
    $query = "UPDATE bookings SET status = '$status' WHERE booking_id = '$booking_id'";
    return mysqli_query($conn, $query);
}
?>
