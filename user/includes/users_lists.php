<?php
include '../../database/db.php'; // Database connection

// Define the SQL query
$sql = "SELECT user_id,hotel_id,rating FROM ratings";

// Execute the query
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // Fetch each row and add it to the array
    while ($row = $result->fetch_assoc()) {
      print_r($row);
     
    }
}


?>