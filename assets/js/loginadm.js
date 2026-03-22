document.addEventListener('DOMContentLoaded', function () {

    // Toggle hiện/ẩn mật khẩu
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

    // Xử lý submit
    const loginForm = document.getElementById('login-form');
    if (!loginForm) return;

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const usernameValue = document.getElementById('username').value.trim();
        const passwordValue = document.getElementById('password').value.trim();

        const formData = new FormData(this);
        fetch('admin_login.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Toast.fire({ icon: 'success', title: 'Đăng nhập thành công!' })
                        .then(() => { window.location.href = 'admin.php'; });
                } else {
                    Toast.fire({ icon: 'error', title: data.message });
                }
            })
            .catch(() => Toast.fire({ icon: 'error', title: 'Có lỗi xảy ra, vui lòng thử lại' }));
    });
});