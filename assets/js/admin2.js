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


document.addEventListener("DOMContentLoaded", function () {
    const citySelect = document.getElementById("filter-city");
    const wardSelect = document.getElementById("filter-ward");

    // Lấy dữ liệu lọc từ biến toàn cục do PHP truyền sang
    const savedCity = window.currentFilters ? window.currentFilters.city : "";
    const savedWard = window.currentFilters ? window.currentFilters.ward : "";

    const addressData = {
        "Thành phố Hồ Chí Minh": [
            "Phường Bến Nghé", "Phường Bến Thành", "Phường Đa Kao", "Phường Nguyễn Thái Bình", "Phường Phạm Ngũ Lão", "Phường Nguyễn Cư Trinh", "Phường Cô Giang", "Phường Cầu Kho", "Phường Tân Định",
            "Phường Võ Thị Sáu", "Phường 14", "Phường 1", "Phường 2", "Phường 4", "Phường 5", "Phường 9", "Phường 12",
            "Phường 6", "Phường 13", "Phường 15", "Phường 16", "Phường 18", "Phường 7", 
            "Phường Bình Thuận", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Tân Hưng", "Phường Tân Kiểng", "Phường Tân Phong", "Phường Tân Phú", "Phường Tân Quy", "Phường Tân Thuận Đông", "Phường Tân Thuận Tây",
            "Phường 8", "Phường 10", "Phường 11", "Phường 3", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"
        ],
        "Thành phố Đà Nẵng": [
            "Phường Hải Châu I", "Phường Hải Châu II", "Phường Thạch Thang", "Phường Nam Dương", "Phường Phước Ninh", "Phường Bình Hiên", "Phường Bình Thuận", "Phường Hòa Thuận Đông", "Phường Hòa Thuận Tây", "Phường Hòa Cường Bắc", "Phường Hòa Cường Nam",
            "Phường Thọ Quang", "Phường Nại Hiên Đông", "Phường Mân Thái", "Phường An Hải Bắc", "Phường Phước Mỹ", "Phường An Hải Tây", "Phường An Hải Đông",
            "Phường Mỹ An", "Phường Khuê Mỹ", "Phường Hòa Hải", "Phường Hòa Quý",
            "Phường Thanh Bình", "Phường Thuận Phước", "Phường Thạc Gián", "Phường Chính Gián", "Phường Vĩnh Trung", "Phường Tân Chính", "Phường Xuân Hà", "Phường Tam Thuận", "Phường Thanh Khê Đông", "Phường Thanh Khê Tây", "Phường An Khê", "Phường Hòa Khê",
            "Phường Hòa Minh", "Phường Hòa Khánh Nam", "Phường Hòa Khánh Bắc", "Phường Hòa Hiệp Nam", "Phường Hòa Hiệp Bắc",
            "Phường Khuê Trung", "Phường Hòa Thọ Đông", "Phường Hòa Thọ Tây", "Phường Hòa Phát", "Phường Hòa An", "Phường Hòa Xuân"
        ]
    };

    // 1. Tải danh sách Thành phố và giữ trạng thái 'selected'
    Object.keys(addressData).forEach(city => {
        let option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        // Nếu thành phố này trùng với thành phố đang lọc trên URL
        if (city === savedCity) option.selected = true; 
        citySelect.appendChild(option);
    });

    // 2. Hàm tải Phường/Xã và giữ trạng thái 'selected'
    function loadWards(selectedCity, selectedWard = "") {
        wardSelect.innerHTML = '<option value="">-- Tất cả Phường/Xã --</option>';
        if (selectedCity && addressData[selectedCity]) {
            addressData[selectedCity].forEach(ward => {
                let option = document.createElement("option");
                option.value = ward;
                option.textContent = ward;
                // Nếu phường này trùng với phường đang lọc trên URL
                if (ward === selectedWard) option.selected = true; 
                wardSelect.appendChild(option);
            });
            wardSelect.disabled = false;
        } else {
            wardSelect.disabled = true;
        }
    }

    // Sự kiện khi admin chủ động thay đổi Thành phố trên giao diện
    citySelect.addEventListener("change", function() {
        loadWards(this.value);
    });

    // 3. QUAN TRỌNG: Tự động kích hoạt khi trang vừa tải xong
    if (savedCity) {
        loadWards(savedCity, savedWard);
    }
});