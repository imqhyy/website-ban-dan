<?php
$title = "Admin";
require_once(__DIR__ . '/forms/init.php');

// =============================================
// PHP DATA LAYER - Fetch all dashboard data
// =============================================

// 1. Doanh thu hôm nay & hôm qua
$todayRevenue = (float) getOne("SELECT COALESCE(SUM(total_amount),0) as rev FROM orders WHERE order_status='completed' AND DATE(created_at)=CURDATE()")['rev'];
$yesterdayRevenue = (float) getOne("SELECT COALESCE(SUM(total_amount),0) as rev FROM orders WHERE order_status='completed' AND DATE(created_at)=CURDATE()-INTERVAL 1 DAY")['rev'];

if ($yesterdayRevenue > 0) {
    $revenueDiff = round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1);
} else {
    $revenueDiff = $todayRevenue > 0 ? 100 : 0;
}
$revenueSign = $revenueDiff >= 0 ? '+' : '';
$revenueClass = $revenueDiff >= 0 ? 'text-success' : 'text-danger';

// 2. Đơn hàng hôm nay & đang chờ
$todayOrders = (int) getOne("SELECT COUNT(*) as cnt FROM orders WHERE DATE(created_at)=CURDATE()")['cnt'];
$yesterdayOrders = (int) getOne("SELECT COUNT(*) as cnt FROM orders WHERE DATE(created_at)=CURDATE()-INTERVAL 1 DAY")['cnt'];
$pendingOrders = (int) getOne("SELECT COUNT(*) as cnt FROM orders WHERE order_status='pending'")['cnt'];
$orderDiff = $todayOrders - $yesterdayOrders;
$orderSign = $orderDiff >= 0 ? '+' : '';
$orderClass = $orderDiff >= 0 ? 'text-success' : 'text-danger';

// 3. Khách hàng mới tuần này
$newUsersCount = (int) getOne("SELECT COUNT(*) as cnt FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")['cnt'];
$lastWeekUsers = (int) getOne("SELECT COUNT(*) as cnt FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)")['cnt'];
$userDiff = $newUsersCount - $lastWeekUsers;
$userSign = $userDiff >= 0 ? '+' : '';
$userClass = $userDiff >= 0 ? 'text-success' : 'text-danger';

// 4. Sản phẩm cạn kho
$lowStockProducts = getAll("SELECT product_name, stock_quantity FROM products WHERE stock_quantity <= 5 ORDER BY stock_quantity ASC LIMIT 5");

// 5. Biểu đồ Line Chart - Doanh thu 6 tháng
$revenueRows = getAll("SELECT DATE_FORMAT(created_at,'%m/%Y') as month_label, SUM(total_amount) as revenue
    FROM orders WHERE order_status='completed' AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(created_at,'%Y%m'), DATE_FORMAT(created_at,'%m/%Y')
    ORDER BY DATE_FORMAT(created_at,'%Y%m')");

$chartLabels = json_encode(array_column($revenueRows, 'month_label'));
$chartData   = json_encode(array_map(fn($r) => round((float)$r['revenue'] / 1000000, 1), $revenueRows)); // Triệu VND

// 6. Pie Chart - Trạng thái đơn hàng
$orderStatusRows = getAll("SELECT order_status, COUNT(*) as cnt FROM orders GROUP BY order_status");
$statusMap = ['completed' => 'Hoàn thành', 'pending' => 'Đang xử lý', 'cancelled' => 'Đã hủy', 'shipping' => 'Đang giao'];
$pieLabels = [];
$pieData   = [];
foreach ($orderStatusRows as $row) {
    $pieLabels[] = $statusMap[$row['order_status']] ?? ucfirst($row['order_status']);
    $pieData[]   = (int) $row['cnt'];
}
$pieLabelsJson = json_encode($pieLabels);
$pieDataJson   = json_encode($pieData);

// 7. 5 Đơn hàng mới nhất
$recentOrders = getAll("SELECT o.*, u.fullname FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5");

$statusBadge = [
    'pending'   => ['Đang xử lý', 'bg-warning'],
    'shipping'  => ['Đang giao',  'bg-primary'],
    'completed' => ['Hoàn thành', 'bg-success'],
    'cancelled' => ['Đã hủy',     'bg-danger'],
];

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
          <div class="col-lg-3 col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Doanh thu <span>| Hôm nay</span></h5>
                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cash-stack"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= number_format($todayRevenue, 0, ',', '.') ?> VND</h6>
                    <span class="<?= $revenueClass ?> small pt-1 fw-bold"><?= $revenueSign . $revenueDiff ?>% so với hôm qua</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 2. Đơn hàng mới -->
          <div class="col-lg-3 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Đơn hàng <span>| Hôm nay</span></h5>
                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $todayOrders ?></h6>
                    <span class="<?= $orderClass ?> small pt-1 fw-bold"><?= $orderSign . $orderDiff ?> so với hôm qua</span>
                    <span class="text-warning small pt-1 d-block"><?= $pendingOrders ?> đơn đang chờ xử lý</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Khách hàng mới -->
          <div class="col-lg-3 col-md-6">
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

          <!-- 4. Tồn kho thấp -->
          <div class="col-lg-3 col-md-6">
            <div class="card info-card warning-card h-100">
              <div class="card-body">
                <h5 class="card-title">Sản phẩm sắp hết hàng</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="text-danger">Dưới 5 cây</h6>
                  </div>
                </div>
                <div class="mt-2 small" style="max-height: 85px; overflow-y: auto; font-size: 0.9rem;">
                  <?php if (!empty($lowStockProducts)): ?>
                    <?php foreach ($lowStockProducts as $lsp): ?>
                      <div>
                        <strong><?= htmlspecialchars($lsp['product_name']) ?>:</strong>
                        <?php if ((int)$lsp['stock_quantity'] === 0): ?>
                          <span class="text-danger fw-bold">0 cây → Hết hàng</span>
                        <?php else: ?>
                          <span class="text-warning fw-bold"><?= $lsp['stock_quantity'] ?> cây</span>
                        <?php endif; ?>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="text-success">Tồn kho ổn định ✓</span>
                  <?php endif; ?>
                </div>
                <a href="admin_quanlytonkho.php" class="btn btn-sm btn-warning d-block mt-2">Xem chi tiết</a>
              </div>
            </div>
          </div>

          <div class="row g-4 mt-2">

            <!-- Biểu đồ doanh thu -->
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Doanh thu 6 tháng gần nhất <small class="text-muted">(Triệu VND)</small></h5>
                  <div class="chart-container" style="position: relative; height: 350px;">
                    <canvas id="revenueChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Biểu đồ tròn -->
            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tỷ lệ đơn hàng</h5>
                  <div class="chart-container" style="position: relative; height: 350px;">
                    <canvas id="orderStatusChart"></canvas>
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
                          <tr><td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào.</td></tr>
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
    document.addEventListener('DOMContentLoaded', function () {
      // Biểu đồ doanh thu 6 tháng — dữ liệu từ PHP
      const chartLabels = <?= $chartLabels ?: '["Chưa có dữ liệu"]' ?>;
      const chartData   = <?= $chartData   ?: '[0]' ?>;

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
          plugins: { legend: { position: 'top' } },
          scales: { y: { beginAtZero: true } }
        }
      });

      // Biểu đồ tròn trạng thái đơn hàng — dữ liệu từ PHP
      const pieLabels = <?= $pieLabelsJson ?: '["Chưa có dữ liệu"]' ?>;
      const pieData   = <?= $pieDataJson   ?: '[0]' ?>;

      const ctxPie = document.getElementById('orderStatusChart').getContext('2d');
      new Chart(ctxPie, {
        type: 'doughnut',
        data: {
          labels: pieLabels,
          datasets: [{
            data: pieData,
            backgroundColor: ['#28a745','#ffc107','#dc3545','#007bff','#6c757d'],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { position: 'bottom' } }
        }
      });
    });
  </script>
</body>

</html>