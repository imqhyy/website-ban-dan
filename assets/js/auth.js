// File: auth.js

// --- HÀM DÙNG CHUNG 1: KHUÔN MẪU TOAST ---
// (Các file khác sẽ "dùng ké" biến Toast này)
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    customClass: { popup: 'my-swal-popup' },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

// --- HÀM DÙNG CHUNG 2: CẬP NHẬT ICON GIỎ HÀNG (DEMO) ---
// (Các file khác cũng sẽ gọi hàm này)
function updateCartIcon(itemCount) {
    // Tìm tất cả các badge có class này
    const allCartBadges = document.querySelectorAll('.cart-item-count-badge');

    allCartBadges.forEach(badge => {
        if (badge) {
            badge.textContent = itemCount;
        }
    });
}

// --- CODE CHÍNH CỦA AUTH.JS ---
document.addEventListener('DOMContentLoaded', function () {

    const userSessionDiv = document.getElementById('user-session');
    const accountDropdown = document.querySelector('.account-dropdown');
    const currentUserJSON = sessionStorage.getItem('currentUser');

    // Tự động tìm và thêm class chung vào các icon giỏ hàng
    const allCartIcons = document.querySelectorAll('.header-actions a[href="cart.html"] .badge, .floating-icon.cart .notification-dot');
    allCartIcons.forEach(icon => icon.classList.add('cart-item-count-badge'));

    if (currentUserJSON) {
        // --- NẾU ĐÃ ĐĂNG NHẬP ---
        const currentUser = JSON.parse(currentUserJSON);

        // 1. HIỂN THỊ ICON GIỎ HÀNG LÀ 3
        updateCartIcon(3);

        // 2. Hiển thị menu tài khoản
        if (accountDropdown) {
            accountDropdown.classList.remove('logged-out');
        }
        userSessionDiv.innerHTML = `
            <p class="text-center mb-2 welcome-text">Xin chào, <strong>${currentUser.fullName}</strong></p>
            <a href="#" id="logout-btn" class="btn btn-danger w-100">Đăng xuất</a>
        `;

        // 3. Gắn sự kiện đăng xuất
        const logoutBtn = document.getElementById('logout-btn');
        logoutBtn.addEventListener('click', function (event) {
            event.preventDefault();
            sessionStorage.removeItem('currentUser');
            updateCartIcon(0); // Cập nhật icon về 0
            Toast.fire({ icon: 'success', title: 'Đăng xuất thành công!' })
                .then(() => {
                    window.location.href = 'index.html';
                });
        });

    } else {
        // --- NẾU CHƯA ĐĂNG NHẬP ---

        // 1. HIỂN THỊ ICON GIỎ HÀNG LÀ 0
        updateCartIcon(0);

        // 2. Ẩn menu và hiện nút đăng nhập
        if (accountDropdown) {
            accountDropdown.classList.add('logged-out');
        }
        userSessionDiv.innerHTML = `
            <a href="login.html" class="btn btn-primary w-100 mb-2">Đăng nhập</a>
            <a href="register.html" class="btn btn-outline-primary w-100">Đăng ký</a>
        `;
    }
});