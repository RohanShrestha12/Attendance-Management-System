    <?php
 include '../database/db.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Hotels</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2 class="text-center">Manage Hotels</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hotel ID</th>
                        <th>Hotel Name</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Amenities</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hotel_query ="SELECT hotels.hotel_id, hotels.hotel_name, locations.location_name, hotels.price_per_night , hotels.amenities,hotels.rating
                    FROM hotels 
                    JOIN locations ON hotels.location_id = locations.location_id";
                    $result = $conn->query($hotel_query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['hotel_id'] . "</td>";
                        echo "<td>" . $row['hotel_name'] . "</td>";
                        echo "<td>" . $row['location_name'] . "</td>";
                        echo "<td>" . $row['price_per_night'] . "</td>";
                        echo "<td>" . $row['amenities'] . "</td>";
                        echo "<td>" . $row['rating'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST' style='display:inline-block;' action='edit_hotel.php'>";
                        echo "<input type='hidden' name='hotel_id' value='" . $row['hotel_id'] . "'>";
                        echo "<button type='submit' class='btn btn-primary'>Edit</button>";
                        echo "</form>";
                        echo "<form method='POST' style='display:inline-block;' action='delete_hotel.php'>";
                        echo "<input type='hidden' name='hotel_id' value='" . $row['hotel_id'] . "'>";
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
