<?php
require_once __DIR__ . "/../../../forms/database.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// --- 1. Lấy mã phiếu tự động (Huy yêu cầu) ---
if ($action === 'get_new_code') {
    $datePart = date("dmy");
    $prefix = "PN-" . $datePart . "-";
    $sql = "SELECT receipt_code FROM import_receipts WHERE receipt_code LIKE '$prefix%' ORDER BY id DESC LIMIT 1";
    $last = getOne($sql);
    if ($last) {
        $lastNum = (int)substr($last['receipt_code'], -3);
        $newNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
    } else { $newNum = "001"; }
    echo $prefix . $newNum;
    exit;
}

// --- 2. Lấy thương hiệu dựa trên phân loại (Database thật) ---
if ($action === 'get_brands') {
    $category_name = $_GET['category_name'] ?? '';
    $sql = "SELECT b.id, b.brand_name 
            FROM brands b
            JOIN brand_category bc ON b.id = bc.brand_id
            JOIN categories c ON bc.category_id = c.id
            WHERE c.category_name = " . $pdo->quote($category_name);
    echo json_encode(getAll($sql));
    exit;
}

// --- 3. Vừa nhập vừa đề xuất tên sản phẩm (Autocomplete) ---
if ($action === 'get_product_suggestions') {
    $type_name = $_GET['type'] ?? ''; // Nhận tên loại (VD: 'Guitar Classic')
    $brand_id = (int)($_GET['brand_id'] ?? 0);
    $query = $_GET['query'] ?? '';

    // Dùng JOIN với bảng categories để lọc chính xác theo tên loại sản phẩm
    $sql = "SELECT p.id, p.product_name 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE c.category_name = " . $pdo->quote($type_name) . " 
            AND p.brand_id = $brand_id 
            AND p.product_name LIKE " . $pdo->quote("%$query%") . " 
            LIMIT 10";
            
    echo json_encode(getAll($sql));
    exit;
}


// --- 4. Lưu phiếu nhập (Cập nhật: Tính giá bình quân gia quyền) ---
if ($action === 'save_import') {
    try {
        $pdo->beginTransaction();
        $receipt_code = $_POST['receipt_code'];
        $import_date  = $_POST['import_date'];
        $total_amount = str_replace(['.', ' VND'], '', $_POST['total_amount'] ?? '0');

        // Lưu thông tin chung của phiếu nhập
        $stmtInsertReceipt = $pdo->prepare("INSERT INTO import_receipts (receipt_code, import_date, total_amount) VALUES (?, ?, ?)");
        $stmtInsertReceipt->execute([$receipt_code, $import_date, $total_amount]);
        $receipt_id = $pdo->lastInsertId();

        $products = $_POST['products'] ?? [];
        $stmtDetail = $pdo->prepare("INSERT INTO import_receipt_details (receipt_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
        
        foreach ($products as $p) {
            $p_id = (int)$p['id'];
            $q_new = (int)$p['qty'];
            $c_new = (float)str_replace(['.', ' VND'], '', $p['price']);

            // --- BƯỚC A: Lấy dữ liệu hiện tại từ bảng products ---
            $current = getOne("SELECT stock_quantity, cost_price, profit_margin FROM products WHERE id = ?", [$p_id]);
            $q_old = (int)$current['stock_quantity'];
            $c_old = (float)$current['cost_price'];
            $p_margin = (float)$current['profit_margin'];

            // --- BƯỚC B: Tính giá nhập bình quân (Yêu cầu của giảng viên) ---
            // Công thức: (Tồn cũ * Giá vốn cũ + Nhập mới * Giá nhập mới) / (Tổng tồn mới)
            if (($q_old + $q_new) > 0) {
                $c_final = (($q_old * $c_old) + ($q_new * $c_new)) / ($q_old + $q_new);
            } else {
                $c_final = $c_new;
            }

            // --- BƯỚC C: Tính giá bán mới dựa trên tỷ lệ lợi nhuận ---
            // Công thức: Giá nhập bình quân * (1 + % Lợi nhuận / 100)
            $s_new = $c_final * (1 + ($p_margin / 100));

            // --- BƯỚC D: Cập nhật đồng thời Giá vốn, Giá bán và Số lượng tồn ---
            $sql_update = "UPDATE products SET 
                            cost_price = ?, 
                            selling_price = ?, 
                            stock_quantity = stock_quantity + ?,
                            updated_at = CURRENT_TIMESTAMP
                           WHERE id = ?";
            $pdo->prepare($sql_update)->execute([$c_final, $s_new, $q_new, $p_id]);

            // Lưu chi tiết sản phẩm vào phiếu nhập
            $stmtDetail->execute([$receipt_id, $p_id, $q_new, $c_new]);
        }

        $pdo->commit(); 
        echo "success";
    } catch (Exception $e) { 
        $pdo->rollBack(); 
        echo "Lỗi: " . $e->getMessage(); 
    }
    exit;
}