<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Xác nhận đơn hàng - Guitar Xì Gòn</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link
      href="assets/vendor/glightbox/css/glightbox.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: NiceShop
  * Template URL: https://bootstrapmade.com/niceshop-bootstrap-ecommerce-template/
  * Updated: Aug 26 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  </head>

  <body class="order-confirmation-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
      <div class="page-title light-background">
        <div
          class="container d-lg-flex justify-content-between align-items-center"
        >
          <h1 class="mb-2 mb-lg-0">Xác nhận đơn hàng</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.php">Trang chủ</a></li>
              <li class="current">Xác nhận đơn hàng</li>
            </ol>
          </nav>
        </div>
      </div>
      <section id="order-confirmation" class="order-confirmation section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="order-confirmation-3">
            <div class="row g-0">
              <div class="col-lg-4 sidebar" data-aos="fade-right">
                <div class="sidebar-content">
                  <div class="success-animation">
                    <i class="bi bi-check-lg"></i>
                  </div>
                  <div class="order-id">
                    <h4 id="summary-order-id"></h4>
                    <div class="order-date" id="summary-order-date"></div>
                  </div>
                  <div class="price-summary">
                    <h5>Tóm tắt đơn hàng</h5>
                    <!-- <ul class="summary-list" id="summary-price-list"></ul> --> <!--Chỗ này có code bên js giúp điền tự động nhưng code đó đang lỗi nên ẩn r-->
                    <ul class="summary-list">
                      <li>
                        <span>Tổng sản phẩm</span>
                        <span>92.000.000 VND</span>
                      </li>
                      <li>
                        <span>Phí vận chuyển</span>
                        <span>Miễn phí</span>
                      </li>
                      <li>
                        <span>Thuế</span>
                        <span>0 VND</span>
                      </li>
                      <li class="total">
                        <span>Total</span>
                        <span>92.000.000 VND</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 main-content" data-aos="fade-in">
                <div class="thank-you-message">
                  <h1 id="thank-you-name">Cảm ơn bạn đã đặt hàng!</h1>
                  <p>
                    Chúng tôi đã nhận được đơn hàng và sẽ xử lý ngay. Một email
                    xác nhận cùng thông tin chi tiết đã được gửi đến bạn.
                  </p>
                </div>
                <div class="details-card" data-aos="fade-up">
                  <div class="card-header">
                    <h3><i class="bi bi-geo-alt"></i>Chi tiết giao hàng</h3>
                  </div>
                  <div class="card-body">
                    <div class="row g-4">
                      <div class="col-md-12">
                        <div class="detail-group">
                          <label>Giao đến</label>
                          <address id="shipping-address-details"></address>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="details-card" data-aos="fade-up">
                  <div class="card-header">
                    <h3><i class="bi bi-bag-check"></i>Sản phẩm đã đặt</h3>
                  </div>
                  <div class="card-body" id="confirmation-item-list"></div>
                </div>
                <div class="action-area" data-aos="fade-up">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <a href="all.php" class="btn btn-back"
                        ><i class="bi bi-arrow-left"></i>Tiếp tục mua sắm</a
                      >
                    </div>
                    <div class="col-md-6">
                      <a href="account.php#" class="btn btn-account"
                        ><span>Xem trong Tài khoản</span
                        ><i class="bi bi-arrow-right"></i
                      ></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <?php include 'forms/footer.php' ?>

    <!-- Scroll Top -->
    <a
      href="#"
      id="scroll-top"
      class="scroll-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

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
    <script src="assets/js/order-confirmation.js"></script>
  </body>
</html>
