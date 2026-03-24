<?php
// --- forms/quanlytonkho/ajax_handle_inventory.php ---
require_once __DIR__ . "/../../../forms/database.php"; // Điều chỉnh đường dẫn tùy cấu trúc của bạn

$action = $_GET['action'] ?? '';

if ($action === 'fetch_inventory') {
    $targetDate = $_GET['date'] ?: date('Y-m-d');
    $searchKeyword = trim($_GET['search'] ?? '');
    $filterStatus = $_GET['status'] ?? '';

    // Lấy ngưỡng cảnh báo từ URL, nếu không có thì mặc định là 5
    $threshold = isset($_GET['threshold']) ? (int)$_GET['threshold'] : 5;
    // Hàm tính toán tồn kho lịch sử (Giữ nguyên logic ird.id của Huy)
    function getHistoricalStats($productId, $date, $profitMargin) {
        global $pdo;
        $stmtImport = $pdo->prepare("SELECT ird.quantity, ird.unit_price, i.import_date FROM import_receipt_details ird JOIN import_receipts i ON ird.receipt_id = i.id WHERE ird.product_id = ? AND DATE(i.import_date) <= ? ORDER BY i.import_date ASC");
        $stmtImport->execute([$productId, $date]);
        $imports = $stmtImport->fetchAll();

        $stmtOrder = $pdo->prepare("
            SELECT quantity, created_at 
            FROM order_details od 
            JOIN orders o ON od.order_id = o.id 
            WHERE od.product_id = ? 
            AND DATE(o.created_at) <= ? 
            AND o.order_status != 'cancel' -- THÊM DÒNG NÀY
            ORDER BY o.created_at ASC
        ");
        $stmtOrder->execute([$productId, $date]);
        $orders = $stmtOrder->fetchAll();

        $curStock = 0; $curAvgCost = 0; $orderIdx = 0;
        foreach ($imports as $imp) {
            while ($orderIdx < count($orders) && $orders[$orderIdx]['created_at'] <= $imp['import_date']) {
                $curStock -= $orders[$orderIdx]['quantity'];
                $orderIdx++;
            }
            $curStock = max(0, $curStock);
            $newQ = $imp['quantity']; $newP = $imp['unit_price'];
            if (($curStock + $newQ) > 0) { $curAvgCost = ($curStock * $curAvgCost + $newQ * $newP) / ($curStock + $newQ); }
            $curStock += $newQ;
        }
        while ($orderIdx < count($orders)) { $curStock -= $orders[$orderIdx]['quantity']; $orderIdx++; }
        return ['stock' => max(0, $curStock), 'price' => $curAvgCost * (1 + ($profitMargin / 100))];
    }

    // Lấy danh sách sản phẩm và lọc
    $sql = "SELECT p.*, c.category_name, b.brand_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN brands b ON p.brand_id = b.id";
    if ($searchKeyword) { $sql .= " WHERE p.product_name LIKE " . $pdo->quote("%$searchKeyword%"); }
    
    $allProducts = getAll($sql);
    $displayData = [];
    foreach ($allProducts as $p) {
        $res = getHistoricalStats($p['id'], $targetDate, $p['profit_margin']);
        $st = ($res['stock'] == 0) ? 'outstock' : (($res['stock'] <= $threshold) ? 'almost' : 'instock');
        
        if ($filterStatus == 'instock' && $st == 'outstock') continue;
        if ($filterStatus == 'almost' && $st != 'almost') continue;
        if ($filterStatus == 'outstock' && $st != 'outstock') continue;

        $p['current_stock'] = $res['stock'];
        $p['calculated_price'] = $res['price'];
        $p['status_key'] = $st;
        $displayData[] = $p;
    }

    // Sử dụng file list.php để phân trang mảng $displayData
    require_once 'list.php'; 

    // Tạo HTML bảng
    $tableHtml = "";
    if (empty($pagedData)) {
        $tableHtml = "<tr><td colspan='7' class='text-center'>Không tìm thấy dữ liệu.</td></tr>";
    } else {
        foreach ($pagedData as $row) {
            $badge = ($row['status_key'] == 'outstock') ? '<span style="color:red; font-weight:bold">Hết hàng 🛑</span>' : 
                     (($row['status_key'] == 'almost') ? '<span style="color:orange; font-weight:bold">Sắp hết ⚠️</span>' : '<span style="color:green; font-weight:bold">Còn hàng ✅</span>');
            $tableHtml .= "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['product_name']) . "</td>
                <td>" . htmlspecialchars($row['category_name']) . "</td>
                <td>" . htmlspecialchars($row['brand_name']) . "</td>
                <td class='fw-bold'>" . number_format($row['calculated_price'], 0, ',', '.') . " VND</td>
                <td class='text-center fw-bold'>{$row['current_stock']}</td>
                <td>$badge</td>
            </tr>";
        }
    }

    // Tạo HTML phân trang (Dùng logic của Huy từ all.php)
    $pgHtml = "";
    if ($maxPage > 1) {
        if ($currentPage > 1) $pgHtml .= "<li><a href='#' data-page='" . ($currentPage - 1) . "'><i class='bi bi-arrow-left'></i></a></li>";
        for ($i = 1; $i <= $maxPage; $i++) {
            $active = ($i == $currentPage) ? 'active' : '';
            $pgHtml .= "<li><a href='#' class='$active' data-page='$i'>$i</a></li>";
        }
        if ($currentPage < $maxPage) $pgHtml .= "<li><a href='#' data-page='" . ($currentPage + 1) . "'><i class='bi bi-arrow-right'></i></a></li>";
    }

    echo json_encode(['table' => $tableHtml, 'pagination' => $pgHtml]);
    exit;
}