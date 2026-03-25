<?php
// 1. Khai báo tiêu đề
$title = "Quản lý tồn kho";

// 2. Nạp init và head
require_once(__DIR__ . '/forms/init.php');
include __DIR__ . "/forms/head.php";

// 3. Lấy Ngưỡng cảnh báo từ Database
// 3. Lấy Ngưỡng cảnh báo từ Database
$stmtT = $pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'warning_threshold'");
$dbThreshold = $stmtT->fetchColumn(); // Lấy giá trị đầu tiên từ kết quả trả về
$warningThreshold = ($dbThreshold !== false) ? $dbThreshold : 5; // Nếu không có dữ liệu thì lấy mặc định là 5

// 4. Khai báo các biến mặc định để Form không báo lỗi "Undefined variable"
$targetDate = date('Y-m-d'); // Mặc định là ngày hôm nay
$searchKeyword = "";
$filterStatus = "";
?>

<body class="inventory-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">
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
    </div>

    <div class="container-manage-import-products">
      <div id="inventory-filter-form">
        <div class="search-container">
          <input type="text" id="search-input" name="search"
            placeholder="Tra cứu số lượng tồn của sản phẩm"
            value="<?= htmlspecialchars($searchKeyword) ?>">
          <button type="submit" id="search-button"><i class="fa fa-search"></i> Tìm kiếm</button>
        </div>

        <div class="sort-container">
          <div class="sort-by-date-container">
            <label>Ngày:
              <input type="date" name="date" id="filter-date" class="input-sort-date" value="<?= $targetDate ?>">
            </label>
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <label for="warning-threshold" style="margin-bottom: 0; white-space: nowrap;">Ngưỡng cảnh báo:</label>
            <input type="number" id="warning-threshold" class="form-control custom-input" 
       value="<?= htmlspecialchars($warningThreshold) ?>" min="0" style="height: 38px; width: 80px;">
          </div>
          <div class="sort-by-order-status">
            <label for="sort-order">Tình trạng:</label>
            <select id="sort-order" name="status" class="status-select-custom">
              <option value="" selected>-- Tất cả loại --</option>
              <option value="instock">Còn hàng</option>
              <option value="almost">Sắp hết</option>
              <option value="outstock">Hết hàng</option>
            </select>
          </div>
          <!-- <button type="submit" id="filter-button" class="status-button">
            <i class="bi bi-funnel"></i> Tra cứu
          </button> -->
        </div>
      </div>
      <hr>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover data-table">
            <thead>
              <tr>
                <th scope="col" style="width: 5%;">ID</th>
                <th scope="col" style="width: 25%;">Tên sản phẩm</th>
                <th scope="col" style="width: 15%;">Loại</th>
                <th scope="col" style="width: 15%;">Thương hiệu</th>
                <th scope="col" style="width: 15%;">Giá bán lẻ</th>
                <th scope="col" style="width: 10%;" class="text-center">Tồn kho</th>
                <th scope="col" style="width: 15%;">Trạng thái</th>
              </tr>
            </thead>
            <tbody id="stock-list-container">
               </tbody>
          </table>
        </div>
      </div>

      <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0px;">
        <div class="container">
          <nav class="d-flex justify-content-center">
            <ul id="inventory-pagination-ul">
               </ul>
          </nav>
        </div>
      </section>
    </div>
  </main>

  <?php require_once __DIR__ . "/forms/footer.php" ?>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <?php require_once __DIR__ . "/forms/scripts.php" ?>
</body>
</html>