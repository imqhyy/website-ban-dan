<?php
ob_start(); // bắt mọi output lạ (PHP warnings, notices, v.v.)
require_once __DIR__ . '/../../forms/init.php';
header('Content-Type: application/json');

function jsonOut($arr) {
    ob_clean();
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonOut(['status' => 'error', 'message' => 'Invalid method']);
}

if (!isset($_SESSION['user'])) {
    jsonOut(['status' => 'error', 'message' => 'Vui lòng đăng nhập để đánh giá!']);
}
// Session lưu username (string) hoặc array — cần lấy id thực từ DB
$sessionUser = is_array($_SESSION['user']) ? ($_SESSION['user']['id'] ?? null) : $_SESSION['user'];
if (!$sessionUser) {
    jsonOut(['status' => 'error', 'message' => 'Vui lòng đăng nhập để đánh giá!']);
}

// Nếu là số → dùng luôn, nếu là username → query lấy id
if (is_numeric($sessionUser)) {
    $userId = (int)$sessionUser;
} else {
    $userRow = getOne("SELECT id FROM users WHERE username = ? LIMIT 1", [$sessionUser]);
    if (!$userRow) jsonOut(['status' => 'error', 'message' => 'Không tìm thấy tài khoản!']);
    $userId = (int)$userRow['id'];
}

$productId   = (int)($_POST['product_id'] ?? 0);
$rating      = (int)($_POST['rating'] ?? 5);
$soundRating = (int)($_POST['sound_rating'] ?? 5);
$specsRating = (int)($_POST['specs_rating'] ?? 5);
$comment     = trim($_POST['comment'] ?? '');

if ($productId <= 0 || $rating < 1 || $rating > 5) {
    jsonOut(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ!']);
}
if (mb_strlen($comment) < 15) {
    jsonOut(['status' => 'error', 'message' => 'Cảm nhận phải có tối thiểu 15 ký tự!']);
}

// Kiểm tra đã review chưa
$existing = getOne("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?", [$productId, $userId]);
if ($existing) {
    jsonOut(['status' => 'error', 'message' => 'Bạn đã đánh giá sản phẩm này rồi!']);
}

// Kiểm tra đã mua hàng chưa
$isPurchased = 0;
try {
    $purchased = getOne("
        SELECT od.id FROM order_details od
        JOIN orders o ON od.order_id = o.id
        WHERE o.user_id = ? AND od.product_id = ? AND o.order_status = 'completed'
        LIMIT 1
    ", [$userId, $productId]);
    $isPurchased = $purchased ? 1 : 0;
} catch (Exception $e) {
    $isPurchased = 0; // không crash nếu bảng chưa có
}

// Xử lý upload nhiều ảnh (tối đa 3)
$imagePaths = [];
if (!empty($_FILES['images']['name'][0])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $uploadDir = __DIR__ . '/../../assets/img/reviews/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $fileCount = min(count($_FILES['images']['name']), 3);
    for ($i = 0; $i < $fileCount; $i++) {
        if ($_FILES['images']['error'][$i] !== 0) continue;
        $fileType = $_FILES['images']['type'][$i];
        if (!in_array($fileType, $allowedTypes)) continue;
        $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
        $filename = 'review_' . $userId . '_' . $productId . '_' . time() . '_' . $i . '.' . $ext;
        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadDir . $filename)) {
            $imagePaths[] = 'assets/img/reviews/' . $filename;
        }
    }
}
$imagePath = !empty($imagePaths) ? implode(',', $imagePaths) : null;

try {
    $pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, sound_rating, specs_rating, comment, image_path, is_purchased)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
        ->execute([$productId, $userId, $rating, $soundRating, $specsRating, $comment, $imagePath, $isPurchased]);
    jsonOut(['status' => 'success', 'message' => 'Cảm ơn bạn đã đánh giá!']);
} catch (PDOException $e) {
    jsonOut(['status' => 'error', 'message' => 'Lỗi khi lưu: ' . $e->getMessage()]);
}
