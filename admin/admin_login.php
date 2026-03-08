<?php
$title = "Đăng nhập dành cho admin";
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">

  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Đăng nhập dành cho Admin</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Trang chủ</a></li>
            <li class="current">Đăng nhập Admin</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Login Section -->
    <section id="login" class="login section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
            <div class="auth-container" data-aos="fade-in" data-aos-delay="200">

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
                    <input type="text" class="form-control" placeholder="Tên đăng nhập" autocomplete="text"
                      id="username">
                  </div>

                  <div class="input-group mb-3">
                    <span class="input-icon">
                      <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Mật khẩu" autocomplete="current-password"
                      id="password">
                    <span class="password-toggle">
                      <i class="bi bi-eye"></i>
                    </span>
                    <script>
                      const passwordInput = document.getElementById('password');
                      const toggleButton = document.querySelector('.password-toggle');
                      const eyeIcon = toggleButton.querySelector('i');
                      toggleButton.addEventListener('click', function () {
                        if (passwordInput.type === 'password') {
                          passwordInput.type = 'text';
                          eyeIcon.classList.remove('bi-eye');
                          eyeIcon.classList.add('bi-eye-slash');
                        } else {
                          passwordInput.type = 'password';
                          eyeIcon.classList.remove('bi-eye-slash');
                          eyeIcon.classList.add('bi-eye');
                        }
                      });
                    </script>
                  </div>

                  <div class="form-options mb-4">
                    <div class="remember-me">
                      <input type="checkbox" id="rememberLogin">
                      <label for="rememberLogin">Ghi nhớ tôi</label>
                    </div>
                    <a href="#" class="forgot-password">Quên mât khẩu?</a>
                  </div>

                  <button type="submit" id='loggedIn' class="auth-btn primary-btn mb-3">
                    Đăng nhập
                    <i class="bi bi-arrow-right"></i>
                  </button>
                  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                  <script>
                    document.addEventListener('DOMContentLoaded', function () {
                      const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1200,
                        timerProgressBar: true,
                        customClass: { popup: 'my-swal-popup' },
                      });
                    });
                  </script>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Login Section -->

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

</body>


</html>