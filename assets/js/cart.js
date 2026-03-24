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
        let totalSavings = 0;
        if (!cartContainer) return;

        // Đếm số lượng loại sản phẩm
        const totalBadgeItems = cartContainer.querySelectorAll('.cart-item').length;
        const badge = document.getElementById('cart-badge');
        if (badge) badge.innerText = totalBadgeItems;

        // Tính toán các sản phẩm không bị hết hàng
        cartContainer.querySelectorAll('.cart-item:not(.out-of-stock)').forEach(itemRow => {
            const price = parseFloat(itemRow.dataset.price);
            const originalPrice = parseFloat(itemRow.dataset.originalPrice || price);
            const quantityInput = itemRow.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);
            const checkbox = itemRow.querySelector('.item-check');

            const itemTotal = price * quantity;
            const itemTotalElement = itemRow.querySelector('.item-total strong');
            if (itemTotalElement) {
                itemTotalElement.textContent = `${itemTotal.toLocaleString('vi-VN')} VNĐ`;
            }

            // Chỉ cộng tiền nếu ô checkbox được tích
            if (checkbox && checkbox.checked) {
                subtotal += itemTotal;
                totalSavings += (originalPrice - price) * quantity;
            }
        });

        // Cập nhật DOM
        if (cartSubtotalElement) cartSubtotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;
        if (cartTotalElement) cartTotalElement.textContent = `${subtotal.toLocaleString('vi-VN')} VNĐ`;

        // Ẩn hiện DOM Tiết kiệm
        const savingsContainer = document.getElementById('cart-savings-container');
        const savingsElement = document.getElementById('cart-savings');
        if (savingsContainer && savingsElement) {
            if (totalSavings > 0) {
                savingsContainer.style.display = 'flex';
                // Đã bỏ dấu trừ (-) ở đầu
                savingsElement.textContent = `${totalSavings.toLocaleString('vi-VN')} VNĐ`;
            } else {
                savingsContainer.style.display = 'none';
            }
        }
    }

    // Xử lý sự kiện click (Chỉ dành cho nút Xóa)
    if (cartContainer) {
        cartContainer.addEventListener('click', function (event) {
            const target = event.target.closest('button');
            if (!target) return;

            const itemRow = target.closest('.cart-item');
            const productId = itemRow.dataset.id;

            // Nút xóa
            if (target.classList.contains('remove-item')) {
                itemRow.remove();
                updateTotals();
                sendCartAjax('remove', productId);

                if (cartContainer.querySelectorAll('.cart-item').length === 0) {
                    cartContainer.innerHTML = '<p class="text-center mt-4">Giỏ hàng của bạn đang trống.</p>';
                    const checkoutBtn = document.querySelector('.checkout-button a');
                    if (checkoutBtn) {
                        checkoutBtn.classList.add('disabled');
                        checkoutBtn.style.pointerEvents = 'none';
                        checkoutBtn.style.opacity = '0.5';
                    }
                }
            }
        });

        // Bắt sự kiện thay đổi số lượng (Do main.js bắn qua hoặc gõ tay)
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
                    quantity = maxStock;
                }

                input.value = quantity;
                updateTotals();
                sendCartAjax('update', productId, quantity);
            }
        });
    }

    // Logic xử lý nút Checkbox
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

    if (cartContainer) {
        cartContainer.addEventListener('change', function (e) {
            if (e.target.classList.contains('item-check')) {
                updateTotals();
                const allEnabled = cartContainer.querySelectorAll('.item-check:not([disabled])').length;
                const allChecked = cartContainer.querySelectorAll('.item-check:not([disabled]):checked').length;
                if (checkAllBtn) checkAllBtn.checked = (allEnabled > 0 && allEnabled === allChecked);
            }
        });
    }

    // Logic nút thanh toán
    const checkoutBtn = document.querySelector('.checkout-button a');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const checkedItems = [];
            cartContainer.querySelectorAll('.item-check:checked').forEach(cb => {
                checkedItems.push(cb.value);
            });

            if (checkedItems.length === 0) {
                Swal.fire('Opps!', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.', 'warning');
                return;
            }
            window.location.href = 'checkout.php?items=' + checkedItems.join(',');
        });
    }

    updateTotals(); // Chạy khởi tạo 1 lần
});