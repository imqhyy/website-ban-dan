<?php
require_once 'forms/init.php';

// ============================================================
// REVIEW DATA LAYER
// ============================================================
$reviewFilter = $_GET['review_filter'] ?? 'all';
$reviewConditions = ["r.product_id = ?", "r.status = 'visible'"];
$reviewParams = [$_GET['id'] ?? 0];

if ($reviewFilter === 'image') {
  $reviewConditions[] = "r.image_path IS NOT NULL";
} elseif ($reviewFilter === 'purchased') {
  $reviewConditions[] = "r.is_purchased = 1";
} elseif (in_array($reviewFilter, ['1', '2', '3', '4', '5'])) {
  $reviewConditions[] = "r.rating = ?";
  $reviewParams[] = (int) $reviewFilter;
}
$reviewWhere = implode(' AND ', $reviewConditions);

$userLoggedIn = !empty($_SESSION['user']);
$currentUserId = $_SESSION['user']['id'] ?? 0;
$alreadyReviewed = false;
if ($userLoggedIn) {
  $alreadyReviewed = (bool) getOne("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?", [$_GET['id'] ?? 0, $currentUserId]);
}

// Lấy id từ URL, validate
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
  header('Location: all.php');
  exit();
}

// Query sản phẩm + tên brand + tên category với điều kiện hiển thị
$stmt = $pdo->prepare("
    SELECT p.*, b.brand_name, b.brand_slug, c.category_name
    FROM products p
    JOIN brands b ON p.brand_id = b.id
    JOIN categories c ON p.category_id = c.id
    WHERE p.id = ? 
      AND p.status = 'visible' 
      AND b.status = 'visible' 
      AND c.status = 'visible'
");
$stmt->execute([$id]);
$product = $stmt->fetch();

// Nếu không tìm thấy hoặc bất kỳ cấp nào bị ẩn, sản phẩm sẽ không được truy vấn ra
if (!$product) {
  header('Location: all.php');
  exit();
}

// Tạo đường dẫn ảnh theo đúng công thức của all.php
$type_folder = create_slug($product['category_name']);
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
$original_price = ($discount > 0) ? $selling_price : null;
$selling_price = ($discount > 0) ? ($selling_price * (1 - $discount / 100)) : $selling_price;
$save_amount = $original_price ? ($original_price - $selling_price) : 0;

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

// Lấy danh sách review có lọc
$reviews = getAll("SELECT r.*, u.fullname, u.avatar FROM reviews r
    LEFT JOIN users u ON r.user_id = u.id
    WHERE {$reviewWhere}
    ORDER BY r.created_at DESC", $reviewParams);

// Thống kê review
$reviewStats = getOne("SELECT COUNT(*) as total,
    ROUND(AVG(rating),1) as avg_rating,
    SUM(CASE WHEN image_path IS NOT NULL THEN 1 ELSE 0 END) as has_image,
    SUM(CASE WHEN is_purchased=1 THEN 1 ELSE 0 END) as purchased_count,
    SUM(CASE WHEN rating=5 THEN 1 ELSE 0 END) as r5,
    SUM(CASE WHEN rating=4 THEN 1 ELSE 0 END) as r4,
    SUM(CASE WHEN rating=3 THEN 1 ELSE 0 END) as r3,
    SUM(CASE WHEN rating=2 THEN 1 ELSE 0 END) as r2,
    SUM(CASE WHEN rating=1 THEN 1 ELSE 0 END) as r1
    FROM reviews WHERE product_id = ? AND status = 'visible'", [$product['id']]);

$totalReviews = (int) ($reviewStats['total'] ?? 0);
$avgRating = (float) ($reviewStats['avg_rating'] ?? 0);

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
                  <img src="<?= $main_img ?>" alt="<?= htmlspecialchars($product['product_name']) ?>"
                    class="img-fluid main-product-image drift-zoom" id="main-product-image"
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
                    <img src="<?= $base_path . $img ?>" alt="View <?= $i + 1 ?>" class="img-fluid" />
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
            <div class="product-details">
              <div class="product-badge-container">
                <span class="badge-category"><?= htmlspecialchars($product['category_name']) ?></span>
                <div class="rating-group">
                  <div class="stars">
                    <?php
                    $full = floor($avgRating);
                    $half = ($avgRating - $full) >= 0.5 ? 1 : 0;
                    $empty = 5 - $full - $half;
                    for ($s = 0; $s < $full; $s++)
                      echo '<i class="bi bi-star-fill"></i>';
                    if ($half)
                      echo '<i class="bi bi-star-half"></i>';
                    for ($s = 0; $s < $empty; $s++)
                      echo '<i class="bi bi-star"></i>';
                    ?>
                  </div>
                  <span class="review-text">(<?= $totalReviews ?> đánh giá)</span>
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
                  <button class="btn primary-action" id="add-to-cart-btn" data-product-id="<?= $product['id'] ?>"
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
                <div class="benefit-item"><i class="bi bi-truck"></i><span>Free ship cho đơn từ 1 triệu đồng</span>
                </div>
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
                  Đánh giá (<?= $totalReviews ?>)
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

                <!-- Tab Đánh giá - DYNAMIC -->
                <div class="tab-pane fade" id="ecommerce-product-details-5-customer-reviews"
                  style="padding-bottom:0px;">
                  <div class="reviews-content">

                    <!-- Tổng quan điểm -->
                    <div class="reviews-header">
                      <div class="rating-overview">
                        <div class="average-score">
                          <div class="score-display"><?= $totalReviews > 0 ? $avgRating : '—' ?></div>
                          <div class="score-stars">
                            <?php
                            $f = floor($avgRating);
                            $h = ($avgRating - $f) >= 0.5 ? 1 : 0;
                            $e = 5 - $f - $h;
                            for ($s = 0; $s < $f; $s++)
                              echo '<i class="bi bi-star-fill"></i>';
                            if ($h)
                              echo '<i class="bi bi-star-half"></i>';
                            for ($s = 0; $s < $e; $s++)
                              echo '<i class="bi bi-star"></i>';
                            ?>
                          </div>
                          <div class="total-reviews"><?= $totalReviews ?> đánh giá</div>
                        </div>
                        <div class="rating-distribution">
                          <?php foreach ([5, 4, 3, 2, 1] as $star):
                            $cnt = (int) ($reviewStats["r{$star}"] ?? 0);
                            $pct = $totalReviews > 0 ? round($cnt / $totalReviews * 100) : 0;
                            ?>
                            <div class="rating-row">
                              <span class="stars-label"><?= $star ?>★</span>
                              <div class="progress-container">
                                <div class="progress-fill" style="width:<?= $pct ?>%"></div>
                              </div>
                              <span class="count-label"><?= $cnt ?></span>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>

                    <!-- 8 bộ lọc -->
                    <div class="review-filters" style="display:flex;gap:8px;flex-wrap:wrap;margin:20px 0;">
                      <?php
                      $filters = [
                        'all' => 'Tất cả (' . $totalReviews . ')',
                        'image' => 'Có hình ảnh (' . ($reviewStats['has_image'] ?? 0) . ')',
                        'purchased' => 'Đã mua hàng (' . ($reviewStats['purchased_count'] ?? 0) . ')',
                        '5' => '5★ (' . ($reviewStats['r5'] ?? 0) . ')',
                        '4' => '4★ (' . ($reviewStats['r4'] ?? 0) . ')',
                        '3' => '3★ (' . ($reviewStats['r3'] ?? 0) . ')',
                        '2' => '2★ (' . ($reviewStats['r2'] ?? 0) . ')',
                        '1' => '1★ (' . ($reviewStats['r1'] ?? 0) . ')',
                      ];
                      foreach ($filters as $key => $label):
                        $active = ($reviewFilter === $key) ? 'background:#111827;color:#fff;' : 'background:#f3f4f6;color:#374151;';
                        ?>
                        <button type="button" class="review-filter-btn" data-filter="<?= $key ?>"
                          style="<?= $active ?>padding:6px 14px;border-radius:20px;font-size:13px;border:1px solid #E5E7EB;cursor:pointer; transition: 0.2s;"><?= $label ?></button>
                      <?php endforeach; ?>
                    </div>

                    <!-- Danh sách review -->
                    <div class="customer-reviews-list" id="top-comment">
                      <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $rv): ?>
                          <div class="review-card" style="border-bottom:1px solid #f3f4f6;">
                            <div class="reviewer-profile">
                              <?php
                              $avt = !empty($rv['avatar']) ? $rv['avatar'] : 'assets/img/default-avatar.jpg';
                              ?>
                              <img src="<?= htmlspecialchars($avt) ?>" alt="Avatar" class="profile-pic"
                                style="width:46px;height:46px;border-radius:50%;object-fit:cover;" />
                              <div class="profile-details">
                                <div class="customer-name" style="font-weight:600;">
                                  <?= htmlspecialchars($rv['fullname'] ?? 'Ẩn danh') ?>
                                  <?php if ($rv['is_purchased']): ?><span
                                      style="font-size:11px;background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:10px;margin-left:6px;">Đã
                                      mua</span><?php endif; ?>
                                </div>
                                <div class="review-meta" style="display:flex;align-items:center;gap:10px;margin-top:4px;">
                                  <div class="review-stars">
                                    <?php for ($s = 1; $s <= 5; $s++)
                                      echo $s <= $rv['rating'] ? '<i class="bi bi-star-fill" style="color:#FBBF24;"></i>' : '<i class="bi bi-star" style="color:#D1D5DB;"></i>'; ?>
                                  </div>
                                  <span class="review-date"
                                    style="font-size:12px;color:#9ca3af;"><?= date('d/m/Y', strtotime($rv['created_at'])) ?></span>
                                </div>
                              </div>
                            </div>
                            <div class="review-text" style="margin-top:12px;color:#374151;">
                              <p><?= nl2br(htmlspecialchars($rv['comment'])) ?></p>
                            </div>
                            <?php if (!empty($rv['image_path'])): ?>
                              <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;">
                                <?php foreach (explode(',', $rv['image_path']) as $imgPath):
                                  $imgPath = trim($imgPath);
                                  if (!$imgPath)
                                    continue; ?>
                                  <img src="<?= htmlspecialchars($imgPath) ?>" alt="Review image"
                                    style="width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #E5E7EB;cursor:pointer;"
                                    onclick="window.open(this.src,'_blank')">
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>
                            <!-- Sub-ratings -->
                            <div style="display:flex;gap:20px;margin-top:10px;font-size:13px;color:#6b7280;">
                              <span>Âm thanh: <?php for ($s = 1; $s <= 5; $s++)
                                echo $s <= $rv['sound_rating'] ? '★' : '☆'; ?></span>
                              <span>Cấu hình: <?php for ($s = 1; $s <= 5; $s++)
                                echo $s <= $rv['specs_rating'] ? '★' : '☆'; ?></span>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <p style="text-align:center;color:#9ca3af;padding:40px 0;">Chưa có đánh giá nào. Hãy là người đầu
                          tiên!</p>
                      <?php endif; ?>
                    </div>

                    <!-- Form viết review -->
                    <div class="write-review-section"
                      style="margin-top:30px;border-top:1px solid #E5E7EB;padding-top:24px;">
                      <?php if (!$userLoggedIn): ?>
                        <div style="text-align:center;padding:20px;">
                          <p style="color:#6b7280;margin-bottom:12px;">Đăng nhập để chia sẻ đánh giá của bạn</p>
                          <a href="login.php" class="btn primary-action" style="display:inline-block;">Đăng nhập ngay</a>
                        </div>
                      <?php elseif ($alreadyReviewed): ?>
                        <p style="text-align:center;color:#16a34a;padding:20px;"><i class="bi bi-check-circle-fill"></i>
                          Bạn đã đánh giá sản phẩm này rồi!</p>
                      <?php else: ?>
                        <h4 style="font-weight:700;color:#111827;margin-bottom:20px;">Viết đánh giá của bạn</h4>
                        <form id="review-form" enctype="multipart/form-data">
                          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                          <!-- Phần 1: Đánh giá chung -->
                          <div style="margin-bottom:20px;">
                            <p style="font-weight:700;color:#111827;margin-bottom:12px;">Đánh giá chung</p>
                            <div class="star-group" id="star-general" style="display:flex;gap:16px;">
                              <?php foreach ([1 => 'Rất Tệ', 2 => 'Tệ', 3 => 'Bình thường', 4 => 'Tốt', 5 => 'Tuyệt vời'] as $v => $lbl): ?>
                                <div style="text-align:center;cursor:pointer;" class="star-item" data-group="rating"
                                  data-value="<?= $v ?>">
                                  <i class="bi bi-star-fill" style="font-size:28px;color:#FBBF24;"></i>
                                  <div style="font-size:12px;color:#4B5563;margin-top:4px;"><?= $lbl ?></div>
                                </div>
                              <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="5">
                          </div>

                          <!-- Phần 2: Theo trải nghiệm -->
                          <div style="border-top:1px solid #E5E7EB;padding-top:20px;margin-bottom:20px;">
                            <p style="font-weight:700;color:#111827;margin-bottom:16px;">Theo trải nghiệm</p>

                            <!-- Âm thanh -->
                            <div
                              style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                              <span style="color:#4B5563;min-width:100px;">Âm thanh</span>
                              <div class="star-group" id="star-sound" style="display:flex;gap:8px;">
                                <?php for ($v = 1; $v <= 5; $v++): ?>
                                  <i class="bi bi-star-fill star-sub" style="font-size:20px;color:#FBBF24;cursor:pointer;"
                                    data-group="sound" data-value="<?= $v ?>"></i>
                                <?php endfor; ?>
                              </div>
                              <span id="sound-label"
                                style="color:#4B5563;min-width:90px;text-align:right;font-size:13px;">Tuyệt phẩm</span>
                            </div>
                            <input type="hidden" name="sound_rating" id="sound-input" value="5">

                            <!-- Cấu hình đàn -->
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                              <span style="color:#4B5563;min-width:100px;">Cấu hình đàn</span>
                              <div class="star-group" id="star-specs" style="display:flex;gap:8px;">
                                <?php for ($v = 1; $v <= 5; $v++): ?>
                                  <i class="bi bi-star-fill star-sub" style="font-size:20px;color:#FBBF24;cursor:pointer;"
                                    data-group="specs" data-value="<?= $v ?>"></i>
                                <?php endfor; ?>
                              </div>
                              <span id="specs-label"
                                style="color:#4B5563;min-width:90px;text-align:right;font-size:13px;">Hoàn hảo</span>
                            </div>
                            <input type="hidden" name="specs_rating" id="specs-input" value="5">
                          </div>

                          <!-- Phần 3: Textarea + ảnh -->
                          <div style="border-top:1px solid #E5E7EB;padding-top:20px;">
                            <textarea name="comment" id="review-comment" rows="4"
                              placeholder="Xin mời chia sẻ một số cảm nhận về sản phẩm (nhập tối thiểu 15 kí tự)"
                              style="width:100%;padding:12px;border:1px solid #D1D5DB;border-radius:8px;font-family:inherit;resize:vertical;"></textarea>

                            <!-- Multi-image row -->
                            <div id="review-images-row"
                              style="display:flex;flex-wrap:wrap;gap:10px;margin-top:12px;align-items:center;">
                              <!-- Thumbnails sẽ được JS thêm vào đây -->
                              <label id="review-add-img-btn"
                                style="cursor:pointer;color:#6b7280;font-size:13px;border:1px dashed #D1D5DB;padding:8px 14px;border-radius:8px;display:flex;align-items:center;gap:6px;white-space:nowrap;">
                                <i class="bi bi-image"></i> Thêm ảnh
                                <input type="file" id="review-image-input" accept="image/*" style="display:none;">
                              </label>
                            </div>

                            <div style="display:flex;justify-content:flex-end;margin-top:12px;">
                              <button type="submit" class="btn primary-action">Gửi đánh giá</button>
                            </div>
                          </div>
                        </form>
                      <?php endif; ?>
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

      // ===== LABELS =====
      var labels = {
        sound: { 1: 'Rất tệ', 2: 'Tệ', 3: 'Tạm ổn', 4: 'Hay', 5: 'Tuyệt phẩm' },
        specs: { 1: 'Rất kém', 2: 'Kém', 3: 'Bình thường', 4: 'Cao cấp', 5: 'Hoàn hảo' }
      };
      var generalLabels = { 1: 'Rất Tệ', 2: 'Tệ', 3: 'Bình thường', 4: 'Tốt', 5: 'Tuyệt vời' };

      // ===== HELPER: set color dùng setAttribute để không bị CSS override =====
      function setColor(el, color) {
        var current = el.getAttribute('style') || '';
        // Xoá color cũ nếu có, thêm mới
        current = current.replace(/color\s*:[^;]+;?/gi, '').trim();
        el.setAttribute('style', current + ';color:' + color + ';');
      }

      // ===== GENERAL STARS =====
      var genContainer = document.getElementById('star-general');
      var genItems = Array.from(document.querySelectorAll('#star-general .star-item'));
      var ratingInput = document.getElementById('rating-input');

      console.log('[Review] genItems:', genItems.length, 'ratingInput:', !!ratingInput);

      if (genItems.length && ratingInput) {
        var curGeneral = 5;

        function paintGeneral(n) {
          genItems.forEach(function (item) {
            var icon = item.querySelector('i');
            if (icon) setColor(icon, parseInt(item.dataset.value) <= n ? '#FBBF24' : '#D1D5DB');
          });
        }

        paintGeneral(5);

        genItems.forEach(function (item) {
          item.addEventListener('mouseover', function () {
            var v = parseInt(item.dataset.value);
            console.log('[Review] hover general', v);
            paintGeneral(v);
          });
          item.addEventListener('click', function () {
            curGeneral = parseInt(item.dataset.value);
            ratingInput.value = curGeneral;
            paintGeneral(curGeneral);
            console.log('[Review] click general', curGeneral);
          });
        });

        if (genContainer) {
          genContainer.addEventListener('mouseleave', function () {
            paintGeneral(curGeneral);
          });
        }
      }

      // ===== SUB STARS (Sound + Specs) =====
      ['sound', 'specs'].forEach(function (group) {
        var container = document.getElementById('star-' + group);
        var stars = Array.from(document.querySelectorAll('#star-' + group + ' .star-sub'));
        var input = document.getElementById(group + '-input');
        var label = document.getElementById(group + '-label');
        var curSub = 5;

        console.log('[Review] ' + group + ' stars:', stars.length);

        if (!stars.length || !input) return;

        function paintSub(n) {
          stars.forEach(function (star) {
            setColor(star, parseInt(star.dataset.value) <= n ? '#FBBF24' : '#D1D5DB');
          });
          if (label) label.textContent = labels[group][n] || '';
          input.value = n;
        }

        paintSub(5);

        stars.forEach(function (star) {
          star.addEventListener('mouseover', function () {
            paintSub(parseInt(star.dataset.value));
          });
          star.addEventListener('click', function () {
            curSub = parseInt(star.dataset.value);
            paintSub(curSub);
          });
        });

        if (container) {
          container.addEventListener('mouseleave', function () {
            paintSub(curSub);
          });
        }
      });

    }); // end DOMContentLoaded



    // ======== Submit Review Form ========
    document.addEventListener('DOMContentLoaded', function () {
      const reviewForm = document.getElementById('review-form');
      if (!reviewForm) return;

      // ===== Multi-image Upload (tối đa 3 ảnh) =====
      const imagesRow = document.getElementById('review-images-row');
      const addImgBtn = document.getElementById('review-add-img-btn');
      const imageInput = document.getElementById('review-image-input');
      const MAX_IMAGES = 3;
      var selectedFiles = []; // lưu File objects

      if (imageInput && addImgBtn) {
        imageInput.addEventListener('change', function () {
          var file = this.files[0];
          if (!file || selectedFiles.length >= MAX_IMAGES) return;

          selectedFiles.push(file);
          this.value = ''; // reset để cho phép chọn lại file giống nhau

          // Tạo thumbnail
          var idx = selectedFiles.length - 1;
          var reader = new FileReader();
          reader.onload = function (e) {
            var thumb = document.createElement('div');
            thumb.style.cssText = 'position:relative;display:inline-block;';
            thumb.dataset.idx = idx;

            var img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #E5E7EB;display:block;';

            var rmBtn = document.createElement('button');
            rmBtn.type = 'button';
            rmBtn.textContent = '×';
            rmBtn.style.cssText = 'position:absolute;top:-8px;right:-8px;background:#ef4444;color:white;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:13px;line-height:1;';
            rmBtn.addEventListener('click', function () {
              selectedFiles.splice(parseInt(thumb.dataset.idx), 1);
              // cập nhật lại data-idx cho các thumb còn lại
              var thumbs = imagesRow.querySelectorAll('[data-idx]');
              thumbs.forEach(function (t, i) { t.dataset.idx = i; });
              thumb.remove();
              // hiện lại nút thêm ảnh nếu < 3
              if (selectedFiles.length < MAX_IMAGES) addImgBtn.style.display = '';
            });

            thumb.appendChild(img);
            thumb.appendChild(rmBtn);
            // chèn trước nút add
            imagesRow.insertBefore(thumb, addImgBtn);

            // ẩn nút nếu đã đủ 3
            if (selectedFiles.length >= MAX_IMAGES) {
              addImgBtn.style.display = 'none';
            }
          };
          reader.readAsDataURL(file);
        });
      }

      // ===== Submit Review =====
      var isSubmitting = false;
      reviewForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (isSubmitting) return;
        var comment = document.getElementById('review-comment').value.trim();
        if (comment.length < 15) {
          Toast.fire({ icon: 'warning', title: 'Cảm nhận phải có tối thiểu 15 ký tự!' });
          return;
        }
        var btn = reviewForm.querySelector('button[type=submit]');
        btn.disabled = true; btn.textContent = 'Đang gửi...';
        isSubmitting = true;

        var fd = new FormData(reviewForm);
        // Thêm ảnh thủ công (vì input[type=file] đã bị reset để cho chọn lại)
        selectedFiles.forEach(function (file) {
          fd.append('images[]', file);
        });

        fetch('forms/ajax/ajax_review.php', { method: 'POST', body: fd })
          .then(function (r) {
            return r.text(); // đọc text trước để debug
          })
          .then(function (text) {
            console.log('[Review submit raw]', text);
            var data = JSON.parse(text);
            if (data.status === 'success') {
              Toast.fire({ icon: 'success', title: data.message });
              setTimeout(function () { location.reload(); }, 1500);
            } else {
              Toast.fire({ icon: 'error', title: data.message });
              btn.disabled = false; btn.textContent = 'Gửi đánh giá';
            }
          })
          .catch(function (err) {
            console.error('[Review submit error]', err);
            Toast.fire({ icon: 'error', title: 'Lỗi: ' + err.message });
            btn.disabled = false; btn.textContent = 'Gửi đánh giá';
            isSubmitting = false;
          });
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const addToCartBtn = document.getElementById('add-to-cart-btn');

      if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function (e) {
          e.preventDefault();

          <?php if (!empty($_SESSION['user'])): ?>
            // 1. Lấy thông tin sản phẩm và số lượng
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const quantityInput = document.getElementById('quantity-input');
            let quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            if (quantity < 1) quantity = 1; // Đề phòng lỗi nhập số âm

            // 2. Đóng gói dữ liệu gửi đi
            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            // 3. Gọi AJAX đến file ajax_cart.php
            fetch('forms/ajax/ajax_cart.php', {
              method: 'POST',
              body: formData
            })
              .then(response => response.json())
              .then(data => {
                if (data.status === 'success') {
                  // Hiện thông báo thành công
                  Toast.fire({
                    icon: 'success',
                    title: 'Đã thêm ' + productName + ' vào giỏ!'
                  });

                  // Cập nhật ngay con số trên icon giỏ hàng ở header
                  if (data.is_new_item) {
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                      let currentCount = parseInt(badge.innerText) || 0;
                      badge.innerText = currentCount + 1;
                    }
                  }
                } else {
                  // Nếu backend báo lỗi (ví dụ hết hàng, v.v.)
                  Toast.fire({
                    icon: 'error',
                    title: data.message
                  });
                }
              })
              .catch(error => {
                console.error('Error:', error);
                Toast.fire({
                  icon: 'error',
                  title: 'Không thể kết nối đến máy chủ!'
                });
              });

          <?php else: ?>
            // Xử lý khi chưa đăng nhập
            Toast.fire({
              icon: 'warning',
              title: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ!'
            })
              .then(() => {
                window.location.href = 'login.php';
              });
          <?php endif; ?>
        });
      }

      // ===== AJAX REVIEW FILTERING =====
      const reviewFilterBtns = document.querySelectorAll('.review-filter-btn');
      const reviewContainer = document.getElementById('top-comment');
      const filterProductId = <?= $product['id'] ?>;

      reviewFilterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          // Update active styling
          reviewFilterBtns.forEach(b => {
            b.style.background = '#f3f4f6';
            b.style.color = '#374151';
          });
          this.style.background = '#111827';
          this.style.color = '#fff';

          const filterVal = this.dataset.filter;
          reviewContainer.innerHTML = '<p style="text-align:center;padding:40px 0; color:#6b7280;"><i class="bi bi-arrow-repeat spin"></i> Đang tải dữ liệu...</p>';

          const formData = new FormData();
          formData.append('product_id', filterProductId);
          formData.append('review_filter', filterVal);

          fetch('forms/ajax/ajax_get_reviews.php', {
            method: 'POST',
            body: formData
          })
          .then(res => res.text())
          .then(html => {
            reviewContainer.innerHTML = html;
          })
          .catch(err => {
            console.error('[Review Filter Error]', err);
            reviewContainer.innerHTML = '<p style="text-align:center;color:#ef4444;padding:40px 0;">Đã xảy ra lỗi khi lọc đánh giá. Vui lòng thử lại sau.</p>';
          });
        });
      });

    });
  </script>
</body>

</html>