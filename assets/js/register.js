const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    customClass: { popup: 'my-swal-popup' },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function () {
            const emailValue = emailInput.value;

            // Nếu người dùng có nhập gì đó VÀ không chứa ký tự @
            if (emailValue.length > 0 && !emailValue.includes('@')) {
                // Tự động thêm đuôi @gmail.com
                emailInput.value = emailValue + '@gmail.com';
            }
        });
    }
    registerForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Lấy giá trị từ các ô input
        const fullName = document.getElementById('Họ và Tên').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const phone = document.getElementById('phone').value; // Lấy thêm SĐT

        // --- VALIDATION (Kiểm tra dữ liệu) ---
        if (password !== confirmPassword) {
            Toast.fire({ icon: 'error', title: 'Mật khẩu xác nhận không khớp!' });
            return;
        }

        if (!fullName || !email || !password) {
            Toast.fire({ icon: 'error', title: 'Vui lòng điền đầy đủ thông tin bắt buộc!' });
            return;
        }

        // --- LƯU TRỮ VÀO LOCALSTORAGE ---
        let users = JSON.parse(localStorage.getItem('users')) || [];

        const userExists = users.some(user => user.email === email);
        if (userExists) {
            Toast.fire({ icon: 'error', title: 'Email này đã được sử dụng!' });
            return;
        }

        // Tạo một đối tượng người dùng mới, có thêm SĐT
        const newUser = {
            fullName: fullName,
            email: email,
            password: password,
            phone: phone, // Thêm SĐT vào đây
            orders: []
        };
        users.push(newUser);

        localStorage.setItem('users', JSON.stringify(users));

        // Thông báo thành công và chuyển hướng
        Swal.fire({
            icon: 'success',
            title: 'Đăng ký thành công!',
            text: 'Bạn sẽ được chuyển đến trang đăng nhập ngay bây giờ.',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'my-swal-popup',
                title: 'my-swal-title',
                htmlContainer: 'my-swal-html-container',
                confirmButton: 'my-swal-confirm-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.html';
            }
        });
    });
});