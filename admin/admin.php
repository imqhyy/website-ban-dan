<?php
$title = "Báo cáo Nhập - Xuất";
require_once(__DIR__ . '/forms/init.php');

// 1. Lấy khoảng thời gian từ GET (Mặc định: 1 tháng gần nhất)
$reportStart = $_GET['report_start'] ?? date('Y-m-01', strtotime('-1 month'));
$reportEnd = $_GET['report_end'] ?? date('Y-m-d');

// 2. Truy vấn tổng hợp Nhập và Xuất cho từng sản phẩm
// Chỉ lấy những sản phẩm có phát sinh giao dịch trong kỳ để bảng gọn hơn
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
        <h1 class="mb-2 mb-lg-0">Báo cáo nhập - xuất</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.php">Báo cáo nhập - xuất</a></li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Stats Cards -->
    <section class="section dashboard">
      <div class="container">

        <div class="row g-4">






          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body" id="io-report-card">
                  <h5 class="card-title">Báo cáo Nhập - Xuất sản phẩm</h5>

                  <form action="#io-report-card" method="GET" id="io-report-form"
                    class="mb-3 d-flex align-items-center gap-3">
                    <input type="hidden" name="rev_date" value="<?= $revDate ?>">
                    <input type="hidden" name="order_date" value="<?= $orderDate ?>">
                    <input type="hidden" name="chart_start" value="<?= $chartStart ?>">
                    <input type="hidden" name="chart_end" value="<?= $chartEnd ?>">

                    <div class="d-flex align-items-center gap-2">
                      <small class="text-muted fw-bold">Khoảng thời gian:</small>
                      <input type="date" name="report_start" id="report_start" value="<?= $reportStart ?>"
                        class="form-control form-control-sm">
                      <span>đến</span>
                      <input type="date" name="report_end" id="report_end" value="<?= $reportEnd ?>"
                        class="form-control form-control-sm">

                      <button type="submit" class="status-button text-nowrap"><i class="bi bi-funnel"></i> Tra
                        cứu</button>
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
                              <td class="text-center fw-bold text-primary">
                                <?php if ($item['total_imported'] > 0): ?>
                                  <a href="admin_quanlynhapsanpham.php?product_id=<?= $item['id'] ?>&date_from=<?= $reportStart ?>&date_to=<?= $reportEnd ?>"
                                    class="text-decoration-none" title="Xem chi tiết các phiếu nhập">
                                    <?= number_format($item['total_imported']) ?>
                                  </a>
                                <?php else: ?>
                                  0
                                <?php endif; ?>
                              </td>
                              <td class="text-center fw-bold text-danger">
                                <?php if ($item['total_exported'] > 0): ?>
                                  <a href="admin_quanlydonhang.php?product_id=<?= $item['id'] ?>&date_from=<?= $reportStart ?>&date_to=<?= $reportEnd ?>"
                                    class="text-decoration-none text-danger" title="Xem các đơn hàng có sản phẩm này">
                                    <?= number_format($item['total_exported']) ?>
                                  </a>
                                <?php else: ?>
                                  0
                                <?php endif; ?>
                              </td>
                              <td class="text-center fw-bold <?= $changeClass ?>">
                                <?= ($netChange > 0 ? '+' : '') . number_format($netChange) ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center text-muted">Không có biến động nhập xuất trong khoảng thời
                              gian này.</td>
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
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php require_once __DIR__ . "/forms/scripts.php" ?>
  <script src="./assets/js/baocaonhapxuat.js"></script>
</body>

</html>