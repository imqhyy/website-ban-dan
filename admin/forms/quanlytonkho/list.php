<?php
// --- Nội dung file admin/forms/quanlytonkho/list.php ---

// 1. Cấu hình phân trang
$perPage = 10; // Huy muốn hiện 10 sản phẩm mỗi trang
$maxPanigation = 4; // Số lượng nút bấm tối đa hiển thị
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($currentPage < 1) $currentPage = 1;

// 2. Tính toán dựa trên mảng $displayData đã được tính ở trang chính
$totalItems = count($displayData);
$maxPage = ceil($totalItems / $perPage);

if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 3. Cắt mảng để lấy đúng 10 sản phẩm cho trang hiện tại
$pagedData = array_slice($displayData, $offset, $perPage);
?>