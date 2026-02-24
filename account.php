<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Tài khoản - Guitar Xì Gòn</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/account_admin.css" rel="stylesheet">
  <!--Dùng chung vì css này hiện tại chỉ có chức năng định dạng input ảnh-->

  <!-- =======================================================
  * Template Name: NiceShop
  * Template URL: https://bootstrapmade.com/niceshop-bootstrap-ecommerce-template/
  * Updated: Aug 26 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="account-page">
  <?php include 'forms/header.php' ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Tài khoản</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Trang chủ</a></li>
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
                  <img src="assets\img\person\images.jpg" alt="Profile" loading="lazy">
                  <span class="status-badge"><i class="bi bi-shield-check"></i></span>
                </div>
                <h4 id="user-display-name">Long G</h4>
                <h6 style="color: rgb(129, 129, 128);">user: gnevadie</h6>
                <div class="user-status">
                  <i class="bi bi-award"></i>
                  <span>Thành viên phá phách</span>
                </div>
              </div>

              <!-- Navigation Menu -->
              <nav class="menu-nav">
                <ul class="nav flex-column" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#orders">
                      <i class="bi bi-box-seam"></i>
                      <span>Đơn hàng của tôi</span>
                      <span class="badge">5</span>
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#wishlist">
                      <i class="bi bi-heart"></i>
                      <span>Danh sách mong muốn</span>
                      <span class="badge">12</span>
                    </a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#wallet">
                      <i class="bi bi-wallet2"></i>
                      <span>Phương thức thanh toán</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                      <i class="bi bi-star"></i>
                      <span>Đánh giá của tôi</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#addresses">
                      <i class="bi bi-geo-alt"></i>
                      <span>Địa chỉ</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings">
                      <i class="bi bi-gear"></i>
                      <span>Cài đặt</span>
                    </a>
                  </li>
                </ul>

                <div class="menu-footer">
                  <a href="support.html" class="help-link">
                    <i class="bi bi-question-circle"></i>
                    <span>Trung tâm hỗ trợ</span>
                  </a>
                  <a href="#" class="logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Đăng xuất</span>
                  </a>
                </div>
              </nav>
            </div>
          </div>

          <!-- Content Area -->
          <div class="col-lg-9">
            <div class="content-area">
              <div class="tab-content">
                <!-- Orders Tab -->
                <div class="tab-pane fade show active" id="orders">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Đơn hàng của tôi</h2>
                    <div class="header-actions">
                      <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Tìm kiếm đơn hàng...">
                      </div>
                      <div class="dropdown">
                        <button class="filter-btn" data-bs-toggle="dropdown">
                          <i class="bi bi-funnel"></i>
                          <span>Lọc</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Tất cả đơn hàng</a></li>
                          <li><a class="dropdown-item" href="#">Đang xử lý</a></li>
                          <li><a class="dropdown-item" href="#">Đã giao</a></li>
                          <li><a class="dropdown-item" href="#">Đã nhận</a></li>
                          <li><a class="dropdown-item" href="#">Đã huỷ</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="orders-grid">
                    <!-- Order Card 1 -->
                    <div class="order-card" data-aos="fade-up" data-aos-delay="100">
                      <div class="order-header">
                        <div class="order-id">
                          <span class="label">Mã đơn hàng:</span>
                          <span class="value">#ORD-2024-1278</span>
                        </div>
                        <div class="order-date" id="order-date"></div>

                        <script>
                          document.getElementById('order-date').textContent =
                            new Date().toLocaleDateString('vi-VN');
                        </script>
                      </div>
                      <div class="order-content">
                        <div class="product-grid">
                          <a href="product-details.html">
                            <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                              loading="lazy">
                          </a>
                          <a href="product-details.html">
                            <img
                              src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                              alt="Product" loading="lazy">
                          </a>
                          <a href="product-details.html">
                            <img src="assets/img/product/guitar/acoustic/taylor/taylor-110e/1.jpg" alt="Product"
                              loading="lazy">
                          </a>
                        </div>
                        <div class="order-info">
                          <div class="info-row">
                            <span>Tình trạng:</span>
                            <span class="status processing">Đang xử lý</span>
                          </div>
                          <div class="info-row">
                            <span>SL:</span>
                            <span>3</span>
                          </div>
                          <div class="info-row">
                            <span>Total:</span>
                            <span class="price">701.000.000 VND</span>
                          </div>
                        </div>
                      </div>
                      <div class="order-footer">
                        <button type="button" class="btn-track" data-bs-toggle="collapse" data-bs-target="#tracking1"
                          aria-expanded="false">Theo dõi đơn hàng</button>
                        <button type="button" class="btn-details" data-bs-toggle="collapse" data-bs-target="#details1"
                          aria-expanded="false">Xem chi tiết</button>
                      </div>

                      <!-- Order Tracking -->
                      <div class="collapse tracking-info" id="tracking1">
                        <div class="tracking-timeline">
                          <div class="timeline-item completed">
                            <div class="timeline-icon">
                              <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đã xác nhận đơn hàng</h5>
                              <p>Đơn hàng của bạn đã được xác nhận</p>
                              <span class="timeline-date">20/02/2025 - 10:30 AM</span>
                            </div>
                          </div>

                          <div class="timeline-item completed">
                            <div class="timeline-icon">
                              <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đang xử lý</h5>
                              <p>Đơn hàng của bạn đang được chuẩn bị</p>
                              <span class="timeline-date">20/02/2025 - 2:45 PM</span>
                            </div>
                          </div>

                          <div class="timeline-item active">
                            <div class="timeline-icon">
                              <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đang đóng gói</h5>
                              <p>Đơn hàng của bạn đang được đóng gói và bàn giao cho đơn vị vận chuyển</p>
                              <span class="timeline-date">20/02/2025 - 4:15 PM</span>
                            </div>
                          </div>

                          <div class="timeline-item">
                            <div class="timeline-icon">
                              <i class="bi bi-truck"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đang vận chuyển</h5>
                              <p>Dự kiến giao hàng trong vòng 24 tiếng</p>
                            </div>
                          </div>

                          <div class="timeline-item">
                            <div class="timeline-icon">
                              <i class="bi bi-house-door"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đã nhận được hàng</h5>
                              <p>Thời gian nhận ước tính: 22/2/2025</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Order Details -->
                      <div class="collapse order-details" id="details1">
                        <div class="details-content">
                          <div class="detail-section">
                            <h5>Thông tin đặt hàng</h5>
                            <div class="info-grid">
                              <div class="info-item">
                                <span class="label">Phương thức thanh toán</span>
                                <span class="value">Credit Card (**** 4589)</span>
                              </div>
                              <div class="info-item">
                                <span class="label">Phương thức vận chuyển</span>
                                <span class="value">Express Delivery (2-3 ngày)</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Mặt hàng (3)</h5>
                            <div class="order-items">
                              <div class="item">
                                <a href="product-details.html">
                                  <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                                    loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Enya EA X2</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-001</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">50.000.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img
                                    src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                                    alt="Product" loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Saga A1 DE PRO</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-002</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">50.000.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img src="assets/img/product/guitar/acoustic/taylor/taylor-110e/1.jpg" alt="Product"
                                    loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Taylor 110E</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-003</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">100.000.000 VND</div>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Chi tiết giá</h5>
                            <div class="price-breakdown">
                              <div class="price-row">
                                <span>Tổng sản phẩm</span>
                                <span>200.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Phí vận chuyển</span>
                                <span>1.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Thuế</span>
                                <span>500.000.000 VND</span>
                              </div>
                              <div class="price-row total">
                                <span>Tổng</span>
                                <span>701.000.000 VND</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Địa chỉ giao hàng</h5>
                            <div class="address-info">
                              <p>Long Ma Bắc Giang<br>123 đường vào tim em ôi băng giá<br>phường A<br> thành phố B, HCM
                                70000<br>Việt Nam</p>
                              <p class="contact">SĐT: 0123123123</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Order Card 2 -->
                    <div class="order-card" data-aos="fade-up" data-aos-delay="200">
                      <div class="order-header">
                        <div class="order-id">
                          <span class="label">Mã đơn hàng:</span>
                          <span class="value">#ORD-2024-1265</span>
                        </div>
                        <div class="order-date">15/02/2025</div>
                      </div>
                      <div class="order-content">
                        <div class="product-grid">
                          <a href="product-details.html">
                            <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                              loading="lazy">
                          </a>
                          <a href="product-details.html">
                            <img
                              src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                              alt="Product" loading="lazy">
                          </a>
                        </div>
                        <div class="order-info">
                          <div class="info-row">
                            <span>Tình trạng:</span>
                            <span class="status shipped">Đang vận chuyển</span>
                          </div>
                          <div class="info-row">
                            <span>SL:</span>
                            <span>2</span>
                          </div>
                          <div class="info-row">
                            <span>Tổng</span>
                            <span class="price">204.000.000 VND</span>
                          </div>
                        </div>
                      </div>
                      <div class="order-footer">
                        <button type="button" class="btn-track" data-bs-toggle="collapse" data-bs-target="#tracking2"
                          aria-expanded="false">Theo dõi đơn hàng</button>
                        <button type="button" class="btn-details" data-bs-toggle="collapse" data-bs-target="#details2"
                          aria-expanded="false">Xem Chi tiết</button>
                      </div>

                      <!-- Order Tracking -->
                      <div class="collapse tracking-info" id="tracking2">
                        <div class="tracking-timeline">
                          <div class="timeline-item completed">
                            <div class="timeline-icon">
                              <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đã xác nhận đơn hàng</h5>
                              <p>Đơn hàng của bạn đã được xác nhận</p>
                              <span class="timeline-date">15/02/2025 - 9:15 AM</span>
                            </div>
                          </div>

                          <div class="timeline-item completed">
                            <div class="timeline-icon">
                              <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đang xử lý</h5>
                              <p>Đơn hàng của bạn đang được chuẩn bi</p>
                              <span class="timeline-date">15/02/2025 - 11:30 AM</span>
                            </div>
                          </div>

                          <div class="timeline-item completed">
                            <div class="timeline-icon">
                              <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đang đóng gói</h5>
                              <p>Đơn hàng của bạn đang được đóng gói và bàn giao cho đơn vị vận chuyển</p>
                              <span class="timeline-date">15/02/2025 - 2:45 PM</span>
                            </div>
                          </div>

                          <div class="timeline-item active">
                            <div class="timeline-icon">
                              <i class="bi bi-truck"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đang vận chuyển</h5>
                              <p>Đơn hàng của bạn đang tự đi đến chỗ bạn, đừng chú ý điện thoại, chúng tôi giao bất
                                thình lình</p>
                              <span class="timeline-date">16/02/2025 - 10:20 AM</span>
                              <div class="shipping-info">
                                <span>Mã vận chuyển: </span>
                                <span class="tracking-number">1Z999AA1234567890</span>
                              </div>
                            </div>
                          </div>

                          <div class="timeline-item">
                            <div class="timeline-icon">
                              <i class="bi bi-house-door"></i>
                            </div>
                            <div class="timeline-content">
                              <h5>Đã nhận được hàng</h5>
                              <p>Thời gian nhận ước tính: Chờ đợi là hạnh phúc</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Order Details -->
                      <div class="collapse order-details" id="details2">
                        <div class="details-content">
                          <div class="detail-section">
                            <h5>Thông tin đặt hàng</h5>
                            <div class="info-grid">
                              <div class="info-item">
                                <span class="label">Phương thức thanh toán</span>
                                <span class="value">Credit Card (**** 7821)</span>
                              </div>
                              <div class="info-item">
                                <span class="label">Phương thức vận chuyển</span>
                                <span class="value">Standard Shipping (3-5 ngày)</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Mặt hàng (2)</h5>
                            <div class="order-items">
                              <div class="item">
                                <a href="product-details.html">
                                  <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                                    loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Enya EA XXX</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-004</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">1.500.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img
                                    src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                                    alt="Product" loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Saga A1 DE YYY</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-005</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">1.500.000 VND</div>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Chi tiết giá</h5>
                            <div class="price-breakdown">
                              <div class="price-row">
                                <span>Tổng sản phẩm</span>
                                <span>3.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Phí vận chuyển</span>
                                <span>200.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Thuế</span>
                                <span>1.000.000</span>
                              </div>
                              <div class="price-row total">
                                <span>Tổng</span>
                                <span>204.000.000 VND</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Địa chỉ giao hàng</h5>
                            <div class="address-info">
                              <p>Young Pop Eyes<br>100 đường 30 tháng 2<br>phường Bình Thạnh<br>thành phố Hồ Chí Minh,
                                HCM 70000<br>Việt Nam</p>
                              <p class="contact">0123456788</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Order Card 3 -->
                    <div class="order-card" data-aos="fade-up" data-aos-delay="300">
                      <div class="order-header">
                        <div class="order-id">
                          <span class="label">Mã đơn hàng:</span>
                          <span class="value">#ORD-2024-1252</span>
                        </div>
                        <div class="order-date">10/2/2025</div>
                      </div>
                      <div class="order-content">
                        <div class="product-grid">
                          <a href="product-details.html">
                            <img
                              src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg"
                              alt="Product" loading="lazy">
                            <img
                              src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                              alt="Product" loading="lazy">
                          </a>
                        </div>
                        <div class="order-info">
                          <div class="info-row">
                            <span>Tình trạng</span>
                            <span class="status delivered">Đã vận chuyển</span>
                          </div>
                          <div class="info-row">
                            <span>SL</span>
                            <span>1</span>
                          </div>
                          <div class="info-row">
                            <span>Tổng</span>
                            <span class="price">3.000.000.000 VND</span>
                          </div>
                        </div>
                      </div>
                      <div class="order-footer">
                        <button type="button" class="btn-review" data-bs-toggle="collapse" data-bs-target="#review3"
                          aria-expanded="false">Viết đánh giá</button>
                        <button type="button" class="btn-details" data-bs-toggle="collapse" data-bs-target="#details3"
                          aria-expanded="false">Xem Chi tiết</button>
                      </div>

                      <!--Write Review-->
                      <div class="collapse order-details" id="review3">
                        <div class="details-content">
                          <div class="detail-section">
                            <h3>Đánh giá sản phẩm</h3>
                            <div class="review-product-item mb-4 pb-4 border-bottom">
                              <div class="d-flex align-items-center mb-3">
                                <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                                  loading="lazy" class="rounded-3 me-3"
                                  style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="product-details">
                                  <h6 class="mb-1 fw-bold">Enya EA XXX</h6>
                                  <span class="text-muted small">Mã sản phẩm: PRD-004 | SL: 1</span>
                                </div>
                              </div>
                              <div class="review-rating mb-3">
                                <label class="form-label fw-semibold">Chất lượng sản phẩm:</label>
                                <div class="star-rating-selector" data-product-id="PRD-004">
                                  <i class="bi bi-star star-icon" data-value="1"></i>
                                  <i class="bi bi-star star-icon" data-value="2"></i>
                                  <i class="bi bi-star star-icon" data-value="3"></i>
                                  <i class="bi bi-star star-icon" data-value="4"></i>
                                  <i class="bi bi-star star-icon" data-value="5"></i>
                                  <span class="rating-text ms-2 small text-muted"></span>
                                  <input type="hidden" name="rating_prd_004" value="0" class="rating-input">
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="reviewText_004" class="form-label fw-semibold">Nhận xét của bạn:</label>
                                <textarea class="form-control" id="reviewText_004" rows="3"
                                  placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."></textarea>
                              </div>
                              <button type="button" class="btn btn-sm btn-primary review-submit-btn">Gửi đánh
                                giá</button>
                            </div>
                            <div class="review-product-item mb-4 pb-4 border-bottom">
                              <div class="d-flex align-items-center mb-3">
                                <img
                                  src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                                  alt="Product" loading="lazy" class="rounded-3 me-3"
                                  style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="product-details">
                                  <h6 class="mb-1 fw-bold">Saga A1 DE YYY</h6>
                                  <span class="text-muted small">Mã sản phẩm: PRD-005 | SL: 1</span>
                                </div>
                              </div>
                              <div class="review-rating mb-3">
                                <label class="form-label fw-semibold">Chất lượng sản phẩm:</label>
                                <div class="star-rating-selector" data-product-id="PRD-005">
                                  <i class="bi bi-star star-icon" data-value="1"></i>
                                  <i class="bi bi-star star-icon" data-value="2"></i>
                                  <i class="bi bi-star star-icon" data-value="3"></i>
                                  <i class="bi bi-star star-icon" data-value="4"></i>
                                  <i class="bi bi-star star-icon" data-value="5"></i>
                                  <span class="rating-text ms-2 small text-muted"></span>
                                  <input type="hidden" name="rating_prd_005" value="0" class="rating-input">
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="reviewText_005" class="form-label fw-semibold">Nhận xét của bạn:</label>
                                <textarea class="form-control" id="reviewText_005" rows="3"
                                  placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."></textarea>
                              </div>
                              <button type="button" class="btn btn-sm btn-primary review-submit-btn">Gửi đánh
                                giá</button>
                            </div>

                          </div>
                        </div>
                      </div>

                      <!-- Order Details -->
                      <div class="collapse order-details" id="details3">
                        <div class="details-content">
                          <div class="detail-section">
                            <h5>Thông tin đặt hàng</h5>
                            <div class="info-grid">
                              <div class="info-item">
                                <span class="label">Phương thức thanh toán</span>
                                <span class="value">Credit Card (**** 7821)</span>
                              </div>
                              <div class="info-item">
                                <span class="label">Phương thức vận chuyển</span>
                                <span class="value">Standard Shipping (3-5 ngày)</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Mặt hàng (2)</h5>
                            <div class="order-items">
                              <div class="item">
                                <a href="product-details.html">
                                  <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                                    loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Enya EA XXX</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-004</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">1.500.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img
                                    src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                                    alt="Product" loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Saga A1 DE YYY</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-005</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">1.500.000 VND</div>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Chi tiết giá</h5>
                            <div class="price-breakdown">
                              <div class="price-row">
                                <span>Tổng sản phẩm</span>
                                <span>3.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Phí vận chuyển</span>
                                <span>200.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Thuế</span>
                                <span>1.000.000</span>
                              </div>
                              <div class="price-row total">
                                <span>Tổng</span>
                                <span>204.000.000 VND</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Địa chỉ giao hàng</h5>
                            <div class="address-info">
                              <p>Young Pop Eyes<br>100 đường 30 tháng 2<br>phường Bình Thạnh<br>thành phố Hồ Chí Minh,
                                HCM 70000<br>Việt Nam</p>
                              <p class="contact">0123456788</p>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>

                    <!-- Order Card 4 -->
                    <div class="order-card" data-aos="fade-up" data-aos-delay="400">
                      <div class="order-header">
                        <div class="order-id">
                          <span class="label">Mã đơn hàng:</span>
                          <span class="value">#ORD-2024-1245</span>
                        </div>
                        <div class="order-date">05/02/2025</div>
                      </div>
                      <div class="order-content">
                        <div class="product-grid">
                          <a href="product-details.html">
                            <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                              loading="lazy">
                          </a>
                          <a href="product-details.html">
                            <img
                              src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                              alt="Product" loading="lazy">
                          </a>
                          <a href="product-details.html">
                            <img src="assets/img/product/guitar/acoustic/taylor/taylor-110e/1.jpg" alt="Product"
                              loading="lazy">
                          </a>
                          <span class="more-items">+2</span>
                        </div>
                        <div class="order-info">
                          <div class="info-row">
                            <span>Tình trạng:</span>
                            <span class="status cancelled">Đã huỷ</span>
                          </div>
                          <div class="info-row">
                            <span>SL:</span>
                            <span>5</span>
                          </div>
                          <div class="info-row">
                            <span>Tổng</span>
                            <span class="price">1.000 VND</span>
                          </div>
                        </div>
                      </div>
                      <div class="order-footer">
                        <button type="button" class="btn-reorder" id="reorder-btn">Đặt lại</button>
                        <button type="button" class="btn-details" data-bs-toggle="collapse" data-bs-target="#details4"
                          aria-expanded="false">Xem chi tiết</button>
                      </div>

                      <!-- Order Details -->
                      <div class="collapse order-details" id="details4">
                        <div class="details-content">
                          <div class="detail-section">
                            <h5>Thông tin đặt hàng</h5>
                            <div class="info-grid">
                              <div class="info-item">
                                <span class="label">Phương thức thanh toán</span>
                                <span class="value">Credit Card (**** 4589)</span>
                              </div>
                              <div class="info-item">
                                <span class="label">Phương thức vận chuyển</span>
                                <span class="value">Express Delivery (2-3 ngày)</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Mặt hàng (3)</h5>
                            <div class="order-items">
                              <div class="item">
                                <a href="product-details.html">
                                  <img src="assets/img/product/guitar/acoustic/enya/enya-ea-x2/1.jpg" alt="Product"
                                    loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Enya EA X2</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-001</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">50.000.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img
                                    src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                                    alt="Product" loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Saga A1 DE PRO</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-002</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">50.000.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img src="assets/img/product/guitar/acoustic/taylor/taylor-110e/1.jpg" alt="Product"
                                    loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Taylor 110E</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-003</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">100.000.000 VND</div>
                              </div>
                              <div class="item">
                                <a href="product-details.html">
                                  <img
                                    src="assets/img/product/guitar/acoustic/yamaha/yamaha-apx1200ii/dan-guitar-acoustic-yamaha-apx1200ii-apx-series--1536x1536.jpg"
                                    alt="Product" loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Yamaha APX Đăng cấp vãi ò</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-010</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">100.000.000 VND</div>
                              </div>

                              <div class="item">
                                <a href="product-details.html">
                                  <img
                                    src="assets/img/product/guitar/acoustic/yamaha/yamaha-cpx600/dan-guitar-acoustic-yamaha-cpx600-cpx-series-.jpg"
                                    alt="Product" loading="lazy">
                                </a>
                                <div class="item-info">
                                  <h6>Yamaha PG-1 bô xăng lửa</h6>
                                  <div class="item-meta">
                                    <span class="sku">Mã sản phẩm: PRD-011</span>
                                    <span class="qty">SL: 1</span>
                                  </div>
                                </div>
                                <div class="item-price">500.000.000 VND</div>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Chi tiết giá</h5>
                            <div class="price-breakdown">
                              <div class="price-row">
                                <span>Tổng sản phẩm</span>
                                <span>800.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Phí vận chuyển</span>
                                <span>3.000.000.000 VND</span>
                              </div>
                              <div class="price-row">
                                <span>Thuế</span>
                                <span>30.000.000.000 VND</span>
                              </div>
                              <div class="price-row total">
                                <span>Tổng</span>
                                <span>33.800.000.000 VND</span>
                              </div>
                            </div>
                          </div>

                          <div class="detail-section">
                            <h5>Địa chỉ giao hàng</h5>
                            <div class="address-info">
                              <p>Tôm My Vơ Sơ Ti<br>33 đường cạnh bờ sông<br>phường A<br> thành phố Vice, VC
                                71000<br>Việt Nam</p>
                              <p class="contact">SĐT: 0123123153</p>
                            </div>
                          </div>
                          <h5>Lý do huỷ: Xuân Tâm đã ăn đơn hàng của bạn</h5>
                        </div>
                      </div>
                    </div>




                  </div>

                  <!-- Pagination -->
                  <div class="pagination-wrapper" data-aos="fade-up">
                    <button type="button" class="btn-prev" disabled="">
                      <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="page-numbers">
                      <button type="button" class="active">1</button>
                      <button type="button">2</button>
                      <button type="button">3</button>
                      <span>...</span>
                      <button type="button">12</button>
                    </div>
                    <button type="button" class="btn-next">
                      <i class="bi bi-chevron-right"></i>
                    </button>
                  </div>
                </div>
                <!-- Payment Methods Tab -->
                <div class="tab-pane fade" id="wallet">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Phương thức thanh toán</h2>
                    <div class="header-actions">
                      <button type="button" class="btn-add-new">
                        <i class="bi bi-plus-lg"></i>
                        Thêm thẻ mới
                      </button>
                    </div>
                  </div>

                  <div class="payment-cards-grid">
                    <!-- Payment Card 1 -->
                    <div class="payment-card default" data-aos="fade-up" data-aos-delay="100">
                      <div class="card-header">
                        <i class="bi bi-credit-card"></i>
                        <div class="card-badges">
                          <span class="default-badge">Mặc định</span>
                          <span class="card-type">Visa</span>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="card-number">•••• •••• •••• 4589</div>
                        <div class="card-info">
                          <span>Expires 09/2026</span>
                        </div>
                      </div>
                      <div class="card-actions">
                        <button type="button" class="btn-edit">
                          <i class="bi bi-pencil"></i>
                          Chỉnh sửa
                        </button>
                        <button type="button" class="btn-remove">
                          <i class="bi bi-trash"></i>
                          Xoá
                        </button>
                      </div>
                    </div>

                    <!-- Payment Card 2 -->
                    <div class="payment-card" data-aos="fade-up" data-aos-delay="200">
                      <div class="card-header">
                        <i class="bi bi-credit-card"></i>
                        <div class="card-badges">
                          <span class="card-type">Mastercard</span>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="card-number">•••• •••• •••• 7821</div>
                        <div class="card-info">
                          <span>Expires 05/2025</span>
                        </div>
                      </div>
                      <div class="card-actions">
                        <button type="button" class="btn-edit">
                          <i class="bi bi-pencil"></i>
                          Chỉnh sửa
                        </button>
                        <button type="button" class="btn-remove">
                          <i class="bi bi-trash"></i>
                          Xoá
                        </button>
                        <button type="button" class="btn-make-default">Đặt làm mặc định</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Đánh giá của tôi</h2>
                    <div class="header-actions">
                      <div class="dropdown">
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Recent</a></li>
                          <li><a class="dropdown-item" href="#">Highest Rating</a></li>
                          <li><a class="dropdown-item" href="#">Lowest Rating</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="reviews-grid">
                    <!-- Review Card 1 -->
                    <div class="review-card" data-aos="fade-up" data-aos-delay="100">
                      <div class="review-header">
                        <img
                          src="assets/img/product/guitar/classic/yamaha/dan-guitar-classic-yamaha-cgs102aii-school-series/dan-guitar-classic-yamaha-cgs102aii-school-series-.jpg"
                          alt="Product" class="product-image" loading="lazy">
                        <div class="review-meta">
                          <h4>Yamaha GC42S</h4>
                          <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span>(5.0)</span>
                          </div>
                          <div class="review-date">15/08/2025</div>
                        </div>
                      </div>
                      <div class="review-content">
                        <p>Tôi không thể kiềm được cảm xúc của mình khi nhận cây đàn này từ Guitar Xì Gòn, tôi đã đập nó
                          như chưa từng được đập, 1 em đàn chất lượng, đàn thế này thì tốn khán giả lắm!</p>
                      </div>
                      <div class="review-footer">
                        <button type="button" class="btn-edit">Sửa đánh giá</button>
                        <button type="button" class="btn-delete">Xoá</button>
                      </div>
                    </div>

                    <!-- Review Card 2 -->
                    <div class="review-card" data-aos="fade-up" data-aos-delay="200">
                      <div class="review-header">
                        <img src="assets\img\product\guitar\acoustic\taylor\taylor-110e\1.jpg" alt="Product"
                          class="product-image" loading="lazy">
                        <div class="review-meta">
                          <h4>Taylor 110CE</h4>
                          <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span>(4.0)</span>
                          </div>
                          <div class="review-date">03/01/2024</div>
                        </div>
                      </div>
                      <div class="review-content">
                        <p>Trước đây tôi cứ tự trách bản thân là 1 người nghèo, cô đơn, nhưng sau khi mua em đàn này thì
                          cuộc sống của tôi đã nâng lên bậc, vừa nghèo, cô đơn nhưng có nhạc nền:)</p>
                      </div>
                      <div class="review-footer">
                        <button type="button" class="btn-edit">Sửa đánh giá</button>
                        <button type="button" class="btn-delete">Xoá</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Addresses Tab -->
                <div class="tab-pane fade" id="addresses">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Địa chỉ giao hàng</h2>
                    <div class="header-actions">
                      <button type="button" class="btn-add-new">
                        <i class="bi bi-plus-lg"></i>
                        Thêm địa chỉ mới
                      </button>
                    </div>
                  </div>

                  <div class="addresses-grid">
                    <div class="address-card default" data-aos="fade-up" data-aos-delay="100">
                      <div class="card-header">
                        <h4>Nhà</h4>
                        <span class="default-badge">Mặc định</span>
                      </div>
                      <div class="card-body">
                        <p class="address-text">273 An Dương Vương<br>Phường Chợ Quán<br>Quận 5<br>Thành phố Hồ Chí Minh
                          700000<br>Việt
                          Nam</p>
                        <div class="contact-info">
                          <div><i class="bi bi-person"></i> Test User</div>
                          <div><i class="bi bi-telephone"></i> 0123456789</div>
                        </div>
                      </div>
                      <div class="card-actions">
                        <button type="button" class="btn-edit">
                          <i class="bi bi-pencil"></i>
                          Sửa
                        </button>
                        <button type="button" class="btn-remove">
                          <i class="bi bi-trash"></i>
                          Xoá
                        </button>
                      </div>
                    </div>

                    <div class="address-card" data-aos="fade-up" data-aos-delay="200">
                      <div class="card-header">
                        <h4>Trường học</h4>
                      </div>
                      <div class="card-body">
                        <p class="address-text">05 Bà Huyện Thanh Quan<br>Phường Xuân Hòa<br>Quận 3<br>TP. Hồ Chí
                          Minh<br>Việt Nam</p>
                        <div class="contact-info">
                          <div><i class="bi bi-person"></i> Test User</div>
                          <div><i class="bi bi-telephone"></i> 0123456789</div>
                        </div>
                      </div>
                      <div class="card-actions">
                        <button type="button" class="btn-edit">
                          <i class="bi bi-pencil"></i>
                          Sửa
                        </button>
                        <button type="button" class="btn-remove">
                          <i class="bi bi-trash"></i>
                          Xoá
                        </button>
                        <button type="button" class="btn-make-default">Đặt làm mặc định</button>
                      </div>
                    </div>
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
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" value="Gnevadie">
                          </div>
                          <div class="col-md-6">
                            <label for="username" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name" value="Long G">
                          </div>
                          <!-- <div class="col-md-6">
                            <label for="firstName" class="form-label">Họ</label>
                            <input type="text" class="form-control" id="firstName">
                          </div>
                          <div class="col-md-6">
                            <label for="lastName" class="form-label">Tên</label>
                            <input type="text" class="form-control" id="lastName">
                          </div> -->
                          <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" value="dragonG@gmai.com">
                          </div>
                          <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="phone" class="form-control" id="phone" value="(096) 969-6969">
                          </div>

                          <div class="input-new-avatar-image">
                            <label for="profilePicture" class="form-label">Ảnh đại diện</label>
                            <div class="input-group">
                              <input type="file" class="form-control file-input-hidden" id="profilePicture"
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
                        </div>


                        <div class="form-buttons">
                          <button type="submit" class="btn-save">Lưu thay đổi</button>
                        </div>
                      </form>
                    </div>


                    <!-- Email Preferences -->
                    <div class="settings-section" data-aos="fade-up" data-aos-delay="100">
                      <h3>Nhận thông báo</h3>
                      <div class="preferences-list">
                        <div class="preference-item">
                          <div class="preference-info">
                            <h4>Cập nhật đơn hàng</h4>
                            <p>Nhận thông báo về đơn hàng của bạn qua email</p>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="orderUpdates" checked="">
                          </div>
                        </div>

                        <div class="preference-item">
                          <div class="preference-info">
                            <h4>Khuyến mãi</h4>
                            <p>Nhận email về các chương trình khuyến mãi và ưu đãi mới</p>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="promotions">
                          </div>
                        </div>

                        <div class="preference-item">
                          <div class="preference-info">
                            <h4>Bản tin</h4>
                            <p>Đăng ký nhận bản tin hàng tuần của chúng tôi</p>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="newsletter" checked="">
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="settings-section" data-aos="fade-up" data-aos-delay="200">
                      <h3>Bảo mật</h3>
                      <form class="settings-form" id="password-update-form">
                        <div class="row g-3">
                          <div class="col-md-12">
                            <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="currentPassword">
                          </div>
                          <div class="col-md-6">
                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword">
                          </div>
                          <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirmPassword">
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
                        <p>Một khi bạn đã xóa tài khoản, bạn sẽ không thể quay lại được nữa. Hãy lưu ý kỹ!!.</p>
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

  <?php include 'forms/footer.php' ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/drift-zoom/Drift.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/auth.js"></script>
  <script src="assets/js/account.js"></script>

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

</body>

</html>