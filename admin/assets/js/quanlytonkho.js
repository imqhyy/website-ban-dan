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
        searchInput.value = "";
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

    // Gọi đến file xử lý AJAX mà mình đã tạo ở bước trước
    const url = `forms/quanlytonkho/ajax_handle_inventory.php?action=fetch_inventory&date=${dateVal}&search=${encodeURIComponent(searchVal)}&status=${statusVal}&threshold=${thresholdVal}&page=${page}`;

    fetch(url)
      .then((res) => res.json())
      .then((data) => {
        inv_TableBody.innerHTML = data.table; // Dán bảng mới vào
        inv_Pagination.innerHTML = data.pagination; // Dán phân trang mới vào
      })
      .catch((err) => {
        console.error("Lỗi AJAX Tồn kho:", err);
        inv_TableBody.innerHTML =
          '<tr><td colspan="7" class="text-center text-danger">Lỗi kết nối máy chủ!</td></tr>';
      });
  }
  // Gán sự kiện cho ô ngưỡng cảnh báo
  inv_Threshold.addEventListener("change", () => fetchInventoryAjax(1));
  inv_Threshold.addEventListener("input", () => {
    clearTimeout(inv_debounceTimer);
    inv_debounceTimer = setTimeout(() => fetchInventoryAjax(1), 500);
  });
  // 2. TÌM KIẾM NÓNG (Vừa gõ vừa hiện)
  inv_Search.addEventListener("input", function () {
    clearTimeout(inv_debounceTimer);
    // Chờ 500ms sau khi Huy ngừng gõ mới load để tránh lag máy
    inv_debounceTimer = setTimeout(() => {
      fetchInventoryAjax(1);
    }, 500);
  });

  // 3. BỘ LỌC TỰ ĐỘNG (Ngày & Trạng thái)
  [inv_Date, inv_Status].forEach((el) => {
    el.addEventListener("change", () => fetchInventoryAjax(1));
  });

  // 4. PHÂN TRANG AJAX (Bấm số trang không load lại page)
  inv_Pagination.addEventListener("click", function (e) {
    const link = e.target.closest("a");
    if (link && link.getAttribute("data-page")) {
      e.preventDefault();
      const targetPage = link.getAttribute("data-page");
      fetchInventoryAjax(targetPage);

      const tableContainer = document.querySelector(
        ".container-manage-import-products",
      );
      if (tableContainer) {
        tableContainer.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    }
  });

  /* --- QUẢN LÝ TỒN KHO - LƯU NGƯỠNG CẢNH BÁO & TẢI LẠI BẢNG --- */
  /* --- QUẢN LÝ TỒN KHO - LƯU NGƯỠNG VÀO DATABASE --- */
  if (inv_Threshold) {
    inv_Threshold.addEventListener("change", function () {
      const newThreshold = this.value;

      // SỬA TẠI ĐÂY:
      // 1. Đổi đường dẫn cho đúng file chứa code xử lý
      // 2. Đưa action lên URL để PHP dùng $_GET['action'] bắt được
      fetch(
        `forms/quanlytonkho/ajax_handle_inventory.php?action=update_threshold`,
        {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `value=${newThreshold}`, // Chỉ gửi value qua POST
        },
      )
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            // Sau khi lưu xong thì tải lại bảng để cập nhật màu sắc Badge
            fetchInventoryAjax(1);

            Toast.fire({
              icon: "success",
              title: "Đã lưu ngưỡng cảnh báo: " + newThreshold,
              timer: 1500,
            });
          } else {
            console.error("Lỗi server:", data.message);
          }
        })
        .catch((err) => console.error("Lỗi kết nối:", err));
    });
  }

  // 5. Chạy lần đầu tiên khi vừa mở trang (Mặc định trang 1)
  fetchInventoryAjax(1);
});
