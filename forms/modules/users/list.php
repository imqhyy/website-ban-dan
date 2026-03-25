<?php
// 1. Cấu hình các thông số cơ bản
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 2;         // Số đơn hàng hiển thị mỗi trang
$maxPanigation = 4;   // Số nút trang tối đa hiển thị

// 2. Lấy ID người dùng (biến $user đã được định nghĩa trong account.php)
$userId = $user['id'];

// 3. Tính tổng số đơn hàng của người dùng này
$sqlCount = "SELECT COUNT(*) as total FROM orders WHERE user_id = ?";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute([$userId]);
$resCount = $stmtCount->fetch();

$maxData = $resCount['total']; 
$maxPage = ceil($maxData / $perPage);

// 4. Kiểm tra tính hợp lệ của trang hiện tại
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 5. Truy vấn lấy danh sách đơn hàng theo trang
$sqlOrders = "SELECT * FROM orders 
              WHERE user_id = ? 
              ORDER BY created_at DESC 
              LIMIT $perPage OFFSET $offset";
$orderStmt = $pdo->prepare($sqlOrders);
$orderStmt->execute([$userId]);
$orders = $orderStmt->fetchAll(); // Biến $orders này sẽ được dùng để loop trong account.php
?>