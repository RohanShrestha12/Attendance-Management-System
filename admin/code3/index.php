<?php include('header.php'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php include('sidebar.php'); ?>
        </div>

        <div class="col-md-10">
            <div id="content-area" class="p-4">
                <h3 class="text-center mt-5">Welcome to the Admin Dashboard</h3>
                <p class="text-center">Select a section from the menu to manage users, locations, packages, or bookings.</p>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Load Manage Users section
        $('#manageUsers').click(function() {
            $('#content-area').load('manage_users.php');
        });

        // Load Manage Locations section
        $('#manageLocations').click(function() {
            $('#content-area').load('manage_locations.php');
        });

        // Load Manage Packages section
        $('#managePackages').click(function() {
            $('#content-area').load('manage_packages.php');
        });

        // Load Manage Bookings section
        $('#manageBookings').click(function() {
            $('#content-area').load('manage_bookings.php');
        });
    });
</script>
