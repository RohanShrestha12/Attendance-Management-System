// scripts.js
$(document).ready(function () {
    // Function to load content dynamically
    function loadContent(page) {
        $.ajax({
            url: page,
            method: 'GET',
            success: function (data) {
                $('#content-area').html(data);
            }
        });
    }

    // Menu click events
    $('#users-menu').click(function () {
        loadContent('manage_users.php');
    });

    $('#locations-menu').click(function () {
        loadContent('manage_locations.php');
    });

    $('#packages-menu').click(function () {
        loadContent('manage_packages.php');
    });

    $('#bookings-menu').click(function () {
        loadContent('manage_bookings.php');
    });

    // Initially load users
    loadContent('manage_users.php');

    // Delegate click events for dynamically loaded content
    $(document).on('click', '.add-btn', function () {
        var section = $(this).data('section');
        $.ajax({
            url: 'modals/add_' + section + '.php',
            method: 'GET',
            success: function (data) {
                $('#addModal').html(data);
                $('#addModal').modal('show');
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        var section = $(this).data('section');
        var id = $(this).data('id');
        $.ajax({
            url: 'modals/edit_' + section + '.php',
            method: 'GET',
            data: { id: id },
            success: function (data) {
                $('#editModal').html(data);
                $('#editModal').modal('show');
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        var section = $(this).data('section');
        var id = $(this).data('id');
        $.ajax({
            url: 'modals/delete_' + section + '.php',
            method: 'GET',
            data: { id: id },
            success: function (data) {
                $('#deleteModal').html(data);
                $('#deleteModal').modal('show');
            }
        });
    });

    // Confirm and Cancel bookings
    $(document).on('click', '.confirm-booking', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'actions/confirm_booking.php',
            method: 'POST',
            data: { id: id },
            success: function () {
                loadContent('manage_bookings.php');
            }
        });
    });

    $(document).on('click', '.cancel-booking', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'actions/cancel_booking.php',
            method: 'POST',
            data: { id: id },
            success: function () {
                loadContent('manage_bookings.php');
            }
        });
    });
});
