<?php
$title = "Quản lý tồn kho";
require_once(__DIR__ . '/forms/init.php');
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý tồn kho</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.html">Trang chủ</a></li>
            <li class="current">Quản lý tồn kho</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <div class="container-manage-import-products">
      <form action="" class="search-container" method="get"><!-- Search box -->
        <input type="text" id="search-input" placeholder="Tra cứu số lượng sản phẩm" name="search">
        <button id="search-button">
          <i class="fa fa-search"></i> Tìm kiếm
        </button>
      </form><!-- End Search box -->

      <div class="sort-container"> <!-- Sort-container -->
        <div class="sort-by-date-container">
          <label>Ngày:<input type="date" class="input-sort-date"></label>
        </div>
        <div class="sort-by-order-status">
          <label for="sort-order">Tình trạng:</label>
          <select id="sort-order" class="status-select-custom">
            <option value="instock">Còn hàng</option>
            <option value="almost">Sắp hết</option>
            <option value="outstock">Hết hàng</option>
          </select>
        </div>
        <button id="filter-button" class="status-button">
          <i class="bi bi-funnel"></i> Tra cứu
        </button>
      </div>
      <hr>


      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover data-table">
            <thead>
              <tr>
                <th scope="col" style="width: 10%;">Hình ảnh</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Loại</th>
                <th scope="col">Nhập</th>
                <th scope="col">Xuất</th>
                <th scope="col">Tồn kho</th>
                <th scope="col">Trạng thái</th>
              </tr>
            </thead>
            <tbody id="product-list-container">
              <tr>
                <td><img
                    src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                    alt="Saga A1 DE PRO" style="width: 70px; height: auto;"></td>
                <td>Saga A1 DE PRO</td>
                <td>Acoustic</td>
                <td><span class="font-weight-bold">2</span></td>
                <td>0</td>
                <td>12</td>
                <td class="action-cell">

                </td>
              </tr>
              <tr>
                <td><img
                    src="assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg"
                    alt="Taylor A12E" style="width: 70px; height: auto;"></td>
                <td>Taylor A12E</td>
                <td>Acoustic</td>
                <td><span class="font-weight-bold">20</span></td>
                <td>15</td>
                <td>32</td>
                <td>

                </td>
              </tr>
              <tr>
                <td><img src="assets/img/product/guitar/acoustic/saga/saga-cl65/dan-guitar-acoustic-saga-cl65-.jpg"
                    alt="Saga CL65" style="width: 70px; height: auto;"></td>
                <td>Saga CL65</td>
                <td>Acoustic</td>
                <td><span class="font-weight-bold">0</span></td>
                <td>5</td>
                <td>45</td>
                <td>

                </td>
              </tr>
              <tr>
                <td><img
                    src="assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg"
                    alt="Ba đờn C100" style="width: 70px; height: auto;"></td>
                <td>Ba đờn C100</td>
                <td>Classic</td>
                <td><span class="font-weight-bold">10</span></td>
                <td>0</td>
                <td>23</td>
                <td>

                </td>
              </tr>
              <tr>
                <td><img
                    src="assets/img/product/guitar/classic/yamaha/dan-guitar-classic-yamaha-cgs102aii-school-series/dan-guitar-classic-yamaha-cgs102aii-school-series-.jpg"
                    alt="Yamaha CGS102AII" style="width: 70px; height: auto;"></td>
                <td>Yamaha CGS102AII</td>
                <td>Classic</td>
                <td><span class="font-weight-bold">7</span></td>
                <td>7</td>
                <td>1</td>
                <td>

                </td>
              </tr>
              <tr>
                <td><img
                    src="assets/img/product/guitar/acoustic/enya/enya ega-x0-pro-sp1/dan-guitar-acoustic-enya-ega-x0-pro-sp1-acousticplus-smart-guitar-2-1536x1536.jpg"
                    alt="Enya EGA X0 PRO SP1" style="width: 70px; height: auto;"></td>
                <td>Enya EGA X0 PRO SP1</td>
                <td>Acoustic</td>
                <td><span class="font-weight-bold">2</span></td>
                <td>1</td>
                <td>3</td>
                <td>

                </td>
              </tr>
              <tr>
                <td><img src="assets/img/product/guitar/acoustic/yamaha/yamaha-ls36-are/1.jpg" alt="Yamaha LS36 ARE"
                    style="width: 70px; height: auto;"></td>
                <td>Yamaha LS36 ARE</td>
                <td>Acoustic</td>
                <td><span class="font-weight-bold">6</span></td>
                <td>0</td>
                <td>15</td>
                <td>

                </td>
              </tr>
              <tr>
                <td><img src="assets/img/product/guitar/acoustic/saga/saga-ss-8ce/dan-guitar-acoustic-saga-ss-8ce-.jpg"
                    alt="Saga SS 8CE" style="width: 70px; height: auto;"></td>
                <td>Saga SS 8CE</td>
                <td>Acoustic</td>
                <td><span class="font-weight-bold">5</span></td>
                <td>2</td>
                <td>0</td>
                <td>

                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


      <!-- Category Pagination Section -->
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
              <li><a href="#">8</a></li>
              <li><a href="#">9</a></li>
              <li><a href="#">10</a></li>
              <li> <a href="#" aria-label="Next page">
                  <span class="d-none d-sm-inline">Sau</span>
                  <i class="bi bi-arrow-right"></i>
                </a> </li>
            </ul>
          </nav>
        </div>
      </section><!-- /Category Pagination Section -->
    </div>










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
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // 1. Lấy ra body của bảng (nơi chứa các hàng sản phẩm)
      const tableBody = document.getElementById('product-list-container');

      if (!tableBody) {
        console.error("Không tìm thấy phần tử tbody có ID 'product-list-container'.");
        return;
      }

      // 2. Lặp qua từng hàng (<tr>) trong tbody
      const productRows = tableBody.getElementsByTagName('tr');

      for (let i = 0; i < productRows.length; i++) {
        const row = productRows[i];

        // 3. Lấy ra tất cả các ô (<td>) trong hàng hiện tại
        const cells = row.getElementsByTagName('td');

        // Cấu trúc cột (dựa trên HTML của bạn):
        // 0: Hình ảnh
        // 1: Tên sản phẩm
        // 2: Loại
        // 3: Nhập
        // 4: Xuất
        // 5: Tồn kho (Cột thứ 6)
        // 6: Trạng thái (Cột thứ 7, action-cell)

        // 4. Lấy giá trị Tồn kho từ cột thứ 6 (cells[5])
        // Sử dụng .textContent để lấy nội dung bên trong <td> và chuyển thành số nguyên.
        const stockCell = cells[5];
        const stockQuantity = parseInt(stockCell.textContent.trim());

        // 5. Xác định cột Trạng thái (cells[6])
        const statusCell = cells[6];

        // 6. Logic kiểm tra và cập nhật trạng thái
        let statusText = '';
        let statusColor = ''; // Tùy chọn để thêm màu sắc

        if (stockQuantity === 0) {
          statusText = 'Hết hàng 🛑';
          statusColor = 'red';
        } else if (stockQuantity <= 5) {
          statusText = 'Sắp hết ⚠️';
          statusColor = 'orange';
        } else {
          statusText = 'Còn hàng ✅';
          statusColor = 'green';
        }

        // 7. Cập nhật nội dung và style cho ô Trạng thái
        statusCell.innerHTML = `<strong>${statusText}</strong>`;
        statusCell.style.color = statusColor;
        statusCell.style.fontWeight = 'bold';
      }
    });
  </script>
</body>

</html>