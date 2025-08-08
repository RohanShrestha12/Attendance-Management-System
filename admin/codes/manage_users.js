$(document).ready(function() {
    // Function to open the modal for adding a user
    $("#addBtn").click(function() {
        $('#userModalLabel').text("Add User");
        $('#userForm')[0].reset(); // Reset the form
        $('#userId').val(''); // Clear hidden userId
        $('#userModal').modal('show'); // Show the modal
    });

    // Function to handle edit button click
    $(document).on('click', '.editUserBtn', function() {
        var userId = $(this).data('id');
        $.ajax({
            url: 'get_user.php',
            type: 'GET',
            data: { user_id: userId },
            success: function(response) {
                var user = JSON.parse(response);
                $('#userId').val(user.user_id);
                $('#username').val(user.username);
                $('#email').val(user.email);
                $('#role').val(user.role);
                $('#userModalLabel').text("Edit User");
                $('#userModal').modal('show');
            }
        });
    });

    // Handle the save button click
    $("#saveUserBtn").click(function() {
        var userId = $('#userId').val();
        var url = userId ? 'update_user.php' : 'add_user.php'; // Different URL for add/update
        var data = {
            user_id: userId,
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            role: $('#role').val()
        };
        
        $.post(url, data, function(response) {
            $('#userModal').modal('hide'); // Hide modal
            location.reload(); // Reload the page to see changes
        });
    });

    // Handle the delete button click
    $(document).on('click', '.deleteUserBtn', function() {
        var userId = $(this).data('id');
        $('#confirmDeleteUserBtn').data('id', userId); // Store userId in the button
        $('#deleteUserModal').modal('show'); // Show the delete confirmation modal
    });

    // Confirm deletion
    $("#confirmDeleteUserBtn").click(function() {
        var userId = $(this).data('id');
        $.post('delete_user.php', { user_id: userId }, function(response) {
            $('#deleteUserModal').modal('hide'); // Hide the modal
            location.reload(); // Reload the page to see changes
        });
    });
});
