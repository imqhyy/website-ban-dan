<?php
// admin/forms/ajax_settings.php
require_once(__DIR__ . '/init.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$adminUsername = $_SESSION['admin'] ?? '';
if (empty($adminUsername)) {
    echo json_encode(['status' => 'error', 'message' => 'Phiên đăng nhập không hợp lệ hoặc đã hết hạn!']);
    exit;
}

$title = $_POST['sale_title'] ?? '';
$date = $_POST['sale_end_date'] ?? '';
$desc = $_POST['sale_desc'] ?? '';

if (empty($title) || empty($date) || empty($desc)) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đủ tất cả các trường!']);
    exit;
}

try {
    // Upsert equivalent since we have preset rows
    $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'mega_sale_title'")->execute([$title]);
    $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'mega_sale_end_date'")->execute([$date]);
    $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'mega_sale_desc'")->execute([$desc]);
    
    echo json_encode(['status' => 'success', 'message' => 'Lưu cài đặt thành công!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi DB: ' . $e->getMessage()]);
}
?>
