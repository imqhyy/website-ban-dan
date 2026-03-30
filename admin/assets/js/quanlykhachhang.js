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

const LOCK_REASONS = [
  "Vi phạm điều khoản sử dụng",
  "Nghi ngờ gian lận / lừa đảo",
  "Spam đơn hàng",
  "Tạm khóa theo yêu cầu của chủ tài khoản",
  "Đẹp trai hơn chủ shop",
];

// Mở modal chi tiết
function openDetail(data) {
  document.getElementById("modalImage").src = data.avatar;
  document.getElementById("modalUsername").textContent = data.username;
  document.getElementById("modalName").textContent = data.fullname;
  document.getElementById("modalPhone").textContent = data.phone;
  document.getElementById("modalEmail").textContent = data.email;
  document.getElementById("modalCreatedAt").textContent = data.created_at;
  document.getElementById("modalAddress").textContent =
    data.address || "Chưa cập nhật";

  const lockedRow = document.getElementById("modalLockedRow");
  if (data.is_locked && data.locked_reason) {
    document.getElementById("modalLockedReason").textContent =
      data.locked_reason;
    lockedRow.style.display = "block";
  } else {
    lockedRow.style.display = "none";
  }

  document.getElementById("DetailModal").style.display = "flex";
}

window.addEventListener("click", function (e) {
  const modal = document.getElementById("DetailModal");
  if (e.target === modal) modal.style.display = "none";
});

function resetPassword(email) {
  Swal.fire({
    icon: "success",
    title: "Đã gửi!",
    text: `Link đặt lại mật khẩu đã được gửi đến email ${email}`,
    timer: 1500,
    showConfirmButton: false,
  });
}

function toggleLock(button) {
  const userId = button.getAttribute("data-user-id");
  const isLocked = button.getAttribute("data-is-locked") === "1";

  if (isLocked) {
    // Mở khóa — confirm trước
    Swal.fire({
      title: "Mở khóa tài khoản?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Đồng ý, mở khóa",
      cancelButtonText: "Hủy",
      confirmButtonColor: "#28a745",
    }).then((result) => {
      if (!result.isConfirmed) return;
      sendLockRequest(userId, "unlock", "", button);
    });
  } else {
    // Khóa — chọn lý do
    const options = LOCK_REASONS.map(
      (r, i) => `<option value="${r}">${r}</option>`,
    ).join("");

    Swal.fire({
      title: "Chọn lý do khóa",
      html: `<select id="swal-reason" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;font-size:14px;box-sizing:border-box;display:block;">
                   <option value="">-- Chọn lý do --</option>
                   ${options}
                 </select>`,
      width: 420,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Khóa",
      cancelButtonText: "Hủy",
      confirmButtonColor: "#d33",
      preConfirm: () => {
        const reason = document.getElementById("swal-reason").value;
        if (!reason) {
          Swal.showValidationMessage("Vui lòng chọn lý do!");
          return false;
        }
        return reason;
      },
    }).then((result) => {
      if (!result.isConfirmed) return;
      sendLockRequest(userId, "lock", result.value, button);
    });
  }
}

function sendLockRequest(userId, action, reason, button) {
  const formData = new FormData();
  formData.append("user_id", userId);
  formData.append("action", action);
  formData.append("reason", reason);

  fetch("admin_quanlykhachhang.php", { method: "POST", body: formData })
    .then((r) => r.json())
    .then((data) => {
      if (data.status === "success") {
        Toast.fire({ icon: "success", title: data.message });
        // Cập nhật nút
        if (action === "lock") {
          button.textContent = "Mở khóa";
          button.classList.replace("btn-success", "btn-warning");
          button.setAttribute("data-is-locked", "1");
        } else {
          button.textContent = "Khóa Tài khoản";
          button.classList.replace("btn-warning", "btn-success");
          button.setAttribute("data-is-locked", "0");
        }
      } else {
        Toast.fire({ icon: "error", title: data.message });
      }
    })
    .catch(() => Toast.fire({ icon: "error", title: "Có lỗi xảy ra!" }));
}
