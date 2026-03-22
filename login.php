<?php require_once('forms/init.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  header('Content-Type: application/json');

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  // Nếu đúng username + password thì vào đúng user
  if ($user && $password == $user['password']) {
    // Kiểm tra tài khoản có bị khóa không
    if (!empty($user['is_locked'])) {
      $reason = !empty($user['locked_reason']) ? $user['locked_reason'] : 'Vi phạm điều khoản';
      echo json_encode(['status' => 'error', 'message' => 'Tài khoản đã bị khóa. Lý do: ' . $reason . '.Để mở khoá hãy Bank 500k với lời nhắn "Tha lỗi cho em"']);
      exit();
    }
    $loginUser = $user;
  } else {
    // Nếu sai thì lấy user đầu tiên trong database
    $defaultStmt = $pdo->query("SELECT * FROM users ORDER BY id ASC LIMIT 1");
    $defaultUser = $defaultStmt->fetch();
    if ($defaultUser) {
      $loginUser = $defaultUser;
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu không chính xác']);
      exit();
    }
  }

  $_SESSION['user'] = $loginUser['username'];
  $_SESSION['fullname'] = $loginUser['fullname'];
  $_SESSION['toast_type'] = 'success';
  $_SESSION['toast_message'] = 'Đăng nhập thành công!';
  echo json_encode(['status' => 'success']);
  exit();
}
?>

<?php
$title = "Đăng nhập - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="login-page">

  <body class="login-page">

    <?php include 'forms/header.php' ?>

    <main class="main">
      <!-- Page Title -->
      <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
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
              <div class="auth-container" data-aos="fade-in" data-aos-delay="200">
                <!-- Login Form -->
                <div class="auth-form login-form active">
                  <div class="form-header">
                    <h3>Chào mừng bạn đã trở lại!</h3>
                    <p>Đăng nhập tài khoản của bạn</p>
                  </div>

                  <form class="auth-form-content" id="login-form" method="POST" action="login.php">
                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-person"></i>
                      </span>
                      <input type="text" class="form-control" placeholder="Tên đăng nhập" autocomplete="username"
                        id="username" name="username" />
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-lock"></i>
                      </span>
                      <input type="password" class="form-control" placeholder="Mật khẩu" autocomplete="current-password"
                        id="password" name="password" />
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
                      <a href="register.php" class="switch-btn">Tạo tài khoản</a>
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
                        <input type="text" class="form-control" placeholder="First name" required=""
                          autocomplete="given-name" />
                      </div>
                      <div class="input-group">
                        <span class="input-icon">
                          <i class="bi bi-person"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Last name" required=""
                          autocomplete="family-name" />
                      </div>
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-envelope"></i>
                      </span>
                      <input type="email" class="form-control" placeholder="Email address" required=""
                        autocomplete="email" />
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-lock"></i>
                      </span>
                      <input type="password" class="form-control" placeholder="Create password" required=""
                        autocomplete="new-password" />
                      <span class="password-toggle">
                        <i class="bi bi-eye"></i>
                      </span>
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                      </span>
                      <input type="password" class="form-control" placeholder="Confirm password" required=""
                        autocomplete="new-password" />
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
                      <button type="button" class="switch-btn" data-target="login">
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
    <?php include 'forms/scripts.php'; ?>
    <script src="assets/js/login.js"></script>
  </body>

  </html>