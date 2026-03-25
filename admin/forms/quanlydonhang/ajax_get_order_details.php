<?php
require_once __DIR__ . "/../../../forms/database.php";

$order_id = (int) ($_GET['id'] ?? 0);

// Sử dụng bí danh 'o' cho bảng orders để tránh lỗi cú pháp
$order = getOne("SELECT * FROM orders o WHERE o.id = ?", [$order_id]);

if (!$order)
    exit("Không tìm thấy đơn hàng.");

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
    <p>Người nhận: <b><?= htmlspecialchars($order['customer_name']) ?></b> -
        <b><?= htmlspecialchars($order['phone']) ?></b></p>
    <p>Địa chỉ: <b><?= htmlspecialchars($order['shipping_address']) ?></b></p>
    <p>Lưu ý: <i><?= htmlspecialchars($order['order_notes'] ?: 'Không có') ?></i></p>
</div>

<hr>
<?php foreach ($details as $d): ?>
    <div class="product-fields-template"
        style="background-color: #f9f9f9; padding: 15px; margin-bottom: 10px; border-radius: 10px; border-left: 5px solid #007bff;">
        <p style="margin-bottom: 5px;">Tên sản phẩm: <b><?= htmlspecialchars($d['product_name']) ?></b></p>
        <p style="margin-bottom: 5px; font-size: 0.9rem; color: #666;">
            Loại: <?= htmlspecialchars($d['category_name']) ?> | Thương hiệu: <?= htmlspecialchars($d['brand_name']) ?>
        </p>

        <div style="display: flex; gap: 20px; align-items: center; background: #fff; padding: 8px; border-radius: 5px;">
            <p style="margin-bottom: 0px;">Số Lượng: <b><?= $d['quantity'] ?></b></p>

            <div class="price-info">
                <?php if ($d['discount_percent'] > 0): ?>
                    <span style="text-decoration: line-through; color: #999; font-size: 0.85rem;">
                        <?= number_format($d['original_price'], 0, ',', '.') ?> VND
                    </span>
                    <span
                        style="background: #ffebeb; color: #d33; padding: 2px 5px; border-radius: 3px; font-size: 0.8rem; font-weight: bold; margin: 0 5px;">
                        -<?= (float) $d['discount_percent'] ?>%
                    </span>
                <?php endif; ?>

                <span style="font-weight: bold; color: #333;">
                    <?= number_format($d['unit_price'], 0, ',', '.') ?> VND/SP
                </span>
            </div>
        </div>

        <p style="margin-top: 5px; margin-bottom: 0px; text-align: right; font-size: 0.95rem;">
            Thành tiền: <b style="color: #007bff;"><?= number_format($d['unit_price'] * $d['quantity'], 0, ',', '.') ?>
                VND</b>
        </p>
    </div>
<?php endforeach; ?>

<div style="margin-top: 15px; text-align: right;">
    <p>Tổng thanh toán: <b
            style="font-size: 1.4rem; color: #d33;"><?= number_format($order['total_amount'], 0, ',', '.') ?>VND</b></p>
</div>