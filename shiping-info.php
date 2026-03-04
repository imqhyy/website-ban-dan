<?php
require_once 'forms/init.php'; ?>
<?php $title = "Thông Tin Vận Chuyển - Guitar Xì Gòn";
include 'forms/head.php' ?>

<body class="shiping-info-page">
  <?php include 'forms/header.php' ?>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Thông tin vận chuyển</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Thông tin vận chuyển</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Page Title -->

    <!-- Shipping Info Section -->
    <section id="shipping-info" class="shipping-info section">
      <div class="container" data-aos="fade-up">
        <div class="content-wrapper">
          <!-- Delivery Options -->
          <div class="content-block" data-aos="fade-up" data-aos-delay="100">
            <div class="section-heading">
              <i class="bi bi-truck"></i>
              <h3>Tùy chọn giao hàng</h3>
              <p>Chọn phương thức giao hàng phù hợp với nhu càu của bạn</p>
            </div>

            <div class="row gy-4 gx-lg-5">
              <div class="col-md-6 col-lg-4">
                <div class="delivery-card">
                  <div class="card-icon">
                    <i class="bi bi-lightning-charge"></i>
                  </div>
                  <h4>Giao hàng hỏa tốc</h4>
                  <p>
                    Đơn hàng của các bạn sẽ được đưa đơn trong 24h tới khi đặt
                    trên live trên các nền tảng của cửa hàng chúng tôi.
                  </p>
                  <div class="delivery-time">
                    <i class="bi bi-clock"></i>
                    <span>1-2 ngày kể từ ngày đặt hàng</span>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-4">
                <div class="delivery-card">
                  <div class="card-icon">
                    <i class="bi bi-box-seam"></i>
                  </div>
                  <h4>Tiêu chuẩn vận chuyển</h4>
                  <p>
                    Chúng tôi sẽ tiến hàng chuẩn bị đơn hàng khi nhận được hóa
                    đơn và sẽ giao trong vòng 3-5 ngày .
                  </p>
                  <div class="delivery-time">
                    <i class="bi bi-clock"></i>
                    <span>3-5 ngày kể từ ngày đặt hàng</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="delivery-card">
                  <div class="card-icon">
                    <i class="bi bi-pin-map"></i>
                  </div>
                  <h4>Vận chuyển nội địa</h4>
                  <p>
                    Cửa hàng chúng tôi có dịch vụ vận chuyển toàn quốc và sẽ
                    luôn đảm bảo về chất lượng trong quá trình đóng gói và vận
                    chuyển.
                  </p>
                  <div class="delivery-time">
                    <i class="bi bi-clock"></i>
                    <span>10-14 ngày (Tùy thuộc vào quốc gia bạn đặt hàng)
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Shipping Costs -->
          <div class="content-block" data-aos="fade-up" data-aos-delay="200">
            <div class="section-heading">
              <i class="bi bi-cash-coin"></i>
              <h3>Chi phí vận chuyển</h3>
              <p>Bảng giá gốc và uy tín cho tất cả các lựa chọn vận chuyển</p>
            </div>

            <div class="shipping-rates">
              <div class="rate-item">
                <div class="rate-type">Giá Vận chuyển Tiêu chuẩn</div>
                <div class="rate-cost">Giá: 20.000VND</div>
                <div class="rate-info">
                  Áp dụng phí ship cho đơn hàng dưới 2.000.000VND
                </div>
              </div>
              <div class="rate-item highlight">
                <div class="rate-type">Miễn phí vận chuyển</div>
                <div class="rate-info">Cho đơn hàng trên 2.000.000VND</div>
              </div>
              <div class="rate-item">
                <div class="rate-type">Vận chuyển hỏa tốc</div>
                <div class="rate-cost">35.000VND</div>
                <div class="rate-info">Nhận hàng trong vòng 1-2 ngày</div>
              </div>
            </div>
          </div>

          <!-- International Shipping -->
          <div class="content-block" data-aos="fade-up" data-aos-delay="300">
            <div class="section-heading">
              <i class="bi bi-globe"></i>
              <h3>Vận chuyển Quốc tế</h3>
              <p>
                Chúng tôi giao hàng trên toàn thế giới với các hãng vận chuyển
                đáng tin cậy.
              </p>
            </div>

            <div class="international-info">
              <div class="info-item">
                <i class="bi bi-clock-history"></i>
                <h5>Thời gian Giao hàng:</h5>
                <p>5-10 ngày làm việc cho hầu hết các điểm đến quốc tế.</p>
              </div>
              <div class="info-item">
                <i class="bi bi-currency-dollar"></i>
                <h5>Thuế &amp; Phí hải quan:</h5>
                <p>
                  Thuế nhập khẩu và các loại phí không được bao gồm trong chi
                  phí vận chuyển.
                </p>
              </div>
              <div class="info-item">
                <i class="bi bi-shield-check"></i>
                <h5>Dịch vụ Đáng tin cậy:</h5>
                <p>
                  Giao hàng có theo dõi (tracking) với các hãng vận chuyển
                  quốc tế hàng đầu.
                </p>
              </div>
            </div>
          </div>

          <!-- FAQ Section -->
          <div class="content-block" data-aos="fade-up" data-aos-delay="400">
            <div class="section-heading">
              <i class="bi bi-question-circle"></i>
              <h3>Câu hỏi về quá trình vận chuyển</h3>
              <p>Các Câu hỏi Thường gặp về Dịch vụ Vận chuyển</p>
            </div>

            <div class="faq-list">
              <div class="faq-item">
                <h3>
                  <i class="bi bi-question-circle"></i>
                  Tôi có thể theo dõi đơn hàng của mình bằng cách nào?
                  <i class="bi bi-chevron-down faq-toggle"></i>
                </h3>
                <div class="faq-answer">
                  <p>
                    Bạn có thể theo dõi đơn hàng bằng mã vận đơn (tracking
                    number) được cung cấp trong email xác nhận vận chuyển.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <h3>
                  <i class="bi bi-question-circle"></i>
                  Nếu tôi không có mặt ở nhà lúc giao hàng thì sao?
                  <i class="bi bi-chevron-down faq-toggle"></i>
                </h3>
                <div class="faq-answer">
                  <p>
                    Đơn vị vận chuyển sẽ để lại thông báo, sau đó họ sẽ thử
                    giao lại lần nữa hoặc để lại đơn hàng của bạn tại một địa
                    điểm an toàn..
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <h3>
                  <i class="bi bi-question-circle"></i>
                  Các bạn có giao hàng vào cuối tuần không?
                  <i class="bi bi-chevron-down faq-toggle"></i>
                </h3>
                <div class="faq-answer">
                  <p>
                    Giao hàng cuối tuần chỉ áp dụng cho dịch vụ vận chuyển
                    nhanh (express shipping) tại một số khu vực được chọn.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Shipping Info Section -->
  </main>

  <?php include 'forms/footer.php' ?>
    <?php include 'forms/scripts.php' ?>
  <script src="assets/js/auth.js"></script>
</body>

</html>