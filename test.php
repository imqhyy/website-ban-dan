<?php
require_once 'forms/init.php';

// Truy vấn lấy danh sách sản phẩm
$stmt = $pdo->query("SELECT p.*, b.brand_name 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id ");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $product) {
    // 1. Lấy danh sách tên file ảnh từ DB
    $images = explode(',', $product['product_images']);

    // 2. Tạo đường dẫn thư mục (Dùng hàm create_slug đã viết trong db.php)
    $type_folder    = create_slug($product['product_type']);
    $brand_folder   = create_slug($product['brand_name']);
    $product_folder = create_slug($product['product_name']);

    // Kết hợp lại chuỗi đường dẫn thư mục
    $base_path = $guitarimg_direct . $type_folder . '/' . $brand_folder . '/' . $product_folder . '/';

    // 3. Xác định đường dẫn đầy đủ của 2 ảnh đầu tiên
    $main_img  = !empty($images[0]) ? $base_path . trim($images[0]) : 'assets/img/default.jpg';
    $hover_img = !empty($images[1]) ? $base_path . trim($images[1]) : $main_img;

    var_dump($product);
}
?>