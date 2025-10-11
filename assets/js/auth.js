const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
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
    
    // Tìm đến thẻ div có id="user-session"
    const userSessionDiv = document.getElementById('user-session');

    // Kiểm tra trạng thái đăng nhập
    const currentUserJSON = sessionStorage.getItem('currentUser');

    if (currentUserJSON) {
        // --- NẾU ĐÃ ĐĂNG NHẬP ---
        const currentUser = JSON.parse(currentUserJSON);

        // Tạo HTML có lời chào và nút Đăng xuất
        userSessionDiv.innerHTML = `
            <p class="text-center mb-2 welcome-text">Xin chào, <strong>${currentUser.fullName}</strong></p>
            <a href="#" id="logout-btn" class="btn btn-danger w-100">Đăng xuất</a>
        `;

        // Gắn sự kiện click cho nút Đăng xuất
        const logoutBtn = document.getElementById('logout-btn');
        logoutBtn.addEventListener('click', function(event) {
            event.preventDefault(); 
            
            // Xóa thông tin người dùng khỏi sessionStorage
            sessionStorage.removeItem('currentUser');
            
            // THAY ĐỔI 2: Thay thế alert() bằng Toast và xử lý chuyển trang
            Toast.fire({
                icon: 'success',
                title: 'Đăng xuất thành công!'
            }).then(() => {
                // Sau khi toast biến mất, mới tải lại trang
                window.location.href = 'index.html';
            });
        });

    } else {
        // --- NẾU CHƯA ĐĂNG NHẬP ---
        
        // Tạo lại 2 nút Đăng nhập và Đăng ký
        userSessionDiv.innerHTML = `
            <a href="login.html" class="btn btn-primary w-100 mb-2">Đăng nhập</a>
            <a href="register.html" class="btn btn-outline-primary w-100">Đăng ký</a>
        `;
    }
});