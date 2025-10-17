document.addEventListener('DOMContentLoaded', function() {
    const lastOrder = JSON.parse(localStorage.getItem('lastOrder'));

    if (!lastOrder) {
        document.querySelector('.container').innerHTML = '<h1>Không tìm thấy thông tin đơn hàng.</h1>';
        return;
    }

    // --- LẤY CÁC VỊ TRÍ CẦN ĐIỀN THÔNG TIN ---
    // Cột trái
    document.getElementById('summary-order-id').textContent = `Mã đơn: ${lastOrder.orderId}`;
    document.getElementById('summary-order-date').textContent = `Ngày đặt: ${lastOrder.date}`;
    document.getElementById('summary-price-list').innerHTML = `
        <li class="total">
            <span>Tổng cộng</span>
            <span>${lastOrder.total.toLocaleString('vi-VN')} VNĐ</span>
        </li>
    `;

    // Cột phải
    document.getElementById('thank-you-name').textContent = `Cảm ơn ${lastOrder.shippingInfo.name}!`;
    document.getElementById('shipping-address-details').innerHTML = `
        ${lastOrder.shippingInfo.name}<br>
        ${lastOrder.shippingInfo.address}<br>
        SĐT: ${lastOrder.shippingInfo.phone}
    `;

    const itemListContainer = document.getElementById('confirmation-item-list');
    itemListContainer.innerHTML = ''; // Xóa nội dung mẫu
    lastOrder.items.forEach(item => {
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
        itemListContainer.innerHTML += itemHTML;
    });

    // Xóa thông tin đơn hàng vừa xem để không bị hiện lại ở lần sau
    localStorage.removeItem('lastOrder');
});