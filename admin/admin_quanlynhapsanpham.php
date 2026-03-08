<?php
$title = "Quản lý nhập sản phẩm";
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý nhập sản phẩm</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.html">Trang chủ</a></li>
            <li class="current">Quản lý nhập sản phẩm</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->





    <!-- Container phiếu nhập và nơi nhập phiếu -->
    <div class="container-manage-import-products">
      <h2 style="margin: 20px 0px;">Thêm Phiếu Nhập Mới</h2>
      <button class="create-import-btn">Tạo Phiếu Nhập</button>

      <!-- Pop-up Phiếu Nhập Mới -->
      <div id="DetailModal" class="modal">
        <div class="modal-content-admin">
          <span class="close-button">&times;</span>
          <h2>Thông tin phiếu nhập</h2>
          <div id="import-form-container">
            <div class="header-fields-row-manage-import">
              <div class="input-info-manage-import">
                <label>Ngày nhập:</label>
                <input type="date">
              </div>
              <div class="input-info-manage-import">
                <label>Mã phiếu:</label>
                <input type="text" placeholder="Nhập mã phiếu">
              </div>
            </div>
            <!-- Điền thông tin sản phẩm -->
            <div class="product-fields-template">
              <hr>

              <label for="manage-product-types">Loại sản phẩm:</label>
              <select class="manage-product-type">
                <option value="Guitar Classic">Classic</option>
                <option value="Guitar Acoustic">Acoustic</option>
              </select>
              <label for="manage-product-brands">Thương hiệu:</label>
              <select class="manage-product-brands">
                <!-- Điền bằng JS -->
              </select>
              <div style="margin-top: 10px; margin-bottom: 20px;">
                <label>Tên sản phẩm:</label>
                <input type="text" class="product-name-input" placeholder="Nhập tên sản phẩm" list="productNameList">
                <datalist id="productNameList"></datalist>
              </div>
              <label>Số Lượng:</label>
              <input type="number" min="1" style="width: 40px;">
              <label>Đơn giá:</label>
              <input type="text" class="unit-price-input" style="width: 150px;">
              <br>
              <button type="button" class="remove-product-btn">Xóa sản phẩm</button>
              <br>
            </div>
            <div id="manage-add-and-save-container">
              <button id="add-product-fields-template">Thêm sản phẩm</button>
              <button id="save-import-product">Lưu</button>
            </div>

          </div>
        </div>
      </div>


      <hr style="border: 1px solid black;">
      <!-- Danh sách phiếu nhập -->
      <h2>Danh Sách Phiếu Nhập Sản Phẩm</h2>
      <!-- Search -->
      <form action="" class="search-container" method="get"><!-- Search box -->
        <input type="text" id="search-input" placeholder="Tìm kiếm mã phiếu nhập" name="search">
        <button id="search-button">
          <i class="fa fa-search"></i> Tìm kiếm
        </button>
      </form><!-- End Search box -->

      <div class="sort-container"> <!-- Sort-container -->
        <div class="sort-by-date-container">
          <label>Từ ngày:<input type="date" class="input-sort-date"></label>

          <label>Đến ngày:<input type="date" class="input-sort-date"></label>
        </div>
        <div class="sort-by-order-status">
          <label for="sort-order">Tình trạng:</label>
          <select id="sort-order" class="status-select-custom">
            <option value="newest">Mới nhất</option>
            <option value="oldest">Cũ nhất</option>
          </select>
        </div>
        <button id="filter-button" class="status-button">
          <i class="bi bi-funnel"></i> Tra cứu
        </button>
      </div>

      <!-- Phiếu nhập thứ nhất -->
      <hr>
      <h3>Ngày nhập: 23/10/2025</h3>
      <h3>Mã phiếu: 1234</h3>
      <table class="data-table">
        <thead>
          <tr>
            <th style="width: 40%;">Sản phẩm</th>
            <th style="width:10%">Loại</th>
            <th style="width: 10%;">Số lượng</th>
            <th style="width: 20%;">Đơn giá</th>
          </tr>
        </thead>
        <tbody id="categoryList">
          <tr>
            <td>Taloy A12E</td>
            <td>Acoustic</td>
            <td>2</td>
            <td>85.000.000 VND</td>
          </tr>
          <tr>
            <td>Ba Đờn</td>
            <td>Classic</td>
            <td>5</td>
            <td>5.000.000 VND</td>
          </tr>
          <tr>
            <td>Enya EGA X0 PRO SP1</td>
            <td>Acoustic</td>
            <td>1</td>
            <td>11.300.000 VND</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Tổng: 217.600.000 VND</th>
          </tr>
        </tfoot>
      </table>

      <!-- Phiếu nhập thứ hai -->
      <hr>
      <h3>Ngày nhập: 10/10/2025</h3>
      <h3>Mã phiếu: 1233</h3>
      <table class="data-table">
        <thead>
          <tr>
            <th style="width: 40%;">Sản phẩm</th>
            <th style="width:10%">Loại</th>
            <th style="width: 10%;">Số lượng</th>
            <th style="width: 20%;">Đơn giá</th>
          </tr>
        </thead>
        <tbody id="categoryList">
          <tr>
            <td>Saga CL65</td>
            <td>Acoustic</td>
            <td>10</td>
            <td>2.000.000 VND</td>
          </tr>
          <tr>
            <td>Ba Đờn</td>
            <td>Classic</td>
            <td>3</td>
            <td>5.000.000 VND</td>
          </tr>
          <tr>
            <td>Yamaha LS36 ARE</td>
            <td>Acoustic</td>
            <td>7</td>
            <td>6.500.000 VND</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Tổng: 80.500.000 VND</th>
          </tr>
        </tfoot>
      </table>

      <!-- Phiếu nhập thứ ba -->
      <hr>
      <h3>Ngày nhập: 12/6/2025</h3>
      <h3>Mã phiếu: 1232</h3>
      <table class="data-table" style="margin-bottom: 20px;">
        <thead>
          <tr>
            <th style="width: 40%;">Sản phẩm</th>
            <th style="width:10%">Loại</th>
            <th style="width: 10%;">Số lượng</th>
            <th style="width: 20%;">Đơn giá</th>
          </tr>
        </thead>
        <tbody id="categoryList">
          <tr>
            <td>Saga SS 8CE</td>
            <td>Acoustic</td>
            <td>1</td>
            <td>6.500.000 VND</td>
          </tr>
          <tr>
            <td>Ba Đờn</td>
            <td>Classic</td>
            <td>3</td>
            <td>5.000.000 VND</td>
          </tr>
          <tr>
            <td>Enya EGA X0 PRO SP1</td>
            <td>Acoustic</td>
            <td>1</td>
            <td>11.300.000 VND</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Tổng: 32.800.000 VND</th>
          </tr>
        </tfoot>
      </table>





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
</body>


</html>