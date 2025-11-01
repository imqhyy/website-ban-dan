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

  if (currentUserJSON) {
    document.body.classList.remove("page-loading");
  } else {
    Swal.fire({
      icon: "warning",
      title: "Yêu cầu đăng nhập",
      text: "Bạn cần đăng nhập để có thể xem hồ sơ.",
      confirmButtonText: "Đến trang đăng nhập",
      allowOutsideClick: false,
      customClass: {
        container: "blurred-login-alert", // Thêm class container riêng cho alert này
        popup: "my-swal-popup",
        title: "my-swal-title",
        htmlContainer: "my-swal-html-container",
        confirmButton: "my-swal-confirm-button",
      },
    }).then(() => {
      window.location.href = "login.html";
    });
  }
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
  if (settingsForm) {
    settingsForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const newFirstName = firstNameInput.value;
      const newLastName = lastNameInput.value;
      const newFullName = (newFirstName + " " + newLastName).trim();
      const newEmail = emailInput.value;
      const newPhone = phoneInput.value;
      let allUsers = JSON.parse(localStorage.getItem("users")) || [];
      const userIndex = allUsers.findIndex(
        (user) => user.email === currentUser.email
      );
      if (userIndex !== -1) {
        allUsers[userIndex].fullName = newFullName;
        allUsers[userIndex].email = newEmail;
        allUsers[userIndex].phone = newPhone;
        localStorage.setItem("users", JSON.stringify(allUsers));
      }
      const updatedCurrentUser = {
        ...currentUser,
        fullName: newFullName,
        email: newEmail,
        phone: newPhone,
      };
      sessionStorage.setItem("currentUser", JSON.stringify(updatedCurrentUser));
      if (userDisplayName) userDisplayName.textContent = newFullName;
      Toast.fire({ icon: "success", title: "Cập nhật thông tin thành công!" });
    });
  }

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
          window.location.href = "index.html";
        }
      );
    });
  }
});

//tắt cái né thì cmt đoạn 241->275 và 286->298
const deleteAccountButton = document.getElementById("delete-account");
deleteAccountButton.addEventListener("click", function () {
  // Dcm
  let mouseX = 0;
  let mouseY = 0;
  let buttonX = 0;
  let buttonY = 0;
  const repulsionRadius = 108;
  const stiffness = 0.15;

  // Hàm theo dõi vị trí chuột
  document.addEventListener("mousemove", function (e) {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  // Hàm chính tính toán và di chuyển nút (chạy mượt mà)
  function animateButton(cancelButton, containerRect) {
    // Tính toán khoảng cách từ chuột đến tâm nút
    const buttonRect = cancelButton.getBoundingClientRect();
    const centerX = buttonRect.left + buttonRect.width / 2;
    const centerY = buttonRect.top + buttonRect.height / 2;

    const dx = mouseX - centerX;
    const dy = mouseY - centerY;
    const distance = Math.sqrt(dx * dx + dy * dy);
    if (distance < repulsionRadius) {
      const repulsionForce = (repulsionRadius - distance) / repulsionRadius;
      const pushX = -dx * repulsionForce * stiffness;
      const pushY = -dy * repulsionForce * stiffness;
      buttonX += pushX;
      buttonY += pushY;
    }
    cancelButton.style.transform = `translate(${buttonX}px, ${buttonY}px)`;
    requestAnimationFrame(() => animateButton(cancelButton, containerRect));
  }
  Swal.fire({
    icon: "warning",
    title: "Ũa xao xó dị má!?",
    text: "Bạn mà xoá là tui khóc huhu á :((",
    showCancelButton: true,
    confirmButtonColor: "#d33", // Đỏ cho hành động nguy hiểm
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Tôi hiểu rõ, Xóa tài khoản!",
    cancelButtonText: "Hủy bỏ",

    didOpen: () => {
      const cancelButton = Swal.getCancelButton();

      if (cancelButton) {
        cancelButton.style.position = "relative";
        cancelButton.style.transition = "none";
        const popup = Swal.getPopup();
        const containerRect = popup.getBoundingClientRect();

        // Khởi động vòng lặp animation
        animateButton(cancelButton, containerRect);
      }
    },
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        icon: "success",
        title: "- 1 thành viên tiềm năng!",
        text: "Hẹn gặp lại bạn vào 1 ngày đẹp chời ^^. Đang chuyển hướng...",
        showConfirmButton: false,
        timer: 2000,
      }).then((result) => {
        window.location.href = "login.html";
      });
    }
  });
});
// document.addEventListener('DOMContentLoaded', function () {

//     const currentUserJSON = sessionStorage.getItem('currentUser');

//     if (!currentUserJSON) {
//         Swal.fire({
//             icon: 'warning',
//             title: 'Yêu cầu đăng nhập',
//             text: 'Bạn cần đăng nhập để truy cập trang này.',
//             confirmButtonText: 'Đến trang đăng nhập',
//             allowOutsideClick: false,
//             customClass: { /* ... custom classes của anh ... */ }
//         }).then(() => {
//             window.location.href = 'login.html';
//         });
//         return;
//     }
//     document.body.classList.remove('page-loading');

//     const currentUser = JSON.parse(currentUserJSON);

//     const userDisplayName = document.getElementById('user-display-name');
//     const firstNameInput = document.getElementById('firstName');
//     const lastNameInput = document.getElementById('lastName');
//     const emailInput = document.getElementById('email');
//     const phoneInput = document.getElementById('phone');
//     const settingsForm = document.getElementById('account-settings-form');
//     const passwordUpdateForm = document.getElementById('password-update-form');
//     const logoutLink = document.querySelector('.logout-link');

//     if (currentUser) {
//         if (userDisplayName) userDisplayName.textContent = currentUser.fullName;

//         if (currentUser.fullName) {
//             const nameParts = currentUser.fullName.split(' ');
//             if (firstNameInput) firstNameInput.value = nameParts.shift();
//             if (lastNameInput) lastNameInput.value = nameParts.join(' ');
//         }

//         if (emailInput) emailInput.value = currentUser.email;
//         if (phoneInput) phoneInput.value = currentUser.phone || '';
//     }

//     if (emailInput) {
//         emailInput.addEventListener('blur', function () {
//             const emailValue = emailInput.value;
//             if (emailValue.length > 0 && !emailValue.includes('@')) {
//                 emailInput.value = emailValue + '@gmail.com';
//             }
//         });
//     }

//     const ordersGrid = document.querySelector('#orders .orders-grid');
//     if (ordersGrid) {
//         ordersGrid.innerHTML = '';

//         const realOrders = currentUser.orders || [];
//         const allOrdersToShow = realOrders.concat(sampleOrders);

//         const orderBadge = document.querySelector('a[href="#orders"] .badge');
//         if (orderBadge) {
//             orderBadge.textContent = allOrdersToShow.length;
//         }

//         if (allOrdersToShow.length > 0) {
//             allOrdersToShow.reverse().forEach(order => {
//                 const totalItems = order.items.reduce((sum, item) => sum + item.quantity, 0);
//                 let productItemsHTML = '';
//                 order.items.forEach(item => {
//                     productItemsHTML += `
//                     <div style="display: flex; align-items: center; margin-bottom: 10px; font-size: 14px;">
//                         <img src="${item.image}" alt="${item.name}" style="width: 40px; height: 40px; border-radius: 4px; margin-right: 10px; object-fit: cover;">
//                         <span style="flex: 1;">${item.name}</span>
//                         <span style="color: #888; margin-left: 10px;">SL: ${item.quantity}</span>
//                     </div>
//                 `;
//                 });
//                 const orderCardHTML = `
//                 <div class="order-card">
//                     <div class="order-header">
//                         <div class="order-id"><span class="label">Mã đơn hàng:</span> <span class="value">#${order.orderId}</span></div>
//                         <div class="order-date">${order.date}</div>
//                     </div>
//                     <div class="order-content">
//                         <div class="product-list-summary" style="padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px dashed #e0e0e0;">
//                             ${productItemsHTML}
//                         </div>
//                         <div class="order-info">
//                             <div class="info-row"><span>Trạng thái</span><span class="status delivered">Đã hoàn thành</span></div>
//                             <div class="info-row"><span>Tổng số lượng</span><span>${totalItems} sản phẩm</span></div>
//                             <div class="info-row"><span>Tổng cộng</span><span class="price">${order.total.toLocaleString('vi-VN')} VNĐ</span></div>
//                         </div>
//                     </div>
//                     <div class="order-footer"><button type="button" class="btn-details">Xem chi tiết</button></div>
//                 </div>
//                 `;
//                 ordersGrid.innerHTML += orderCardHTML;
//             });
//         } else {
//             ordersGrid.innerHTML = '<p class="text-center p-5">Bạn chưa có đơn hàng nào.</p>';
//         }
//     }

//     if (settingsForm) {
//         settingsForm.addEventListener('submit', function (event) {
//             event.preventDefault();
//             const newFirstName = firstNameInput.value;
//             const newLastName = lastNameInput.value;
//             const newFullName = (newFirstName + ' ' + newLastName).trim();
//             const newEmail = emailInput.value;
//             const newPhone = phoneInput.value;
//             let allUsers = JSON.parse(localStorage.getItem('users')) || [];
//             const userIndex = allUsers.findIndex(user => user.email === currentUser.email);
//             if (userIndex !== -1) {
//                 allUsers[userIndex].fullName = newFullName;
//                 allUsers[userIndex].email = newEmail;
//                 allUsers[userIndex].phone = newPhone;
//                 localStorage.setItem('users', JSON.stringify(allUsers));
//             }
//             const updatedCurrentUser = { ...currentUser, fullName: newFullName, email: newEmail, phone: newPhone };
//             sessionStorage.setItem('currentUser', JSON.stringify(updatedCurrentUser));
//             if (userDisplayName) userDisplayName.textContent = newFullName;
//             Toast.fire({ icon: 'success', title: 'Cập nhật thông tin thành công!' });
//         });
//     }

//     if (passwordUpdateForm) {
//         passwordUpdateForm.addEventListener('submit', function (event) {
//             event.preventDefault();
//             const currentPassword = document.getElementById('currentPassword').value;
//             const newPassword = document.getElementById('newPassword').value;
//             const confirmNewPassword = document.getElementById('confirmPassword').value;
//             if (currentPassword !== currentUser.password) { Toast.fire({ icon: 'error', title: 'Mật khẩu hiện tại không đúng!' }); return; }
//             if (!newPassword) { Toast.fire({ icon: 'error', title: 'Vui lòng nhập mật khẩu mới!' }); return; }
//             if (newPassword !== confirmNewPassword) { Toast.fire({ icon: 'error', title: 'Mật khẩu xác nhận không khớp!' }); return; }
//             let allUsers = JSON.parse(localStorage.getItem('users')) || [];
//             const userIndex = allUsers.findIndex(user => user.email === currentUser.email);
//             if (userIndex !== -1) {
//                 allUsers[userIndex].password = newPassword;
//                 localStorage.setItem('users', JSON.stringify(allUsers));
//                 currentUser.password = newPassword;
//                 sessionStorage.setItem('currentUser', JSON.stringify(currentUser));
//                 Toast.fire({ icon: 'success', title: 'Đổi mật khẩu thành công!' });
//                 passwordUpdateForm.reset();
//             }
//         });
//     }

//     if (logoutLink) {
//         logoutLink.addEventListener('click', function (event) {
//             event.preventDefault();
//             sessionStorage.removeItem('currentUser');
//             updateCartIcon(0);
//             Toast.fire({ icon: 'success', title: 'Đăng xuất thành công!' })
//                 .then(() => {
//                     window.location.href = 'index.html';
//                 });
//         });
//     }

// });

//Dùng để khi click vào nút "đặt lại" trong đơn hàng nó sẽ nhảy sang trang checkout
// Lấy đối tượng nút bằng ID của nó
const button = document.getElementById("reorder-btn");

// Thêm một hàm để thực thi khi nút được nhấn
button.addEventListener("click", function () {
  // Thay đổi URL của cửa sổ hiện tại
  window.location.href = "checkout.html"; // Thay thế bằng đường dẫn trang bạn muốn
});
