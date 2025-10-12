document.addEventListener('DOMContentLoaded', function() {
    
    // --- BẢO VỆ TRANG & KIỂM TRA DỮ LIỆU ---
    const currentUser = JSON.parse(sessionStorage.getItem('currentUser'));
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (!currentUser) {
        alert('Bạn cần đăng nhập để thanh toán!');
        window.location.href = 'login.html';
        return;
    }
    if (cart.length === 0) {
        alert('Giỏ hàng của bạn đang trống, không thể thanh toán!');
        window.location.href = 'index.html';
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
    const nameParts = currentUser.fullName.split(' ');
    firstNameInput.value = nameParts.shift();
    lastNameInput.value = nameParts.join(' ');
    emailInput.value = currentUser.email || '';
    phoneInput.value = currentUser.phone || '';

    // --- HIỂN THỊ TÓM TẮT ĐƠN HÀNG ---
    let total = 0;
    let totalItems = 0;
    summaryItemsContainer.innerHTML = ''; 
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        totalItems += item.quantity;
        const itemHTML = `
            <div class="order-item">
                <div class="order-item-image">
                    <img src="${item.image}" alt="${item.name}" class="img-fluid">
                </div>
                <div class="order-item-details">
                    <h4>${item.name}</h4>
                    <div class="order-item-price">
                        <span class="quantity">${item.quantity} ×</span>
                        <span class="price">${item.price.toLocaleString('vi-VN')} VNĐ</span>
                    </div>
                </div>
            </div>
        `;
        summaryItemsContainer.innerHTML += itemHTML;
    });
    
    itemCountElement.textContent = `${totalItems} sản phẩm`;
    const formattedTotal = `${total.toLocaleString('vi-VN')} VNĐ`;
    orderSubtotalElement.textContent = formattedTotal;
    orderTotalElement.textContent = formattedTotal;
    placeOrderBtnPrice.textContent = formattedTotal;

    // --- XỬ LÝ SỰ KIỆN ĐẶT HÀNG ---
    checkoutForm.addEventListener('submit', function(event) {
    event.preventDefault();

    // Lấy thông tin từ form
    const fullName = document.getElementById('first-name').value + ' ' + document.getElementById('last-name').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;

    if (!firstNameInput.value || !lastNameInput.value || !phoneInput.value || !addressInput.value) {
            Toast.fire({ icon: 'error', title: 'Vui lòng điền đầy đủ thông tin giao hàng!' });
            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Đặt hàng thành công!',
            text: 'Cảm ơn bạn đã mua hàng tại Guitar Xì Gòn.',
            confirmButtonText: 'Xem xác nhận đơn hàng',
            customClass: { /* ... custom classes của anh ... */ }
        }).then(() => {
            const newOrder = {
                orderId: `ORD-${Date.now()}`,
                items: cart,
                total: total, // Bây giờ biến total đã hợp lệ
                date: new Date().toLocaleDateString('vi-VN'),
                paymentMethod: document.querySelector('input[name="payment-method"]:checked').value,
                shippingInfo: {
                    name: firstNameInput.value + ' ' + lastNameInput.value,
                    phone: phoneInput.value,
                    address: addressInput.value
                }
            };
            
            let allUsers = JSON.parse(localStorage.getItem('users')) || [];
            const userIndex = allUsers.findIndex(user => user.email === currentUser.email);

            if (userIndex !== -1) {
                if (!allUsers[userIndex].orders) allUsers[userIndex].orders = [];
                allUsers[userIndex].orders.push(newOrder);
                localStorage.setItem('users', JSON.stringify(allUsers));
                currentUser.orders = allUsers[userIndex].orders;
                sessionStorage.setItem('currentUser', JSON.stringify(currentUser));
            }

            localStorage.setItem('lastOrder', JSON.stringify(newOrder));
            localStorage.removeItem('cart');
            window.location.href = 'order-confirmation.html';
        });
    });
});