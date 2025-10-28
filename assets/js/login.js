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

    // --- Tự động thêm @gmail.com ---
    if (emailInput) {
        emailInput.addEventListener('blur', function () {
            const emailValue = emailInput.value;
            if (emailValue.length > 0 && !emailValue.includes('@')) {
                emailInput.value = emailValue + '@gmail.com';
            }
        });
    }

    // --- XỬ LÝ ĐĂNG NHẬP ---
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            Toast.fire({ icon: 'error', title: 'Vui lòng nhập thông tin!' });
            return;
        }

        const users = JSON.parse(localStorage.getItem('users')) || [];

            // --- TRƯỜNG HỢP 2: Đăng nhập sai (Tự động dùng tài khoản Test User) ---

            // 1. Lấy danh sách tất cả người dùng
            let allUsers = JSON.parse(localStorage.getItem('users')) || [];
            const testUserEmail = "test@gmail.com";

            // 2. Kiểm tra xem "Test User" đã tồn tại trong localStorage chưa
            let testUserAccount = allUsers.find(user => user.email === testUserEmail);

            if (!testUserAccount) {
                // 3. Nếu CHƯA có, tạo mới và LƯU VÀO LOCALSTORAGE
                testUserAccount = {
                    fullName: "Test User",
                    email: testUserEmail,
                    password: "123", // Mật khẩu mẫu
                    phone: "0123456789",
                    orders: [] // Mảng đơn hàng rỗng
                };
                allUsers.push(testUserAccount);
                localStorage.setItem('users', JSON.stringify(allUsers));
            }
            // 4. Nếu đã có, thì 'testUserAccount' chính là tài khoản đó

            // 5. Đăng nhập bằng tài khoản Test User
            Toast.fire({
                icon: 'success',
                title: 'Đăng nhập thành công!'
            }).then(() => {
                sessionStorage.setItem('currentUser', JSON.stringify(testUserAccount));
                window.location.href = 'index.html';
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