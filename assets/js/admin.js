/*DÀNH CHO QUẢN LÝ KHÁCH HÀNG*/
// Lấy các phần tử
var modal = document.getElementById("DetailModal");
var closeButton = document.querySelector(".close-button");

if (modal) {
  // Hàm hiển thị Modal và điền dữ liệu (Cần được gọi khi bấm nút)
  function showCustomerDetails(name, phone, img) {
    // 1. Điền dữ liệu vào Modal
    document.getElementById("modalName").innerText = name;
    document.getElementById("modalPhone").innerText = phone;
    document.getElementById("modalImage").src = img;
    // ... Điền các dữ liệu khác tại đây

    // 2. Hiển thị Modal
    modal.style.display = "block";
  }
  // --------------------
  // Đóng Modal
  // --------------------
  // Khi bấm vào nút Đóng (X)
  if (closeButton) {
    closeButton.onclick = function () {
      modal.style.display = "none";
    };
  }

  // Khi bấm vào bất kỳ đâu ngoài Modal
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
}

// --------------------
// Bấm vào nút "Chi tiết"
// --------------------
// Bạn cần lắng nghe sự kiện bấm vào nút 'Chi tiết'
// Giả sử nút 'Chi tiết' có class là 'detail-btn'
document.querySelectorAll(".detail-btn").forEach((button) => {
  button.addEventListener("click", function (event) {
    event.preventDefault(); // Ngăn hành động chuyển trang mặc định của thẻ <a>

    // **Lưu ý quan trọng:** Bạn phải lấy dữ liệu (Nguyễn Văn A, SĐT) từ HTML/Database
    // Trong ví dụ này, ta giả định dữ liệu có sẵn:
    var customerName = "Châu Tinh Trì";
    var customerPhone = "0987654321";
    var customerImage = "assets/img/person/chautinhtri.jpg";
    showCustomerDetails(customerName, customerPhone, customerImage);
  });
});

/*DÀNH CHO TRANG QUẢN LÝ PHÂN LOẠI*/

/* --- QUẢN LÝ PHÂN LOẠI BẰNG AJAX --- */

function initializeCategoryEvents() {
  // --- 1. Sự kiện cho nút SỬA ---
  document.querySelectorAll(".edit-category-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const editModal = document.getElementById("edit-info-category");
      document.getElementById("input-edit-id-category").value =
        this.getAttribute("data-id");
      document.getElementById("input-edit-namecategory").value =
        this.getAttribute("data-name");
      document.getElementById("input-edit-profitcategory").value =
        this.getAttribute("data-profit");
      const rawDesc = this.getAttribute("data-desc");
      document.getElementById("mo_ta").value =
        rawDesc === "Chưa có mô tả" ? "" : rawDesc;
      editModal.style.display = "block";
    });
  });

  // --- 2. Sự kiện cho nút QUẢN LÝ THƯƠNG HIỆU (Huy đưa đoạn này vào đây) ---
  document.querySelectorAll(".manage-brands-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const catId = this.getAttribute("data-id");
      const row = this.closest("tr");
      const catName =
        row.querySelector(".manage-name-category")?.textContent || "Phân loại";

      document.getElementById("current-category-id").value = catId;
      document.getElementById("brand-modal-title").innerHTML =
        `Danh sách thương hiệu: <strong>${catName}</strong>`;

      fetchBrands(catId); // Tải danh sách brand qua AJAX
    });
  });

  // --- 3. Sự kiện cho nút XÓA ---
  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const row = this.closest("tr");
      const categoryName = row
        .querySelector(".manage-name-category")
        .textContent.trim();
      const categoryId = this.getAttribute("data-id");

      Swal.fire({
        title: "Xác nhận xóa?",
        html: `Loại: <strong>${categoryName}</strong> sẽ bị xóa vĩnh viễn.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Xóa",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(
            `forms/quanlyloaisanpham/ajax_handle_categories.php?action=delete&id=${categoryId}`,
          )
            .then((res) => res.text())
            .then((data) => {
              if (data.trim() === "success") {
                fetchCategories(); // Tải lại bảng và gán lại sự kiện
                if (Swal.isVisible()) {
                  // 2. PHẢI DỪNG TIMER TRƯỚC (Khi nó vẫn còn đang Visible)
                  if (Swal.getTimerLeft() > 0) {
                    Swal.stopTimer();
                  }
                  // 3. SAU ĐÓ MỚI ĐÓNG
                  Swal.close();
                }
                Toast.fire({ icon: "success", title: "Đã xóa thành công!" });
              } else if (data.trim() === "error_constraint") {
                Swal.fire(
                  "Lỗi",
                  "Không thể xóa loại đang có sản phẩm!",
                  "error",
                );
              }
            });
        }
      });
    });
  });

  // --- 4. Sự kiện nút ẨN/HIỆN (Nếu cần dùng AJAX sau này) ---
}

// --- 3. Sự kiện SUBMIT FORM SỬA (AJAX) ---
// Thêm đoạn này vào bên trong document.addEventListener('DOMContentLoaded', ...)
const editCatForm = document.querySelector("#edit-info-category form");
if (editCatForm) {
  editCatForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Chặn load lại trang

    let formData = new FormData(this);
    formData.append("action", "update");

    fetch("forms/quanlyloaisanpham/ajax_handle_categories.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => {
        if (data.trim() === "success") {
          document.getElementById("edit-info-category").style.display = "none"; // Đóng modal
          fetchCategories(); // Cập nhật lại bảng

          Toast.fire({ icon: "success", title: "Cập nhật thành công!" });
        } else {
          Swal.fire("Lỗi", "Không thể cập nhật dữ liệu", "error");
        }
      });
  });
}

// Gọi lần đầu khi trang vừa load
document.addEventListener("DOMContentLoaded", initializeCategoryEvents);
// 1. Hàm tải lại danh sách phân loại (Cập nhật UI)
function fetchCategories() {
  fetch("forms/quanlyloaisanpham/ajax_handle_categories.php?action=fetch_list")
    .then((res) => res.text())
    .then((data) => {
      const container = document.getElementById("categoryList");
      if (container) {
        container.innerHTML = data;
        // QUAN TRỌNG: Sau khi thay đổi HTML, phải gán lại sự kiện cho các nút Sửa/Xóa mới
        initializeCategoryEvents();
      }
    });
}

// 2. Hàm thêm phân loại mới
function addNewCategoryAjax() {
  const nameInput = document.getElementById("new-cat-name");
  const profitInput = document.getElementById("new-cat-profit");
  const descInput = document.getElementById("new-cat-desc");

  if (!nameInput.value.trim()) {
    Swal.fire("Lỗi", "Vui lòng nhập tên loại sản phẩm", "warning");
    return;
  }

  let formData = new FormData();
  formData.append("action", "add");
  formData.append("category_name", nameInput.value);
  formData.append("profit_margin", profitInput.value);
  formData.append("description", descInput.value);

  fetch("forms/quanlyloaisanpham/ajax_handle_categories.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      if (data.trim() === "success") {
        // Xóa form
        nameInput.value = "";
        profitInput.value = "";
        descInput.value = "";

        // Cập nhật lại bảng
        fetchCategories();

        // Thông báo

        Toast.fire({ icon: "success", title: "Đã thêm phân loại mới!" });
      } else {
        Swal.fire("Lỗi", "Không thể thêm phân loại", "error");
      }
    });
}

/* DÀNH CHO TRANG QUẢN LÝ THƯƠNG HIỆU (AJAX) */
const manageButtons = document.querySelectorAll(".manage-brands-btn");
const brandModal = document.getElementById("edit-brands-modal");
const brandsTbody = document.getElementById("brands-tbody");
const closeBrandsBtn = document.getElementById("btn-close-brands-modal"); // Nút Đóng mới

if (manageButtons && brandModal) {
  manageButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const catId = this.getAttribute("data-id");
      const row = this.closest("tr");
      const catName =
        row.querySelector(".manage-name-category")?.textContent || "Phân loại";

      document.getElementById("current-category-id").value = catId;
      document.getElementById("brand-modal-title").innerHTML =
        `Danh sách thương hiệu: <strong>${catName}</strong>`;

      fetchBrands(catId);
      brandModal.style.display = "block";
      if (brandModal) {
        window.onclick = function (event) {
          if (event.target == brandModal) {
            brandModal.style.display = "none";
          }
        };
      }
    });
  });

  // Sự kiện đóng khi bấm dấu X
  document.querySelector(".close-button-for-edit-brands").onclick = () =>
    (brandModal.style.display = "none");

  // THÊM MỚI: Sự kiện đóng khi bấm nút "Đóng" ở footer
  if (closeBrandsBtn) {
    closeBrandsBtn.onclick = () => {
      brandModal.style.display = "none";
    };
  }
}

function fetchBrands(catId) {
  fetch(
    `forms/quanlyloaisanpham/ajax_handle_brands.php?action=fetch&cat_id=${catId}`,
  )
    .then((response) => response.text())
    .then((data) => {
      brandsTbody.innerHTML = data;
    });
}

// Hàm cập nhật lợi nhuận riêng
function updateBrandProfit(brandId, catId, btnElement) {
  const row = btnElement.closest("tr");
  const profitValue = row.querySelector(".brand-profit-input").value;

  let formData = new FormData();
  formData.append("action", "update_profit");
  formData.append("brand_id", brandId);
  formData.append("cat_id", catId);
  formData.append("profit", profitValue);

  fetch("forms/quanlyloaisanpham/ajax_handle_brands.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      if (data.trim() === "success") {
        Toast.fire({ icon: "success", title: "Đã cập nhật lợi nhuận!" });
      }
    });
}

// Hàm xóa thương hiệu cho quản lý thương hiệu trong phân loại(Đã sửa lỗi đồng bộ giao diện)
function deleteBrand(brandId, catId) {
  Swal.fire({
    title: "Xác nhận xóa?",
    text: "Thương hiệu này sẽ không còn thuộc phân loại hiện tại!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Xóa ngay",
    cancelButtonText: "Hủy",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(
        `forms/quanlyloaisanpham/ajax_handle_brands.php?action=delete&brand_id=${brandId}&cat_id=${catId}`,
      )
        .then((res) => res.text())
        .then((data) => {
          // ĐOẠN CODE CỦA HUY PHẢI NẰM Ở ĐÂY:
          if (data.trim() === "success") {
            fetchBrands(catId); // Cập nhật Modal
            fetchGlobalBrands(); // Cập nhật bảng tổng ở dưới

            Toast.fire({ icon: "success", title: "Đã xóa liên kết!" });
          } else {
            Swal.fire("Lỗi", "Không thể xóa: " + data, "error");
          }
        });
    }
  });
}

// Tìm đến đoạn này trong admin.js và thay thế:
// Thêm thương hiệu mới (Nút thêm trong Modal Phân loại)
const addBrandQuickBtn = document.getElementById("btn-add-brand-quick");
if (addBrandQuickBtn) {
  addBrandQuickBtn.addEventListener("click", function () {
    const catId = document.getElementById("current-category-id").value;
    const brandNameInput = document.getElementById("new-brand-name");
    const brandName = brandNameInput.value.trim();

    if (!brandName) {
      Swal.fire("Thông báo", "Vui lòng nhập tên thương hiệu!", "warning");
      return;
    }

    let formData = new FormData();
    formData.append("brand_name", brandName);
    formData.append("cat_id", catId);
    formData.append("action", "add");

    // Lệnh FETCH phải nằm TRONG này thì mới hiểu formData là gì
    fetch("forms/quanlyloaisanpham/ajax_handle_brands.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => {
        if (data.trim() === "success") {
          brandNameInput.value = "";
          fetchBrands(catId); // Cập nhật danh sách trong Modal
          fetchGlobalBrands(); // Cập nhật bảng tổng ở dưới trang
          Toast.fire({ icon: "success", title: "Đã thêm thương hiệu!" });
        }
      });
  });
}

// chỗ này dành cho table hiện toàn bộ thương hiệu có trong database
/* 1. Hàm tải danh sách thương hiệu tổng */
function fetchGlobalBrands() {
  fetch("forms/quanlyloaisanpham/ajax_handle_brands.php?action=fetch_global")
    .then((res) => res.text())
    .then((data) => {
      const container = document.getElementById("global-brands-tbody");
      if (container) container.innerHTML = data;
    });
}

/* 2. Gọi hàm này ngay khi trang vừa load xong */
document.addEventListener("DOMContentLoaded", function () {
  fetchGlobalBrands();
});

/* 4. Hàm xóa vĩnh viễn thương hiệu (Global) */
function deleteBrandGlobal(id, name) {
  Swal.fire({
    title: "Xóa vĩnh viễn?",
    html: `Hãng <strong>${name}</strong> sẽ mất sạch khỏi hệ thống!`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    confirmButtonText: "Xóa sạch",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(
        `forms/quanlyloaisanpham/ajax_handle_brands.php?action=delete_global&id=${id}`,
      )
        .then((res) => res.text())
        .then((data) => {
          if (data.trim() === "success") {
            fetchGlobalBrands(); // Cập nhật lại bảng tổng
            // Nếu đang mở Modal của phân loại nào đó, ta cũng nên load lại Modal đó
            const currentCatId = document.getElementById(
              "current-category-id",
            ).value;
            if (currentCatId) fetchBrands(currentCatId);
            Toast.fire({ icon: "success", title: "Đã xóa vĩnh viễn!" });
          }
        });
    }
  });
}

/* --- QUẢN LÝ THƯƠNG HIỆU toàn cục trong quản lý phân loại --- */

const editInfoBrandModal = document.getElementById("edit-info-brand");

// Hàm mở Modal và nạp dữ liệu từ Server
function openEditBrandModal(brandId) {
  fetch(
    `forms/quanlyloaisanpham/ajax_handle_brands.php?action=get_brand_detail&id=${brandId}`,
  )
    .then((res) => res.json())
    .then((data) => {
      // Điền dữ liệu vào các input trong modal dựa trên ID Huy đã thiết kế
      document.getElementById("input-edit-id-brand").value = data.id;
      document.getElementById("input-edit-namebrand").value = data.brand_name;
      document.getElementById("mo_ta_brand").value = data.description || "";

      // Hiển thị modal
      editInfoBrandModal.style.display = "block";
    });
}
if (editInfoBrandModal) {
  window.onclick = function (event) {
    if (event.target == editInfoBrandModal) {
      editInfoBrandModal.style.display = "none";
    }
  };
}

// Xử lý đóng Modal
const closeBtnBrand = document.querySelector(
  ".close-button-for-edit-info-brand",
);
if (closeBtnBrand) {
  closeBtnBrand.onclick = function () {
    editInfoBrandModal.style.display = "none";
  };
}

// Hàm Lưu thay đổi bằng AJAX
function saveBrandChanges(event) {
  event.preventDefault();

  const id = document.getElementById("input-edit-id-brand").value;
  const name = document.getElementById("input-edit-namebrand").value;
  const desc = document.getElementById("mo_ta_brand").value;

  let formData = new FormData();
  formData.append("action", "update_brand_info");
  formData.append("id", id);
  formData.append("name", name);
  formData.append("desc", desc);

  fetch("forms/quanlyloaisanpham/ajax_handle_brands.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      console.log("Server response:", data); // Dòng này giúp Huy soi lỗi cực nhanh
      if (data.trim() === "success") {
        editInfoBrandModal.style.display = "none";
        fetchGlobalBrands();

        const curCatId = document.getElementById("current-category-id").value;
        if (curCatId) fetchBrands(curCatId);
        Toast.fire({ icon: "success", title: "Đã cập nhật thương hiệu!" });
      } else {
        // Hiển thị cả lỗi mà Server trả về để dễ sửa
        Swal.fire("Lỗi", "Không thể cập nhật: " + data, "error");
      }
    });
}

// Hàm thêm thương hiệu trực tiếp từ bảng tổng (Dưới cùng trang)
function addNewBrandGlobalDirect() {
  const nameInput = document.getElementById("global-new-brand-name");
  const descInput = document.getElementById("global-new-brand-desc");
  const name = nameInput.value.trim();
  const desc = descInput.value.trim();

  if (!name) {
    Swal.fire("Thông báo", "Vui lòng nhập tên thương hiệu!", "warning");
    return;
  }

  let formData = new FormData();
  formData.append("action", "add_global_direct");
  formData.append("brand_name", name);
  formData.append("brand_desc", desc);

  fetch("forms/quanlyloaisanpham/ajax_handle_brands.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      if (data.trim() === "success") {
        nameInput.value = "";
        descInput.value = "";
        fetchGlobalBrands(); // Cập nhật lại bảng
        Toast.fire({ icon: "success", title: "Đã thêm thương hiệu mới!" });
      }
    });
}

const editButtons = document.querySelectorAll(".edit-category-btn");
if (editButtons) {
  editButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      const editModal = document.getElementById("edit-info-category");
      if (!editModal) return;

      // 1. LẤY DỮ LIỆU: Ưu tiên lấy từ data-attributes để chính xác nhất
      const categoryId = button.getAttribute("data-id");
      const row = button.closest("tr");

      if (row) {
        const cells = row.querySelectorAll("td");

        // Trích xuất dữ liệu từ các cột
        const categoryName = cells[1].textContent.trim();
        const profitPercentage = cells[2].textContent.trim().replace("%", "");
        const description = cells[3].textContent.trim();

        // 2. ĐIỀN DỮ LIỆU VÀO MODAL
        // Điền ID vào input hidden
        const idInput = document.getElementById("input-edit-id-category");
        if (idInput) idInput.value = categoryId;

        // Điền Tên Loại
        const nameInput = document.getElementById("input-edit-namecategory");
        if (nameInput) nameInput.value = categoryName;

        // Điền Lợi nhuận
        const profitInput = document.getElementById(
          "input-edit-profitcategory",
        );
        if (profitInput) profitInput.value = profitPercentage;

        // Điền Mô tả
        const descriptionTextarea = document.getElementById("mo_ta");
        if (descriptionTextarea) descriptionTextarea.value = description;
      }

      // 3. HIỂN THỊ MODAL VÀ XỬ LÝ ĐÓNG
      editModal.style.display = "block";

      const closeBtn = document.querySelector(
        ".close-button-for-edit-info-category",
      );
      if (closeBtn) {
        closeBtn.onclick = function () {
          editModal.style.display = "none";
        };
      }

      window.onclick = function (event) {
        if (event.target == editModal) {
          editModal.style.display = "none";
        }
      };
    });
  });
}

/*DÀNH CHO QUẢN LÝ NHẬP SẢN PHẨM */

//Dữ liệu mẫu (Giả định bạn có cấu trúc dữ liệu như thế này)
const brandData = {
  "Guitar Classic": ["Ba đờn", "Yamaha"],
  "Guitar Acoustic": ["Saga", "Taylor", "Enya", "Yamaha"],
  // Thêm các loại khác nếu cần
};
// Dữ liệu mẫu tên sản phẩm (Bạn cần phải tùy chỉnh dữ liệu này)
const productNamesData = {
  "Guitar Classic": {
    "Ba đờn": ["Ba Đờn N100", "Ba Đờn N250", "Ba Đờn C100"],
    Yamaha: ["Yamaha C40", "Yamaha C70", "Yamaha CX40"],
  },
  "Guitar Acoustic": {
    Saga: ["Saga CL65", "Saga SF700C", "Saga GS-02"],
    Taylor: ["Taylor A12E", "Taylor GS Mini", "Taylor 114CE"],
    Enya: ["Enya EGA X0 PRO SP1", "Enya ED-X0", "Enya Nova Go"],
    Yamaha: ["Yamaha FG800", "Yamaha FS820", "Yamaha LS36 ARE"],
  },
};
// ... (các const khác như brandData)

function updateProductDatalist(productContainer) {
  // 1. Lấy giá trị đang chọn: Loại sản phẩm và Thương hiệu
  const typeSelect = productContainer.querySelector(".manage-product-type");
  const brandSelect = productContainer.querySelector(".manage-product-brands");
  const productNameInput = productContainer.querySelector(
    ".product-name-input",
  );

  if (!typeSelect || !brandSelect || !productNameInput) return;

  const selectedType = typeSelect.value;
  const selectedBrand = brandSelect.value;

  // 2. Lấy datalist tương ứng với input tên sản phẩm
  //    (Lưu ý: datalist có thể có ID tĩnh, nhưng nên tạo/quản lý riêng cho từng sản phẩm)
  //    Để đơn giản, ta sẽ chỉ tìm datalist ngay sau input Tên sản phẩm
  const datalist = document.getElementById(
    productNameInput.getAttribute("list"),
  );
  if (!datalist) return;

  // 3. Xóa nội dung cũ
  datalist.innerHTML = "";

  // 4. Lấy danh sách tên sản phẩm từ dữ liệu mẫu
  const productList = productNamesData[selectedType]?.[selectedBrand] || [];

  // 5. Thêm các tùy chọn mới vào datalist
  productList.forEach((productName) => {
    const option = document.createElement("option");
    option.value = productName;
    datalist.appendChild(option);
  });
}

function updateBrandsForProduct(typeSelect) {
  // khi chọn loại acoustic hay classic thì các brand cũng thay đổi
  // 1. Lấy giá trị loại sản phẩm đang được chọn
  const selectedType = typeSelect.value;

  // 2. Lấy thẻ select Thương hiệu tương ứng (là phần tử cùng cấp trong div cha)
  //    Chúng ta tìm kiếm thẻ select có class 'manage-product-brands' bên trong thẻ DIV cha của typeSelect.
  const productContainer = typeSelect.closest(".product-fields-template");
  if (!productContainer) return; // Bảo vệ nếu không tìm thấy container

  const brandSelect = productContainer.querySelector(".manage-product-brands");
  if (!brandSelect) return; // Bảo vệ nếu không tìm thấy select Thương hiệu

  // 3. Lấy danh sách thương hiệu tương ứng
  const brands = brandData[selectedType] || []; // Thêm || [] để tránh lỗi nếu không tìm thấy loại

  // 4. Xóa tất cả các tùy chọn cũ trong select Thương hiệu
  brandSelect.innerHTML = "";

  // 5. Lặp qua danh sách thương hiệu và thêm vào thẻ select
  brands.forEach((brand) => {
    const option = document.createElement("option");
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
  const rawNumber = value.toString().replace(/[^0-9]/g, "");

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
    const currentValue = this.value.replace(/[^0-9]/g, "");

    // Chỉ định dạng nếu có giá trị
    if (currentValue) {
      // Gán lại giá trị đã được định dạng (có dấu chấm và VND)
      this.value = formatCurrency(currentValue);
    } else {
      // Nếu người dùng xóa sạch, giữ lại ô trống
      this.value = "";
    }
  };

  // --- Định nghĩa hàm xử lý khi nhấn phím ---
  const handleKeydown = function (event) {
    // Kiểm tra xem phím Enter (key code 13) có được nhấn không
    if (event.key === "Enter") {
      event.preventDefault(); // Ngăn trình duyệt gửi form hoặc hành động mặc định
      handleFormatting.call(this); // Gọi hàm định dạng
      this.blur(); // Tự động di chuyển khỏi ô nhập
    }
  };

  // 1. Gán sự kiện BLUR (Click ra ngoài)
  inputElement.addEventListener("blur", handleFormatting);

  // 2. Gán sự kiện KEYDOWN (Nhấn Enter)
  inputElement.addEventListener("keydown", handleKeydown);

  // QUAN TRỌNG: Gán sự kiện FOCUS để dọn dẹp định dạng khi BẮT ĐẦU nhập lại
  inputElement.addEventListener("focus", function () {
    // Khi người dùng click vào ô, loại bỏ ' VND' và dấu chấm để họ nhập số thuần
    this.value = this.value.replace(/[^0-9]/g, "");
  });
}

// HÀM MỚI: Đặt lại toàn bộ form phiếu nhập về trạng thái ban đầu
function resetImportForm() {
  const importFormContainer = document.getElementById("import-form-container");
  if (!importFormContainer) return;

  // 1. Reset các trường Header (Ngày nhập, Mã phiếu)
  const headerInputs = importFormContainer.querySelectorAll(
    ".header-fields-row-manage-import input",
  );
  headerInputs.forEach((input) => {
    input.value = "";
  });

  // 2. Chỉ giữ lại 1 sản phẩm duy nhất và reset nó
  const allProductFields = importFormContainer.querySelectorAll(
    ".product-fields-template",
  );

  // Giữ lại phần tử đầu tiên (sản phẩm mặc định)
  const initialProductFields = allProductFields[0];

  // Xóa tất cả các phần tử sản phẩm thừa (từ phần tử thứ 2 trở đi)
  for (let i = 1; i < allProductFields.length; i++) {
    allProductFields[i].remove();
  }

  // 3. Reset các trường của sản phẩm còn lại (sản phẩm đầu tiên)
  initialProductFields.querySelectorAll("input, select").forEach((element) => {
    if (element.tagName === "SELECT") {
      element.selectedIndex = 0; // Đặt lại về option đầu tiên
    } else {
      element.value = ""; // Xóa giá trị input
    }
  });

  // 4. Cập nhật lại danh sách Thương hiệu (và Datalist) cho sản phẩm đầu tiên
  const typeSelect = initialProductFields.querySelector(".manage-product-type");
  if (typeSelect) {
    updateBrandsForProduct(typeSelect);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // 1. Gán sự kiện 'change' cho tất cả các select Loại sản phẩm hiện có
  //    (Áp dụng cho sản phẩm mặc định ban đầu)
  document.querySelectorAll(".manage-product-type").forEach((selectElement) => {
    //khi thay đổi lựa chọn phân loại sẽ kích hoạt hàm thay đổi brand
    selectElement.addEventListener("change", function () {
      updateBrandsForProduct(this); // 'this' là select Loại sản phẩm vừa thay đổi
    });
    // Gọi hàm để thiết lập Thương hiệu ban đầu cho sản phẩm mặc định
    updateBrandsForProduct(selectElement);
  });

  // THAY ĐỔI MỚI: Gán sự kiện 'change' cho tất cả các select Thương hiệu hiện có
  document
    .querySelectorAll(".manage-product-brands")
    .forEach((selectElement) => {
      selectElement.addEventListener("change", function () {
        // Lấy div cha (.product-fields-template)
        const productContainer = this.closest(".product-fields-template");
        updateProductDatalist(productContainer);
      });
    });

  // === GÁN SỰ KIỆN FORMAT CHO CÁC Ô ĐƠN GIÁ BAN ĐẦU ===
  document.querySelectorAll(".unit-price-input").forEach((input) => {
    attachPriceFormatter(input);
  });
  // ===================================================

  document.querySelectorAll(".create-import-btn").forEach((button) => {
    //hiện popup khi click vào nút thêm phiếu nhập
    button.addEventListener("click", function (event) {
      event.preventDefault();
      // <<< THÊM: Reset form trước khi mở modal >>>
      resetImportForm();
      modal.style.display = "block";
    });
  });

  const initialProductTemplate = document.getElementsByClassName(
    "product-fields-template",
  )[0];
  if (initialProductTemplate) {
    const initialRemoveBtn = initialProductTemplate.querySelector(
      ".remove-product-btn",
    );
    if (initialRemoveBtn) {
      // Ẩn nút xóa trên sản phẩm đầu tiên để đảm bảo luôn có ít nhất 1 sản phẩm
      initialRemoveBtn.style.display = "none";
    }
  }

  // 3. Xử lý nút THÊM SẢN PHẨM (Đảm bảo code này vẫn chạy sau khi bạn sửa HTML/JS thêm sản phẩm)
  const addProductButton = document.getElementById(
    "add-product-fields-template",
  ); // ID của nút "Thêm sản phẩm"
  const importFormContainer = document.getElementById("import-form-container");
  const productTemplate = document.getElementsByClassName(
    "product-fields-template",
  )[0];
  const actionButtonConatainer = document.getElementById(
    "manage-add-and-save-container",
  );

  if (addProductButton && actionButtonConatainer) {
    addProductButton.addEventListener("click", function () {
      const newProductFields = productTemplate.cloneNode(true);

      // ... (Phần xóa giá trị và thêm HR như code trước) ...

      // Xóa giá trị input và reset select
      newProductFields.querySelectorAll("input, select").forEach((element) => {
        if (element.tagName === "SELECT") {
          element.selectedIndex = 0;
        } else {
          element.value = "";
        }
      });

      // 1. HIỆN NÚT XÓA TRÊN BẢN SAO
      const newRemoveBtn = newProductFields.querySelector(
        ".remove-product-btn",
      );
      if (newRemoveBtn) {
        newRemoveBtn.style.display = "block"; // Đảm bảo nút này hiển thị

        // 2. GÁN SỰ KIỆN XÓA CHO NÚT MỚI
        newRemoveBtn.addEventListener("click", function () {
          // Xóa phần tử cha của nút (chính là .product-fields-template)
          newProductFields.remove();
        });
      }

      // CHỖ QUAN TRỌNG: Gán sự kiện 'change' cho select Loại sản phẩm MỚI
      const newTypeSelect = newProductFields.querySelector(
        ".manage-product-type",
      );
      newTypeSelect.addEventListener("change", function () {
        updateBrandsForProduct(this);
      });

      // Gán sự kiện 'change' cho select Thương hiệu MỚI
      const newBrandSelect = newProductFields.querySelector(
        ".manage-product-brands",
      );
      newBrandSelect.addEventListener("change", function () {
        const productContainer = this.closest(".product-fields-template");
        updateProductDatalist(productContainer);
      });

      // THAY ĐỔI MỚI: Gán sự kiện format cho ô Đơn giá MỚI
      const newPriceInput = newProductFields.querySelector(".unit-price-input");
      attachPriceFormatter(newPriceInput);

      // Gọi hàm cập nhật Thương hiệu cho sản phẩm mới (dựa trên giá trị mặc định)
      updateBrandsForProduct(newTypeSelect);

      importFormContainer.insertBefore(
        newProductFields,
        actionButtonConatainer,
      );
    });
  }

  const button_saveimportproduct = document.getElementById(
    "save-import-product",
  );
  if (button_saveimportproduct) {
    button_saveimportproduct.addEventListener("click", function (event) {
      event.preventDefault(); // Ngăn submit form nếu có

      // 1. Đóng Modal
      modal.style.display = "none";

      // 2. Reset form
      resetImportForm();

      // 3. Hiện Toast thành công
      Toast.fire({
        icon: "success",
        title: "Phiếu nhập đã được lưu thành công!",
      });

      // TODO: Gọi API lưu dữ liệu ở đây
      // saveImportData();
    });
  }
});

/**Quản lý danh mục sản phẩm */

window.addEventListener("click", function (event) {
  // Lấy các phần tử modal (có thể null nếu trang đó không có)
  const addProductModal = document.getElementById("addProductModal");
  const editProductModal = document.getElementById("editProductModal");

  // Kiểm tra addProdcutModal có tồn tại trên trang này KHÔNG và người dùng có bấm trúng nó KHÔNG
  if (addProductModal && event.target == addProductModal) {
    addProductModal.style.display = "none";
  }

  // Tương tự cho editProductModal
  if (editProductModal && event.target == editProductModal) {
    editProductModal.style.display = "none";
  }
});




/** QUẢN LÝ DANH MỤC SẢN PHẨM: HỢP NHẤT TOÀN BỘ LOGIC **/

document.addEventListener('DOMContentLoaded', function () {
    const addProductModal = document.getElementById('addProductModal');
    const addProductForm = document.getElementById('add-product-form');
    const openAddBtn = document.getElementById('open-add-product');
    
    const typeSelect = document.getElementById('modal-product-type');
    const brandSelect = document.getElementById('modal-product-brand');
    const profitInput = document.getElementById('modal-product-profit-margin');
    
    const imageUpload = document.getElementById('product-images-upload');
    const previewContainer = document.getElementById('image-preview-container');

    if (!addProductModal) return; // Nếu không ở trang này thì thoát

    // --- 1. Mở/Đóng Modal ---
    if (openAddBtn) {
        openAddBtn.addEventListener('click', () => addProductModal.style.display = 'block');
    }

    const closeButtons = [
        addProductModal.querySelector('.close-button'),
        document.getElementById('cancel-add-product')
    ];

    closeButtons.forEach(btn => {
        if (btn) btn.onclick = () => addProductModal.style.display = 'none';
    });

    // --- 2. Load Thương hiệu & Lợi nhuận (Yêu cầu 1, 2) ---
    if (typeSelect && brandSelect) {
        typeSelect.addEventListener('change', function () {
            const categoryName = this.value;
            if (!categoryName) return;

            fetch(`forms/danhmucsanpham/ajax_handle_products.php?action=get_brands_by_category&category_name=${categoryName}`)
                .then(res => res.json())
                .then(brands => {
                    let html = '<option value="" selected disabled>-- Chọn thương hiệu --</option>';
                    html += brands.map(b => `<option value="${b.id}" data-profit="${b.profit_margin}">${b.brand_name}</option>`).join('');
                    brandSelect.innerHTML = html;
                    profitInput.value = ''; 
                });
        });

        brandSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            profitInput.value = (selected && selected.value) ? selected.getAttribute('data-profit') : '';
        });
    }

    // --- 3. Xem trước ảnh (Tối đa 6 ảnh) ---
    let dataStorage = new DataTransfer(); 
    if (imageUpload) {
        imageUpload.addEventListener('change', function() {
            const files = Array.from(this.files);
            if (dataStorage.files.length + files.length > 6) {
                Swal.fire('Thông báo', 'Tổng số lượng ảnh không được quá 6!', 'warning');
                this.files = dataStorage.files; 
                return;
            }
            files.forEach(file => {
                dataStorage.items.add(file); 
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = `<img src="${e.target.result}"><button type="button" class="remove-img-btn">&times;</button>`;
                    div.querySelector('.remove-img-btn').onclick = () => {
                        const newData = new DataTransfer();
                        for (let f of dataStorage.files) { if (f !== file) newData.items.add(f); }
                        dataStorage = newData;
                        imageUpload.files = dataStorage.files; 
                        div.remove();
                    };
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
            this.files = dataStorage.files; 
        });
    }

    // --- 4. Gửi dữ liệu thật bằng AJAX (Yêu cầu 6, 7 xử lý ở PHP) ---
    if (addProductForm) {
        addProductForm.onsubmit = function (e) {
            e.preventDefault();
            
            Swal.fire({ title: 'Đang lưu...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            let formData = new FormData(this);
            formData.append('action', 'add_product');

            fetch('forms/danhmucsanpham/ajax_handle_products.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    Swal.fire('Thành công', 'Sản phẩm mới đã được lưu!', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Lỗi', data, 'error');
                }
            });
        };
    }
});



/* --- QUẢN LÝ DANH MỤC SẢN PHẨM: XỬ LÝ NÚT SỬA (GIAO DIỆN) --- */
document.addEventListener("DOMContentLoaded", function () {
  const editProductModal = document.getElementById("editProductModal");
  const editProductForm = document.getElementById("edit-product-form");

  // Lắng nghe sự kiện click cho các nút Sửa
  document.querySelectorAll(".edit-product-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      const row = this.closest("tr");
      if (!row) return;

      // 1. TRÍCH XUẤT DỮ LIỆU TỪ HÀNG
      const productName = row.cells[1].textContent.trim();
      const productType = row.cells[2].textContent.trim();
      // Loại bỏ " VND" và dấu chấm để lấy số thuần
      const costPrice = row.cells[3].textContent.replace(/[^0-9]/g, ""); 
      const profit = row.cells[4].textContent.replace("%", "").trim();

      // 2. ĐIỀN DỮ LIỆU VÀO MODAL SỬA
      document.getElementById("edit-product-name").value = productName;
      
      // Xử lý logic chọn Phân loại
      const typeValue = productType.includes("Acoustic") ? "Guitar Acoustic" : "Guitar Classic";
      const typeSelect = document.getElementById("edit-product-type");
      if(typeSelect) {
          typeSelect.value = typeValue;
          // Cập nhật danh sách Thương hiệu tương ứng (dùng hàm đã có của Huy)
          updateEditModalBrands(typeValue); 
      }

      // Điền các giá trị tài chính
      const costInput = document.getElementById("modal-product-cost-price");
      if(costInput) costInput.value = costPrice;

      const profitInput = editProductModal.querySelector("#modal-product-profit-margin");
      if(profitInput) profitInput.value = profit;

      // 3. HIỂN THỊ MODAL
      if (editProductModal) {
        editProductModal.style.display = "block";
      }
    });
  });

  // Xử lý đóng Modal Sửa
  const closeEditBtn = document.getElementById("close-edit-modal");
  const cancelEditBtn = document.getElementById("cancel-edit-product");

  [closeEditBtn, cancelEditBtn].forEach((btn) => {
    if (btn) {
      btn.onclick = () => {
        editProductModal.style.display = "none";
      };
    }
  });
});