// --- KHUÔN MẪU TOAST ---
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1200,
    timerProgressBar: true,
    customClass: {
        popup: 'my-swal-popup'
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    const emailInput = document.getElementById('email');

    // --- ĐÃ XÓA: Tự động thêm @gmail.com ---

    // --- XỬ LÝ ĐĂNG NHẬP ---
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // --- TÀI KHOẢN TEST USER ĐƯỢC TẠO TRỰC TIẾP TRONG SESSION ---
        const testUserAccount = {
            fullName: "Test User",
            email: "test@gmail.com",
            password: "123",
            phone: "0123456789",
            orders: []
        };

        // --- ĐĂNG NHẬP THÀNH CÔNG VỚI TÀI KHOẢN TEST ---
        Toast.fire({
            icon: 'success',
            title: 'Đăng nhập thành công!'
        }).then(() => {
            sessionStorage.setItem('currentUser', JSON.stringify(testUserAccount));
            window.location.href = 'index.php';
        });
    });

    // --- XỬ LÝ NÚT XEM MẬT KHẨU ---
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.password-toggle');
    const eyeIcon = toggleButton.querySelector('i');

    toggleButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });
});