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
        /* Logout button styling */
        .logout-btn {
            position: absolute;
            right: 20px;
            top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
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

                <!-- Logout button at the top right -->
                <a href="logout.php" class="logout-btn">Logout</a>

                <!-- Removed toolbar with "Add" button -->
                <!-- Dashboard overview -->
                <div class="row text-center mt-4">
                    <?php
                    // Include the database connection
                    include '../database/db.php';
                    
                    // Error handling to prevent undefined variable issues
                    $totalUsers = $totalLocations = $totalHotels = $totalPackages = $totalBookings = 0;

                    // Fetch total users
                    $result = $conn->query("SELECT COUNT(*) AS total_users FROM users");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalUsers = $row['total_users'] ?? 0;
                    }

                    // Fetch total locations
                    $result = $conn->query("SELECT COUNT(*) AS total_locations FROM locations");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalLocations = $row['total_locations'] ?? 0;
                    }

                    // Fetch total hotels
                    $result = $conn->query("SELECT COUNT(*) AS total_hotels FROM hotels");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalHotels = $row['total_hotels'] ?? 0;
                    }

                    // Fetch total packages
                    $result = $conn->query("SELECT COUNT(*) AS total_packages FROM packages");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $totalPackages = $row['total_packages'] ?? 0;
                    }

                    // Fetch total bookings
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

    <script>
        $(document).ready(function() {
            // Function to load content dynamically
            function loadContent(page) {
                $("#content-area").load(page);
            }

            // Menu click handlers
            $("#users-menu").click(function() {
                loadContent('manage_users.php');
                $("#addBtn").text("Add User").removeClass('d-none').off('click').on('click', function() {
                    window.location.href = 'add_user.php';
                });
            });

            $("#hotels-menu").click(function() {
                loadContent('manage_hotels.php');
                $("#addBtn").text("Add Hotel").removeClass('d-none').off('click').on('click', function() {
                    window.location.href = 'add_hotel.php';
                });
            });

            $("#packages-menu").click(function() {
                loadContent('manage_packages.php');
                $("#addBtn").text("Add Package").removeClass('d-none').off('click').on('click', function() {
                    window.location.href = 'add_package.php';
                });
            });

            $("#bookings-menu").click(function() {
                loadContent('manage_bookings.php');
                $("#addBtn").addClass('d-none');  // Hide the Add button for bookings section
            });
        });
    </script>
</body>
</html>
