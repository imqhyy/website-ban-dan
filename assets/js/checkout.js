document.addEventListener("DOMContentLoaded", function () {
  const checkoutForm = document.getElementById("checkout-form");

  // Dữ liệu giả (hardcode) thay cho API
  const addressData = {
    "Hà Nội": {
      "Quận Ba Đình": ["Phường Phúc Xá", "Phường Trúc Bạch", "Phường Vĩnh Phúc", "Phường Cống Vị", "Phường Liễu Giai", "Phường Nguyễn Trung Trực", "Phường Quán Thánh", "Phường Ngọc Hà", "Phường Điện Biên"],
      "Quận Hoàn Kiếm": ["Phường Phúc Tân", "Phường Đồng Xuân", "Phường Hàng Bạc", "Phường Cửa Đông", "Phường Hàng Bồ", "Phường Hàng Đào", "Phường Tràng Tiền", "Phường Lý Thái Tổ"],
      "Quận Hai Bà Trưng": ["Phường Nguyễn Du", "Phường Bùi Thị Xuân", "Phường Ngô Thì Nhậm", "Phường Đồng Nhân", "Phường Bạch Đằng", "Phường Thanh Nhàn", "Phường Cầu Dền", "Phường Bách Khoa", "Phường Quỳnh Lôi", "Phường Bạch Mai", "Phường Quỳnh Mai", "Phường Vĩnh Tuy", "Phường Minh Khai", "Phường Trương Định", "Phường Đồng Tâm", "Phường Lê Đại Hành"],
      "Quận Đống Đa": ["Phường Cát Linh", "Phường Láng Hạ", "Phường Láng Thượng", "Phường Ô Chợ Dừa", "Phường Nam Đồng", "Phường Trung Liệt", "Phường Thịnh Quang", "Phường Khương Thượng", "Phường Quang Trung"],
      "Quận Cầu Giấy": ["Phường Dịch Vọng", "Phường Dịch Vọng Hậu", "Phường Quan Hoa", "Phường Trung Hòa", "Phường Nghĩa Đô", "Phường Nghĩa Tân", "Phường Mai Dịch", "Phường Yên Hòa"],
      "Quận Thanh Xuân": ["Phường Hạ Đình", "Phường Khương Đình", "Phường Khương Mai", "Phường Khương Trung", "Phường Kim Giang", "Phường Nhân Chính", "Phường Phương Liệt", "Phường Thanh Xuân Bắc", "Phường Thanh Xuân Nam", "Phường Thanh Xuân Trung", "Phường Thượng Đình"],
      "Quận Hoàng Mai": ["Phường Đại Kim", "Phường Định Công", "Phường Giáp Bát", "Phường Hoàng Liệt", "Phường Hoàng Văn Thụ", "Phường Lĩnh Nam", "Phường Mai Động", "Phường Tân Mai", "Phường Thanh Trì", "Phường Thịnh Liệt", "Phường Trần Phú", "Phường Tương Mai", "Phường Vĩnh Hưng", "Phường Yên Sở"],
      "Quận Long Biên": ["Phường Bồ Đề", "Phường Cự Khối", "Phường Đức Giang", "Phường Gia Thụy", "Phường Giang Biên", "Phường Long Biên", "Phường Ngọc Lâm", "Phường Ngọc Thụy", "Phường Phúc Đồng", "Phường Phúc Lợi", "Phường Sài Đồng", "Phường Thạch Bàn", "Phường Thượng Thanh", "Phường Việt Hưng"],
      "Quận Bắc Từ Liêm": ["Phường Cổ Nhuế 1", "Phường Cổ Nhuế 2", "Phường Đông Ngạc", "Phường Đức Thắng", "Phường Liên Mạc", "Phường Minh Khai", "Phường Phú Diễn", "Phường Phúc Diễn", "Phường Tây Tựu", "Phường Thượng Cát", "Phường Thụy Phương", "Phường Xuân Đỉnh", "Phường Xuân Tảo"],
      "Quận Nam Từ Liêm": ["Phường Cầu Diễn", "Phường Đại Mỗ", "Phường Mễ Trì", "Phường Mỹ Đình 1", "Phường Mỹ Đình 2", "Phường Phú Đô", "Phường Tây Mỗ", "Phường Phương Canh", "Phường Trung Văn", "Phường Xuân Phương"]
    },
    "Thành phố Hồ Chí Minh": {
      "Quận 1": ["Phường Bến Nghé", "Phường Bến Thành", "Phường Đa Kao", "Phường Nguyễn Thái Bình", "Phường Phạm Ngũ Lão", "Phường Nguyễn Cư Trinh", "Phường Cô Giang", "Phường Cầu Ông Lãnh", "Phường Tân Định", "Phường Cầu Kho"],
      "Quận 3": ["Phường Võ Thị Sáu", "Phường 14", "Phường 11", "Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 9", "Phường 10", "Phường 12", "Phường 13"],
      "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 18"],
      "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14"],
      "Quận 7": ["Phường Bình Thuận", "Phường Phú Mỹ", "Phường Phú Thuận", "Phường Tân Hưng", "Phường Tân Kiểng", "Phường Tân Phong", "Phường Tân Phú", "Phường Tân Quy", "Phường Tân Thuận Đông", "Phường Tân Thuận Tây"],
      "Quận 10": ["Phường 1", "Phường 2", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
      "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15"],
      "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6", "Phường 7", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 17", "Phường 19", "Phường 21", "Phường 22", "Phường 24", "Phường 25", "Phường 26", "Phường 27", "Phường 28"],
      "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 13", "Phường 15", "Phường 17"],
      "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10", "Phường 11", "Phường 12", "Phường 13", "Phường 14", "Phường 15", "Phường 16", "Phường 17"]
    }
  };

  // Các phần tử xử lý địa chỉ mặc định/mới
  const finalAddressInput = document.getElementById("final-address");
  const defaultAddressRadio = document.getElementById("default-address");
  const newAddressRadio = document.getElementById("new-address");
  const defaultAddressDisplay = document.getElementById("default-address-display");
  const defaultAddressValue = defaultAddressDisplay ? defaultAddressDisplay.getAttribute("data-address") : "";

  // Các phần tử trong khối nhập địa chỉ mới
  const newAddressGroup = document.getElementById("new-address-group");
  const citySelect = document.getElementById("new-city");
  const districtSelect = document.getElementById("new-district");
  const wardSelect = document.getElementById("new-ward");
  const streetInput = document.getElementById("new-street");
  const btnApplyAddress = document.getElementById("btn-apply-address");
  const applySuccessMsg = document.getElementById("apply-success-msg");

  let isNewAddressApplied = false;

  // ==========================================
  // 1. ĐỔ DỮ LIỆU ĐỊA CHỈ TỪ BIẾN TĨNH
  // ==========================================

  // Tải danh sách Tỉnh/Thành phố khi vừa vào trang
  if (citySelect) {
    Object.keys(addressData).forEach(city => {
      let option = document.createElement("option");
      option.value = city;
      option.textContent = city;
      citySelect.appendChild(option);
    });
  }

  // Khi chọn Tỉnh/Thành -> Load Quận/Huyện
  if (citySelect) {
    citySelect.addEventListener("change", function () {
      // Reset tuyến dưới
      districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
      wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      districtSelect.disabled = true;
      wardSelect.disabled = true;
      resetApplyState();

      const selectedCity = this.value;
      if (selectedCity && addressData[selectedCity]) {
        Object.keys(addressData[selectedCity]).forEach(district => {
          let option = document.createElement("option");
          option.value = district;
          option.textContent = district;
          districtSelect.appendChild(option);
        });
        districtSelect.disabled = false; // Mở khóa ô Quận/Huyện
      }
    });
  }

  // Khi chọn Quận/Huyện -> Load Phường/Xã
  if (districtSelect) {
    districtSelect.addEventListener("change", function () {
      wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      wardSelect.disabled = true;
      resetApplyState();

      const selectedCity = citySelect.value;
      const selectedDistrict = this.value;

      if (selectedCity && selectedDistrict && addressData[selectedCity][selectedDistrict]) {
        addressData[selectedCity][selectedDistrict].forEach(ward => {
          let option = document.createElement("option");
          option.value = ward;
          option.textContent = ward;
          wardSelect.appendChild(option);
        });
        wardSelect.disabled = false; // Mở khóa ô Phường/Xã
      }
    });
  }

  // Khi thay đổi Phường/Xã hoặc gõ số nhà -> Yêu cầu ấn Apply lại
  if (wardSelect) wardSelect.addEventListener("change", resetApplyState);
  if (streetInput) streetInput.addEventListener("input", resetApplyState);

  // ==========================================
  // 2. LOGIC ẨN/HIỆN & NÚT HOÀN THÀNH
  // ==========================================

  function resetApplyState() {
    isNewAddressApplied = false;
    if (finalAddressInput) finalAddressInput.value = "";
    if (applySuccessMsg) applySuccessMsg.style.display = "none";
    if (btnApplyAddress) {
      btnApplyAddress.classList.replace("btn-success", "btn-dark");
      btnApplyAddress.innerHTML = '<i class="bi bi-check-circle"></i> Hoàn thành';
    }
  }

  function handleAddressChange() {
    if (defaultAddressRadio?.checked) {
      if (newAddressGroup) newAddressGroup.style.display = "none";
      if (finalAddressInput) finalAddressInput.value = defaultAddressValue;
    } else if (newAddressRadio?.checked) {
      if (newAddressGroup) newAddressGroup.style.display = "block";
      if (!isNewAddressApplied && finalAddressInput) {
        finalAddressInput.value = ""; // Phải bấm hoàn thành mới có data
      }
    }
  }

  if (defaultAddressRadio && newAddressRadio) {
    defaultAddressRadio.addEventListener("change", handleAddressChange);
    newAddressRadio.addEventListener("change", handleAddressChange);
    handleAddressChange();
  }

  if (btnApplyAddress) {
    btnApplyAddress.addEventListener("click", function () {
      const city = citySelect.value;
      const district = districtSelect.value;
      const ward = wardSelect.value;
      const street = streetInput.value.trim();

      if (!city || !district || !ward || !street) {
        Swal.fire('Opps!', 'Vui lòng chọn Tỉnh/Thành, Quận/Huyện, Phường/Xã và nhập Tên đường/Số nhà!', 'warning');
        return;
      }

      // Ghép chuỗi gửi xuống DB
      const fullNewAddress = `${street}, ${ward}, ${district}, ${city}`;
      finalAddressInput.value = fullNewAddress;
      isNewAddressApplied = true;

      applySuccessMsg.style.display = "inline-block";
      btnApplyAddress.classList.replace("btn-dark", "btn-success");
      btnApplyAddress.innerHTML = '<i class="bi bi-check-all"></i> Đã lưu';
    });
  }

  // ==========================================
  // 3. XỬ LÝ SUBMIT FORM
  // ==========================================
  if (checkoutForm) {
    checkoutForm.addEventListener("submit", function (event) {
      event.preventDefault();

      if (defaultAddressRadio?.checked && defaultAddressValue.trim() === "") {
        Swal.fire('Lỗi', 'Bạn chưa có địa chỉ mặc định. Vui lòng chọn "Thêm địa chỉ mới"!', 'error');
        return;
      }

      if (newAddressRadio?.checked && !isNewAddressApplied) {
        Swal.fire('Lỗi', 'Vui lòng nhấn nút "Hoàn thành" để xác nhận địa chỉ mới!', 'warning');
        return;
      }

      const submitBtn = checkoutForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;

      submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang xử lý...';
      submitBtn.disabled = true;

      fetch('forms/ajax/ajax_checkout.php', {
        method: 'POST',
        body: new FormData(checkoutForm)
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({ toast: true, position: "top-end", icon: "success", title: data.message, showConfirmButton: false, timer: 1500 })
              .then(() => window.location.href = "order-confirmation.php?order=" + data.order_code);
          } else {
            Swal.fire('Lỗi', data.message, 'error');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
          }
        })
        .catch(error => {
          Swal.fire('Lỗi', 'Lỗi kết nối mạng!', 'error');
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        });
    });
  }
});