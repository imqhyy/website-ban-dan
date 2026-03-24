<?php
$title = "Tài khoản";
require_once(__DIR__ . '/forms/init.php');

$adminUsername = $_SESSION['admin'] ?? '';
$admin = null;
if (!empty($adminUsername)) {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$adminUsername]);
    $admin = $stmt->fetch();
}

if (!$admin) {
    header("Location: admin_login.php");
    exit();
}

// Bóc tách trước các biến để chèn vào HTML cho gọn gàng
$fullname = !empty($admin['fullname']) ? $admin['fullname'] : 'Quản trị viên';
$email = !empty($admin['email']) ? $admin['email'] : 'Chưa cập nhật';
$phone = !empty($admin['phone']) ? $admin['phone'] : 'Chưa cập nhật';
$role = !empty($admin['role']) ? $admin['role'] : 'admin';
$status = !empty($admin['status']) ? $admin['status'] : 'active';
$avatarPath = !empty($admin['avatar']) ? '../assets/img/users/' . $admin['avatar'] : 'assets/img/person/mckhutthuocbangchan.jpeg';

include __DIR__ . "/forms/head.php";
?>

<body class="account-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Tài khoản</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Tài khoản</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Account Section -->
    <section id="account" class="account section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu d-lg-none mb-4">
          <button class="mobile-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#profileMenu">
            <i class="bi bi-grid"></i>
            <span>Menu</span>
          </button>
        </div>

        <div class="row g-4">
          <!-- Profile Menu -->
          <div class="col-lg-3">
            <div class="profile-menu collapse d-lg-block" id="profileMenu">
              <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <img src="<?= htmlspecialchars($avatarPath) ?>" alt="Profile" loading="lazy">
                  <span class="status-badge"><i class="bi bi-shield-check"></i></span>
                </div>
                <h4 id="user-display-name"><?= htmlspecialchars($fullname) ?></h4>
                <h6 style="color: rgb(129, 129, 128);">user: <?= htmlspecialchars($adminUsername) ?></h6>
                <div class="user-status">
                  <i class="bi bi-award"></i>
                  <span><?= $role === 'super_admin' ? 'Kẻ thống trị hệ thống' : 'Quản trị viên' ?></span>
                </div>
              </div>

              <!-- Navigation Menu -->
              <nav class="menu-nav">
                <ul class="nav flex-column" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#orders">
                      <i class="bi bi-box-seam"></i>
                      <span>Hồ sơ admin</span>
                    </a>
                  </li>



                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings">
                      <i class="bi bi-gear"></i>
                      <span>Cài đặt</span>
                    </a>
                  </li>
                </ul>

                <!-- <div class="menu-footer">
                  <a href="support.php" class="help-link">
                    <i class="bi bi-question-circle"></i>
                    <span>Trung tâm hỗ trợ</span>
                  </a>
                  
                </div> -->
              </nav>
            </div>
          </div>

          <!-- Content Area -->
          <div class="col-lg-9">
            <div class="content-area">
              <div class="tab-content">
                <!-- Orders Tab -->
                <div class="tab-pane fade show active" id="orders">
                  <h2 style="font-size: 24px; font-weight: 600;">Thông tin người quản trị</h2>
                  <hr>
                  <div class="admin-info-detail" style="margin: 20px">
                    <p><strong>Username: </strong><?= htmlspecialchars($adminUsername) ?></p>
                    <p><strong>Họ và tên: </strong><?= htmlspecialchars($fullname) ?></p>
                    <p><strong>Email: </strong><?= htmlspecialchars($email) ?></p>
                    <p><strong>Số điện thoại: </strong><?= htmlspecialchars($phone) ?></p>

                    <p><strong>Quyền Hạn:</strong> <span class="role-tag"><?= $role === 'super_admin' ? 'Super Admin' : 'Admin' ?></span></p>
                    <p><strong>Trạng Thái:</strong> <span class="status-active"><?= ucfirst($status) ?></span></p>
                  </div>





                </div>



                <!-- Settings Tab -->
                <div class="tab-pane fade" id="settings">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Cài đặt tài khoản</h2>
                  </div>

                  <div class="settings-content">
                    <!-- Personal Information -->
                    <div class="settings-section" data-aos="fade-up">
                      <h3>Thông tin cá nhân</h3>
                      <form class="settings-form" id="account-settings-form">
                        <input type="hidden" name="action" value="update_profile">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" value="<?= htmlspecialchars($adminUsername) ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                          </div>
                          <div class="col-md-6">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="fullname" value="<?= htmlspecialchars($fullname) ?>">
                          </div>
                          <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                          </div>
                          <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>">
                          </div>
                        </div>

                        <div class="input-new-avatar-image">
                          <label for="profilePicture" class="form-label">Ảnh đại diện</label>
                          <div class="input-group">
                            <input type="file" class="form-control file-input-hidden" id="profilePicture" name="avatar"
                              accept="image/*">

                            <input type="text" class="form-control" id="fileNameDisplay"
                              placeholder="Chưa có tệp nào được chọn" readonly
                              style="border-radius: 10px 0px 0px 10px;">

                            <button class="btn btn-outline-secondary custom-upload-btn" type="button"
                              id="uploadAvatarButton">
                              Tải lên
                            </button>
                          </div>
                          <div class="form-text">
                            Kích thước tối đa: 2MB. Định dạng: JPG, PNG.
                          </div>
                        </div>

                        <div class="form-buttons">
                          <button type="submit" class="btn-save">Lưu thay đổi</button>
                        </div>

                      </form>
                    </div>




                    <!-- Security Settings -->
                    <div class="settings-section" data-aos="fade-up" data-aos-delay="200">
                      <h3>Bảo mật</h3>
                      <form class="settings-form" id="password-update-form">
                        <input type="hidden" name="action" value="update_password">
                        <div class="row g-3">
                          <div class="col-md-12">
                            <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                          </div>
                          <div class="col-md-6">
                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                          </div>
                          <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                          </div>
                        </div>

                        <div class="form-buttons">
                          <button type="submit" class="btn-save">Cập nhật mật khẩu</button>
                        </div>
                      </form>
                    </div>

                    <!-- Delete Account -->
                    <div class="settings-section danger-zone" data-aos="fade-up" data-aos-delay="300">
                      <h3>Xoá tài khoản</h3>
                      <div class="danger-zone-content">
                        <p>Một khi bạn đã xóa tài khoản, bạn sẽ mất quyền quản trị!!</p>
                        <button type="button" class="btn-danger" id="delete-account">Xoá tài khoản</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

    </section><!-- /Account Section -->

  </main>

  <?php require_once __DIR__ . "/forms/footer.php" ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php
  require_once __DIR__ . "/forms/scripts.php";
  ?>


  <!--script này dùng để tạo thông báo và thực hiện 1 số thao tác trong đánh giá đơn hàng-->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ratingSelectors = document.querySelectorAll('.star-rating-selector');

      ratingSelectors.forEach(selector => {
        const stars = selector.querySelectorAll('.star-icon');
        const input = selector.querySelector('.rating-input');
        const ratingText = selector.querySelector('.rating-text');

        const messages = {
          1: "Rất tệ",
          2: "Tệ",
          3: "Trung bình",
          4: "Tốt",
          5: "Rất tốt"
        };

        // Hàm cập nhật trạng thái các ngôi sao và input
        function updateRating(value) {
          stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'));
            if (starValue <= value) {
              star.classList.add('filled');
              star.classList.remove('bi-star');
              star.classList.add('bi-star-fill');
            } else {
              star.classList.remove('filled');
              star.classList.remove('bi-star-fill');
              star.classList.add('bi-star');
            }
          });
          input.value = value;
          ratingText.textContent = value > 0 ? `(${value}/5) - ${messages[value]}` : '';
        }

        // Khởi tạo ban đầu (ví dụ: 0 sao)
        updateRating(0);

        // Xử lý sự kiện click
        stars.forEach(star => {
          star.addEventListener('click', function () {
            const value = parseInt(this.getAttribute('data-value'));
            updateRating(value);
          });
        });

        // Xử lý sự kiện hover (Rê chuột)
        selector.addEventListener('mouseover', function (e) {
          if (e.target.classList.contains('star-icon')) {
            const hoverValue = parseInt(e.target.getAttribute('data-value'));
            stars.forEach(star => {
              const starValue = parseInt(star.getAttribute('data-value'));
              if (starValue <= hoverValue) {
                star.classList.add('filled');
                star.classList.remove('bi-star');
                star.classList.add('bi-star-fill');
              } else {
                star.classList.remove('filled');
                star.classList.remove('bi-star-fill');
                star.classList.add('bi-star');
              }
            });
            ratingText.textContent = hoverValue > 0 ? `(${hoverValue}/5) - ${messages[hoverValue]}` : '';
          }
        });

        // Xử lý sự kiện mouseout (Rời chuột)
        selector.addEventListener('mouseout', function () {
          const currentValue = parseInt(input.value);
          updateRating(currentValue);
        });
      });

      // Xử lý sự kiện click nút Gửi đánh giá (chỉ là demo, không có chức năng backend)
      document.querySelectorAll('.review-submit-btn').forEach(button => {
        button.addEventListener('click', function () {
          const itemContainer = this.closest('.review-product-item');
          const productId = itemContainer.querySelector('.star-rating-selector').getAttribute('data-product-id');
          const rating = itemContainer.querySelector('.rating-input').value;
          const reviewText = itemContainer.querySelector('textarea').value;


          // *** LUÔN LUÔN THÔNG BÁO THÀNH CÔNG CHO MỤC ĐÍCH GIAO DIỆN ***

          // Lấy rating để hiển thị trong thông báo
          const displayRating = rating > 0 ? `${rating} sao` : 'Chưa có sao';
          const productName = itemContainer.querySelector('h6').textContent;

          // SỬ DỤNG SWEETALERT2 CHO THÔNG BÁO THÀNH CÔNG
          Swal.fire({
            title: 'Đánh giá thành công! 🎉',
            html: `Cảm ơn bạn đã đánh giá sản phẩm <strong>${productName}</strong>.`,
            icon: 'success',
            confirmButtonText: 'Tuyệt vời',
            customClass: {
              popup: 'my-swal-popup',
              title: 'my-swal-title',
              confirmButton: 'my-swal-confirm-button',
              htmlContainer: 'my-swal-html-container'
            }
          }).then(() => {
            // Ẩn form đánh giá sau khi người dùng nhấn nút xác nhận
            itemContainer.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        Đánh giá của bạn cho sản phẩm <strong>${productId}</strong> đã được gửi! Cảm ơn bạn.
                    </div>`;
          });

          // Nếu ẩn cái trên chọn cái này, thì phải nhập đánh giá và số sao mới cho gửi
          // if (rating === '0' || reviewText.trim() === '') {
          //     alert('Vui lòng chọn số sao và nhập nhận xét của bạn.');
          //     return;
          // }

          // // Gửi dữ liệu đi (Demo)
          // console.log(`Đánh giá cho sản phẩm ${productId}:`);
          // console.log(`- Số sao: ${rating}`);
          // console.log(`- Nhận xét: "${reviewText}"`);

          // // Hiển thị thông báo thành công (Có thể dùng SweetAlert2 nếu đã cài)
          // alert(`Đánh giá của bạn cho sản phẩm ${productId} đã được gửi thành công!`);

          // // Ẩn form đánh giá sau khi gửi (hoặc cập nhật trạng thái)
          // itemContainer.innerHTML = `<div class="alert alert-success" role="alert">
          //     Đánh giá của bạn cho sản phẩm <strong>${productId}</strong> đã được gửi! Cảm ơn bạn.
          // </div>`;
        });
      });

    });
  </script>



  <!--/*========================================= */
      /* JS khi ấn vào nút tải lên nó sẽ kích hoạt chức năng input ảnh */
      /* =========================================*/-->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // 1. Lấy các phần tử cần thiết
      const uploadButton = document.getElementById('uploadAvatarButton');
      const fileInput = document.getElementById('profilePicture');
      const fileNameDisplay = document.getElementById('fileNameDisplay');

      // 2. Kích hoạt input file khi nhấn nút "Tải lên"
      uploadButton.addEventListener('click', function () {
        fileInput.click(); // Kích hoạt hành động chọn file
      });

      // 3. Kích hoạt input file khi nhấn vào ô hiển thị tên file (Cải thiện UX)
      fileNameDisplay.addEventListener('click', function () {
        fileInput.click();
      });

      // 4. Cập nhật tên file đã chọn vào ô hiển thị
      fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
          // Hiển thị tên file đầu tiên được chọn
          fileNameDisplay.value = fileInput.files[0].name;
        } else {
          // Nếu không có file nào được chọn
          fileNameDisplay.value = "Chưa có tệp nào được chọn";
        }
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const accountForm = document.getElementById('account-settings-form');
      if (accountForm) {
        accountForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          let formData = new FormData(this);
          
          fetch('forms/account_admin/ajax_admin_update.php', {
            method: 'POST',
            body: formData
          })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
              // F5 Tải lại trang sau 1.5s để đồng bộ UI
              setTimeout(() => { window.location.reload(); }, 1500);
            } else {
              Swal.fire({
                icon: 'error',
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
              });
            }
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              title: 'Lỗi mạng hoặc máy chủ không phản hồi',
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
          });
        });
      }
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const passwordForm = document.getElementById('password-update-form');
      if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          let formData = new FormData(this);
          
          if (formData.get('newPassword') !== formData.get('confirmPassword')) {
             Swal.fire({
                icon: 'error',
                title: 'Mật khẩu xác nhận không khớp!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
             });
             return;
          }

          fetch('forms/account_admin/ajax_admin_update.php', {
            method: 'POST',
            body: formData
          })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
              passwordForm.reset(); 
            } else {
              Swal.fire({
                icon: 'error',
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
              });
            }
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              title: 'Lỗi mạng hoặc máy chủ không phản hồi',
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
          });
        });
      }
    });
  </script>

</body>

</html>