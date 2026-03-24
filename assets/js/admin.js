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
//

/*DÀNH CHO TRANG QUẢN LÝ PHÂN LOẠI*/

/* --- QUẢN LÝ PHÂN LOẠI BẰNG AJAX (BẢN FIX MỞ/ĐÓNG MODAL) --- */
function initializeCategoryEvents() {
  // --- 1. Sự kiện cho nút SỬA PHÂN LOẠI ---
  document.querySelectorAll(".edit-category-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const editModal = document.getElementById("edit-info-category");

      // Nạp dữ liệu vào Modal
      document.getElementById("input-edit-id-category").value =
        this.getAttribute("data-id");
      document.getElementById("input-edit-namecategory").value =
        this.getAttribute("data-name");
      document.getElementById("input-edit-profitcategory").value =
        this.getAttribute("data-profit");
      const rawDesc = this.getAttribute("data-desc");
      document.getElementById("mo_ta").value =
        rawDesc === "Chưa có mô tả" ? "" : rawDesc;

      // HIỆN MODAL
      if (editModal) editModal.style.display = "block";
    });
  });

  // --- 2. Sự kiện cho nút QUẢN LÝ THƯƠNG HIỆU (FIX LỖI KHÔNG MỞ MODAL) ---
  document.querySelectorAll(".manage-brands-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const catId = this.getAttribute("data-id");
      const brandModal = document.getElementById("edit-brands-modal"); // Modal cần mở
      const row = this.closest("tr");
      const catName =
        row.querySelector(".manage-name-category")?.textContent || "Phân loại";

      document.getElementById("current-category-id").value = catId;
      document.getElementById("brand-modal-title").innerHTML =
        `Danh sách thương hiệu: <strong>${catName}</strong>`;

      fetchBrands(catId); // Tải danh sách brand qua AJAX

      // HIỆN MODAL (Huy bị thiếu dòng này nên Modal không mở)
      if (brandModal) brandModal.style.display = "block";
    });
  });

  document.querySelectorAll(".hide-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const categoryId = this.dataset.id;

      fetch("forms/quanlyloaisanpham/ajax_handle_categories.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=toggle_status&id=${categoryId}`,
      })
        .then((res) => res.text())
        .then((data) => {
          if (data.trim() === "success") {
            fetchCategories(); // Tải lại bảng để đổi icon mắt
            Toast.fire({
              icon: "success",
              title: "Đã cập nhật hiển thị loại!",
            });
          }
        });
    });
  });

  // --- 3. Sự kiện cho nút XÓA --- (Giữ nguyên logic của Huy)
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
                fetchCategories();
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

function toggleBrandStatus(id) {
  fetch("forms/quanlyloaisanpham/ajax_handle_brands.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=toggle_brand_status&id=${id}`,
  })
    .then((res) => res.text())
    .then((data) => {
      if (data.trim() === "success") {
        fetchGlobalBrands(); // Tải lại bảng để cập nhật icon
        Toast.fire({
          icon: "success",
          title: "Đã cập nhật trạng thái thương hiệu!",
        });
      } else {
        Swal.fire("Lỗi", data, "error");
      }
    });
}
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

/* ==========================================================
   DỮ LIỆU MẪU & CẤU HÌNH (GIỮ NGUYÊN)
   ========================================================== */
const brandData = {
  "Guitar Classic": ["Ba đờn", "Yamaha"],
  "Guitar Acoustic": ["Saga", "Taylor", "Enya", "Yamaha"],
};

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

/* ==========================================================
   CÁC HÀM HỖ TRỢ LOGIC (DIALIST, BRAND, CURRENCY, RESET)
   ========================================================== */

// 1. Cập nhật Thương hiệu từ DB
function updateBrandsForProduct(typeSelect) {
  const selectedType = typeSelect.value;
  const productContainer = typeSelect.closest(".product-fields-template");
  const brandSelect = productContainer.querySelector(".manage-product-brands");

  // Gọi AJAX để lấy thương hiệu thật từ Database
  fetch(
    `forms/quanlynhapsanpham/ajax_handle_import.php?action=get_brands&category_name=${encodeURIComponent(selectedType)}`,
  )
    .then((res) => res.json())
    .then((brands) => {
      brandSelect.innerHTML = brands
        .map((b) => `<option value="${b.id}">${b.brand_name}</option>`)
        .join("");
      // Sau khi có brand, cập nhật luôn datalist gợi ý sản phẩm
      updateProductDatalist(productContainer);
    });
}

// 2. Gợi ý sản phẩm khi nhập (Autocomplete)
// 1. Cập nhật hàm gợi ý sản phẩm (SỬA LỖI CLOSURE)
function updateProductDatalist(productContainer) {
  const nameInput = productContainer.querySelector(".product-name-input");
  const datalist = productContainer.querySelector("datalist"); // Lấy datalist ngay trong container này

  nameInput.oninput = function () {
    // QUAN TRỌNG: Lấy giá trị HIỆN TẠI bên trong sự kiện oninput
    const type = productContainer.querySelector(".manage-product-type").value;
    const brandId = productContainer.querySelector(
      ".manage-product-brands",
    ).value;
    const query = this.value;

    if (query.length < 1) {
      datalist.innerHTML = "";
      return;
    }

    fetch(
      `forms/quanlynhapsanpham/ajax_handle_import.php?action=get_product_suggestions&type=${encodeURIComponent(type)}&brand_id=${brandId}&query=${encodeURIComponent(query)}`,
    )
      .then((res) => res.json())
      .then((products) => {
        datalist.innerHTML = products
          .map(
            (p) =>
              `<option value="${p.product_name}" data-id="${p.id}"></option>`,
          )
          .join("");
      });
  };
}

function formatCurrency(value) {
  const rawNumber = value.toString().replace(/[^0-9]/g, "");
  if (rawNumber.length < 4) return rawNumber;
  return rawNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " VND";
}

function attachPriceFormatter(inputElement) {
  if (!inputElement) return;

  const handleFormatting = function () {
    const currentValue = this.value.replace(/[^0-9]/g, "");
    this.value = currentValue ? formatCurrency(currentValue) : "";
  };

  inputElement.addEventListener("blur", handleFormatting);
  inputElement.addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      handleFormatting.call(this);
      this.blur();
    }
  });

  inputElement.addEventListener("focus", function () {
    this.value = this.value.replace(/[^0-9]/g, "");
  });
}

function resetImportForm() {
  const importFormContainer = document.getElementById("import-form-container");
  if (!importFormContainer) return;

  // 1. Reset Header
  importFormContainer
    .querySelectorAll(".header-fields-row-manage-import input")
    .forEach((i) => (i.value = ""));

  // 2. Dọn dẹp các dòng sản phẩm, chỉ giữ lại dòng đầu tiên
  const allProductFields = importFormContainer.querySelectorAll(
    ".product-fields-template",
  );
  for (let i = 1; i < allProductFields.length; i++) {
    allProductFields[i].remove();
  }

  // 3. Reset dòng đầu tiên
  const initialFields = allProductFields[0];
  initialFields.querySelectorAll("input, select").forEach((el) => {
    if (el.tagName === "SELECT") el.selectedIndex = 0;
    else el.value = "";
  });

  const typeSelect = initialFields.querySelector(".manage-product-type");
  if (typeSelect) updateBrandsForProduct(typeSelect);
}

/* ==========================================================
   QUẢN LÝ SỰ KIỆN (BẢN MERGE CHUẨN - KHÔNG TRÙNG LẶP)
   ========================================================== */

document.addEventListener("DOMContentLoaded", function () {
  const importModal = document.getElementById("ImportReceiptModal");
  const closeImportBtn = document.getElementById("close-import-modal");
  const createImportBtns = document.querySelectorAll(".create-import-btn");
  const importFormContainer = document.getElementById("import-form-container");
  const addProductButton = document.getElementById(
    "add-product-fields-template",
  );
  const saveImportButton = document.getElementById("save-import-product");

  // 2. Sửa logic khi bấm nút "Thêm sản phẩm" (SỬA LỖI TRÙNG ID)
  // Huy tìm đoạn addProductButton.addEventListener("click", ...) và cập nhật:
  if (addProductButton && importFormContainer) {
    addProductButton.addEventListener("click", function () {
      const productTemplate = document.querySelector(
        ".product-fields-template",
      );
      const actionContainer = document.getElementById(
        "manage-add-and-save-container",
      );

      if (productTemplate && actionContainer) {
        const newProductFields = productTemplate.cloneNode(true);
        const timestamp = Date.now(); // Tạo mã duy nhất

        // Xử lý Datalist để không bị trùng ID
        const newInput = newProductFields.querySelector(".product-name-input");
        const newDatalist = newProductFields.querySelector("datalist");

        newDatalist.id = "list_" + timestamp; // Gán ID mới: list_171123...
        newInput.setAttribute("list", "list_" + timestamp); // Trỏ input vào ID mới này

        // Reset giá trị
        newProductFields.querySelectorAll("input, select").forEach((el) => {
          if (el.tagName === "SELECT") el.selectedIndex = 0;
          else el.value = "";
        });

        // Gán lại các sự kiện (Giữ nguyên logic cũ của Huy)
        const removeBtn = newProductFields.querySelector(".remove-product-btn");
        if (removeBtn) {
          removeBtn.style.display = "block";
          removeBtn.onclick = () => newProductFields.remove();
        }

        const newTypeSelect = newProductFields.querySelector(
          ".manage-product-type",
        );
        newTypeSelect.addEventListener("change", function () {
          updateBrandsForProduct(this);
        });

        const newBrandSelect = newProductFields.querySelector(
          ".manage-product-brands",
        );
        newBrandSelect.addEventListener("change", function () {
          updateProductDatalist(newProductFields);
        });

        attachPriceFormatter(
          newProductFields.querySelector(".unit-price-input"),
        );

        importFormContainer.insertBefore(newProductFields, actionContainer);
        updateBrandsForProduct(newTypeSelect);
      }
    });
  }
  if (!importModal) return;

  // --- 1. KHỞI TẠO DÒNG ĐẦU TIÊN KHI TẢI TRANG ---
  const initialRow = document.querySelector(".product-fields-template");
  if (initialRow) {
    // Ẩn nút xóa ở dòng đầu tiên
    const initialRemoveBtn = initialRow.querySelector(".remove-product-btn");
    if (initialRemoveBtn) initialRemoveBtn.style.display = "none";

    // Gán sự kiện cho các select có sẵn
    const typeSelect = initialRow.querySelector(".manage-product-type");
    const brandSelect = initialRow.querySelector(".manage-product-brands");
    const priceInput = initialRow.querySelector(".unit-price-input");

    typeSelect?.addEventListener("change", function () {
      updateBrandsForProduct(this);
    });
    brandSelect?.addEventListener("change", function () {
      updateProductDatalist(initialRow);
    });
    attachPriceFormatter(priceInput);

    // Chạy khởi tạo brand mặc định
    if (typeSelect) updateBrandsForProduct(typeSelect);
  }

  // --- 2. LOGIC ĐÓNG / MỞ MODAL ---
  createImportBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      resetImportForm(); // Xóa trắng form cũ

      // GỌI AJAX LẤY MÃ PHIẾU TỰ ĐỘNG
      fetch(
        "forms/quanlynhapsanpham/ajax_handle_import.php?action=get_new_code",
      )
        .then((res) => res.text())
        .then((code) => {
          document.getElementById("import-receipt-code").value = code;
          importModal.style.display = "block";
        });
    });
  });

  if (closeImportBtn) {
    closeImportBtn.onclick = () => (importModal.style.display = "none");
  }

  window.addEventListener("click", (e) => {
    if (e.target == importModal) importModal.style.display = "none";
  });

  // --- 3. LOGIC THÊM DÒNG SẢN PHẨM MỚI ---
  if (addProductButton && importFormContainer) {
    addProductButton.addEventListener("click", function () {
      const productTemplate = document.querySelector(
        ".product-fields-template",
      );
      const actionContainer = document.getElementById(
        "manage-add-and-save-container",
      );

      if (productTemplate && actionContainer) {
        const newProductFields = productTemplate.cloneNode(true);

        // Reset giá trị dòng mới
        newProductFields.querySelectorAll("input, select").forEach((el) => {
          if (el.tagName === "SELECT") el.selectedIndex = 0;
          else el.value = "";
        });

        // Hiện và gán sự kiện nút Xóa
        const removeBtn = newProductFields.querySelector(".remove-product-btn");
        if (removeBtn) {
          removeBtn.style.display = "block";
          removeBtn.onclick = () => newProductFields.remove();
        }

        // Gán sự kiện cho Select Loại & Thương hiệu mới
        const newTypeSelect = newProductFields.querySelector(
          ".manage-product-type",
        );
        newTypeSelect.addEventListener("change", function () {
          updateBrandsForProduct(this);
        });

        const newBrandSelect = newProductFields.querySelector(
          ".manage-product-brands",
        );
        newBrandSelect.addEventListener("change", function () {
          updateProductDatalist(newProductFields);
        });

        // Định dạng tiền tệ cho ô mới
        attachPriceFormatter(
          newProductFields.querySelector(".unit-price-input"),
        );

        // Chèn vào Form
        importFormContainer.insertBefore(newProductFields, actionContainer);
        updateBrandsForProduct(newTypeSelect);
      }
    });
  }

  // --- 4. LOGIC LƯU PHIẾU NHẬP (BẢN FIX - HUY) ---
  if (saveImportButton) {
    saveImportButton.addEventListener("click", function (e) {
      e.preventDefault();

      const receiptCode = document.getElementById("import-receipt-code").value;
      const importDate = document.querySelector(
        '.header-fields-row-manage-import input[type="date"]',
      ).value;

      if (!importDate) {
        Swal.fire(
          "Thông báo",
          "Huy ơi, chọn ngày nhập giúp mình nhé!",
          "warning",
        );
        return;
      }

      let formData = new FormData();
      formData.append("action", "save_import");
      formData.append("receipt_code", receiptCode);
      formData.append("import_date", importDate);

      let totalAll = 0;
      let hasProductError = false;
      let productCount = 0;

      // Duyệt qua từng dòng sản phẩm để thu thập dữ liệu
      document
        .querySelectorAll(".product-fields-template")
        .forEach((row, index) => {
          const nameInput = row.querySelector(".product-name-input");
          const qtyInput = row.querySelector('input[type="number"]');
          const priceInput = row.querySelector(".unit-price-input");

          if (nameInput.value.trim() !== "") {
            // Tìm ID sản phẩm từ Datalist
            const datalist = document.getElementById(
              nameInput.getAttribute("list"),
            );
            const option = Array.from(datalist.options).find(
              (opt) => opt.value === nameInput.value,
            );

            if (option && option.dataset.id) {
              const qty = parseInt(qtyInput.value) || 0;
              const price =
                parseInt(priceInput.value.replace(/[^0-9]/g, "")) || 0;

              totalAll += qty * price;
              productCount++;

              formData.append(`products[${index}][id]`, option.dataset.id);
              formData.append(`products[${index}][qty]`, qty);
              formData.append(`products[${index}][price]`, price);
            } else {
              hasProductError = true; // Có tên nhưng không có trong DB
            }
          }
        });

      if (productCount === 0) {
        Swal.fire("Lỗi", "Bạn chưa nhập sản phẩm!", "error");
        return;
      }

      if (hasProductError) {
        Swal.fire(
          "Lỗi",
          "Có sản phẩm không hợp lệ (Huy hãy chọn từ danh sách gợi ý nhé)!",
          "error",
        );
        return;
      }

      formData.append("total_amount", totalAll); // Gửi tổng tiền để PHP không báo lỗi

      // Gửi dữ liệu qua AJAX
      fetch("forms/quanlynhapsanpham/ajax_handle_import.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.text())
        .then((data) => {
          if (data.trim() === "success") {
            Swal.fire("Thành công", "Đã lưu phiếu nhập thành công!", "success");
            importModal.style.display = "none";
            resetImportForm();
            location.reload(); // Tải lại để cập nhật danh sách
          } else {
            Swal.fire("Lỗi Server", data, "error");
          }
        })
        .catch((err) => Swal.fire("Lỗi kết nối", err.message, "error"));
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

/* ==========================================================
   QUẢN LÝ DANH MỤC SẢN PHẨM: AJAX + ĐIỂM NỔI BẬT + LOGIC 6 ẢNH (BẢN FULL)
   ========================================================== */
document.addEventListener("DOMContentLoaded", function () {
  const addModal = document.getElementById("addProductModal");
  const editModal = document.getElementById("editProductModal");
  const productTableBody = document.getElementById("product-list-container");

  if (!productTableBody) return;

  // --- 1. BIẾN QUẢN LÝ ẢNH ---
  let addDataStorage = new DataTransfer(); // Thêm dòng này cho Add Modal
  let editDataStorage = new DataTransfer();
  let currentImagesToKeep = [];
  let currentBasePath = "";

  // --- 2. HÀM TẢI DANH SÁCH SẢN PHẨM (AJAX) ---
  // --- Cập nhật hàm fetchProductList trong admin.js ---
  function fetchProductList(page = 1) {
    const type = document.getElementById("filter-product-type")?.value || ""; // Giờ là ID số
    const brand = document.getElementById("filter-product-brand")?.value || "";
    const discountSelect = document.getElementById("filter-product-discount");
    const discount = discountSelect ? discountSelect.value : ""; // Đảm bảo lấy đúng value
    const search = document.getElementById("search-input")?.value || "";

    // Gửi yêu cầu lên server, dùng category_id (hoặc giữ key product_type nhưng giá trị là ID)
    console.log(`Đang lọc: Type=${type}, Brand=${brand}, Discount=${discount}, Page=${page}`);

    const url = `forms/danhmucsanpham/ajax_handle_products.php?action=fetch_list&page=${page}&product_type=${type}&brand_id=${brand}&is_discount=${discount}&search=${encodeURIComponent(search)}`;

    fetch(url)
      .then((res) => res.json())
      .then((data) => {
        const productTableBody = document.getElementById(
          "product-list-container",
        );
        if (productTableBody) {
          productTableBody.innerHTML = data.table;
          // Cập nhật lại thanh phân trang AJAX
          const paginationUl = document.querySelector(
            "#category-pagination ul",
          );
          if (paginationUl) paginationUl.innerHTML = data.pagination;

          attachActionButtonsEvents(); // Quan trọng: Gán lại sự kiện Sửa/Xóa
        }
      });
  }

  // --- 3. LOGIC NẠP THƯƠNG HIỆU CHO MODAL THÊM ---
  const typeSelectAdd = document.getElementById("modal-product-type");
  const brandSelectAdd = document.getElementById("modal-product-brand");
  const profitInputAdd = document.getElementById("modal-product-profit-margin");

  if (typeSelectAdd && brandSelectAdd) {
    typeSelectAdd.addEventListener("change", function () {
      // Khi đổi loại, đi lấy Brand tương ứng
      fetch(
        `forms/danhmucsanpham/ajax_handle_products.php?action=get_brands_by_category&category_name=${this.value}`,
      )
        .then((res) => res.json())
        .then((brands) => {
          brandSelectAdd.innerHTML =
            '<option value="" selected disabled>-- Chọn thương hiệu --</option>' +
            brands
              .map(
                (b) =>
                  `<option value="${b.id}" data-profit="${b.profit_margin}">${b.brand_name}</option>`,
              )
              .join("");
          if (profitInputAdd) profitInputAdd.value = ""; // Reset lợi nhuận
        });
    });

    // Tự động điền % lợi nhuận mặc định khi chọn thương hiệu
    brandSelectAdd.addEventListener("change", function () {
      const selected = this.options[this.selectedIndex];
      if (profitInputAdd) profitInputAdd.value = selected?.dataset.profit || "";
    });
  }

  // --- HÀM VẼ PREVIEW ẢNH TRONG MODAL THÊM ---
  function renderAddPreviews() {
    const container = document.getElementById("image-preview-container");
    if (!container) return;
    container.innerHTML = ""; // Xóa các preview cũ để vẽ mới

    Array.from(addDataStorage.files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = (e) => {
        const div = document.createElement("div");
        div.className = "preview-item new-img";
        div.style.position = "relative";
        div.innerHTML = `
            <img src="${e.target.result}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
            <button type="button" class="remove-img-btn bg-danger text-white rounded-circle position-absolute" 
                    style="top: -5px; right: -5px; width: 20px; height: 20px; border: none; font-size: 12px; cursor: pointer;">&times;</button>
        `;
        // Xử lý nút xóa ảnh lẻ ngay khi đang thêm
        div.querySelector(".remove-img-btn").onclick = () => {
          const newData = new DataTransfer();
          Array.from(addDataStorage.files).forEach((f, i) => {
            if (i !== index) newData.items.add(f);
          });
          addDataStorage = newData;
          document.getElementById("product-images-upload").files =
            addDataStorage.files;
          renderAddPreviews();
        };
        container.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }
  // --- 4. HÀM VẼ PREVIEW ẢNH TRONG MODAL SỬA ---
  function renderEditPreviews() {
    const container = document.getElementById("edit-preview-container");
    if (!container) return;
    container.innerHTML = "";

    currentImagesToKeep.forEach((fileName, index) => {
      const div = document.createElement("div");
      div.className = "preview-item existing-img";
      div.style.position = "relative";
      div.innerHTML = `
                <img src="${currentBasePath}${fileName}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                <button type="button" class="remove-img-btn bg-danger text-white rounded-circle position-absolute" style="top: -5px; right: -5px; width: 20px; height: 20px; border: none; font-size: 12px; cursor: pointer;">&times;</button>
                <span class="badge bg-dark position-absolute bottom-0 start-0 w-100 opacity-75" style="font-size: 9px;">Ảnh cũ</span>
            `;
      div.querySelector(".remove-img-btn").onclick = () => {
        currentImagesToKeep.splice(index, 1);
        document.getElementById("current-images-to-keep-input").value =
          currentImagesToKeep.join(",");
        renderEditPreviews();
      };
      container.appendChild(div);
    });

    Array.from(editDataStorage.files).forEach((file, index) => {
      const reader = new FileReader();
      reader.onload = (e) => {
        const div = document.createElement("div");
        div.className = "preview-item new-img";
        div.style.position = "relative";
        div.innerHTML = `
                    <img src="${e.target.result}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                    <button type="button" class="remove-img-btn bg-warning text-dark rounded-circle position-absolute" style="top: -5px; right: -5px; width: 20px; height: 20px; border: none; font-size: 12px; cursor: pointer;">&times;</button>
                    <span class="badge bg-info position-absolute bottom-0 start-0 w-100 opacity-75 text-dark" style="font-size: 9px;">Mới</span>
                `;
        div.querySelector(".remove-img-btn").onclick = () => {
          const newData = new DataTransfer();
          Array.from(editDataStorage.files).forEach((f, i) => {
            if (i !== index) newData.items.add(f);
          });
          editDataStorage = newData;
          document.getElementById("edit-images-upload").files =
            editDataStorage.files;
          renderEditPreviews();
        };
        container.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }

  // --- 5. NẠP DỮ LIỆU KHI BẤM NÚT SỬA ---
  function attachActionButtonsEvents() {
    document.querySelectorAll(".edit-product-btn").forEach((btn) => {
      btn.onclick = function () {
        const productId = this.dataset.id;
        Swal.fire({ title: "Đang tải...", didOpen: () => Swal.showLoading() });

        fetch(
          `forms/danhmucsanpham/ajax_handle_products.php?action=get_product_detail&id=${productId}`,
        )
          .then((res) => res.json())
          .then((p) => {
            Swal.close();
            document.getElementById("edit-product-id").value = p.id;
            document.getElementById("edit-product-name").value = p.product_name;
            document.getElementById("edit-product-type").value = p.category_id; // SỬA TẠI ĐÂY
            document.getElementById("edit-product-summary").value =
              p.summary_description;
            document.getElementById("edit-product-overview").value =
              p.detailed_overview;
            document.getElementById("edit-product-profit-margin").value =
              p.profit_margin;
            document.getElementById("edit-product-discount").value =
              p.discount_percent;
            document.getElementById("edit-product-accessories").value =
              p.accessories_text || "";

            // Nạp Điểm nổi bật
            for (let i = 1; i <= 4; i++) {
              document.getElementById(`edit-h${i}_t`).value =
                p[`highlight_${i}_title`] || "";
              document.getElementById(`edit-h${i}_c`).value =
                p[`highlight_${i}_content`] || "";
            }

            // Quan trọng: Nạp brand đúng cho Modal Sửa
            loadBrandsForEdit(p.category_id, p.brand_id); // SỬA TẠI ĐÂY

            currentBasePath = p.base_path;
            currentImagesToKeep = p.product_images
              ? p.product_images
                  .split(",")
                  .map((s) => s.trim())
                  .filter((s) => s !== "")
              : [];
            editDataStorage = new DataTransfer();
            document.getElementById("edit-images-upload").value = "";

            let keepInput = document.getElementById(
              "current-images-to-keep-input",
            );
            if (!keepInput) {
              keepInput = document.createElement("input");
              keepInput.type = "hidden";
              keepInput.name = "images_to_keep";
              keepInput.id = "current-images-to-keep-input";
              document
                .getElementById("edit-product-form")
                .appendChild(keepInput);
            }
            // Gửi dưới dạng chuỗi JSON để PHP đọc được chính xác mảng
            keepInput.value = JSON.stringify(currentImagesToKeep);

            renderEditPreviews();
            editModal.style.display = "block";
          });
      };
    });

    // XỬ LÝ NÚT ẨN/HIỆN SẢN PHẨM
    document.querySelectorAll(".hide-btn").forEach((btn) => {
      btn.onclick = function () {
        const productId = this.dataset.id;

        fetch("forms/danhmucsanpham/ajax_handle_products.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          // SỬA TẠI ĐÂY: Phải dùng dấu backtick (phím dưới nút Esc) để truyền biến ${productId}
          body: `action=toggle_status&id=${productId}`,
        })
          .then((res) => res.text())
          .then((data) => {
            if (data.trim() === "success") {
              fetchProductList(); // Tải lại bảng để cập nhật icon mới
              Toast.fire({
                icon: "success",
                title: "Đã cập nhật trạng thái hiển thị!",
              });
            } else {
              Swal.fire("Lỗi", data, "error");
            }
          });
      };
    });

    // XỬ LÝ NÚT XÓA SẢN PHẨM
    document.querySelectorAll(".delete-product-btn").forEach((btn) => {
      btn.onclick = function () {
        const productId = this.dataset.id;

        Swal.fire({
          title: "Huy có chắc chắn không?",
          text: "Sản phẩm và toàn bộ thư mục ảnh sẽ bị xóa vĩnh viễn!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Đúng, xóa nó!",
          cancelButtonText: "Hủy bỏ",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "Đang xóa...",
              didOpen: () => Swal.showLoading(),
            });

            // Gửi lệnh xóa lên Server
            // admin.js - Phần xử lý nút Xóa
            fetch("forms/danhmucsanpham/ajax_handle_products.php", {
              method: "POST",
              headers: { "Content-Type": "application/x-www-form-urlencoded" },
              body: `action=delete_product&id=${productId}`,
            })
              .then((res) => res.text())
              .then((data) => {
                Swal.close();
                const response = data.trim();

                if (response === "delete_success") {
                  Swal.fire(
                    "Đã xóa!",
                    "Sản phẩm chưa có giao dịch nên đã được xóa vĩnh viễn.",
                    "success",
                  );
                  fetchProductList();
                } else if (response === "hidden_success") {
                  Swal.fire({
                    title: "Thông báo",
                    text: "Sản phẩm này đã có lịch sử nhập hàng/bán hàng nên hệ thống đã tự động chuyển sang trạng thái ẨN để bảo toàn dữ liệu.",
                    icon: "info",
                  });
                  fetchProductList(); // Cập nhật lại bảng để hiện icon mắt gạch chéo
                } else {
                  Swal.fire("Lỗi", data, "error");
                }
              });
          }
        });
      };
    });
  }

  // --- 6. SỰ KIỆN SUBMIT (THÊM & SỬA) ---
  document
    .getElementById("add-product-form")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();
      Swal.fire({ title: "Đang lưu...", didOpen: () => Swal.showLoading() });
      let formData = new FormData(this);
      formData.append("action", "add_product");
      fetch("forms/danhmucsanpham/ajax_handle_products.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.text())
        .then((data) => {
          Swal.close();
          if (data.trim() === "success") {
            Swal.fire("Thành công", "Đã thêm sản phẩm!", "success");
            addModal.style.display = "none";
            this.reset();
            addDataStorage = new DataTransfer(); // Reset kho chứa ảnh
            document.getElementById("image-preview-container").innerHTML = ""; // Xóa preview
            fetchProductList(1);
          } else {
            Swal.fire("Lỗi", data, "error");
          }
        });
    });

  // --- 6. LƯU THAY ĐỔI (SUBMIT EDIT - BẢN SỬA LỖI NHÂN BẢN ẢNH) ---
  document
    .getElementById("edit-product-form")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Đang cập nhật...",
        didOpen: () => Swal.showLoading(),
      });

      let formData = new FormData(this);
      formData.append("action", "update_product");

      // TUYỆT ĐỐI KHÔNG append thêm product_images[] ở đây nữa
      // Vì lệnh new FormData(this) đã lấy ảnh từ input (đã được đồng bộ qua DataTransfer) rồi.

      fetch("forms/danhmucsanpham/ajax_handle_products.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.text())
        .then((data) => {
          Swal.close();
          if (data.trim() === "success") {
            Swal.fire("Thành công", "Thông tin đã được cập nhật!", "success");
            editModal.style.display = "none";
            fetchProductList(1);
          } else {
            Swal.fire("Lỗi", data, "error");
          }
        });
    });

  // --- 7. SỰ KIỆN THAY ĐỔI LOẠI Ở MODAL SỬA ---
  document
    .getElementById("edit-product-type")
    ?.addEventListener("change", function () {
      loadBrandsForEdit(this.value, null);
    });

  // --- 8. MỞ/ĐÓNG MODAL & CHỌN ẢNH ---
  document.getElementById("open-add-product")?.addEventListener("click", () => {
    addModal.style.display = "block";
  });
  document
    .querySelectorAll(
      ".close-button, #cancel-add-product, #cancel-edit-product, #close-edit-modal",
    )
    .forEach((btn) => {
      btn.onclick = () => {
        if (addModal) addModal.style.display = "none";
        if (editModal) editModal.style.display = "none";
      };
    });

  // --- 8.1 XỬ LÝ CHỌN ẢNH Ở MODAL THÊM (BẢN FIX) ---
  document
    .getElementById("product-images-upload")
    ?.addEventListener("change", function () {
      const files = Array.from(this.files);

      // Kiểm tra: Số ảnh đã chọn trước đó + số ảnh mới chọn có > 6 không
      if (addDataStorage.files.length + files.length > 6) {
        Swal.fire(
          "Thông báo",
          `Huy ơi, tối đa chỉ được 6 ảnh thôi! Bạn còn chọn thêm được ${6 - addDataStorage.files.length} tấm nữa.`,
          "warning",
        );
        this.files = addDataStorage.files; // Ép input quay về danh sách hợp lệ cũ
        return;
      }

      // Nếu hợp lệ thì nạp thêm vào storage
      files.forEach((f) => addDataStorage.items.add(f));
      this.files = addDataStorage.files; // Đồng bộ ngược lại input
      renderAddPreviews(); // Giờ thì hàm này đã chạy được rồi!
    });

  // xử lí chỉ cho upload tối đa 6 ảnh
  document
    .getElementById("edit-images-upload")
    ?.addEventListener("change", function () {
      const files = Array.from(this.files);
      const totalNow =
        currentImagesToKeep.length + editDataStorage.files.length;
      if (totalNow + files.length > 6) {
        Swal.fire(
          "Thông báo",
          `Tổng ảnh không quá 6! Bạn còn thêm được ${6 - totalNow} tấm.`,
          "warning",
        );
        this.files = editDataStorage.files;
        return;
      }
      files.forEach((f) => editDataStorage.items.add(f));
      this.files = editDataStorage.files;
      renderEditPreviews();
    });

  // --- 9. SỰ KIỆN BỘ LỌC (PHÂN LOẠI & THƯƠNG HIỆU) ---
  const filterType = document.getElementById("filter-product-type");
  const filterBrand = document.getElementById("filter-product-brand");
  const filterDiscount = document.getElementById("filter-product-discount");

  if (filterDiscount) {
    filterDiscount.addEventListener("change", function () {
      fetchProductList(1); // Tải lại trang 1 với điều kiện mới
    });
  }
  if (filterType && filterBrand) {
    // Khi đổi Loại sản phẩm ở bộ lọc
    filterType.addEventListener("change", function () {
      if (!this.value) {
        filterBrand.innerHTML =
          '<option value="">-- Tất cả thương hiệu --</option>';
        fetchProductList(1); // Tải lại toàn bộ
        return;
      }
      // Tải danh sách thương hiệu tương ứng cho bộ lọc
      fetch(
        `forms/danhmucsanpham/ajax_handle_products.php?action=get_brands_by_category&category_name=${this.value}`,
      )
        .then((res) => res.json())
        .then((brands) => {
          filterBrand.innerHTML =
            '<option value="">-- Tất cả thương hiệu --</option>' +
            brands
              .map((b) => `<option value="${b.id}">${b.brand_name}</option>`)
              .join("");
          fetchProductList(1); // Chạy bộ lọc ngay
        });
    });

    // Khi đổi Thương hiệu ở bộ lọc
    filterBrand.addEventListener("change", () => fetchProductList(1));
  }

  // --- 10. SỰ KIỆN TÌM KIẾM ---
  const searchForm = document.querySelector(".search-container");
  const searchInput = document.getElementById("search-input");

  if (searchForm && searchInput) {
    // 1. Tìm kiếm khi bấm nút hoặc nhấn Enter
    searchForm.addEventListener("submit", function (e) {
      e.preventDefault();
      fetchProductList(1);
    });

    // 2. Tìm kiếm "nóng" (vừa gõ vừa tìm) - Huy thêm đoạn này vào nhé
    searchInput.addEventListener("input", function () {
      // Chỉ tìm kiếm khi Huy dừng gõ khoảng 300ms để tránh gửi quá nhiều yêu cầu (Debounce)
      clearTimeout(this.delayTimer);
      this.delayTimer = setTimeout(function () {
        fetchProductList(1);
      }, 300);
    });
  }

  // --- 11. SỰ KIỆN BẤM PHÂN TRANG ---
  const paginationUl = document.querySelector("#category-pagination ul");
  if (paginationUl) {
    paginationUl.addEventListener("click", function (e) {
      const link = e.target.closest("a");
      if (link && link.dataset.page) {
        e.preventDefault();
        fetchProductList(link.dataset.page); // Chuyển trang
      }
    });
  }

  if (document.body.classList.contains("manage-products-page")) {
      fetchProductList(1);
  }
});

// Hàm hỗ trợ nạp Brand cho Modal Sửa
// Đổi tham số thành categoryId cho dễ hiểu
function loadBrandsForEdit(categoryId, selectedBrandId) {
  const brandEditSelect = document.getElementById("edit-product-brand");
  if (!brandEditSelect) return;

  // Gọi AJAX với ID phân loại
  fetch(
    `forms/danhmucsanpham/ajax_handle_products.php?action=get_brands_by_category&category_name=${categoryId}`,
  )
    .then((res) => res.json())
    .then((brands) => {
      brandEditSelect.innerHTML =
        '<option value="">-- Chọn thương hiệu --</option>' +
        brands
          .map(
            (b) =>
              `<option value="${b.id}" data-profit="${b.profit_margin}" ${b.id == selectedBrandId ? "selected" : ""}>${b.brand_name}</option>`,
          )
          .join("");
    });
}



/* ==========================================================
   QUẢN LÝ TỒN KHO: TÌM KIẾM NÓNG & BỘ LỌC TỰ ĐỘNG
   ========================================================== */
document.addEventListener("DOMContentLoaded", function () {
  // Kiểm tra nếu đang ở đúng trang Tồn kho mới chạy logic này
  if (document.body.classList.contains("inventory-page")) {
    const inventoryForm = document.getElementById("inventory-filter-form");
    const searchInput = document.getElementById("inventory-search-input");
    const dateInput = document.getElementById("inventory-filter-date");
    const statusSelect = document.getElementById("inventory-status-select");

    if (inventoryForm) {
      // 1. Tự động tra cứu khi thay đổi Ngày hoặc Tình trạng
      [dateInput, statusSelect].forEach((element) => {
        if (element) {
          element.addEventListener("change", function () {
            inventoryForm.submit();
          });
        }
      });

      
      // 2. TÌM KIẾM NÓNG: Vừa gõ vừa hiện (Debounce 500ms)
      let typingTimer;
      if (searchInput) {
        searchInput.addEventListener("input", function () {
          clearTimeout(typingTimer);
          typingTimer = setTimeout(() => {
            inventoryForm.submit();
          }, 500); // Chờ nửa giây sau khi ngừng gõ mới load lại trang
        });

        // Đưa con trỏ xuống cuối văn bản để trải nghiệm gõ không bị ngắt quãng
        const currentVal = searchInput.value;
        searchInput.focus();
        searchInput.value = '';
        searchInput.value = currentVal;
      }
    }
  }
});

/* ==========================================================
   CHUYÊN MỤC QUẢN LÝ TỒN KHO - AJAX FULL LOGIC (HUY)
   ========================================================== */
document.addEventListener("DOMContentLoaded", function () {
    // Chỉ chạy logic này khi trình duyệt thấy class 'inventory-page' ở body
    if (!document.body.classList.contains("inventory-page")) return;

    const inv_TableBody = document.getElementById("stock-list-container");
    const inv_Pagination = document.querySelector("#category-pagination ul");
    const inv_Search = document.getElementById("search-input");
    const inv_Date = document.getElementById("filter-date");
    const inv_Status = document.getElementById("sort-order");
    const inv_Threshold = document.getElementById("warning-threshold"); // Thêm dòng này
    let inv_debounceTimer;

    // 1. Hàm chính để tải dữ liệu qua AJAX
    function fetchInventoryAjax(page = 1) {
        const dateVal = inv_Date.value;
        const searchVal = inv_Search.value;
        const statusVal = inv_Status.value;
        const thresholdVal = inv_Threshold.value || 5; // Lấy ngưỡng, mặc định là 5

        // Hiện hiệu ứng đang tải cho Huy nhìn cho chuyên nghiệp
        inv_TableBody.innerHTML = '<tr><td colspan="7" class="text-center">Đang tính toán tồn kho...</td></tr>';

        // Gọi đến file xử lý AJAX mà mình đã tạo ở bước trước
        const url = `forms/quanlytonkho/ajax_handle_inventory.php?action=fetch_inventory&date=${dateVal}&search=${encodeURIComponent(searchVal)}&status=${statusVal}&threshold=${thresholdVal}&page=${page}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                inv_TableBody.innerHTML = data.table; // Dán bảng mới vào
                inv_Pagination.innerHTML = data.pagination; // Dán phân trang mới vào
            })
            .catch(err => {
                console.error("Lỗi AJAX Tồn kho:", err);
                inv_TableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Lỗi kết nối máy chủ!</td></tr>';
            });
    }
    // Gán sự kiện cho ô ngưỡng cảnh báo
    inv_Threshold.addEventListener("change", () => fetchInventoryAjax(1));
    inv_Threshold.addEventListener("input", () => {
        clearTimeout(inv_debounceTimer);
        inv_debounceTimer = setTimeout(() => fetchInventoryAjax(1), 500);
    });
    // 2. TÌM KIẾM NÓNG (Vừa gõ vừa hiện)
    inv_Search.addEventListener("input", function() {
        clearTimeout(inv_debounceTimer);
        // Chờ 500ms sau khi Huy ngừng gõ mới load để tránh lag máy
        inv_debounceTimer = setTimeout(() => {
            fetchInventoryAjax(1); 
        }, 500);
    });

    // 3. BỘ LỌC TỰ ĐỘNG (Ngày & Trạng thái)
    [inv_Date, inv_Status].forEach(el => {
        el.addEventListener("change", () => fetchInventoryAjax(1));
    });

    // 4. PHÂN TRANG AJAX (Bấm số trang không load lại page)
    inv_Pagination.addEventListener("click", function(e) {
        const link = e.target.closest("a");
        if (link && link.getAttribute("data-page")) {
            e.preventDefault();
            const targetPage = link.getAttribute("data-page");
            fetchInventoryAjax(targetPage);
            window.scrollTo({ top: 0, behavior: 'smooth' }); // Cuộn lên đầu bảng cho dễ nhìn
        }
    });

    // 5. Chạy lần đầu tiên khi vừa mở trang (Mặc định trang 1)
    fetchInventoryAjax(1);
});