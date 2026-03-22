<?php
require_once 'forms/init.php';

// Lấy id từ URL, validate
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
  header('Location: all.php');
  exit();
}

// Query sản phẩm + tên brand
$stmt = $pdo->prepare("
    SELECT p.*, b.brand_name, b.brand_slug
    FROM products p
    LEFT JOIN brands b ON p.brand_id = b.id
    WHERE p.id = ?
");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
  header('Location: all.php');
  exit();
}

// Tạo đường dẫn ảnh theo đúng công thức của all.php
$type_folder = create_slug($product['product_type']);
$brand_folder = create_slug($product['brand_name']);
$product_folder = create_slug($product['product_name']);
$base_path = $guitarimg_direct . $type_folder . '/' . $brand_folder . '/' . $product_folder . '/';

// Xử lý danh sách ảnh
$images = !empty($product['product_images'])
  ? array_map('trim', explode(',', $product['product_images']))
  : [];
$main_img = !empty($images[0]) ? $base_path . $images[0] : 'assets/img/default-1.jpg';

// Xử lý giá
$selling_price = (float) $product['selling_price'];
$cost_price = (float) $product['cost_price'];
$discount = (float) $product['discount_percent'];
$profit_margin = (float) $product['profit_margin'];

// Tính giá gốc hiển thị (trước giảm giá)
$original_price = $discount > 0
  ? round($selling_price / (1 - $discount / 100))
  : null;
$save_amount = $original_price ? $original_price - $selling_price : 0;

// Xử lý accessories JSON
$accessories_fixed = [];
$accessories_others = '';
if (!empty($product['accessories'])) {
  $acc = json_decode($product['accessories'], true);
  if ($acc) {
    $accessories_fixed = $acc['fixed'] ?? [];
    $accessories_others = $acc['others'] ?? '';
  }
}

// Highlights
$highlights = [];
for ($i = 1; $i <= 4; $i++) {
  if (!empty($product["highlight_{$i}_title"])) {
    $highlights[] = [
      'title' => $product["highlight_{$i}_title"],
      'content' => $product["highlight_{$i}_content"] ?? '',
    ];
  }
}

$title = htmlspecialchars($product['product_name']) . ' - Guitar Xì Gòn';
include 'forms/head.php';
?>

<body class="product-details-page">
  <?php include 'forms/header.php' ?>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Chi tiết sản phẩm</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="all.php">Sản phẩm</a></li>
            <li class="current"><?= htmlspecialchars($product['product_name']) ?></li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Product Details Section -->
    <section id="product-details" class="product-details section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">

          <!-- Product Gallery -->
          <div class="col-lg-7" data-aos="zoom-in" data-aos-delay="150">
            <div class="product-gallery">
              <div class="main-showcase">
                <div class="image-zoom-container">
                  <img src="<?= $main_img ?>"
                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                    class="img-fluid main-product-image drift-zoom"
                    id="main-product-image"
                    data-zoom="<?= $main_img ?>" />
                  <div class="image-navigation">
                    <button class="nav-arrow prev-image image-nav-btn prev-image" type="button">
                      <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="nav-arrow next-image image-nav-btn next-image" type="button">
                      <i class="bi bi-chevron-right"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="thumbnail-grid">
                <?php foreach ($images as $i => $img): ?>
                    <div class="thumbnail-wrapper thumbnail-item <?= $i === 0 ? 'active' : '' ?>"
                      data-image="<?= $base_path . $img ?>">
                      <img src="<?= $base_path . $img ?>"
                        alt="View <?= $i + 1 ?>" class="img-fluid" />
                    </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
            <div class="product-details">
              <div class="product-badge-container">
                <span class="badge-category"><?= htmlspecialchars($product['product_type']) ?></span>
                <div class="rating-group">
                  <div class="stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                  </div>
                  <span class="review-text">(127 đánh giá)</span>
                </div>
              </div>

              <h1 class="product-name"><?= htmlspecialchars($product['product_name']) ?></h1>

              <div class="pricing-section">
                <div class="price-display">
                  <span class="sale-price"><?= number_format($selling_price, 0, ',', '.') ?> VND</span>
                  <?php if ($original_price): ?>
                      <span class="regular-price"><?= number_format($original_price, 0, ',', '.') ?> VND</span>
                  <?php endif; ?>
                </div>
                <?php if ($discount > 0): ?>
                    <div class="savings-info">
                      <span class="save-amount">Tiết kiệm <?= number_format($save_amount, 0, ',', '.') ?> VND</span>
                      <span class="discount-percent">(Giảm <?= $discount ?>%)</span>
                    </div>
                <?php endif; ?>
              </div>

              <?php if (!empty($product['summary_description'])): ?>
                  <div class="product-description">
                    <p><?= htmlspecialchars($product['summary_description']) ?></p>
                  </div>
              <?php endif; ?>

              <div class="availability-status">
                <div class="stock-indicator">
                  <i class="bi bi-check-circle-fill"></i>
                  <span class="stock-text">Còn hàng</span>
                </div>
              </div>

              <div class="variant-section"></div>

              <!-- Purchase Options -->
              <div class="purchase-section">
                <div class="quantity-control">
                  <label class="control-label">Số lượng:</label>
                  <div class="quantity-input-group">
                    <div class="quantity-selector">
                      <button class="quantity-btn decrease" type="button">
                        <i class="bi bi-dash"></i>
                      </button>
                      <input type="number" class="quantity-input" id="quantity-input" value="1" min="1" />
                      <button class="quantity-btn increase" type="button">
                        <i class="bi bi-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="action-buttons">
                  <button class="btn primary-action" id="add-to-cart-btn"
                    data-product-id="<?= $product['id'] ?>"
                    data-product-name="<?= htmlspecialchars($product['product_name']) ?>">
                    <i class="bi bi-bag-plus"></i>
                    Thêm vào giỏ hàng
                  </button>
                  <button class="btn secondary-action" onclick="window.location.href='cart.php'">
                    <i class="bi bi-lightning"></i>
                    Mua ngay
                  </button>
                </div>
              </div>

              <!-- Benefits -->
              <div class="benefits-list">
                <div class="benefit-item"><i class="bi bi-truck"></i><span>Free ship cho đơn từ 1 triệu đồng</span></div>
                <div class="benefit-item"><i class="bi bi-arrow-clockwise"></i><span>45 ngày đổi trả</span></div>
                <div class="benefit-item"><i class="bi bi-shield-check"></i><span>Bảo hành lên đến 3 năm</span></div>
                <div class="benefit-item"><i class="bi bi-headset"></i><span>Hỗ trợ 24/7</span></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Information Tabs -->
        <div class="row mt-5" data-aos="fade-up" data-aos-delay="300">
          <div class="col-12">
            <div class="info-tabs-container">
              <nav class="tabs-navigation nav">
                <button class="nav-link active" data-bs-toggle="tab"
                  data-bs-target="#ecommerce-product-details-5-overview" type="button">
                  Tổng quan
                </button>
                <button class="nav-link" data-bs-toggle="tab"
                  data-bs-target="#ecommerce-product-details-5-customer-reviews" type="button">
                  Đánh giá (127)
                </button>
              </nav>

              <div class="tab-content">

                <!-- Tab Tổng quan -->
                <div class="tab-pane fade show active" id="ecommerce-product-details-5-overview">
                  <div class="overview-content">
                    <div class="row g-4">
                      <div class="col-lg-8">
                        <div class="content-section">
                          <h3>Tổng quan sản phẩm</h3>
                          <?php if (!empty($product['detailed_overview'])): ?>
                              <p><?= nl2br(htmlspecialchars($product['detailed_overview'])) ?></p>
                          <?php endif; ?>

                          <?php if (!empty($highlights)): ?>
                              <h4>Điểm nổi bật</h4>
                              <div class="highlights-grid">
                                <?php foreach ($highlights as $hl): ?>
                                    <div class="highlight-card">
                                      <i class="bi bi-star"></i>
                                      <h5><?= htmlspecialchars($hl['title']) ?></h5>
                                      <p><?= htmlspecialchars($hl['content']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                              </div>
                          <?php endif; ?>
                        </div>
                      </div>

                      <?php if (!empty($accessories_fixed) || !empty($accessories_others)): ?>
                          <div class="col-lg-4">
                            <div class="package-contents">
                              <h4>Phụ kiện kèm theo</h4>
                              <ul class="contents-list">
                                <?php foreach ($accessories_fixed as $item): ?>
                                    <li><i class="bi bi-check-circle"></i><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                                <?php if ($accessories_others): ?>
                                    <li><i class="bi bi-check-circle"></i><?= htmlspecialchars($accessories_others) ?></li>
                                <?php endif; ?>
                              </ul>
                            </div>
                          </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <!-- Tab Đánh giá (giữ nguyên tĩnh) -->
                <div class="tab-pane fade" id="ecommerce-product-details-5-customer-reviews" style="padding-bottom:0px;">
                  <div class="reviews-content">
                    <div class="reviews-header">
                      <div class="rating-overview">
                        <div class="average-score">
                          <div class="score-display">4.6</div>
                          <div class="score-stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                          </div>
                          <div class="total-reviews">127 Khách hàng đã... mua lại sau khi đập!</div>
                        </div>
                        <div class="rating-distribution">
                          <div class="rating-row"><span class="stars-label">5★</span><div class="progress-container"><div class="progress-fill" style="width:68%"></div></div><span class="count-label">86</span></div>
                          <div class="rating-row"><span class="stars-label">4★</span><div class="progress-container"><div class="progress-fill" style="width:22%"></div></div><span class="count-label">28</span></div>
                          <div class="rating-row"><span class="stars-label">3★</span><div class="progress-container"><div class="progress-fill" style="width:6%"></div></div><span class="count-label">8</span></div>
                          <div class="rating-row"><span class="stars-label">2★</span><div class="progress-container"><div class="progress-fill" style="width:3%"></div></div><span class="count-label">4</span></div>
                          <div class="rating-row"><span class="stars-label">1★</span><div class="progress-container"><div class="progress-fill" style="width:1%"></div></div><span class="count-label">1</span></div>
                        </div>
                      </div>
                      <div class="write-review-cta">
                        <h4>Chia sẻ kinh nghiệm... phá hoại của bạn</h4>
                        <p>Khoe chiến tích và tăng doanh số cho chúng tôi</p>
                      </div>
                    </div>

                    <div class="customer-reviews-list" id="top-comment">
                      <div class="review-card">
                        <div class="reviewer-profile">
                          <img src="assets/img/person/namperfect.jpg" alt="Khách hàng" class="profile-pic" />
                          <div class="profile-details">
                            <div class="customer-name">Nam Vui Tính (Đã đập 3 cây)</div>
                            <div class="review-meta">
                              <div class="review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                              <span class="review-date">Đập vỡ lần cuối: 28/03/2024</span>
                            </div>
                          </div>
                        </div>
                        <h5 class="review-headline">Quá bền! Nhưng tôi đã thành công mua cây thứ 4.</h5>
                        <div class="review-text"><p>Tôi đã phải dùng búa tạ mới làm nó bung ra được. Gỗ Full Solid gì mà dai dẳng quá! Cây đàn này là một thách thức lớn. Nhưng sau khi đập, tôi thấy nhẹ nhõm và đã đặt mua ngay cây mới!</p></div>
                        <div class="review-actions">
                          <button class="action-btn"><i class="bi bi-hand-thumbs-up"></i> Chiến thắng (12)</button>
                          <button class="action-btn"><i class="bi bi-chat-dots"></i> Đặt mua tiếp</button>
                        </div>
                      </div>

                      <div class="review-card">
                        <div class="reviewer-profile">
                          <img src="assets/img/person/mckhutthuocbangchan.jpeg" alt="Khách hàng" class="profile-pic" />
                          <div class="profile-details">
                            <div class="customer-name">Nger Không Nân (Chơi hệ Lo-Fi)</div>
                            <div class="review-meta">
                              <div class="review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i></div>
                              <span class="review-date">Ngày 15 tháng 3, 2024</span>
                            </div>
                          </div>
                        </div>
                        <h5 class="review-headline">Đàn quá mới, không có vết xước Lo-Fi nào hết. Tệ!</h5>
                        <div class="review-text"><p>Tôi muốn cây đàn có chất âm mộc mạc, hơi rè rè. Nhưng cây này quá hoàn hảo! Tôi phải tự tay tạo ra vài vết nứt để đạt được chất Lo-Fi mong muốn. Vẫn cho 4 sao vì âm thanh cơ bản quá tốt!</p></div>
                        <div class="review-actions">
                          <button class="action-btn"><i class="bi bi-hand-thumbs-up"></i> Có cảm hứng đập (8)</button>
                          <button class="action-btn"><i class="bi bi-chat-dots"></i> Yêu cầu đổi đàn cũ</button>
                        </div>
                      </div>

                      <div class="review-card">
                        <div class="reviewer-profile">
                          <img src="assets/img/person/mckvacayphonglon.jpg" alt="Khách hàng" class="profile-pic" />
                          <div class="profile-details">
                            <div class="customer-name">Em Suy Kay Không Linh (Chiến binh DE1 Pro)</div>
                            <div class="review-meta">
                              <div class="review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                              <span class="review-date">Ngày 22 tháng 2, 2024</span>
                            </div>
                          </div>
                        </div>
                        <h5 class="review-headline">Mới mua 2 tuần, đã thành công làm vỡ một góc cần đàn!</h5>
                        <div class="review-text"><p>Mục tiêu của tôi đã hoàn thành! Cảm ơn đã cho tôi cảm giác cần đàn chắc chắn trước khi tôi làm gãy nó. Rất tuyệt vời!</p></div>
                        <div class="review-actions">
                          <button class="action-btn"><i class="bi bi-hand-thumbs-up"></i> Hữu ích (15)</button>
                          <button class="action-btn"><i class="bi bi-chat-dots"></i> Trả lời và đặt hàng mới</button>
                        </div>
                      </div>

                      <section id="category-pagination" class="category-pagination section" style="padding-bottom:0px;">
                        <div class="container">
                          <nav class="d-flex justify-content-center" aria-label="Page navigation">
                            <ul>
                              <li><a href="#top-comment"><i class="bi bi-arrow-left"></i><span class="d-none d-sm-inline">Trước</span></a></li>
                              <li><a href="#top-comment" class="active">1</a></li>
                              <li><a href="#top-comment">2</a></li>
                              <li><a href="#top-comment">3</a></li>
                              <li class="ellipsis">...</li>
                              <li><a href="#top-comment">8</a></li>
                              <li><a href="#top-comment" aria-label="Next page"><span class="d-none d-sm-inline">Sau</span><i class="bi bi-arrow-right"></i></a></li>
                            </ul>
                          </nav>
                        </div>
                      </section>
                    </div>
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
  <script src="assets/js/products.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const addToCartBtn = document.getElementById('add-to-cart-btn');
      if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function (e) {
          e.preventDefault();
          <?php if (!empty($_SESSION['user'])): ?>
              const productName = this.getAttribute('data-product-name');
              Toast.fire({ icon: 'success', title: 'Đã thêm ' + productName + ' vào giỏ!' });
          <?php else: ?>
              Toast.fire({ icon: 'warning', title: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ!' })
                .then(() => { window.location.href = 'login.php'; });
          <?php endif; ?>
        });
      }
    });
  </script>
</body>
</html>