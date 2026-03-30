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

      // HIỆN MODAL
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
    });
  });
}


/* --- BỘ XỬ LÝ ĐÓNG MODAL TẬP TRUNG --- */
window.addEventListener("click", function(event) {
    // Danh sách tất cả các ID modal bạn đang có
    const modalIds = [
        "edit-info-category",
        "edit-brands-modal",
        "edit-info-brand",
        "DetailModal" // Nếu có dùng cho quản lý khách hàng
    ];

    modalIds.forEach(id => {
        const modal = document.getElementById(id);
        // Nếu click trúng chính cái nền đen (modal) thì ẩn nó đi
        if (modal && event.target === modal) {
            modal.style.display = "none";
        }
    });
});