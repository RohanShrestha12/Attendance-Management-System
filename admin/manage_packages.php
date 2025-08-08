<?php
include '../database/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Packages</h2>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPackageModal">Add Package</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Package Name</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th>Amenities</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $package_query = "SELECT * FROM packages";
                $result = $conn->query($package_query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['package_id'] . "</td>";
                    echo "<td>" . $row['package_name'] . "</td>";
                    echo "<td>" . $row['duration'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['amenities'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editPackageModal' 
                    data-id='" . $row['package_id'] . "' 
                    data-name='" . $row['package_name'] . "' 
                    data-duration='" . $row['duration'] . "' 
                    data-description='" . $row['description'] . "' 
                    data-amenities='" . $row['amenities'] . "' 
                    data-price='" . $row['price'] . "'>Edit</button> ";
                    echo "<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deletePackageModal' data-id='" . $row['package_id'] . "' data-name='" . $row['package_name'] . "'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Package Modal -->
    <div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPackageModalLabel">Add New Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="add_package.php">
                        <div class="mb-3">
                            <label for="package_name" class="form-label">Package Name</label>
                            <input type="text" class="form-control" id="package_name" name="package_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="package_duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="package_duration" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="package_description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="package_description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="package_amenities" class="form-label">Amenities</label>
                            <input type="text" class="form-control" id="package_amenities" name="amenities" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Package Modal -->
    <div class="modal fade" id="editPackageModal" tabindex="-1" aria-labelledby="editPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageModalLabel">Edit Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="edit_package.php">
                        <input type="hidden" id="edit_package_id" name="package_id">
                        <div class="mb-3">
                            <label for="edit_package_name" class="form-label">Package Name</label>
                            <input type="text" class="form-control" id="edit_package_name" name="package_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_package_duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="edit_package_duration" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_package_description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="edit_package_description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_package_amenities" class="form-label">Amenities</label>
                            <input type="text" class="form-control" id="edit_package_amenities" name="amenities" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Package Modal -->
    <div class="modal fade" id="deletePackageModal" tabindex="-1" aria-labelledby="deletePackageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePackageModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the package <strong id="delete_package_name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="delete_package.php" id="deletePackageForm">
                        <input type="hidden" name="package_id" id="delete_package_id">
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
    // Show edit modal and populate with package data
    $('#editPackageModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var packageId = button.data('id');
        var packageName = button.data('name');
        var packageDuration = button.data('duration');
        var packageDescription = button.data('description');
        var packageAmenities = button.data('amenities');
        var price = button.data('price');

        var modal = $(this);
        modal.find('#edit_package_id').val(packageId);
        modal.find('#edit_package_name').val(packageName);
        modal.find('#edit_package_duration').val(packageDuration); // Fixed duration field
        modal.find('#edit_package_description').val(packageDescription);
        modal.find('#edit_package_amenities').val(packageAmenities);
        modal.find('#edit_price').val(price);
    });

    // Show delete modal and populate with package data
    $('#deletePackageModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var packageId = button.data('id');
        var packageName = button.data('name');

        var modal = $(this);
        modal.find('#delete_package_id').val(packageId);
        modal.find('#delete_package_name').text(packageName);
    });
});
</script>
</html>
