<?php require_once('forms/init.php'); ?>
<?php
// Lấy 1 Sản phẩm nổi bật ngẫu nhiên
$heroStmt = $pdo->prepare("SELECT p.*, c.category_name, b.brand_name,
                           (SELECT AVG(rating) FROM reviews WHERE product_id = p.id AND status = 'visible') as avg_rating,
                           (SELECT COUNT(id) FROM reviews WHERE product_id = p.id AND status = 'visible') as total_reviews
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id
                           LEFT JOIN brands b ON p.brand_id = b.id
                           WHERE p.status = 'visible' ORDER BY RAND() LIMIT 1");
$heroStmt->execute();
$heroProduct = $heroStmt->fetch();

// Lấy 4 Sản phẩm bán chạy (ID order)
$bestSellersStmt = $pdo->prepare("SELECT p.*, c.category_name, b.brand_name,
                                  (SELECT AVG(rating) FROM reviews WHERE product_id = p.id AND status = 'visible') as avg_rating,
                                  (SELECT COUNT(id) FROM reviews WHERE product_id = p.id AND status = 'visible') as total_reviews
                                  FROM products p 
                                  LEFT JOIN categories c ON p.category_id = c.id
                                  LEFT JOIN brands b ON p.brand_id = b.id
                                  WHERE p.status = 'visible' LIMIT 4");
$bestSellersStmt->execute();
$bestSellers = $bestSellersStmt->fetchAll();

$title = "Trang Chủ - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="index-page">
  <?php include 'forms/header.php' ?>

  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-container">
        <div class="hero-content">
          <div class="content-wrapper" data-aos="fade-up" data-aos-delay="100">
            <h1 class="hero-title">Sản phẩm nổi bật</h1>
            <p class="hero-description">
              Khám phá bộ sưu tập guitar cao cấp, mang lại âm thanh tinh tế và
              đẳng cấp. Từ classic đến acoustic, tất cả đều sẵn sàng với ưu
              đãi độc quyền và giao hàng nhanh chóng.
            </p>
            <div class="hero-actions" data-aos="fade-up" data-aos-delay="200">
              <a href="all.php" class="btn-secondary">Xem toàn bộ đàn</a>
            </div>
            <div class="features-list" data-aos="fade-up" data-aos-delay="300">
              <div class="feature-item">
                <i class="bi bi-truck"></i>
                <span>Giao hàng miễn phí</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-award"></i>
                <span>Chất lượng</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-headset"></i>
                <span>Hỗ trợ nhiệt tình</span>
              </div>
            </div>
          </div>
        </div>

        <div class="hero-visuals">
          <div class="product-showcase" data-aos="fade-left" data-aos-delay="200">
            <?php if ($heroProduct):
              $images = !empty($heroProduct['product_images']) ? explode(',', $heroProduct['product_images']) : [];
              $mainImg = 'assets/img/default-1.jpg';
              if (!empty($images[0]) && isset($guitarimg_direct)) {
                $mainImg = $guitarimg_direct . create_slug($heroProduct['category_name']) . '/' . create_slug($heroProduct['brand_name']) . '/' . create_slug($heroProduct['product_name']) . '/' . trim($images[0]);
              }

              $originalPrice = $heroProduct['selling_price'];
              $discount = $heroProduct['discount_percent'];
              $actualPrice = $originalPrice;
              if ($discount > 0) {
                $actualPrice = $originalPrice - ($originalPrice * $discount / 100);
              }
              ?>
              <div class="product-card featured">
                <a href="product-details.php?id=<?= $heroProduct['id'] ?>">
                  <img src="<?= htmlspecialchars($mainImg) ?>" alt="Featured Product" class="img-fluid" />
                </a>
                <div class="product-badge">Điểm nhấn</div>
                <div class="product-info">
                  <a href="product-details.php?id=<?= $heroProduct['id'] ?>" class="product-title"
                    style="font-size: 25px"><?= htmlspecialchars($heroProduct['product_name']) ?></a>
                  <div class="price">
                    <span class="sale-price"><?= number_format($actualPrice, 0, ',', '.') ?> VND</span>
                    <?php if ($discount > 0): ?>
                      <span class="original-price"><?= number_format($originalPrice, 0, ',', '.') ?> VND</span>
                    <?php endif; ?>
                  </div>
                </div>
                <?php
                $h_avg_r = (float) ($heroProduct['avg_rating'] ?? 0);
                $h_tot_r = (int) ($heroProduct['total_reviews'] ?? 0);
                ?>
                <div class="product-rating"
                  style="display: flex; justify-content: flex-end; align-items:center; gap:4px; font-size:14px;">
                  <i class="bi bi-star-fill" style="color:<?= $h_tot_r > 0 ? '#FBBF24' : '#D1D5DB' ?>;"></i>
                  <span
                    style="font-weight:600;color:<?= $h_tot_r > 0 ? '#111827' : '#9CA3AF' ?>;"><?= $h_tot_r > 0 ? number_format($h_avg_r, 1) : '0.0' ?></span>
                  <span style="color:#9CA3AF;">(<?= $h_tot_r ?>)</span>
                </div>
              </div>
            <?php endif; ?>
            <!-- Ân 2 sản phẩm mini hiện lên sản phẩm to hơn, đẹp v xoá uổng -->
            <!-- <div class="product-grid">
              <div class="product-mini" data-aos="zoom-in" data-aos-delay="400">
                <a href="all.php">
                  <img src="assets\img\product\guitar\acoustic\yamaha\yamaha-apx600fm\1.jpg" alt="Product"
                    class="img-fluid">
                </a>
                <span class="mini-price">2.300.000 VND</span>
              </div>
              <div class="product-mini" data-aos="zoom-in" data-aos-delay="500">
                <a href="all.php">
                  <img src="assets\img\product\guitar\acoustic\enya\enya ega-x0-pro-sp1\8.jpg" alt="Product"
                    class="img-fluid">
                </a>
                <span class="mini-price">6.500.000 VND</span>
              </div>
            </div> -->
          </div>

          <div class="floating-elements">
            <a href="cart.php" class="floating-icon cart" data-aos="fade-up" data-aos-delay="600" hidden>
              <i class="bi bi-cart3"></i>
              <span class="notification-dot cart-item-count-badge"><?= isset($cart_count) ? $cart_count : 0 ?></span>
            </a>
            <!-- <div
                class="floating-icon search"
                data-aos="fade-up"
                data-aos-delay="800"
              >
                <i class="bi bi-search"></i>
              </div> -->
          </div>
        </div>
      </div>
    </section>
    <!-- /Hero Section -->

    <!--  -->

    <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Bán chạy nhất</h2>
        <p>Top những sản phẩm hay được đập nhất shop</p>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-5">
          <?php foreach ($bestSellers as $item):
            $images = !empty($item['product_images']) ? explode(',', $item['product_images']) : [];
            $mainImg = 'assets/img/default-1.jpg';
            if (!empty($images[0]) && isset($guitarimg_direct)) {
              $mainImg = $guitarimg_direct . create_slug($item['category_name']) . '/' . create_slug($item['brand_name']) . '/' . create_slug($item['product_name']) . '/' . trim($images[0]);
            }
            $originalPrice = $item['selling_price'];
            $discount = $item['discount_percent'];
            $actualPrice = $originalPrice;
            if ($discount > 0) {
              $actualPrice = $originalPrice - ($originalPrice * $discount / 100);
            }
            ?>
            <div class="col-lg-3 col-md-6">
              <div class="product-item">
                <div class="product-image">
                  <?php if ($discount > 0): ?>
                    <div class="product-badge sale-badge">-<?= $discount ?>%</div>
                  <?php endif; ?>
                  <a href="product-details.php?id=<?= $item['id'] ?>"><img src="<?= htmlspecialchars($mainImg) ?>"
                      alt="Product Image" class="img-fluid" loading="lazy" /></a>
                </div>
                <div class="product-info">
                  <div class="product-category">Bán chạy</div>
                  <h4 class="product-title">
                    <a href="product-details.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['product_name']) ?></a>
                  </h4>
                  <div class="product-price">
                    <span class="current-price"><?= number_format($actualPrice, 0, ',', '.') ?> VND</span>
                    <?php if ($discount > 0): ?>
                      <br />
                      <span class="old-price"><?= number_format($originalPrice, 0, ',', '.') ?> VND</span>
                    <?php endif; ?>
                  </div>
                  <?php
                  $b_avg_r = (float) ($item['avg_rating'] ?? 0);
                  $b_tot_r = (int) ($item['total_reviews'] ?? 0);
                  ?>
                  <div class="product-rating"
                    style="display: flex; justify-content: flex-end; align-items:center; gap:4px; font-size:14px;">
                    <i class="bi bi-star-fill" style="color:<?= $b_tot_r > 0 ? '#FBBF24' : '#D1D5DB' ?>;"></i>
                    <span
                      style="font-weight:600;color:<?= $b_tot_r > 0 ? '#111827' : '#9CA3AF' ?>;"><?= $b_tot_r > 0 ? number_format($b_avg_r, 1) : '0.0' ?></span>
                    <span style="color:#9CA3AF;">(<?= $b_tot_r ?>)</span>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <!-- /Best Sellers Section -->


  </main>

  <?php include 'forms/footer.php';
  include 'forms/scripts.php' ?>
  <script src="assets/js/login.js"></script>
</body>

</html>