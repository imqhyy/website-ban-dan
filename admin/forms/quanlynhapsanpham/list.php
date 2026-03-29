<?php
// 1. Lấy tham số từ URL
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 5; // Số lượng phiếu mỗi trang
$maxPagination = 4; // Số lượng nút phân trang tối đa hiển thị

// 2. Xây dựng điều kiện lọc (WHERE)
$conditions = [];
$params = [];

// Lọc theo mã phiếu HOẶC tên sản phẩm (Search)
if (!empty($_GET['search'])) {
    $search_safe = trim($_GET['search']);
    // Logic: Tìm mã phiếu trực tiếp HOẶC tìm phiếu có chứa sản phẩm có tên tương ứng
    $conditions[] = "(receipt_code LIKE ? OR id IN (
        SELECT receipt_id FROM import_receipt_details ird 
        JOIN products p ON ird.product_id = p.id 
        WHERE p.product_name LIKE ?
    ))";
    $params[] = "%$search_safe%";
    $params[] = "%$search_safe%";
}

// Lọc theo ID sản phẩm cụ thể (Khi nhảy từ báo cáo sang)
if (!empty($_GET['product_id'])) {
    $p_id = (int)$_GET['product_id'];
    $conditions[] = "id IN (SELECT receipt_id FROM import_receipt_details WHERE product_id = ?)";
    $params[] = $p_id;
}

// Lọc theo khoảng ngày
if (!empty($_GET['date_from'])) {
    $conditions[] = "import_date >= ?";
    $params[] = $_GET['date_from'];
}
if (!empty($_GET['date_to'])) {
    $conditions[] = "import_date <= ?";
    $params[] = $_GET['date_to'];
}

// Tạo câu lệnh WHERE
$where = "";
if (!empty($conditions)) {
    $where = " WHERE " . implode(" AND ", $conditions);
}

// Xử lý sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$order_by = ($sort === 'oldest') ? "import_date ASC, id ASC" : "import_date DESC, id DESC";

// 3. Tính tổng số phiếu để phân trang
$sqlCount = "SELECT COUNT(*) as total FROM import_receipts $where";
$totalData = getOne($sqlCount, $params)['total']; 
$maxPage = ceil($totalData / $perPage);

// 4. Kiểm tra tính hợp lệ của trang
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 5. Truy vấn dữ liệu phiếu nhập
$sql = "SELECT * FROM import_receipts 
        $where 
        ORDER BY $order_by 
        LIMIT $perPage OFFSET $offset";
$receipts = getAll($sql, $params); 
?>