// Lấy các phần tử
var modal = document.getElementById("DetailModal");
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
        var customerImage = 'assets/img/person/chautinhtri.jpg';
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

                    /*DÀNH CHO TRANG QUẢN LÝ PHÂN LOẠI*/



//Dữ liệu mẫu (Giả định bạn có cấu trúc dữ liệu như thế này)
const brandData = {
    "Guitar Classic": [
        "Ba đờn",
        "Yamaha"
    ],
    "Guitar Acoustic": [
        "Enya",
        "Yamaha",
        "Everest",
        "Taylor"
    ]
    // Thêm các loại khác nếu cần
};

const brandsUlList = document.getElementById("brandsUlList"); // Dùng ID mới của UL
const categorySelect = modal.querySelector('.category-list');

function showBrandList(nameCategory) {
    document.getElementById("modalCategory").innerText = nameCategory;
    // 2. Lấy danh sách thương hiệu dựa trên tên loại sản phẩm
    const brands = brandData[nameCategory];
    // 3. Xóa nội dung cũ trong UL
    brandsUlList.innerHTML = '';
    


    if (brands && brands.length > 0) {
        // 5. Thêm các thương hiệu mới vào UL
        brands.forEach(brand => {
            const li = document.createElement('li');
            li.textContent = brand;
            brandsUlList.appendChild(li);
        });
    } else {
        // Nếu không có dữ liệu
        const li = document.createElement('li');
        li.textContent = `Chưa có thương hiệu nào cho loại ${nameCategory}.`;
        brandsUlList.appendChild(li);
    }
    modal.style.display = "block";
}


const manageButtons = document.querySelectorAll('.manage-brands-btn');
// 3. Lặp qua từng nút và gắn sự kiện 'click'
manageButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn hành động mặc định (nếu là thẻ <a>)
        const row = button.closest('tr');
        const categoryTd = row.querySelector('.manage-name-category');
        const categoryName = categoryTd.textContent.trim();
        var name = categoryName;
        showBrandList(name);
    });
});

