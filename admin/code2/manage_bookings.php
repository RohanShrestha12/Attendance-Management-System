<?php
include '../database/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Bookings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User Name</th>
                    <th>Hotel Name</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $booking_query = "SELECT 
    bookings.booking_id, 
    bookings.check_in_date, 
    bookings.check_out_date, 
    bookings.total_amount, 
    users.username, 
    hotels.hotel_name
FROM 
    bookings
JOIN 
    users ON bookings.user_id = users.user_id
JOIN 
    hotels ON bookings.hotel_id = hotels.hotel_id;
";
                $result = $conn->query($booking_query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['booking_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['hotel_name'] . "</td>";
                    echo "<td>" . $row['check_in_date'] . "</td>";
                    echo "<td>" . $row['check_out_date'] . "</td>";
                    echo "<td>";
                    echo "<form method='POST' style='display:inline-block;' action='edit_booking.php'>";
                    echo "<input type='hidden' name='booking_id' value='" . $row['booking_id'] . "'>";
                    echo "<button type='submit' class='btn btn-primary'>Edit</button>";
                    echo "</form>";
                    echo "<form method='POST' style='display:inline-block;' action='delete_booking.php'>";
                    echo "<input type='hidden' name='booking_id' value='" . $row['booking_id'] . "'>";
                    echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
