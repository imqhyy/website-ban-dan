<?php
// Đường dẫn chuẩn từ admin/forms/danhmucsanpham/ ra gốc rồi vào forms/database.php
require_once __DIR__ . "/../../../forms/database.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// --- 1. Lấy thương hiệu & Lợi nhuận mặc định ---
if ($action === 'get_brands_by_category') {
    $category_name = $_GET['category_name'] ?? '';
    
    $sql = "SELECT b.id, b.brand_name, bc.brand_profit AS profit_margin 
            FROM brands b
            JOIN brand_category bc ON b.id = bc.brand_id
            JOIN categories c ON bc.category_id = c.id
            WHERE c.category_name = " . $pdo->quote($category_name);
            
    $brands = getAll($sql);
    echo json_encode($brands);
    exit;
}

// --- 2. Xử lý THÊM SẢN PHẨM ---
if ($action === 'add_product') {
    try {
        $p_name = $_POST['product_name'];
        $p_type = $_POST['product_type'];
        $brand_id = (int)$_POST['brand_id'];

        // Lấy tên thương hiệu để làm folder
        $brand_info = getOne("SELECT brand_name FROM brands WHERE id = $brand_id");
        $b_name = $brand_info['brand_name'];

        // 1. Tạo Slug cho Phân loại, Thương hiệu và Tên sản phẩm
        $type_slug    = create_slug($p_type);
        $brand_slug   = create_slug($b_name);
        $product_slug = create_slug($p_name);

        // 2. CẬP NHẬT ĐƯỜNG DẪN: Thêm {$product_slug} vào cuối cùng
        // Đường dẫn mong muốn: assets/img/products/guitar/guitar-acoustic/saga/jack/
        $relative_path = "assets/img/products/guitar/{$type_slug}/{$brand_slug}/{$product_slug}/";

        // 3. Xác định đường dẫn vật lý trên server để tạo thư mục
        $upload_dir = __DIR__ . "/../../../" . $relative_path;

        // 4. Tạo thư mục đa cấp (recursive = true)
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Xử lý đổi tên ảnh theo số thứ tự 1-6
        $uploaded_images = [];
        if (!empty($_FILES['product_images']['name'][0])) {
            foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
                if ($key < 6) { 
                    $ext = pathinfo($_FILES['product_images']['name'][$key], PATHINFO_EXTENSION);
                    $new_file_name = "{$product_slug}-" . ($key + 1) . ".{$ext}";
                    if (move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
                        $uploaded_images[] = $new_file_name;
                    }
                }
            }
        }
        $images_string = implode(',', $uploaded_images);

        // Lưu Database
        $sql = "INSERT INTO products (
                    product_name, product_type, brand_id, product_images, 
                    summary_description, detailed_overview, profit_margin, discount_percent, accessories,
                    highlight_1_title, highlight_1_content, highlight_2_title, highlight_2_content,
                    highlight_3_title, highlight_3_content, highlight_4_title, highlight_4_content
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $p_name, $p_type, $brand_id, $images_string,
            $_POST['summary_description'], $_POST['detailed_overview'],
            $_POST['profit_margin'], $_POST['discount_percent'], 
            json_encode(array_filter(array_map('trim', explode("\n", $_POST['accessories']))), JSON_UNESCAPED_UNICODE),
            $_POST['h1_t'], $_POST['h1_c'], $_POST['h2_t'], $_POST['h2_c'],
            $_POST['h3_t'], $_POST['h3_c'], $_POST['h4_t'], $_POST['h4_c']
        ]);

        echo "success";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    exit;
}