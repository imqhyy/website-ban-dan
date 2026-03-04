<?php
require_once 'forms/init.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  header('Content-Type: application/json');
  $fullname = $_POST['fullname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  // 1. Kiểm tra mật khẩu khớp nhau
  if ($password !== $confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Mật khẩu không khớp', 'field' => 'confirmPassword']);
    exit;
  }

  // 2. Kiểm tra xem username hoặc email đã tồn tại trong database chưa
  $checkStmt = $pdo->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
  $checkStmt->execute([$username, $email]);
  $existingUser = $checkStmt->fetch();

  if ($existingUser) {
    if ($existingUser['username'] === $username) {
      // Thêm 'field' => 'username' để JS biết lỗi ở ô nào
      echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập này đã tồn tại!', 'field' => 'username']);
      exit;
    }
    if ($existingUser['email'] === $email) {
      // Thêm 'field' => 'email'
      echo json_encode(['status' => 'error', 'message' => 'Email này đã được sử dụng!', 'field' => 'email']);
      exit;
    }
  }

  //Nếu không trùng, tiến hành lưu vào database
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("
        INSERT INTO users (fullname, username, email, phone, password)
        VALUES (?, ?, ?, ?, ?)
    ");

  if ($stmt->execute([$fullname, $username, $email, $phone, $password])) {
    echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi đăng ký']);
  }
  exit;
}
?>
<?php
$title = "Đăng Ký - Guitar Xì Gòn";
include 'forms/head.php';
?>

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
                  <form method="POST" action="register.php" id="register-form">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và Tên"
                         autocomplete="name">
                      <label for="fullName">Họ và Tên</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập"
                        autocomplete="username">
                      <label for="text">Tên đăng nhập</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="email" name="email" placeholder="Địa chỉ email"
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
                            placeholder="Password"  minlength="1" autocomplete="new-password">
                          <label for="password">Mật khẩu</label>
                        </div>
                      </div>
                      <div class="full-width-container">
                        <div class="form-floating">
                          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                            placeholder="Confirm Password"  minlength="1" autocomplete="new-password">
                          <label for="confirmPassword">Xác nhận lại mật khẩu</label>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="form-check mb-4" style="margin-left: 20px;">
                  <input class="form-check-input" type="checkbox" id="termsCheck" name="termsCheck" >
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

  <?php include 'forms/footer.php';
  include 'forms/scripts.php' ?>
  <script src="assets/js/register.js"></script>
</body>

</html>