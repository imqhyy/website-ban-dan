<?php
$title = "Quản lý Đánh giá";
require_once(__DIR__ . '/forms/init.php');

$adminUsername = $_SESSION['admin'] ?? '';
if (empty($adminUsername)) {
  header('Location: admin_login.php');
  exit;
}

$action = $_POST['action'] ?? '';
if ($action && !empty($_POST['review_id'])) {
  $rid = (int) $_POST['review_id'];
  if ($action === 'hide')
    $pdo->prepare("UPDATE reviews SET status='hidden'  WHERE id=?")->execute([$rid]);
  if ($action === 'show')
    $pdo->prepare("UPDATE reviews SET status='visible' WHERE id=?")->execute([$rid]);
  if ($action === 'delete')
    $pdo->prepare("DELETE FROM reviews WHERE id=?")->execute([$rid]);
  header('Location: admin_quanlyreview.php');
  exit;
}

$search = trim($_GET['search'] ?? '');
$whereClause = "1=1";
$params = [];

if ($search !== '') {
  $whereClause .= " AND (u.fullname LIKE ? OR u.username LIKE ? OR p.product_name LIKE ? OR r.comment LIKE ?)";
  $likeSearch = "%{$search}%";
  $params = [$likeSearch, $likeSearch, $likeSearch, $likeSearch];
}

$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$totalCountRow = getOne("SELECT COUNT(*) as cnt FROM reviews r 
                         LEFT JOIN users u ON r.user_id = u.id 
                         LEFT JOIN products p ON r.product_id = p.id 
                         WHERE $whereClause", $params);
$totalReviewsCount = $totalCountRow['cnt'] ?? 0;
$totalPages = ceil($totalReviewsCount / $limit);

$reviews = getAll("SELECT r.*, u.fullname, u.username, u.email, p.product_name FROM reviews r
    LEFT JOIN users u ON r.user_id = u.id
    LEFT JOIN products p ON r.product_id = p.id
    WHERE $whereClause
    ORDER BY r.created_at DESC
    LIMIT $limit OFFSET $offset", $params);

include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>
  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý Đánh giá</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.php">Trang chủ</a></li>
            <li class="current">Review</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <form action="" class="search-container" method="GET" style="margin-top: 5px;">
              <input type="text" id="search-input" name="search" placeholder="Tìm tên, sản phẩm, nội dung..."
                value="<?= htmlspecialchars($search) ?>">
              <button id="search-button" type="submit">
                <i class="bi bi-search"></i> Tìm kiếm
              </button>
            </form>

            <?php if ($search !== ''): ?>
              <div class="text-center mb-3">
                <a href="admin_quanlyreview.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-circle"></i>
                  Xóa tìm kiếm</a>
              </div>
            <?php endif; ?>

            <h5 class="card-title mb-3">Danh sách đánh giá (Tổng số: <?= $totalReviewsCount ?>)</h5>

            <div class="table-responsive">
              <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Sao</th>
                    <th>Nội dung</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($reviews as $rv): ?>
                    <tr>
                      <td><?= $rv['id'] ?></td>
                      <td>
                        <div class="fw-bold text-primary"><?= htmlspecialchars($rv['fullname'] ?? 'Ẩn danh') ?></div>
                        <?php if (!empty($rv['username'])): ?>
                          <div class="text-muted" style="font-size: 12px;">@<?= htmlspecialchars($rv['username']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($rv['email'])): ?>
                          <div class="text-muted" style="font-size: 12px;"><i class="bi bi-envelope"></i>
                            <?= htmlspecialchars($rv['email']) ?></div>
                        <?php endif; ?>
                      </td>
                      <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <?= htmlspecialchars($rv['product_name'] ?? '') ?></td>
                      <td>
                        <div><i class="bi bi-star-fill text-warning"></i> <?= $rv['rating'] ?>/5</div>
                        <div class="text-muted" style="font-size: 12px; margin-top:4px;">
                          Âm thanh: <?= $rv['sound_rating'] ?? 5 ?> <br /> Cấu hình: <?= $rv['specs_rating'] ?? 5 ?>
                        </div>
                      </td>
                      <td style="max-width:300px; white-space:normal; overflow-wrap: break-word;">
                        <div style="margin-bottom: 8px; font-size: 14px;"><?= nl2br(htmlspecialchars($rv['comment'])) ?>
                        </div>
                        <?php if (!empty($rv['image_path'])): ?>
                          <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <?php foreach (explode(',', $rv['image_path']) as $img): ?>
                              <a href="../<?= htmlspecialchars(trim($img)) ?>" target="_blank">
                                <img src="../<?= htmlspecialchars(trim($img)) ?>"
                                  style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc; transition: transform 0.2s;"
                                  onmouseover="this.style.transform='scale(1.1)'"
                                  onmouseout="this.style.transform='scale(1)'" />
                              </a>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                        <?php if ($rv['is_purchased']): ?>
                          <div style="margin-top: 8px; font-size: 11px; color: #198754;"><i
                              class="bi bi-check-circle-fill"></i> Đã mua hàng</div>
                        <?php endif; ?>
                      </td>
                      <td><?= date('d/m/Y', strtotime($rv['created_at'])) ?></td>
                      <td>
                        <?php if ($rv['status'] === 'visible'): ?>
                          <span class="badge bg-success">Hiện</span>
                        <?php else: ?>
                          <span class="badge bg-secondary">Ẩn</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <form method="post" style="display:inline;">
                          <input type="hidden" name="review_id" value="<?= $rv['id'] ?>">
                          <?php if ($rv['status'] === 'visible'): ?>
                            <button name="action" value="hide" class="btn btn-sm btn-warning">Ẩn</button>
                          <?php else: ?>
                            <button name="action" value="show" class="btn btn-sm btn-success">Hiện</button>
                          <?php endif; ?>
                          <button name="action" value="delete" class="btn btn-sm btn-danger"
                            onclick="return confirm('Xóa đánh giá này?')">Xóa</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (empty($reviews)): ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted">Chưa có đánh giá nào.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <?php if ($totalPages > 1): ?>
              <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0;">
                <div class="container">
                  <nav class="d-flex justify-content-center">
                    <ul>
                      <?php
                      $qParams = $_GET;
                      unset($qParams['page']);
                      $queryString = http_build_query($qParams);
                      $baseUrl = "?" . ($queryString ? $queryString . "&" : "");
                      ?>
                      <?php if ($page > 1): ?>
                        <li><a href="<?= $baseUrl ?>page=<?= $page - 1 ?>"><i class="bi bi-arrow-left"></i></a></li>
                      <?php endif; ?>

                      <?php
                      $startP = max(1, $page - 2);
                      $endP = min($totalPages, $page + 2);
                      for ($i = $startP; $i <= $endP; $i++):
                        ?>
                        <li>
                          <a href="<?= $baseUrl ?>page=<?= $i ?>"
                            class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
                        </li>
                      <?php endfor; ?>

                      <?php if ($page < $totalPages): ?>
                        <li><a href="<?= $baseUrl ?>page=<?= $page + 1 ?>"><i class="bi bi-arrow-right"></i></a></li>
                      <?php endif; ?>
                    </ul>
                  </nav>
                </div>
              </section>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php require_once __DIR__ . "/forms/footer.php";
  require_once __DIR__ . "/forms/scripts.php"; ?>
</body>

</html>