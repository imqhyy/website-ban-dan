<?php
// 1. Tham số phân trang
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 2; // Số đơn hàng mỗi trang
$maxPanigation = 4;

// 2. Xây dựng điều kiện lọc (WHERE)
$conditions = [];
$params = [];

// Tìm kiếm mã đơn hàng
if (!empty($_GET['search'])) {
    $conditions[] = "order_code LIKE ?";
    $params[] = "%" . trim($_GET['search']) . "%";
}


// 1. Thêm lọc theo ID sản phẩm (Khi nhảy từ báo cáo sang)
if (!empty($_GET['product_id'])) {
    $p_id = (int)$_GET['product_id'];
    // Chỉ lấy đơn hàng có chứa sản phẩm này trong bảng chi tiết
    $conditions[] = "id IN (SELECT order_id FROM order_details WHERE product_id = ?)";
    $params[] = $p_id;
}

// 2. Nâng cấp Search: Tìm theo mã đơn hàng HOẶC tên sản phẩm
if (!empty($_GET['search'])) {
    $search_safe = trim($_GET['search']);
    // Xóa dòng tìm kiếm cũ và thay bằng dòng này để tìm được cả tên sản phẩm
    $conditions[] = "(order_code LIKE ? OR id IN (
        SELECT order_id FROM order_details od 
        JOIN products p ON od.product_id = p.id 
        WHERE p.product_name LIKE ?
    ))";
    $params[] = "%$search_safe%";
    $params[] = "%$search_safe%";
}

// Lọc theo ngày đặt
if (!empty($_GET['date_from'])) {
    $conditions[] = "created_at >= ?";
    $params[] = $_GET['date_from'] . " 00:00:00";
}
if (!empty($_GET['date_to'])) {
    $conditions[] = "created_at <= ?";
    $params[] = $_GET['date_to'] . " 23:59:59";
}

// Lọc theo trạng thái
if (!empty($_GET['order_status'])) {
    $conditions[] = "order_status = ?";
    $params[] = $_GET['order_status'];
}

// Lọc theo thành phố (Tìm chuỗi trong shipping_address)
if (!empty($_GET['city'])) {
    $conditions[] = "shipping_address LIKE ?";
    $params[] = "%" . trim($_GET['city']) . "%";
}

// Lọc theo phường/xã (Tìm chuỗi trong shipping_address)
if (!empty($_GET['ward'])) {
    $conditions[] = "shipping_address LIKE ?";
    $params[] = "%" . trim($_GET['ward']) . "%";
}

$where = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

// 3. Tính tổng số đơn hàng để phân trang
$sqlCount = "SELECT COUNT(*) as total FROM orders $where";
$totalOrders = getOne($sqlCount, $params)['total'];
$maxPage = ceil($totalOrders / $perPage);

if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 4. Truy vấn danh sách đơn hàng
$sql = "SELECT * FROM orders $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
$orders = getAll($sql, $params);
?>