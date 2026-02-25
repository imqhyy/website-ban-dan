<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Giỏ hàng - Guitar Xì Gòn</title>

  <head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <!-- =======================================================
  * Template Name: NiceShop
  * Template URL: https://bootstrapmade.com/niceshop-bootstrap-ecommerce-template/
  * Updated: Aug 26 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  </head>

<body>

  <?php include 'forms/header.php' ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Giỏ hàng</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Giỏ hàng</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Cart Section -->
    <section id="cart" class="cart section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <div class="cart-items">
              <div class="cart-header d-none d-lg-block">
                <div class="row align-items-center">
                  <div class="col-lg-6">
                    <h5>Sản phẩm</h5>
                  </div>
                  <div class="col-lg-2 text-center">
                    <h5>Đơn giá</h5>
                  </div>
                  <div class="col-lg-2 text-center">
                    <h5>Số lượng</h5>
                  </div>
                  <div class="col-lg-2 text-center">
                    <h5>Thành tiền</h5>
                  </div>
                </div>
              </div>

              <div id="cart-items-container-demo">
                <div class="cart-item" data-price="2000000">
                  <div class="row align-items-center">
                    <div class="col-lg-6 col-12 mt-3 mt-lg-0 mb-lg-0 mb-3">
                      <div class="product-info d-flex align-items-center">
                        <div class="product-image">
                          <a href="product-details.php"><img
                              src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                              alt="Saga A1" class="img-fluid"></a>
                        </div>
                        <div class="product-details">
                          <a href="product-details.php">
                            <h6 class="product-title">Saga A1 DE PRO</h6>
                          </a>

                          <button class="remove-item" type="button" disabled style="opacity: 0.5; cursor: click;"><i
                              class="bi bi-trash"></i> Xóa</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="price-tag"><span class="current-price">2.000.000 VNĐ</span></div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="quantity-selector">
                        <button class="quantity-btn decrease" type="button"><i class="bi bi-dash"></i></button>
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="quantity-btn increase" type="button"><i class="bi bi-plus"></i></button>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="item-total"><strong>2.000.000 VNĐ</strong></div>
                    </div>
                  </div>
                </div>
                <div class="cart-item" data-price="5000000">
                  <div class="row align-items-center">
                    <div class="col-lg-6 col-12 mt-3 mt-lg-0 mb-lg-0 mb-3">
                      <div class="product-info d-flex align-items-center">
                        <div class="product-image">
                          <a href="product-details.php">
                            <img
                              src="assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg"
                              alt="Ba đờn C100" class="img-fluid"></a>
                        </div>
                        <div class="product-details">
                          <a href="product-details.php">
                            <h6 class="product-title">Ba đờn C100</h6>
                          </a>

                          <button class="remove-item" type="button" disabled style="opacity: 0.5; cursor: click;"><i
                              class="bi bi-trash"></i> Xóa</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="price-tag"><span class="current-price">5.000.000 VNĐ</span></div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="quantity-selector">
                        <button class="quantity-btn decrease" type="button"><i class="bi bi-dash"></i></button>
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="quantity-btn increase" type="button"><i class="bi bi-plus"></i></button>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="item-total"><strong>5.000.000 VNĐ</strong></div>
                    </div>
                  </div>
                </div>
                <div class="cart-item" data-price="85000000">
                  <div class="row align-items-center">
                    <div class="col-lg-6 col-12 mt-3 mt-lg-0 mb-lg-0 mb-3">
                      <div class="product-info d-flex align-items-center">
                        <div class="product-image"> <a href="product-details.php"><img
                              src="assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg"
                              alt="Taylor A12E" class="img-fluid"></a></div>
                        <div class="product-details">
                          <a href="product-details.php">
                            <h6 class="product-title">Taylor A12E</h6>
                          </a>

                          <button class="remove-item" type="button" disabled style="opacity: 0.5; cursor: click;"><i
                              class="bi bi-trash"></i> Xóa</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="price-tag"><span class="current-price">85.000.000 VNĐ</span></div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="quantity-selector">
                        <button class="quantity-btn decrease" type="button"><i class="bi bi-dash"></i></button>
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="quantity-btn increase" type="button"><i class="bi bi-plus"></i></button>
                      </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                      <div class="item-total"><strong>85.000.000 VNĐ</strong></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <div class="cart-summary">
              <h4 class="summary-title">Tóm tắt đơn hàng</h4>
              <div class="summary-item">
                <span class="summary-label">Tạm tính</span>
                <span class="summary-value" id="cart-subtotal">0 VNĐ</span>
              </div>
              <div class="summary-total">
                <span class="summary-label">Tổng cộng</span>
                <span class="summary-value" id="cart-total">0 VNĐ</span>
              </div>
              <div class="checkout-button">
                <a href="checkout.php" class="btn btn-accent w-100">Tiến hành thanh toán <i
                    class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/auth.js"></script>
  <script src="assets/js/cart.js"></script>
  <script>
    const currentUserJSON = sessionStorage.getItem('currentUser');

    if (currentUserJSON) {
      document.body.classList.remove('page-loading');
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Yêu cầu đăng nhập',
        text: 'Bạn cần đăng nhập để có thể xem giỏ hàng.',
        confirmButtonText: 'Đến trang đăng nhập',
        allowOutsideClick: false,
        customClass: {
          container: 'blurred-login-alert', // Thêm class container riêng cho alert này
          popup: 'my-swal-popup',
          title: 'my-swal-title',
          htmlContainer: 'my-swal-html-container',
          confirmButton: 'my-swal-confirm-button'
        }
      }).then(() => {
        window.location.href = 'login.php';
      });
    }
  </script>

</body>

</html>

</html>