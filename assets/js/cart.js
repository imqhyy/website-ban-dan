document.addEventListener('DOMContentLoaded', function() {
    
    const cartContainer = document.getElementById('cart-items-container');
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function renderCart() {
        cartContainer.innerHTML = '';
        
        if (cart.length === 0) {
            cartContainer.innerHTML = '<p class="text-center my-5">Giỏ hàng của bạn đang trống.</p>';
            cartSubtotalElement.textContent = '0 VNĐ';
            cartTotalElement.textContent = '0 VNĐ';
            updateCartIcon();
            return;
        }

        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            const cartItemHTML = `
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-12 mt-3 mt-lg-0 mb-lg-0 mb-3">
                            <div class="product-info d-flex align-items-center">
                                <div class="product-image">
                                    <img src="${item.image}" alt="${item.name}" class="img-fluid" loading="lazy">
                                </div>
                                <div class="product-details">
                                    <h6 class="product-title">${item.name}</h6>
                                    <button class="remove-item btn-remove" type="button" data-index="${index}">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                            <div class="price-tag">
                                <span class="current-price">${item.price.toLocaleString('vi-VN')} VNĐ</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                            <div class="quantity-selector">
                                <button class="quantity-btn decrease" data-index="${index}"><i class="bi bi-dash"></i></button>
                                <input type="number" class="quantity-input" value="${item.quantity}" min="1" data-index="${index}">
                                <button class="quantity-btn increase" data-index="${index}"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                            <div class="item-total">
                                <strong>${itemTotal.toLocaleString('vi-VN')} VNĐ</strong>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            cartContainer.innerHTML += cartItemHTML;
        });

        cartSubtotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;
        cartTotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`; // Tạm thời tổng cộng bằng tạm tính
        updateCartIcon();
    }

    function updateAndSaveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    cartContainer.addEventListener('click', function(event) {
        const target = event.target.closest('button'); // Tìm nút được bấm gần nhất
        if (!target) return;

        if (target.classList.contains('btn-remove')) {
            const index = target.dataset.index;
            cart.splice(index, 1);
            updateAndSaveCart();
        }
        
        if (target.classList.contains('increase')) {
            const index = target.dataset.index;
            cart[index].quantity++;
            updateAndSaveCart();
        }
        
        if (target.classList.contains('decrease')) {
            const index = target.dataset.index;
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
                updateAndSaveCart();
            }
        }
    });
    
    cartContainer.addEventListener('change', function(event) {
        if (event.target.classList.contains('quantity-input')) {
            const index = event.target.dataset.index;
            let newQuantity = parseInt(event.target.value);
            if (newQuantity < 1 || isNaN(newQuantity)) {
                newQuantity = 1;
            }
            cart[index].quantity = newQuantity;
            updateAndSaveCart();
        }
    });

    renderCart();
});

// Hàm cập nhật icon giỏ hàng ở header
function updateCartIcon() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadges = document.querySelectorAll('.header-actions .bi-cart3 + .badge'); // Cập nhật cho tất cả badge
    cartBadges.forEach(badge => {
        if (badge) {
            badge.textContent = totalItems;
        }
    });
}