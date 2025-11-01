// Thay thế toàn bộ file assets/js/checkout.js

document.addEventListener("DOMContentLoaded", function () {
  // --- BẢO VỆ TRANG ---
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
  // KHÔNG KIỂM TRA GIỎ HÀNG THẬT NỮA

  if (currentUser) {
    document.body.classList.remove("page-loading");
  } else {
    Swal.fire({
      icon: "warning",
      title: "Yêu cầu đăng nhập",
      text: "Bạn cần đăng nhập để có thể thanh toán!",
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

  // --- LẤY CÁC PHẦN TỬ HTML ---
  const firstNameInput = document.getElementById("first-name");
  const lastNameInput = document.getElementById("last-name");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const addressInput = document.getElementById("address");
  const summaryItemsContainer = document.getElementById("order-summary-items");
  const itemCountElement = document.getElementById("item-count");
  const orderSubtotalElement = document.getElementById("order-subtotal");
  const orderTotalElement = document.getElementById("order-total");
  const placeOrderBtnPrice = document.getElementById("place-order-btn-price");
  const checkoutForm = document.getElementById("checkout-form");

  // --- ĐIỀN THÔNG TIN CÓ SẴN CỦA NGƯỜI DÙNG ---
  // if (currentUser.fullName) {
  //   const nameParts = currentUser.fullName.split(" ");
  //   firstNameInput.value = nameParts.shift();
  //   lastNameInput.value = nameParts.join(" ");
  // }
  // emailInput.value = currentUser.email || "";
  // phoneInput.value = currentUser.phone || "";

  // --- HIỂN THỊ TÓM TẮT ĐƠN HÀNG (DEMO) ---
  const demoCart = [
    {
      name: "Saga A1 DE PRO",
      quantity: 1,
      price: 2000000,
      image:
        "assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg",
    },
    {
      name: "Ba đờn C100",
      quantity: 1,
      price: 5000000,
      image:
        "assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg",
    },
    {
      name: "Taylor A12E",
      quantity: 1,
      price: 85000000,
      image:
        "assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg",
    },
  ];

  let total = 0;
  let totalItems = 0;
  summaryItemsContainer.innerHTML = "";
  demoCart.forEach((item) => {
    const itemTotal = item.price * item.quantity;
    total += itemTotal;
    totalItems += item.quantity;
    const itemHTML = `
            <div class="order-item">
                <div class="order-item-image"><img src="${item.image}" alt="${
      item.name
    }" class="img-fluid"></div>
                <div class="order-item-details">
                    <h4>${item.name}</h4>
                    <div class="order-item-price">
                        <span class="quantity">${item.quantity} ×</span>
                        <span class="price">${item.price.toLocaleString(
                          "vi-VN"
                        )} VND</span>
                    </div>
                </div>
            </div>`;
    summaryItemsContainer.innerHTML += itemHTML;
  });

  itemCountElement.textContent = `${totalItems} sản phẩm`;
  const formattedTotal = `${total.toLocaleString("vi-VN")} VND`;
  orderSubtotalElement.textContent = formattedTotal;
  orderTotalElement.textContent = formattedTotal;
  placeOrderBtnPrice.textContent = formattedTotal;
  // --- KHUÔN MẪU TOAST ---
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1200,
    timerProgressBar: true,
    customClass: {
      popup: "my-swal-popup",
    },
    didOpen: (toast) => {
      // toast.onmouseenter = Swal.stopTimer;
      // toast.onmouseleave = Swal.resumeTimer;
    },
  });
  // --- XỬ LÝ SỰ KIỆN ĐẶT HÀNG (DEMO) ---
  checkoutForm.addEventListener("submit", function (event) {
    event.preventDefault();

    // Toast thông báo thành công
    Toast.fire({
      icon: "success",
      title: "Đặt hàng thành công!",
    }).then(() => {
      window.location.href = "order-confirmation.html";
    });
  });

  // --- XỬ LÝ CHỌN ĐỊA CHỈ ---
  const defaultAddressRadio = document.getElementById("default-address");
  const newAddressRadio = document.getElementById("new-address");

  const defaultAddressDisplay = document
    .getElementById("default-address-display")
    .textContent.trim();

  // Hàm xử lý thay đổi lựa chọn địa chỉ
  function handleAddressChange() {
    if (defaultAddressRadio.checked) {
      // 1. Nếu chọn Địa chỉ Mặc định
      addressInput.value = defaultAddressDisplay;
      addressInput.classList.remove("is-new-address"); // (Tùy chọn: xóa class)
      Toast.fire({
        icon: "info",
        title: "Đã chọn địa chỉ mặc định",
        timer: 1000,
      });
    } else if (newAddressRadio.checked) {
      // 2. Nếu chọn Thêm địa chỉ mới
      addressInput.value = "";
      addressInput.classList.add("is-new-address"); // (Tùy chọn: thêm class)
      addressInput.focus();
      Toast.fire({
        icon: "info",
        title: "Vui lòng nhập địa chỉ mới",
        timer: 1000,
      });
    }
  }

  // Lắng nghe sự kiện thay đổi trên cả hai radio button
  defaultAddressRadio.addEventListener("change", handleAddressChange);
  newAddressRadio.addEventListener("change", handleAddressChange);

  // Khởi tạo trạng thái ban đầu (đảm bảo địa chỉ mặc định được điền sẵn khi tải trang)
  // Không cần gọi handleAddressChange() vì input đã có sẵn value mặc định.
  // Nhưng nếu bạn muốn đảm bảo, hãy gọi nó.
  // handleAddressChange();
});
