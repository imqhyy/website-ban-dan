<?php
require_once 'forms/init.php';
$title = "Thanh toán - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="checkout-page">
  <?php include 'forms/header.php' ?>

  <?php
  // NẾU CHƯA ĐĂNG NHẬP -> HIỆN POPUP RỒI DỪNG LẠI
  if (!isset($_SESSION['user'])):
    ?>
    <div style="min-height: 60vh;"></div>
    <?php include 'forms/footer.php'; ?>
    <?php include 'forms/scripts.php'; ?>

    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Yêu cầu đăng nhập',
        text: 'Bạn cần đăng nhập để có thể thanh toán!',
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
  <?php exit(); // DỪNG TOÀN BỘ CODE TẠI ĐÂY NẾU CHƯA ĐĂNG NHẬP ?>
<?php endif; ?>


<?php
// NẾU ĐÃ ĐĂNG NHẬP -> CHẠY CODE LẤY DỮ LIỆU DB
$session_user = is_array($_SESSION['user']) ? $_SESSION['user']['id'] : $_SESSION['user'];
$user_info = is_numeric($session_user)
  ? getOne("SELECT * FROM users WHERE id = $session_user")
  : getOne("SELECT * FROM users WHERE username = '$session_user'");
$user_id = $user_info['id'];
// NẾU ĐÃ ĐĂNG NHẬP -> CHẠY CODE LẤY DỮ LIỆU DB
$session_user = is_array($_SESSION['user']) ? $_SESSION['user']['id'] : $_SESSION['user'];
$user_info = is_numeric($session_user)
  ? getOne("SELECT * FROM users WHERE id = $session_user")
  : getOne("SELECT * FROM users WHERE username = '$session_user'");
$user_id = $user_info['id'];

// ==================== LẤY DỮ LIỆU SẢN PHẨM ====================
$is_buy_now = isset($_GET['type']) && $_GET['type'] == 'buynow';
$cart_items = [];
$in_clause = '';

if ($is_buy_now && isset($_SESSION['buy_now_item'])) {
  // 1. LẤY TỪ MUA NGAY (DỮ LIỆU TRONG SESSION)
  $p_id = (int) $_SESSION['buy_now_item']['product_id'];
  $p_qty = (int) $_SESSION['buy_now_item']['quantity'];

  $product = getOne("
        SELECT p.id as product_id, p.product_name, p.selling_price, p.discount_percent, p.product_images, p.stock_quantity, p.status, b.brand_name, cat.category_name
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN categories cat ON p.category_id = cat.id
        WHERE p.id = $p_id
    ");

  if (!$product || $product['status'] === 'hidden') {
    echo "<script>window.location.href='index.php?error=' + encodeURIComponent('Sản phẩm không hợp lệ!');</script>";
    exit();
  }

  // Lớp bảo vệ thứ 2: Đề phòng trường hợp lỗi Session, tự ép số lượng về tối đa của kho
  if ($p_qty > $product['stock_quantity']) {
    $p_qty = $product['stock_quantity'];
  }

  $product['quantity'] = $p_qty;
  $cart_items[] = $product;

} else {
  // 2. LẤY TỪ GIỎ HÀNG (DỮ LIỆU TỪ DATABASE)
  $selected_items = $_GET['items'] ?? '';
  if (empty($selected_items)) {
    echo "<script>window.location.href='cart.php?error=' + encodeURIComponent('Vui lòng chọn sản phẩm cần thanh toán!');</script>";
    exit();
  }

  $item_ids = array_filter(explode(',', $selected_items), 'is_numeric');
  $in_clause = implode(',', $item_ids);

  $cart_items = getAll("
        SELECT c.quantity, p.id as product_id, p.product_name, p.selling_price, p.discount_percent, p.product_images, p.stock_quantity, p.status, b.brand_name, cat.category_name
        FROM cart c
        JOIN products p ON c.product_id = p.id
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN categories cat ON p.category_id = cat.id
        WHERE c.user_id = $user_id AND p.id IN ($in_clause)
    ");

  if (empty($cart_items)) {
    echo "<script>window.location.href='cart.php?error=' + encodeURIComponent('Giỏ hàng của bạn đang trống!');</script>";
    exit();
  }
}
// ==============================================================
$total_cart = 0;
$total_items = 0;
$total_savings = 0;

foreach ($cart_items as &$item) {
  if ($item['status'] === 'hidden') {
    $err = urlencode('Sản phẩm "' . $item['product_name'] . '" không tồn tại hoặc đã ngừng kinh doanh!');
    echo "<script>window.location.href='cart.php?error=$err';</script>";
    exit();
  }

  $has_discount = ($item['discount_percent'] > 0);
  $original_price = $item['selling_price'];
  // Tính giá thực tế
  $actual_price = $has_discount ? $original_price * (1 - ($item['discount_percent'] / 100)) : $original_price;

  $item['actual_price'] = $actual_price;
  $item['original_price'] = $original_price;

  $total_cart += $actual_price * $item['quantity'];
  $total_items += $item['quantity'];
  $total_savings += ($original_price - $actual_price) * $item['quantity'];
}
unset($item);
?>

<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Thanh toán</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Trang chủ</a></li>
          <li class="current">Thanh toán</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="checkout" class="checkout section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-7">
          <div class="checkout-container" data-aos="fade-up">
            <form class="checkout-form" id="checkout-form">
              <div class="checkout-section">
                <div class="section-header">
                  <div class="section-number">1</div>
                  <h3>Thông tin khách hàng</h3>
                </div>
                <div class="section-content">
                  <input type="hidden" name="checkout_type" value="<?= $is_buy_now ? 'buynow' : 'cart' ?>">
                  <?php if (!$is_buy_now): ?>
                    <input type="hidden" name="selected_items" value="<?= htmlspecialchars($in_clause) ?>">
                  <?php endif; ?>
                  <div class="form-group">
                    <label for="name">Họ và tên người nhận</label>
                    <input type="text" value="<?= htmlspecialchars($user_info['fullname'] ?? '') ?>"
                      class="form-control" name="nameinfo" id="name" required />
                  </div>
                  <div class="form-group">
                    <label for="email">Địa chỉ Email</label>
                    <input type="email" value="<?= htmlspecialchars($user_info['email'] ?? '') ?>" class="form-control"
                      name="email" id="email" required />
                  </div>
                  <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone" id="phone"
                      value="<?= htmlspecialchars($user_info['phone'] ?? '') ?>" required />
                  </div>
                  <div class="form-group">
                    <label for="note">Lưu ý</label>
                    <input type="text" class="form-control" name="note" id="note" />
                  </div>
                </div>
              </div>

              <?php
              // Xây dựng chuỗi địa chỉ đầy đủ từ các cột trong DB
              $address_parts = [];
              if (!empty($user_info['address']))
                $address_parts[] = $user_info['address'];
              if (!empty($user_info['ward']))
                $address_parts[] = $user_info['ward'];
              if (!empty($user_info['district']))
                $address_parts[] = $user_info['district'];
              if (!empty($user_info['city']))
                $address_parts[] = $user_info['city'];

              $full_address = implode(', ', $address_parts);
              ?>

              <div class="checkout-section">
                <div class="section-header">
                  <div class="section-number">2</div>
                  <h3>Địa chỉ giao hàng</h3>
                </div>
                <div class="section-content">

                  <input type="hidden" name="address" id="final-address" value="<?= htmlspecialchars($full_address) ?>">

                  <div class="address-options mb-4">
                    <div class="form-check address-option">
                      <input class="form-check-input" type="radio" name="address-option" id="default-address"
                        value="default" checked />
                      <label class="form-check-label" for="default-address">
                        Địa chỉ Mặc định
                        <i class="bi bi-geo-alt-fill text-danger ms-2"></i>
                      </label>
                      <p id="default-address-display" class="form-text ms-4"
                        data-address="<?= htmlspecialchars($full_address) ?>">
                        <?= $full_address !== '' ? htmlspecialchars($full_address) : 'Bạn chưa thiết lập địa chỉ mặc định' ?>
                      </p>
                    </div>

                    <div class="form-check address-option mt-3">
                      <input class="form-check-input" type="radio" name="address-option" id="new-address" value="new" />
                      <label class="form-check-label" for="new-address">
                        Thêm địa chỉ mới
                      </label>
                    </div>
                  </div>

                  <div class="form-group" id="new-address-group"
                    style="display: none; margin-left: 1.5rem; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <label class="mb-2 fw-bold text-dark">Thêm địa chỉ giao hàng mới</label>

                    <div class="row g-2 mb-2">
                      <div class="col-md-6">
                        <select class="form-select" id="new-city">
                          <option value="">-- Chọn Tỉnh/Thành --</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <select class="form-select" id="new-ward" disabled>
                          <option value="">-- Chọn Phường/Xã --</option>
                        </select>
                      </div>
                    </div>

                    <div class="mb-2">
                      <input type="text" class="form-control" id="new-street" placeholder="Nhập số nhà, tên đường..." />
                    </div>

                    <button type="button" id="btn-apply-address" class="btn btn-sm btn-dark mt-2">
                      <i class="bi bi-check-circle"></i> Hoàn thành
                    </button>
                    <span id="apply-success-msg" class="text-success ms-2" style="display: none; font-weight: 500;">
                      Đã áp dụng địa chỉ mới!
                    </span>
                  </div>

                </div>
              </div>

              <div class="checkout-section" id="payment-method">
                <div class="section-header">
                  <div class="section-number">3</div>
                  <h3>Phương thức thanh toán</h3>
                </div>
                <div class="section-content">
                  <div class="payment-options">
                    <div class="payment-option active">
                      <input type="radio" name="payment-method" id="cod" value="COD" checked="" />
                      <label for="cod">
                        <span class="payment-icon"><i class="bi bi-cash-coin"></i></span>
                        <span class="payment-label">Thanh toán khi nhận hàng (COD)</span>
                      </label>
                    </div>
                    <div class="payment-option">
                      <input type="radio" name="payment-method" id="bank-transfer" value="Bank Transfer" />
                      <label for="bank-transfer">
                        <span class="payment-icon"><i class="bi bi-bank"></i></span>
                        <span class="payment-label">Chuyển khoản ngân hàng</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="checkout-section">
                <div class="section-header">
                  <div class="section-number">4</div>
                  <h3>Hoàn tất đơn hàng</h3>
                </div>
                <div class="section-content">
                  <div class="place-order-container">
                    <button type="submit" class="btn btn-primary place-order-btn">
                      <span class="btn-text">Đặt Hàng</span>
                      <span class="btn-price" id="place-order-btn-price"><?= number_format($total_cart, 0, ',', '.') ?>
                        VNĐ</span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="order-summary" data-aos="fade-left" data-aos-delay="200">
            <div class="order-summary-header">
              <h3>Tóm tắt đơn hàng</h3>
              <span class="item-count" id="item-count"><?= $total_items ?> sản phẩm</span>
            </div>
            <div class="order-summary-content">
              <div class="order-items" id="order-summary-items">
                <?php foreach ($cart_items as $item):
                  $images = !empty($item['product_images']) ? explode(',', $item['product_images']) : [];
                  $main_img = !empty($images[0]) ? $guitarimg_direct . create_slug($item['category_name']) . '/' . create_slug($item['brand_name']) . '/' . create_slug($item['product_name']) . '/' . trim($images[0]) : 'assets/img/default-1.jpg';
                  ?>
                  <div class="order-item">
                    <div class="order-item-image"><img src="<?= $main_img ?>"
                        alt="<?= htmlspecialchars($item['product_name']) ?>" class="img-fluid"></div>
                    <div class="order-item-details">
                      <h4><?= htmlspecialchars($item['product_name']) ?></h4>
                      <div class="order-item-price">
                        <span class="quantity"><?= $item['quantity'] ?> ×</span>
                        <?php if ($item['discount_percent'] > 0): ?>
                          <span class="text-muted text-decoration-line-through me-1"
                            style="font-size: 0.85rem;"><?= number_format($item['original_price'], 0, ',', '.') ?>đ</span>
                        <?php endif; ?>
                        <span class="price text-danger fw-bold"><?= number_format($item['actual_price'], 0, ',', '.') ?>
                          VNĐ</span>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <div class="order-totals">
                <div class="order-subtotal d-flex justify-content-between mb-2">
                  <span>Tạm tính</span>
                  <span id="order-subtotal"><?= number_format($total_cart, 0, ',', '.') ?> VNĐ</span>
                </div>

                <?php if ($total_savings > 0): ?>
                  <div class="order-savings d-flex justify-content-between  mb-3">
                    <span>Tiết kiệm</span>
                    <span>-<?= number_format($total_savings, 0, ',', '.') ?> VNĐ</span>
                  </div>
                <?php endif; ?>

                <div class="order-shipping d-flex justify-content-between mb-2">
                  <span>Vận chuyển</span>
                  <span>Miễn phí</span>
                </div>

                <div class="order-tax d-flex justify-content-between mb-3">
                  <span>Thuế</span>
                  <span>0 VNĐ</span>
                </div>

                <div class="order-total d-flex justify-content-between fw-bold fs-5 border-top pt-3 mt-2">
                  <span>Tổng cộng</span>
                  <span id="order-total" class="text-danger"><?= number_format($total_cart, 0, ',', '.') ?> VNĐ</span>
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

<script src="assets/js/checkout.js"></script>
</body>

</html>