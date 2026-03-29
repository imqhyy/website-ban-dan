<?php
require_once(__DIR__ . '/forms/init.php');

// Format số điện thoại về dạng (xxx) xxx-xxxx
function formatPhone($phone) {
    if (empty($phone)) return 'Chưa cập nhật';
    // Xóa hết ký tự không phải số
    $digits = preg_replace('/[^0-9]/', '', $phone);
    // Chuẩn hóa về 10 số
    if (strlen($digits) === 10) {
        return '(' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 3) . '-' . substr($digits, 6);
    }
    // 11 số (đầu 84...)
    if (strlen($digits) === 11) {
        return '(' . substr($digits, 0, 4) . ') ' . substr($digits, 4, 3) . '-' . substr($digits, 7);
    }
    return $phone; // Trả nguyên nếu không nhận dạng được
}

// --- Xử lý POST khóa/mở khóa ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    $userId = (int)($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $reason = trim($_POST['reason'] ?? '');

    if (!$userId) {
        echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
        exit();
    }

    if ($action === 'lock') {
        if (empty($reason)) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng chọn lý do khóa']);
            exit();
        }
        $stmt = $pdo->prepare("UPDATE users SET is_locked=1, locked_reason=? WHERE id=?");
        $stmt->execute([$reason, $userId]);
        echo json_encode(['status' => 'success', 'message' => 'Đã khóa tài khoản!']);

    } elseif ($action === 'unlock') {
        $stmt = $pdo->prepare("UPDATE users SET is_locked=0, locked_reason=NULL WHERE id=?");
        $stmt->execute([$userId]);
        echo json_encode(['status' => 'success', 'message' => 'Đã mở khóa tài khoản!']);

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Action không hợp lệ']);
    }
    exit();
}

$title = "Quản lý khách hàng";

// --- Xử lý tìm kiếm, sắp xếp, phân trang ---
$search  = trim($_GET['search'] ?? '');
$sort    = $_GET['sort'] ?? 'asc';
$sort    = in_array($sort, ['asc', 'desc']) ? $sort : 'asc';
$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = 6;
$offset  = ($page - 1) * $perPage;

// Đếm tổng
$countSql  = "SELECT COUNT(*) FROM users WHERE fullname LIKE ? OR username LIKE ? OR email LIKE ?";
$keyword   = '%' . $search . '%';
$stmtCount = $pdo->prepare($countSql);
$stmtCount->execute([$keyword, $keyword, $keyword]);
$totalRows  = (int)$stmtCount->fetchColumn();
$totalPages = max(1, ceil($totalRows / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

// Query danh sách
$sql  = "SELECT * FROM users WHERE fullname LIKE ? OR username LIKE ? OR email LIKE ?
         ORDER BY fullname $sort LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $keyword, PDO::PARAM_STR);
$stmt->bindValue(2, $keyword, PDO::PARAM_STR);
$stmt->bindValue(3, $keyword, PDO::PARAM_STR);
$stmt->bindValue(4, $perPage, PDO::PARAM_INT);
$stmt->bindValue(5, $offset,  PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý khách hàng</h1>
        <nav class="breadcrumbs">
          <ol>
            
            <li class="current">Quản lý khách hàng</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="container-manage-import-products">

      <!-- Search -->
      <form action="" class="search-container" method="get">
        <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
        <input type="text" id="search-input" placeholder="Tìm kiếm tên, username, email"
          name="search" value="<?= htmlspecialchars($search) ?>">
        <button id="search-button" type="submit">
          <i class="bi bi-search"></i> Tìm kiếm
        </button>
      </form>

      <!-- Sort -->
      <div class="sort-container">
        <a href="?search=<?= urlencode($search) ?>&sort=asc&page=1"
          class="<?= $sort === 'asc' ? 'active' : '' ?>" id="sort-button">
          Sắp xếp A → Z
        </a>
        <a href="?search=<?= urlencode($search) ?>&sort=desc&page=1"
          class="<?= $sort === 'desc' ? 'active' : '' ?>" id="sort-button">
          Sắp xếp Z → A
        </a>
      </div>

      <!-- Danh sách khách hàng -->
      <div>
        <?php if (empty($users)): ?>
          <p style="text-align:center; padding:30px; color:#888;">Không tìm thấy khách hàng nào.</p>
        <?php else: ?>
          <?php foreach ($users as $user): ?>
            <?php
              $avatar = !empty($user['avatar'])
                ? '../' . htmlspecialchars($user['avatar'])
                : '../assets/img/person/images.jpg';
            ?>
            <div class="customer-card">
              <div class="customer-avatar-container">
                <img src="<?= $avatar ?>" class="customer-avatar" alt="avatar" style="object-fit:cover;width:60px;height:60px;border-radius:50%;">
              </div>
              <div class="customer-info">
                <p class="customer-name"><?= htmlspecialchars($user['fullname']) ?></p>
                <p class="customer-phone"><?= formatPhone($user['phone'] ?? '') ?></p>
              </div>
              <div class="customer-actions">
                <button class="action-btn reset-btn"
                  onclick="resetPassword('<?= htmlspecialchars($user['email']) ?>')">
                  Reset Mật khẩu
                </button>
                <button class="action-btn lock-btn <?= $user['is_locked'] ? 'btn-warning' : 'btn-success' ?>"
                  data-user-id="<?= $user['id'] ?>"
                  data-is-locked="<?= $user['is_locked'] ?>"
                  onclick="toggleLock(this)">
                  <?= $user['is_locked'] ? 'Mở khóa' : 'Khóa Tài khoản' ?>
                </button>
                <button class="action-btn detail-btn"
                  data-json="<?= htmlspecialchars(json_encode([
                    'avatar'        => $avatar,
                    'fullname'      => $user['fullname'],
                    'phone'         => formatPhone($user['phone'] ?? ''),
                    'email'         => $user['email'],
                    'username'      => $user['username'],
                    'created_at'    => date('d/m/Y', strtotime($user['created_at'])),
                    'address'       => trim(implode(', ', array_filter([
                      $user['address'] ?? '',
                      $user['ward'] ?? '',
                      $user['district'] ?? '',
                      $user['city'] ?? '',
                    ]))),
                    'is_locked'     => (int)$user['is_locked'],
                    'locked_reason' => $user['locked_reason'] ?? '',
                  ]), ENT_QUOTES) ?>"
                  onclick="openDetail(JSON.parse(this.getAttribute('data-json')))">
                  Chi tiết
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- Modal chi tiết -->
        <div id="DetailModal" class="modal">
          <div class="modal-content-admin" style="margin: auto; width: fit-content; min-width: 350px; max-width: 600px;">
            <span class="close-button" onclick="document.getElementById('DetailModal').style.display='none'">&times;</span>
            <h2>Chi tiết Khách hàng</h2>
            <div class="customer-info-details-container">
              <div class="avt-container">
                <div class="customer-avatar-details-container">
                  <img src="" id="modalImage" class="customer-avatar-details" alt="avatar">
                </div>
              </div>
              <div>
                <p class="customer-info-details"><strong>Username: </strong><span id="modalUsername"></span></p>
                <p class="customer-info-details"><strong>Tên: </strong><span id="modalName"></span></p>
                <p class="customer-info-details"><strong>SĐT: </strong><span id="modalPhone"></span></p>
                <p class="customer-info-details"><strong>Email: </strong><span id="modalEmail"></span></p>
                <p class="customer-info-details"><strong>Ngày đăng ký: </strong><span id="modalCreatedAt"></span></p>
                <p class="customer-info-details"><strong>Địa chỉ: </strong><span id="modalAddress"></span></p>
                <p class="customer-info-details" id="modalLockedRow" style="display:none;">
                  <strong>Lý do khóa: </strong><span id="modalLockedReason" style="color:red;"></span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <?php if ($totalPages > 1): ?>
      <section id="category-pagination" class="category-pagination section" style="padding-bottom:0px;">
        <div class="container">
          <nav class="d-flex justify-content-center" aria-label="Page navigation">
            <ul>
              <li>
                <a href="?search=<?= urlencode($search) ?>&sort=<?= $sort ?>&page=<?= max(1, $page - 1) ?>">
                  <i class="bi bi-arrow-left"></i>
                  <span class="d-none d-sm-inline">Trước</span>
                </a>
              </li>
              <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li>
                  <a href="?search=<?= urlencode($search) ?>&sort=<?= $sort ?>&page=<?= $p ?>"
                    <?= $p === $page ? 'class="active"' : '' ?>>
                    <?= $p ?>
                  </a>
                </li>
              <?php endfor; ?>
              <li>
                <a href="?search=<?= urlencode($search) ?>&sort=<?= $sort ?>&page=<?= min($totalPages, $page + 1) ?>">
                  <span class="d-none d-sm-inline">Sau</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </section>
      <?php endif; ?>

    </div>

  </main>

  <?php require_once __DIR__ . "/forms/footer.php" ?>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>
  <div id="preloader"></div>

  <?php require_once __DIR__ . "/forms/scripts.php" ?>

  <script>
    const LOCK_REASONS = [
      'Vi phạm điều khoản sử dụng',
      'Nghi ngờ gian lận / lừa đảo',
      'Spam đơn hàng',
      'Tạm khóa theo yêu cầu của chủ tài khoản',
      'Đẹp trai hơn chủ shop'
    ];

    // Mở modal chi tiết
    function openDetail(data) {
      document.getElementById('modalImage').src             = data.avatar;
      document.getElementById('modalUsername').textContent  = data.username;
      document.getElementById('modalName').textContent      = data.fullname;
      document.getElementById('modalPhone').textContent     = data.phone;
      document.getElementById('modalEmail').textContent     = data.email;
      document.getElementById('modalCreatedAt').textContent = data.created_at;
      document.getElementById('modalAddress').textContent   = data.address || 'Chưa cập nhật';

      const lockedRow = document.getElementById('modalLockedRow');
      if (data.is_locked && data.locked_reason) {
        document.getElementById('modalLockedReason').textContent = data.locked_reason;
        lockedRow.style.display = 'block';
      } else {
        lockedRow.style.display = 'none';
      }

      document.getElementById('DetailModal').style.display = 'flex';
    }

    window.addEventListener('click', function (e) {
      const modal = document.getElementById('DetailModal');
      if (e.target === modal) modal.style.display = 'none';
    });

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
      const userId   = button.getAttribute('data-user-id');
      const isLocked = button.getAttribute('data-is-locked') === '1';

      if (isLocked) {
        // Mở khóa — confirm trước
        Swal.fire({
          title: 'Mở khóa tài khoản?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Đồng ý, mở khóa',
          cancelButtonText: 'Hủy',
          confirmButtonColor: '#28a745',
        }).then(result => {
          if (!result.isConfirmed) return;
          sendLockRequest(userId, 'unlock', '', button);
        });

      } else {
        // Khóa — chọn lý do
        const options = LOCK_REASONS.map((r, i) =>
          `<option value="${r}">${r}</option>`
        ).join('');

        Swal.fire({
          title: 'Chọn lý do khóa',
          html: `<select id="swal-reason" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;font-size:14px;box-sizing:border-box;display:block;">
                   <option value="">-- Chọn lý do --</option>
                   ${options}
                 </select>`,
          width: 420,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Khóa',
          cancelButtonText: 'Hủy',
          confirmButtonColor: '#d33',
          preConfirm: () => {
            const reason = document.getElementById('swal-reason').value;
            if (!reason) {
              Swal.showValidationMessage('Vui lòng chọn lý do!');
              return false;
            }
            return reason;
          }
        }).then(result => {
          if (!result.isConfirmed) return;
          sendLockRequest(userId, 'lock', result.value, button);
        });
      }
    }

    function sendLockRequest(userId, action, reason, button) {
      const formData = new FormData();
      formData.append('user_id', userId);
      formData.append('action', action);
      formData.append('reason', reason);

      fetch('admin_quanlykhachhang.php', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
          if (data.status === 'success') {
            Toast.fire({ icon: 'success', title: data.message });
            // Cập nhật nút
            if (action === 'lock') {
              button.textContent = 'Mở khóa';
              button.classList.replace('btn-success', 'btn-warning');
              button.setAttribute('data-is-locked', '1');
            } else {
              button.textContent = 'Khóa Tài khoản';
              button.classList.replace('btn-warning', 'btn-success');
              button.setAttribute('data-is-locked', '0');
            }
          } else {
            Toast.fire({ icon: 'error', title: data.message });
          }
        })
        .catch(() => Toast.fire({ icon: 'error', title: 'Có lỗi xảy ra!' }));
    }
  </script>
<style>
  .swal-no-overflow { overflow: hidden !important; }
  .swal2-html-container { overflow: hidden !important; }
</style>
</body>
</html>