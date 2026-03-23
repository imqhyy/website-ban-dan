<?php
require_once 'forms/init.php';

// 1. Bắt mã đơn hàng từ URL
$order_code = $_GET['order'] ?? '';
if (empty($order_code)) {
  header("Location: index.php");
  exit();
}

// 2. Truy vấn thông tin đơn hàng từ DB
$stmt_order = $pdo->prepare("SELECT * FROM orders WHERE order_code = ?");
$stmt_order->execute([$order_code]);
$order_info = $stmt_order->fetch();

if (!$order_info) {
  echo "<script>alert('Không tìm thấy đơn hàng!'); window.location.href='index.php';</script>";
  exit();
}

// 3. Truy vấn chi tiết sản phẩm của đơn hàng đó
$stmt_details = $pdo->prepare("
    SELECT od.*, p.product_name, p.product_images, b.brand_name, cat.category_name
    FROM order_details od
    JOIN products p ON od.product_id = p.id
    LEFT JOIN brands b ON p.brand_id = b.id
    LEFT JOIN categories cat ON p.category_id = cat.id
    WHERE od.order_id = ?
");
$stmt_details->execute([$order_info['id']]);
$order_items = $stmt_details->fetchAll();

$title = "Xác Nhận Đơn Hàng - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="order-confirmation-page">
  <?php include 'forms/header.php' ?>

  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Xác nhận đơn hàng</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Trang chủ</a></li>
            <li class="current">Xác nhận đơn hàng</li>
          </ol>
        </nav>
      </div>
    </div>
    <section id="order-confirmation" class="order-confirmation section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="order-confirmation-3">
          <div class="row g-0">
            <div class="col-lg-4 sidebar" data-aos="fade-right">
              <div class="sidebar-content">
                <div class="success-animation">
                  <i class="bi bi-check-lg"></i>
                </div>
                <div class="order-id">
                  <h4 id="summary-order-id">Mã đơn: #<?= htmlspecialchars($order_info['order_code']) ?></h4>
                  <div class="order-date" id="summary-order-date">
                    Ngày đặt: <?= date('d/m/Y H:i', strtotime($order_info['created_at'] ?? 'now')) ?>
                  </div>
                </div>
                <div class="price-summary">
                  <h5>Tóm tắt đơn hàng</h5>
                  <ul class="summary-list">
                    <li>
                      <span>Tổng sản phẩm</span>
                      <span><?= number_format($order_info['total_amount'], 0, ',', '.') ?> VND</span>
                    </li>
                    <li>
                      <span>Phí vận chuyển</span>
                      <span>Miễn phí</span>
                    </li>
                    <li>
                      <span>Thuế</span>
                      <span>0 VND</span>
                    </li>
                    <li class="total">
                      <span>Total</span>
                      <span><?= number_format($order_info['total_amount'], 0, ',', '.') ?> VND</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-lg-8 main-content" data-aos="fade-in">
              <div class="thank-you-message">
                <h1 id="thank-you-name">Cảm ơn, <?= htmlspecialchars($order_info['customer_name']) ?>!</h1>
                <p>
                  Chúng tôi đã nhận được đơn hàng và sẽ xử lý ngay. Một email
                  xác nhận cùng thông tin chi tiết đã được gửi đến bạn.
                </p>
              </div>
              <div class="details-card" data-aos="fade-up">
                <div class="card-header">
                  <h3><i class="bi bi-geo-alt"></i>Chi tiết giao hàng</h3>
                </div>
                <div class="card-body">
                  <div class="row g-4">
                    <div class="col-md-12">
                      <div class="detail-group">
                        <label>Giao đến</label>
                        <address id="shipping-address-details">
                          <strong><?= htmlspecialchars($order_info['customer_name']) ?></strong><br>
                          Địa chỉ: <?= htmlspecialchars($order_info['shipping_address']) ?><br>
                          Email: <?= htmlspecialchars($order_info['email']) ?> <br>
                          SĐT: <?= htmlspecialchars($order_info['phone']) ?>
                          <?php if (!empty($order_info['order_notes'])): ?>
                            <br><span class="text-danger">Ghi chú:
                              <?= htmlspecialchars($order_info['order_notes']) ?></span>
                          <?php endif; ?>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="details-card" data-aos="fade-up">
                <div class="card-header">
                  <h3><i class="bi bi-bag-check"></i>Sản phẩm đã đặt</h3>
                </div>
                <div class="card-body" id="confirmation-item-list">
                  <?php foreach ($order_items as $item):
                    $images = !empty($item['product_images']) ? explode(',', $item['product_images']) : [];
                    $main_img = !empty($images[0]) ? $guitarimg_direct . create_slug($item['category_name']) . '/' . create_slug($item['brand_name']) . '/' . create_slug($item['product_name']) . '/' . trim($images[0]) : 'assets/img/default-1.jpg';
                    ?>
                    <div class="item">
                      <div class="item-image">
                        <img src="<?= $main_img ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" loading="lazy"
                          style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                      </div>
                      <div class="item-details"
                        style="display: flex; flex-direction: column; justify-content: center; margin-left: 15px;">
                        <h4 style="font-size: 1.1rem; margin-bottom: 5px;"><?= htmlspecialchars($item['product_name']) ?>
                        </h4>
                        <div class="item-price" style="color: #6c757d;">
                          <span class="quantity"><?= $item['quantity'] ?> ×</span>
                          <span class="price fw-bold text-danger"><?= number_format($item['unit_price'], 0, ',', '.') ?>
                            VNĐ</span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="action-area" data-aos="fade-up">
                <div class="row g-3">
                  <div class="col-md-6">
                    <a href="all.php" class="btn btn-back"><i class="bi bi-arrow-left"></i>Tiếp tục mua sắm</a>
                  </div>
                  <div class="col-md-6">
                    <a href="account.php" class="btn btn-account"><span>Xem trong Tài khoản</span><i
                        class="bi bi-arrow-right"></i></a>
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

</body>

</html>