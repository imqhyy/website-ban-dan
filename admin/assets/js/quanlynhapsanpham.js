/* ==========================================================
   LOGIC XEM THÊM / THU GỌN SẢN PHẨM TRONG PHIẾU NHẬP
   ========================================================== */
document.addEventListener('click', function(e) {
    // Kiểm tra nếu click vào nút (hoặc icon bên trong nút) có class 'show-more-products'
    const btn = e.target.closest('.show-more-products');
    
    if (btn) {
        const tbody = btn.closest('tbody');
        const extraRows = tbody.querySelectorAll('.extra-product');
        const count = btn.getAttribute('data-count');
        
        // Kiểm tra trạng thái hiện tại (đang ẩn hay đang hiện)
        const isCollapsed = extraRows[0].classList.contains('d-none');

        // Bật/tắt class d-none cho tất cả các dòng sản phẩm bổ sung
        extraRows.forEach(row => row.classList.toggle('d-none'));

        // Cập nhật giao diện nút bấm
        if (isCollapsed) {
            btn.innerHTML = `<i class="bi bi-chevron-double-up"></i> Thu gọn`;
            btn.style.background = "#fff3cd"; // Đổi màu nhẹ khi mở ra để dễ phân biệt
        } else {
            btn.innerHTML = `<i class="bi bi-chevron-double-down"></i> Xem thêm ${count} sản phẩm khác`;
            btn.style.background = "#f8f9fa";
        }
    }
});