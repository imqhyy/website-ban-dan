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

  // Tìm hoặc tạo hộp gợi ý một cách an toàn
  const getSuggestionBox = () => {
    let box = productContainer.querySelector(".custom-suggestion-box");
    if (!box) {
      box = document.createElement("div");
      box.className = "custom-suggestion-box";
      // Đặt cha là relative để làm mốc tọa độ
      nameInput.parentNode.style.position = "relative";
      Object.assign(box.style, {
        position: "absolute",
        zIndex: "1000",
        background: "#fff",
        left: nameInput.offsetLeft + "px",
        top: nameInput.offsetTop + nameInput.offsetHeight + "px",
        width: nameInput.offsetWidth + "px",
        border: "1px solid #ddd",
        display: "none",
        maxHeight: "200px",
        overflowY: "auto",
      });
      nameInput.parentNode.style.position = "relative";
      nameInput.parentNode.appendChild(box);
    }
    return box;
  };

  const loadData = () => {
    const type = productContainer.querySelector(".manage-product-type").value;
    const brandId = productContainer.querySelector(
      ".manage-product-brands",
    ).value;
    const query = nameInput.value;

    if (!type || !brandId) return;

    fetch(
      `forms/quanlynhapsanpham/ajax_handle_import.php?action=get_product_suggestions&type=${encodeURIComponent(type)}&brand_id=${brandId}&query=${encodeURIComponent(query)}`,
    )
      .then((res) => res.json())
      .then((products) => {
        const suggestionBox = getSuggestionBox(); // Lấy box tại thời điểm có dữ liệu
        suggestionBox.innerHTML = products
          .map(
            (p) =>
              `<div class="sug-item" data-id="${p.id}" style="padding: 8px; cursor: pointer; border-bottom: 1px solid #eee;">${p.product_name}</div>`,
          )
          .join("");

        suggestionBox.style.display = products.length ? "block" : "none";

        suggestionBox.querySelectorAll(".sug-item").forEach((item) => {
          item.onclick = function () {
            nameInput.value = this.innerText;
            nameInput.dataset.id = this.getAttribute("data-id"); // Lưu ID để dùng khi lưu
            suggestionBox.style.display = "none";
          };
        });
      });
  };

  nameInput.onfocus = loadData;
  nameInput.oninput = function () {
    this.dataset.id = ""; // XÓA SẠCH ID ngay khi người dùng gõ bất kỳ phím nào
    loadData(); // Sau đó mới gọi hàm hiện gợi ý như bình thường
  };

  // Đóng menu khi click ra ngoài
  document.addEventListener("click", (e) => {
    const box = productContainer.querySelector(".custom-suggestion-box");
    if (box && !nameInput.contains(e.target) && !box.contains(e.target)) {
      box.style.display = "none";
    }
  });
}

function formatCurrency(value) {
  const rawNumber = value.toString().replace(/[^0-9]/g, "");
  if (rawNumber.length < 4) return rawNumber;
  return rawNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " VND";
}

function attachPriceFormatter(inputElement) {
  if (!inputElement) return;

  inputElement.addEventListener("input", function (e) {
    // 1. Lấy giá trị số thuần túy
    let value = this.value.replace(/[^0-9]/g, "");
    
    // 2. Nếu trống thì không hiển thị gì
    if (!value) {
      this.value = "";
      return;
    }

    // 3. Định dạng số với dấu chấm
    let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    
    // 4. Gán lại giá trị kèm đuôi VND
    this.value = formattedValue + " VND";

    // 5. Đưa con trỏ chuột về trước chữ " VND" để người dùng gõ tiếp không bị lỗi
    // (Khoảng cách là 4 ký tự tính từ cuối: " VND")
    const cursorPosition = this.value.length - 4;
    this.setSelectionRange(cursorPosition, cursorPosition);
  });

  // Chặn trường hợp người dùng click chuột vào sau chữ VND rồi gõ tiếp
  inputElement.addEventListener("click", function() {
    const cursorPosition = this.value.length - 4;
    if (this.selectionStart > cursorPosition) {
        this.setSelectionRange(cursorPosition, cursorPosition);
    }
  });

  // Khi xóa, nếu chạm vào chữ VND thì xóa luôn số cuối cùng
  inputElement.addEventListener("keydown", function(e) {
    if (e.key === "Backspace" || e.key === "Delete") {
        let value = this.value.replace(/[^0-9]/g, "");
        if (value.length > 0) {
            // Cho phép xóa bình thường bằng cách xử lý ở sự kiện 'input'
        }
    }
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

        // XÓA BỎ đoạn code liên quan đến datalist.id cũ ở đây vì đã dùng custom box

        // Reset giá trị các ô nhập
        newProductFields.querySelectorAll("input, select").forEach((el) => {
          if (el.tagName === "SELECT") el.selectedIndex = 0;
          else el.value = "";
        });

        const newPriceInput = newProductFields.querySelector(".unit-price-input");
        attachPriceFormatter(newPriceInput); // Thêm dòng này để dòng mới cũng tự format khi gõ

        // Xóa hộp gợi ý cũ của dòng bị clone (nếu có) để tạo cái mới sạch sẽ
        const oldBox = newProductFields.querySelector(".custom-suggestion-box");
        if (oldBox) oldBox.remove();

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
  // đã viết rồi ctrl F addProductButton là thấy

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
      // Duyệt qua từng dòng sản phẩm để thu thập dữ liệu
      document
        .querySelectorAll(".product-fields-template")
        .forEach((row, index) => {
          const nameInput = row.querySelector(".product-name-input");
          const qtyInput = row.querySelector('input[type="number"]');
          const priceInput = row.querySelector(".unit-price-input");

          if (nameInput.value.trim() !== "") {
            // LẤY TRỰC TIẾP ID từ dataset đã lưu khi bạn click chọn gợi ý
            const productId = nameInput.dataset.id;

            if (productId) {
              const qty = parseInt(qtyInput.value) || 0;
              const price =
                parseInt(priceInput.value.replace(/[^0-9]/g, "")) || 0;

              totalAll += qty * price;
              productCount++;

              formData.append(`products[${index}][id]`, productId);
              formData.append(`products[${index}][qty]`, qty);
              formData.append(`products[${index}][price]`, price);
            } else {
              // Trường hợp người dùng gõ tên bừa bãi mà không chọn từ danh sách gợi ý
              hasProductError = true;
            }
          }
        });

      if (productCount === 0) {
        Swal.fire("Lỗi", "Bạn chưa chọn sản phẩm!", "error");
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
            Swal.fire(
              "Thành công",
              "Đã lưu phiếu nhập thành công!",
              "success",
            ).then(() => {
              location.reload(); // Chỉ reload sau khi đã bấm nút OK trên thông báo
            });
            importModal.style.display = "none";
            resetImportForm();
          } else {
            Swal.fire("Lỗi Server", data, "error");
          }
        })
        .catch((err) => Swal.fire("Lỗi kết nối", err.message, "error"));
    });
  }
});






/* ==========================================================
   LOGIC XEM THÊM / THU GỌN SẢN PHẨM TRONG PHIẾU NHẬP
   ========================================================== */
document.addEventListener('click', function(e) {
    // Kiểm tra nếu click vào nút (hoặc icon bên trong nút) có class 'show-more-products'
    const btn = e.target.closest('.show-more-products');
    
    if (btn) {
        const tbody = btn.closest('tbody');
        const extraRows = tbody.querySelectorAll('.extra-product');
        const count = btn.getAttribute('data-count');
        
        // Kiểm tra trạng thái hiện tại (đang ẩn hay đang hiện)
        const isCollapsed = extraRows[0].classList.contains('d-none');

        // Bật/tắt class d-none cho tất cả các dòng sản phẩm bổ sung
        extraRows.forEach(row => row.classList.toggle('d-none'));

        // Cập nhật giao diện nút bấm
        if (isCollapsed) {
            btn.innerHTML = `<i class="bi bi-chevron-double-up"></i> Thu gọn`;
            btn.style.background = "#fff3cd"; // Đổi màu nhẹ khi mở ra để dễ phân biệt
        } else {
            btn.innerHTML = `<i class="bi bi-chevron-double-down"></i> Xem thêm ${count} sản phẩm khác`;
            btn.style.background = "#f8f9fa";
        }
    }
});





