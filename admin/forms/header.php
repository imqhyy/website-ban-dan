<header id="header" class="header sticky-top">
  <!-- Top Bar -->
  <div class="top-bar py-2 d-none">
    <div class="container-fluid container-xl">
      <div class="row align-items-center">
        <div class="col-lg-4 d-none d-lg-flex">
          <div class="top-bar-item">
            <i class="bi bi-telephone-fill me-2"></i>
            <span>Cần giúp đỡ? Liên hệ chúng tôi: </span>
            <a href="tel:+1234567890">0123456789</a>
          </div>
        </div>

        <div class="col-lg-4 col-md-12 text-center">
          <div class="announcement-slider swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                  "loop": false,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 1,
                  "direction": "vertical",
                  "effect": "slide"
                }
              </script>
            <div class="swiper-wrapper">
              <div class="swiper-slide">🚚 Không miễn phí giao hàng cho đơn hàng trên 2.000.000VND</div>
              <div class="swiper-slide">💰 Không đảm bảo hoàn tiền trong 30 ngày.</div>
              <div class="swiper-slide">🎁 Không giảm giá 20% cho đơn hàng đầu tiên</div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>

  <!-- Main Header -->
  <div class="main-header">
    <div class="container-fluid container-xl">
      <div class="d-flex py-3 align-items-center justify-content-between">

        <!-- Logo -->
        <a href="admin.php" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.webp" alt=""> -->
          <h1 class="sitename">Guitar Xì Gòn</h1>
        </a>



        <!-- Actions -->
        <div class="header-actions d-flex align-items-center justify-content-end">

          <!-- Mobile Search Toggle -->
          <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
            <i class="bi bi-search"></i>
          </button>

          <!-- Account -->
          <div class="dropdown account-dropdown">
            <button class="header-action-btn" data-bs-toggle="dropdown">
              <i class="bi bi-person"></i>
            </button>
            <div class="dropdown-menu">
              <div class="dropdown-header">
                <h6>Chào mừng đến với <span class="sitename">Guitar Xì Gòn</span></h6>
                <p class="mb-0">Truy cập tài khoản &amp; quản lý đơn hàng</p>
              </div>
              <div class="dropdown-body">
                <a class="dropdown-item d-flex align-items-center" href="admin_account.php#">
                  <i class="bi bi-person-circle me-2"></i>
                  <span>Hồ sơ của tôi</span>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="admin_account.php#settings">
                  <i class="bi bi-gear me-2"></i>
                  <span>Cài đặt</span>
                </a>
              </div>
              <div class="dropdown-footer">
                <?php if (!empty($_SESSION['admin'])): ?>
                  <a href="admin_logout.php" class="btn btn-outline-primary w-100">Đăng xuất</a>
                <?php else: ?>
                  <a href="admin_login.php" class="btn btn-outline-primary w-100">Đăng nhập</a>
                <?php endif; ?>
              </div>
            </div>
          </div>


          <!-- Mobile Navigation Toggle -->
          <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>

        </div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <div class="header-nav">
    <div class="container-fluid container-xl position-relative">
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="admin.php">Báo cáo nhập - xuất</a></li>
          <li><a href="admin_quanlykhachhang.php">Quản lý khách hàng</a></li>
          <li><a href="admin_quanlyloaisanpham.php">Quản lý loại sản phẩm</a></li>
          <li><a href="admin_danhmucsanpham.php">Quản lý danh mục sản phẩm</a></li>
          <li><a href="admin_quanlynhapsanpham.php">Quản lý nhập sản phẩm</a></li>
          <li><a href="admin_quanlydonhang.php">Quản lý đơn hàng</a></li>
          <li><a href="admin_quanlytonkho.php">Quản lý tồn kho</a></li>

          <li><a href="admin_quanlyreview.php">Quản lý Đánh giá</a></li>
        </ul>
      </nav>
    </div>
  </div>


</header>