<?php
require_once '../init.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập.']);
    exit();
}

global $pdo;

// Lấy user_id
$session_user = is_array($_SESSION['user']) ? $_SESSION['user']['id'] : $_SESSION['user'];
$user_id = is_numeric($session_user) ? $session_user : getOne("SELECT id FROM users WHERE username = '$session_user'")['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['nameinfo'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $note = $_POST['note'] ?? '';

    if (empty($name) || empty($phone) || empty($address)) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin bắt buộc.']);
        exit();
    }

    $selected_items = $_POST['selected_items'] ?? '';
    $item_ids = array_filter(explode(',', $selected_items), 'is_numeric');
    if (empty($item_ids)) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi: Không có sản phẩm nào được chọn.']);
        exit();
    }
    $in_clause = implode(',', $item_ids);

    try {
        $pdo->beginTransaction();

        // 1. Chỉ khóa và check tồn kho những sản phẩm được chọn mua
        $stmt_cart = $pdo->prepare("
            SELECT c.quantity, p.selling_price, p.id as product_id, p.product_name, p.stock_quantity 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ? AND p.id IN ($in_clause) FOR UPDATE
        ");
        $stmt_cart->execute([$user_id]);
        $cart_items = $stmt_cart->fetchAll();

        if (empty($cart_items)) {
            throw new Exception("Giỏ hàng trống.");
        }

        $total_amount = 0;
        foreach ($cart_items as $item) {
            // KIỂM TRA: Nếu số lượng mua lớn hơn số lượng trong kho
            if ($item['quantity'] > $item['stock_quantity']) {
                throw new Exception("Rất tiếc, sản phẩm '" . $item['product_name'] . "' hiện chỉ còn " . $item['stock_quantity'] . " chiếc trong kho. Vui lòng cập nhật lại giỏ hàng.");
            }
            $total_amount += $item['selling_price'] * $item['quantity'];
        }

        // 2. Tạo mã đơn hàng (VD: ORD-2026-A1B2C)
        $order_code = 'ORD-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 5));

        // 3. Insert bảng orders
        $stmt_order = $pdo->prepare("INSERT INTO orders (user_id, order_code, customer_name, phone, email, shipping_address, order_notes, total_amount, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'newest')");
        $stmt_order->execute([$user_id, $order_code, $name, $phone, $email, $address, $note, $total_amount]);
        $order_id = $pdo->lastInsertId();

        // 4. Insert bảng order_details VÀ TRỪ TỒN KHO
        $stmt_detail = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
        $stmt_deduct_stock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?"); // Lệnh trừ kho

        foreach ($cart_items as $item) {
            $stmt_detail->execute([$order_id, $item['product_id'], $item['quantity'], $item['selling_price']]);
            $stmt_deduct_stock->execute([$item['quantity'], $item['product_id']]); // Thực thi trừ kho
        }

        // 5. CHỈ xóa những sản phẩm đã đặt khỏi giỏ hàng
        $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id IN ($in_clause)")->execute([$user_id]);

        $pdo->commit();
        echo json_encode(['status' => 'success', 'message' => 'Đặt hàng thành công!', 'order_code' => $order_code]);

    } catch (Exception $e) {
        $pdo->rollBack(); // Hủy toàn bộ thao tác nếu có lỗi (Hết hàng, lỗi SQL...)
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}