const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Clear login state
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('userEmail');
    
    // Redirect to login page
    window.location.href = 'account.html';
});