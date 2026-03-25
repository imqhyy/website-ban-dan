const today = new Date();
const dd = String(today.getDate()).padStart(2, "0");
const mm = String(today.getMonth() + 1).padStart(2, "0"); // Tháng bắt đầu từ 0
const yyyy = today.getFullYear();
const currentDate = dd + "/" + mm + "/" + yyyy;

// Tìm các vị trí hiển thị ngày và gán ngày hôm nay vào
const orderDate1 = document.getElementById("order-date-1");
const orderDate2 = document.getElementById("order-date-2");
const orderDate3 = document.getElementById("order-date-3");

if (orderDate1) orderDate1.textContent = currentDate;
if (orderDate2) orderDate2.textContent = currentDate;
if (orderDate3) orderDate3.textContent = currentDate;
const sampleOrders = [
  {
    orderId: "DEMO-001",
    date: currentDate,
    total: 2000000,
    items: [
      {
        image:
          "assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg",
        name: "Saga A1 DE PRO",
        quantity: 1,
        price: 2000000,
      },
    ],
  },
  {
    orderId: "DEMO-002",
    date: currentDate,
    total: 5000000,
    items: [
      {
        image:
          "assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg",
        name: "Ba đờn C100",
        quantity: 1,
        price: 5000000,
      },
    ],
  },
  {
    orderId: "DEMO-003",
    date: currentDate,
    total: 85000000,
    items: [
      {
        image:
          "assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg",
        name: "Taylor A12E",
        quantity: 1,
        price: 85000000,
      },
    ],
  },
];
document.addEventListener("DOMContentLoaded", function () {
  const currentUserJSON = sessionStorage.getItem("currentUser");

  // if (currentUserJSON) {
  //   document.body.classList.remove("page-loading");
  // } else {
  //   Swal.fire({
  //     icon: "warning",
  //     title: "Yêu cầu đăng nhập",
  //     text: "Bạn cần đăng nhập để có thể xem hồ sơ.",
  //     confirmButtonText: "Đến trang đăng nhập",
  //     allowOutsideClick: false,
  //     customClass: {
  //       container: "blurred-login-alert", // Thêm class container riêng cho alert này
  //       popup: "my-swal-popup",
  //       title: "my-swal-title",
  //       htmlContainer: "my-swal-html-container",
  //       confirmButton: "my-swal-confirm-button",
  //     },
  //   }).then(() => {
  //     window.location.href = "login.php";
  //   });
  // }
  const currentUser = JSON.parse(currentUserJSON);

  // --- Lấy các phần tử HTML ---
  const userDisplayName = document.getElementById("user-display-name");
  const firstNameInput = document.getElementById("firstName");
  const lastNameInput = document.getElementById("lastName");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const settingsForm = document.getElementById("account-settings-form");
  const passwordUpdateForm = document.getElementById("password-update-form");
  const logoutLink = document.querySelector(".logout-link");

  // --- TỰ ĐỘNG THÊM @GMAIL.COM ---
  if (emailInput) {
    emailInput.addEventListener("blur", function () {
      const emailValue = emailInput.value;
      if (emailValue.length > 0 && !emailValue.includes("@")) {
        emailInput.value = emailValue + "@gmail.com";
      }
    });
  }

  // --- HIỂN THỊ LỊCH SỬ ĐƠN HÀNG ---
  // const ordersGrid = document.querySelector('#orders .orders-grid');
  // if (ordersGrid) {
  //     ordersGrid.innerHTML = '';

  //     const realOrders = currentUser.orders || [];
  //     const allOrdersToShow = realOrders.concat(sampleOrders);

  //     const orderBadge = document.querySelector('a[href="#orders"] .badge');
  //     if (orderBadge) {
  //         orderBadge.textContent = allOrdersToShow.length;
  //     }

  //     if (allOrdersToShow.length > 0) {
  //         allOrdersToShow.reverse().forEach(order => {
  //             const totalItems = order.items.reduce((sum, item) => sum + item.quantity, 0);
  //             let productItemsHTML = '';
  //             order.items.forEach(item => {
  //                 productItemsHTML += `
  //                 <div style="display: flex; align-items: center; margin-bottom: 10px; font-size: 14px;">
  //                     <img src="${item.image}" alt="${item.name}" style="width: 40px; height: 40px; border-radius: 4px; margin-right: 10px; object-fit: cover;">
  //                     <span style="flex: 1;">${item.name}</span>
  //                     <span style="color: #888; margin-left: 10px;">SL: ${item.quantity}</span>
  //                 </div>
  //             `;
  //             });
  //             const orderCardHTML = `
  //             <div class="order-card">
  //                 <div class="order-header">
  //                     <div class="order-id"><span class="label">Mã đơn hàng:</span> <span class="value">#${order.orderId}</span></div>
  //                     <div class="order-date">${order.date}</div>
  //                 </div>
  //                 <div class="order-content">
  //                     <div class="product-list-summary" style="padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px dashed #e0e0e0;">
  //                         ${productItemsHTML}
  //                     </div>
  //                     <div class="order-info">
  //                         <div class="info-row"><span>Trạng thái</span><span class="status delivered">Đã hoàn thành</span></div>
  //                         <div class="info-row"><span>Tổng số lượng</span><span>${totalItems} sản phẩm</span></div>
  //                         <div class="info-row"><span>Tổng cộng</span><span class="price">${order.total.toLocaleString('vi-VN')} VNĐ</span></div>
  //                     </div>
  //                 </div>
  //                 <div class="order-footer"><button type="button" class="btn-details">Xem chi tiết</button></div>
  //             </div>
  //             `;
  //             ordersGrid.innerHTML += orderCardHTML;
  //         });
  //     } else {
  //         ordersGrid.innerHTML = '<p class="text-center p-5">Bạn chưa có đơn hàng nào.</p>';
  //     }
  // }

  // --- XỬ LÝ LƯU THÔNG TIN CÁ NHÂN ---
  // if (settingsForm) {
  //   settingsForm.addEventListener("submit", function (event) {
  //     event.preventDefault();
  //     const newFirstName = firstNameInput.value;
  //     const newLastName = lastNameInput.value;
  //     const newFullName = (newFirstName + " " + newLastName).trim();
  //     const newEmail = emailInput.value;
  //     const newPhone = phoneInput.value;
  //     let allUsers = JSON.parse(localStorage.getItem("users")) || [];
  //     const userIndex = allUsers.findIndex(
  //       (user) => user.email === currentUser.email
  //     );
  //     if (userIndex !== -1) {
  //       allUsers[userIndex].fullName = newFullName;
  //       allUsers[userIndex].email = newEmail;
  //       allUsers[userIndex].phone = newPhone;
  //       localStorage.setItem("users", JSON.stringify(allUsers));
  //     }
  //     const updatedCurrentUser = {
  //       ...currentUser,
  //       fullName: newFullName,
  //       email: newEmail,
  //       phone: newPhone,
  //     };
  //     sessionStorage.setItem("currentUser", JSON.stringify(updatedCurrentUser));
  //     if (userDisplayName) userDisplayName.textContent = newFullName;
  //     Toast.fire({ icon: "success", title: "Cập nhật thông tin thành công!" });
  //   });
  // }

  // --- XỬ LÝ ĐỔI MẬT KHẨU ---
  if (passwordUpdateForm) {
    passwordUpdateForm.addEventListener("submit", function (event) {
      Toast.fire({ icon: "success", title: "Đổi mật khẩu thành công!" });
      passwordUpdateForm.reset();
      // event.preventDefault();
      // const currentPassword = document.getElementById('currentPassword').value;
      // const newPassword = document.getElementById('newPassword').value;
      // const confirmNewPassword = document.getElementById('confirmPassword').value;
      // if (currentPassword !== currentUser.password) { Toast.fire({ icon: 'error', title: 'Mật khẩu hiện tại không đúng!' }); return; }
      // if (!newPassword) { Toast.fire({ icon: 'error', title: 'Vui lòng nhập mật khẩu mới!' }); return; }
      // if (newPassword !== confirmNewPassword) { Toast.fire({ icon: 'error', title: 'Mật khẩu xác nhận không khớp!' }); return; }
      // let allUsers = JSON.parse(localStorage.getItem('users')) || [];
      // const userIndex = allUsers.findIndex(user => user.email === currentUser.email);
      // if (userIndex !== -1) {
      //     allUsers[userIndex].password = newPassword;
      //     localStorage.setItem('users', JSON.stringify(allUsers));
      //     currentUser.password = newPassword;
      //     sessionStorage.setItem('currentUser', JSON.stringify(currentUser));
      //     Toast.fire({ icon: 'success', title: 'Đổi mật khẩu thành công!' });
      //     passwordUpdateForm.reset();
      // }
    });
  }

  // --- XỬ LÝ NÚT ĐĂNG XUẤT ---
  if (logoutLink) {
    logoutLink.addEventListener("click", function (event) {
      event.preventDefault();
      sessionStorage.removeItem("currentUser");
      updateCartIcon(0); // Gọi hàm từ auth.js
      Toast.fire({ icon: "success", title: "Đăng xuất thành công!" }).then(
        () => {
          window.location.href = "index.php";
        },
      );
    });
  }
});

//né
// const deleteAccountButton = document.getElementById("delete-account");
// deleteAccountButton.addEventListener("click", function () {
//   // Dcm
//   let mouseX = 0;
//   let mouseY = 0;
//   let buttonX = 0;
//   let buttonY = 0;
//   const repulsionRadius = 108;
//   const stiffness = 0.15;

//   // Hàm theo dõi vị trí chuột
//   document.addEventListener("mousemove", function (e) {
//     mouseX = e.clientX;
//     mouseY = e.clientY;
//   });

//   // Hàm chính tính toán và di chuyển nút (chạy mượt mà)
//   function animateButton(cancelButton, containerRect) {
//     // Tính toán khoảng cách từ chuột đến tâm nút
//     const buttonRect = cancelButton.getBoundingClientRect();
//     const centerX = buttonRect.left + buttonRect.width / 2;
//     const centerY = buttonRect.top + buttonRect.height / 2;

//     const dx = mouseX - centerX;
//     const dy = mouseY - centerY;
//     const distance = Math.sqrt(dx * dx + dy * dy);
//     if (distance < repulsionRadius) {
//       const repulsionForce = (repulsionRadius - distance) / repulsionRadius;
//       const pushX = -dx * repulsionForce * stiffness;
//       const pushY = -dy * repulsionForce * stiffness;
//       buttonX += pushX;
//       buttonY += pushY;
//     }
//     cancelButton.style.transform = `translate(${buttonX}px, ${buttonY}px)`;
//     requestAnimationFrame(() => animateButton(cancelButton, containerRect));
//   }
//   Swal.fire({
//     icon: "warning",
//     title: "Ũa xao xó dị má!?",
//     text: "Bạn mà xoá là tui khóc huhu á :((",
//     showCancelButton: true,
//     confirmButtonColor: "#d33", // Đỏ cho hành động nguy hiểm
//     cancelButtonColor: "#3085d6",
//     confirmButtonText: "Tôi hiểu rõ, Xóa tài khoản!",
//     cancelButtonText: "Hủy bỏ",

//     didOpen: () => {
//       const cancelButton = Swal.getCancelButton();

//       if (cancelButton) {
//         cancelButton.style.position = "relative";
//         cancelButton.style.transition = "none";
//         const popup = Swal.getPopup();
//         const containerRect = popup.getBoundingClientRect();

//         // Khởi động vòng lặp animation
//         animateButton(cancelButton, containerRect);
//       }
//     },
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire({
//         icon: "success",
//         title: "- 1 thành viên tiềm năng!",
//         text: "Hẹn gặp lại bạn vào 1 ngày đẹp chời ^^. Đang chuyển hướng...",
//         showConfirmButton: false,
//         timer: 2000,
//       }).then((result) => {
//         window.location.href = "login.php";
//       });
//     }
//   });
// });
const deleteAccountButton = document.getElementById("delete-account");

if (deleteAccountButton) {
  // Thêm kiểm tra an toàn
  deleteAccountButton.addEventListener("click", function () {
    Swal.fire({
      icon: "warning",
      title: "Bạn có chắc chắn muốn xóa?",
      text: "Hành động này không thể hoàn tác. Toàn bộ dữ liệu của bạn sẽ bị xóa vĩnh viễn.",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Vâng, Xóa tài khoản!",
      cancelButtonText: "Hủy bỏ",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: "success",
          title: "Đã xóa tài khoản!", // Sửa thành văn bản nghiêm túc
          text: "Tài khoản của bạn đã được xóa. Đang chuyển hướng...", // Sửa thành văn bản nghiêm túc
          showConfirmButton: false,
          timer: 2000,
        }).then((result) => {
          window.location.href = "login.php";
        });
      }
    });
  });
}
//Dùng để khi click vào nút "đặt lại" trong đơn hàng nó sẽ nhảy sang trang checkout
// Lấy đối tượng nút bằng ID của nó
const button = document.getElementById("reorder-btn");

if (button) {
  // Thêm một hàm để thực thi khi nút được nhấn
  button.addEventListener("click", function () {
    // Thay đổi URL của cửa sổ hiện tại
    window.location.href = "checkout.php"; // Thay thế bằng đường dẫn trang bạn muốn
  });
}

// < !--script này dùng để tạo thông báo và thực hiện 1 số thao tác trong đánh giá đơn hàng-- >
document.addEventListener("DOMContentLoaded", function () {
  const ratingSelectors = document.querySelectorAll(".star-rating-selector");

  ratingSelectors.forEach((selector) => {
    const stars = selector.querySelectorAll(".star-icon");
    const input = selector.querySelector(".rating-input");
    const ratingText = selector.querySelector(".rating-text");

    const messages = {
      1: "Rất tệ",
      2: "Tệ",
      3: "Trung bình",
      4: "Tốt",
      5: "Rất tốt",
    };

    // Hàm cập nhật trạng thái các ngôi sao và input
    function updateRating(value) {
      stars.forEach((star) => {
        const starValue = parseInt(star.getAttribute("data-value"));
        if (starValue <= value) {
          star.classList.add("filled");
          star.classList.remove("bi-star");
          star.classList.add("bi-star-fill");
        } else {
          star.classList.remove("filled");
          star.classList.remove("bi-star-fill");
          star.classList.add("bi-star");
        }
      });
      input.value = value;
      ratingText.textContent =
        value > 0 ? `(${value}/5) - ${messages[value]}` : "";
    }

    // Khởi tạo ban đầu (ví dụ: 0 sao)
    updateRating(0);

    // Xử lý sự kiện click
    stars.forEach((star) => {
      star.addEventListener("click", function () {
        const value = parseInt(this.getAttribute("data-value"));
        updateRating(value);
      });
    });

    // Xử lý sự kiện hover (Rê chuột)
    selector.addEventListener("mouseover", function (e) {
      if (e.target.classList.contains("star-icon")) {
        const hoverValue = parseInt(e.target.getAttribute("data-value"));
        stars.forEach((star) => {
          const starValue = parseInt(star.getAttribute("data-value"));
          if (starValue <= hoverValue) {
            star.classList.add("filled");
            star.classList.remove("bi-star");
            star.classList.add("bi-star-fill");
          } else {
            star.classList.remove("filled");
            star.classList.remove("bi-star-fill");
            star.classList.add("bi-star");
          }
        });
        ratingText.textContent =
          hoverValue > 0 ? `(${hoverValue}/5) - ${messages[hoverValue]}` : "";
      }
    });

    // Xử lý sự kiện mouseout (Rời chuột)
    selector.addEventListener("mouseout", function () {
      const currentValue = parseInt(input.value);
      updateRating(currentValue);
    });
  });

  // Xử lý sự kiện click nút Gửi đánh giá (chỉ là demo, không có chức năng backend)
  document.querySelectorAll(".review-submit-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const itemContainer = this.closest(".review-product-item");
      const productId = itemContainer
        .querySelector(".star-rating-selector")
        .getAttribute("data-product-id");
      const rating = itemContainer.querySelector(".rating-input").value;
      const reviewText = itemContainer.querySelector("textarea").value;

      // *** LUÔN LUÔN THÔNG BÁO THÀNH CÔNG CHO MỤC ĐÍCH GIAO DIỆN ***

      // Lấy rating để hiển thị trong thông báo
      const displayRating = rating > 0 ? `${rating} sao` : "Chưa có sao";
      const productName = itemContainer.querySelector("h6").textContent;

      // SỬ DỤNG SWEETALERT2 CHO THÔNG BÁO THÀNH CÔNG
      Swal.fire({
        title: "Đánh giá thành công! 🎉",
        html: `Cảm ơn bạn đã đánh giá sản phẩm <strong>${productName}</strong>.`,
        icon: "success",
        confirmButtonText: "Tuyệt vời",
        customClass: {
          popup: "my-swal-popup",
          title: "my-swal-title",
          confirmButton: "my-swal-confirm-button",
          htmlContainer: "my-swal-html-container",
        },
      }).then(() => {
        // Ẩn form đánh giá sau khi người dùng nhấn nút xác nhận
        itemContainer.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        Đánh giá của bạn cho sản phẩm <strong>${productId}</strong> đã được gửi! Cảm ơn bạn.
                    </div>`;
      });
    });
  });
});

/*========================================= */
/* JS khi ấn vào nút tải lên nó sẽ kích hoạt chức năng input ảnh */
/* =========================================*/
document.addEventListener("DOMContentLoaded", function () {
  // 1. Lấy các phần tử cần thiết
  const uploadButton = document.getElementById("uploadAvatarButton");
  const fileInput = document.getElementById("profilePicture");
  const fileNameDisplay = document.getElementById("fileNameDisplay");

  // 2. Kích hoạt input file khi nhấn nút "Tải lên"
  uploadButton.addEventListener("click", function () {
    fileInput.click(); // Kích hoạt hành động chọn file
  });

  // 3. Kích hoạt input file khi nhấn vào ô hiển thị tên file (Cải thiện UX)
  fileNameDisplay.addEventListener("click", function () {
    fileInput.click();
  });

  // 4. Cập nhật tên file đã chọn vào ô hiển thị
  fileInput.addEventListener("change", function () {
    if (fileInput.files.length > 0) {
      // Hiển thị tên file đầu tiên được chọn
      fileNameDisplay.value = fileInput.files[0].name;
    } else {
      // Nếu không có file nào được chọn
      fileNameDisplay.value = "Chưa có tệp nào được chọn";
    }
  });
});

// --- XỬ LÝ LỌC & TÌM KIẾM ĐƠN HÀNG ---
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("order-search-input");
  const filterMenuItems = document.querySelectorAll(
    "#order-filter-menu .dropdown-item",
  );
  const orderCards = document.querySelectorAll(".orders-grid .order-card");

  function filterOrders() {
    const searchTerm = searchInput
      ? searchInput.value.toLowerCase().trim()
      : "";
    const activeFilter = document.querySelector(
      "#order-filter-menu .dropdown-item.active",
    );
    const statusFilter = activeFilter
      ? activeFilter.getAttribute("data-status")
      : "all";

    console.log("Đang lọc với filter:", { searchTerm, statusFilter });

    if (!orderCards || orderCards.length === 0) {
      console.log("Không tìm thấy thẻ đơn hàng nào để lọc!");
      return;
    }

    orderCards.forEach((card, index) => {
      const orderCode = card.getAttribute("data-order-code") || "";
      const orderStatus = card.getAttribute("data-status") || "";

      const matchSearch = orderCode.includes(searchTerm);
      const matchStatus =
        statusFilter === "all" || statusFilter === orderStatus;

      console.log(
        `Thẻ #${index} [Mã ${orderCode}]: data-status='${orderStatus}'. matchStatus=${matchStatus}, matchSearch=${matchSearch}`,
      );

      if (matchSearch && matchStatus) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  }

  if (searchInput) {
    searchInput.addEventListener("input", filterOrders);
  }

  if (filterMenuItems.length > 0) {
    filterMenuItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        e.preventDefault();
        filterMenuItems.forEach((i) => i.classList.remove("active", "fw-bold"));
        this.classList.add("active", "fw-bold");
        filterOrders();
      });
    });
  }
});
