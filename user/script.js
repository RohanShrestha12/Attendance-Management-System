document.getElementById('profile-icon').addEventListener('click', function() {
    let menu = document.getElementById('dropdown-menu');
    menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
});

document.getElementById('login-btn').addEventListener('click', function() {
    let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
});

// JavaScript to handle the "Book Now" button click and populate the modal



        