<?php
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

// --- 2. Xử lý THÊM SẢN PHẨM (BẢN FIX LỖI $stmt) ---
if ($action === 'add_product') {
    try {
        $p_name = $_POST['product_name'];
        $p_type = $_POST['product_type'];
        $brand_id = (int) $_POST['brand_id'];

        // Lấy tên thương hiệu để tạo slug thư mục
        $brand_info = getOne("SELECT brand_name FROM brands WHERE id = $brand_id");
        $b_name = $brand_info['brand_name'];

        $type_slug = create_slug($p_type);
        $brand_slug = create_slug($b_name);
        $product_slug = create_slug($p_name);

        $relative_path = "assets/img/products/guitar/{$type_slug}/{$brand_slug}/{$product_slug}/";
        $upload_dir = __DIR__ . "/../../../" . $relative_path;

        if (!file_exists($upload_dir))
            mkdir($upload_dir, 0777, true);

        // Xử lý upload ảnh (tối đa 6 ảnh)
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

        // ĐỊNH NGHĨA $acc_json (Trước đó Huy bị thiếu dòng này)
        $acc_lines = array_values(array_filter(array_map('trim', explode("\n", $_POST['accessories'] ?? ''))));
        $acc_json = json_encode(['fixed' => $acc_lines, 'others' => ''], JSON_UNESCAPED_UNICODE);

        $sql = "INSERT INTO products (product_name, product_type, brand_id, product_images, summary_description, detailed_overview, profit_margin, discount_percent, accessories, highlight_1_title, highlight_1_content, highlight_2_title, highlight_2_content, highlight_3_title, highlight_3_content, highlight_4_title, highlight_4_content) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // CHÈN THÊM DÒNG PREPARE (Đây là dòng Huy bị thiếu gây lỗi Fatal error)
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $p_name,
            $p_type,
            $brand_id,
            $images_string,
            $_POST['summary_description'] ?? '',
            $_POST['detailed_overview'] ?? '',
            $_POST['profit_margin'] ?? 0,
            $_POST['discount_percent'] ?? 0,
            $acc_json,
            $_POST['highlight_1_title'] ?? '',
            $_POST['highlight_1_content'] ?? '',
            $_POST['highlight_2_title'] ?? '',
            $_POST['highlight_2_content'] ?? '',
            $_POST['highlight_3_title'] ?? '',
            $_POST['highlight_3_content'] ?? '',
            $_POST['highlight_4_title'] ?? '',
            $_POST['highlight_4_content'] ?? ''
        ]);

        echo "success";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    exit;
}

// --- 3. AJAX TẢI LẠI DANH SÁCH (BỘ LỌC + PHÂN TRANG) ---
if ($action === 'fetch_list') {
    // Logic tương tự list_admin.php nhưng trả về chuỗi HTML
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $perPage = 10;
    $conditions = [];

    if (!empty($_GET['product_type']))
        $conditions[] = "p.product_type = " . $pdo->quote($_GET['product_type']);
    if (!empty($_GET['brand_id']))
        $conditions[] = "p.brand_id = " . (int) $_GET['brand_id'];
    if (!empty($_GET['search'])) {
        $search = $pdo->quote('%' . trim($_GET['search']) . '%');
        $conditions[] = "(p.product_name LIKE $search OR p.id LIKE $search)";
    }

    $where = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

    $maxData = getOne("SELECT COUNT(*) as total FROM products p $where")['total'];
    $maxPage = ceil($maxData / $perPage);
    $currentPage = max(1, min($currentPage, $maxPage));
    $offset = ($currentPage - 1) * $perPage;

    $products = getAll("SELECT p.*, b.brand_name FROM products p LEFT JOIN brands b ON p.brand_id = b.id $where ORDER BY p.id DESC LIMIT $perPage OFFSET $offset");

    // Tạo HTML cho bảng
    $tableHtml = "";
    if (empty($products)) {
        $tableHtml = "<tr><td colspan='8' class='text-center'>Không tìm thấy sản phẩm.</td></tr>";
    } else {
        foreach ($products as $p) {
            $type = str_replace('Guitar ', '', htmlspecialchars($p['product_type']));
            $tableHtml .= "<tr>
                <td>{$p['id']}</td>
                <td>" . htmlspecialchars($p['product_name']) . "</td>
                <td>$type</td>
                <td>" . htmlspecialchars($p['brand_name'] ?? 'N/A') . "</td>
                <td>Đang cập nhật...</td>
                <td>" . (float) $p['profit_margin'] . "%</td>
                <td>Đang cập nhật...</td>
                <td class='function-button-container'>
                    <button class='action-icon-btn edit-product-btn' title='Sửa' data-id='{$p['id']}'><i class='bi bi-pencil-square' style='color: #ffc107;'></i></button>
                    <button class='action-icon-btn hide-btn' title='Ẩn'><i class='bi bi-eye'></i></button>
                    <button class='action-icon-btn delete-product-btn' title='Xóa' data-id='{$p['id']}'><i class='bi bi-trash3 text-danger'></i></button>
                </td>
            </tr>";
        }
    }

    // Tạo HTML cho phân trang
    $pageHtml = "";
    if ($maxPage > 1) {
        if ($currentPage > 1)
            $pageHtml .= "<li><a href='#' data-page='" . ($currentPage - 1) . "'><i class='bi bi-arrow-left'></i></a></li>";
        for ($i = 1; $i <= $maxPage; $i++) {
            $active = ($i == $currentPage) ? 'active' : '';
            $pageHtml .= "<li><a href='#' class='$active' data-page='$i'>$i</a></li>";
        }
        if ($currentPage < $maxPage)
            $pageHtml .= "<li><a href='#' data-page='" . ($currentPage + 1) . "'><i class='bi bi-arrow-right'></i></a></li>";
    }

    echo json_encode(['table' => $tableHtml, 'pagination' => $pageHtml]);
    exit;
}



// --- Action 4: Lấy chi tiết 1 sản phẩm để sửa (BẢN CHUẨN ĐƯỜNG DẪN) ---
if ($action === 'get_product_detail') {
    $id = (int) $_GET['id'];
    $sql = "SELECT p.*, b.brand_name 
            FROM products p 
            LEFT JOIN brands b ON p.brand_id = b.id 
            WHERE p.id = $id";
    $product = getOne($sql);

    if ($product) {
        // 1. Tạo đường dẫn gốc từ Slug để gửi về cho JS
        $type_slug = create_slug($product['product_type']);
        $brand_slug = create_slug($product['brand_name']);
        $product_slug = create_slug($product['product_name']);

        // Trả về đường dẫn chuẩn (đảm bảo không bị dư dấu / ở giữa)
        $product['base_path'] = "../assets/img/products/guitar/{$type_slug}/{$brand_slug}/{$product_slug}/";

        // 2. Xử lý phụ kiện (nối lại thành văn bản cho textarea)
        if (!empty($product['accessories'])) {
            $acc_arr = json_decode($product['accessories'], true);
            $product['accessories_text'] = implode("\n", $acc_arr);
        }
        echo json_encode($product);
    }
    exit;
}


// --- Action 5: CẬP NHẬT SẢN PHẨM (BẢN FIX TRIỆT ĐỂ LỖI 7 ẢNH) ---
if ($action === 'update_product') {
    try {
        $p_id = (int) $_POST['product_id'];
        $p_name = $_POST['product_name'];
        $p_type = $_POST['product_type'];
        $brand_id = (int) $_POST['brand_id'];

        // 1. Lấy dữ liệu CŨ từ Database để xác định thư mục ĐANG CHỨA FILE
        $old_product = getOne("SELECT p.*, b.brand_name FROM products p LEFT JOIN brands b ON p.brand_id = b.id WHERE p.id = $p_id");

        $old_path_info = [
            'type' => create_slug($old_product['product_type']),
            'brand' => create_slug($old_product['brand_name']),
            'name' => create_slug($old_product['product_name'])
        ];
        $old_dir = __DIR__ . "/../../../assets/img/products/guitar/{$old_path_info['type']}/{$old_path_info['brand']}/{$old_path_info['name']}/";

        // 2. Tính toán thư mục MỚI (phòng trường hợp Huy đổi tên/loại/hiệu)
        $brand_info = getOne("SELECT brand_name FROM brands WHERE id = $brand_id");
        $new_path_info = [
            'type' => create_slug($p_type),
            'brand' => create_slug($brand_info['brand_name']),
            'name' => create_slug($p_name)
        ];
        $new_dir = __DIR__ . "/../../../assets/img/products/guitar/{$new_path_info['type']}/{$new_path_info['brand']}/{$new_path_info['name']}/";

        // 3. Lấy danh sách ảnh Huy muốn giữ (từ JS gửi lên)
        $images_to_keep_str = $_POST['images_to_keep'] ?? '';
        $images_to_keep_arr = array_filter(array_map('trim', explode(',', $images_to_keep_str)));

        // 4. BƯỚC QUAN TRỌNG: Xóa file thật sự bị loại bỏ khỏi thư mục CŨ
        $db_images_arr = array_filter(array_map('trim', explode(',', $old_product['product_images'])));
        foreach ($db_images_arr as $file_name) {
            if (!in_array($file_name, $images_to_keep_arr)) {
                $file_to_delete = $old_dir . $file_name;
                if (file_exists($file_to_delete)) {
                    unlink($file_to_delete); // Xóa sạch dấu vết ảnh bị Huy bấm "X"
                }
            }
        }

        // 5. Nếu có đổi thông tin (Tên/Loại/Hiệu) -> Di chuyển các ảnh còn lại sang thư mục mới
        if ($old_dir !== $new_dir) {
            if (!file_exists($new_dir))
                mkdir($new_dir, 0777, true);
            foreach ($images_to_keep_arr as $file) {
                if (file_exists($old_dir . $file)) {
                    rename($old_dir . $file, $new_dir . $file);
                }
            }
            // Xóa thư mục cũ nếu trống để dọn dẹp
            if (file_exists($old_dir) && count(scandir($old_dir)) == 2)
                rmdir($old_dir);
        } else {
            // Nếu không đổi thư mục, đảm bảo thư mục tồn tại
            if (!file_exists($new_dir))
                mkdir($new_dir, 0777, true);
        }

        // 6. Xử lý ảnh MỚI upload thêm
        $new_uploaded_images = [];
        if (!empty($_FILES['product_images']['name'][0])) {
            foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
                $ext = pathinfo($_FILES['product_images']['name'][$key], PATHINFO_EXTENSION);
                $new_file_name = "{$new_path_info['name']}-" . time() . "{$key}.{$ext}";
                if (move_uploaded_file($tmp_name, $new_dir . $new_file_name)) {
                    $new_uploaded_images[] = $new_file_name;
                }
            }
        }

        // 7. Tổng hợp danh sách ảnh cuối cùng (luôn <= 6 nhờ JS đã chặn)
        $final_images_list = implode(',', array_merge($images_to_keep_arr, $new_uploaded_images));

        // 8. Cập nhật Database
        $acc_lines = array_values(array_filter(array_map('trim', explode("\n", $_POST['accessories'] ?? ''))));
        $acc_json = json_encode(['fixed' => $acc_lines, 'others' => ''], JSON_UNESCAPED_UNICODE);
        $sql = "UPDATE products SET 
                product_name = ?, product_type = ?, brand_id = ?, product_images = ?,
                summary_description = ?, detailed_overview = ?, profit_margin = ?, discount_percent = ?, accessories = ?,
                highlight_1_title = ?, highlight_1_content = ?, highlight_2_title = ?, highlight_2_content = ?, 
                highlight_3_title = ?, highlight_3_content = ?, highlight_4_title = ?, highlight_4_content = ?
                WHERE id = ?";

        $pdo->prepare($sql)->execute([
            $p_name,
            $p_type,
            $brand_id,
            $final_images_list,
            $_POST['summary_description'],
            $_POST['detailed_overview'],
            $_POST['profit_margin'],
            $_POST['discount_percent'],
            $acc_json,
            $_POST['highlight_1_title'],
            $_POST['highlight_1_content'],
            $_POST['highlight_2_title'],
            $_POST['highlight_2_content'],
            $_POST['highlight_3_title'],
            $_POST['highlight_3_content'],
            $_POST['highlight_4_title'],
            $_POST['highlight_4_content'],
            $p_id
        ]);

        echo "success";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    exit;
}

// --- Action 6: XÓA SẢN PHẨM VÀ THƯ MỤC ẢNH ---
if ($action === 'delete_product') {
    try {
        $id = (int) $_POST['id'];

        // 1. Lấy thông tin sản phẩm để xác định thư mục cần xóa
        $product = getOne("SELECT p.*, b.brand_name 
                           FROM products p 
                           LEFT JOIN brands b ON p.brand_id = b.id 
                           WHERE p.id = $id");

        if (!$product) {
            echo "Lỗi: Không tìm thấy sản phẩm.";
            exit;
        }

        // 2. Xóa bản ghi trong Database trước
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);

        // 3. Xử lý xóa thư mục ảnh vật lý trên máy
        $type_slug = create_slug($product['product_type']);
        $brand_slug = create_slug($product['brand_name']);
        $product_slug = create_slug($product['product_name']);

        $target_dir = __DIR__ . "/../../../assets/img/products/guitar/{$type_slug}/{$brand_slug}/{$product_slug}/";

        if (file_exists($target_dir) && is_dir($target_dir)) {
            // Xóa toàn bộ file bên trong thư mục trước khi xóa thư mục
            $files = glob($target_dir . '*');
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file);
            }
            // Xóa thư mục rỗng
            rmdir($target_dir);
        }

        echo "success";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    exit;
}