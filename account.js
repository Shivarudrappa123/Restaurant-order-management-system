document.addEventListener('DOMContentLoaded', function() {
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // Form toggle functionality
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            toggleBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (btn.dataset.form === 'login') {
                loginForm.classList.remove('form-inactive');
                loginForm.classList.add('form-active');
                registerForm.classList.remove('form-active');
                registerForm.classList.add('form-inactive');
            } else {
                registerForm.classList.remove('form-inactive');
                registerForm.classList.add('form-active');
                loginForm.classList.remove('form-active');
                loginForm.classList.add('form-inactive');
            }
        });
    });

    // Password confirmation validation
    registerForm.addEventListener('submit', function(e) {
        const password = document.getElementById('registerPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }
    });
}); 