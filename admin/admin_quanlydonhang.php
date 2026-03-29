<?php
$title = "Quản lý đơn hàng";
require_once(__DIR__ . '/forms/init.php');
require_once(__DIR__ . '/forms/quanlydonhang/list.php'); // Gọi file logic
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>
  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý đơn hàng</h1>
        <nav class="breadcrumbs">
          <ol>

            <li class="current">Quản lý đơn hàng</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="container-manage-orders" style="width: 90%; margin: auto; padding: 20px;">
      <form action="" method="get">
        <div class="search-container">
          <input type="text" id="search-input" name="search" placeholder="Tra cứu mã đơn hàng"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
          <button id="search-button" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
        </div>

        <div class="sort-container">
          <div class="sort-by-date-container">
            <label>Từ ngày:<input type="date" name="date_from" class="input-sort-date"
                value="<?= $_GET['date_from'] ?? '' ?>"></label>
            <label>Đến ngày:<input type="date" name="date_to" class="input-sort-date"
                value="<?= $_GET['date_to'] ?? '' ?>"></label>
          </div>
          <div class="sort-by-order-status">
            <label for="sort-order">Tình trạng:</label>
            <select id="sort-order" name="order_status" class="status-select-custom">
              <option value="">Tất cả</option>
              <option value="newest" <?= ($_GET['order_status'] ?? '') == 'newest' ? 'selected' : '' ?>>Mới đặt</option>
              <option value="processed" <?= ($_GET['order_status'] ?? '') == 'processed' ? 'selected' : '' ?>>Đã xử lý
              </option>
              <option value="deliveried" <?= ($_GET['order_status'] ?? '') == 'deliveried' ? 'selected' : '' ?>>Đã giao
              </option>
              <option value="cancel" <?= ($_GET['order_status'] ?? '') == 'cancel' ? 'selected' : '' ?>>Huỷ</option>
            </select>
          </div>
          <button id="filter-button" type="submit" class="status-button"><i class="bi bi-funnel"></i> Tra cứu</button>
        </div>
        <div class="sort-container" style="margin-top: 10px;">
          <div class="sort-by-location-container">
            <label for="filter-city">Thành phố:</label>
            <select id="filter-city" name="city" class="status-select-custom">
              <option value="">-- Tất cả Thành phố --</option>
            </select>

            <label for="filter-ward" style="margin-left: 20px;">Phường/Xã:</label>
            <select id="filter-ward" name="ward" class="status-select-custom" disabled>
              <option value="">-- Tất cả Phường/Xã --</option>
            </select>
          </div>
        </div>
      </form>
      <hr>

      <?php if (!empty($_GET['product_id'])):
        // Lấy tên sản phẩm để hiện thông báo cho pro
        $product_name = getOne("SELECT product_name FROM products WHERE id = ?", [$_GET['product_id']])['product_name'] ?? 'Sản phẩm ID: ' . $_GET['product_id'];
        ?>
        <div class="alert alert-warning py-2 d-flex justify-content-between align-items-center mt-3">
          <span>Đang lọc đơn hàng có sản phẩm: <strong>
              <?= htmlspecialchars($product_name) ?>
            </strong></span>
          <a href="admin_quanlydonhang.php" class="btn btn-sm btn-outline-dark">Xóa lọc</a>
        </div>
      <?php endif; ?>
      
      <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $o):
          $statusMap = ['newest' => 'Mới đặt', 'processed' => 'Đã xử lý', 'deliveried' => 'Đã giao', 'cancel' => 'Huỷ'];
          ?>
          <div class="manage-order-container" data-order-id="<?= $o['id'] ?>">
            <div class="info-and-status-order">
              <div class="info-order">
                <p>Mã đơn hàng: <b><?= htmlspecialchars($o['order_code']) ?></b></p>
                <p>Ngày đặt hàng: <b><?= date("d/m/Y", strtotime($o['created_at'])) ?></b></p>
                <p>Tổng tiền: <b><?= number_format($o['total_amount'], 0, ',', '.') ?>VND</b></p>
              </div>
              <div class="status-block">
                <p style="margin-bottom: 0px;">Tình trạng: <b
                    class="order-status-value"><?= $statusMap[$o['order_status']] ?></b>
                  <i class="bi bi-pencil-square edit-status-order" style="cursor: pointer;"></i>
                </p>
                <div class="status-select-container hidden">
                  <span class="status-select-button" data-status="newest">Mới đặt</span>
                  <hr style="margin: 0"><span class="status-select-button" data-status="processed">Đã xử lý</span>
                  <hr style="margin: 0"><span class="status-select-button" data-status="deliveried">Đã giao</span>
                  <hr style="margin: 0"><span class="status-select-button" data-status="cancel">Huỷ</span>
                </div>
              </div>
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
              <button type="button" class="action-btn detail-btn" data-id="<?= $o['id'] ?>">Chi tiết</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align: center;">Không có đơn hàng nào.</p>
      <?php endif; ?>

      <section id="category-pagination" class="category-pagination section">
        <div class="container">
          <nav class="d-flex justify-content-center">
            <ul>
              <?php
              $params = $_GET;
              unset($params['page']);
              $query = http_build_query($params);
              $base_url = "admin_quanlydonhang.php?" . ($query ? $query . "&" : "");
              ?>
              <?php if ($currentPage > 1): ?>
                <li><a href="<?= $base_url ?>page=<?= $currentPage - 1 ?>"><i class="bi bi-arrow-left"></i></a></li>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                <li><a href="<?= $base_url ?>page=<?= $i ?>"
                    class="<?= ($i == $currentPage) ? 'active' : '' ?>"><?= $i ?></a></li>
              <?php endfor; ?>
              <?php if ($currentPage < $maxPage): ?>
                <li><a href="<?= $base_url ?>page=<?= $currentPage + 1 ?>"><i class="bi bi-arrow-right"></i></a></li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </section>
    </div>

    <div id="OrderDetailModal" class="modal">
      <div class="modal-content-admin">
        <span class="close-button">&times;</span>
        <h2>Chi tiết đơn hàng</h2>
        <div id="modal-body-content">
        </div>
        <div id="close-detail-order-container">
          <button class="close-button-detail-order">Đóng</button>
        </div>
      </div>
    </div>
  </main>

  <?php require_once __DIR__ . "/forms/footer.php";
  require_once __DIR__ . "/forms/scripts.php"; ?>
  <script>
    window.currentFilters = {
      city: "<?= htmlspecialchars($_GET['city'] ?? '') ?>",
      ward: "<?= htmlspecialchars($_GET['ward'] ?? '') ?>"
    };
  </script>
  <script src="./assets/js/quanlydonhang.js"></script>
</body>


</html>