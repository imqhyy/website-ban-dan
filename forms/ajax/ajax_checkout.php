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

    $checkout_type = $_POST['checkout_type'] ?? 'cart';
    $in_clause = ''; // Khởi tạo biến rỗng để xíu nữa dùng không bị lỗi

    try {
        $pdo->beginTransaction();
        $cart_items = [];

        // 1. KIỂM TRA LUỒNG DỮ LIỆU
        if ($checkout_type === 'buynow' && isset($_SESSION['buy_now_item'])) {
            // Luồng 1: Mua ngay (Lấy từ Session)
            $p_id = (int) $_SESSION['buy_now_item']['product_id'];
            $p_qty = (int) $_SESSION['buy_now_item']['quantity'];

            $stmt_prod = $pdo->prepare("SELECT p.id as product_id, p.product_name, p.selling_price, p.discount_percent, p.stock_quantity, p.status FROM products p WHERE p.id = ? FOR UPDATE");
            $stmt_prod->execute([$p_id]);
            $prod = $stmt_prod->fetch();

            if (!$prod || $prod['status'] === 'hidden') {
                throw new Exception("Sản phẩm không tồn tại.");
            }

            $prod['quantity'] = $p_qty;
            $cart_items[] = $prod;

        } else {
            // Luồng 2: Thanh toán từ Giỏ hàng (Lấy từ Database)
            $selected_items = $_POST['selected_items'] ?? '';
            $item_ids = array_filter(explode(',', $selected_items), 'is_numeric');

            if (empty($item_ids)) {
                throw new Exception("Không có sản phẩm nào được chọn.");
            }

            $in_clause = implode(',', $item_ids);

            $stmt_cart = $pdo->prepare("
                SELECT c.quantity, p.selling_price, p.discount_percent, p.id as product_id, p.product_name, p.stock_quantity, p.status 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ? AND p.id IN ($in_clause) FOR UPDATE
            ");
            $stmt_cart->execute([$user_id]);
            $cart_items = $stmt_cart->fetchAll();

            if (empty($cart_items)) {
                throw new Exception("Giỏ hàng trống.");
            }
        }

        // 2. TÍNH TOÁN TIỀN VÀ KIỂM TRA KHO
        $total_amount = 0;
        foreach ($cart_items as &$item) {
            if ($item['status'] === 'hidden') {
                throw new Exception("Sản phẩm '" . $item['product_name'] . "' không tồn tại hoặc đã ngừng kinh doanh. Vui lòng cập nhật lại.");
            }
            if ($item['quantity'] > $item['stock_quantity']) {
                throw new Exception("Rất tiếc, sản phẩm '" . $item['product_name'] . "' hiện chỉ còn " . $item['stock_quantity'] . " chiếc trong kho.");
            }

            // Tính toán giá trị để insert vào DB
            $original_price = $item['selling_price'];
            $discount = $item['discount_percent'] ?? 0;
            $actual_price = ($discount > 0) ? $original_price * (1 - ($discount / 100)) : $original_price;

            $item['actual_price'] = $actual_price;
            $item['original_price'] = $original_price;
            $item['discount_percent'] = $discount;

            $total_amount += $actual_price * $item['quantity'];
        }
        unset($item);

        // 3. TẠO ĐƠN HÀNG VÀO DATABASE
        $order_code = 'ORD-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 5));

        $stmt_order = $pdo->prepare("INSERT INTO orders (user_id, order_code, customer_name, phone, email, shipping_address, order_notes, total_amount, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'newest')");
        $stmt_order->execute([$user_id, $order_code, $name, $phone, $email, $address, $note, $total_amount]);
        $order_id = $pdo->lastInsertId();

        $stmt_detail = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, original_price, discount_percent, unit_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_deduct_stock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");

        foreach ($cart_items as $item) {
            $stmt_detail->execute([
                $order_id,
                $item['product_id'],
                $item['quantity'],
                $item['original_price'],
                $item['discount_percent'],
                $item['actual_price']
            ]);
            $stmt_deduct_stock->execute([$item['quantity'], $item['product_id']]);
        }

        // 4. DỌN DẸP DỮ LIỆU SAU KHI ĐẶT (QUAN TRỌNG)
        if ($checkout_type === 'buynow') {
            unset($_SESSION['buy_now_item']); // Nếu mua ngay thì xóa rác trong Session
        } else {
            // Nếu từ giỏ hàng thì mới xóa hàng trong DB cart
            $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id IN ($in_clause)")->execute([$user_id]);
        }

        $pdo->commit();
        echo json_encode(['status' => 'success', 'message' => 'Đặt hàng thành công!', 'order_code' => $order_code]);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}