
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1200,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
/*DÀNH CHO QUẢN LÝ KHÁCH HÀNG*/
// Lấy các phần tử
var modal = document.getElementById("DetailModal");
var closeButton = document.querySelector(".close-button");

if(modal) {
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
    // Đóng Modal
    // --------------------
    // Khi bấm vào nút Đóng (X)
    if(closeButton) {
        closeButton.onclick = function () {
            modal.style.display = "none";
        }
    }


    // Khi bấm vào bất kỳ đâu ngoài Modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}


// --------------------
// Bấm vào nút "Chi tiết"
// --------------------
// Bạn cần lắng nghe sự kiện bấm vào nút 'Chi tiết'
// Giả sử nút 'Chi tiết' có class là 'detail-btn'
document.querySelectorAll('.detail-btn').forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn hành động chuyển trang mặc định của thẻ <a>

        // **Lưu ý quan trọng:** Bạn phải lấy dữ liệu (Nguyễn Văn A, SĐT) từ HTML/Database
        // Trong ví dụ này, ta giả định dữ liệu có sẵn:
        var customerName = 'Châu Tinh Trì';
        var customerPhone = '0987654321';
        var customerImage = 'assets/img/person/chautinhtri.jpg';
        showCustomerDetails(customerName, customerPhone, customerImage);
    });
});



                            /*DÀNH CHO TRANG QUẢN LÝ PHÂN LOẠI*/


const manageButtons = document.querySelectorAll('.manage-brands-btn');
if(manageButtons) {
    const editModal = document.getElementById('edit-brands-modal');
    // 3. Lặp qua từng nút và gắn sự kiện 'click'
    manageButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn hành động mặc định (nếu là thẻ <a>)
            editModal.style.display = "block";
            const closebuttonforeditinfocategory = document.querySelector('.close-button-for-edit-brands');
            closebuttonforeditinfocategory.onclick = function () {
                editModal.style.display = "none";
            }
            // Khi bấm vào bất kỳ đâu ngoài Modal
            window.onclick = function (event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
            }
        });
    });
    /*Hiệu ứng thông báo và đóng modal của nút lưu thay đổi*/
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Khai báo Toast (Dùng lại cấu hình giống các phần trên của bạn)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // 2. Lấy các phần tử cần thiết
        const saveBtn = document.getElementById('save-brands-list-btn');
        const brandModal = document.getElementById('edit-brands-modal');

        if (saveBtn) {
            saveBtn.addEventListener('click', function () {
                // Tại đây bạn có thể thêm logic xử lý dữ liệu từ các ô input (.brand-edit-input)
                
                // 3. Hiển thị thông báo thành công
                Toast.fire({
                    icon: 'success',
                    html: '<strong>Đã lưu thay đổi thương hiệu thành công!</strong>'
                });

                // 4. Đóng Modal
                if (brandModal) {
                    brandModal.style.display = 'none';
                }
            });
        }
    });
}


const editButtons = document.querySelectorAll('.edit-category-btn');
if (editButtons) {
    editButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            // Lấy modal chỉnh sửa bằng ID
            const editModal = document.getElementById('edit-info-category');
            const closebuttonforeditinfocategory = document.querySelector('.close-button-for-edit-info-category');
            closebuttonforeditinfocategory.onclick = function () {
                editModal.style.display = "none";
            }

            // Khi bấm vào bất kỳ đâu ngoài Modal
            window.onclick = function (event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
            }
            // Khi bấm lưu đóng editModal
            document.querySelector('.close-button-for-edit-category-container').onclick = function () {
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

    document.addEventListener('DOMContentLoaded', function () {
        const saveButton = document.querySelector('.close-button-for-edit-category-container');
        if (saveButton) {
            saveButton.addEventListener('click', function () {
                // Tìm container cha (có thể chỉnh sửa, thêm class nếu cần)
                const editContainer = saveButton.closest('.edit-category-wrapper')
                || saveButton.closest('.modal')
                || saveButton.closest('div');
            
                if (editContainer) {
                    editContainer.style.display = 'none'; // ← Ẩn, không xóa
                }
            
                // HIỆN TOAST
                Toast.fire({
                icon: 'success',
                html: '<strong>Đã lưu thay đổi</strong>'
                });
            });
        }
    });
}






                            /*DÀNH CHO QUẢN LÝ NHẬP SẢN PHẨM */


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

//Hàm xử lý tiền tệ khi nhập đơn giá (KHÔNG ĐỔI)
function formatCurrency(value) {
    // 1. Loại bỏ tất cả ký tự không phải số (trừ dấu chấm để tránh bị lỗi khi nhập liệu)
    const rawNumber = value.toString().replace(/[^0-9]/g, '');

    // Nếu số lượng chữ số dưới 4, không định dạng dấu chấm
    if (rawNumber.length < 4) {
        return rawNumber;
    }

    // 2. Định dạng số với dấu chấm là dấu phân cách hàng nghìn (ví dụ: 12.345.678)
    // RegExp: Tìm tất cả vị trí có 3 chữ số đứng sau, không phải ở đầu chuỗi và không có thêm chữ số nào sau nó.
    const formatted = rawNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // 3. Thêm đơn vị VND
    return formatted + " VND";
}

// HÀM MỚI: Gán sự kiện định dạng tiền tệ (Sử dụng BLUR và ENTER)
function attachPriceFormatter(inputElement) {
    if (!inputElement) return;

    // --- Định nghĩa hàm xử lý định dạng chung ---
    const handleFormatting = function () {
        // Lấy giá trị hiện tại, loại bỏ tất cả ký tự không phải số
        const currentValue = this.value.replace(/[^0-9]/g, '');

        // Chỉ định dạng nếu có giá trị
        if (currentValue) {
            // Gán lại giá trị đã được định dạng (có dấu chấm và VND)
            this.value = formatCurrency(currentValue);
        } else {
            // Nếu người dùng xóa sạch, giữ lại ô trống
            this.value = '';
        }
    };

    // --- Định nghĩa hàm xử lý khi nhấn phím ---
    const handleKeydown = function (event) {
        // Kiểm tra xem phím Enter (key code 13) có được nhấn không
        if (event.key === 'Enter') {
            event.preventDefault(); // Ngăn trình duyệt gửi form hoặc hành động mặc định
            handleFormatting.call(this); // Gọi hàm định dạng
            this.blur(); // Tự động di chuyển khỏi ô nhập
        }
    };

    // 1. Gán sự kiện BLUR (Click ra ngoài)
    inputElement.addEventListener('blur', handleFormatting);

    // 2. Gán sự kiện KEYDOWN (Nhấn Enter)
    inputElement.addEventListener('keydown', handleKeydown);

    // QUAN TRỌNG: Gán sự kiện FOCUS để dọn dẹp định dạng khi BẮT ĐẦU nhập lại
    inputElement.addEventListener('focus', function () {
        // Khi người dùng click vào ô, loại bỏ ' VND' và dấu chấm để họ nhập số thuần
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}

// HÀM MỚI: Đặt lại toàn bộ form phiếu nhập về trạng thái ban đầu
function resetImportForm() {
    const importFormContainer = document.getElementById('import-form-container');
    if (!importFormContainer) return;

    // 1. Reset các trường Header (Ngày nhập, Mã phiếu)
    const headerInputs = importFormContainer.querySelectorAll('.header-fields-row-manage-import input');
    headerInputs.forEach(input => {
        input.value = '';
    });

    // 2. Chỉ giữ lại 1 sản phẩm duy nhất và reset nó
    const allProductFields = importFormContainer.querySelectorAll('.product-fields-template');

    // Giữ lại phần tử đầu tiên (sản phẩm mặc định)
    const initialProductFields = allProductFields[0];

    // Xóa tất cả các phần tử sản phẩm thừa (từ phần tử thứ 2 trở đi)
    for (let i = 1; i < allProductFields.length; i++) {
        allProductFields[i].remove();
    }

    // 3. Reset các trường của sản phẩm còn lại (sản phẩm đầu tiên)
    initialProductFields.querySelectorAll('input, select').forEach(element => {
        if (element.tagName === 'SELECT') {
            element.selectedIndex = 0; // Đặt lại về option đầu tiên
        } else {
            element.value = ''; // Xóa giá trị input
        }
    });

    // 4. Cập nhật lại danh sách Thương hiệu (và Datalist) cho sản phẩm đầu tiên
    const typeSelect = initialProductFields.querySelector('.manage-product-type');
    if (typeSelect) {
        updateBrandsForProduct(typeSelect);
    }
}


document.addEventListener('DOMContentLoaded', function () {
    // 1. Gán sự kiện 'change' cho tất cả các select Loại sản phẩm hiện có
    //    (Áp dụng cho sản phẩm mặc định ban đầu)
    document.querySelectorAll('.manage-product-type').forEach(selectElement => { //khi thay đổi lựa chọn phân loại sẽ kích hoạt hàm thay đổi brand
        selectElement.addEventListener('change', function () {
            updateBrandsForProduct(this); // 'this' là select Loại sản phẩm vừa thay đổi
        });
        // Gọi hàm để thiết lập Thương hiệu ban đầu cho sản phẩm mặc định
        updateBrandsForProduct(selectElement);
    });

    // THAY ĐỔI MỚI: Gán sự kiện 'change' cho tất cả các select Thương hiệu hiện có
    document.querySelectorAll('.manage-product-brands').forEach(selectElement => {
        selectElement.addEventListener('change', function () {
            // Lấy div cha (.product-fields-template)
            const productContainer = this.closest('.product-fields-template');
            updateProductDatalist(productContainer);
        });
    });

    // === GÁN SỰ KIỆN FORMAT CHO CÁC Ô ĐƠN GIÁ BAN ĐẦU ===
    document.querySelectorAll('.unit-price-input').forEach(input => {
        attachPriceFormatter(input);
    });
    // ===================================================


    document.querySelectorAll('.create-import-btn').forEach(button => { //hiện popup khi click vào nút thêm phiếu nhập
        button.addEventListener('click', function (event) {
            event.preventDefault();
            // <<< THÊM: Reset form trước khi mở modal >>>
            resetImportForm();
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
        addProductButton.addEventListener('click', function () {
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
                newRemoveBtn.addEventListener('click', function () {
                    // Xóa phần tử cha của nút (chính là .product-fields-template)
                    newProductFields.remove();
                });
            }


            // CHỖ QUAN TRỌNG: Gán sự kiện 'change' cho select Loại sản phẩm MỚI
            const newTypeSelect = newProductFields.querySelector('.manage-product-type');
            newTypeSelect.addEventListener('change', function () {
                updateBrandsForProduct(this);
            });

            // Gán sự kiện 'change' cho select Thương hiệu MỚI
            const newBrandSelect = newProductFields.querySelector('.manage-product-brands');
            newBrandSelect.addEventListener('change', function () {
                const productContainer = this.closest('.product-fields-template');
                updateProductDatalist(productContainer);
            });

            // THAY ĐỔI MỚI: Gán sự kiện format cho ô Đơn giá MỚI
            const newPriceInput = newProductFields.querySelector('.unit-price-input');
            attachPriceFormatter(newPriceInput);


            // Gọi hàm cập nhật Thương hiệu cho sản phẩm mới (dựa trên giá trị mặc định)
            updateBrandsForProduct(newTypeSelect);

            importFormContainer.insertBefore(newProductFields, actionButtonConatainer);
        });
    }

    const button_saveimportproduct = document.getElementById('save-import-product');
    if (button_saveimportproduct) {
        button_saveimportproduct.addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn submit form nếu có

            // 1. Đóng Modal
            modal.style.display = "none";

            // 2. Reset form
            resetImportForm();

            // 3. Hiện Toast thành công
            Toast.fire({
                icon: 'success',
                title: 'Phiếu nhập đã được lưu thành công!'
            });

            // TODO: Gọi API lưu dữ liệu ở đây
            // saveImportData();
        });
    }

});


                                    /**Quản lý danh mục sản phẩm */
const openAddBtn = document.getElementById('open-add-product');
if(openAddBtn) {
    document.addEventListener('DOMContentLoaded', function () {
        const addProductModal = document.getElementById('addProductModal');
        const closeBtn = addProductModal.querySelector('.close-button');
        const cancelBtn = document.getElementById('cancel-add-product');
        const imageUpload = document.getElementById('product-images-upload');
        const previewContainer = document.getElementById('image-preview-container');

        // 1. Mở/Đóng Modal
        openAddBtn.addEventListener('click', () => {
            addProductModal.style.display = 'block';
        });

        [closeBtn, cancelBtn].forEach(btn => {
            btn.onclick = () => addProductModal.style.display = 'none';
        });

        // 2. Xử lý xem trước ảnh (Tối đa 6 ảnh)

        // Khởi tạo "vùng đệm" DataTransfer
        let dataStorage = new DataTransfer(); 

        if (imageUpload) {
            imageUpload.addEventListener('change', function() {
                const files = Array.from(this.files);
                
                // Kiểm tra giới hạn 6 ảnh
                if (dataStorage.files.length + files.length > 6) {
                    Swal.fire('Thông báo', 'Tổng số lượng ảnh không được quá 6!', 'warning');
                    // Cập nhật lại input bằng những gì đang có trong dataStorage (để xóa tệp vừa chọn sai)
                    this.files = dataStorage.files; 
                    return;
                }

                files.forEach(file => {
                    // Thêm file mới vào vùng đệm
                    dataStorage.items.add(file); 
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                            <img src="${e.target.result}">
                            <button type="button" class="remove-img-btn">&times;</button>
                        `;

                        // Xử lý khi bấm nút xóa
                        div.querySelector('.remove-img-btn').onclick = () => {
                            // Xóa file khỏi vùng đệm DataTransfer
                            const newDataStorage = new DataTransfer();
                            for (let i = 0; i < dataStorage.files.length; i++) {
                                if (dataStorage.files[i] !== file) {
                                    newDataStorage.items.add(dataStorage.files[i]);
                                }
                            }
                            dataStorage = newDataStorage;
                            
                            // CẬP NHẬT NGƯỢC LẠI INPUT FILE
                            imageUpload.files = dataStorage.files; 
                            div.remove();
                        };

                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });

                // QUAN TRỌNG: Cập nhật input file để nó đồng bộ với vùng đệm
                this.files = dataStorage.files; 
            });
}

        // 3. Xử lý Logic Thương hiệu dựa trên Phân loại (Sử dụng dữ liệu brandData có sẵn của bạn)
        const typeSelect = document.getElementById('modal-product-type');
        const brandSelect = document.getElementById('modal-product-brand');

        function updateModalBrands() {
            const brands = brandData[typeSelect.value] || [];
            brandSelect.innerHTML = brands.map(b => `<option value="${b}">${b}</option>`).join('');
        }

        typeSelect.addEventListener('change', updateModalBrands);
        updateModalBrands(); // Khởi tạo lần đầu

        // 4. Xử lý lưu form
        document.getElementById('add-product-form').onsubmit = function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Sản phẩm mới đã được thêm vào hệ thống!',
                confirmButtonColor: '#28a745'
            }).then(() => {
                addProductModal.style.display = 'none';
                this.reset();
                previewContainer.innerHTML = '';
            });
        };
    });
}

// Bộ lọc cho bảng Danh sách sản phẩm hiện có
const sortProductCategory = document.getElementById('sort-product-category');
const sortProductBrand = document.getElementById('sort-product-brand');

if (sortProductCategory && sortProductBrand) {
    // 1. Cập nhật danh sách Thương hiệu khi chọn Loại sản phẩm
    sortProductCategory.addEventListener('change', function () {
        const selectedType = this.value; // Ví dụ: "Acoustic" hoặc "Classic"
        
        // Map lại giá trị value vì brandData của bạn dùng key đầy đủ
        const typeKey = selectedType === "Acoustic" ? "Guitar Acoustic" : 
                        selectedType === "Classic" ? "Guitar Classic" : "";

        const brands = brandData[typeKey] || [];

        // Xóa cũ thêm mới
        sortProductBrand.innerHTML = '<option value="">-- Chọn thương hiệu --</option>';
        brands.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand;
            option.textContent = brand;
            sortProductBrand.appendChild(option);
        });
    });

    // 2. Logic lọc bảng (Ví dụ đơn giản lọc theo text trong các cột)
    const filterTable = () => {
        const categoryValue = sortProductCategory.value.toLowerCase();
        const brandValue = sortProductBrand.value.toLowerCase();
        const rows = document.querySelectorAll('#product-list-container tr');

        rows.forEach(row => {
            const rowCategory = row.cells[2].textContent.toLowerCase();
            const rowName = row.cells[1].textContent.toLowerCase();
            
            const matchCategory = !categoryValue || rowCategory.includes(categoryValue);
            const matchBrand = !brandValue || rowName.toLowerCase().includes(brandValue);

            row.style.display = (matchCategory && matchBrand) ? "" : "none";
        });
    };

    sortProductCategory.addEventListener('change', filterTable);
    sortProductBrand.addEventListener('change', filterTable);
}

/* --- QUẢN LÝ DANH MỤC SẢN PHẨM: XỬ LÝ NÚT SỬA --- */
document.addEventListener('DOMContentLoaded', function () {
    const editProductModal = document.getElementById('editProductModal');
    const editProductForm = document.getElementById('edit-product-form');
    
    // Lắng nghe sự kiện click cho các nút có class .edit-product-btn
    document.querySelectorAll('.edit-product-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            // 1. Tìm hàng (row) chứa nút vừa bấm
            const row = this.closest('tr');
            if (!row) return;

            // 2. Trích xuất dữ liệu từ các cột trong hàng
            // Cột 1: Hình ảnh, Cột 2: Tên, Cột 3: Loại, Cột 4: Giá vốn...
            const productName = row.cells[1].textContent.trim();
            const productType = row.cells[2].textContent.trim();
            const costPrice = row.cells[3].textContent.trim();
            const profit = row.cells[4].textContent.trim();

            // 3. Điền dữ liệu vào các ô Input trong Modal Sửa
            document.getElementById('edit-product-name').value = productName;
            
            // Chuẩn hóa loại sản phẩm để khớp với value của <select>
            const typeValue = productType.includes("Acoustic") ? "Guitar Acoustic" : "Guitar Classic";
            const typeSelect = document.getElementById('edit-product-type');
            typeSelect.value = typeValue;

            // Cập nhật danh sách Thương hiệu tương ứng với Loại vừa chọn
            updateEditModalBrands(typeValue);
            
            // Điền một số dữ liệu mặc định/giả định cho các trường chi tiết
            document.getElementById('edit-product-summary').value = `Mô tả tóm tắt cho ${productName}`;
            document.getElementById('edit-product-overview').value = `Thông tin chi tiết về cấu tạo và chất liệu của dòng ${productName}...`;
            document.getElementById('edit-product-accessories').value = "Bao đàn chính hãng\nLục giác chỉnh cần\nBộ dây dự phòng";

            // 4. Hiển thị Modal
            if (editProductModal) {
                editProductModal.style.display = 'block';
            }
        });
    });

    // Hàm cập nhật Thương hiệu trong Modal Sửa dựa trên brandData có sẵn
    function updateEditModalBrands(selectedType) {
        const brandSelect = document.getElementById('edit-product-brand');
        if (!brandSelect) return;

        const brands = brandData[selectedType] || [];
        brandSelect.innerHTML = brands.map(b => `<option value="${b}">${b}</option>`).join('');
    }

    // Tự động cập nhật Thương hiệu khi người dùng thay đổi Loại trong Modal Sửa
    const modalTypeSelect = document.getElementById('edit-product-type');
    if (modalTypeSelect) {
        modalTypeSelect.addEventListener('change', function() {
            updateEditModalBrands(this.value);
        });
    }

    // Xử lý đóng Modal Sửa
    const closeEditBtn = document.getElementById('close-edit-modal');
    const cancelEditBtn = document.getElementById('cancel-edit-product');
    
    [closeEditBtn, cancelEditBtn].forEach(btn => {
        if (btn) {
            btn.onclick = () => { editProductModal.style.display = 'none'; };
        }
    });

    // Xử lý khi bấm Lưu thay đổi
    if (editProductForm) {
        editProductForm.onsubmit = function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Dữ liệu sản phẩm đã được cập nhật!',
                confirmButtonColor: '#28a745'
            }).then(() => {
                editProductModal.style.display = 'none';
            });
        };
    }
});