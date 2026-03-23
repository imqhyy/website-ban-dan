<?php
require_once __DIR__ . "/../../../forms/database.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// --- 1. Lấy thương hiệu theo ID Phân loại (Sửa để fix lỗi Foreign Key) ---
if ($action === 'get_brands_by_category') {
    $cat_id = (int)($_GET['category_name'] ?? 0); // Huy gửi ID lên thì ta ép kiểu int
    // Phải lọc theo c.id mới ra được Brand đúng
    $sql = "SELECT b.id, b.brand_name, bc.brand_profit AS profit_margin 
            FROM brands b
            JOIN brand_category bc ON b.id = bc.brand_id
            JOIN categories c ON bc.category_id = c.id
            WHERE c.id = $cat_id";
    echo json_encode(getAll($sql));
    exit;
}

// --- 2. Thêm sản phẩm mới (Sửa product_type thành category_id) ---
if ($action === 'add_product') {
    try {
        $p_name = $_POST['product_name'];
        $cat_id = (int)$_POST['product_type'];
        $brand_id = (int)$_POST['brand_id'];

        $cat_info = getOne("SELECT category_name FROM categories WHERE id = $cat_id");
        $brand_info = getOne("SELECT brand_name FROM brands WHERE id = $brand_id");

        $type_slug = create_slug($cat_info['category_name']);
        $brand_slug = create_slug($brand_info['brand_name']);
        $product_slug = create_slug($p_name);

        $relative_path = "assets/img/products/guitar/{$type_slug}/{$brand_slug}/{$product_slug}/";
        $upload_dir = __DIR__ . "/../../../" . $relative_path;
        if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

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
        $acc_json = json_encode(array_filter(array_map('trim', explode("\n", $_POST['accessories']))), JSON_UNESCAPED_UNICODE);

        $sql = "INSERT INTO products (product_name, category_id, brand_id, product_images, summary_description, detailed_overview, profit_margin, discount_percent, accessories, highlight_1_title, highlight_1_content, highlight_2_title, highlight_2_content, highlight_3_title, highlight_3_content, highlight_4_title, highlight_4_content) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $pdo->prepare($sql)->execute([
            $p_name,
            $cat_id,
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

// --- 3. AJAX TẢI LẠI DANH SÁCH (BẢN CHUẨN CATEGORY_ID - HUY COPY ĐOẠN NÀY) ---
if ($action === 'fetch_list') {
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 10;
    $conditions = [];

    // SỬA: Lọc theo category_id (kiểu số) thay vì product_type (kiểu chữ)
    if (!empty($_GET['product_type'])) {
        $conditions[] = "p.category_id = " . (int)$_GET['product_type'];
    }

    if (!empty($_GET['brand_id'])) {
        $conditions[] = "p.brand_id = " . (int)$_GET['brand_id'];
    }

    if (!empty($_GET['search'])) {
        $search = $pdo->quote('%' . trim($_GET['search']) . '%');
        $conditions[] = "(p.product_name LIKE $search OR p.id LIKE $search)";
    }

    $where = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

    // Đếm tổng để tính số trang
    $maxData = getOne("SELECT COUNT(*) as total FROM products p $where")['total'];
    $maxPage = ceil($maxData / $perPage);
    $currentPage = max(1, min($currentPage, $maxPage));
    $offset = ($currentPage - 1) * $perPage;

    // SỬA: JOIN thêm bảng categories để lấy category_name hiển thị ra bảng
    $sql = "SELECT p.*, b.brand_name, c.category_name 
            FROM products p 
            LEFT JOIN brands b ON p.brand_id = b.id 
            LEFT JOIN categories c ON p.category_id = c.id 
            $where ORDER BY p.id DESC LIMIT $perPage OFFSET $offset";

    // Tạo HTML cho bảng (Giữ nguyên các cột của Huy)
    $products = getAll($sql);
    $tableHtml = ""; // PHẢI KHỞI TẠO BIẾN NÀY ĐẦU TIÊN

    if (empty($products)) {
        $tableHtml = "<tr><td colspan='8' class='text-center'>Chưa có sản phẩm nào.</td></tr>";
    } else {
        foreach ($products as $p) {
            $type = str_replace('Guitar ', '', htmlspecialchars($p['category_name'] ?? 'N/A'));
            $cost_display = number_format($p['cost_price'], 0, ',', '.') . " VND";
            $selling_display = number_format($p['selling_price'], 0, ',', '.') . " VND";
            $statusIcon = ($p['status'] === 'visible') ? 'bi-eye' : 'bi-eye-slash text-secondary';
            $statusTitle = ($p['status'] === 'visible') ? 'Đang hiện - Bấm để ẩn' : 'Đang ẩn - Bấm để hiện';

            $tableHtml .= "<tr>
                <td>{$p['id']}</td>
                <td>" . htmlspecialchars($p['product_name']) . "</td>
                <td>$type</td>
                <td>" . htmlspecialchars($p['brand_name'] ?? 'N/A') . "</td>
                <td class='fw-bold'>$cost_display</td>
                <td>" . (float)$p['profit_margin'] . "%</td>
                <td class='fw-bold text-primary'>$selling_display</td>
                <td class='function-button-container'>
                    <button class='action-icon-btn edit-product-btn' title='Sửa' data-id='{$p['id']}'><i class='bi bi-pencil-square' style='color: #ffc107;'></i></button>
                    <button class='action-icon-btn hide-btn' title='{$statusTitle}' data-id='{$p['id']}'>
                        <i class='bi {$statusIcon}'></i>
                    </button>
                    <button class='action-icon-btn delete-product-btn' title='Xóa' data-id='{$p['id']}'><i class='bi bi-trash3 text-danger'></i></button>
                </td>
            </tr>";
        }
    }

    // Tạo HTML cho phân trang (Giữ nguyên logic vẽ nút của Huy)
    $pageHtml = "";
    if ($maxPage > 1) {
        if ($currentPage > 1) $pageHtml .= "<li><a href='#' data-page='" . ($currentPage - 1) . "'><i class='bi bi-arrow-left'></i></a></li>";
        for ($i = 1; $i <= $maxPage; $i++) {
            $active = ($i == $currentPage) ? 'active' : '';
            $pageHtml .= "<li><a href='#' class='$active' data-page='$i'>$i</a></li>";
        }
        if ($currentPage < $maxPage) $pageHtml .= "<li><a href='#' data-page='" . ($currentPage + 1) . "'><i class='bi bi-arrow-right'></i></a></li>";
    }

    echo json_encode(['table' => $tableHtml, 'pagination' => $pageHtml]);
    exit;
}

// --- 4. Lấy chi tiết để Sửa (PHẢI GIỮ LẠI TÊN LOẠI ĐỂ TẠO SLUG ẢNH) ---
if ($action === 'get_product_detail') {
    $id = (int)$_GET['id'];
    // JOIN thêm categories để lấy tên (category_name) dùng cho đường dẫn ảnh
    $sql = "SELECT p.*, b.brand_name, c.category_name 
            FROM products p 
            LEFT JOIN brands b ON p.brand_id = b.id 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = $id";
    $product = getOne($sql);

    if ($product) {
        // Cập nhật đường dẫn ảnh dựa trên tên loại thật từ bảng categories
        $product['base_path'] = "../assets/img/products/guitar/" . create_slug($product['category_name']) . "/" . create_slug($product['brand_name']) . "/" . create_slug($product['product_name']) . "/";

        // Giữ nguyên logic xử lý phụ kiện JSON của Huy
        if (!empty($product['accessories'])) {
            $acc_arr = json_decode($product['accessories'], true);
            $product['accessories_text'] = is_array($acc_arr) ? implode("\n", $acc_arr) : "";
        }
        echo json_encode($product);
    }
    exit;
}

// --- 5. LƯU CẬP NHẬT SẢN PHẨM (BẢN FIX LỖI MẤT ẢNH CŨ - HUY THAY THẾ) ---
if ($action === 'update_product') {
    try {
        $pdo->beginTransaction();

        $p_id = (int)$_POST['product_id'];
        $p_name = $_POST['product_name'];
        $cat_id = (int)$_POST['product_type'];
        $brand_id = (int)$_POST['brand_id'];

        // 1. Lấy thông tin cũ để so sánh thư mục
        $sqlOld = "SELECT p.product_name, b.brand_name, c.category_name FROM products p 
                   LEFT JOIN brands b ON p.brand_id = b.id 
                   LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $p_id";
        $old_p = getOne($sqlOld);

        $cat_info = getOne("SELECT category_name FROM categories WHERE id = $cat_id");
        $brand_info = getOne("SELECT brand_name FROM brands WHERE id = $brand_id");

        $product_slug_new = create_slug($p_name);
        $upload_dir_new = __DIR__ . "/../../../assets/img/products/guitar/" . create_slug($cat_info['category_name']) . "/" . create_slug($brand_info['brand_name']) . "/{$product_slug_new}/";
        if (!file_exists($upload_dir_new)) mkdir($upload_dir_new, 0777, true);

        $upload_dir_old = __DIR__ . "/../../../assets/img/products/guitar/" . create_slug($old_p['category_name']) . "/" . create_slug($old_p['brand_name']) . "/" . create_slug($old_p['product_name']) . "/";

        // 2. Đọc danh sách ảnh cũ (Giờ JS đã gửi JSON chuẩn nên PHP sẽ nhận được mảng)
        $images_to_keep = json_decode($_POST['images_to_keep'] ?? '[]', true) ?: [];
        $final_images_list = [];

        foreach ($images_to_keep as $index => $old_file_name) {
            $ext = pathinfo($old_file_name, PATHINFO_EXTENSION);
            $new_name = "{$product_slug_new}-" . ($index + 1) . ".{$ext}";

            // CHỈ RENAME KHI: Thư mục đổi HOẶC tên file mới khác tên file cũ
            if ($upload_dir_old !== $upload_dir_new || $old_file_name !== $new_name) {
                if (file_exists($upload_dir_old . $old_file_name)) {
                    rename($upload_dir_old . $old_file_name, $upload_dir_new . $new_name);
                }
            }
            $final_images_list[] = $new_name;
        }

        // 3. Upload ảnh mới (Đánh số tiếp theo danh sách cũ)
        if (!empty($_FILES['product_images']['name'][0])) {
            foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
                if (count($final_images_list) < 6) {
                    $ext = pathinfo($_FILES['product_images']['name'][$key], PATHINFO_EXTENSION);
                    $new_file_name = "{$product_slug_new}-" . (count($final_images_list) + 1) . ".{$ext}";
                    if (move_uploaded_file($tmp_name, $upload_dir_new . $new_file_name)) {
                        $final_images_list[] = $new_file_name;
                    }
                }
            }
        }

        $images_string = implode(',', $final_images_list);

        // 4. Dọn dẹp thư mục cũ
        if ($upload_dir_old !== $upload_dir_new && is_dir($upload_dir_old)) {
            $files = glob($upload_dir_old . "*");
            foreach ($files as $file) {
                if (is_file($file)) unlink($file);
            }
            @rmdir($upload_dir_old);
        }

        // 5. Cập nhật Database
        // 5. Cập nhật Database (BẢN FIX ĐẦY ĐỦ HIGHLIGHTS)
        $sql = "UPDATE products SET 
            product_name = ?, 
            category_id = ?, 
            brand_id = ?, 
            product_images = ?, 
            summary_description = ?, 
            detailed_overview = ?, 
            profit_margin = ?, 
            discount_percent = ?, 
            accessories = ?,
            highlight_1_title = ?, highlight_1_content = ?,
            highlight_2_title = ?, highlight_2_content = ?,
            highlight_3_title = ?, highlight_3_content = ?,
            highlight_4_title = ?, highlight_4_content = ?
        WHERE id = ?";

        $pdo->prepare($sql)->execute([
            $p_name,
            $cat_id,
            $brand_id,
            $images_string,
            $_POST['summary_description'],
            $_POST['detailed_overview'],
            $_POST['profit_margin'],
            $_POST['discount_percent'],
            json_encode(array_filter(array_map('trim', explode("\n", $_POST['accessories']))), JSON_UNESCAPED_UNICODE),
            // Bổ sung Highlights vào đây
            $_POST['highlight_1_title'] ?? '',
            $_POST['highlight_1_content'] ?? '',
            $_POST['highlight_2_title'] ?? '',
            $_POST['highlight_2_content'] ?? '',
            $_POST['highlight_3_title'] ?? '',
            $_POST['highlight_3_content'] ?? '',
            $_POST['highlight_4_title'] ?? '',
            $_POST['highlight_4_content'] ?? '',
            $p_id
        ]);

        $pdo->commit();
        echo "success";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Lỗi SQL: " . $e->getMessage();
    }
    exit;
}

// --- 6. XỬ LÝ XÓA SẢN PHẨM (Nâng cấp theo yêu cầu giảng viên) ---
if ($action === 'delete_product') {
    try {
        $id = (int)$_POST['id'];

        // BƯỚC 1: Kiểm tra xem sản phẩm đã từng được nhập hàng chưa
        // Chúng ta kiểm tra trong bảng chi tiết phiếu nhập (import_receipt_details)
        $checkImport = getOne("SELECT COUNT(*) as total FROM import_receipt_details WHERE product_id = ?", [$id]);
        
        // Kiểm tra thêm cả trong chi tiết đơn hàng (Nếu Huy muốn an toàn tuyệt đối)
        $checkOrder = getOne("SELECT COUNT(*) as total FROM order_details WHERE product_id = ?", [$id]);

        if ($checkImport['total'] > 0 || $checkOrder['total'] > 0) {
            // TRƯỜNG HỢP 1: Đã có dữ liệu liên quan -> Chỉ chuyển sang trạng thái 'hidden'
            $pdo->prepare("UPDATE products SET status = 'hidden' WHERE id = ?")->execute([$id]);
            echo "hidden_success"; // Gửi mã phản hồi riêng để JS hiện thông báo
        } else {
            // TRƯỜNG HỢP 2: Sản phẩm "sạch" (chưa bán, chưa nhập) -> Xóa vĩnh viễn
            
            // 1. Lấy thông tin để xóa thư mục ảnh trên ổ cứng
            $p = getOne("SELECT p.product_name, b.brand_name, c.category_name 
                        FROM products p 
                        JOIN brands b ON p.brand_id = b.id 
                        JOIN categories c ON p.category_id = c.id 
                        WHERE p.id = ?", [$id]);

            if ($p) {
                $dir = __DIR__ . "/../../../assets/img/products/guitar/" . create_slug($p['category_name']) . "/" . create_slug($p['brand_name']) . "/" . create_slug($p['product_name']) . "/";
                if (is_dir($dir)) {
                    $files = glob($dir . '*', GLOB_MARK);
                    foreach ($files as $file) { unlink($file); }
                    @rmdir($dir);
                }
            }

            // 2. Xóa dòng dữ liệu trong Database
            $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
            echo "delete_success";
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    exit;
}


// --- 7. XỬ LÝ ẨN/HIỆN SẢN PHẨM (Huy thêm đoạn này) ---
if ($action === 'toggle_status') {
    try {
        $id = (int)$_POST['id'];

        // 1. Lấy trạng thái hiện tại
        $current = getOne("SELECT status FROM products WHERE id = ?", [$id]);

        // 2. Đảo ngược trạng thái
        $newStatus = ($current['status'] === 'visible') ? 'hidden' : 'visible';

        // 3. Cập nhật vào Database
        $pdo->prepare("UPDATE products SET status = ? WHERE id = ?")->execute([$newStatus, $id]);

        echo "success";
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    exit;
}
