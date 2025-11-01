                                    //DÀNH CHO QUẢN LÝ ĐƠN HÀNG
                


// DÀNH CHO QUẢN LÝ ĐƠN HÀNG
document.addEventListener('DOMContentLoaded', function() {
    const editIcons = document.querySelectorAll('.edit-status-order');
    
    // --- BỔ SUNG: Xử lý click ra bên ngoài để đóng dropdown ---
    document.addEventListener('click', function(event) {
        // Lấy tất cả các dropdown đang mở
        const openContainers = document.querySelectorAll('.status-select-container:not(.hidden)');
        
        openContainers.forEach(container => {
            // 1. Tìm phần tử chứa dropdown (status-block)
            const statusBlock = container.closest('.status-block');
            
            // 2. Kiểm tra xem cú nhấp chuột (event.target) có nằm ngoài status-block không
            // Dùng !statusBlock.contains(event.target) để xác định
            if (statusBlock && !statusBlock.contains(event.target)) {
                // Nếu nhấp chuột bên ngoài status-block, thêm class 'hidden' để đóng
                container.classList.add('hidden');
            }
        });
    });
    // ------------------------------------------------------------
    //2. Tính năng khi mở dropdown nó sẽ tự tô đậm dòng trùng với trạng thái hiện tại cộng với tính năng ẩn hiện dropdown
    editIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const statusBlock = icon.closest('.status-block');
            const statusSelectContainer = statusBlock.querySelector('.status-select-container');

            // Lấy trạng thái hiện tại (Giả định đã có ID: 'order-status-value' như gợi ý trước)
            const currentStatusElement = statusBlock.querySelector('.order-status-value') || statusBlock.querySelector('b');
            const currentStatus = currentStatusElement ? currentStatusElement.textContent.trim() : null;

            // 3. Chuyển đổi (toggle) class 'hidden' để hiện/ẩn
            if (statusSelectContainer) {
                statusSelectContainer.classList.toggle('hidden');
                
                // --- LOGIC TÔ ĐẬM TRẠNG THÁI HIỆN TẠI ---
                const statusButtons = statusSelectContainer.querySelectorAll('.status-select-button');

                statusButtons.forEach(button => {
                    button.classList.remove('current-status'); 
                    const buttonStatus = button.getAttribute('data-status') || button.textContent.trim();
                    
                    if (buttonStatus === currentStatus) {
                        button.classList.add('current-status');
                    }
                });
                // -------------------------------------------
            }
        
            // [Tính năng bổ sung] Đóng các hộp chọn trạng thái khác nếu có
            // Lưu ý: Tính năng này vẫn giữ lại để đảm bảo chỉ 1 dropdown được mở khi click bút chì
            document.querySelectorAll('.status-select-container').forEach(container => {
                if (container !== statusSelectContainer && !container.classList.contains('hidden')) {
                    container.classList.add('hidden');
                }
            });
        });
    });

    // --- 3. XỬ LÝ CLICK VÀO OPTION TRONG DROPDOWN ĐỂ ĐÓNG VÀ CẬP NHẬT (TÍNH NĂNG MỚI) ---
    const statusButtons = document.querySelectorAll('.status-select-button');

    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy giá trị trạng thái mới được chọn
            const newStatus = button.textContent.trim();
            
            // 1. Đóng dropdown (Thao tác chính theo yêu cầu)
            const statusSelectContainer = button.closest('.status-select-container');
            if (statusSelectContainer) {
                statusSelectContainer.classList.add('hidden');
            }
            
            // [BỔ SUNG - Nâng cao] Cập nhật trạng thái hiển thị
            const statusBlock = button.closest('.status-block');
            if (statusBlock) {
                // Giả định thẻ <b> là nơi hiển thị trạng thái hiện tại
                const currentStatusDisplay = statusBlock.querySelector('.order-status-value') || statusBlock.querySelector('b');
                if (currentStatusDisplay) {
                    currentStatusDisplay.textContent = newStatus;
                    
                    // *Lưu ý: Bạn có thể thêm AJAX call ở đây để gửi newStatus lên server*
                }
            }
            
        });
    });
    // ---------------------------------------------------------------------------------
});

////////////////////////////////////////
///////Pop-up chi tiết đơn hàng/////////
////////////////////////////////////////

// Lấy các phần tử
var modal = document.getElementById("DetailModal");
var closeButton = document.querySelector(".close-button");

if(modal && closeButton) {

    // --------------------
    // Bấm vào nút "Chi tiết"
    // --------------------
    // Bạn cần lắng nghe sự kiện bấm vào nút 'Chi tiết'
    // Giả sử nút 'Chi tiết' có class là 'detail-btn'
    document.querySelectorAll('.detail-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn hành động chuyển trang mặc định của thẻ <a>
            
            // **Lưu ý quan trọng:** Bạn phải lấy dữ liệu (Nguyễn Văn A, SĐT) từ HTML/Database
            // Trong ví dụ này, ta giả định dữ liệu có sẵn:
            modal.style.display = "block";
        });
    });

    // --------------------
    // Đóng Modal
    // --------------------
    // Khi bấm vào nút Đóng (X)
    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    // Khi bấm vào bất kỳ đâu ngoài Modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    document.querySelector('.close-button-detail-order').onclick = function() {
        modal.style.display = "none";
    }
}




