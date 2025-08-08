<!-- modals/delete_user.php -->
<?php
$user_id = $_GET['id'];
?>

<div class="modal-dialog">
    <div class="modal-content">
        <form id="deleteUserForm">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Delete User</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#deleteUserForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'actions/delete_user.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function () {
                $('#deleteModal').modal('hide');
                loadContent('manage_users.php');
            }
        });
    });
</script>
