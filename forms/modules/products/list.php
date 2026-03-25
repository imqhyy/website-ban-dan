<?php
// 1. Lấy tham số từ URL
$brand = isset($_GET['brand']) ? $_GET['brand'] : null;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; //số lượng sản phẩm hiện thị mỗi trang
$maxPanigation = 4; //số lượng phân trang tối đa được hiển thị

// 2. Xây dựng điều kiện lọc (WHERE)
    //  2.1. Lấy mảng thương hiệu và loại đàn từ URL



// 2.2. Xây dựng điều kiện lọc BẮT BUỘC (Trạng thái hiển thị)
$conditions = [];
$conditions[] = "p.status = 'visible'";
$conditions[] = "c.status = 'visible'";
$conditions[] = "b.status = 'visible'";

// --- Các bộ lọc từ người dùng (Giữ nguyên logic của bạn nhưng thêm vào mảng $conditions) ---

// Lọc thương hiệu
$brand_ids = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
if (!empty($brand_ids)) {
    $ids = implode(',', array_map('intval', $brand_ids));
    $conditions[] = "p.brand_id IN ($ids)";
}  

// Lọc phân loại
$types = isset($_GET['type']) ? (array)$_GET['type'] : [];
// BỔ SUNG: Lấy tên phân loại từ trang category_detail
$nav_type = isset($_GET['product_type']) ? $_GET['product_type'] : null;

if (!empty($types)) {
    // Nếu lọc qua checkbox (ID)
    $ids = implode(',', array_map('intval', $types)); 
    $conditions[] = "p.category_id IN ($ids)";
} elseif ($nav_type) {
    // Nếu lọc qua menu/đường dẫn (Tên phân loại)
    $conditions[] = "c.category_name = '" . addslashes($nav_type) . "'";
}

// Lọc giá
$raw_min = isset($_GET['min_price']) ? str_replace('.', '', $_GET['min_price']) : '';
$raw_max = isset($_GET['max_price']) ? str_replace('.', '', $_GET['max_price']) : '';
if ($raw_min !== '') $conditions[] = "p.selling_price >= " . (float)$raw_min;
if ($raw_max !== '') $conditions[] = "p.selling_price <= " . (float)$raw_max;

// Lọc tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $search_safe = addslashes($search);
    $conditions[] = "(p.product_name LIKE '%$search_safe%' OR p.summary_description LIKE '%$search_safe%')";
}

// --- BỔ SUNG: Lọc theo chương trình ưu đãi (Tất cả / Giảm giá) ---
$filter_promo = isset($_GET['filter_promo']) ? $_GET['filter_promo'] : 'all';

if ($filter_promo === 'discount') {
    // Chỉ lấy sản phẩm có phần trăm giảm giá lớn hơn 0
    $conditions[] = "p.discount_percent > 0";
}
// Nếu là 'all' thì không cần thêm điều kiện vì mặc định đã lấy hết sản phẩm visible

// Gộp tất cả thành điều kiện WHERE
$where = " WHERE " . implode(" AND ", $conditions);

// --- Xử lý sắp xếp ---
$order_by = "p.id DESC";
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':  $order_by = "p.selling_price ASC"; break;
        case 'price_desc': $order_by = "p.selling_price DESC"; break;
        case 'name_asc':   $order_by = "p.product_name ASC"; break;
        case 'name_desc':  $order_by = "p.product_name DESC"; break;
    }
}

// 3. Tính tổng số sản phẩm (Phải dùng JOIN để lọc đúng status cha)
$sqlCount = "SELECT COUNT(*) as total 
             FROM products p 
             JOIN categories c ON p.category_id = c.id
             JOIN brands b ON p.brand_id = b.id " . $where;
$resCount = getOne($sqlCount);
$maxData = $resCount['total']; 
$maxPage = ceil($maxData / $perPage);

// 4. Kiểm tra tính hợp lệ của trang
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 5. Truy vấn lấy dữ liệu cuối cùng (Kết hợp cả status và bộ lọc)
$sql = "SELECT p.*, c.category_name, b.brand_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN brands b ON p.brand_id = b.id
        $where
        ORDER BY $order_by
        LIMIT $perPage OFFSET $offset";

$products = getAll($sql);