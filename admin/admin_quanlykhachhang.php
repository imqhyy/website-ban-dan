<?php
$title = "Quản lý khách hàng";
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý khách hàng</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.html">Trang chủ</a></li>
            <li class="current">Quản lý khách hàng</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <div class="container-manage-import-products">
      
    
      <form action="" class="search-container" method="get"><!-- Search box -->
        <input type="text" id="search-input" placeholder="Tìm kiếm" name="search">
        <button id="search-button">
          <i class="fa fa-search"></i> Tìm kiếm
        </button>
      </form><!-- End Search box -->

      <div class="sort-container"> <!-- Sort-container -->
        <button id="sort-button" onclick="sortCustomers('asc')">
          Sắp xếp A → Z
        </button>
        <button id="sort-button" onclick="sortCustomers('dsc')">
          Sắp xếp Z → A
        </button>
      </div>


      <div><!-- Thông tin khách hàng -->
        <!--Khách hàng 1-->
        <div class="customer-card">
          <div class="customer-avatar-container">
            <img src="assets/img/person/gdragon.png" class="customer-avatar" atl="avatar khách hàng">
          </div>
          <div class="customer-info">
            <p class="customer-name">Ji Đa Gòn</p>
            <p class="customer-phone">0987654321</p>
          </div>
          <div class="customer-actions">
            <button class="action-btn reset-btn" onclick="resetPassword('chautinktri123@gmail.com')">
              Reset Mật khẩu </button>
            <button class="action-btn lock-btn btn-success" onclick="toggleLock(this)">
              Khóa Tài khoản
            </button>
            <button class="action-btn detail-btn">Chi tiết</button>
          </div>
        </div>

        <!--Khách hàng 2-->
        <div class="customer-card">
          <div class="customer-avatar-container">
            <img src="assets/img/person/chautinhtri.jpg" class="customer-avatar" atl="avatar khách hàng">
          </div>
          <div class="customer-info">
            <p class="customer-name">Châu Tinh Trì</p>
            <p class="customer-phone">0987654321</p>
          </div>
          <div class="customer-actions">
            <button class="action-btn reset-btn" onclick="resetPassword('chautinktri123@gmail.com')">
              Reset Mật khẩu </button>
            <button class="action-btn lock-btn btn-success" onclick="toggleLock(this)">
              Khóa Tài khoản
            </button>
            <button class="action-btn detail-btn">Chi tiết</button>
          </div>
        </div>

        <!--Khách hàng 3-->
        <div class="customer-card">
          <div class="customer-avatar-container">
            <img src="assets/img/person/datvantay.jpg" class="customer-avatar" atl="avatar khách hàng">
          </div>
          <div class="customer-info">
            <p class="customer-name">Đạt Văn Tây</p>
            <p class="customer-phone">0334342323</p>
          </div>
          <div class="customer-actions">
            <button class="action-btn reset-btn" onclick="resetPassword('chautinktri123@gmail.com')">
              Reset Mật khẩu </button>
            <button class="action-btn lock-btn btn-success" onclick="toggleLock(this)">
              Khóa Tài khoản
            </button>
            <button class="action-btn detail-btn">Chi tiết</button>
          </div>
        </div>

        <!--Khách hàng 4-->
        <div class="customer-card">
          <div class="customer-avatar-container">
            <img src="assets/img/person/soicodoc.jpg" class="customer-avatar" atl="avatar khách hàng">
          </div>
          <div class="customer-info">
            <p class="customer-name">Sói Cô Độc</p>
            <p class="customer-phone">0343242344</p>
          </div>
          <div class="customer-actions">
            <button class="action-btn reset-btn" onclick="resetPassword('chautinktri123@gmail.com')">
              Reset Mật khẩu </button>
            <button class="action-btn lock-btn btn-success" onclick="toggleLock(this)">
              Khóa Tài khoản
            </button>
            <button class="action-btn detail-btn">Chi tiết</button>
          </div>
        </div>
        <!-- Pop-up chi tiết -->
        <div id="DetailModal" class="modal">
          <div class="modal-content-admin" style="margin: 10% auto;">
            <span class="close-button">&times;</span>
            <h2>Chi tiết Khách hàng</h2>
            <div class="customer-info-details-container">
              <div class="avt-container">
                <div class="customer-avatar-details-container">
                  <img src="assets/img/person/images.jpg" id="modalImage" class="customer-avatar-details"
                    atl="avatar khách hàng">
                </div>
              </div>
              
              <div>
                <p class="customer-info-details"><strong>Tên: </strong> <span id="modalName"></span></p>
                <p class="customer-info-details"><strong>SĐT: </strong> <span id="modalPhone"></span></p>
                <p class="customer-info-details"><strong>Ngày đăng ký: </strong> <span>1/1/2021</span></p>
                <p class="customer-info-details"><strong>Số lần đặt hàng: </strong> <span>100</span></p>
                <p class="customer-info-details"><strong>Danh hiệu: </strong> <span>Cổ đông lớn nhất</span></p>
                <p class="customer-info-details"><strong>Email: </strong>chautinktri123@gmail.com</p>
                <p class="customer-info-details"><strong>Địa chỉ: </strong>7 Lê Trọng Tấn phường Bình Tân thành phố Hồ Chí
                  Minh</p>
              </div>
            </div>
          </div>
        </div>


      </div><!-- End Thông tin khách hàng -->
      


      <!-- Category Pagination Section -->
        <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0px;">
          <div class="container">
            <nav class="d-flex justify-content-center" aria-label="Page navigation">
              <ul>
                <li> <a href="#" aria-label="Previous page"> <i class="bi bi-arrow-left"></i>
                    <span class="d-none d-sm-inline">Trước</span>
                  </a> </li>
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li class="ellipsis">...</li>
                <li><a href="#">8</a></li>
                <li><a href="#">9</a></li>
                <li><a href="#">10</a></li>
                <li> <a href="#" aria-label="Next page">
                    <span class="d-none d-sm-inline">Sau</span>
                    <i class="bi bi-arrow-right"></i>
                  </a> </li>
              </ul>
            </nav>
          </div>
        </section><!-- /Category Pagination Section -->

    </div> <!--End container manage import products-->
    



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
<!-- xu ly thong bao cho cac nut chuc nang trong quan ly khach hang -->
<script>

  function resetPassword(text) {
    Swal.fire({
      icon: 'success',
      title: 'Đã gửi!',
      text: `Link đặt lại mật khẩu đã được gửi đến email ${text}`,
      timer: 1500,
      showConfirmButton: false
    });
  }
  function toggleLock(button) {
    const isLocked = button.textContent.includes('Khóa');
    button.textContent = isLocked ? 'Mở khóa' : 'Khóa Tài khoản';
    button.classList.toggle('btn-warning', isLocked);
    button.classList.toggle('btn-success', !isLocked);

    Swal.fire({
      icon: isLocked ? 'warning' : 'success',
      title: isLocked ? 'Đã khóa!' : 'Đã mở khóa!',
      text: isLocked ? 'Tài khoản đã bị khóa' : 'Tài khoản đã được mở khóa',
      timer: 1500,
      showConfirmButton: false
    });
  }
</script>

</html>