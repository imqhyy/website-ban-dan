<?php
require_once(__DIR__ . '/forms/init.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  header('Content-Type: application/json');

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  // Nếu đúng username + password thì vào đúng admin
  if ($user && $password == $user['password']) {
    $loginUser = $user;
  } else {
    // Nếu sai thì lấy admin đầu tiên trong database
    $defaultStmt = $pdo->query("SELECT * FROM admin_users ORDER BY id ASC LIMIT 1");
    $defaultUser = $defaultStmt->fetch();
    if ($defaultUser) {
      $loginUser = $defaultUser;
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tài khoản admin nào trong hệ thống']);
      exit();
    }
  }

  $_SESSION['admin'] = $loginUser['username'];
  // $_SESSION['admin_role'] = $loginUser['role'];
  echo json_encode(['status' => 'success']);
  exit();
}

$title = "Đăng nhập dành cho Admin";
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
                  <p>Đăng nhập tài khoản Admin</p>
                </div>

                <form class="auth-form-content" id="login-form" method="POST">
                  <div class="input-group mb-3">
                    <span class="input-icon">
                      <i class="bi bi-person"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Tên đăng nhập" autocomplete="username"
                      id="username" name="username">
                  </div>

                  <div class="input-group mb-3">
                    <span class="input-icon">
                      <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" placeholder="Mật khẩu" autocomplete="current-password"
                      id="password" name="password">
                    <span class="password-toggle">
                      <i class="bi bi-eye"></i>
                    </span>
                  </div>

                  <div class="form-options mb-4">
                    <div class="remember-me">
                      <input type="checkbox" id="rememberLogin">
                      <label for="rememberLogin">Ghi nhớ tôi</label>
                    </div>
                  </div>

                  <button type="submit" class="auth-btn primary-btn mb-3">
                    Đăng nhập
                    <i class="bi bi-arrow-right"></i>
                  </button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section><!-- /Login Section -->

  </main>

  <?php require_once __DIR__ . "/forms/footer.php" ?>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <div id="preloader"></div>

  <?php require_once __DIR__ . "/forms/scripts.php" ?>

  <script src="../assets/js/loginadm.js"></script>
  <?php if (!empty($_SESSION['toast_message'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Toast.fire({
          icon: '<?php echo $_SESSION["toast_type"] ?? "info"; ?>',
          title: '<?php echo htmlspecialchars($_SESSION["toast_message"]); ?>'
        });
      });
    </script>
    <?php
    unset($_SESSION['toast_message'], $_SESSION['toast_type']);
  endif; ?>

</body>

</html>