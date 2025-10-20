// Lấy các phần tử
var modal = document.getElementById("customerDetailModal");
var closeButton = document.querySelector(".close-button");

// Hàm hiển thị Modal và điền dữ liệu (Cần được gọi khi bấm nút)
function showCustomerDetails(name, phone, img) {
    // 1. Điền dữ liệu vào Modal
    document.getElementById("modalName").innerText = name;
    document.getElementById("modalPhone").innerText = phone;
    document.getElementById('modalImage').src = img;
    // ... Điền các dữ liệu khác tại đây
    
    // 2. Hiển thị Modal
    modal.style.display = "block";
}

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
        var customerName = 'Châu Tinh Trì'; 
        var customerPhone = '0987654321';
        var customerImage = 'assets/img/person/chautinhtri.jpg'
        showCustomerDetails(customerName, customerPhone, customerImage);
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