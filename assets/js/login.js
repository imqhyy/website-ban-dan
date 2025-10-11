const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1600,
    timerProgressBar: true,
    customClass: {
        popup: 'my-swal-popup'
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const users = JSON.parse(localStorage.getItem('users')) || [];

        const validUser = users.find(user => user.email === email && user.password === password);

        if (validUser) {
            // NẾU TÌM THẤY (ĐĂNG NHẬP THÀNH CÔNG)
            
            // THAY ĐỔI 2: Thay thế alert() bằng Toast báo thành công
            Toast.fire({
                icon: 'success',
                title: 'Đăng nhập thành công!'
            }).then(() => {
                // Sau khi toast tự động biến mất, mới thực hiện chuyển trang
                sessionStorage.setItem('currentUser', JSON.stringify(validUser));
                window.location.href = 'index.html';
            });

        } else {
            // NẾU KHÔNG TÌM THẤY (ĐĂNG NHẬP THẤT BẠI)
            Toast.fire({
                icon: 'error',
                title: 'Email hoặc mật khẩu không đúng!'
            });
        }
    });

    // 1. Lấy các phần tử cần thiết
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.password-toggle');
    const eyeIcon = toggleButton.querySelector('i'); //
    toggleButton.addEventListener('click', function() {
        // 3. Kiểm tra loại của ô input hiện tại
        if (passwordInput.type === 'password') {
            // Nếu đang là 'password', chuyển sang 'text' để xem
            passwordInput.type = 'text';

            // Đổi icon từ con mắt mở sang con mắt gạch chéo
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });
});