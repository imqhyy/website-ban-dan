<?php
require_once 'forms/init.php'; ?>
<?php $title = "Xác Nhận Đơn Hàng - Guitar Xì Gòn";
include 'forms/head.php' ?>

  <body class="order-confirmation-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
      <div class="page-title light-background">
        <div
          class="container d-lg-flex justify-content-between align-items-center"
        >
          <h1 class="mb-2 mb-lg-0">Xác nhận đơn hàng</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.php">Trang chủ</a></li>
              <li class="current">Xác nhận đơn hàng</li>
            </ol>
          </nav>
        </div>
      </div>
      <section id="order-confirmation" class="order-confirmation section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="order-confirmation-3">
            <div class="row g-0">
              <div class="col-lg-4 sidebar" data-aos="fade-right">
                <div class="sidebar-content">
                  <div class="success-animation">
                    <i class="bi bi-check-lg"></i>
                  </div>
                  <div class="order-id">
                    <h4 id="summary-order-id"></h4>
                    <div class="order-date" id="summary-order-date"></div>
                  </div>
                  <div class="price-summary">
                    <h5>Tóm tắt đơn hàng</h5>
                    <!-- <ul class="summary-list" id="summary-price-list"></ul> --> <!--Chỗ này có code bên js giúp điền tự động nhưng code đó đang lỗi nên ẩn r-->
                    <ul class="summary-list">
                      <li>
                        <span>Tổng sản phẩm</span>
                        <span>92.000.000 VND</span>
                      </li>
                      <li>
                        <span>Phí vận chuyển</span>
                        <span>Miễn phí</span>
                      </li>
                      <li>
                        <span>Thuế</span>
                        <span>0 VND</span>
                      </li>
                      <li class="total">
                        <span>Total</span>
                        <span>92.000.000 VND</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 main-content" data-aos="fade-in">
                <div class="thank-you-message">
                  <h1 id="thank-you-name">Cảm ơn bạn đã đặt hàng!</h1>
                  <p>
                    Chúng tôi đã nhận được đơn hàng và sẽ xử lý ngay. Một email
                    xác nhận cùng thông tin chi tiết đã được gửi đến bạn.
                  </p>
                </div>
                <div class="details-card" data-aos="fade-up">
                  <div class="card-header">
                    <h3><i class="bi bi-geo-alt"></i>Chi tiết giao hàng</h3>
                  </div>
                  <div class="card-body">
                    <div class="row g-4">
                      <div class="col-md-12">
                        <div class="detail-group">
                          <label>Giao đến</label>
                          <address id="shipping-address-details"></address>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="details-card" data-aos="fade-up">
                  <div class="card-header">
                    <h3><i class="bi bi-bag-check"></i>Sản phẩm đã đặt</h3>
                  </div>
                  <div class="card-body" id="confirmation-item-list"></div>
                </div>
                <div class="action-area" data-aos="fade-up">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <a href="all.php" class="btn btn-back"
                        ><i class="bi bi-arrow-left"></i>Tiếp tục mua sắm</a
                      >
                    </div>
                    <div class="col-md-6">
                      <a href="account.php#" class="btn btn-account"
                        ><span>Xem trong Tài khoản</span
                        ><i class="bi bi-arrow-right"></i
                      ></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include 'forms/footer.php' ?>
    <?php include 'forms/scripts.php' ?>
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/order-confirmation.js"></script>
  </body>
</html>
