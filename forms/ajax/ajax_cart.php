<?php
require_once '../init.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để thêm vào giỏ.']);
    exit();
}

global $pdo;

$session_user = is_array($_SESSION['user']) ? $_SESSION['user']['id'] : $_SESSION['user'];
$user_id = $session_user;

// Nếu session là chuỗi tên đăng nhập, ta query lấy ID thật
if (!is_numeric($session_user)) {
    // LƯU Ý: Giả định cột tên đăng nhập trong bảng users là 'username'. 
    // Nếu DB của bạn dùng tên khác (vd: 'tai_khoan'), hãy sửa lại chữ 'username' ở câu SQL dưới.
    $stmt_user = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt_user->execute([$session_user]);
    $u = $stmt_user->fetch();

    if ($u) {
        $user_id = $u['id'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy ID người dùng.']);
        exit();
    }
}

$action = $_POST['action'] ?? '';
$product_id = (int) ($_POST['product_id'] ?? 0);
$quantity = (int) ($_POST['quantity'] ?? 1);

if (!$action || !$product_id) {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ.']);
    exit();
}

try {
    switch ($action) {
        case 'add':
            // 1. Kiểm tra tồn kho của sản phẩm
            $stmt_stock = $pdo->prepare("SELECT stock_quantity, product_name, status FROM products WHERE id = ?");
            $stmt_stock->execute([$product_id]);
            $product_info = $stmt_stock->fetch();

            if (!$product_info || $product_info['status'] === 'hidden') {
                echo json_encode(['status' => 'error', 'message' => "Sản phẩm này hiện đang ẩn hoặc ngừng kinh doanh."]);
                exit();
            }

            $max_stock = $product_info['stock_quantity'];

            // 2. Kiểm tra xem sản phẩm đã có trong giỏ chưa
            $stmt_check = $pdo->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt_check->execute([$user_id, $product_id]);
            $item = $stmt_check->fetch();

            if ($item) {
                $new_qty = $item['quantity'] + $quantity;
                if ($new_qty > $max_stock) {
                    echo json_encode(['status' => 'error', 'message' => "Rất tiếc, chỉ còn $max_stock sản phẩm '" . $product_info['product_name'] . "' trong kho."]);
                    exit();
                }
                $update = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $update->execute([$new_qty, $user_id, $product_id]);
                echo json_encode(['status' => 'success', 'message' => 'Đã thêm vào giỏ hàng!', 'is_new_item' => false]);
            } else {
                if ($quantity > $max_stock) {
                    echo json_encode(['status' => 'error', 'message' => "Rất tiếc, chỉ còn $max_stock sản phẩm '" . $product_info['product_name'] . "' trong kho."]);
                    exit();
                }
                $insert = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $insert->execute([$user_id, $product_id, $quantity]);
                echo json_encode(['status' => 'success', 'message' => 'Đã thêm vào giỏ hàng!', 'is_new_item' => true]);
            }
            break;

        case 'update':
            $update = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $update->execute([$quantity, $user_id, $product_id]);
            echo json_encode(['status' => 'success']);
            break;

        case 'remove':
            $delete = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $delete->execute([$user_id, $product_id]);
            echo json_encode(['status' => 'success', 'message' => 'Đã xóa sản phẩm.']);
            break;

        case 'buy_now':
            // 1. Kiểm tra tồn kho của sản phẩm trước khi cho phép Mua Ngay
            $stmt_stock = $pdo->prepare("SELECT stock_quantity, product_name, status FROM products WHERE id = ?");
            $stmt_stock->execute([$product_id]);
            $product_info = $stmt_stock->fetch();

            if (!$product_info || $product_info['status'] === 'hidden') {
                echo json_encode(['status' => 'error', 'message' => "Sản phẩm này hiện đang ẩn hoặc ngừng kinh doanh."]);
                exit();
            }

            $max_stock = $product_info['stock_quantity'];

            // 2. Chặn ngay nếu khách mua vượt quá số lượng kho
            if ($quantity > $max_stock) {
                echo json_encode(['status' => 'error', 'message' => "Rất tiếc, chỉ còn $max_stock sản phẩm '" . $product_info['product_name'] . "' trong kho."]);
                exit();
            }

            // 3. Nếu hợp lệ thì mới lưu tạm vào Session
            $_SESSION['buy_now_item'] = [
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
            echo json_encode(['status' => 'success']);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
?>