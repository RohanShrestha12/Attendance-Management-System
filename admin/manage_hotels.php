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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Hotels</h2>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addHotelModal">Add Hotel</button>
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
                $hotel_query = "SELECT * FROM hotels";
                $result = $conn->query($hotel_query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['hotel_id'] . "</td>";
                    echo "<td>" . $row['hotel_name'] . "</td>";
                    echo "<td>" . $row['location_id'] . "</td>";
                    echo "<td>" . $row['price_per_night'] . "</td>";
                    echo "<td>" . $row['amenities'] . "</td>";
                    echo "<td>" . $row['rating'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editHotelModal' data-id='" . $row['hotel_id'] . "' data-name='" . $row['hotel_name'] . "' data-location='" . $row['location_id'] . "' data-price='" . $row['price_per_night'] . "' data-amenities='" . $row['amenities'] . "' data-rating='" . $row['rating'] . "'>Edit</button> ";
                    echo "<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteHotelModal' data-id='" . $row['hotel_id'] . "' data-name='" . $row['hotel_name'] . "'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Hotel Modal -->
    <div class="modal fade" id="addHotelModal" tabindex="-1" aria-labelledby="addHotelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHotelModalLabel">Add New Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="add_hotel.php">
                        <div class="mb-3">
                            <label for="hotel_name" class="form-label">Hotel Name</label>
                            <input type="text" class="form-control" id="hotel_name" name="hotel_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="location_id" class="form-label">Location ID</label>
                            <input type="number" class="form-control" id="location_id" name="location_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Price per Night</label>
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night" required>
                        </div>
                        <div class="mb-3">
                            <label for="amenities" class="form-label">Amenities</label>
                            <input type="text" class="form-control" id="amenities" name="amenities" required>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Hotel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Hotel Modal -->
    <div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHotelModalLabel">Edit Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="edit_hotel.php">
                        <input type="hidden" id="edit_hotel_id" name="hotel_id">
                        <div class="mb-3">
                            <label for="edit_hotel_name" class="form-label">Hotel Name</label>
                            <input type="text" class="form-control" id="edit_hotel_name" name="hotel_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_location_id" class="form-label">Location ID</label>
                            <input type="number" class="form-control" id="edit_location_id" name="location_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price_per_night" class="form-label">Price per Night</label>
                            <input type="number" class="form-control" id="edit_price_per_night" name="price_per_night" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_amenities" class="form-label">Amenities</label>
                            <input type="text" class="form-control" id="edit_amenities" name="amenities" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_rating" class="form-label">Rating</label>
                            <input type="number" class="form-control" id="edit_rating" name="rating" min="1" max="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Hotel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Hotel Modal -->
    <div class="modal fade" id="deleteHotelModal" tabindex="-1" aria-labelledby="deleteHotelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteHotelModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the hotel <strong id="delete_hotel_name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="delete_hotel.php" id="deleteHotelForm">
                        <input type="hidden" name="hotel_id" id="delete_hotel_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
$(document).ready(function() {
    $('#editHotelModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var hotelId = button.data('id');
        var hotelName = button.data('name');
        var locationName = button.data('location');
        var price = button.data('price');
        var amenities = button.data('amenities');
        var rating = button.data('rating');

        var modal = $(this);
        modal.find('#edit_hotel_id').val(hotelId);
        modal.find('#edit_hotel_name').val(hotelName);
        modal.find('#edit_location_id').val(locationName); // Assuming location name is being edited as location_id
        modal.find('#edit_price_per_night').val(price);
        modal.find('#edit_amenities').val(amenities);
        modal.find('#edit_rating').val(rating);
    });

    $('#deleteHotelModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var hotelId = button.data('id');
        var hotelName = button.data('name');

        var modal = $(this);
        modal.find('#delete_hotel_id').val(hotelId);
        modal.find('#delete_hotel_name').text(hotelName);
    });
});
</script>

</html>
