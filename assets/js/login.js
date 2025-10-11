document.addEventListener('DOMContentLoaded', function() {
    // Lấy form đăng nhập bằng id "login-form"
    const loginForm = document.getElementById('login-form');

    // Lắng nghe sự kiện submit form
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn form gửi đi

        // Lấy giá trị từ các input có id="email" và id="password"
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Lấy danh sách tài khoản đã đăng ký từ localStorage
        const users = JSON.parse(localStorage.getItem('users')) || [];

        // Tìm kiếm trong danh sách xem có tài khoản nào khớp cả email và mật khẩu không
        const validUser = users.find(user => user.email === email && user.password === password);

        if (validUser) {
            // NẾU TÌM THẤY (ĐĂNG NHẬP THÀNH CÔNG)
            alert('Đăng nhập thành công!');
            
            // Lưu thông tin người dùng hiện tại vào sessionStorage
            sessionStorage.setItem('currentUser', JSON.stringify(validUser));

            // Chuyển hướng người dùng về trang chủ
            window.location.href = 'index.html';
        } else {
            // NẾU KHÔNG TÌM THẤY (ĐĂNG NHẬP THẤT BẠI)
            alert('Email hoặc mật khẩu không đúng!');
        }
    });
});