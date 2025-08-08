
<?php
session_start();
include "../database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_id = $_POST['hotel_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $total_amount = floatval(str_replace('$', '', $_POST['total_amount'])); // Strip out the $ symbol
    $user_id = $_SESSION['user_id'];
    
    // Debugging log
    error_log("Total Amount from form: " . $total_amount); // Check the value in the error log

    // Your booking insertion code here
}

    // Insert booking details into the bookings table
    $query = "INSERT INTO bookings (user_id, hotel_id, check_in_date, check_out_date, total_amount) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissd", $user_id, $hotel_id, $check_in_date, $check_out_date, $total_amount);

    if ($stmt->execute()) {
        // Redirect to a success page or show success message
        header("Location: index.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

?>
