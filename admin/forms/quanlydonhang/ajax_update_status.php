<?php
require_once __DIR__ . "/../../../forms/database.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    $new_status = $_POST['status'];

    try {
        $pdo->beginTransaction();

        // 1. Lấy trạng thái cũ (Dùng alias o cho chắc chắn)
        $old_status = getOne("SELECT o.order_status FROM orders o WHERE o.id = ?", [$order_id])['order_status'];

        // 2. Cập nhật trạng thái mới
        $stmt = $pdo->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $stmt->execute([$new_status, $order_id]);

        // 3. Logic kho hàng: Nếu huỷ đơn thì cộng trả lại stock_quantity
        if ($new_status === 'cancel' && $old_status !== 'cancel') {
            $items = getAll("SELECT product_id, quantity FROM order_details WHERE order_id = ?", [$order_id]);
            foreach ($items as $item) {
                $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity + ? WHERE id = ?")
                    ->execute([$item['quantity'], $item['product_id']]);
            }
        }
        
        // Nếu chuyển từ 'cancel' về lại trạng thái khác thì trừ kho lại
        if ($old_status === 'cancel' && $new_status !== 'cancel') {
            $items = getAll("SELECT product_id, quantity FROM order_details WHERE order_id = ?", [$order_id]);
            foreach ($items as $item) {
                $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?")
                    ->execute([$item['quantity'], $item['product_id']]);
            }
        }

        $pdo->commit();
        echo "success";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "error: " . $e->getMessage();
    }
}
?>