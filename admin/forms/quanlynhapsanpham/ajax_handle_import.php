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

// --- 4. Lưu phiếu nhập (Cập nhật bước 2: Tăng tồn kho) ---
if ($action === 'save_import') {
    try {
        $pdo->beginTransaction();
        $receipt_code = $_POST['receipt_code'];
        $import_date  = $_POST['import_date'];
        $total_amount = str_replace(['.', ' VND'], '', $_POST['total_amount'] ?? '0');

        // 1. Lưu thông tin chung của phiếu nhập
        $stmt = $pdo->prepare("INSERT INTO import_receipt_details (receipt_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)"); // Giữ nguyên code cũ
        $stmt = $pdo->prepare("INSERT INTO import_receipts (receipt_code, import_date, total_amount) VALUES (?, ?, ?)");
        $stmt->execute([$receipt_code, $import_date, $total_amount]);
        $receipt_id = $pdo->lastInsertId();

        $products = $_POST['products'] ?? [];
        
        // 2. Chuẩn bị câu lệnh lưu chi tiết và câu lệnh CẬP NHẬT KHO
        $stmtDetail = $pdo->prepare("INSERT INTO import_receipt_receipt_details (receipt_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)"); 
        $stmtDetail = $pdo->prepare("INSERT INTO import_receipt_details (receipt_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
        
        // CÂU LỆNH MỚI: Cập nhật cột stock_quantity trong bảng products
        $stmtUpdateStock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity + ? WHERE id = ?");
        
        foreach ($products as $p) {
            $price = str_replace(['.', ' VND'], '', $p['price']);
            $qty = (int)$p['qty'];
            $p_id = (int)$p['id'];

            // Lưu vào bảng chi tiết phiếu nhập
            $stmtDetail->execute([$receipt_id, $p_id, $qty, $price]);

            // THỰC HIỆN BƯỚC 2: Cộng dồn số lượng vào kho
            $stmtUpdateStock->execute([$qty, $p_id]);
        }

        $pdo->commit(); 
        echo "success";
    } catch (Exception $e) { 
        $pdo->rollBack(); 
        echo "Lỗi: " . $e->getMessage(); 
    }
    exit;
}