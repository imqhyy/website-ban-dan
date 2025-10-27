document.addEventListener('DOMContentLoaded', function () {

    const cartContainer = document.getElementById('cart-items-container-demo');
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');

    // --- HÀM TÍNH TOÁN VÀ CẬP NHẬT TỔNG TIỀN (DEMO) ---
    function updateDemoTotal() {
        let subtotal = 0;
        if (!cartContainer) return; // Thoát nếu không tìm thấy giỏ hàng demo

        // Lặp qua từng sản phẩm mẫu
        cartContainer.querySelectorAll('.cart-item').forEach(itemRow => {
            // Lấy giá của sản phẩm (lưu trong data-price)
            const price = parseFloat(itemRow.dataset.price);

            // Lấy số lượng
            const quantityInput = itemRow.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);

            // Tính thành tiền của hàng này
            const itemTotal = price * quantity;
            subtotal += itemTotal;

            // Cập nhật số thành tiền cho hàng này
            const itemTotalElement = itemRow.querySelector('.item-total strong');
            if (itemTotalElement) {
                itemTotalElement.textContent = `${itemTotal.toLocaleString('vi-VN')} VNĐ`;
            }
        });

        // Cập nhật tổng tiền ở cột tóm tắt
        if (cartSubtotalElement) {
            cartSubtotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;
        }
        if (cartTotalElement) {
            cartTotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;
        }
    }

    // --- XỬ LÝ CÁC NÚT BẤM (DEMO) ---
    if (cartContainer) {
        cartContainer.addEventListener('click', function (event) {
            const target = event.target.closest('button');
            if (!target) return;

            const itemRow = target.closest('.cart-item');
            const quantityInput = itemRow.querySelector('.quantity-input');
            let quantity = parseInt(quantityInput.value);

            // Bấm nút +
            if (target.classList.contains('increase')) {
                quantity++;
                if (quantity > 10) quantity = 10;
                quantityInput.value = quantity;
            }

            // Bấm nút -
            if (target.classList.contains('decrease')) {
                if (quantity > 1) {
                    quantity--;
                    quantityInput.value = quantity;
                }
            }

            // Cập nhật lại tổng tiền sau khi bấm
            updateDemoTotal();
        });
    }

    // Tính tổng tiền lần đầu tiên khi tải trang
    updateDemoTotal();
});

// Hàm này để cho file product-details.js gọi
// Nó không làm gì cả, vì icon giỏ hàng đã được auth.js xử lý
function updateCartIcon() {
    // Không làm gì cả
}