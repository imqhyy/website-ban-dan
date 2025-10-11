// THAY ĐỔI 1: Thêm "khuôn mẫu" Toast đã được đồng bộ style
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
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

            // THAY ĐỔI 3: Thay thế alert() bằng Toast báo lỗi
            Toast.fire({
                icon: 'error',
                title: 'Email hoặc mật khẩu không đúng!'
            });
        }
    });
});