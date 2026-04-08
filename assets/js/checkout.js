document.addEventListener("DOMContentLoaded", function () {
  const checkoutForm = document.getElementById("checkout-form");

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

  // Các phần tử xử lý địa chỉ mặc định/mới
  const finalAddressInput = document.getElementById("final-address");
  const defaultAddressRadio = document.getElementById("default-address");
  const newAddressRadio = document.getElementById("new-address");
  const defaultAddressDisplay = document.getElementById("default-address-display");
  const defaultAddressValue = defaultAddressDisplay ? defaultAddressDisplay.getAttribute("data-address") : "";

  // Các phần tử trong khối nhập địa chỉ mới
  const newAddressGroup = document.getElementById("new-address-group");
  const citySelect = document.getElementById("new-city");
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

  function getWardsByCity(selectedCity) {
    const cityData = addressData[selectedCity];
    if (!cityData) {
      return [];
    }

    if (Array.isArray(cityData)) {
      return cityData;
    }

    // Hỗ trợ cả dữ liệu 3 cấp bằng cách gộp toàn bộ phường của các quận.
    const wards = [];
    Object.keys(cityData).forEach(districtKey => {
      const districtWards = cityData[districtKey];
      if (Array.isArray(districtWards)) {
        wards.push(...districtWards);
      }
    });
    return [...new Set(wards)];
  }

  // Khi chọn Tỉnh/Thành -> Load trực tiếp danh sách Phường/Xã
  if (citySelect) {
    citySelect.addEventListener("change", function () {
      wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      wardSelect.disabled = true;
      resetApplyState();

      const selectedCity = this.value;
      const wards = getWardsByCity(selectedCity);

      if (selectedCity && wards.length > 0) {
        wards.forEach(ward => {
          let option = document.createElement("option");
          option.value = ward;
          option.textContent = ward;
          wardSelect.appendChild(option);
        });
        wardSelect.disabled = false;
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
      const ward = wardSelect.value;
      const street = streetInput.value.trim();

      // Validate cơ bản
      if (!city || !ward || !street) {
        Swal.fire('Opps!', 'Vui lòng chọn Tỉnh/Thành, Phường/Xã và nhập Tên đường/Số nhà!', 'warning');
        return;
      }

      // Ghép chuỗi gửi xuống DB
      const addressParts = [street, ward];
      addressParts.push(city);

      const fullNewAddress = addressParts.join(", ");
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