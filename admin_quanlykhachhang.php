<?php
require_once 'forms/init.php';

// Chặn truy cập nếu chưa đăng nhập Admin (nếu bạn đã làm hàm check admin thì thêm vào đây)

// Lấy danh sách toàn bộ khách hàng từ mới đến cũ
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$customers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Quản lý khách hàng - Guitar Xì Gòn</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/admin.css" rel="stylesheet">
</head>

<body class="login-page">
  <header id="header" class="header sticky-top">
    <div class="main-header">
      <div class="container-fluid container-xl">
        <div class="d-flex py-3 align-items-center justify-content-between">
          <a href="admin.html" class="logo d-flex align-items-center">
            <h1 class="sitename">Guitar Xì Gòn</h1>
          </a>
          <div class="header-actions d-flex align-items-center justify-content-end">
            <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse"
              data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
              <i class="bi bi-search"></i>
            </button>
            <div class="dropdown account-dropdown">
              <button class="header-action-btn" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i>
              </button>
              <div class="dropdown-menu">
                <div class="dropdown-header">
                  <h6>Tài khoản <span class="sitename">Admin</span></h6>
                  <p class="mb-0">quản lý sản phẩm &amp; khách hàng</p>
                </div>
                <div class="dropdown-body">
                  <a class="dropdown-item d-flex align-items-center" href="admin_account.html">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>Hồ sơ admin</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="account.php#settings">
                    <i class="bi bi-gear me-2"></i>
                    <span>Cài đặt</span>
                  </a>
                </div>
                <div class="dropdown-footer">
                  <button class="btn btn-outline-primary w-100" id="admin-logout-button">Đăng xuất</button>
                </div>
              </div>
            </div>
            <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="header-nav">
      <div class="container-fluid container-xl position-relative">
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="admin.html">Trang chủ</a></li>
            <li><a href="admin_quanlykhachhang.php">Quản lý khách hàng</a></li>
            <li><a href="admin_quanlyloaisanpham.html">Quản lý loại sản phẩm</a></li>
            <li><a href="admin_danhmucsanpham.html">Quản lý danh mục sản phẩm</a></li>
            <li><a href="admin_quanlynhapsanpham.html">Quản lý nhập sản phẩm</a></li>
            <li><a href="admin_quanlydonhang.html">Quản lý đơn hàng</a></li>
            <li><a href="admin_quanlytonkho.html">Quản lý tồn kho</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="collapse" id="mobileSearch">
      <div class="container">
        <form class="search-form">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm">
            <button class="btn" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </header>

  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý khách hàng</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.html">Trang chủ</a></li>
            <li class="current">Quản lý khách hàng</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="container-manage-import-products">
      <form action="" class="search-container" method="get">
        <input type="text" id="search-input" placeholder="Tìm kiếm" name="search">
        <button id="search-button">
          <i class="fa fa-search"></i> Tìm kiếm
        </button>
      </form>

      <div class="sort-container">
        <button id="sort-button" onclick="sortCustomers('asc')">Sắp xếp A → Z</button>
        <button id="sort-button" onclick="sortCustomers('dsc')">Sắp xếp Z → A</button>
      </div>

      <div>
        <?php if (count($customers) > 0): ?>
          <?php foreach ($customers as $cus): ?>
            <div class="customer-card">
              <div class="customer-avatar-container">
                <img src="<?php echo htmlspecialchars($cus['avatar'] ?? 'assets/img/person/images.jpg'); ?>"
                  class="customer-avatar" alt="avatar khách hàng">
              </div>
              <div class="customer-info">
                <p class="customer-name"><?php echo htmlspecialchars($cus['fullname']); ?></p>
                <p class="customer-phone"><?php echo htmlspecialchars($cus['phone'] ?? 'Chưa cập nhật'); ?></p>
              </div>
              <div class="customer-actions">
                <button class="action-btn reset-btn"
                  onclick="resetPassword('<?php echo htmlspecialchars($cus['email']); ?>')">
                  Reset Mật khẩu
                </button>
                <button class="action-btn lock-btn btn-success" onclick="toggleLock(this)">
                  Khóa Tài khoản
                </button>
                <button class="action-btn detail-btn" data-name="<?php echo htmlspecialchars($cus['fullname']); ?>"
                  data-phone="<?php echo htmlspecialchars($cus['phone'] ?? 'Chưa cập nhật'); ?>"
                  data-email="<?php echo htmlspecialchars($cus['email']); ?>"
                  data-avatar="<?php echo htmlspecialchars($cus['avatar'] ?? 'assets/img/person/images.jpg'); ?>"
                  data-created="<?php echo date('d/m/Y', strtotime($cus['created_at'] ?? 'now')); ?>"
                  data-address="<?php echo htmlspecialchars(($cus['address'] ?? '') . ', ' . ($cus['ward'] ?? '') . ', ' . ($cus['district'] ?? '') . ', ' . ($cus['city'] ?? '')); ?>"
                  onclick="showCustomerDetails(this)">
                  Chi tiết
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center p-5">Chưa có khách hàng nào đăng ký.</p>
        <?php endif; ?>
      </div>

      <div id="DetailModal" class="modal">
        <div class="modal-content-admin" style="margin: 10% auto;">
          <span class="close-button"
            onclick="document.getElementById('DetailModal').style.display='none'">&times;</span>
          <h2>Chi tiết Khách hàng</h2>
          <div class="customer-info-details-container">
            <div class="avt-container">
              <div class="customer-avatar-details-container">
                <img src="" id="modalImage" class="customer-avatar-details" alt="avatar khách hàng">
              </div>
            </div>
            <div>
              <p class="customer-info-details"><strong>Tên: </strong> <span id="modalName"></span></p>
              <p class="customer-info-details"><strong>SĐT: </strong> <span id="modalPhone"></span></p>
              <p class="customer-info-details"><strong>Email: </strong> <span id="modalEmail"></span></p>
              <p class="customer-info-details"><strong>Ngày đăng ký: </strong> <span id="modalCreated"></span></p>
              <p class="customer-info-details"><strong>Địa chỉ: </strong> <span id="modalAddress"></span></p>
            </div>
          </div>
        </div>
      </div>

      <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0px;">
        <div class="container">
          <nav class="d-flex justify-content-center" aria-label="Page navigation">
            <ul>
              <li> <a href="#" aria-label="Previous page"> <i class="bi bi-arrow-left"></i>
                  <span class="d-none d-sm-inline">Trước</span>
                </a> </li>
              <li><a href="#" class="active">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li class="ellipsis">...</li>
              <li> <a href="#" aria-label="Next page">
                  <span class="d-none d-sm-inline">Sau</span>
                  <i class="bi bi-arrow-right"></i>
                </a> </li>
            </ul>
          </nav>
        </div>
      </section>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
    function resetPassword(email) {
      Swal.fire({
        icon: 'success',
        title: 'Đã gửi!',
        text: `Link đặt lại mật khẩu đã được gửi đến email ${email}`,
        timer: 1500,
        showConfirmButton: false
      });
    }

    function toggleLock(button) {
      const isLocked = button.textContent.includes('Khóa');
      button.textContent = isLocked ? 'Mở khóa' : 'Khóa Tài khoản';
      button.classList.toggle('btn-warning', isLocked);
      button.classList.toggle('btn-success', !isLocked);

      Swal.fire({
        icon: isLocked ? 'warning' : 'success',
        title: isLocked ? 'Đã khóa!' : 'Đã mở khóa!',
        text: isLocked ? 'Tài khoản đã bị khóa' : 'Tài khoản đã được mở khóa',
        timer: 1500,
        showConfirmButton: false
      });
    }

    function showCustomerDetails(btn) {
      // Lấy data từ nút vừa bấm
      const name = btn.getAttribute('data-name');
      const phone = btn.getAttribute('data-phone');
      const email = btn.getAttribute('data-email');
      const avatar = btn.getAttribute('data-avatar');
      const address = btn.getAttribute('data-address');
      const created = btn.getAttribute('data-created');

      // Gắn vào bảng Pop-up
      document.getElementById('modalName').textContent = name;
      document.getElementById('modalPhone').textContent = phone;
      document.getElementById('modalEmail').textContent = email;
      document.getElementById('modalImage').src = avatar;

      // Xử lý chuỗi địa chỉ rỗng
      let displayAddress = address.replace(/, , , |^, |, $/g, '').trim();
      document.getElementById('modalAddress').textContent = displayAddress ? displayAddress : 'Chưa cập nhật';

      document.getElementById('modalCreated').textContent = created;

      // Hiển thị Pop-up
      document.getElementById('DetailModal').style.display = 'block';
    }
  </script>
</body>

</html>