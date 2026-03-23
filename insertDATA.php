<?php
require_once('forms/database.php');

$results = [];

function runSeed($pdo, $label, $sql, $params = [])
{
    global $results;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results[] = "✅ $label";
    } catch (PDOException $e) {
        $results[] = "❌ $label — " . $e->getMessage();
    }
}

// ============================================================
// CATEGORIES
// ============================================================
$categories = [
    [1, 'Guitar Acoustic', 25.00, 'guitar-acoustic', 'Dòng guitar thùng sử dụng dây kim loại.'],
    [2, 'Guitar Classic', 30.00, 'guitar-classic', 'Dòng guitar thùng sử dụng dây nylon.'],
];
foreach ($categories as $r) {
    runSeed(
        $pdo,
        "Category: {$r[1]}",
        "INSERT INTO categories (id, category_name, profit_margin, category_slug, description) VALUES (?,?,?,?,?)
         ON DUPLICATE KEY UPDATE category_name=VALUES(category_name), profit_margin=VALUES(profit_margin), category_slug=VALUES(category_slug), description=VALUES(description)",
        $r
    );
}

// ============================================================
// BRANDS
// ============================================================
$brands = [
    [1, 'Saga', NULL, 'saga'],
    [2, 'Taylor', NULL, 'taylor'],
    [3, 'Ba Đờn', NULL, 'ba-don'],
    [4, 'Yamaha', NULL, 'yamaha'],
    [5, 'Enya', 'đàn cho nhà giàu', 'enya'],
];
foreach ($brands as $r) {
    runSeed(
        $pdo,
        "Brand: {$r[1]}",
        "INSERT INTO brands (id, brand_name, description, brand_slug) VALUES (?,?,?,?)
         ON DUPLICATE KEY UPDATE brand_name=VALUES(brand_name), description=VALUES(description), brand_slug=VALUES(brand_slug)",
        $r
    );
}

// ============================================================
// BRAND_CATEGORY
// ============================================================
$brand_categories = [
    [1, 1, 20.00],
    [2, 1, 20.00],
    [3, 2, 20.00],
    [4, 1, 20.00],
    [4, 2, 20.00],
    [5, 1, 32.00],
];
foreach ($brand_categories as $r) {
    runSeed(
        $pdo,
        "BrandCategory: brand={$r[0]} cat={$r[1]}",
        "INSERT INTO brand_category (brand_id, category_id, brand_profit) VALUES (?,?,?)
         ON DUPLICATE KEY UPDATE brand_profit=VALUES(brand_profit)",
        $r
    );
}

// ============================================================
// ADMIN USERS
// ============================================================
$admins = [
    [1, 'admin', 'Trần Hà Linh', 'linhhatran@gmail.com', '0783445439', NULL, '123'],
];
foreach ($admins as $r) {
    runSeed(
        $pdo,
        "Admin: {$r[1]}",
        "INSERT INTO admin_users (id, username, fullname, email, phone, avatar, password) VALUES (?,?,?,?,?,?,?)
         ON DUPLICATE KEY UPDATE fullname=VALUES(fullname), email=VALUES(email), phone=VALUES(phone), avatar=VALUES(avatar), password=VALUES(password)",
        $r
    );
}

// ============================================================
// USERS
// ============================================================
$users = [
    [1, 'rpt.mckkk', 'mck', 'Nghiêm Vũ Hoàng Long', 'nghiemtong@gmail.com', '(012) 345-6789', NULL, NULL, NULL, NULL, 'assets/img/person/mckhutthuocbangchan.jpeg', 0, NULL],
    [22, 'wxrdie', 'wxrdie', 'Phạm Nam Hải', 'wrxdie@gmail.com', '(012) 345-1111', 'Nhà của MCK', 'Hà Nội', 'Phố Quan Hoa', 'Cầu Giấy', 'assets/img/avatars/1774078406_wxrdie.jpg', 0, NULL],
    [23, 'tlinh', 'tlinh', 'Nguyễn Thảo Linh', 'tlinh@gmail.com', '(012) 345-2222', NULL, NULL, NULL, NULL, 'assets/img/avatars/1774079282_tlinhdautroc.jpg', 0, NULL],
    [24, 'longchimloi', 'long123', 'Nguyễn Hoàng Long', 'longchimloi@gmail.com', '0912345678', '12 Nguyễn Trãi', 'Hồ Chí Minh', 'Quận 1', 'Phường Bến Thành', 'assets/img/person/longchimloi.jpg', 1, 'Nghi ngờ gian lận / lừa đảo'],
    [25, 'wxrdie2', 'wxr123', 'Trần Minh Khoa', 'minhkhoa@gmail.com', '0923456789', '45 Lê Lợi', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/wxrdie.jpg', 0, NULL],
    [26, 'gdragon_vn', 'gd123', 'Kwon Ji Young', 'gdragon@gmail.com', '0934567890', '7 Phạm Ngũ Lão', 'Hồ Chí Minh', 'Quận 1', 'Phường Phạm Ngũ Lão', 'assets/img/person/gdragon.png', 0, NULL],
    [27, 'jackj97', 'jack123', 'Trịnh Trần Phương Tuấn', 'jackj97@gmail.com', '0945678901', '99 Cách Mạng Tháng 8', 'Hồ Chí Minh', 'Quận 10', 'Phường 5', 'assets/img/person/jack.png', 0, NULL],
    [28, 'soicodoc2', 'soi123', 'Nguyễn Văn Sói', 'soicodoc@gmail.com', '0956789012', '33 Đinh Tiên Hoàng', 'Hà Nội', 'Hoàn Kiếm', 'Phường Tràng Tiền', 'assets/img/person/soicodoc.jpg', 0, NULL],
    [29, 'namperfect2', 'nam123', 'Trần Nam Perfect', 'namperfect@gmail.com', '0967890123', '88 Bà Triệu', 'Hà Nội', 'Hai Bà Trưng', 'Phường Bùi Thị Xuân', 'assets/img/person/namperfect.jpg', 0, NULL],
    [30, 'datvantay2', 'dat123', 'Nguyễn Đạt Văn Tây', 'datvantay@gmail.com', '0978901234', '15 Nguyễn Huệ', 'Đà Nẵng', 'Hải Châu', 'Phường Thạch Thang', 'assets/img/person/datvantay.jpg', 0, NULL],
    [31, 'dangrangcom', 'dang123', 'Đặng Rang Cơm', 'dangrangcom@gmail.com', '0989012345', '22 Trần Phú', 'Đà Nẵng', 'Hải Châu', 'Phường Nam Dương', 'assets/img/person/dangrangcom.jpg', 0, NULL],
    [32, 'anhnhancobap', 'anh123', 'Lê Văn Nhân', 'anhnhancobap@gmail.com', '0990123456', '56 Hùng Vương', 'Cần Thơ', 'Ninh Kiều', 'Phường Tân An', 'assets/img/person/anhnhancobap.jpg', 0, NULL],
    [33, 'chautinhtri2', 'chau123', 'Châu Tinh Trì Fan', 'chautinhtri@gmail.com', '0901234567', '100 Võ Văn Tần', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/chautinhtri.jpg', 0, NULL],
];
foreach ($users as $r) {
    runSeed(
        $pdo,
        "User: {$r[1]}",
        "INSERT INTO users (id, username, password, fullname, email, phone, address, city, district, ward, avatar, is_locked, locked_reason) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
         ON DUPLICATE KEY UPDATE password=VALUES(password), fullname=VALUES(fullname), email=VALUES(email), phone=VALUES(phone), address=VALUES(address), city=VALUES(city), district=VALUES(district), ward=VALUES(ward), avatar=VALUES(avatar), is_locked=VALUES(is_locked), locked_reason=VALUES(locked_reason)",
        $r
    );
}

// ============================================================
// PRODUCTS
// ============================================================
$products = [
    [2, 'Taylor A12E', 1, 2, 'taylor-a12e-1.jpg,taylor-a12e-2.jpg,taylor-a12e-3.jpg,taylor-a12e-4.jpg,taylor-a12e-5.jpg,taylor-a12e-6.jpg', 'Huyền thoại của Taylor cho sự thoải mái tối đa.', 'Thiết kế Grand Concert nhỏ gọn với vát cạnh (Armrest) giúp người chơi không bị mỏi tay.', 70000000.00, 21.43, 0.00, 85000000.00, 'Thiết kế vát cạnh', 'Tăng sự thoải mái khi tì tay chơi đàn.', 'Hệ thống ES2', 'Bộ thu âm độc quyền cho âm thanh chân thực khi ra loa.', 'Phím đàn Ebony', 'Cảm giác lướt phím cực mượt mà.', 'Thân đàn nhỏ gọn', 'Phù hợp cho fingerstyle và phòng thu.', NULL, 0],
    [3, 'Ba đờn C100', 2, 3, 'badon-c100-1.jpg,badon-c100-2.jpg,badon-c100-3.jpg,badon-c100-4.jpg,badon-c100-5.jpg,badon-c100-6.jpg', 'Đàn guitar cổ điển chất lượng cao sản xuất tại Việt Nam.', 'C100 là lựa chọn hàng đầu cho học sinh sinh viên bắt đầu học guitar cổ điển với âm thanh ấm áp.', 4000000.00, 25.00, 10.00, 5000000.00, 'Gỗ thịt 100%', 'Toàn thân được làm từ gỗ thật, càng chơi càng hay.', 'Cần đàn chắc chắn', 'Thiết kế chuẩn classic, dễ cầm nắm.', 'Âm thanh ấm', 'Phù hợp với các bản nhạc trữ tình, cổ điển.', 'Giá thành hợp lý', 'Chất lượng vượt trội trong tầm giá.', NULL, 0],
    [4, 'Ba Đờn C150', 2, 3, 'ba-don-c150-1.jpg,ba-don-c150-2.jpg,ba-don-c150-3.jpg,ba-don-c150-4.jpg,ba-don-c150-5.jpg,ba-don-c150-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [5, 'Ba Đờn C170', 2, 3, 'ba-don-c170-1.jpg,ba-don-c170-2.jpg,ba-don-c170-3.jpg,ba-don-c170-4.jpg,ba-don-c170-5.jpg,ba-don-c170-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [6, 'Ba Đờn C250', 2, 3, 'ba-don-c250-1.jpg,ba-don-c250-2.jpg,ba-don-c250-3.jpg,ba-don-c250-4.jpg,ba-don-c250-5.jpg,ba-don-c250-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [7, 'Yamaha C40mii C CX', 2, 4, 'yamaha-c40mii-c-cx-1.jpg,yamaha-c40mii-c-cx-2.jpg,yamaha-c40mii-c-cx-3.jpg,yamaha-c40mii-c-cx-4.jpg,yamaha-c40mii-c-cx-5.jpg,yamaha-c40mii-c-cx-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [8, 'Yamaha GC42S GC GCX', 2, 4, 'yamaha-gc42s-gc-gcx-1.jpg,yamaha-gc42s-gc-gcx-2.jpg,yamaha-gc42s-gc-gcx-3.jpg,yamaha-gc42s-gc-gcx-4.jpg,yamaha-gc42s-gc-gcx-5.jpg,yamaha-gc42s-gc-gcx-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [9, 'Yamaha GL1 Guitarlele', 2, 4, 'yamaha-gl1-guitarlele-1.jpg,yamaha-gl1-guitarlele-2.jpg,yamaha-gl1-guitarlele-3.jpg,yamaha-gl1-guitarlele-4.jpg,yamaha-gl1-guitarlele-5.jpg,yamaha-gl1-guitarlele-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [12, 'Saga SS 8CE', 1, 1, 'saga-ss-8ce-1.jpg,saga-ss-8ce-2.jpg,saga-ss-8ce-3.jpg,saga-ss-8ce-4.jpg,saga-ss-8ce-5.jpg,saga-ss-8ce-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [13, 'Enya EA X2', 1, 5, 'enya-ea-x2-1.jpg,enya-ea-x2-2.jpg,enya-ea-x2-3.jpg,enya-ea-x2-4.jpg,enya-ea-x2-5.jpg,enya-ea-x2-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [14, 'Enya EGA X0 PRO SP1', 1, 5, 'enya-ega-x0-pro-sp1-1.jpg,enya-ega-x0-pro-sp1-2.jpg,enya-ega-x0-pro-sp1-3.jpg,enya-ega-x0-pro-sp1-4.jpg,enya-ega-x0-pro-sp1-5.jpg,enya-ega-x0-pro-sp1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [15, 'Enya EM X1 SP1', 1, 5, 'enya-em-x1-sp1-1.jpg,enya-em-x1-sp1-2.jpg,enya-em-x1-sp1-3.jpg,enya-em-x1-sp1-4.jpg,enya-em-x1-sp1-5.jpg,enya-em-x1-sp1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [16, 'Taylor 110E', 1, 2, 'taylor-110e-1.jpg,taylor-110e-2.jpg,taylor-110e-3.jpg,taylor-110e-4.jpg,taylor-110e-5.jpg,taylor-110e-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [23, 'Jack', 1, 5, NULL, NULL, NULL, 0.00, 20.00, 0.00, 3500000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0],
    [27, 'tày enzoo', 1, 2, 'tay-enzo-1.png,tay-enzo-2.png,tay-enzo-3.png,tay-enzo-4.png,tay-enzo-5.png,tay-enzo-6.png', '', '', 0.00, 20.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', 0],
    [29, 'akkakaka', 1, 1, 'akkakaka-1.jpeg,akkakaka-2.jpg,akkakaka-3.jpg,akkakaka-4.jpg,akkakaka-5.jpg,akkakaka-6.png', 'hih', 'hihihi', 0.00, 20.00, 0.00, 0.00, 'Âm thanh', 'asdfsfsfssfs', 'Màu sắc', 'sdsfsfsdfs', 'Chiều cao', '15', 'Chiều dài', '18', '["dây xích meo","ca giủ"]', 2],
];
foreach ($products as $r) {
    runSeed(
        $pdo,
        "Product: {$r[1]}",
        "INSERT INTO products (id, product_name, category_id, brand_id, product_images, summary_description, detailed_overview, cost_price, profit_margin, discount_percent, selling_price, highlight_1_title, highlight_1_content, highlight_2_title, highlight_2_content, highlight_3_title, highlight_3_content, highlight_4_title, highlight_4_content, accessories, stock_quantity) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
         ON DUPLICATE KEY UPDATE product_name=VALUES(product_name), category_id=VALUES(category_id), brand_id=VALUES(brand_id), product_images=VALUES(product_images), summary_description=VALUES(summary_description), detailed_overview=VALUES(detailed_overview), cost_price=VALUES(cost_price), profit_margin=VALUES(profit_margin), discount_percent=VALUES(discount_percent), selling_price=VALUES(selling_price), highlight_1_title=VALUES(highlight_1_title), highlight_1_content=VALUES(highlight_1_content), highlight_2_title=VALUES(highlight_2_title), highlight_2_content=VALUES(highlight_2_content), highlight_3_title=VALUES(highlight_3_title), highlight_3_content=VALUES(highlight_3_content), highlight_4_title=VALUES(highlight_4_title), highlight_4_content=VALUES(highlight_4_content), accessories=VALUES(accessories), stock_quantity=VALUES(stock_quantity)",
        $r
    );
}

// ============================================================
// IMPORT RECEIPTS
// ============================================================
$import_receipts = [
    [3, 'PN-230326-001', '2026-03-24 00:00:00', 2000000.00, NULL],
];
foreach ($import_receipts as $r) {
    runSeed(
        $pdo,
        "Import Receipt: {$r[1]}",
        "INSERT INTO import_receipts (id, receipt_code, import_date, total_amount, note) VALUES (?,?,?,?,?)
         ON DUPLICATE KEY UPDATE receipt_code=VALUES(receipt_code), import_date=VALUES(import_date), total_amount=VALUES(total_amount), note=VALUES(note)",
        $r
    );
}

// ============================================================
// IMPORT RECEIPT DETAILS
// ============================================================
$import_receipt_details = [
    [3, 3, 29, 2, 1000000.00],
];
foreach ($import_receipt_details as $r) {
    runSeed(
        $pdo,
        "Import Receipt Detail: receipt_id={$r[1]}, product_id={$r[2]}, qty={$r[3]}",
        "INSERT INTO import_receipt_details (id, receipt_id, product_id, quantity, unit_price) VALUES (?,?,?,?,?)
         ON DUPLICATE KEY UPDATE receipt_id=VALUES(receipt_id), product_id=VALUES(product_id), quantity=VALUES(quantity), unit_price=VALUES(unit_price)",
        $r
    );
}

// ============================================================
// ORDERS
// ============================================================
$orders = [
    // Thêm dữ liệu orders ở đây nếu có
];
foreach ($orders as $r) {
    runSeed(
        $pdo,
        "Order: {$r[2]}",
        "INSERT INTO orders (id, user_id, order_code, customer_name, phone, email, shipping_address, order_notes, total_amount, order_status) VALUES (?,?,?,?,?,?,?,?,?,?)
         ON DUPLICATE KEY UPDATE user_id=VALUES(user_id), customer_name=VALUES(customer_name), phone=VALUES(phone), email=VALUES(email), shipping_address=VALUES(shipping_address), order_notes=VALUES(order_notes), total_amount=VALUES(total_amount), order_status=VALUES(order_status)",
        $r
    );
}

// ============================================================
// ORDER DETAILS
// ============================================================
$order_details = [
    // Thêm dữ liệu order details ở đây nếu có
];
foreach ($order_details as $r) {
    runSeed(
        $pdo,
        "Order Detail: order_id={$r[1]}, product_id={$r[2]}, qty={$r[3]}",
        "INSERT INTO order_details (id, order_id, product_id, quantity, unit_price) VALUES (?,?,?,?,?)
         ON DUPLICATE KEY UPDATE order_id=VALUES(order_id), product_id=VALUES(product_id), quantity=VALUES(quantity), unit_price=VALUES(unit_price)",
        $r
    );
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Seed Database</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
            background: #1e1e1e;
            color: #d4d4d4;
        }

        h2 {
            color: #569cd6;
        }

        .result {
            margin: 4px 0;
            font-size: 14px;
        }

        .done {
            color: #6a9955;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>🌱 Seed Database — Guitar Xì Gòn</h2>
    <?php foreach ($results as $r): ?>
        <div class="result">
            <?= $r ?>
        </div>
    <?php endforeach; ?>
    <div class="done">✅ Hoàn tất! Tổng:
        <?= count($results) ?> bản ghi.
    </div>
</body>

</html>