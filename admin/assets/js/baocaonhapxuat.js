/* ==========================================================
   LOGIC RÀNG BUỘC NGÀY THÁNG CHO BÁO CÁO NHẬP XUẤT
   ========================================================== */
document.addEventListener("DOMContentLoaded", function () {
  const startDateInput = document.getElementById("report_start");
  const endDateInput = document.getElementById("report_end");
  const reportForm = document.getElementById("io-report-form");

  if (startDateInput && endDateInput) {
    // 1. Khi thay đổi Ngày bắt đầu: Cập nhật 'min' của Ngày kết thúc
    startDateInput.addEventListener("change", function () {
      if (this.value) {
        endDateInput.min = this.value;
      }
    });

    // 2. Khi thay đổi Ngày kết thúc: Cập nhật 'max' của Ngày bắt đầu
    endDateInput.addEventListener("change", function () {
      if (this.value) {
        startDateInput.max = this.value;
      }
    });

    // 3. Khởi tạo giá trị giới hạn ngay khi load trang
    if (startDateInput.value) endDateInput.min = startDateInput.value;
    if (endDateInput.value) startDateInput.max = endDateInput.value;

    // 4. Kiểm tra cuối cùng trước khi submit (Phòng trường hợp nhập tay)
    if (reportForm) {
      reportForm.addEventListener("submit", function (e) {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);

        if (start > end) {
          e.preventDefault(); // Chặn gửi form
          Swal.fire({
            icon: "error",
            title: "Ngày không hợp lệ",
            text: "Ngày bắt đầu không thể lớn hơn ngày kết thúc!",
          });
        }
      });
    }
  }
});