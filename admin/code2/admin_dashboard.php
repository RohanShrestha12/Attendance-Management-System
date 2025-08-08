<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            border-radius: 10px;
        }
        .toolbar {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: left;
        }
        .toolbar .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <h4 class="text-white text-center mt-3">Admin Menu</h4>
                    <a href="#" id="users-menu">Manage Users</a>
                    <a href="#" id="hotels-menu">Manage Hotels</a>
                    <a href="#" id="packages-menu">Manage Packages</a>
                    <a href="#" id="bookings-menu">Manage Bookings</a>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <h2 class="mt-5 text-center">Welcome to the Admin Dashboard</h2>
                <p class="text-center">Use the menu on the left to manage different sections.</p>

                <!-- Toolbar for adding new items -->
                <div class="toolbar text-start mb-3">
                    <button id="addBtn" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
                </div>

                <!-- Dashboard overview -->
                <div class="row text-center mt-4">
                    <!-- PHP Code to Fetch Data -->
                    <?php
                    include '../database/db.php';
                    
                    $totalUsers = $totalLocations = $totalHotels = $totalPackages = $totalBookings = 0;

                    $result = $conn->query("SELECT COUNT(*) AS total_users FROM users");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalUsers = $row['total_users'] ?? 0;
                    }

                    $result = $conn->query("SELECT COUNT(*) AS total_locations FROM locations");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalLocations = $row['total_locations'] ?? 0;
                    }

                    $result = $conn->query("SELECT COUNT(*) AS total_hotels FROM hotels");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalHotels = $row['total_hotels'] ?? 0;
                    }

                    $result = $conn->query("SELECT COUNT(*) AS total_packages FROM packages");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalPackages = $row['total_packages'] ?? 0;
                    }

                    $result = $conn->query("SELECT COUNT(*) AS total_bookings FROM bookings");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalBookings = $row['total_bookings'] ?? 0;
                    }
                    ?>

                    <!-- Display cards with totals -->
                    <div class="col-md-3">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <h5>Total Users</h5>
                                <h3><?php echo $totalUsers; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <h5>Total Locations</h5>
                                <h3><?php echo $totalLocations; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <h5>Total Hotels</h5>
                                <h3><?php echo $totalHotels; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">
                                <h5>Total Packages</h5>
                                <h3><?php echo $totalPackages; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <h5>Total Bookings</h5>
                                <h3><?php echo $totalBookings; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content will be loaded here dynamically when menu is clicked -->
                <div id="content-area" class="mt-4"></div>
            </main>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                    <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and AJAX Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load content dynamically
            function loadContent(page) {
                $('#content-area').load(page);
            }

            // Click events for menu items
            $('#users-menu').click(function() {
                loadContent('users.php');
                $('#addBtn').removeClass('d-none');
            });
            $('#hotels-menu').click(function() {
                loadContent('hotels.php');
                $('#addBtn').removeClass('d-none');
            });
            $('#packages-menu').click(function() {
                loadContent('packages.php');
                $('#addBtn').removeClass('d-none');
            });
            $('#bookings-menu').click(function() {
                loadContent('bookings.php');
                $('#addBtn').addClass('d-none');
            });

            // Handle Add Form Submission
            $('#addForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.post('add.php', formData, function(response) {
                    $('#addModal').modal('hide');
                    loadContent('users.php');
                });
            });

            // Handle Edit Form Submission
            $('#editForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.post('edit.php', formData, function(response) {
                    $('#editModal').modal('hide');
                    loadContent('users.php');
                });
            });

            // Handle Delete Confirmation
            $('#confirmDeleteBtn').click(function() {
                var id = $(this).data('id');
                $.post('delete.php', { id: id }, function(response) {
                    $('#deleteModal').modal('hide');
                    loadContent('users.php');
                });
            });

            // Load initial content (e.g., Users)
            loadContent('users.php');
        });
    </script>
</body>
</html>
