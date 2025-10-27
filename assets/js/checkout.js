// Thay thế toàn bộ file assets/js/checkout.js

document.addEventListener('DOMContentLoaded', function () {

    // --- BẢO VỆ TRANG ---
    const currentUser = JSON.parse(sessionStorage.getItem('currentUser'));
    // KHÔNG KIỂM TRA GIỎ HÀNG THẬT NỮA

    if (!currentUser) {
        Swal.fire({ icon: 'warning', title: 'Yêu cầu đăng nhập', text: 'Bạn cần đăng nhập để thanh toán!' }).then(() => { window.location.href = 'login.html'; });
        return;
    }

    // --- LẤY CÁC PHẦN TỬ HTML ---
    const firstNameInput = document.getElementById('first-name');
    const lastNameInput = document.getElementById('last-name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const summaryItemsContainer = document.getElementById('order-summary-items');
    const itemCountElement = document.getElementById('item-count');
    const orderSubtotalElement = document.getElementById('order-subtotal');
    const orderTotalElement = document.getElementById('order-total');
    const placeOrderBtnPrice = document.getElementById('place-order-btn-price');
    const checkoutForm = document.getElementById('checkout-form');

    // --- ĐIỀN THÔNG TIN CÓ SẴN CỦA NGƯỜI DÙNG ---
    if (currentUser.fullName) {
        const nameParts = currentUser.fullName.split(' ');
        firstNameInput.value = nameParts.shift();
        lastNameInput.value = nameParts.join(' ');
    }
    emailInput.value = currentUser.email || '';
    phoneInput.value = currentUser.phone || '';

    // --- HIỂN THỊ TÓM TẮT ĐƠN HÀNG (DEMO) ---
    const demoCart = [
        { name: "Saga A1 DE PRO", quantity: 1, price: 2000000, image: "assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg" },
        { name: "Ba đờn C100", quantity: 1, price: 5000000, image: "assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg" },
        { name: "Taylor A12E", quantity: 1, price: 85000000, image: "assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg" }
    ];

    let total = 0;
    let totalItems = 0;
    summaryItemsContainer.innerHTML = '';
    demoCart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        totalItems += item.quantity;
        const itemHTML = `
            <div class="order-item">
                <div class="order-item-image"><img src="${item.image}" alt="${item.name}" class="img-fluid"></div>
                <div class="order-item-details">
                    <h4>${item.name}</h4>
                    <div class="order-item-price">
                        <span class="quantity">${item.quantity} ×</span>
                        <span class="price">${item.price.toLocaleString('vi-VN')} VNĐ</span>
                    </div>
                </div>
            </div>`;
        summaryItemsContainer.innerHTML += itemHTML;
    });

    itemCountElement.textContent = `${totalItems} sản phẩm`;
    const formattedTotal = `${total.toLocaleString('vi-VN')} VNĐ`;
    orderSubtotalElement.textContent = formattedTotal;
    orderTotalElement.textContent = formattedTotal;
    placeOrderBtnPrice.textContent = formattedTotal;

    // --- XỬ LÝ SỰ KIỆN ĐẶT HÀNG (DEMO) ---
    checkoutForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // --- BẮT ĐẦU SỬA ĐỔI TỪ ĐÂY ---

        Swal.fire({
            icon: 'success',
            title: 'Đặt hàng thành công!',
            text: 'Cảm ơn bạn đã mua hàng.',

            // Cài đặt cho nền mờ (blur)
            backdrop: true, // Bật nền mờ
            allowOutsideClick: false, // Không cho bấm ra ngoài

            // Cài đặt 2 nút bấm
            showCancelButton: true, // <-- DÒNG NÀY SẼ THÊM NÚT THỨ 2
            confirmButtonText: 'Xem xác nhận đơn hàng',
            cancelButtonText: 'Tiếp tục mua sắm'

        }).then((result) => {
            // Xử lý logic sau khi bấm nút
            if (result.isConfirmed) {
                // Nếu bấm nút "Xem xác nhận đơn hàng"
                window.location.href = 'order-confirmation.html';
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Nếu bấm nút "Tiếp tục mua sắm"
                window.location.href = 'index.html'; // Chuyển về trang chủ
            }
        });

        // --- KẾT THÚC SỬA ĐỔI ---
    });
});