document.addEventListener('DOMContentLoaded', function() {
    
    // Tìm đến thẻ div có id="user-session"
    const userSessionDiv = document.getElementById('user-session');

    // Kiểm tra trạng thái đăng nhập
    const currentUserJSON = sessionStorage.getItem('currentUser');

    if (currentUserJSON) {
        // --- NẾU ĐÃ ĐĂNG NHẬP ---
        const currentUser = JSON.parse(currentUserJSON);

        // Tạo HTML có lời chào và nút Đăng xuất
        //  thêm 1 class "welcome-text" để có thể chỉnh style nếu muốn
        userSessionDiv.innerHTML = `
            <p class="text-center mb-2 welcome-text">Xin chào, <strong>${currentUser.fullName}</strong></p>
            <a href="#" id="logout-btn" class="btn btn-outline-primary w-100">Đăng xuất</a>
        `;

        // Gắn sự kiện click cho nút Đăng xuất
        const logoutBtn = document.getElementById('logout-btn');
        logoutBtn.addEventListener('click', function(event) {
            event.preventDefault(); 
            sessionStorage.removeItem('currentUser');
            alert('Bạn đã đăng xuất thành công!');
            window.location.href = 'index.html';
        });

    } else {
        // --- NẾU CHƯA ĐĂNG NHẬP ---
        
<<<<<<< HEAD
        // Tạo lại 2 nút Đăng nhập và Đăng ký y như code gốc
=======
        // Tạo lại 2 nút Đăng nhập và Đăng ký
>>>>>>> main
        userSessionDiv.innerHTML = `
            <a href="login.html" class="btn btn-primary w-100 mb-2">Đăng nhập</a>
            <a href="register.html" class="btn btn-outline-primary w-100">Đăng ký</a>
        `;
    }
});
