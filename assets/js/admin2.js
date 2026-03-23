                                    //DÀNH CHO QUẢN LÝ ĐƠN HÀNG
                


document.addEventListener('DOMContentLoaded', function() {
    // 1. Xử lý Ẩn/Hiện Dropdown trạng thái
    const editIcons = document.querySelectorAll('.edit-status-order');
    editIcons.forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.stopPropagation();
            const statusBlock = icon.closest('.status-block');
            const container = statusBlock.querySelector('.status-select-container');
            
            // Đóng các cái khác
            document.querySelectorAll('.status-select-container').forEach(c => {
                if(c !== container) c.classList.add('hidden');
            });
            container.classList.toggle('hidden');
        });
    });

    // 2. Cập nhật trạng thái qua AJAX
    const statusButtons = document.querySelectorAll('.status-select-button');
    statusButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const newStatus = btn.getAttribute('data-status');
            const statusLabel = btn.textContent;
            const container = btn.closest('.manage-order-container');
            const orderId = container.getAttribute('data-order-id');

            let formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('status', newStatus);
            formData.append('action', 'update_status');

            fetch('forms/quanlydonhang/ajax_update_status.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                if(data.trim() === 'success') {
                    container.querySelector('.order-status-value').textContent = statusLabel;
                    btn.closest('.status-select-container').classList.add('hidden');
                    Toast.fire({ icon: 'success', title: 'Đã cập nhật trạng thái!' });
                }
            });
        });
    });

    // 3. Xử lý Modal Chi tiết
    const modal = document.getElementById("OrderDetailModal");
    const modalBody = document.getElementById("modal-body-content");

    document.querySelectorAll('.detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            modalBody.innerHTML = "Đang tải dữ liệu...";
            modal.style.display = "block";

            fetch(`forms/quanlydonhang/ajax_get_order_details.php?id=${orderId}`)
                .then(res => res.text())
                .then(html => {
                    modalBody.innerHTML = html;
                });
        });
    });

    // 4. Đóng Modal
    document.querySelectorAll('.close-button, .close-button-detail-order').forEach(btn => {
        btn.onclick = () => modal.style.display = "none";
    });

    window.onclick = (e) => {
        if (e.target == modal) modal.style.display = "none";
        if (!e.target.closest('.status-block')) {
            document.querySelectorAll('.status-select-container').forEach(c => c.classList.add('hidden'));
        }
    };
});