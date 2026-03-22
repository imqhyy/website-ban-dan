<?php
$title = "Admin";
require_once(__DIR__ . '/forms/init.php');
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <!-- THAY THẾ PHẦN <main> HIỆN TẠI BẰNG ĐOẠN NÀY -->
  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Trang chủ</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.html">Trang chủ</a></li>
            <!-- <li class="current">Trang điều khiển</li> -->
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

              <!-- 1. BỘ LỌC (FILTER) ĐƯỢC THÊM VÀO -->
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h7>Bộ lọc</h7>
                  </li>
                  <li><a class="dropdown-item" href="#">Hôm nay</a></li>
                  <li><a class="dropdown-item" href="#">Tháng này</a></li>
                  <li><a class="dropdown-item" href="#">Năm nay</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Doanh thu <span>| Hôm nay</span></h5>

                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cash-stack"></i>
                  </div>
                  <div class="ps-3">
                    <h6>24.500.000 VND</h6>
                    <span class="text-success small pt-1 fw-bold">+12% so với hôm qua</span>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- 2. Đơn hàng mới -->
          <div class="col-lg-3 col-md-6">
            <div class="card info-card revenue-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h7>Bộ lọc</h7>
                  </li>
                  <li><a class="dropdown-item" href="#">Hôm nay</a></li>
                  <li><a class="dropdown-item" href="#">Tháng này</a></li>
                  <li><a class="dropdown-item" href="#">Năm nay</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Đơn hàng <span>| Hôm nay</span></h5>

                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6>42</h6>
                    <span class="text-success small pt-1 fw-bold">+8 so với hôm qua</span>
                    <span class="text-warning small pt-1 d-block">25 đơn đang chờ xử lý</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Khách hàng hoạt động -->
          <div class="col-lg-3 col-md-6">
            <div class="card info-card customers-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h7>Bộ lọc</h7>
                  </li>
                  <li><a class="dropdown-item" href="#">Tuần này</a></li>
                  <li><a class="dropdown-item" href="#">Tháng này</a></li>
                  <li><a class="dropdown-item" href="#">Năm nay</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Khách hoạt động <span>| Tuần này</span></h5>

                <div class="d-flex align-items-start">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>268</h6>

                    <span class="text-success small pt-1 fw-bold">+5% so với tuần trước</span>

                    <span class="text-info small pt-1 d-block">30 khách mới</span>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tồn kho thấp -->
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
                  <div><strong>Enya EGA X0 PRO SP1:</strong> <span class="text-warning fw-bold">3 cây</span></div>
                  <div><strong>Yamaha CGS102AII:</strong> <span class="text-danger fw-bold">1 cây</span></div>
                  <div><strong>Saga SS 8CE:</strong> <span class="text-danger fw-bold">0 cây</span> → <span
                      class="text-danger fw-bold">Hết hàng</span></div>
                </div>

                <a href="admin_quanlytonkho.html" class="btn btn-sm btn-warning d-block mt-2">Xem chi tiết</a>

              </div>
            </div>
          </div>

          <div class="row g-4 mt-2">

            <!-- Biểu đồ doanh thu -->
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Doanh thu 6 tháng gần nhất</h5>
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
                  <h5 class="card-title">Đơn hàng gần nhất</h5>
                  <div class="table-responsive">
                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th>Mã đơn</th>
                          <th>Khách hàng</th>
                          <th>Sản phẩm</th>
                          <th>Giá</th>
                          <th>Trạng thái</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="#">#ORD-2024-1279</a></td>
                          <td>Long G</td>
                          <td>Enya EA X2 + Saga A1 DE PRO + Taylor 110E</td>
                          <td>701.000.000 VND</td>
                          <td><span class="badge bg-warning">Đang xử lý</span></td>

                        </tr>
                        <tr>
                          <td><a href="#">#ORD-2024-1278</a></td>
                          <td>Sói Cô Độc</td>
                          <td>Guitar Yamaha FG800</td>
                          <td>5.200.000 VND</td>
                          <td><span class="badge bg-success">Hoàn thành</span></td>
                        </tr>
                        <tr>
                          <td><a href="#">#ORD-2024-1277</a></td>
                          <td>Châu Tinh Trì</td>
                          <td>Enya EGA X0 PRO SP1</td>
                          <td>11.300.000 VND</td>
                          <td><span class="badge bg-success">Hoàn thành</span></td>
                        </tr>
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

  <?php
  require_once __DIR__ . "/forms/scripts.php"
    ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Biểu đồ doanh thu 6 tháng
      const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
      const revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
          labels: ['Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10'],
          datasets: [{
            label: 'Doanh thu (Triệu VND)',
            data: [18, 22, 25, 28, 26, 30],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'top' },
            title: { display: false }
          },
          scales: {
            y: { beginAtZero: true }
          }
        }
      });

      // Biểu đồ tròn trạng thái đơn hàng
      const ctxPie = document.getElementById('orderStatusChart').getContext('2d');
      const orderStatusChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
          labels: ['Hoàn thành', 'Đang xử lý', 'Đã hủy', 'Đang giao'],
          datasets: [{
            data: [65, 25, 5, 5],
            backgroundColor: [
              '#28a745', // xanh
              '#ffc107', // vàng
              '#dc3545', // đỏ
              '#007bff'  // xanh dương
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'bottom' }
          }
        }
      });
    });
  </script>
</body>


</html>