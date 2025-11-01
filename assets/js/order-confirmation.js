document.addEventListener('DOMContentLoaded', function () {

    // --- LẤY DỮ LIỆU DEMO ---
    const currentUser = JSON.parse(sessionStorage.getItem('currentUser'));

    // Tạo 3 sản phẩm mẫu (giống 3 sản phẩm trong cart.html và checkout.html)
    const demoOrderItems = [
        { name: "Saga A1 DE PRO", quantity: 1, price: 2000000, image: "assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg" },
        { name: "Ba đờn C100", quantity: 1, price: 5000000, image: "assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg" },
        { name: "Taylor A12E", quantity: 1, price: 85000000, image: "assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg" }
    ];

    // Tính toán tổng tiền
    let total = 0;
    demoOrderItems.forEach(item => {
        total += item.price * item.quantity;
    });

    // --- LẤY CÁC VỊ TRÍ CẦN ĐIỀN THÔNG TIN ---
    const orderIdEl = document.getElementById('summary-order-id');
    const orderDateEl = document.getElementById('summary-order-date');
    const priceListEl = document.getElementById('summary-price-list');
    const thankYouNameEl = document.getElementById('thank-you-name');
    const shippingDetailsEl = document.getElementById('shipping-address-details');
    const itemListEl = document.getElementById('confirmation-item-list');

    // --- ĐIỀN THÔNG TIN VÀO TRANG ---

    // 1. Cột trái (Sidebar)
    if (orderIdEl) orderIdEl.textContent = `Mã đơn: #ORD-2024-1279`;
    if (orderDateEl) orderDateEl.textContent = `Ngày đặt: ${new Date().toLocaleDateString('vi-VN')}`;
    if (priceListEl) {
        priceListEl.innerHTML = `
            <li class="total">
                <span>Tổng cộng</span>
                <span>${total.toLocaleString('vi-VN')} VND</span>
            </li>
        `;
    }

    // 2. Cột phải (Nội dung chính)
    if (currentUser) {
        if (thankYouNameEl) thankYouNameEl.textContent = `Cảm ơn, Long G!`;
        if (shippingDetailsEl) {
            shippingDetailsEl.innerHTML = `
                Long G<br>
                Địa chỉ: 273 An Dương Vương, Phường, Chợ Quán, Thành phố Hồ Chí Minh 700000<br>
                Email: dragonG@gmai.com <br>
                SĐT: (096) 969-6969`;
        }
    } else {
        if (thankYouNameEl) thankYouNameEl.textContent = `Cảm ơn bạn đã đặt hàng!`;
    }

    // 3. Điền danh sách sản phẩm
    if (itemListEl) {
        itemListEl.innerHTML = ''; // Xóa nội dung mẫu
        demoOrderItems.forEach(item => {
            const itemHTML = `
                <div class="item">
                    <div class="item-image">
                        <img src="${item.image}" alt="${item.name}" loading="lazy">
                    </div>
                    <div class="item-details">
                        <h4>${item.name}</h4>
                        <div class="item-price">
                            <span class="quantity">${item.quantity} ×</span>
                            <span class="price">${item.price.toLocaleString('vi-VN')} VNĐ</span>
                        </div>
                    </div>
                </div>
            `;
            itemListEl.innerHTML += itemHTML;
        });
    }
});