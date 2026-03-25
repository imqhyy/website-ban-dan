<?php
ob_start();
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
    jsonOut(['status' => 'error', 'message' => 'Vui lòng đăng nhập!']);
}

$sessionUser = is_array($_SESSION['user']) ? ($_SESSION['user']['id'] ?? null) : $_SESSION['user'];
if (!$sessionUser) {
    jsonOut(['status' => 'error', 'message' => 'Vui lòng đăng nhập!']);
}

// Lấy user_id
if (is_numeric($sessionUser)) {
    $userId = (int)$sessionUser;
} else {
    $userRow = getOne("SELECT id FROM users WHERE username = ? LIMIT 1", [$sessionUser]);
    if (!$userRow) jsonOut(['status' => 'error', 'message' => 'Không tìm thấy tài khoản!']);
    $userId = (int)$userRow['id'];
}

$action = strtolower(trim($_POST['action'] ?? ''));
$reviewId = (int)($_POST['review_id'] ?? 0);

if ($reviewId <= 0 || empty($action)) {
    jsonOut(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ!']);
}

// Kiểm tra quyền sở hữu review
$review = getOne("SELECT * FROM reviews WHERE id = ? AND user_id = ?", [$reviewId, $userId]);
if (!$review) {
    jsonOut(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện hành động này!']);
}

if ($action === 'delete') {
    try {
        $pdo->prepare("DELETE FROM reviews WHERE id = ?")->execute([$reviewId]);
        jsonOut(['status' => 'success', 'message' => 'Đã xoá đánh giá!']);
    } catch (PDOException $e) {
        jsonOut(['status' => 'error', 'message' => 'Lỗi DB: ' . $e->getMessage()]);
    }
} elseif ($action === 'update') {
    $comment = trim($_POST['comment'] ?? '');
    $rating      = (int)($_POST['rating'] ?? 0);
    $soundRating = (int)($_POST['sound_rating'] ?? 0);
    $specsRating = (int)($_POST['specs_rating'] ?? 0);

    if (mb_strlen($comment) < 15) {
        jsonOut(['status' => 'error', 'message' => 'Nội dung đánh giá phải có tối thiểu 15 ký tự!']);
    }
    if ($rating < 1 || $rating > 5) $rating = $review['rating'];
    if ($soundRating < 1 || $soundRating > 5) $soundRating = $review['sound_rating'];
    if ($specsRating < 1 || $specsRating > 5) $specsRating = $review['specs_rating'];

    // --- Xử lý ảnh ---
    $currentImages = array_filter(explode(',', $review['image_path'] ?? ''), function($p) { return trim($p) !== ''; });

    // 1. Xoá ảnh cũ
    $removedImages = json_decode($_POST['removed_images'] ?? '[]', true);
    if (!empty($removedImages)) {
        foreach ($removedImages as $rmPath) {
            $rmPath = trim($rmPath);
            $fullPath = __DIR__ . '/../../' . $rmPath;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
            $currentImages = array_filter($currentImages, function($p) use ($rmPath) {
                return trim($p) !== $rmPath;
            });
        }
    }

    // 2. Upload ảnh mới
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = __DIR__ . '/../../assets/img/reviews/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) continue;
            $ext = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) continue;
            $fileName = 'review_' . $userId . '_' . $review['product_id'] . '_' . time() . '_' . $key . '.' . $ext;
            if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
                $currentImages[] = 'assets/img/reviews/' . $fileName;
            }
        }
    }

    $newImagePath = implode(',', array_values($currentImages));

    try {
        $pdo->prepare("UPDATE reviews SET comment = ?, rating = ?, sound_rating = ?, specs_rating = ?, image_path = ? WHERE id = ?")
            ->execute([$comment, $rating, $soundRating, $specsRating, $newImagePath, $reviewId]);
        jsonOut(['status' => 'success', 'message' => 'Đã cập nhật đánh giá!', 'image_path' => $newImagePath]);
    } catch (PDOException $e) {
        jsonOut(['status' => 'error', 'message' => 'Lỗi DB: ' . $e->getMessage()]);
    }
} else {
    jsonOut(['status' => 'error', 'message' => 'Hành động không hợp lệ!']);
}
