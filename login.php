<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Đăng nhập - Guitar Xì Gòn</title>
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

  <body class="login-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
      <!-- Page Title -->
      <div class="page-title light-background">
        <div
          class="container d-lg-flex justify-content-between align-items-center"
        >
          <h1 class="mb-2 mb-lg-0">Đăng nhập</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.php">Trang chủ</a></li>
              <li class="current">Đăng nhập</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- End Page Title -->

      <!-- Login Section -->
      <section id="login" class="login section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
              <div
                class="auth-container"
                data-aos="fade-in"
                data-aos-delay="200"
              >
                <!-- Login Form -->
                <div class="auth-form login-form active">
                  <div class="form-header">
                    <h3>Chào mừng bạn đã trở lại!</h3>
                    <p>Đăng nhập tài khoản của bạn</p>
                  </div>

                  <form class="auth-form-content" id="login-form">
                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-person"></i>
                      </span>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Tên đăng nhập"
                        autocomplete="text"
                        id="email"
                      />
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-lock"></i>
                      </span>
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Mật khẩu"
                        autocomplete="current-password"
                        id="password"
                      />
                      <span class="password-toggle">
                        <i class="bi bi-eye"></i>
                      </span>
                    </div>

                    <div class="form-options mb-4">
                      <div class="remember-me">
                        <input type="checkbox" id="rememberLogin" />
                        <label for="rememberLogin">Ghi nhớ tôi</label>
                      </div>
                      <a href="#" class="forgot-password">Quên mât khẩu?</a>
                    </div>

                    <button type="submit" class="auth-btn primary-btn mb-3">
                      Đăng nhập
                      <i class="bi bi-arrow-right"></i>
                    </button>

                    <div class="divider">
                      <span>or</span>
                    </div>

                    <button type="button" class="auth-btn social-btn">
                      <i class="bi bi-google"></i>
                      Đăng nhập với Google
                    </button>

                    <div class="switch-form">
                      <span>Bạn chưa có tài khoản?</span>
                      <a href="register.php" class="switch-btn"
                        >Tạo tài khoản</a
                      >
                    </div>
                  </form>
                </div>

                <!-- Register Form -->
                <div class="auth-form register-form">
                  <div class="form-header">
                    <h3>Tạo tài khoản</h3>
                    <p>Tham gia với chúng tôi</p>
                  </div>

                  <form class="auth-form-content">
                    <div class="name-row">
                      <div class="input-group">
                        <span class="input-icon">
                          <i class="bi bi-person"></i>
                        </span>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="First name"
                          required=""
                          autocomplete="given-name"
                        />
                      </div>
                      <div class="input-group">
                        <span class="input-icon">
                          <i class="bi bi-person"></i>
                        </span>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Last name"
                          required=""
                          autocomplete="family-name"
                        />
                      </div>
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-envelope"></i>
                      </span>
                      <input
                        type="email"
                        class="form-control"
                        placeholder="Email address"
                        required=""
                        autocomplete="email"
                      />
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-lock"></i>
                      </span>
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Create password"
                        required=""
                        autocomplete="new-password"
                      />
                      <span class="password-toggle">
                        <i class="bi bi-eye"></i>
                      </span>
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                      </span>
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Confirm password"
                        required=""
                        autocomplete="new-password"
                      />
                      <span class="password-toggle">
                        <i class="bi bi-eye"></i>
                      </span>
                    </div>

                    <div class="terms-check mb-4">
                      <input type="checkbox" id="termsRegister" required="" />
                      <label for="termsRegister">
                        Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a> và
                        <a href="#">và chính sách bảo mật</a>
                      </label>
                    </div>

                    <button type="submit" class="auth-btn primary-btn mb-3">
                      Tạo tài khoản
                      <i class="bi bi-arrow-right"></i>
                    </button>

                    <div class="divider">
                      <span>or</span>
                    </div>

                    <button type="button" class="auth-btn social-btn">
                      <i class="bi bi-google"></i>
                      Đăng nhập với tài khoản Google
                    </button>

                    <div class="switch-form">
                      <span>Nếu bạn đã có tài khoản?</span>
                      <button
                        type="button"
                        class="switch-btn"
                        data-target="login"
                      >
                        Đăng nhập
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Login Section -->
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
    <script src="assets/js/login.js"></script>
  </body>
</html>
