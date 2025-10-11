// Chờ cho toàn bộ nội dung trang được tải xong
document.addEventListener('DOMContentLoaded', function() {
    // Lấy form đăng ký bằng id mà anh vừa thêm vào
    const registerForm = document.getElementById('register-form');

    // Lắng nghe sự kiện khi người dùng nhấn nút "Tạo tài khoản"
    registerForm.addEventListener('submit', function(event) {
        // Ngăn chặn form gửi đi theo cách mặc định
        event.preventDefault();

        // Lấy giá trị từ các ô input trong form của anh
        const fullName = document.getElementById('Họ và Tên').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value; // Sửa id cho đúng với HTML của anh

        // --- VALIDATION (Kiểm tra dữ liệu) ---
        // 1. Kiểm tra mật khẩu có khớp không
        if (password !== confirmPassword) {
            alert('Mật khẩu xác nhận không khớp!');
            return; // Dừng hàm
        }

        // 2. Kiểm tra các trường có bị bỏ trống không (dù đã có required)
        if (!fullName || !email || !password) {
            alert('Vui lòng điền đầy đủ thông tin bắt buộc.');
            return;
        }

        // --- LƯU TRỮ VÀO LOCALSTORAGE ---
        // 3. Lấy danh sách người dùng đã có từ localStorage
        let users = JSON.parse(localStorage.getItem('users')) || [];

        // 4. Kiểm tra xem email đã tồn tại chưa (dùng email làm định danh chính)
        const userExists = users.some(user => user.email === email);
        if (userExists) {
            alert('Email này đã được sử dụng để đăng ký!');
            return;
        }

        // 5. Nếu mọi thứ ổn, tạo một đối tượng người dùng mới
        const newUser = {
            fullName: fullName,
            email: email,
            password: password 
        };
        users.push(newUser);

        // 6. Lưu lại mảng users mới vào localStorage
        localStorage.setItem('users', JSON.stringify(users));

        // 7. Thông báo thành công và chuyển hướng người dùng
        alert('Đăng ký thành công! Bạn sẽ được chuyển đến trang đăng nhập.');
        window.location.href = 'login.html'; // Chuyển sang trang đăng nhập
    });
});