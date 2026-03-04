<?php
require_once 'forms/init.php'; ?>

<?php $title = "404 - Guitar Xì Gòn";
include 'forms/head.php' ?>

<body class="index-page">

  </head>

  <body class="index-page">

    <?php include 'forms/header.php' ?>

    <main class="main">

      <!-- Page Title -->
      <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
          <h1 class="mb-2 mb-lg-0">404</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.php">Trang chủ</a></li>
              <li class="current">404</li>
            </ol>
          </nav>
        </div>
      </div><!-- End Page Title -->

      <!-- Error 404 Section -->
      <section id="error-404" class="error-404 section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

          <div class="text-center">
            <div class="error-icon mb-4" data-aos="zoom-in" data-aos-delay="200">
              <i class="bi bi-exclamation-circle"></i>
            </div>

            <h1 class="error-code mb-4" data-aos="fade-up" data-aos-delay="300">404</h1>

            <h2 class="error-title mb-3" data-aos="fade-up" data-aos-delay="400">Xin lỗi! Không tìm thấy trang</h2>

            <p class="error-text mb-4" data-aos="fade-up" data-aos-delay="500">
              Trang bạn đang tìm kiếm có thể đã bị xóa, đổi tên hoặc tạm tời không khả dụng
            </p>



            <div class="error-action" data-aos="fade-up" data-aos-delay="700">
              <a href="index.php" class="btn btn-primary">Trở về Trang chủ</a>
            </div>
          </div>

        </div>

      </section><!-- /Error 404 Section -->

    </main>

    <?php include 'forms/footer.php' ?>

    <?php include 'forms/scripts.php' ?>
    <script src="assets/js/auth.js"></script>
  </body>

  </html>