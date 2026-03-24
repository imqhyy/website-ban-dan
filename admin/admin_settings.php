<?php
$title = "Cài đặt Khuyến Mãi - Admin";
require_once(__DIR__ . '/forms/init.php');

$adminUsername = $_SESSION['admin'] ?? '';
if (empty($adminUsername)) {
    header('Location: admin_login.php');
    exit;
}

// Lấy Cấu hình hiện tại
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settingsRows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$saleEndDate = $settingsRows['mega_sale_end_date'] ?? '2026/05/01';
$saleTitle = $settingsRows['mega_sale_title'] ?? 'Đếm ngược ngày đại ưu đãi';
$saleDesc = $settingsRows['mega_sale_desc'] ?? '';

include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Cài đặt Khuyến Mãi (Mega Sale)</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.php">Trang chủ Quản trị</a></li>
            <li class="current">Sự kiện</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Cấu hình Content -->
    <section class="section account-settings">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="settings-section" style="background:#fff; padding:30px; border-radius:15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
              <h3 style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 25px;"><i class="bi bi-clock-history text-danger me-2"></i>Chỉnh sửa Bộ Đếm Ngược Trang Chủ</h3>
              
              <form id="mega-sale-form">
                <div class="mb-4">
                  <label class="form-label fw-bold">Tên Chiến Dịch (Tiêu đề Banner)</label>
                  <input type="text" class="form-control" name="sale_title" value="<?= htmlspecialchars($saleTitle) ?>" required>
                  <small class="text-muted">VD: Siêu Sale Mùa Hè, Đại Tiệc Âm Nhạc...</small>
                </div>
                
                <div class="mb-4">
                  <label class="form-label fw-bold text-danger">Ngày Kết Thúc (YYYY/MM/DD)</label>
                  <input type="text" class="form-control border-danger" name="sale_end_date" value="<?= htmlspecialchars($saleEndDate) ?>" placeholder="2026/05/01" required>
                  <small class="text-muted">Hệ thống đếm ngược sẽ tự căn cứ vào ngày này. Format: YYYY/MM/DD (VD: 2026/05/01)</small>
                </div>
                
                <div class="mb-4">
                  <label class="form-label fw-bold">Mô tả hiển thị</label>
                  <textarea class="form-control" name="sale_desc" rows="4" required><?= htmlspecialchars($saleDesc) ?></textarea>
                  <small class="text-muted">Đoạn text kích thích người mua hốt đàn bên dưới đồng hồ đếm ngược.</small>
                </div>
                
                <div class="form-buttons text-end">
                  <button type="submit" class="btn btn-danger px-4 py-2" style="border-radius: 30px;">
                    <i class="bi bi-save me-2"></i>Lưu cấu hình
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php require_once __DIR__ . "/forms/footer.php" ?>
  <?php require_once __DIR__ . "/forms/scripts.php" ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const megaSaleForm = document.getElementById('mega-sale-form');
      if (megaSaleForm) {
        megaSaleForm.addEventListener('submit', function(e) {
          e.preventDefault();
          fetch('forms/ajax_settings.php', {
            method: 'POST',
            body: new FormData(this)
          })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Đã lưu cấu hình Sự kiện!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: data.message || 'Có lỗi xảy ra',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
              });
            }
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              title: 'Lỗi máy chủ',
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
          });
        });
      }
    });
  </script>
</body>
</html>
