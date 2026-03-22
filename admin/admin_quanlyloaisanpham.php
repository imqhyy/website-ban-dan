<?php
$title = "Quản lý loại sản phẩm";
require_once "forms/init.php";
?>

<body class="login-page">
    <script>
    // const currentUserJSON = sessionStorage.getItem('isLoggedIn');
    // if (currentUserJSON) {
    //   document.body.classList.remove('page-loading');
    // } else {
    //   Swal.fire({
    //     icon: 'warning',
    //     title: 'Yêu cầu đăng nhập',
    //     text: 'Bạn cần đăng nhập để có thể truy cập tính năng của admin.',
    //     confirmButtonText: 'Đến trang đăng nhập',
    //     allowOutsideClick: false,
    //     customClass: {
    //       container: 'blurred-login-alert', // Thêm class container riêng cho alert này
    //       popup: 'my-swal-popup',
    //       title: 'my-swal-title',
    //       htmlContainer: 'my-swal-html-container',
    //       confirmButton: 'my-swal-confirm-button'
    //     }
    //   }).then(() => {
    //     window.location.href = 'admin_login.html';
    //   });
    // }
    </script>

    <?php require_once __DIR__ . "/forms/header.php" ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Quản lý loại sản phẩm</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="admin.html">Trang chủ</a></li>
                        <li class="current">Quản lý loại sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->



        <div class="container-manage-category-products">
            <h2 style="margin: 20px 0px;">Thêm Loại Sản Phẩm Mới</h2>
            <form id="add-category-form" class="add-form-category-products">
                <input type="text" id="new-cat-name" name="category_name" style="flex-grow: 1;"
                    placeholder="Tên Loại Sản Phẩm (ví dụ: Guitar Acoustic)" required>

                <input type="number" id="new-cat-profit" name="profit_margin" style="width: 120px; padding: 10px;
                    border: 1px solid #ccc; border-radius: 25px;" placeholder="Lợi nhuận(%)">

                <input type="text" id="new-cat-desc" name="description" style="flex-grow: 1;" placeholder="Mô tả (Tùy chọn)">

                <button type="button" onclick="addNewCategoryAjax()">Thêm mới</button>
            </form>

            <h2>Danh Sách Loại Sản Phẩm</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 17%;">Tên Loại</th>
                        <th sytle="width: 13%;">% Lợi nhuận</th>
                        <th style="width: 40%;">Mô tả</th>
                        <th style="width: 25%;">Chức năng</th>
                    </tr>
                </thead>
                <tbody id="categoryList">
                    <?php
          // 1. Truy vấn lấy tất cả phân loại từ database
          // Đảm bảo bạn đã chạy lệnh SQL thêm cột profit_margin và description trước đó
          $categories = getAll("SELECT * FROM categories ORDER BY id ASC");

          if (!empty($categories)):
            foreach ($categories as $cat):
              // Chuẩn hóa dữ liệu hiển thị
              $catID = $cat['id'];
              $catName = htmlspecialchars($cat['category_name']);
              $profit = number_format($cat['profit_margin'] ?? 20, 0); // Mặc định 20% nếu trống
              // Dùng trim() để loại bỏ khoảng trắng và empty() để kiểm tra chuỗi rỗng
              $desc = !empty(trim($cat['description'] ?? '')) ? htmlspecialchars($cat['description']) : 'Chưa có mô tả';
          ?>
                    <tr>
                        <td><?= $catID ?></td>
                        <td class="manage-name-category"><?= $catName ?></td>
                        <td><?= $profit ?>%</td>
                        <td><?= $desc ?></td>
                        <td class="function-button-container">
                            <button class="action-icon-btn edit-category-btn" title="Sửa" data-id="<?= $catID ?>"
                                data-name="<?= $catName ?>" data-profit="<?= $profit ?>" data-desc="<?= $desc ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="action-icon-btn manage-brands-btn" title="Quản lý thương hiệu"
                                data-id="<?= $catID ?>">
                                <i class="bi bi-sliders"></i>
                            </button>

                            <button class="action-icon-btn hide-btn" title="Ẩn">
                                <i class="bi bi-eye"></i>
                            </button>

                            <!-- logic xóa được xử lý bằng đoạn script ở cuối file, vì thẻ button không điều
                 hướng được nen dùng javascript để gửi dữ liệu đến handle_delete_category.php -->
                            <button class="action-icon-btn delete-btn" title="Xoá" data-id="<?= $catID ?>">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                    <?php 
            endforeach;
          else: 
          ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Chưa có dữ liệu phân loại sản phẩm.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="add-category-container" style="margin-top: 30px;">
                <h2 style="margin-bottom: 20px;">Thêm Thương Hiệu Mới</h2>
                <div class="add-form-category-products">
                    <input type="text" id="global-new-brand-name" style="flex-grow: 1;"
                        placeholder="Tên Thương Hiệu (ví dụ: Fender, Gibson...)" required>
                    <input type="text" id="global-new-brand-desc" style="flex-grow: 2;"
                        placeholder="Mô tả thương hiệu (Tùy chọn)">
                    <button type="button" onclick="addNewBrandGlobalDirect()" style="background-color: #0d6efd;">Thêm
                        thương hiệu</button>
                </div>
            </div>

            <hr style="margin: 50px 0; border-top: 2px dashed #ccc;">

            <h2 style="margin: 20px 0px;">Danh Sách Tất Cả Thương Hiệu Hiện Có</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 25%;">Tên Thương Hiệu</th>
                        <th style="width: 40%;">Mô tả</th>
                        <th style="width: 15%;">Ngày tạo</th>
                        <th style="width: 15%; text-align: center;">Chức năng</th>
                    </tr>
                </thead>
                <tbody id="global-brands-tbody">
                </tbody>
            </table>

            <!-- Pop up chỉnh sửa thương hiệu -->
            <div id="edit-info-brand" class="modal">
              <div class="modal-content-admin">
                  <span class="close-button-for-edit-info-brand">&times;</span>
                  <h2>Chỉnh sửa thương hiệu</h2>

                  <form onsubmit="saveBrandChanges(event)">
                      <input type="hidden" id="input-edit-id-brand">

                      <h3>Tên thương hiệu:
                          <input id="input-edit-namebrand" name="brand_name" type="text" style="border-radius: 25px; border: 1px solid #ccc; padding-left: 10px;" required>
                      </h3>

                      <hr>
                      <h3>Mô tả</h3>
                      <textarea id="mo_ta_brand" rows="4" cols="50"
                          placeholder="Nhập mô tả chi thương hiệu ở đây..."
                          style="border-radius: 25px; padding: 10px; width: 100%;"></textarea>

                      <div id="close-edit-info-brand-container">
                          <button type="submit" class="save-all-brands-btn">Lưu thay đổi</button>
                      </div>
                  </form>
              </div>
          </div>



            <!-- Pop up chỉnh sửa phân loại -->
            <div id="edit-info-category" class="modal">
                <div class="modal-content-admin">
                    <span class="close-button-for-edit-info-category">&times;</span>
                    <h2>Chỉnh sửa phân loại</h2>

                    <form action="" method="POST">
                        <input type="hidden" name="category_id" id="input-edit-id-category">

                        <h3>Tên loại:
                            <input id="input-edit-namecategory" name="category_name" type="text" value="" required>
                        </h3>

                        <hr>
                        <h3>% Lợi nhuận:
                            <input id="input-edit-profitcategory" name="profit_margin" type="number" min="0" max="999"
                                style="width: 80px;">
                        </h3>

                        <hr>
                        <h3>Mô tả</h3>
                        <textarea id="mo_ta" name="description" rows="4" cols="50"
                            placeholder="Nhập mô tả chi tiết sản phẩm ở đây..."
                            style="border-radius: 25px; padding: 10px;"></textarea>

                        <div id="close-edit-category-container">
                            <button type="submit" class="close-button-for-edit-category-container">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Pop up quản lý thương hiệu -->
            <div id="edit-brands-modal" class="modal">
                <div class="modal-content-admin">
                    <span class="close-button-for-edit-brands">&times;</span>
                    <div id="brandList">
                        <h3 id="brand-modal-title">Danh sách thương hiệu:</h3>

                        <input type="hidden" id="current-category-id">

                        <div class="brandsContainer">
                            <table class="brandsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 45%; text-align: left;">Thương hiệu</th>
                                        <th style="width: 30%; text-align: left;">Lợi nhuận</th>
                                        <th style="width: 25%;">Tuỳ chỉnh</th>
                                    </tr>
                                </thead>
                                <tbody id="brands-tbody">
                                </tbody>
                            </table>
                        </div>

                        <div class="addBrandsForm">
                            <input id="new-brand-name" class="inputBrandsForm" placeholder="Tên thương hiệu mới...">
                            <button type="button" id="btn-add-brand-quick" class="addBrandsButton">Thêm</button>
                        </div>

                        <div class="modal-footer-admin">
                            <button type="button" id="btn-close-brands-modal" class="save-all-brands-btn">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>






    </main>

    <?php require_once __DIR__ . "/forms/footer.php" ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php 
    require_once __DIR__ . "/forms/scripts.php"
  ?>
</body>
<!-- Xử lý nếu đăng xuát xoá local storage -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toàn bộ code bên trong sẽ chỉ chạy sau khi DOM đã được tải hoàn toàn

    // 1. Lấy ra phần tử nút Đăng xuất
    const logoutButton = document.getElementById('admin-logout-button');

    // 2. Thêm trình lắng nghe sự kiện khi nhấp chuột
    if (logoutButton) { // Thêm kiểm tra an toàn
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn hành vi mặc định của liên kết/nút

            // 3. XÓA TRẠNG THÁI ĐĂNG NHẬP KHỎI LOCALSTORAGE
            localStorage.removeItem('admin_isLoggedIn');

            // 4. CHUYỂN HƯỚNG người dùng về trang đăng nhập
            window.location.href = 'admin_login.html';
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === TOAST ĐỊNH NGHĨA ===
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 500,
      timerProgressBar: true,
      didOpen: (toast) => {
          // --- DÒNG QUAN TRỌNG NHẤT ---
          // Mỗi khi một Toast mới mở ra, ta ép các Toast cũ phải "câm lặng" hoàn toàn
          // bằng cách dừng mọi bộ đếm thời gian đang tồn tại.
          if (Swal.getTimerLeft()) {
              Swal.stopTimer();
          }
          
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
      }
    });

    const eyeIconSrc = 'assets/img/iconbutton/eye.png';
    const eyeCrossedIconSrc = 'assets/img/iconbutton/eye-crossed.png';

    // === ẨN / HIỆN DANH MỤC ===
    const hideButtons = document.querySelectorAll('.hide-btn');
    hideButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = button.querySelector('.button-icon');
            const row = button.closest('tr');
            const categoryName = row.querySelector('.manage-name-category').textContent.trim();

            let newStateTitle = '';
            let toastMessage = '';

            if (button.title === 'Ẩn') {
                icon.src = eyeCrossedIconSrc;
                icon.alt = 'Hiện';
                newStateTitle = 'Hiện';
                toastMessage = `Đã ẩn: <strong>${categoryName}</strong>`;
            } else {
                icon.src = eyeIconSrc;
                icon.alt = 'Ẩn';
                newStateTitle = 'Ẩn';
                toastMessage = `Đã hiện: <strong>${categoryName}</strong>`;
            }

            button.title = newStateTitle;

            // TOAST
            Toast.fire({
                icon: 'success',
                html: toastMessage
            });
        });
    });

    // === XÓA DANH MỤC ===
    
});

// === THÊM DANH MỤC MỚI ===
function addNewCategory() {
    const newCategoryNameInput = document.getElementById('newCategoryName');
    const name = newCategoryNameInput.value.trim() || '';

    // === GỌI API THÊM Ở ĐÂY ===

    // HIỆN TOAST
    Toast.fire({
        icon: 'success',
        html: `Đã thêm thành công <strong>${name}</strong>!`
    });

    // XÓA FORM
    newCategoryNameInput.value = '';
    const profitInput = document.querySelector('.add-form-category-products input[placeholder="Lợi nhuận(%)"]');
    if (profitInput) profitInput.value = '';
    const descInput = document.getElementById('newCategoryDescription');
    if (descInput) descInput.value = '';
}
</script>

<!-- dùng để thông báo khi thêm 1 phân loại nào đó
    bước 1: chuyển hướng đến trang handle_add_category
    bước 2: thêm vào database vào tạo message sessionStorage (cần khai báo session_start() trước đó)
    bước 3: chuyển hướng về lại admin quanlyphanloai
    bước 4: file main.js được nhúng vào sẽ đọc được message đó và hiển thị thông báo -->
<?php
if (isset($_SESSION['toast_message'])) {
    $msg = addslashes($_SESSION['toast_message']);
    $type = $_SESSION['toast_type'] ?? 'info';
    
    echo "<script>
        window.globalToast = {
            type: '$type',
            message: '$msg'
        };
    </script>";

    unset($_SESSION['toast_message']);
    unset($_SESSION['toast_type']);
}
?>

</html>