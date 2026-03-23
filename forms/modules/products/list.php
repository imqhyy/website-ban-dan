<?php
// 1. Lấy tham số từ URL
$brand = isset($_GET['brand']) ? $_GET['brand'] : null;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; //số lượng sản phẩm hiện thị mỗi trang
$maxPanigation = 4; //số lượng phân trang tối đa được hiển thị

// 2. Xây dựng điều kiện lọc (WHERE)
    //  2.1. Lấy mảng thương hiệu và loại đàn từ URL



    //  2.2. Xây dựng điều kiện lọc
$conditions = [];

// Lọc thương hiệu
$brand_ids = isset($_GET['brand']) ? (array)$_GET['brand'] : [];

if (!empty($brand_ids)) {
    // Nếu người dùng tích chọn checkbox ở trang all.php
    $ids = implode(',', array_map('intval', $brand_ids));
    $conditions[] = "p.brand_id IN ($ids)";
}  

//Lọc phân loại
// Lọc phân loại
$types = isset($_GET['type']) ? (array)$_GET['type'] : [];
// Lấy thêm biến product_type từ Nav menu
$nav_type = isset($_GET['product_type']) ? $_GET['product_type'] : null;

if (!empty($types)) {
    // Ưu tiên nếu người dùng tích chọn checkbox
    $type_list = "'" . implode("','", array_map('addslashes', $types)) . "'";
    $ids = implode(',', array_map('intval', $types)); 
    $conditions[] = "p.category_id IN ($ids)";
} elseif ($nav_type) {
    // Nếu không tích checkbox nhưng có giá trị từ Nav menu
    $conditions[] = "p.product_type = '" . addslashes($nav_type) . "'";
}

//Lọc giá
// Lấy giá trị từ URL và loại bỏ dấu chấm định dạng (ví dụ: 5.000.000 -> 5000000)
$raw_min = isset($_GET['min_price']) ? str_replace('.', '', $_GET['min_price']) : '';
$raw_max = isset($_GET['max_price']) ? str_replace('.', '', $_GET['max_price']) : '';

$min_price = ($raw_min !== '') ? (float)$raw_min : null;
$max_price = ($raw_max !== '') ? (float)$raw_max : null;

// Nếu có giá thấp nhất, thêm điều kiện >=
if ($min_price !== null) {
    $conditions[] = "p.selling_price >= $min_price";
}

// Nếu có giá cao nhất, thêm điều kiện <=
if ($max_price !== null) {
    $conditions[] = "p.selling_price <= $max_price";
}



// 2.3. Lọc theo từ khóa tìm kiếm (Search) trang search-result.php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    // Sử dụng addslashes để bảo mật và LIKE để tìm kiếm tương đối
    $search_safe = addslashes($search);
    $conditions[] = "(p.product_name LIKE '%$search_safe%' OR p.summary_description LIKE '%$search_safe%')";
}

// Lọc theo Dáng đàn
if (!empty($_GET['body_shape'])) {
    $conditions[] = "p.body_shape = '" . addslashes($_GET['body_shape']) . "'";
}

// Lọc theo Loại gỗ
if (!empty($_GET['wood_type'])) {
    $conditions[] = "p.wood_type = '" . addslashes($_GET['wood_type']) . "'";
}

// Lọc theo Cấu tạo
if (!empty($_GET['construction'])) {
    $conditions[] = "p.construction = '" . addslashes($_GET['construction']) . "'";
}

// Lọc theo Kích thước
if (!empty($_GET['product_size'])) {
    $conditions[] = "p.product_size = '" . addslashes($_GET['product_size']) . "'";
}

// Xử lý Sắp xếp (Cần thay đổi câu lệnh ORDER BY cuối file)
$order_by = "p.id DESC"; // Mặc định
if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':  $order_by = "p.selling_price ASC"; break;
        case 'price_desc': $order_by = "p.selling_price DESC"; break;
        case 'name_asc':   $order_by = "p.product_name ASC"; break;
        // Thêm trường hợp Z-A ở đây
        case 'name_desc':  $order_by = "p.product_name DESC"; break;
        default:           $order_by = "p.id DESC"; break;
    }
}
//Tạo điều kiện WHERE cho sql
$where = "";
if (!empty($conditions)) {
    $where = " WHERE " . implode(" AND ", $conditions);
}






// 3. Tính tổng số sản phẩm dựa trên bộ lọc
$sqlCount = "SELECT p.*, b.brand_name 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id " . $where;
$maxData = getRows($sqlCount); 
$maxPage = ceil($maxData / $perPage);

// 4. Kiểm tra tính hợp lệ của trang
if ($currentPage < 1) $currentPage = 1;
if ($currentPage > $maxPage && $maxPage > 0) $currentPage = $maxPage;
$offset = ($currentPage - 1) * $perPage;

// 5. Truy vấn dữ liệu: Lấy tất cả cột từ products và cột brand_name từ bảng brands
$sql = "SELECT p.*, b.brand_name, c.category_name 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN categories c ON p.category_id = c.id 
        $where 
        ORDER BY $order_by 
        LIMIT $perPage OFFSET $offset";
$products = getAll($sql); 
?>