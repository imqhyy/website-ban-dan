<?php
$title = "Quản lý đơn hàng";
require_once(__DIR__ . '/forms/init.php');
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
  <?php require_once __DIR__ . "/forms/header.php" ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Quản lý đơn hàng</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="admin.html">Trang chủ</a></li>
            <li class="current">Quản lý đơn hàng</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->


    <div class="container-manage-import-products">
      <form action="" class="search-container" method="get"><!-- Search box -->
        <input type="text" id="search-input" placeholder="Tra cứu mã đơn hàng" name="search">
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
            <option value="newest">Mới đặt</option>
            <option value="processed">Đã xử lý</option>
            <option value="deliveried">Đã giao</option>
            <option value="cancel">Huỷ</option>
          </select>
        </div>
        <button id="filter-button" class="status-button">
          <i class="bi bi-funnel"></i> Tra cứu
        </button>
      </div>
      <hr>


      <!-- Pop-up Phiếu Nhập Mới -->
      <div id="DetailModal" class="modal">
        <div class="modal-content-admin">
          <span class="close-button">&times;</span>
          <h2>Chi tiết đơn hàng</h2>
          <!-- Thông tin đơn hàng -->
          <div>
            <label style="margin-right: 30px;">Ngày đặt hàng: <b>26/6/2025</b></label>
            <label>Mã đơn hàng: <b>#ORD-2025-1278</b></label>
            <br>
            <label style="margin-right: 30px;">Người nhận hàng: <b>Gi Đa Gòn</b></label>
            <label>Số điện thoại: <b>012223434</b></label>
            <br>
            <label>Địa chỉ: <b>5 Đường abc Quận XYZ</b></label>
            <label><b>Lưu ý: </b> Không giao hàng vào thứ 2 tại anh không thích</label>
          </div>
          <!-- thông tin sản phẩm -->
          <div class="product-fields-template">
            <hr>
            <label>Tên sản phẩm: <b>Saga X Pro</b></label>
            <br>
            <label>Loại sản phẩm: <b>Acoustic</b></label>

            <label>Thương hiệu: <b>Saga</b></label>
            <br>

            <label>Số Lượng: <b>1</b></label>
            <label>Đơn giá: <b>1.000.000VND</b></label>
          </div>
          <!-- thông tin sản phẩm -->
          <div class="product-fields-template">
            <hr>
            <label>Tên sản phẩm: <b>Enya Y Pro Max</b></label>
            <br>
            <label>Loại sản phẩm: <b>Acoustic</b></label>

            <label>Thương hiệu: <b>Enya</b></label>
            <br>

            <label>Số Lượng: <b>1</b></label>
            <label>Đơn giá: <b>4.000.000VND</b></label>
          </div>

          <!--tổng số tiền-->
          <label>Tổng số tiền: <b>5.000.000VND</b></label>

          <div id="close-detail-order-container">
            <button class="close-button-detail-order">Đóng</button>
          </div>
        </div>
      </div>



      <!-- Đơn hàng thứ 1 -->
      <div class="manage-order-container">
        <div class="info-and-status-order">
          <div class="info-order">
            <p>Mã đơn hàng: <b>1234</b></p>
            <p>Ngày đặt hàng: <b>26/10/2025</b></p>
            <p>Tổng tiền: <b>3.000.000VND</b></p>
          </div>
          <div class="status-block">
            <div>
              <p style="margin-bottom: 0px;">Tình trạng: <b class="order-status-value">Đã giao</b> <img
                  src="assets/img/iconbutton/pencil.png" class="edit-status-order" alt="Sửa trạng thái"
                  style="width: 15px; transform: translateY(-4px); cursor: pointer;"></p>
            </div>
            <div class="status-select-container hidden">
              <span class="status-select-button">Mới đặt</span>
              <hr style="margin: 0">
              <span class="status-select-button">Đã xử lý</span>
              <hr style="margin: 0">
              <span class="status-select-button">Đã giao</span>
              <hr style="margin: 0">
              <span class="status-select-button">Huỷ</span>
            </div>
          </div>

        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
          <button type="button" class="action-btn detail-btn">Chi tiết</button>
        </div>
      </div>

      <!-- Đơn hàng thứ 2 -->
      <div class="manage-order-container">
        <div class="info-and-status-order">
          <div class="info-order">
            <p>Mã đơn hàng: <b>1234</b></p>
            <p>Ngày đặt hàng: <b>26/10/2025</b></p>
            <p>Tổng tiền: <b>3.000.000VND</b></p>
          </div>
          <div class="status-block">
            <div>
              <p style="margin-bottom: 0px;">Tình trạng: <b class="order-status-value">Đã giao</b> <img
                  src="assets/img/iconbutton/pencil.png" class="edit-status-order" alt="Sửa trạng thái"
                  style="width: 15px; transform: translateY(-4px); cursor: pointer;"></p>
            </div>
            <div class="status-select-container hidden">
              <span class="status-select-button">Mới đặt</span>
              <hr style="margin: 0">
              <span class="status-select-button">Đã xử lý</span>
              <hr style="margin: 0">
              <span class="status-select-button">Đã giao</span>
              <hr style="margin: 0">
              <span class="status-select-button">Huỷ</span>
            </div>
          </div>

        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
          <button type="button" class="action-btn detail-btn">Chi tiết</button>
        </div>
      </div>

      <!-- Đơn hàng thứ 3 -->
      <div class="manage-order-container">
        <div class="info-and-status-order">
          <div class="info-order">
            <p>Mã đơn hàng: <b>1234</b></p>
            <p>Ngày đặt hàng: <b>26/10/2025</b></p>
            <p>Tổng tiền: <b>3.000.000VND</b></p>
          </div>
          <div class="status-block">
            <div>
              <p style="margin-bottom: 0px;">Tình trạng: <b class="order-status-value">Đã giao</b> <img
                  src="assets/img/iconbutton/pencil.png" class="edit-status-order" alt="Sửa trạng thái"
                  style="width: 15px; transform: translateY(-4px); cursor: pointer;"></p>
            </div>
            <div class="status-select-container hidden">
              <span class="status-select-button">Mới đặt</span>
              <hr style="margin: 0">
              <span class="status-select-button">Đã xử lý</span>
              <hr style="margin: 0">
              <span class="status-select-button">Đã giao</span>
              <hr style="margin: 0">
              <span class="status-select-button">Huỷ</span>
            </div>
          </div>
        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
          <button type="button" class="action-btn detail-btn">Chi tiết</button>
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
    </div> <!--End class container-manage-import-products-->










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
  <script src="../assets/js/admin2.js"></script>
</body>


</html>