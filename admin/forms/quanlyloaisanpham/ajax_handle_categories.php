<?php
// Lùi 3 cấp để nạp database.php (admin/forms/quanlyloaisanpham/ -> forms/database.php)
require_once "../../../forms/database.php"; 

$action = $_REQUEST['action'] ?? '';

// 1. LẤY DANH SÁCH PHÂN LOẠI (Cập nhật giao diện không cần F5)
if ($action == 'fetch_list') {
    $categories = getAll("SELECT * FROM categories ORDER BY id ASC");
    if (!empty($categories)) {
        foreach ($categories as $cat) {
            $catID = $cat['id'];
            $catName = htmlspecialchars($cat['category_name']);
            $profit = number_format($cat['profit_margin'] ?? 20, 0);
            
            // Xử lý hiển thị mô tả: nếu trống hoặc chỉ có khoảng trắng thì hiện "Chưa có mô tả"
            $descRaw = $cat['description'] ?? '';
            $descDisplay = !empty(trim($descRaw)) ? htmlspecialchars($descRaw) : 'Chưa có mô tả';
            $statusIcon = ($cat['status'] === 'visible') ? 'bi-eye' : 'bi-eye-slash text-secondary';
            $statusTitle = ($cat['status'] === 'visible') ? 'Đang hiện - Bấm để ẩn' : 'Đang ẩn - Bấm để hiện';
            echo "<tr>
                    <td>$catID</td>
                    <td class='manage-name-category'>$catName</td>
                    <td>$profit%</td>
                    <td>$descDisplay</td>
                    <td class='function-button-container'>
                        <button class='action-icon-btn edit-category-btn' title='Sửa' 
                                data-id='$catID' 
                                data-name='$catName' 
                                data-profit='$profit' 
                                data-desc='$descDisplay'>
                            <i class='bi bi-pencil-square'></i>
                        </button>

                        <button class='action-icon-btn manage-brands-btn' title='Quản lý thương hiệu' data-id='$catID'>
                            <i class='bi bi-sliders'></i>
                        </button>

                        <button class='action-icon-btn hide-btn' title='{$statusTitle}' data-id='{$catID}'>
                            <i class='bi {$statusIcon}'></i>
                        </button>

                        <button class='action-icon-btn delete-btn' title='Xoá' data-id='$catID'>
                            <i class='bi bi-trash3'></i>
                        </button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>Chưa có dữ liệu phân loại sản phẩm.</td></tr>";
    }
    exit();
}

// 2. XỬ LÝ THÊM MỚI PHÂN LOẠI
if ($action == 'add') {
    $name = trim($_POST['category_name'] ?? '');
    $profit = floatval($_POST['profit_margin'] ?? 20);
    $desc = trim($_POST['description'] ?? '');

    if (!empty($name)) {
        $slug = create_slug($name); // Đảm bảo hàm này có trong database.php hoặc init.php
        $sql = "INSERT INTO categories (category_name, category_slug, profit_margin, description) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$name, $slug, $profit, $desc])) {
            echo "success";
        } else {
            echo "error";
        }
    }
    exit();
}

// 3. XỬ LÝ CẬP NHẬT PHÂN LOẠI (SỬA)
if ($action == 'update') {
    $id = $_POST['category_id'] ?? null;
    $name = trim($_POST['category_name'] ?? '');
    $profit = floatval($_POST['profit_margin'] ?? 0);
    $desc = trim($_POST['description'] ?? '');

    if ($id && !empty($name)) {
        $slug = create_slug($name);
        $sql = "UPDATE categories SET category_name = ?, category_slug = ?, profit_margin = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$name, $slug, $profit, $desc, $id])) {
            echo "success";
        } else {
            echo "error";
        }
    }
    exit();
}

// 4. XỬ LÝ XÓA PHÂN LOẠI
if ($action == 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            if ($stmt->execute([$id])) {
                echo "success";
            }
        } catch (PDOException $e) {
            // Trả về lỗi đặc biệt nếu phân loại đang có sản phẩm (ràng buộc khóa ngoại)
            echo "error_constraint";
        }
    }
    exit();
}


// --- 5. ĐỔI TRẠNG THÁI ẨN/HIỆN LOẠI SẢN PHẨM ---
if ($action == 'toggle_status') {
    $id = (int)$_POST['id'];
    $current = getOne("SELECT status FROM categories WHERE id = ?", [$id]);
    $newStatus = ($current['status'] === 'visible') ? 'hidden' : 'visible';
    
    if ($pdo->prepare("UPDATE categories SET status = ? WHERE id = ?")->execute([$newStatus, $id])) {
        echo "success";
    }
    exit();
}