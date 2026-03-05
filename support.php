<?php
require_once 'forms/init.php'; ?>
<?php $title = "Hỗ Trợ - Guitar Xì Gòn";
include 'forms/head.php' ?>

<body class="support-page">
  <?php include 'forms/header.php' ?>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Hỗ trợ</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Hỗ trợ</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Page Title -->

    <!-- Support Section -->
    <section id="support" class="support section">
      <div class="container" data-aos="fade-up">
        <!-- Support Header -->
        <div class="support-header" data-aos="fade-up">
          <div class="header-content">
            <h2>Trung tâm Trợ giúp &amp; Hỗ trợ</h2>
            <p>
              Tìm câu trả lời, hướng dẫn và nhận sự hỗ trợ từ đội ngũ của
              chúng tôi.
            </p>
          </div>
        </div>

        <!-- Quick Support Actions -->
        <div class="quick-support" data-aos="fade-up" data-aos-delay="100">
          <div class="action-item live-chat">
            <div class="action-content">
              <i class="bi bi-chat-text"></i>
              <h4>Trò chuyện trực tiếp</h4>
              <p>Trò chuyện với đội ngũ hỗ trợ của chúng tôi</p>
              <a href="#" class="action-button">Bắt đầu trò chuyện</a>
            </div>
          </div>

          <div class="action-item phone">
            <div class="action-content">
              <i class="bi bi-telephone"></i>
              <h4>Gọi cho chúng tôi</h4>
              <p>Đường dây hỗ trợ 24/7</p>
              <a href="tel:1234567890" class="action-button">0123456789</a>
            </div>
          </div>

          <div class="action-item email">
            <div class="action-content">
              <i class="bi bi-envelope"></i>
              <h4>Hỗ trợ qua email</h4>
              <p>Nhận hỗ trợ thông qua email</p>
              <a href="#" class="action-button">Gửi email</a>
            </div>
          </div>
        </div>

        <!-- Help Topics -->
        <div class="help-categories" data-aos="fade-up" data-aos-delay="200">
          <h3>Chủ đề hỗ trợ phổ biến</h3>
          <div class="category-cards">
            <a href="#" class="category-card" data-aos="zoom-in" data-aos-delay="100">
              <span class="icon"><i class="bi bi-box-seam"></i></span>
              <h5>Đơn hàng &amp; Giao hàng</h5>
              <ul>
                <li>Theo dõi đơn hàng</li>
                <li>Phương thức vận chuyển</li>
                <li>Đổi &amp; trả hàng</li>
              </ul>
              <span class="arrow"><i class="bi bi-arrow-right"></i></span>
            </a>

            <a href="#" class="category-card" data-aos="zoom-in" data-aos-delay="200">
              <span class="icon"><i class="bi bi-wallet2"></i></span>
              <h5>Hóa đơn &amp; Thanh toán</h5>
              <ul>
                <li>Phương thức thanh toán</li>
                <li>Hoá đơn</li>
                <li>Trạng thái hoàn tiền</li>
              </ul>
              <span class="arrow"><i class="bi bi-arrow-right"></i></span>
            </a>

            <a href="#" class="category-card" data-aos="zoom-in" data-aos-delay="300">
              <span class="icon"><i class="bi bi-person-gear"></i></span>
              <h5>Cài đặt tài khoản</h5>
              <ul>
                <li>Quản lý hồ sơ cá nhân</li>
                <li>Đặt lại mật khẩu</li>
                <li>Cài đặt quyền riêng tư</li>
              </ul>
              <span class="arrow"><i class="bi bi-arrow-right"></i></span>
            </a>

            <a href="#" class="category-card" data-aos="zoom-in" data-aos-delay="400">
              <span class="icon"><i class="bi bi-shield-check"></i></span>
              <h5>Bảo mật</h5>
              <ul>
                <li>Bảo mật tài khoản</li>
                <li>Xác thực hai bước</li>
                <li>Chính sách bảo mật</li>
              </ul>
              <span class="arrow"><i class="bi bi-arrow-right"></i></span>
            </a>
          </div>
        </div>

        <!-- Self Help -->
        <div class="self-help" data-aos="fade-up" data-aos-delay="300">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="content-box">
                <h3>Tính năng trả lời câu hỏi tự động</h3>
                <p class="subtitle">
                  Tìm câu trả lời nhanh chóng với hệ thống kiến thức toàn diện
                  của chúng tôi.
                </p>
                <div class="resource-links">
                  <a href="#" class="resource-link">
                    <i class="bi bi-play-circle"></i>
                    <div class="link-content">
                      <h6>Video hướng dẫn</h6>
                      <p>Hướng dẫn từng bước bằng video.</p>
                    </div>
                  </a>
                  <a href="#" class="resource-link">
                    <i class="bi bi-file-text"></i>
                    <div class="link-content">
                      <h6>Hướng dẫn sử dụng</h6>
                      <p>Tài liệu chi tiết và dễ hiểu.</p>
                    </div>
                  </a>
                  <a href="#" class="resource-link">
                    <i class="bi bi-book"></i>
                    <div class="link-content">
                      <h6>Kho kiến thức</h6>
                      <p>Bài viết và hướng dẫn chuyên sâu.</p>
                    </div>
                  </a>
                  <a href="#" class="resource-link">
                    <i class="bi bi-tools"></i>
                    <div class="link-content">
                      <h6>Khắc phục sự cố</h6>
                      <p>Các vấn đề thường gặp và cách xử lý.</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="faq-section">
                <h4>Câu hỏi thường gặp</h4>
                <div class="faq-list">
                  <div class="faq-item">
                    <h3>
                      Làm thế nào để theo dõi đơn hàng của tôi?
                      <i class="bi bi-plus faq-toggle"></i>
                    </h3>
                    <div class="faq-answer">
                      <p>
                        Bạn có thể theo dõi đơn hàng bằng cách nhập mã đơn
                        hàng của mình trong mục Theo dõi đơn hàng trên
                        website.
                      </p>
                    </div>
                  </div>

                  <div class="faq-item">
                    <h3>
                      Tôi có thể thay đổi địa chỉ giao hàng không?
                      <i class="bi bi-plus faq-toggle"></i>
                    </h3>
                    <div class="faq-answer">
                      <p>
                        Vui lòng liên hệ bộ phận hỗ trợ để thay đổi địa chỉ
                        trước khi đơn hàng được gửi đi.
                      </p>
                    </div>
                  </div>

                  <div class="faq-item">
                    <h3>
                      Bạn chấp nhận những phương thức thanh toán nào?
                      <i class="bi bi-plus faq-toggle"></i>
                    </h3>
                    <div class="faq-answer">
                      <p>
                        Chúng tôi chấp nhận tất cả các loại thẻ tín dụng phổ
                        biến và thanh toán qua PayPal.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Support Section -->
  </main>

  <?php include 'forms/footer.php' ?>
    <?php include 'forms/scripts.php' ?>
</body>

</html>