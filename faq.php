<?php
require_once 'forms/init.php'; ?>
<?php $title = "FAQ - Guitar Xì Gòn";
include 'forms/head.php' ?>

  <body class="faq-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
      <!-- Page Title -->
      <div class="page-title light-background">
        <div
          class="container d-lg-flex justify-content-between align-items-center"
        >
          <h1 class="mb-2 mb-lg-0">Câu hỏi thường gặp</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.php">Trang chủ</a></li>
              <li class="current">Câu hỏi thường gặp</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- End Page Title -->

      <!-- Faq Section -->
      <section id="faq" class="faq section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-4 justify-content-between">
            <div class="col-lg-8">
              <div class="faq-list">
                <div
                  class="faq-item faq-active"
                  data-aos="fade-up"
                  data-aos-delay="100"
                >
                  <h3>Khi mua đàn có bảo hành không?</h3>
                  <div class="faq-content">
                    <p>
                      Khi mua đàn tại Guitar Xì Gòn, sẽ có bảo hành trong 12
                      tháng và hỗ trợ sửa lỗi do nhà sản xuất.
                    </p>
                  </div>
                  <i class="bi bi-plus faq-toggle"></i>
                </div>
                <!-- End FAQ Item-->

                <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                  <h3>Shop có hỗ trợ ship toàn quốc không?</h3>
                  <div class="faq-content">
                    <p>
                      Nếu quý khách ở xa cửa hàng, Guitar Xì Gòn sẽ gửi đàn cho
                      quý khách qua những đơn vị vận chuyển uy tín nhất, đảm bảo
                      đóng gói và chống sốc an toàn.
                    </p>
                  </div>
                  <i class="bi bi-plus faq-toggle"></i>
                </div>
                <!-- End FAQ Item-->

                <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                  <h3>
                    Shop có chương trình giảm giá cho học sinh, sinh viên không?
                  </h3>
                  <div class="faq-content">
                    <p>
                      Guitar Xì Gòn đặc biết thường xuyên có các chương trình
                      khuyến mãi dành cho các bạn học sinh - sinh viên, quý
                      khách hãy theo dõi trang web thường xuyên để có thông tin
                      mới nhất về chương trình khuyến mãi.
                    </p>
                  </div>
                  <i class="bi bi-plus faq-toggle"></i>
                </div>
                <!-- End FAQ Item-->

                <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                  <h3>
                    Tôi có thể đến trực tiếp cửa hàng để xem và mua đàn không?
                  </h3>
                  <div class="faq-content">
                    <p>
                      Quý khách hoàn toàn có thể đến cửa hàng tại địa chỉ "273
                      An Dương Vương, Phường, Chợ Quán, Hồ Chí Minh 700000" để
                      xem và mua đàn.
                    </p>
                  </div>
                  <i class="bi bi-plus faq-toggle"></i>
                </div>
                <!-- End FAQ Item-->
              </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
              <div class="faq-card">
                <i class="bi bi-chat-dots-fill"></i>
                <h3>Không thấy câu hỏi của bạn?</h3>
                <p>
                  Đừng lo, bạn có thể gọi trực tiếp đến số diện thoại 0123456789
                  hoặc gửi mail đến email guitarxigon@gmail.com để được tư vấn,
                  chúng tôi luôn đón tiếp bạn.
                </p>
                <a href="#" class="btn btn-primary">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Faq Section -->
    </main>

    <?php include 'forms/header.php' ?>
    <?php include 'forms/scripts.php' ?>
    <script src="assets/js/auth.js"></script>
  </body>
</html>
