<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'header.php'; // Include header
?>

<!-- jQuery and Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <h5 class="sidebar-heading text-center">Admin Panel</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_locations.php">Manage Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_hotels.php">Manage Hotels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_packages.php">Manage Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_bookings.php">Manage Bookings</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <h2>Dashboard</h2>
            <div class="row">
                <!-- Cards for totals -->
                <div class="col-md-3">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text" id="totalUsers"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Locations</h5>
                            <p class="card-text" id="totalLocations"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Hotels</h5>
                            <p class="card-text" id="totalHotels"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Packages</h5>
                            <p class="card-text" id="totalPackages"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content"></div> <!-- Content area to dynamically load pages -->
        </main>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load totals via AJAX
    $.ajax({
        url: 'fetch_totals.php',
        type: 'GET',
        success: function(data) {
            var totals = JSON.parse(data);
            $('#totalUsers').text(totals.total_users);
            $('#totalLocations').text(totals.total_locations);
            $('#totalHotels').text(totals.total_hotels);
            $('#totalPackages').text(totals.total_packages);
        }
    });

    // Load content when links are clicked
    $('a.nav-link').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('#content').load(url);
    });
});
</script>
