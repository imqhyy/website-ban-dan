<?php
require_once 'forms/init.php'; ?>
<?php $title = "Giỏ Hàng - Guitar Xì Gòn";
include 'forms/head.php' ?>
<style>
  /* Hiệu ứng làm mờ cho sản phẩm hết hàng */
  .cart-item.out-of-stock {
    opacity: 0.6;
    background-color: #f8f9fa;
  }

  .cart-item.out-of-stock .product-image img {
    filter: grayscale(100%);
    /* Làm ảnh thành trắng đen */
  }

  .img-sold-out-wrapper {
    position: relative;
    display: inline-block;
  }

  .sold-out-badge {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    text-align: center;
    font-size: 0.8rem;
    padding: 2px 0;
    font-weight: bold;
  }

  /* Vô hiệu hóa click vào mọi thứ trừ nút Xóa */
  .cart-item.out-of-stock .product-details a,
  .cart-item.out-of-stock .quantity-selector {
    pointer-events: none;
  }

  .cart-item.out-of-stock .remove-item {
    pointer-events: auto;
    /* Vẫn cho phép bấm nút Xóa */
    cursor: pointer;
  }

  /* Fix checkbox lệch */
  #check-all,
  .item-check {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    vertical-align: middle !important;
    position: relative !important;
    top: 0 !important;
    flex-shrink: 0;
    align-self: center;
    width: 18px;
    height: 18px;
  }
</style>

<body>

  <?php include 'forms/header.php' ?>
  <?php if (!isset($_SESSION['user'])): ?>

    <div style="min-height: 60vh;"></div>
    <?php include 'forms/footer.php'; ?>
    <?php include 'forms/scripts.php'; ?>

    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Yêu cầu đăng nhập',
        text: 'Bạn cần đăng nhập để có thể xem giỏ hàng.',
        confirmButtonText: 'Đến trang đăng nhập',
        allowOutsideClick: false,
        customClass: {
          container: 'blurred-login-alert',
          popup: 'my-swal-popup',
          title: 'my-swal-title',
          htmlContainer: 'my-swal-html-container',
          confirmButton: 'my-swal-confirm-button'
        }
      }).then(() => {
        window.location.href = 'login.php';
      });
    </script>
  </body>

  </html>
  <?php exit(); // DỪNG TOÀN BỘ CODE TẠI ĐÂY, KHÔNG CHO CHẠY XUỐNG DƯỚI ?>
<?php endif; ?>
<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Giỏ hàng</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Trang chủ</a></li>
          <li class="current">Giỏ hàng</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Cart Section -->
  <section id="cart" class="cart section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
          <div class="cart-items">
            <div class="cart-header d-none d-lg-block">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <div class="d-flex align-items-center">
                    <input class="form-check-input me-3" type="checkbox" id="check-all">
                    <h5 class="mb-0">Chọn tất cả</h5>
                  </div>
                </div>
                <div class="col-lg-2 text-center">
                  <h5>Đơn giá</h5>
                </div>
                <div class="col-lg-2 text-center">
                  <h5>Số lượng</h5>
                </div>
                <div class="col-lg-2 text-center">
                  <h5>Thành tiền</h5>
                </div>
              </div>
            </div>

            <div id="cart-items-container-demo">
              <?php
              // Lấy ID user
              $session_user = is_array($_SESSION['user']) ? $_SESSION['user']['id'] : $_SESSION['user'];
              $user_id = 0;
              if (!is_numeric($session_user)) {
                $stmt_u = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                $stmt_u->execute([$session_user]);
                $u = $stmt_u->fetch();
                if ($u)
                  $user_id = $u['id'];
              } else {
                $user_id = $session_user;
              }

              // Truy vấn giỏ hàng kết hợp thông tin sản phẩm
              $sql_cart = "
                  SELECT c.quantity, p.id as product_id, p.product_name, p.selling_price, p.product_images, p.stock_quantity,
                         b.brand_name, cat.category_name
                  FROM cart c
                  JOIN products p ON c.product_id = p.id
                  LEFT JOIN brands b ON p.brand_id = b.id
                  LEFT JOIN categories cat ON p.category_id = cat.id
                  WHERE c.user_id = ?
              ";
              $stmt_cart = $pdo->prepare($sql_cart);
              $stmt_cart->execute([$user_id]);
              $cart_items = $stmt_cart->fetchAll();
              $total_cart = 0;
              if (count($cart_items) > 0):
                foreach ($cart_items as $item):
                  $type_folder = create_slug($item['category_name']);
                  $brand_folder = create_slug($item['brand_name']);
                  $product_folder = create_slug($item['product_name']);
                  $base_path = $guitarimg_direct . $type_folder . '/' . $brand_folder . '/' . $product_folder . '/';
                  $images = !empty($item['product_images']) ? explode(',', $item['product_images']) : [];
                  $main_img = !empty($images[0]) ? $base_path . trim($images[0]) : 'assets/img/default-1.jpg';

                  // --- LOGIC KIỂM TRA TỒN KHO ---
                  $is_out_of_stock = ($item['stock_quantity'] <= 0);
                  $display_quantity = $item['quantity'];
                  $stock_warning = false;

                  // Nếu kho còn hàng nhưng khách bỏ giỏ nhiều hơn số lượng kho hiện tại
                  if (!$is_out_of_stock && $display_quantity > $item['stock_quantity']) {
                    $display_quantity = $item['stock_quantity']; // Tự ép hiển thị về số lượng tối đa còn lại
                    $stock_warning = true;
                  }

                  // Chỉ cộng tiền những sản phẩm còn hàng
                  if (!$is_out_of_stock) {
                    $item_total = $item['selling_price'] * $display_quantity;
                    $total_cart += $item_total;
                  } else {
                    $item_total = 0;
                  }
                  ?>
                  <div class="cart-item <?= $is_out_of_stock ? 'out-of-stock' : '' ?>"
                    data-price="<?= $item['selling_price'] ?>" data-id="<?= $item['product_id'] ?>">
                    <div class="row align-items-center">
                      <div class="col-lg-6 col-12 mt-3 mt-lg-0 mb-lg-0 mb-3">
                        <div class="product-info d-flex align-items-center">
                          <input class="form-check-input item-check me-3" type="checkbox" value="<?= $item['product_id'] ?>"
                            >
                          <div class="product-image img-sold-out-wrapper">
                            <a href="product-details.php?id=<?= $item['product_id'] ?>">
                              <img src="<?= $main_img ?>" alt="<?= htmlspecialchars($item['product_name']) ?>"
                                class="img-fluid">
                            </a>
                            <?php if ($is_out_of_stock): ?>
                              <div class="sold-out-badge">Hết hàng</div>
                            <?php endif; ?>
                          </div>
                          <div class="product-details">
                            <a href="product-details.php?id=<?= $item['product_id'] ?>">
                              <h6 class="product-title"><?= htmlspecialchars($item['product_name']) ?></h6>
                            </a>
                            <button class="remove-item btn btn-link text-danger p-0" type="button"><i
                                class="bi bi-trash"></i> Xóa</button>

                            <?php if ($stock_warning): ?>
                              <p class="text-warning mb-0" style="font-size: 0.8rem;"><i
                                  class="bi bi-exclamation-triangle"></i> Chỉ còn <?= $item['stock_quantity'] ?> sản phẩm.</p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                        <div class="price-tag"><span
                            class="current-price"><?= number_format($item['selling_price'], 0, ',', '.') ?> VNĐ</span></div>
                      </div>
                      <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                        <?php if ($is_out_of_stock): ?>
                          <span class="text-muted fw-bold">Không khả dụng</span>
                        <?php else: ?>
                          <div class="quantity-selector">
                            <button class="quantity-btn decrease" type="button"><i class="bi bi-dash"></i></button>
                            <input type="number" class="quantity-input" value="<?= $display_quantity ?>" min="1"
                              max="<?= $item['stock_quantity'] ?>">
                            <button class="quantity-btn increase" type="button"><i class="bi bi-plus"></i></button>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                        <div class="item-total"><strong><?= number_format($item_total, 0, ',', '.') ?> VNĐ</strong></div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-center mt-4">Giỏ hàng của bạn đang trống.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
          <div class="cart-summary">
            <h4 class="summary-title">Tóm tắt đơn hàng</h4>
            <div class="summary-item">
              <span class="summary-label">Tạm tính</span>
              <span class="summary-value" id="cart-subtotal">0 VNĐ</span>
            </div>
            <div class="summary-total">
              <span class="summary-label">Tổng cộng</span>
              <span class="summary-value" id="cart-total">0 VNĐ</span>
            </div>
            <div class="checkout-button">
              <a href="checkout.php" class="btn btn-accent w-100">Tiến hành thanh toán <i
                  class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php include 'forms/footer.php' ?>
<?php include 'forms/scripts.php' ?>
<script src="assets/js/cart.js"></script>
</body>

</html>