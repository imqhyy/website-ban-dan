document.addEventListener('DOMContentLoaded', function () {
    const cartContainer = document.getElementById('cart-items-container-demo');
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');

    // Hàm gọi AJAX để lưu thay đổi
    function sendCartAjax(action, productId, quantity = 0) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('product_id', productId);
        if (quantity > 0) formData.append('quantity', quantity);

        fetch('forms/ajax/ajax_cart.php', {
            method: 'POST',
            body: formData
        }).then(res => res.json()).then(data => {
            if (data.status === 'success' && action === 'remove') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Đã xóa sản phẩm',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    // Cập nhật lại tổng tiền trên giao diện
    function updateTotals() {
        let subtotal = 0;
        if (!cartContainer) return;

        // BỎ QUA CÁC SẢN PHẨM CÓ CLASS .out-of-stock
        cartContainer.querySelectorAll('.cart-item:not(.out-of-stock)').forEach(itemRow => {
            const price = parseFloat(itemRow.dataset.price);
            const quantityInput = itemRow.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);
            const checkbox = itemRow.querySelector('.item-check'); // Lấy checkbox

            const itemTotal = price * quantity;
            const itemTotalElement = itemRow.querySelector('.item-total strong');
            if (itemTotalElement) {
                itemTotalElement.textContent = `${itemTotal.toLocaleString('vi-VN')} VNĐ`;
            }

            // CHỈ CỘNG VÀO TỔNG TIỀN NẾU ĐƯỢC TICK
            if (checkbox && checkbox.checked) {
                subtotal += itemTotal;
            }
        });

        if (cartSubtotalElement) cartSubtotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;
        if (cartTotalElement) cartTotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;
    }

    // Xử lý sự kiện click (Tăng, Giảm, Xóa)
    if (cartContainer) {
        cartContainer.addEventListener('click', function (event) {
            const target = event.target.closest('button');
            if (!target) return;

            const itemRow = target.closest('.cart-item');
            const productId = itemRow.dataset.id;
            const quantityInput = itemRow.querySelector('.quantity-input');
            let quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            // Tăng số lượng
            // Tăng số lượng
            if (target.classList.contains('increase')) {
                const maxStock = parseInt(quantityInput.getAttribute('max')); // Lấy số tồn kho

                if (quantity >= maxStock) {
                    Swal.fire('Opps!', `Rất tiếc, bạn chỉ có thể mua tối đa ${maxStock} sản phẩm này.`, 'info');
                    return; // Chặn không cho tăng và không gửi AJAX
                }

                quantity++;
                quantityInput.value = quantity;
                updateTotals();
                sendCartAjax('update', productId, quantity);
            }

            // Giảm số lượng
            if (target.classList.contains('decrease')) {
                if (quantity > 1) {
                    quantity--;
                    quantityInput.value = quantity;
                    updateTotals();
                    sendCartAjax('update', productId, quantity);
                }
            }

            // Xóa sản phẩm
            if (target.classList.contains('remove-item')) {
                itemRow.remove(); // Xóa khỏi HTML
                updateTotals(); // Tính lại tiền
                sendCartAjax('remove', productId); // Xóa khỏi DB

                // Cập nhật lại số trên icon header
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    let currentCount = parseInt(badge.innerText) || 0;
                    badge.innerText = Math.max(0, currentCount - quantity);
                }
            }

        });
        // Bắt sự kiện khách hàng tự gõ số lượng vào ô input
        cartContainer.addEventListener('change', function (event) {
            if (event.target.classList.contains('quantity-input')) {
                const input = event.target;
                let quantity = parseInt(input.value);
                const maxStock = parseInt(input.getAttribute('max'));
                const productId = input.closest('.cart-item').dataset.id;

                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                } else if (quantity > maxStock) {
                    Swal.fire('Opps!', `Rất tiếc, bạn chỉ có thể mua tối đa ${maxStock} sản phẩm này.`, 'info');
                    quantity = maxStock; // Ép trở lại mức tối đa
                }

                input.value = quantity;
                updateTotals();
                sendCartAjax('update', productId, quantity);
            }
        });
    }

    // Xử lý Checkbox
    const checkAllBtn = document.getElementById('check-all');
    if (checkAllBtn) {
        checkAllBtn.addEventListener('change', function () {
            const isChecked = this.checked;
            cartContainer.querySelectorAll('.item-check:not([disabled])').forEach(cb => {
                cb.checked = isChecked;
            });
            updateTotals();
        });
    }

    cartContainer.addEventListener('change', function (e) {
        if (e.target.classList.contains('item-check')) {
            updateTotals();
            // Cập nhật lại trạng thái nút "Chọn tất cả"
            const allEnabled = cartContainer.querySelectorAll('.item-check:not([disabled])').length;
            const allChecked = cartContainer.querySelectorAll('.item-check:not([disabled]):checked').length;
            if (checkAllBtn) checkAllBtn.checked = (allEnabled > 0 && allEnabled === allChecked);
        }
    });

    // Bắt sự kiện ấn nút "Tiến hành thanh toán"
    const checkoutBtn = document.querySelector('.checkout-button a');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Gom các ID sản phẩm được tick
            const checkedItems = [];
            cartContainer.querySelectorAll('.item-check:checked').forEach(cb => {
                checkedItems.push(cb.value);
            });

            if (checkedItems.length === 0) {
                Swal.fire('Opps!', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.', 'warning');
                return;
            }

            // Chuyển sang trang checkout và nối danh sách ID lên URL
            window.location.href = 'checkout.php?items=' + checkedItems.join(',');
        });
    }

    updateTotals(); // Chạy 1 lần khi load trang
});