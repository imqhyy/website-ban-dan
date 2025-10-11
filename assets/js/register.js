// THAY ĐỔI 1: Thêm customClass vào "khuôn mẫu" Toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    // Báo cho Toast dùng style popup mà đã thêm trong CSS
    customClass: {
        popup: 'my-swal-popup'
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

// Chờ cho toàn bộ nội dung trang được tải xong
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('register-form');

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const fullName = document.getElementById('Họ và Tên').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // --- VALIDATION (Kiểm tra dữ liệu) ---
        if (password !== confirmPassword) {
            // Không cần sửa ở đây, vì nó đã tự động dùng style từ "khuôn mẫu" Toast
            Toast.fire({
                icon: 'error',
                title: 'Mật khẩu xác nhận không khớp!'
            });
            return;
        }

        if (!fullName || !email || !password) {
            Toast.fire({
                icon: 'error',
                title: 'Vui lòng điền đầy đủ thông tin!'
            });
            return;
        }

        // --- LƯU TRỮ VÀO LOCALSTORAGE ---
        let users = JSON.parse(localStorage.getItem('users')) || [];

        const userExists = users.some(user => user.email === email);
        if (userExists) {
            Toast.fire({
                icon: 'error',
                title: 'Email này đã được sử dụng!'
            });
            return;
        }

        const newUser = {
            fullName: fullName,
            email: email,
            password: password
        };
        users.push(newUser);

        localStorage.setItem('users', JSON.stringify(users));

        // THAY ĐỔI 2: Thêm customClass vào Modal báo thành công
        Swal.fire({
            icon: 'success',
            title: 'Đăng ký thành công!',
            text: 'Bạn sẽ được chuyển đến trang đăng nhập ngay bây giờ.',
            confirmButtonText: 'OK',
            // Báo cho Modal này dùng bộ style đã thêm trong CSS
            customClass: {
                popup: 'my-swal-popup',
                title: 'my-swal-title',
                htmlContainer: 'my-swal-html-container',
                confirmButton: 'my-swal-confirm-button'
            }
        }).then((result) => {
            // Sau khi người dùng bấm OK, mới chuyển trang
            if (result.isConfirmed) {
                window.location.href = 'login.html';
            }
        });
    });
});