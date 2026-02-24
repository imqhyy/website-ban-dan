
    <header id="header" class="header">
      <!-- Top Bar -->
      <div class="top-bar py-2">
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
                    "loop": true,
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
                  <div class="swiper-slide">
                    🚚 Miễn phí giao hàng cho đơn hàng trên 2.000.000VND
                  </div>
                  <div class="swiper-slide">
                    💰 Đảm bảo hoàn tiền trong 30 ngày.
                  </div>
                  <div class="swiper-slide">
                    🎁 Giảm giá 20% cho đơn hàng đầu tiên
                  </div>
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
            <a href="index.php" class="logo d-flex align-items-center">
              <!-- Uncomment the line below if you also wish to use an image logo -->
              <!-- <img src="assets/img/logo.webp" alt=""> -->
              <h1 class="sitename">Guitar Xì Gòn</h1>
            </a>

            <!-- Search -->
            <form class="search-form desktop-search-form" action="search-results.php">
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Tìm kiếm sản phẩm"
                />
                <button class="btn" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>

            <!-- Actions -->
            <div
              class="header-actions d-flex align-items-center justify-content-end"
            >
              <!-- Mobile Search Toggle -->
              <button
                class="header-action-btn mobile-search-toggle d-xl-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mobileSearch"
                aria-expanded="false"
                aria-controls="mobileSearch"
              >
                <i class="bi bi-search"></i>
              </button>

              <!-- Account -->
              <div class="dropdown account-dropdown">
                <button class="header-action-btn" data-bs-toggle="dropdown">
                  <i class="bi bi-person"></i>
                </button>
                <div class="dropdown-menu">
                  <div class="dropdown-header">
                    <h6>
                      Chào mừng đến với
                      <span class="sitename">Guitar Xì Gòn</span>
                    </h6>
                    <p class="mb-0">
                      Truy cập tài khoản &amp; quản lý đơn hàng
                    </p>
                  </div>
                  <div class="dropdown-body">
                    <a
                      class="dropdown-item d-flex align-items-center"
                      href="account.php#"
                    >
                      <i class="bi bi-person-circle me-2"></i>
                      <span>Hồ sơ của tôi</span>
                    </a>
                    <a
                      class="dropdown-item d-flex align-items-center"
                      href="account.php#orders"
                    >
                      <i class="bi bi-bag-check me-2"></i>
                      <span>Đơn hàng của tôi</span>
                    </a>
                    <!-- <a class="dropdown-item d-flex align-items-center" href="account.php#wishlist">
                    <i class="bi bi-heart me-2"></i>
                    <span>Danh sách mong muốn</span>
                  </a> -->
                    <a
                      class="dropdown-item d-flex align-items-center"
                      href="account.php#settings"
                    >
                      <i class="bi bi-gear me-2"></i>
                      <span>Cài đặt</span>
                    </a>
                  </div>
                  <div class="dropdown-footer" id="user-session"></div>
                </div>
              </div>
              <!-- Cart -->
              <a href="cart.php" class="header-action-btn">
                <i class="bi bi-cart3"></i>
                <span class="badge">3</span>
              </a>

              <!-- Mobile Navigation Toggle -->
              <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <div class="header-nav" style="position: sticky; top: 0;">
        <div class="container-fluid container-xl position-relative">
          <nav id="navmenu" class="navmenu">
            <ul>
              <li><a href="index.php">Trang chủ</a></li>
              <li><a href="all.php">Tất cả sản phẩm</a></li>
              <li class="dropdown">
                <a href="#"
                  ><span>Phân loại</span>
                  <i class="bi bi-chevron-down toggle-dropdown"></i
                ></a>
                <ul>
                  <li class="dropdown">
                    <a href="category_detail.php"
                      ><span>Guitar Classic</span
                      ><i class="bi bi-chevron-right toggle-dropdown"></i
                    ></a>
                    <ul>
                      <li><a href="brand.php">Ba đờn</a></li>
                      <li><a href="brand.php">Yamaha</a></li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="category_detail.php"
                      ><span>Guitar Acoustic</span
                      ><i class="bi bi-chevron-right toggle-dropdown"></i
                    ></a>
                    <ul>
                      <li><a href="brand.php">Saga</a></li>
                      <li><a href="brand.php">Taylor</a></li>
                      <li><a href="brand.php">Enya</a></li>
                      <li><a href="brand.php">Yamaha</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li><a href="cart.php">Giỏ Hàng</a></li>
              <li><a href="checkout.php">Thanh toán</a></li>
              <!-- <li><a href="contact.php">Liên hệ</a></li> -->
              <li><a href="about.php">Về chúng tôi</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <!-- Mobile Search Form -->
      <div class="collapse" id="mobileSearch">
        <div class="container">
          <form class="search-form">
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                placeholder="Tìm kiếm sản phẩm"
              />
              <button class="btn" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </header>