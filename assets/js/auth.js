// --- HÀM DÙNG CHUNG 1: KHUÔN MẪU TOAST ---
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

// --- HÀM DÙNG CHUNG 2: CẬP NHẬT ICON GIỎ HÀNG (DEMO) ---
function updateCartIcon(itemCount) {
    const allCartBadges = document.querySelectorAll('.cart-item-count-badge');
    allCartBadges.forEach(badge => {
        if (badge) {
            badge.textContent = itemCount;
        }
    });
}

// --- CODE CHÍNH CỦA AUTH.JS ---
document.addEventListener('DOMContentLoaded', function () {

    // Lấy các phần tử
    const userSessionDiv = document.getElementById('user-session');
    const accountDropdown = document.querySelector('.account-dropdown');
    const currentUserJSON = sessionStorage.getItem('currentUser');

    // Thêm class chung cho tất cả icon giỏ hàng
    const allCartIcons = document.querySelectorAll('.header-actions a[href="cart.html"] .badge, .floating-icon.cart .notification-dot');
    allCartIcons.forEach(icon => icon.classList.add('cart-item-count-badge'));

    if (currentUserJSON) {
        // --- NẾU ĐÃ ĐĂNG NHẬP ---
        updateCartIcon(3);
        const currentUser = JSON.parse(currentUserJSON);

        // **THÊM KIỂM TRA AN TOÀN**
        if (accountDropdown) {
            accountDropdown.classList.remove('logged-out');
        }
        if (userSessionDiv) {
            userSessionDiv.innerHTML = `
                <p class="text-center mb-2 welcome-text">Xin chào, <strong>${currentUser.fullName}</strong></p>
                <a href="#" id="logout-btn" class="btn btn-danger w-100">Đăng xuất</a>
            `;

            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) { // Thêm kiểm tra an toàn
                logoutBtn.addEventListener('click', function (event) {
                    event.preventDefault();
                    sessionStorage.removeItem('currentUser');
                    updateCartIcon(0);
                    Toast.fire({ icon: 'success', title: 'Đăng xuất thành công!' })
                        .then(() => {
                            window.location.href = 'index.html';
                        });
                });
            }
        }

    } else {
        // --- NẾU CHƯA ĐĂNG NHẬP ---
        updateCartIcon(0);

        // **THÊM KIỂM TRA AN TOÀN**
        if (accountDropdown) {
            accountDropdown.classList.add('logged-out');
        }
        if (userSessionDiv) {
            userSessionDiv.innerHTML = `
                <a href="login.html" class="btn btn-primary w-100 mb-2">Đăng nhập</a>
                <a href="register.html" class="btn btn-outline-primary w-100">Đăng ký</a>
            `;
        }
    }
});