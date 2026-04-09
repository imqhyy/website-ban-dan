function initRegisterForm() {
  const registerForm = document.getElementById("register-form");

  if (!registerForm || registerForm.dataset.registerJsInit === "1") {
    return;
  }

  registerForm.dataset.registerJsInit = "1";
  const emailInput = registerForm.querySelector('#email, input[name="email"]');

  function normalizeGmailInput(inputElement) {
    if (!inputElement) {
      return;
    }

    const value = inputElement.value.trim();

    if (value === "") {
      return;
    }

    if (/^[^@\s]+@gmail\.com$/i.test(value)) {
      inputElement.value = value;
      return;
    }

    const localPart = value.split("@")[0].replace(/\s+/g, "");
    if (localPart) {
      inputElement.value = `${localPart}@gmail.com`;
    }
  }

  if (emailInput) {
    emailInput.addEventListener("blur", function () {
      normalizeGmailInput(emailInput);
    });

    emailInput.addEventListener("change", function () {
      normalizeGmailInput(emailInput);
    });
  }

  registerForm.addEventListener("focusout", function (event) {
    if (event.target && event.target.id === "email") {
      normalizeGmailInput(event.target);
    }
  });

  registerForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // --- 1. KIỂM TRA RỖNG VÀ TỰ FOCUS TẠI FRONTEND ---
    const fullname = document.getElementById("fullname");
    const username = document.getElementById("username");
    const email = registerForm.querySelector('#email, input[name="email"]');
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");

    normalizeGmailInput(email);

    if (fullname.value.trim() === "") {
      Toast.fire({ icon: "warning", title: "Bạn chưa nhập Họ và Tên" });
      fullname.focus(); // Tự trỏ chuột vào ô Họ tên
      return;
    }
    if (username.value.trim() === "") {
      Toast.fire({ icon: "warning", title: "Bạn chưa nhập Tên đăng nhập" });
      username.focus();
      return;
    }
    if (email.value.trim() === "") {
      Toast.fire({ icon: "warning", title: "Bạn chưa nhập Email" });
      email.focus();
      return;
    }
    if (password.value.trim() === "") {
      Toast.fire({ icon: "warning", title: "Bạn chưa nhập Mật khẩu" });
      password.focus();
      return;
    }
    if (confirmPassword.value.trim() === "") {
      Toast.fire({ icon: "warning", title: "Bạn chưa xác nhận Mật khẩu" });
      confirmPassword.focus();
      return;
    }


    // --- RÀNG BUỘC ĐỊA CHỈ MỚI THÊM ---
    if (city.value === "") {
      Toast.fire({ icon: "warning", title: "Vui lòng chọn Tỉnh/Thành phố cho địa chỉ mặc định" });
      city.focus();
      return;
    }
    if (ward.value === "") {
      Toast.fire({ icon: "warning", title: "Vui lòng chọn Phường/Xã" });
      ward.focus();
      return;
    }
    if (address.value.trim() === "") {
      Toast.fire({ icon: "warning", title: "Vui lòng nhập Số nhà, tên đường" });
      address.focus();
      return;
    }
    // -------------------------------------------------

    const formData = new FormData(this);
    fetch("register.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          Toast.fire({
            icon: "success",
            title: data.message,
          }).then(() => {
            window.location.href = "login.php";
          });
        } else {
          Toast.fire({
            icon: "error",
            title: data.message,
          });

          // TỰ FOCUS VÀO Ô BỊ LỖI THEO BIẾN 'field' TỪ PHP TRẢ VỀ ---
          if (data.field) {
            const errorInput = document.getElementById(data.field);
            if (errorInput) {
              errorInput.focus();
            }
          }
          // -----------------------------------------------------------------
        }
      })
      .catch((error) => console.error("Error:", error));
  });

  // Thêm vào trong register.js -> hàm initRegisterForm()

  // Dữ liệu giả (hardcode) thay cho API
  const addressData = {
    "Thành phố Hồ Chí Minh": [
      // Bến Nghé (Quận 1), ...
      "Phường Bến Nghé", "Phường Bến Thành", "Phường Đa Kao", "Phường Nguyễn Thái Bình", "Phường Phạm Ngũ Lão", "Phường Nguyễn Cư Trinh", "Phường Cô Giang", "Phường Cầu Kho", "Phường Tân Định",
      "Phường Võ Thị Sáu", "Phường 14", "Phường 1", "Phường 2", "Phường 4", "Phường 5", "Phường 9", "Phường 12",
      "Phường 6", "Phường 13", "Phường 15", "Phường 16", "Phường 18",
      "Phường 7",
      "Phường Bình Thuận", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Tân Hưng", "Phường Tân Kiểng", "Phường Tân Phong", "Phường Tân Phú", "Phường Tân Quy", "Phường Tân Thuận Đông", "Phường Tân Thuận Tây",
      "Phường 8", "Phường 10", "Phường 11",
      "Phường 3",
      "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"
    ],
    "Thành phố Đà Nẵng": [
      "Phường Hải Châu I", "Phường Hải Châu II", "Phường Thạch Thang", "Phường Nam Dương", "Phường Phước Ninh", "Phường Bình Hiên", "Phường Bình Thuận", "Phường Hòa Thuận Đông", "Phường Hòa Thuận Tây", "Phường Hòa Cường Bắc", "Phường Hòa Cường Nam",
      "Phường Thọ Quang", "Phường Nại Hiên Đông", "Phường Mân Thái", "Phường An Hải Bắc", "Phường Phước Mỹ", "Phường An Hải Tây", "Phường An Hải Đông",
      "Phường Mỹ An", "Phường Khuê Mỹ", "Phường Hòa Hải", "Phường Hòa Quý",
      "Phường Thanh Bình", "Phường Thuận Phước", "Phường Thạc Gián", "Phường Chính Gián", "Phường Vĩnh Trung", "Phường Tân Chính", "Phường Xuân Hà", "Phường Tam Thuận", "Phường Thanh Khê Đông", "Phường Thanh Khê Tây", "Phường An Khê", "Phường Hòa Khê",
      "Phường Hòa Minh", "Phường Hòa Khánh Nam", "Phường Hòa Khánh Bắc", "Phường Hòa Hiệp Nam", "Phường Hòa Hiệp Bắc",
      "Phường Khuê Trung", "Phường Hòa Thọ Đông", "Phường Hòa Thọ Tây", "Phường Hòa Phát", "Phường Hòa An", "Phường Hòa Xuân"
    ]
  };

  const citySelect = document.getElementById("city");
  const wardSelect = document.getElementById("ward");

  // 1. Đổ dữ liệu Tỉnh/Thành
  if (citySelect) {
    Object.keys(addressData).forEach((city) => {
      let option = document.createElement("option");
      option.value = city;
      option.textContent = city;
      citySelect.appendChild(option);
    });

    // 2. Sự kiện thay đổi Tỉnh/Thành -> Load Phường/Xã
    citySelect.addEventListener("change", function () {
      wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      wardSelect.disabled = true;

      const wards = addressData[this.value];
      if (wards) {
        wards.forEach((ward) => {
          let option = document.createElement("option");
          option.value = ward;
          option.textContent = ward;
          wardSelect.appendChild(option);
        });
        wardSelect.disabled = false;
      }
    });
  }
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initRegisterForm);
} else {
  initRegisterForm();
}
