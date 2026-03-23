<?php
require_once __DIR__ . "/../../../forms/database.php"; 

$order_id = (int)($_GET['id'] ?? 0);

// Sử dụng bí danh 'o' cho bảng orders để tránh lỗi cú pháp
$order = getOne("SELECT * FROM orders o WHERE o.id = ?", [$order_id]);

if (!$order) exit("Không tìm thấy đơn hàng.");

// Tương tự cho phần chi tiết sản phẩm
$sqlDetails = "SELECT d.*, p.product_name, c.category_name, b.brand_name 
               FROM order_details d
               JOIN products p ON d.product_id = p.id
               JOIN categories c ON p.category_id = c.id
               JOIN brands b ON p.brand_id = b.id
               WHERE d.order_id = ?";

$details = getAll($sqlDetails, [$order_id]);
?>

<div style="padding: 10px;">
    <p>Ngày đặt hàng: <b><?= date("d/m/Y", strtotime($order['created_at'])) ?></b></p>
    <p>Mã đơn hàng: <b>#<?= htmlspecialchars($order['order_code']) ?></b></p>
    <p>Người nhận: <b><?= htmlspecialchars($order['customer_name']) ?></b> - <b><?= htmlspecialchars($order['phone']) ?></b></p>
    <p>Địa chỉ: <b><?= htmlspecialchars($order['shipping_address']) ?></b></p>
    <p>Lưu ý: <i><?= htmlspecialchars($order['order_notes'] ?: 'Không có') ?></i></p>
</div>

<hr>
<?php foreach ($details as $d): ?>
<div class="product-fields-template" style="background-color: #f9f9f9; padding: 10px; margin-bottom: 5px; border-radius: 10px;">
    <p style="margin-bottom: 5px;">Tên sản phẩm: <b><?= htmlspecialchars($d['product_name']) ?></b></p>
    <p style="margin-bottom: 0px; font-size: 0.9rem; color: #666;">
        Loại: <?= htmlspecialchars($d['category_name']) ?> | Thương hiệu: <?= htmlspecialchars($d['brand_name']) ?>
    </p>
    <p style="margin-bottom: 0px;">Số Lượng: <b><?= $d['quantity'] ?></b> - Đơn giá: <b><?= number_format($d['unit_price'], 0, ',', '.') ?>VND</b></p>
</div>
<?php endforeach; ?>

<div style="margin-top: 15px; text-align: right;">
    <p>Tổng thanh toán: <b style="font-size: 1.4rem; color: #d33;"><?= number_format($order['total_amount'], 0, ',', '.') ?>VND</b></p>
</div>