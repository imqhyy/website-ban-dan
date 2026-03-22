
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.password-toggle');
    if (toggleButton && passwordInput) {
        const eyeIcon = toggleButton.querySelector('i');
        toggleButton.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }

    //--- Xử lý Đăng nhập bằng AJAX ---
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            //Kiểm tra rỗng
            const usernameValue = document.getElementById('username').value.trim();
            const passwordValue = document.getElementById('password').value.trim();

            const formData = new FormData(this);
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = 'index.php';
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }
});