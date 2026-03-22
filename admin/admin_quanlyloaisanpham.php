<?php
$title = "Quản lý loại sản phẩm";
require_once(__DIR__ . '/forms/init.php');
include __DIR__ . "/forms/head.php";
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
      <div class="add-form-category-products">
        <input type="text" id="newCategoryName" style="flex-grow: 1;"
          placeholder="Tên Loại Sản Phẩm (ví dụ: Guitar Acoustic)">
        <input type="text" id="" style="width: 120px;" placeholder="Lợi nhuận(%)">
        <input type="text" id="newCategoryDescription" style="flex-grow: 1;" placeholder="Mô tả (Tùy chọn)">
        <button onclick="addNewCategory()">Thêm mới</button>
      </div>

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
          <tr>
            <td>1</td>
            <td class="manage-name-category">Guitar Acoustic</td>
            <td>25%</td>
            <td>Dòng guitar thùng sử dụng dây kim loại.</td>
            <td class="function-button-container">
              <button class="edit-category-btn action-icon-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
              <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
              <button class="hide-btn action-icon-btn" title="Ẩn"><img src="assets/img/iconbutton/eye.png"
                  class="button-icon" alt="Ẩn"></button>
              <button class="manage-brands-btn action-icon-btn" title="Quản lý thương hiệu"><img
                  src="assets/img/iconbutton/settings-sliders.png" class="button-icon"
                  alt="Quản lý thương hiệu"></button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td class="manage-name-category">Guitar Classic</td>
            <td>30%</td>
            <td>Dòng guitar thùng sử dụng dây nylon.</td>
            <td class="function-button-container">
              <button class="edit-category-btn action-icon-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
              <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
              <button class="hide-btn action-icon-btn" title="Ẩn"><img src="assets/img/iconbutton/eye.png"
                  class="button-icon" alt="Ẩn"></button>
              <button class="manage-brands-btn action-icon-btn" title="Quản lý thương hiệu"><img
                  src="assets/img/iconbutton/settings-sliders.png" class="button-icon"
                  alt="Quản lý thương hiệu"></button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- Pop up chỉnh sửa phân loại -->
      <div id="edit-info-category" class="modal">
        <div class="modal-content-admin">
          <span class="close-button-for-edit-info-category">&times;</span>
          <h2>Chỉnh sửa phân loại: </h2>
          <h3>Tên loại: <input id="input-edit-namecategory" type="text" value=""></h3>

          <hr>
          <h3>% Lợi nhuận: <input id="input-edit-profitcategory" type="number" min="0" max="999" style="width: 80px;">
          </h3>

          <hr>
          <h3>Mô tả</h3>
          <textarea id="mo_ta" name="product_description" rows="4" cols="50"
            placeholder="Nhập mô tả chi tiết sản phẩm ở đây..." style="border-radius: 25px; padding: 10px;"></textarea>

          <div id="close-edit-category-container">
            <button class="close-button-for-edit-category-container">Lưu</button>
          </div>
        </div>
      </div>


      <!-- Pop up quản lý thương hiệu -->
      <div id="edit-brands-modal" class="modal">
        <div class="modal-content-admin">
          <span class="close-button-for-edit-brands">&times;</span>
          <div id="brandList">
            <h3>Danh sách thương hiệu hiện có:</h3>
            <div class="brandsContainer">
              <table class="brandsTable">
                <thead>
                  <tr>
                    <th style="width: 50%;">Thương hiệu</th>
                    <th style="width: 25%;">Lợi nhuận</th>
                    <th style="width: 25%;">Tuỳ chỉnh</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Saga</td>
                    <td>20%</td>
                    <td><input type="text" class="brand-edit-input"></td>
                  </tr>
                  <tr>
                    <td>Taylor</td>
                    <td>10000%</td>
                    <td><input type="text" class="brand-edit-input"></td>
                  </tr>
                  <tr>
                    <td>Takamine</td>
                    <td>0%</td>
                    <td><input type="text" class="brand-edit-input"></td>
                  </tr>
                  <tr>
                    <td>Takamine</td>
                    <td>0%</td>
                    <td><input type="text" class="brand-edit-input"></td>
                  </tr>
                  <tr>
                    <td>Takamine</td>
                    <td>0%</td>
                    <td><input type="text" class="brand-edit-input"></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="addBrandsForm">
              <input class="inputBrandsForm" placeholder="Thêm thương hiệu (Lợi nhuận sẽ mặc định theo phân loại)">

              </input>
              <div class="addBrandsButton">Thêm</div>
            </div>
            <div class="modal-footer-admin">
              <button id="save-brands-list-btn" class="save-all-brands-btn">Lưu thay đổi</button>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const eyeIconSrc = 'assets/img/iconbutton/eye.png';
    const eyeCrossedIconSrc = 'assets/img/iconbutton/eye-crossed.png';

    // === ẨN / HIỆN DANH MỤC ===
    const hideButtons = document.querySelectorAll('.hide-btn');
    hideButtons.forEach(button => {
      button.addEventListener('click', function () {
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
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const row = button.closest('tr');
        const categoryName = row.querySelector('.manage-name-category').textContent.trim();

        // Giữ popup xác nhận (quan trọng)
        Swal.fire({
          title: 'Xác nhận xóa?',
          html: `Loại: <strong>${categoryName}</strong> sẽ bị xóa vĩnh viễn.`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Xóa',
          cancelButtonText: 'Hủy'
        }).then((result) => {
          if (result.isConfirmed) {
            // === GỌI API XÓA Ở ĐÂY ===
            // row.remove();

            Toast.fire({
              icon: 'success',
              html: `Đã xóa: <strong>${categoryName}</strong>`
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Toast.fire({
              icon: 'info',
              html: 'Đã hủy xóa'
            });
          }
        });
      });
    });
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

</html>