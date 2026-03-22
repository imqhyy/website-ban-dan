<?php
// 1. Cấu hình phân trang
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10; // Admin thường hiện nhiều dòng hơn (10 dòng/trang)
$maxPanigation = 4; 

// 2. Xây dựng điều kiện lọc (WHERE)
$conditions = [];

// 2.1. Lọc theo Phân loại (từ ô select id="filter-product-type")
if (!empty($_GET['product_type'])) {
    $conditions[] = "p.product_type = '" . addslashes($_GET['product_type']) . "'";
}

// 2.2. Lọc theo Thương hiệu (từ ô select id="filter-product-brand")
if (!empty($_GET['brand_id'])) {
    $conditions[] = "p.brand_id = " . (int)$_GET['brand_id'];
}

// 2.3. Lọc theo từ khóa tìm kiếm (Search)
if (!empty($_GET['search'])) {
    $search_safe = addslashes(trim($_GET['search']));
    $conditions[] = "(p.product_name LIKE '%$search_safe%' OR p.id LIKE '%$search_safe%')";
}

$where = "";
if (!empty($conditions)) {
    $where = " WHERE " . implode(" AND ", $conditions);
}

// 3. Tính tổng số sản phẩm dựa trên bộ lọc để phân trang
$sqlCount = "SELECT COUNT(*) as total FROM products p " . $where;
$countResult = getOne($sqlCount); 
$maxData = $countResult['total'];
$maxPage = ceil($maxData / $perPage);

// 4. Kiểm tra tính hợp lệ của trang
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 5. Truy vấn dữ liệu sản phẩm kèm tên thương hiệu
$sql = "SELECT p.*, b.brand_name 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        $where 
        ORDER BY p.id DESC 
        LIMIT $perPage OFFSET $offset";

$all_products = getAll($sql); 
?>