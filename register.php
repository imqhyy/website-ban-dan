<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Đăng ký - Guitar Xì Gòn</title>
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

<body class="register-page">

  <?php include 'forms/header.php' ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Đăng ký</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Đăng ký</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Register Section -->
    <section id="register" class="register section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="registration-form-wrapper">
              <div class="form-header text-center">
                <h2>Tạo tài khoản</h2>
                <p>Hãy tạo tài khoản và mua sắm thôi nào!</p>
              </div>

              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <form id="register-form">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="Họ và Tên" name="Họ và Tên" placeholder="Họ và Tên"
                        required="" autocomplete="name">
                      <label for="fullName">Họ và Tên</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="username" name="email" placeholder="Tên đăng nhập"
                        autocomplete="email">
                      <label for="text">Tên đăng nhập</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="email" name="email" placeholder="Email Address"
                        autocomplete="text">
                      <label for="email">Địa chỉ email</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại">
                      <label for="phone">Số điện thoại (Không bắt buộc)</label>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-floating">
                          <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" required="" minlength="1" autocomplete="new-password">
                          <label for="password">Mật khẩu</label>
                        </div>
                      </div>
                      <div class="full-width-container">
                        <div class="form-floating">
                          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                            placeholder="Confirm Password" required="" minlength="1" autocomplete="new-password">
                          <label for="confirmPassword">Xác nhận lại mật khẩu</label>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="form-check mb-4" style="margin-left: 20px;">
                  <input class="form-check-input" type="checkbox" id="termsCheck" name="termsCheck" required="">
                  <label class="form-check-label" for="termsCheck">
                    Tôi đồng ý với <a href="tos.php">Điều khoản dịch vụ</a> và <a href="privacy.php">Chính sách bảo
                      mật</a>
                  </label>
                </div>

                <div class="form-check mb-4" style="margin-left: 20px;">
                  <input class="form-check-input" type="checkbox" id="marketingCheck" name="marketingCheck">
                  <label class="form-check-label" for="marketingCheck">
                    Tôi muốn nhận các thông báo/thư tiếp thị về sản phẩm, dịch vụ và các chương trình khuyến mãi
                  </label>
                </div>

                <div class="d-grid mb-4">
                  <button type="submit" class="btn btn-register">Tạo tài khoản</button>
                </div>

                <div class="login-link text-center">
                  <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                </div>
                </form>
              </div>
            </div>

            <div class="social-login">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="divider">
                    <span>Hoặc đăng nhập với</span>
                  </div>
                  <div class="social-buttons">
                    <a href="#" class="btn btn-social">
                      <i class="bi bi-google"></i>
                      <span>Google</span>
                    </a>
                    <a href="#" class="btn btn-social">
                      <i class="bi bi-facebook"></i>
                      <span>Facebook</span>
                    </a>
                    <a href="#" class="btn btn-social">
                      <i class="bi bi-apple"></i>
                      <span>Apple</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="decorative-elements">
              <div class="circle circle-1"></div>
              <div class="circle circle-2"></div>
              <div class="circle circle-3"></div>
              <div class="square square-1"></div>
              <div class="square square-2"></div>
            </div>
          </div>
        </div>
      </div>

      </div>

    </section><!-- /Register Section -->

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
  <script src="assets/js/register.js"></script>



</body>

</html>