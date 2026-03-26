<?php
$title = "Admin";
require_once(__DIR__ . '/forms/init.php');

// =============================================
// PHP DATA LAYER - Fetch all dashboard data
// =============================================

// Lấy ngày lọc từ GET, mặc định là ngày hiện tại của hệ thống
$revDate = $_GET['rev_date'] ?? date('Y-m-d');
$orderDate = $_GET['order_date'] ?? date('Y-m-d');

// 1. Doanh thu theo ngày lọc (Bỏ so sánh % cũ)
// Giữ nguyên status 'deliveried' như code cũ của bạn
$filteredRevenue = (float) getOne("SELECT COALESCE(SUM(total_amount),0) as rev FROM orders WHERE order_status='deliveried' AND DATE(created_at) = ?", [$revDate])['rev'];

// 2. Đơn hàng theo ngày lọc (Bỏ so sánh tăng giảm)
$filteredOrders = (int) getOne("SELECT COUNT(*) as cnt FROM orders WHERE DATE(created_at) = ?", [$orderDate])['cnt'];

// Lấy đơn hàng chưa xử lý (Tính từ ngày được lọc trở về trước)
// Lưu ý: Dựa vào file orders.sql của bạn, trạng thái chưa xử lý là 'newest'
$pendingOrdersCount = (int) getOne("SELECT COUNT(*) as cnt FROM orders WHERE order_status='newest' AND DATE(created_at) <= ?", [$orderDate])['cnt'];

// 3. Khách hàng mới tuần này
$newUsersCount = (int) getOne("SELECT COUNT(*) as cnt FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")['cnt'];
$lastWeekUsers = (int) getOne("SELECT COUNT(*) as cnt FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)")['cnt'];
$userDiff = $newUsersCount - $lastWeekUsers;
$userSign = $userDiff >= 0 ? '+' : '';
$userClass = $userDiff >= 0 ? 'text-success' : 'text-danger';


// --- MỚI: Lấy ngưỡng cảnh báo từ Database ---
$stmtT = $pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'warning_threshold'");
$dbThreshold = $stmtT->fetchColumn();
$warningThreshold = ($dbThreshold !== false) ? (int)$dbThreshold : 5;


// 4. Sản phẩm sắp hết hàng (Chỉ lấy sản phẩm có tồn kho từ 1 đến ngưỡng)
// Thêm điều kiện stock_quantity > 0 để loại bỏ hàng đã hết
$lowStockProducts = getAll("SELECT product_name, stock_quantity FROM products 
                            WHERE stock_quantity > 0 AND stock_quantity <= ? 
                            ORDER BY stock_quantity ASC LIMIT 5", [$warningThreshold]);

// 5. Biểu đồ Line Chart - Doanh thu theo khoảng ngày tùy chỉnh
// Mặc định là 6 tháng trước đến hôm nay nếu không chọn
$chartStart = $_GET['chart_start'] ?? date('Y-m-d', strtotime('-6 months'));
$chartEnd   = $_GET['chart_end']   ?? date('Y-m-d');

$revenueRows = getAll("SELECT DATE_FORMAT(created_at,'%m/%Y') as month_label, SUM(total_amount) as revenue
    FROM orders 
    WHERE order_status='deliveried' 
    AND DATE(created_at) BETWEEN ? AND ?
    GROUP BY DATE_FORMAT(created_at,'%Y%m'), DATE_FORMAT(created_at,'%m/%Y')
    ORDER BY DATE_FORMAT(created_at,'%Y%m')", [$chartStart, $chartEnd]);

$chartLabels = json_encode(array_column($revenueRows, 'month_label'));
$chartData   = json_encode(array_map(fn($r) => round((float)$r['revenue'] / 1000000, 1), $revenueRows)); // Triệu VND

// 6. Pie Chart - Trạng thái đơn hàng theo khoảng ngày chọn
// Sử dụng chung $chartStart và $chartEnd từ bộ lọc phía trên
$orderStatusRows = getAll("SELECT order_status, COUNT(*) as cnt 
                           FROM orders 
                           WHERE DATE(created_at) BETWEEN ? AND ? 
                           GROUP BY order_status", [$chartStart, $chartEnd]);

$statusMap = [
  'newest'    => 'Đơn mới',
  'processed' => 'Đã xử lý',
  'deliveried' => 'Đã giao',
  'cancel'    => 'Đã hủy'
];

$pieLabels = [];
$pieData   = [];

foreach ($orderStatusRows as $row) {
  // Sử dụng map để hiển thị tiếng Việt, nếu không có thì giữ nguyên status gốc
  $pieLabels[] = $statusMap[$row['order_status']] ?? ucfirst($row['order_status']);
  $pieData[]   = (int) $row['cnt'];
}

$pieLabelsJson = json_encode($pieLabels);
$pieDataJson   = json_encode($pieData);

// 7. 5 Đơn hàng mới nhất
$recentOrders = getAll("SELECT o.*, u.fullname FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5");

$statusBadge = [
  'newest'     => ['Chưa xử lý',      'bg-info'],    // Màu xanh nhạt
  'processed'  => ['Đang giao hàng',     'bg-primary'], // Màu xanh dương
  'deliveried' => ['Đã giao hàng', 'bg-success'], // Màu xanh lá
  'cancel'     => ['Đã hủy',       'bg-danger'],  // Màu đỏ
];


// 8. Báo cáo Nhập - Xuất theo khoảng thời gian
// Mặc định: Từ ngày đầu tháng trước đến ngày hiện tại
$reportStart = $_GET['report_start'] ?? date('Y-m-01', strtotime('-1 month'));
$reportEnd   = $_GET['report_end']   ?? date('Y-m-d');

// Truy vấn tổng hợp Nhập và Xuất cho từng sản phẩm
$ioReport = getAll("
    SELECT p.id, p.product_name, 
           COALESCE(imp.total_import, 0) AS total_imported,
           COALESCE(exp.total_export, 0) AS total_exported
    FROM products p
    LEFT JOIN (
        SELECT ird.product_id, SUM(ird.quantity) AS total_import
        FROM import_receipt_details ird
        JOIN import_receipts i ON ird.receipt_id = i.id
        WHERE DATE(i.import_date) BETWEEN ? AND ?
        GROUP BY ird.product_id
    ) imp ON p.id = imp.product_id
    LEFT JOIN (
        SELECT od.product_id, SUM(od.quantity) AS total_export
        FROM order_details od
        JOIN orders o ON od.order_id = o.id
        WHERE o.order_status != 'cancel' AND DATE(o.created_at) BETWEEN ? AND ?
        GROUP BY od.product_id
    ) exp ON p.id = exp.product_id
    WHERE imp.total_import > 0 OR exp.total_export > 0
    ORDER BY (COALESCE(imp.total_import, 0) + COALESCE(exp.total_export, 0)) DESC
", [$reportStart, $reportEnd, $reportStart, $reportEnd]);

include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Trang chủ</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.php">Trang chủ</a></li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Stats Cards -->
    <section class="section dashboard">
      <div class="container">

        <div class="row g-4">

          <!-- 1. Doanh thu hôm nay -->
          <div class="col-lg-3 col-md-6 hidden">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Doanh thu <br>
                  <form action="" method="GET" style="display: inline-block;">
                    <input type="hidden" name="order_date" value="<?= $orderDate ?>">
                    <input type="date" name="rev_date" value="<?= $revDate ?>" onchange="this.form.submit()" style="border:none; background:transparent; font-size: 0.8rem; color: #899bbd; cursor: pointer;">
                  </form>
                </h5>
                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cash-stack"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= number_format($filteredRevenue, 0, ',', '.') ?> VND</h6>
                    <span class="text-muted small pt-2">Tổng thu trong ngày</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 2. Đơn hàng mới -->
          <div class="col-lg-3 col-md-6 hidden">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Đơn hàng <br>
                  <form action="" method="GET" style="display: inline-block;">
                    <input type="hidden" name="rev_date" value="<?= $revDate ?>">
                    <input type="date" name="order_date" value="<?= $orderDate ?>" onchange="this.form.submit()" style="border:none; background:transparent; font-size: 0.8rem; color: #899bbd; cursor: pointer;">
                  </form>
                </h5>
                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $filteredOrders ?></h6>
                    <span class="text-warning small pt-1 fw-bold"><?= $pendingOrdersCount ?> đơn đang chờ xử lý</span>
                    <small class="text-muted d-block" style="font-size: 0.7rem;">(Tính đến hết ngày lọc)</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Khách hàng mới -->
          <div class="col-lg-3 col-md-6 hidden">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Khách mới <span>| Tuần này</span></h5>
                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $newUsersCount ?></h6>
                    <span class="<?= $userClass ?> small pt-1 fw-bold"><?= $userSign . $userDiff ?> so với tuần trước</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 hidden">
            <div class="card info-card warning-card h-100">
              <div class="card-body">
                <h5 class="card-title">Sản phẩm sắp hết hàng</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="text-danger">Dưới <?= $warningThreshold ?> cây</h6>
                  </div>
                </div>
                <div class="mt-2 small" style="max-height: 85px; overflow-y: auto; font-size: 0.9rem;">
                  <?php if (!empty($lowStockProducts)): ?>
                    <?php foreach ($lowStockProducts as $lsp): ?>
                      <div>
                        <strong><?= htmlspecialchars($lsp['product_name']) ?>:</strong>
                        <span class="text-warning fw-bold"><?= $lsp['stock_quantity'] ?> cây</span>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="text-success">Không có sản phẩm sắp hết ✓</span>
                  <?php endif; ?>
                </div>
                <a href="admin_quanlytonkho.php" class="btn btn-sm btn-warning d-block mt-2">Xem chi tiết</a>
              </div>
            </div>
          </div>

          <div class="row g-4 mt-2">

            <!-- <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Doanh thu tùy chỉnh <small class="text-muted">(Triệu VND)</small></h5>

                  <form action="" method="GET" class="mb-3 d-flex align-items-center gap-2">
                    <input type="hidden" name="rev_date" value="<?= $revDate ?>">
                    <input type="hidden" name="order_date" value="<?= $orderDate ?>">

                    <div class="d-flex align-items-center gap-1">
                      <small class="text-muted">Từ:</small>
                      <input type="date" name="chart_start" value="<?= $chartStart ?>" class="form-control form-control-sm" onchange="this.form.submit()">
                    </div>
                    <div class="d-flex align-items-center gap-1">
                      <small class="text-muted">Đến:</small>
                      <input type="date" name="chart_end" value="<?= $chartEnd ?>" class="form-control form-control-sm" onchange="this.form.submit()">
                    </div>
                  </form>

                  <div class="chart-container" style="position: relative; height: 350px;">
                    <canvas id="revenueChart"></canvas>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- Biểu đồ tròn -->
            <!-- <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tỷ lệ đơn hàng</h5>
                  <div class="chart-container" style="position: relative; height: 350px;">
                    <canvas id="orderStatusChart"></canvas>
                  </div>
                </div>
              </div>
            </div> -->

          </div>


          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Báo cáo Nhập - Xuất sản phẩm</h5>

                  <form action="" method="GET" class="mb-3 d-flex align-items-center gap-3">
                    <input type="hidden" name="rev_date" value="<?= $revDate ?>">
                    <input type="hidden" name="order_date" value="<?= $orderDate ?>">
                    <input type="hidden" name="chart_start" value="<?= $chartStart ?>">
                    <input type="hidden" name="chart_end" value="<?= $chartEnd ?>">

                    <div class="d-flex align-items-center gap-2">
                      <small class="text-muted fw-bold">Khoảng thời gian:</small>
                      <input type="date" name="report_start" value="<?= $reportStart ?>" class="form-control form-control-sm" onchange="this.form.submit()">
                      <span>đến</span>
                      <input type="date" name="report_end" value="<?= $reportEnd ?>" class="form-control form-control-sm" onchange="this.form.submit()">
                    </div>
                  </form>

                  <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-bordered border-light">
                      <thead class="table-light sticky-top" style="z-index: 900;">
                        <tr>
                          <th>ID</th>
                          <th>Tên sản phẩm</th>
                          <th class="text-center text-primary">Tổng nhập (Qty)</th>
                          <th class="text-center text-danger">Tổng xuất (Qty)</th>
                          <th class="text-center">Biến động thuần</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($ioReport)): ?>
                          <?php foreach ($ioReport as $item):
                            $netChange = $item['total_imported'] - $item['total_exported'];
                            $changeClass = $netChange >= 0 ? 'text-success' : 'text-danger';
                          ?>
                            <tr>
                              <td><?= $item['id'] ?></td>
                              <td class="fw-bold"><?= htmlspecialchars($item['product_name']) ?></td>
                              <td class="text-center fw-bold text-primary"><?= number_format($item['total_imported']) ?></td>
                              <td class="text-center fw-bold text-danger"><?= number_format($item['total_exported']) ?></td>
                              <td class="text-center fw-bold <?= $changeClass ?>">
                                <?= ($netChange > 0 ? '+' : '') . number_format($netChange) ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center text-muted">Không có biến động nhập xuất trong khoảng thời gian này.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Bảng đơn hàng gần nhất -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card recent-sales">
                <div class="card-body">
                  <h5 class="card-title">Đơn hàng mới nhất</h5>
                  <div class="table-responsive">
                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th>Mã đơn</th>
                          <th>Khách hàng</th>
                          <th>Tổng tiền</th>
                          <th>Ngày đặt</th>
                          <th>Trạng thái</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($recentOrders)): ?>
                          <?php foreach ($recentOrders as $ord):
                            $badge = $statusBadge[$ord['order_status']] ?? [ucfirst($ord['order_status']), 'bg-secondary'];
                          ?>
                            <tr>
                              <td><a href="admin_quanlydonhang.php">#<?= htmlspecialchars($ord['order_code'] ?? $ord['id']) ?></a></td>
                              <td><?= htmlspecialchars($ord['fullname'] ?? 'Khách vãng lai') ?></td>
                              <td><?= number_format((float)$ord['total_amount'], 0, ',', '.') ?> VND</td>
                              <td><?= date('d/m/Y H:i', strtotime($ord['created_at'])) ?></td>
                              <td><span class="badge <?= $badge[1] ?>"><?= $badge[0] ?></span></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
    </section>

  </main>

  <?php require_once __DIR__ . "/forms/footer.php" ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php require_once __DIR__ . "/forms/scripts.php" ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Biểu đồ doanh thu 6 tháng — dữ liệu từ PHP
      const chartLabels = <?= $chartLabels ?: '["Chưa có dữ liệu"]' ?>;
      const chartData = <?= $chartData   ?: '[0]' ?>;

      const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
      new Chart(ctxRevenue, {
        type: 'line',
        data: {
          labels: chartLabels,
          datasets: [{
            label: 'Doanh thu (Triệu VND)',
            data: chartData,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Biểu đồ tròn trạng thái đơn hàng — dữ liệu từ PHP
      const pieLabels = <?= $pieLabelsJson ?: '["Chưa có dữ liệu"]' ?>;
      const pieData = <?= $pieDataJson   ?: '[0]' ?>;

      const ctxPie = document.getElementById('orderStatusChart').getContext('2d');
      new Chart(ctxPie, {
        type: 'doughnut',
        data: {
          labels: pieLabels,
          datasets: [{
            data: pieData,
            backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#007bff', '#6c757d'],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    });
  </script>
</body>

</html>