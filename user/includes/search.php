<?php
session_start();
include '../../database/db.php';  // Database connection

if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']);
    
    // Check if the user is logged in, otherwise set user_id to NULL
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;  // Set user_id to null for unlogged users
    }

    // Prepare to search for hotel by name or ID (if it's a valid hotel query)
    $stmt = $conn->prepare("SELECT hotel_id FROM hotels WHERE hotel_name LIKE ? OR hotel_id = ?");
    $search_query = "%{$query}%";
    $stmt->bind_param('si', $search_query, $query);  // Bind both string and integer
    $stmt->execute();
    $stmt->bind_result($hotel_id);
    $stmt->fetch();
    $stmt->close();
    
    // If no matching hotel is found, set hotel_id to null
    if (empty($hotel_id)) {
        $hotel_id = null;
    }

    // Insert search query and hotel_id (if found) into search_history table (user_id can be null)
    $stmt = $conn->prepare("INSERT INTO search_history (user_id, search_query, hotel_id) VALUES (?, ?, ?)");
    
    // Handle null for user_id and hotel_id
    $stmt->bind_param('isi', $user_id, $query, $hotel_id);
    $stmt->execute();
    $stmt->close();
    
    // Redirect to the search results page with the query as a parameter
    header("Location: ../index.php?query=" . urlencode($query));
    exit();
} else {
    // If no query is provided, redirect to home or show an error message
    header("Location: ../index.php");
    exit();
}
?>
