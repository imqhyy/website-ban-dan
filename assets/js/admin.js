

                                    /*DÀNH CHO QUẢN LÝ KHÁCH HÀNG*/
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
        "Saga",
        "Taylor",
        "Enya",
        "Yamaha"
    ]
    // Thêm các loại khác nếu cần
};

const brandsUlList = document.getElementById("brandsUlList"); // Dùng ID mới của UL

function showBrandList(nameCategory) {
    
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
        document.getElementById("modalCategory").innerText = name;
        showBrandList(name);
        modal.style.display = "block";
    });
});

const editButtons = document.querySelectorAll('.edit-btn');
if(editButtons) {
    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            // Lấy modal chỉnh sửa bằng ID
            const editModal = document.getElementById('edit-info-category');
            const closebuttonforeditinfocategory = document.querySelector('.close-button-for-edit-info-category');
            closebuttonforeditinfocategory.onclick = function() {
                editModal.style.display = "none";
            }

            // Khi bấm vào bất kỳ đâu ngoài Modal
            window.onclick = function(event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
            }
            // Khi bấm lưu đóng editModal
            document.querySelector('.close-button-for-edit-category-container').onclick = function() {
                editModal.style.display = "none";
            }
            // Lấy thông tin từ hàng hiện tại để điền vào modal (Nâng cao: Tùy chọn)
            const row = button.closest('tr');
            if (row) {
                // Lấy ra các ô dữ liệu (<td>) trong hàng
                const cells = row.querySelectorAll('td');
                
                // Cấu trúc cột dựa trên HTML của bạn:
                // 0: ID
                // 1: Tên Loại (class: .manage-name-category)
                // 2: % Lợi nhuận
                // 3: Mô tả
                // 4: Chức năng

                // 1. LẤY DỮ LIỆU TỪ HÀNG
                const categoryName = cells[1].textContent.trim(); // Cột Tên Loại
                const profitPercentage = cells[2].textContent.trim().replace('%', ''); // Cột Lợi nhuận (Loại bỏ ký tự '%')
                const description = cells[3].textContent.trim(); // Cột Mô tả

                // 2. ĐIỀN DỮ LIỆU VÀO CÁC INPUT TRONG MODAL
                
                // a) Tên Loại (Input đầu tiên trong <h3>)
                const nameInput = document.getElementById('input-edit-namecategory');
                if (nameInput) {
                    nameInput.value = categoryName;
                }

                // b) % Lợi nhuận (Input thứ hai trong <h3>)
                const profitInput = document.getElementById('input-edit-profitcategory');
                if (profitInput) {
                    profitInput.value = profitPercentage;
                }
                
                // c) Mô tả (Textarea)
                const descriptionTextarea = document.getElementById('mo_ta');
                if (descriptionTextarea) {
                    descriptionTextarea.value = description;
                }
            }
            editModal.style.display = "block";
        });
    });
}




                                    /*DÀNH CHO QUẢN LÝ NHẬP SẢN PHẨM */

// Dữ liệu mẫu tên sản phẩm (Bạn cần phải tùy chỉnh dữ liệu này)
const productNamesData = {
    "Guitar Classic": {
        "Ba đờn": ["Ba Đờn N100", "Ba Đờn N250", "Ba Đờn C100"],
        "Yamaha": ["Yamaha C40", "Yamaha C70", "Yamaha CX40"]
    },
    "Guitar Acoustic": {
        "Saga": ["Saga CL65", "Saga SF700C", "Saga GS-02"],
        "Taylor": ["Taylor A12E", "Taylor GS Mini", "Taylor 114CE"],
        "Enya": ["Enya EGA X0 PRO SP1", "Enya ED-X0", "Enya Nova Go"],
        "Yamaha": ["Yamaha FG800", "Yamaha FS820", "Yamaha LS36 ARE"]
    }
};
// ... (các const khác như brandData)

function updateProductDatalist(productContainer) {
    // 1. Lấy giá trị đang chọn: Loại sản phẩm và Thương hiệu
    const typeSelect = productContainer.querySelector('.manage-product-type');
    const brandSelect = productContainer.querySelector('.manage-product-brands');
    const productNameInput = productContainer.querySelector('.product-name-input');
    
    if (!typeSelect || !brandSelect || !productNameInput) return;

    const selectedType = typeSelect.value;
    const selectedBrand = brandSelect.value;
    
    // 2. Lấy datalist tương ứng với input tên sản phẩm
    //    (Lưu ý: datalist có thể có ID tĩnh, nhưng nên tạo/quản lý riêng cho từng sản phẩm)
    //    Để đơn giản, ta sẽ chỉ tìm datalist ngay sau input Tên sản phẩm
    const datalist = document.getElementById(productNameInput.getAttribute('list'));
    if (!datalist) return;

    // 3. Xóa nội dung cũ
    datalist.innerHTML = '';
    
    // 4. Lấy danh sách tên sản phẩm từ dữ liệu mẫu
    const productList = productNamesData[selectedType]?.[selectedBrand] || [];

    // 5. Thêm các tùy chọn mới vào datalist
    productList.forEach(productName => {
        const option = document.createElement('option');
        option.value = productName;
        datalist.appendChild(option);
    });
}


function updateBrandsForProduct(typeSelect) { // khi chọn loại acoustic hay classic thì các brand cũng thay đổi
    // 1. Lấy giá trị loại sản phẩm đang được chọn
    const selectedType = typeSelect.value;
            
    // 2. Lấy thẻ select Thương hiệu tương ứng (là phần tử cùng cấp trong div cha)
    //    Chúng ta tìm kiếm thẻ select có class 'manage-product-brands' bên trong thẻ DIV cha của typeSelect.
    const productContainer = typeSelect.closest('.product-fields-template'); 
    if (!productContainer) return; // Bảo vệ nếu không tìm thấy container

    const brandSelect = productContainer.querySelector('.manage-product-brands');
    if (!brandSelect) return; // Bảo vệ nếu không tìm thấy select Thương hiệu

    // 3. Lấy danh sách thương hiệu tương ứng
    const brands = brandData[selectedType] || []; // Thêm || [] để tránh lỗi nếu không tìm thấy loại

    // 4. Xóa tất cả các tùy chọn cũ trong select Thương hiệu
    brandSelect.innerHTML = '';

    // 5. Lặp qua danh sách thương hiệu và thêm vào thẻ select
    brands.forEach(brand => {
        const option = document.createElement('option');
        option.value = brand;
        option.textContent = brand;
        brandSelect.appendChild(option);
    });

    // THAY ĐỔI MỚI: Gọi hàm cập nhật datalist sau khi Brand được cập nhật
    updateProductDatalist(productContainer);
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Gán sự kiện 'change' cho tất cả các select Loại sản phẩm hiện có
    //    (Áp dụng cho sản phẩm mặc định ban đầu)
    document.querySelectorAll('.manage-product-type').forEach(selectElement => { //khi thay đổi lựa chọn phân loại sẽ kích hoạt hàm thay đổi brand
        selectElement.addEventListener('change', function() {
            updateBrandsForProduct(this); // 'this' là select Loại sản phẩm vừa thay đổi
        });
        // Gọi hàm để thiết lập Thương hiệu ban đầu cho sản phẩm mặc định
        updateBrandsForProduct(selectElement); 
    });

    // THAY ĐỔI MỚI: Gán sự kiện 'change' cho tất cả các select Thương hiệu hiện có
    document.querySelectorAll('.manage-product-brands').forEach(selectElement => {
        selectElement.addEventListener('change', function() {
            // Lấy div cha (.product-fields-template)
            const productContainer = this.closest('.product-fields-template');
            updateProductDatalist(productContainer);
        });
    });
// ...

    
    document.querySelectorAll('.create-import-btn').forEach(button => { //hiện popup khi click vào nút thêm phiếu nhập
        button.addEventListener('click', function(event) {
            event.preventDefault(); 
            // KHÔNG cần thiết lập lại sự kiện 'change' ở đây nữa
            modal.style.display = "block";
        });
    });

    const initialProductTemplate = document.getElementsByClassName('product-fields-template')[0];
    const initialRemoveBtn = initialProductTemplate.querySelector('.remove-product-btn');
    if (initialRemoveBtn) {
        // Ẩn nút xóa trên sản phẩm đầu tiên để đảm bảo luôn có ít nhất 1 sản phẩm
        initialRemoveBtn.style.display = 'none'; 
    }


    // 3. Xử lý nút THÊM SẢN PHẨM (Đảm bảo code này vẫn chạy sau khi bạn sửa HTML/JS thêm sản phẩm)
    const addProductButton = document.getElementById('add-product-fields-template'); // ID của nút "Thêm sản phẩm"
    const importFormContainer = document.getElementById('import-form-container');
    const productTemplate = document.getElementsByClassName('product-fields-template')[0];
    const actionButtonConatainer = document.getElementById('manage-add-and-save-container');
    if (addProductButton && actionButtonConatainer) {
        addProductButton.addEventListener('click', function() {
            const newProductFields = productTemplate.cloneNode(true);
            
            // ... (Phần xóa giá trị và thêm HR như code trước) ...
            
            // Xóa giá trị input và reset select
            newProductFields.querySelectorAll('input, select').forEach(element => {
                if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0;
                } else {
                    element.value = '';
                }
            });

            // 1. HIỆN NÚT XÓA TRÊN BẢN SAO
            const newRemoveBtn = newProductFields.querySelector('.remove-product-btn');
            if (newRemoveBtn) {
                newRemoveBtn.style.display = 'block'; // Đảm bảo nút này hiển thị
                
                // 2. GÁN SỰ KIỆN XÓA CHO NÚT MỚI
                newRemoveBtn.addEventListener('click', function() {
                    // Xóa phần tử cha của nút (chính là .product-fields-template)
                    newProductFields.remove(); 
                });
            }
            
            
            // CHỖ QUAN TRỌNG: Gán sự kiện 'change' cho select Loại sản phẩm MỚI
            const newTypeSelect = newProductFields.querySelector('.manage-product-type');
            newTypeSelect.addEventListener('change', function() {
                updateBrandsForProduct(this);
            });

            // THAY ĐỔI MỚI: Gán sự kiện 'change' cho select Thương hiệu MỚI
            const newBrandSelect = newProductFields.querySelector('.manage-product-brands');
            newBrandSelect.addEventListener('change', function() {
                const productContainer = this.closest('.product-fields-template');
                updateProductDatalist(productContainer);
            });

            // Gọi hàm cập nhật Thương hiệu cho sản phẩm mới (dựa trên giá trị mặc định)
            updateBrandsForProduct(newTypeSelect);

            importFormContainer.insertBefore(newProductFields, actionButtonConatainer);
        });
    }
});

const button_saveimportproduct = document.getElementById('save-import-product');
if(button_saveimportproduct) {
    button_saveimportproduct.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn hành động mặc định (nếu có)
        
        // 1. Đóng Modal
        modal.style.display = "none";
        
        // 2. Hiện thông báo (Sử dụng SweetAlert2 nếu đã được tích hợp, nếu không dùng alert() mặc định)
        // Cách 1: Dùng alert() mặc định của trình duyệt
        // alert("Phiếu nhập đã được lưu thành công!");
        
        // Cách 2: Dùng SweetAlert2 (Đã thấy thư viện được load trong HTML)
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: 'Phiếu nhập đã được lưu thành công.',
            confirmButtonText: 'Đóng'
        });
        
        // NOTE: Thêm code xử lý lưu dữ liệu (gọi API, lưu LocalStorage,...) tại đây
    });
}




