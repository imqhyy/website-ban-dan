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
  let currentProductPage = 1;
  function fetchProductList(page = 1) {
    currentProductPage = page;
    const type = document.getElementById("filter-product-type")?.value || ""; // Giờ là ID số
    const brand = document.getElementById("filter-product-brand")?.value || "";
    const discountSelect = document.getElementById("filter-product-discount");
    const discount = discountSelect ? discountSelect.value : ""; // Đảm bảo lấy đúng value
    const search = document.getElementById("search-input")?.value || "";

    // Gửi yêu cầu lên server, dùng category_id (hoặc giữ key product_type nhưng giá trị là ID)
    console.log(
      `Đang lọc: Type=${type}, Brand=${brand}, Discount=${discount}, Page=${page}`,
    );

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
            // 1. Điền các thông tin cơ bản
            document.getElementById("edit-product-id").value = p.id;
            document.getElementById("edit-product-name").value = p.product_name;

            // 2. CHỌN PHÂN LOẠI: Gán ID phân loại từ database vào select
            // Lưu ý: Select này trong HTML phải được đổ dữ liệu bằng PHP trước (như mình đã hướng dẫn ở câu trước)
            document.getElementById("edit-product-type").value = p.category_id;

            // 3. CHỌN THƯƠNG HIỆU: Gọi hàm nạp Brand theo Category vừa chọn
            // Chúng ta truyền p.category_id để biết lấy Brand của loại nào,
            // và p.brand_id để hàm biết cần "selected" vào cái nào.
            loadBrandsForEdit(p.category_id, p.brand_id);
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
              fetchProductList(currentProductPage); // Tải lại bảng để cập nhật icon mới
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
                  fetchProductList(currentProductPage);
                } else if (response === "hidden_success") {
                  Swal.fire({
                    title: "Thông báo",
                    text: "Sản phẩm này đã có lịch sử nhập hàng/bán hàng nên hệ thống đã tự động chuyển sang trạng thái ẨN để bảo toàn dữ liệu.",
                    icon: "info",
                  });
                  fetchProductList(currentProductPage); // Cập nhật lại bảng để hiện icon mắt gạch chéo
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
            fetchProductList(currentProductPage);
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
            fetchProductList(currentProductPage);
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
        // 1. Gọi hàm tải dữ liệu trang mới
        fetchProductList(link.dataset.page);

        // 2. Thêm đoạn cuộn mượt về đầu khu vực quản lý
        const tableContainer = document.querySelector(
          ".container-manage-import-products",
        );
        if (tableContainer) {
          tableContainer.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }
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
