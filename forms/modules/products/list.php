<?php
// 1. Lấy tham số từ URL
$brand = isset($_GET['brand']) ? $_GET['brand'] : null;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; 

// 2. Xây dựng điều kiện lọc (WHERE)
$where = "";
if ($brand) {
    // Giả sử cột thương hiệu trong DB của bạn là 'brand_name'
    $where = " WHERE brand_name = '$brand'"; 
}

// 3. Tính tổng số sản phẩm dựa trên bộ lọc
$sqlCount = "SELECT * FROM products" . $where;
$maxData = getRows($sqlCount); 
$maxPage = ceil($maxData / $perPage);

// 4. Kiểm tra tính hợp lệ của trang
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 5. Truy vấn dữ liệu cuối cùng
$sql = "SELECT * FROM products $where ORDER BY id DESC LIMIT $perPage OFFSET $offset";
$products = getAll($sql); 
?>