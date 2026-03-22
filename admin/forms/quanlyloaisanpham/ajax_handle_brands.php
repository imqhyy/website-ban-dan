<?php
// không nạp init.php vì nó sẽ gọi luôn file head.php gây lỗi cho hàm xóa brand
// ajax ở đây sẽ gửi dữ liệu về, nếu nạp init.php nó sẽ gửi luôn những đoạn html
// không cần thiết được require ở file init php gây ra lỗi dữ liệu
require_once "../../../forms/database.php";

$action = $_REQUEST['action'] ?? '';
$cat_id = $_REQUEST['cat_id'] ?? null;

// 1. LẤY DANH SÁCH THƯƠNG HIỆU
if ($action == 'fetch' && $cat_id) {
    // Lấy thông tin từ bảng brand_category kết nối với brands
    $sql = "SELECT b.id, b.brand_name, bc.brand_profit 
            FROM brands b
            JOIN brand_category bc ON b.id = bc.brand_id
            WHERE bc.category_id = :cat_id
            ORDER BY b.brand_name ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':cat_id' => $cat_id]);
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($brands)) {
        foreach ($brands as $b) {
            echo "<tr>
                    <td>".htmlspecialchars($b['brand_name'])."</td>
                    <td>
                        <div class='input-group input-group-sm' style='width: 100px;'>
                            <input type='number' class='form-control brand-profit-input' 
                                   value='".(float)$b['brand_profit']."' 
                                   data-brand-id='{$b['id']}' data-cat-id='{$cat_id}'>
                            <span class='input-group-text'>%</span>
                        </div>
                    </td>
                    <td class='text-center'>
                        <button class='btn btn-link text-primary p-0 me-2' 
                                onclick='updateBrandProfit({$b['id']}, {$cat_id}, this)' title='Lưu lợi nhuận'>
                            <i class='bi bi-check-circle-fill'></i>
                        </button>
                        <button class='btn btn-link text-danger p-0' 
                                onclick='deleteBrand({$b['id']}, {$cat_id})' title='Xóa liên kết'>
                            <i class='bi bi-trash3-fill'></i>
                        </button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3' class='text-center'>Chưa có thương hiệu nào cho loại này.</td></tr>";
    }
}

// 2. THÊM THƯƠNG HIỆU MỚI
if ($action == 'add' && $cat_id) {
    $name = trim($_POST['brand_name'] ?? '');
    if (!empty($name)) {
        try {
            $pdo->beginTransaction();
            
            // Lấy lợi nhuận mặc định của Loại sản phẩm
            $catInfo = getOne("SELECT profit_margin FROM categories WHERE id = $cat_id");
            $defaultProfit = $catInfo['profit_margin'] ?? 20;

            // Kiểm tra/Thêm vào bảng brands
            $checkBrand = getOne("SELECT id FROM brands WHERE brand_name = '$name'");
            if ($checkBrand) {
                $brand_id = $checkBrand['id'];
            } else {
                $slug = create_slug($name);
                $stmtAdd = $pdo->prepare("INSERT INTO brands (brand_name, brand_slug) VALUES (:name, :slug)");
                $stmtAdd->execute([':name' => $name, ':slug' => $slug]);
                $brand_id = $pdo->lastInsertId();
            }

            // Nối vào brand_category kèm lợi nhuận mặc định
            $sqlLink = "INSERT IGNORE INTO brand_category (brand_id, category_id, brand_profit) 
                        VALUES (:bid, :cid, :profit)";
            $stmtLink = $pdo->prepare($sqlLink);
            $stmtLink->execute([':bid' => $brand_id, ':cid' => $cat_id, ':profit' => $defaultProfit]);
            
            $pdo->commit();
            echo "success";
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "error";
        }
    }
}

// 3. CẬP NHẬT LỢI NHUẬN RIÊNG CHO BRAND
if ($action == 'update_profit') {
    $bid = $_POST['brand_id'] ?? null;
    $cid = $_POST['cat_id'] ?? null;
    $profit = $_POST['profit'] ?? 0;
    
    if ($bid && $cid) {
        $stmt = $pdo->prepare("UPDATE brand_category SET brand_profit = :profit 
                               WHERE brand_id = :bid AND category_id = :cid");
        $stmt->execute([':profit' => $profit, ':bid' => $bid, ':cid' => $cid]);
        echo "success";
    }
}

// 4. XÓA THƯƠNG HIỆU (Xóa liên kết trong bảng trung gian)
if ($action == 'delete') {
    $brand_id = $_GET['brand_id'] ?? null;
    $cid = $_GET['cat_id'] ?? null;
    if ($brand_id && $cid) {
        // Thực hiện xóa dòng liên kết trong bảng brand_category
        $result = $pdo->query("DELETE FROM brand_category WHERE brand_id = $brand_id AND category_id = $cid");
        
        if ($result) {
            echo "success"; // Dòng này cực kỳ quan trọng để JavaScript nhận diện thành công
        } else {
            echo "error";
        }
    }
    exit(); // Dừng script để không trả về dữ liệu thừa
}

// THÊM ĐOẠN NÀY VÀO ajax_handle_brands.php
if ($action == 'get_brand_detail' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Sử dụng hàm getOne đã có trong database.php của Huy
    $brand = getOne("SELECT * FROM brands WHERE id = $id");
    if ($brand) {
        echo json_encode($brand);
    }
    exit();
}

if ($action == 'fetch_global') {
    $all_brands = $pdo->query("SELECT * FROM brands ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($all_brands)) {
        foreach ($all_brands as $b) {
            $brandNameEsc = htmlspecialchars($b['brand_name'], ENT_QUOTES);
            
            // SỬA TẠI ĐÂY: Dùng empty() và trim() để kiểm tra chuỗi rỗng
            $displayDesc = !empty(trim($b['description'])) ? htmlspecialchars($b['description']) : 'Chưa có mô tả';
            
            echo "<tr>
                    <td>{$b['id']}</td>
                    <td><strong>$brandNameEsc</strong></td>
                    <td>$displayDesc</td> <td>" . date('d/m/Y', strtotime($b['created_at'])) . "</td>
                    <td class='function-button-container'>
                        <button class='action-icon-btn' title='Sửa' onclick='openEditBrandModal({$b['id']})'>
                            <i class='bi bi-pencil-square' style='color: #ffc107;'></i>
                        </button>
                        <button class='action-icon-btn' title='Xóa' onclick='deleteBrandGlobal({$b['id']}, \"$brandNameEsc\")'>
                            <i class='bi bi-trash3 text-danger'></i>
                        </button>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>Chưa có thương hiệu nào.</td></tr>";
    }
    exit();
}

if ($action == 'delete_global') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $pdo->query("DELETE FROM brands WHERE id = $id");
        echo "success";
    }
    exit();
}



// 1. Thêm thương hiệu mới trực tiếp từ bảng Global
if ($action == 'add_global_direct') {
    $name = trim($_POST['brand_name'] ?? '');
    $desc = trim($_POST['brand_desc'] ?? '');
    if (!empty($name)) {
        $slug = create_slug($name);
        $stmt = $pdo->prepare("INSERT INTO brands (brand_name, description, brand_slug) VALUES (:name, :desc, :slug)");
        if ($stmt->execute([':name' => $name, ':desc' => $desc, ':slug' => $slug])) {
            echo "success";
        }
    }
    exit();
}

// THÊM ĐOẠN NÀY VÀO CUỐI FILE ajax_handle_brands.php
if ($action == 'update_brand_info') {
    $id = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['desc'] ?? '');
    
    if ($id && $name) {
        // Cập nhật tên và mô tả vào bảng brands
        $stmt = $pdo->prepare("UPDATE brands SET brand_name = :name, description = :desc WHERE id = :id");
        $result = $stmt->execute([
            ':name' => $name, 
            ':desc' => $desc, 
            ':id' => $id
        ]);
        
        if ($result) {
            echo "success"; // Trình duyệt cần nhận chữ này để hiện Toast thành công
        } else {
            echo "error_db";
        }
    } else {
        echo "missing_data";
    }
    exit();
}
