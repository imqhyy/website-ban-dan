<?php
// 1. Cấu hình
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 5; 
$userId = $user['id'];

// 2. Lấy giá trị lọc từ URL
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$searchFilter = isset($_GET['search']) ? $_GET['search'] : '';

// 3. Xây dựng điều kiện WHERE cho cả việc ĐẾM và LẤY dữ liệu
$whereClause = "WHERE user_id = ?";
$params = [$userId];

if ($statusFilter !== 'all') {
    $whereClause .= " AND order_status = ?";
    $params[] = $statusFilter;
}

if (!empty($searchFilter)) {
    $whereClause .= " AND order_code LIKE ?";
    $params[] = "%$searchFilter%";
}

// 4. Tính TỔNG SỐ đơn hàng (đã bao gồm lọc) để phân trang chính xác
// Tính tổng số đơn hàng dựa trên ĐIỀU KIỆN ĐANG LỌC ($whereClause)
$sqlCount = "SELECT COUNT(*) as total FROM orders $whereClause";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute($params); // Dùng biến $params đã tạo ở trên
$resCount = $stmtCount->fetch();

$maxData = $resCount['total']; 
$maxPage = ceil($maxData / $perPage);

// 5. Tính toán Offset
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 6. Lấy danh sách đơn hàng thực tế
$sqlOrders = "SELECT * FROM orders $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
$orderStmt = $pdo->prepare($sqlOrders);
$orderStmt->execute($params);
$orders = $orderStmt->fetchAll();

// 7. Lấy riêng tổng số đơn hàng KHÔNG LỌC để hiển thị lên Badge menu nếu cần
$sqlTotal = "SELECT COUNT(*) FROM orders WHERE user_id = ?";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->execute([$userId]);
$totalAllOrders = $stmtTotal->fetchColumn();
?>