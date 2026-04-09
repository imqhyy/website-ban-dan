<?php
require_once 'forms/init.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_SESSION['user']]);
$user = $stmt->fetch();
require_once "forms/modules/users/list.php";

// Fetch user reviews
$reviewStmt = $pdo->prepare("
    SELECT r.*, p.product_name, c.category_name, b.brand_name, p.product_images 
    FROM reviews r
    JOIN products p ON r.product_id = p.id
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN brands b ON p.brand_id = b.id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$reviewStmt->execute([$user['id']]);
$userReviews = $reviewStmt->fetchAll();


$title = "Hồ sơ của tôi - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="account-page">
  <?php include 'forms/header.php' ?>
  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Tài khoản</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Tài khoản</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Account Section -->
    <section id="account" class="account section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu d-lg-none mb-4">
          <button class="mobile-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#profileMenu">
            <i class="bi bi-grid"></i>
            <span>Menu</span>
          </button>
        </div>

        <div class="row g-4">
          <!-- Profile Menu -->
          <div class="col-lg-3">
            <div class="profile-menu collapse d-lg-block" id="profileMenu">
              <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <?php
                  $avatarSrc = (!empty($user['avatar'])) ? $user['avatar'] : 'assets/img/person/images.jpg';
                  ?>
                  <img src="<?php echo htmlspecialchars($avatarSrc); ?>" alt="Profile" loading="lazy">
                  <span class="status-badge"><i class="bi bi-shield-check"></i></span>
                </div>
                <h4 id="user-display-name"><?php echo htmlspecialchars($user['fullname']); ?></h4>
                <h6 style="color: rgb(129, 129, 128);">
                  user:<?php echo htmlspecialchars($user['username']); ?></h6>
                <div class="user-status">
                  <i class="bi bi-award"></i>
                  <span>Thành viên phá phách</span>
                </div>
              </div>

              <!-- Navigation Menu -->
              <nav class="menu-nav">
                <ul class="nav flex-column" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#orders">
                      <i class="bi bi-box-seam"></i>
                      <span>Đơn hàng của tôi</span>
                      <span class="badge"><?= $maxData ?></span>
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#wishlist">
                      <i class="bi bi-heart"></i>
                      <span>Danh sách mong muốn</span>
                      <span class="badge">12</span>
                    </a>
                  </li> -->
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#wallet">
                      <i class="bi bi-wallet2"></i>
                      <span>Phương thức thanh toán</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                      <i class="bi bi-star"></i>
                      <span>Đánh giá của tôi</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#addresses">
                      <i class="bi bi-geo-alt"></i>
                      <span>Địa chỉ</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings">
                      <i class="bi bi-gear"></i>
                      <span>Cài đặt</span>
                    </a>
                  </li>
                </ul>

                <div class="menu-footer">
                  <a href="support.php" class="help-link">
                    <i class="bi bi-question-circle"></i>
                    <span>Trung tâm hỗ trợ</span>
                  </a>
                  <a href="#" class="logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Đăng xuất</span>
                  </a>
                </div>
              </nav>
            </div>
          </div>

          <!-- Content Area -->
          <div class="col-lg-9">
            <div class="content-area">
              <div class="tab-content">
                <!-- Orders Tab -->
                <div class="tab-pane fade show active" id="orders">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Đơn hàng của tôi</h2>
                    <div class="header-actions">
                      <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="order-search-input" placeholder="Tìm kiếm đơn hàng..." value="<?= htmlspecialchars($searchFilter) ?>">
                      </div>
                      <div class="dropdown">
                        <button class="filter-btn" data-bs-toggle="dropdown">
                          <i class="bi bi-funnel"></i>
                          <span>Lọc</span>
                        </button>
                        <ul class="dropdown-menu" id="order-filter-menu">
                          <li><a class="dropdown-item <?= ($statusFilter == 'all') ? 'active fw-bold' : '' ?>" href="account.php?status=all">Tất cả</a></li>
                          <li><a class="dropdown-item <?= ($statusFilter == 'newest') ? 'active fw-bold' : '' ?>" href="account.php?status=newest">Mới đặt (Chờ xác nhận)</a></li>
                          <li><a class="dropdown-item <?= ($statusFilter == 'processed') ? 'active fw-bold' : '' ?>" href="account.php?status=processed">Đã xử lý (Đang giao)</a></li>
                          <li><a class="dropdown-item <?= ($statusFilter == 'deliveried') ? 'active fw-bold' : '' ?>" href="account.php?status=deliveried">Đã giao hàng</a></li>
                          <li><a class="dropdown-item <?= ($statusFilter == 'cancel') ? 'active fw-bold' : '' ?>" href="account.php?status=cancel">Đã hủy</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="orders-grid">
                    <?php if (empty($orders)): ?>
                      <div class="text-center p-5 text-muted w-100">
                        <i class="bi bi-box-seam fs-1 d-block mb-3" style="font-size: 3rem;"></i>
                        <p>Bạn chưa có đơn hàng nào.</p>
                        <a href="shop.php" class="btn btn-dark mt-2">Tiếp tục mua sắm</a>
                      </div>
                    <?php else: ?>
                      <?php foreach ($orders as $key => $order): ?>
                        <?php
                        $orderId = $order['id'];
                        $detailStmt = $pdo->prepare("SELECT od.*, p.product_name, p.product_images, c.category_name, b.brand_name 
                                                       FROM order_details od 
                                                       JOIN products p ON od.product_id = p.id 
                                                       LEFT JOIN categories c ON p.category_id = c.id
                                                       LEFT JOIN brands b ON p.brand_id = b.id
                                                       WHERE od.order_id = ?");
                        $detailStmt->execute([$orderId]);
                        $orderDetails = $detailStmt->fetchAll();

                        $statusClass = '';
                        $statusText = '';
                        switch ($order['order_status']) {
                          case 'newest':
                            $statusClass = 'processing';
                            $statusText = 'Chờ xác nhận';
                            break;
                          case 'processed': // Khi Admin chọn "Đã xử lý"
                            $statusClass = 'shipped';  // Đổi màu sang xanh dương/vận chuyển
                            $statusText = 'Đang giao hàng'; // Nhảy thẳng tới nội dung này
                            break;
                          case 'deliveried':
                            $statusClass = 'delivered';
                            $statusText = 'Đã nhận được hàng';
                            break;
                          case 'cancel':
                            $statusClass = 'cancelled';
                            $statusText = 'Đã hủy';
                            break;
                        }
                        $totalQty = 0;
                        foreach ($orderDetails as $dt) {
                          $totalQty += $dt['quantity'];
                        }
                        ?>
                        <div class="order-card" data-status="<?= htmlspecialchars($statusClass) ?>"
                          data-order-code="<?= strtolower(htmlspecialchars($order['order_code'])) ?>" data-aos="fade-up"
                          data-aos-delay="<?= 100 * (($key % 3) + 1) ?>">
                          <div class="order-header">
                            <div class="order-id">
                              <span class="label">Mã đơn hàng:</span>
                              <span class="value">#<?= htmlspecialchars($order['order_code']) ?></span>
                            </div>
                            <div class="order-date">
                              <?= date('d/m/Y - h:i A', strtotime($order['created_at'])) ?>
                            </div>
                          </div>
                          <div class="order-content">
                            <div class="product-grid">
                              <?php foreach (array_slice($orderDetails, 0, 3) as $dt):
                                $images = !empty($dt['product_images']) ? explode(',', $dt['product_images']) : [];
                                $imgSrc = 'assets/img/default-1.jpg';
                                if (!empty($images[0]) && isset($guitarimg_direct)) {
                                  $imgSrc = $guitarimg_direct . create_slug($dt['category_name']) . '/' . create_slug($dt['brand_name']) . '/' . create_slug($dt['product_name']) . '/' . trim($images[0]);
                                }
                              ?>
                                <a href="product-details.php?id=<?= $dt['product_id'] ?>">
                                  <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Product" loading="lazy">
                                </a>
                              <?php endforeach; ?>
                              <?php if (count($orderDetails) > 3): ?>
                                <span class="more-items">+<?= count($orderDetails) - 3 ?></span>
                              <?php endif; ?>
                            </div>
                            <div class="order-info">
                              <div class="info-row">
                                <span>Tình trạng:</span>
                                <span class="status <?= $statusClass ?>"><?= $statusText ?></span>
                              </div>
                              <div class="info-row">
                                <span>SL:</span>
                                <span><?= $totalQty ?></span>
                              </div>
                              <div class="info-row">
                                <span>Tổng:</span>
                                <span class="price"><?= number_format($order['total_amount'], 0, ',', '.') ?>
                                  VND</span>
                              </div>
                            </div>
                          </div>
                          <div class="order-footer">
                            <?php if ($order['order_status'] == 'completed'): ?>
                              <button type="button" class="btn-review" data-bs-toggle="collapse"
                                data-bs-target="#review_<?= $orderId ?>">Viết đánh giá</button>
                            <?php endif; ?>
                            <?php if ($order['order_status'] != 'canceled' && $order['order_status'] != 'completed'): ?>
                              <button type="button" class="btn-track" data-bs-toggle="collapse"
                                data-bs-target="#tracking_<?= $orderId ?>">Theo dõi đơn
                                hàng</button>
                            <?php endif; ?>
                            <button type="button" class="btn-details" data-bs-toggle="collapse"
                              data-bs-target="#details_<?= $orderId ?>">Xem chi tiết</button>
                          </div>

                          <?php if ($order['order_status'] != 'canceled' && $order['order_status'] != 'completed'): ?>
                            <div class="collapse tracking-info" id="tracking_<?= $orderId ?>">
                              <div class="tracking-timeline">
                                <div class="timeline-item completed">
                                  <div class="timeline-icon"><i class="bi bi-cart-check-fill"></i></div>
                                  <div class="timeline-content">
                                    <h5>Đã đặt đơn hàng</h5>
                                    <span
                                      class="timeline-date"><?= date('d/m/Y - h:i A', strtotime($order['created_at'])) ?></span>
                                  </div>
                                </div>

                                <div
                                  class="timeline-item <?= in_array($order['order_status'], ['processed', 'deliveried']) ? 'completed' : 'active' ?>">
                                  <div class="timeline-icon"><i class="bi bi-check-circle-fill"></i></div>
                                  <div class="timeline-content">
                                    <h5>
                                      <?= ($order['order_status'] == 'newest') ? 'Chờ xác nhận đơn hàng' : 'Đã xác nhận đơn hàng' ?>
                                    </h5>

                                    <?php if ($order['order_status'] !== 'newest'): ?>
                                      <span class="timeline-date">Đã xử lý lúc
                                        <?= date('d/m/Y', strtotime($order['updated_at'])) ?></span>
                                    <?php endif; ?>
                                  </div>
                                </div>

                                <div class="timeline-item <?php
                                                          if (in_array($order['order_status'], ['processed', 'deliveried']))
                                                            echo 'completed';
                                                          elseif ($order['order_status'] == 'cancel')
                                                            echo 'cancelled'; // Thêm class cancelled để hiện màu đỏ
                                                          ?>">
                                  <div class="timeline-icon">
                                    <i
                                      class="bi <?= ($order['order_status'] == 'cancel') ? 'bi-x-circle-fill' : 'bi-truck' ?>"></i>
                                  </div>
                                  <div class="timeline-content">
                                    <h5>
                                      <?php
                                      if ($order['order_status'] == 'cancel')
                                        echo 'Đã hủy đơn hàng';
                                      elseif ($order['order_status'] == 'deliveried')
                                        echo 'Giao hàng thành công';
                                      else
                                        echo 'Đang vận chuyển';
                                      ?>
                                    </h5>

                                    <?php if ($order['order_status'] == 'cancel'): ?>
                                      <span class="timeline-date">Đã hủy lúc
                                        <?= date('d/m/Y - h:i A', strtotime($order['updated_at'])) ?></span>
                                    <?php elseif (in_array($order['order_status'], ['processed', 'deliveried'])): ?>
                                      <span class="timeline-date">Cập nhật lúc:
                                        <?= date('d/m/Y', strtotime($order['updated_at'])) ?></span>
                                    <?php endif; ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php endif; ?>

                          <?php if ($order['order_status'] == 'completed'): ?>
                            <div class="collapse order-details" id="review_<?= $orderId ?>">
                              <div class="details-content">
                                <div class="detail-section">
                                  <h3>Đánh giá sản phẩm</h3>
                                  <?php foreach ($orderDetails as $dt):
                                    $images = !empty($dt['product_images']) ? explode(',', $dt['product_images']) : [];
                                    $imgSrc = 'assets/img/default-1.jpg';
                                    if (!empty($images[0]) && isset($guitarimg_direct)) {
                                      $imgSrc = $guitarimg_direct . create_slug($dt['category_name']) . '/' . create_slug($dt['brand_name']) . '/' . create_slug($dt['product_name']) . '/' . trim($images[0]);
                                    }
                                  ?>
                                    <div class="review-product-item mb-4 pb-4 border-bottom">
                                      <div class="d-flex align-items-center mb-3">
                                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Product" loading="lazy"
                                          class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="product-details">
                                          <h6 class="mb-1 fw-bold">
                                            <?= htmlspecialchars($dt['product_name']) ?>
                                          </h6>
                                          <span class="text-muted small">SL:
                                            <?= $dt['quantity'] ?></span>
                                        </div>
                                      </div>
                                      <div class="review-rating mb-3">
                                        <label class="form-label fw-semibold">Chất lượng sản
                                          phẩm:</label>
                                        <div class="star-rating-selector" data-product-id="<?= $dt['product_id'] ?>">
                                          <i class="bi bi-star star-icon" data-value="1"></i><i class="bi bi-star star-icon"
                                            data-value="2"></i>
                                          <i class="bi bi-star star-icon" data-value="3"></i><i class="bi bi-star star-icon"
                                            data-value="4"></i>
                                          <i class="bi bi-star star-icon" data-value="5"></i>
                                          <span class="rating-text ms-2 small text-muted"></span>
                                          <input type="hidden" name="rating_prd_<?= $dt['product_id'] ?>" value="0"
                                            class="rating-input">
                                        </div>
                                      </div>
                                      <div class="mb-3">
                                        <textarea class="form-control" rows="3"
                                          placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."></textarea>
                                      </div>
                                      <button type="button" class="btn btn-sm btn-primary review-submit-btn"
                                        onclick="Swal.fire('Thành công', 'Cảm ơn đánh giá của bạn!', 'success')">Gửi
                                        đánh giá</button>
                                    </div>
                                  <?php endforeach; ?>
                                </div>
                              </div>
                            </div>
                          <?php endif; ?>

                          <div class="collapse order-details" id="details_<?= $orderId ?>">
                            <div class="details-content">
                              <div class="detail-section">
                                <h5>Thông tin đặt hàng</h5>
                                <div class="info-grid">
                                  <div class="info-item">
                                    <span class="label">Phương thức thanh toán</span>
                                    <span class="value"><?= htmlspecialchars($order['payment_method']) ?></span>
                                  </div>
                                  <div class="info-item">
                                    <span class="label">Thông tin liên hệ</span>
                                    <span
                                      class="value"><?= htmlspecialchars($order['customer_name'] . ' - ' . $order['phone']) ?></span>
                                  </div>
                                </div>
                              </div>

                              <div class="detail-section">
                                <h5>Mặt hàng (<?= count($orderDetails) ?>)</h5>
                                <div class="order-items">
                                  <?php foreach ($orderDetails as $dt):
                                    $images = !empty($dt['product_images']) ? explode(',', $dt['product_images']) : [];
                                    $imgSrc = 'assets/img/default-1.jpg';
                                    if (!empty($images[0]) && isset($guitarimg_direct)) {
                                      $imgSrc = $guitarimg_direct . create_slug($dt['category_name']) . '/' . create_slug($dt['brand_name']) . '/' . create_slug($dt['product_name']) . '/' . trim($images[0]);
                                    }
                                  ?>
                                    <div class="item">
                                      <a href="product-details.php?id=<?= $dt['product_id'] ?>">
                                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Product" loading="lazy">
                                      </a>
                                      <div class="item-info">
                                        <h6><?= htmlspecialchars($dt['product_name']) ?>
                                        </h6>
                                        <div class="item-meta"><span class="qty">SL:
                                            <?= $dt['quantity'] ?></span></div>
                                      </div>
                                      <div class="item-price">
                                        <?= number_format($dt['unit_price'] * $dt['quantity'], 0, ',', '.') ?>
                                        VND
                                      </div>
                                    </div>
                                  <?php endforeach; ?>
                                </div>
                              </div>

                              <div class="detail-section">
                                <h5>Chi tiết giá</h5>
                                <div class="price-breakdown">
                                  <div class="price-row total">
                                    <span>Tổng cộng</span>
                                    <span><?= number_format($order['total_amount'], 0, ',', '.') ?>
                                      VND</span>
                                  </div>
                                </div>
                              </div>

                              <div class="detail-section">
                                <h5>Địa chỉ giao hàng</h5>
                                <div class="address-info">
                                  <p><?= htmlspecialchars($order['shipping_address']) ?></p>
                                </div>
                              </div>
                              <?php if (!empty($order['order_notes'])): ?>
                                <div class="detail-section mt-3">
                                  <h5>Ghi chú:</h5>
                                  <p class="text-muted">
                                    <?= nl2br(htmlspecialchars($order['order_notes'])) ?>
                                  </p>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>

                  <!-- Pagination -->
                  <div class="pagination-wrapper" data-aos="fade-up">
                    <nav class="d-flex justify-content-center">
                      <ul class="pagination-list" style="display: flex; list-style: none; gap: 8px; padding: 0;">
                        <?php
                        // Tạo URL giữ các tham số hiện tại để không bị mất tab khi chuyển trang
                        $params = $_GET;
                        unset($params['page']);
                        $query = http_build_query($params);
                        // Thêm #orders để sau khi load trang nó tự nhảy xuống tab Đơn hàng
                        $base_url = "account.php?" . ($query ? $query . "&" : "");
                        ?>

                        <?php if ($currentPage > 1): ?>
                          <li><a href="<?= $base_url ?>page=<?= $currentPage - 1 ?>#orders" class="btn-prev"><i
                                class="bi bi-chevron-left"></i></a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                          <li>
                            <a href="<?= $base_url ?>page=<?= $i ?>#orders"
                              class="page-number <?= ($i == $currentPage) ? 'active' : '' ?>"
                              style="<?= ($i == $currentPage) ? 'background: #000; color: #fff; padding: 5px 12px; border-radius: 4px;' : 'padding: 5px 12px;' ?>">
                              <?= $i ?>
                            </a>
                          </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $maxPage): ?>
                          <li><a href="<?= $base_url ?>page=<?= $currentPage + 1 ?>#orders" class="btn-next"><i
                                class="bi bi-chevron-right"></i></a></li>
                        <?php endif; ?>
                      </ul>
                    </nav>
                  </div>
                </div>
                <!-- Payment Methods Tab -->
                <div class="tab-pane fade" id="wallet">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Phương thức thanh toán</h2>
                    <div class="header-actions">
                      <button type="button" class="btn-add-new">
                        <i class="bi bi-plus-lg"></i>
                        Thêm thẻ mới
                      </button>
                    </div>
                  </div>

                  <div class="payment-cards-grid">
                    <!-- Payment Card 1 -->
                    <div class="payment-card default" data-aos="fade-up" data-aos-delay="100">
                      <div class="card-header">
                        <i class="bi bi-credit-card"></i>
                        <div class="card-badges">
                          <span class="default-badge">Mặc định</span>
                          <span class="card-type">Visa</span>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="card-number">•••• •••• •••• 4589</div>
                        <div class="card-info">
                          <span>Expires 09/2026</span>
                        </div>
                      </div>
                      <div class="card-actions">
                        <button type="button" class="btn-edit">
                          <i class="bi bi-pencil"></i>
                          Chỉnh sửa
                        </button>
                        <button type="button" class="btn-remove">
                          <i class="bi bi-trash"></i>
                          Xoá
                        </button>
                      </div>
                    </div>

                    <!-- Payment Card 2 -->
                    <div class="payment-card" data-aos="fade-up" data-aos-delay="200">
                      <div class="card-header">
                        <i class="bi bi-credit-card"></i>
                        <div class="card-badges">
                          <span class="card-type">Mastercard</span>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="card-number">•••• •••• •••• 7821</div>
                        <div class="card-info">
                          <span>Expires 05/2025</span>
                        </div>
                      </div>
                      <div class="card-actions">
                        <button type="button" class="btn-edit">
                          <i class="bi bi-pencil"></i>
                          Chỉnh sửa
                        </button>
                        <button type="button" class="btn-remove">
                          <i class="bi bi-trash"></i>
                          Xoá
                        </button>
                        <button type="button" class="btn-make-default">Đặt làm mặc định</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Đánh giá của tôi</h2>
                    <div class="header-actions">
                      <div class="dropdown">
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Recent</a></li>
                          <li><a class="dropdown-item" href="#">Highest Rating</a></li>
                          <li><a class="dropdown-item" href="#">Lowest Rating</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="reviews-grid">
                    <?php if (empty($userReviews)): ?>
                      <div class="w-100 p-4 text-center text-muted" style="background: #f8f9fa; border-radius: 8px;">
                        <i class="bi bi-star fs-1 text-secondary mb-2"></i>
                        <p>Bạn chưa viết đánh giá nào.</p>
                      </div>
                    <?php else: ?>
                      <?php foreach ($userReviews as $rv): ?>
                        <?php
                        $images = explode(',', $rv['product_images']);
                        $imgSrc = 'assets/img/product/default.png'; // Fallback
                        if (!empty($images[0]) && isset($guitarimg_direct)) {
                          $imgSrc = $guitarimg_direct . create_slug($rv['category_name']) . '/' . create_slug($rv['brand_name']) . '/' . create_slug($rv['product_name']) . '/' . trim($images[0]);
                        }
                        ?>
                        <div class="review-card" data-review-id="<?= htmlspecialchars($rv['id']) ?>"
                          data-images="<?= htmlspecialchars($rv['image_path'] ?? '') ?>" data-aos="fade-up"
                          data-aos-delay="100">
                          <div class="review-header">
                            <a href="product-details.php?id=<?= $rv['product_id'] ?>">
                              <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Product" class="product-image" loading="lazy"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            </a>
                            <div class="review-meta">
                              <h4><a href="product-details.php?id=<?= $rv['product_id'] ?>"
                                  style="color: inherit; text-decoration: none;"><?= htmlspecialchars($rv['product_name']) ?></a>
                              </h4>
                              <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                  <i class="bi <?= $i <= $rv['rating'] ? 'bi-star-fill' : 'bi-star' ?>" <?= $i <= $rv['rating'] ? 'style="color: #FBBF24;"' : '' ?>></i>
                                <?php endfor; ?>
                                <span>(<?= number_format($rv['rating'], 1) ?>)</span>
                              </div>
                              <div class="review-date"><?= date('d/m/Y H:i', strtotime($rv['created_at'])) ?></div>
                            </div>
                          </div>
                          <div class="review-content">
                            <p class="review-text"><?= nl2br(htmlspecialchars($rv['comment'])) ?></p>
                            <?php if (!empty($rv['image_path'])): ?>
                              <div class="review-images mt-2" style="display:flex; gap:10px;">
                                <?php foreach (explode(',', $rv['image_path']) as $imgPath): ?>
                                  <img src="<?= htmlspecialchars($imgPath) ?>"
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>

                            <!-- Hiển thị đánh giá chi tiết -->
                            <div style="display:flex;gap:20px;margin-top:10px;font-size:13px;color:#6b7280;">
                              <span>Âm thanh:
                                <?php for ($s = 1; $s <= 5; $s++)
                                  echo $s <= $rv['sound_rating'] ? '★' : '☆'; ?></span>
                              <span>Cấu hình:
                                <?php for ($s = 1; $s <= 5; $s++)
                                  echo $s <= $rv['specs_rating'] ? '★' : '☆'; ?></span>
                            </div>
                          </div>
                          <div class="review-footer">
                            <button type="button" class="btn-edit" data-id="<?= $rv['id'] ?>">Sửa đánh giá</button>
                            <button type="button" class="btn-delete" data-id="<?= $rv['id'] ?>">Xoá</button>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Addresses Tab -->
                <div class="tab-pane fade" id="addresses">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Địa chỉ giao hàng</h2>
                    <div class="header-actions">
                      <button type="button" class="btn-add-new d-none">
                        <i class="bi bi-plus-lg"></i>
                        Thêm địa chỉ mới
                      </button>
                    </div>
                  </div>

                  <div class="addresses-grid">
                    <?php if (!empty($user['address']) && !empty($user['city'])): ?>
                      <div class="address-card default" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-header">
                          <h4>Địa chỉ Mặc định</h4>
                          <span class="default-badge">Mặc định</span>
                        </div>
                        <div class="card-body">
                          <p class="address-text">
                            <?= htmlspecialchars($user['address']) ?><br>
                            <?= htmlspecialchars($user['ward']) ?><br>

                            <?= htmlspecialchars($user['city']) ?><br>
                            Việt Nam
                          </p>
                          <div class="contact-info">
                            <div><i class="bi bi-person"></i>
                              <?= htmlspecialchars($user['fullname']) ?></div>
                            <div><i class="bi bi-telephone"></i>
                              <?= htmlspecialchars($user['phone']) ?></div>
                          </div>
                        </div>
                        <div class="card-actions">
                          <!-- Redirect to settings tab to edit -->
                          <button type="button" class="btn-edit"
                            onclick="document.querySelector('a[href=\'#settings\']').click();">
                            <i class="bi bi-pencil"></i> Cập nhật
                          </button>
                        </div>
                      </div>
                    <?php else: ?>
                      <div class="w-100 p-4 text-center text-muted" style="background: #f8f9fa; border-radius: 8px;">
                        <i class="bi bi-geo-alt fs-1 text-secondary mb-2"></i>
                        <p>Bạn chưa thiết lập địa chỉ giao hàng. Vui lòng cập nhật trong phần Cài
                          đặt.</p>
                        <button type="button" class="btn btn-sm btn-dark mt-2"
                          onclick="document.querySelector('a[href=\'#settings\']').click();">Đến
                          trang Cài đặt</button>
                      </div>
                    <?php endif; ?>
                  </div>


                </div>
                <!-- Settings Tab -->
                <div class="tab-pane fade" id="settings">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Cài đặt tài khoản</h2>
                  </div>

                  <div class="settings-content">
                    <!-- Personal Information -->
                    <div class="settings-section" data-aos="fade-up">
                      <h3>Thông tin cá nhân</h3>
                      <form class="settings-form" method="POST" action="update_profile.php" id="account-settings-form"
                        enctype="multipart/form-data">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username"
                              value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                          </div>

                          <div class="col-md-6">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                              value="<?php echo htmlspecialchars($user['fullname']); ?>">
                          </div>

                          <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                              value="<?php echo htmlspecialchars($user['email']); ?>">
                          </div>

                          <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                              value="<?php echo htmlspecialchars($user['phone']); ?>">
                          </div>

                          <div class="col-md-6">
                            <label for="city" class="form-label">Tỉnh / Thành phố</label>
                            <select class="form-select" id="city" name="city" data-current="<?= htmlspecialchars($user['city'] ?? '') ?>">
                              <option value="">-- Chọn Tỉnh/Thành --</option>
                            </select>
                          </div>

                          <div class="col-md-6">
                            <label for="ward" class="form-label">Phường / Xã</label>
                            <select class="form-select" id="ward" name="ward" data-current="<?= htmlspecialchars($user['ward'] ?? '') ?>" disabled>
                              <option value="">-- Chọn Phường/Xã --</option>
                            </select>
                          </div>

                          <div class="col-md-12">
                            <label for="address" class="form-label">Địa chỉ cụ thể (Số nhà, tên đường)</label>
                            <input type="text" class="form-control" id="address" name="address"
                              value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" placeholder="VD: 123 Đường ABC...">
                          </div>


                          <div class="col-md-12 input-new-avatar-image">
                            <label for="profilePicture" class="form-label">Ảnh đại
                              diện</label>
                            <div class="input-group">
                              <input type="file" class="d-none" id="profilePicture" name="avatar" accept="image/*">
                              <input type="text" class="form-control" id="fileNameDisplay"
                                placeholder="Chưa có tệp nào được chọn" readonly
                                style="border-radius: 10px 0px 0px 10px;">
                              <button class="btn btn-outline-secondary custom-upload-btn" type="button"
                                id="uploadAvatarButton">
                                Tải lên
                              </button>
                            </div>
                            <div class="form-text">
                              Kích thước tối đa: 2MB. Định dạng: JPG, PNG.
                            </div>
                          </div>

                          <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">Lưu thay
                              đổi</button>
                          </div>
                        </div>
                      </form>
                    </div>


                    <!-- Email Preferences -->
                    <div class="settings-section" data-aos="fade-up" data-aos-delay="100">
                      <h3>Nhận thông báo</h3>
                      <div class="preferences-list">
                        <div class="preference-item">
                          <div class="preference-info">
                            <h4>Cập nhật đơn hàng</h4>
                            <p>Nhận thông báo về đơn hàng của bạn qua email</p>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="orderUpdates" checked="">
                          </div>
                        </div>

                        <div class="preference-item">
                          <div class="preference-info">
                            <h4>Khuyến mãi</h4>
                            <p>Nhận email về các chương trình khuyến mãi và ưu đãi mới</p>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="promotions">
                          </div>
                        </div>

                        <div class="preference-item">
                          <div class="preference-info">
                            <h4>Bản tin</h4>
                            <p>Đăng ký nhận bản tin hàng tuần của chúng tôi</p>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="newsletter" checked="">
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="settings-section" data-aos="fade-up" data-aos-delay="200">
                      <h3>Bảo mật</h3>
                      <form class="settings-form" id="password-update-form">
                        <div class="row g-3">
                          <div class="col-md-12">
                            <label for="currentPassword" class="form-label">Mật khẩu hiện
                              tại</label>
                            <input type="password" class="form-control" id="currentPassword">
                          </div>
                          <div class="col-md-6">
                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword">
                          </div>
                          <div class="col-md-6">
                            <label for="confirmPassword" class="form-label">Xác nhận mật
                              khẩu mới</label>
                            <input type="password" class="form-control" id="confirmPassword">
                          </div>
                        </div>

                        <div class="form-buttons">
                          <button type="submit" class="btn-save">Cập nhật mật khẩu</button>
                        </div>
                      </form>
                    </div>

                    <!-- Delete Account -->
                    <div class="settings-section danger-zone" data-aos="fade-up" data-aos-delay="300">
                      <h3>Xoá tài khoản</h3>
                      <div class="danger-zone-content">
                        <p>Một khi bạn đã xóa tài khoản, bạn sẽ không thể quay lại được nữa. Hãy
                          lưu ý kỹ!!.</p>
                        <button type="button" class="btn-danger" id="delete-account">Xoá tài
                          khoản</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

    </section><!-- /Account Section -->

  </main>

  <?php include 'forms/footer.php' ?>
  <?php include 'forms/scripts.php' ?>
  <script src="assets/js/account.js?v=<?= time() ?>"></script>






</body>

</html>