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
    [1, 'Guitar Acoustic', 'guitar-acoustic'],
    [2, 'Guitar Classic', 'guitar-classic'],
];
foreach ($categories as $r) {
    runSeed(
        $pdo,
        "Category: {$r[1]}",
        "INSERT INTO categories (id, category_name, category_slug) VALUES (?,?,?)
         ON DUPLICATE KEY UPDATE category_name=VALUES(category_name), category_slug=VALUES(category_slug)",
        $r
    );
}

// ============================================================
// BRANDS
// ============================================================
$brands = [
    [1, 'Saga', 20.00, 'saga'],
    [2, 'Taylor', 20.00, 'taylor'],
    [3, 'Ba Đờn', 20.00, 'ba-don'],
    [4, 'Yamaha', 20.00, 'yamaha'],
    [5, 'Enya', 20.00, 'enya'],
];
foreach ($brands as $r) {
    runSeed(
        $pdo,
        "Brand: {$r[1]}",
        "INSERT INTO brands (id, brand_name, profit_margin, brand_slug) VALUES (?,?,?,?)
         ON DUPLICATE KEY UPDATE brand_name=VALUES(brand_name), profit_margin=VALUES(profit_margin), brand_slug=VALUES(brand_slug)",
        $r
    );
}

// ============================================================
// BRAND_CATEGORY
// ============================================================
$brand_categories = [
    [1, 1],
    [2, 1],
    [3, 2],
    [4, 1],
    [4, 2],
    [5, 1],
];
foreach ($brand_categories as $r) {
    runSeed(
        $pdo,
        "BrandCategory: brand={$r[0]} cat={$r[1]}",
        "INSERT INTO brand_category (brand_id, category_id) VALUES (?,?)
         ON DUPLICATE KEY UPDATE brand_id=VALUES(brand_id)",
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
         ON DUPLICATE KEY UPDATE fullname=VALUES(fullname), email=VALUES(email), phone=VALUES(phone), password=VALUES(password)",
        $r
    );
}

// ============================================================
// USERS
// ============================================================
$users = [
    [1, 'rpt.mckkk', 'mck', 'Nghiêm Vũ Hoàng Long', 'nghiemtong@gmail.com', '(012) 345-6789', NULL, NULL, NULL, NULL, 'assets/img/person/mckhutthuocbangchan.jpeg'],
    [22, 'wxrdie', 'wxrdie', 'Phạm Nam Hải', 'wrxdie@gmail.com', '(012) 345-1111', 'Nhà của MCK', 'Hà Nội', 'Phố Quan Hoa', 'Cầu Giấy', 'assets/img/avatars/1774078406_wxrdie.jpg'],
    [23, 'tlinh', 'tlinh', 'Nguyễn Thảo Linh', 'tlinh@gmail.com', '(012) 345-2222', NULL, NULL, NULL, NULL, 'assets/img/avatars/1774079282_tlinhdautroc.jpg'],
    [24, 'longchimloi', 'long123', 'Nguyễn Hoàng Long', 'longchimloi@gmail.com', '0912345678', '12 Nguyễn Trãi', 'Hồ Chí Minh', 'Quận 1', 'Phường Bến Thành', 'assets/img/person/longchimloi.jpg'],
    [25, 'gdragon_vn', 'gd123', 'Kwon Ji Young', 'gdragon@gmail.com', '0934567890', '7 Phạm Ngũ Lão', 'Hồ Chí Minh', 'Quận 1', 'Phường Phạm Ngũ Lão', 'assets/img/person/gdragon.png'],
    [26, 'jackj97', 'jack123', 'Trịnh Trần Phương Tuấn', 'jackj97@gmail.com', '0945678901', '99 Cách Mạng Tháng 8', 'Hồ Chí Minh', 'Quận 10', 'Phường 5', 'assets/img/person/jack.png'],
    [27, 'soicodoc2', 'soi123', 'Nguyễn Văn Sói', 'soicodoc@gmail.com', '0956789012', '33 Đinh Tiên Hoàng', 'Hà Nội', 'Hoàn Kiếm', 'Phường Tràng Tiền', 'assets/img/person/soicodoc.jpg'],
    [28, 'namperfect2', 'nam123', 'Trần Nam Perfect', 'namperfect@gmail.com', '0967890123', '88 Bà Triệu', 'Hà Nội', 'Hai Bà Trưng', 'Phường Bùi Thị Xuân', 'assets/img/person/namperfect.jpg'],
    [29, 'datvantay2', 'dat123', 'Nguyễn Đạt Văn Tây', 'datvantay@gmail.com', '0978901234', '15 Nguyễn Huệ', 'Đà Nẵng', 'Hải Châu', 'Phường Thạch Thang', 'assets/img/person/datvantay.jpg'],
    [30, 'dangrangcom', 'dang123', 'Đặng Rang Cơm', 'dangrangcom@gmail.com', '0989012345', '22 Trần Phú', 'Đà Nẵng', 'Hải Châu', 'Phường Nam Dương', 'assets/img/person/dangrangcom.jpg'],
    [31, 'anhnhancobap', 'anh123', 'Lê Văn Nhân', 'anhnhancobap@gmail.com', '0990123456', '56 Hùng Vương', 'Cần Thơ', 'Ninh Kiều', 'Phường Tân An', 'assets/img/person/anhnhancobap.jpg'],
    [32, 'chautinhtri2', 'chau123', 'Châu Tinh Trì Fan', 'chautinhtri@gmail.com', '0901234567', '100 Võ Văn Tần', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/chautinhtri.jpg'],
];
foreach ($users as $r) {
    runSeed(
        $pdo,
        "User: {$r[1]}",
        "INSERT INTO users (id, username, password, fullname, email, phone, address, city, district, ward, avatar) VALUES (?,?,?,?,?,?,?,?,?,?,?)
         ON DUPLICATE KEY UPDATE fullname=VALUES(fullname), email=VALUES(email), phone=VALUES(phone), address=VALUES(address), city=VALUES(city), district=VALUES(district), ward=VALUES(ward), avatar=VALUES(avatar)",
        $r
    );
}

// ============================================================
// PRODUCTS
// ============================================================
$products = [
    [1, 'Saga A1 DE PRO', 'Guitar Acoustic', 1, 'saga-a1-de-pro-1.jpg,saga-a1-de-pro-2.jpg,saga-a1-de-pro-3.jpg,saga-a1-de-pro-4.jpg,saga-a1-de-pro-5.jpg,saga-a1-de-pro-6.jpg', 'Dòng đàn acoustic chuyên nghiệp với âm thanh mạnh mẽ.', 'Saga A1 DE PRO sở hữu mặt top bằng gỗ nguyên tấm (Solid), mang lại độ vang và ấm vượt trội.', 2000000, 20.00, 0.00, 2400000, 'Âm thanh nội lực', 'Thân đàn lớn giúp cộng hưởng âm thanh cực tốt.', 'Gỗ Solid Spruce', 'Mặt trước làm từ gỗ thông nguyên tấm chọn lọc.', 'Khóa đúc cao cấp', 'Giữ dây ổn định, không bị phô khi chơi lâu.', 'Action thấp', 'Dễ bấm, phù hợp cho người mới và chuyên nghiệp.', '{"fixed":["Bao đàn chính hãng cao cấp (Gig Bag)","Lục giác chỉnh cần (Ty chỉnh cần)"],"others":"Khăn lau đàn"}'],
    [2, 'Taylor A12E', 'Guitar Acoustic', 2, 'taylor-a12e-1.jpg,taylor-a12e-2.jpg,taylor-a12e-3.jpg,taylor-a12e-4.jpg,taylor-a12e-5.jpg,taylor-a12e-6.jpg', 'Huyền thoại của Taylor cho sự thoải mái tối đa.', 'Thiết kế Grand Concert nhỏ gọn với vát cạnh (Armrest) giúp người chơi không bị mỏi tay.', 70000000, 21.43, 0.00, 85000000, 'Thiết kế vát cạnh', 'Tăng sự thoải mái khi tì tay chơi đàn.', 'Hệ thống ES2', 'Bộ thu âm độc quyền cho âm thanh chân thực khi ra loa.', 'Phím đàn Ebony', 'Cảm giác lướt phím cực mượt mà.', 'Thân đàn nhỏ gọn', 'Phù hợp cho fingerstyle và phòng thu.', '{"fixed":["Bao đàn chính hãng cao cấp (Gig Bag)","Dây đàn dự phòng","Capo hoặc Pick"],"others":"Dây đeo da cừu"}'],
    [3, 'Ba đờn C100', 'Guitar Classic', 3, 'badon-c100-1.jpg,badon-c100-2.jpg,badon-c100-3.jpg,badon-c100-4.jpg,badon-c100-5.jpg,badon-c100-6.jpg', 'Đàn guitar cổ điển chất lượng cao sản xuất tại Việt Nam.', 'C100 là lựa chọn hàng đầu cho học sinh sinh viên bắt đầu học guitar cổ điển với âm thanh ấm áp.', 4000000, 25.00, 10.00, 5000000, 'Gỗ thịt 100%', 'Toàn thân được làm từ gỗ thật, càng chơi càng hay.', 'Cần đàn chắc chắn', 'Thiết kế chuẩn classic, dễ cầm nắm.', 'Âm thanh ấm', 'Phù hợp với các bản nhạc trữ tình, cổ điển.', 'Giá thành hợp lý', 'Chất lượng vượt trội trong tầm giá.', '{"fixed":["Lục giác chỉnh cần (Ty chỉnh cần)"],"others":"Giá để nhạc"}'],
    [4, 'Ba Đờn C150', 'Guitar Classic', 3, 'ba-don-c150-1.jpg,ba-don-c150-2.jpg,ba-don-c150-3.jpg,ba-don-c150-4.jpg,ba-don-c150-5.jpg,ba-don-c150-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [5, 'Ba Đờn C170', 'Guitar Classic', 3, 'ba-don-c170-1.jpg,ba-don-c170-2.jpg,ba-don-c170-3.jpg,ba-don-c170-4.jpg,ba-don-c170-5.jpg,ba-don-c170-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [6, 'Ba Đờn C250', 'Guitar Classic', 3, 'ba-don-c250-1.jpg,ba-don-c250-2.jpg,ba-don-c250-3.jpg,ba-don-c250-4.jpg,ba-don-c250-5.jpg,ba-don-c250-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [7, 'Yamaha C40mii C CX', 'Guitar Classic', 4, 'yamaha-c40mii-c-cx-1.jpg,yamaha-c40mii-c-cx-2.jpg,yamaha-c40mii-c-cx-3.jpg,yamaha-c40mii-c-cx-4.jpg,yamaha-c40mii-c-cx-5.jpg,yamaha-c40mii-c-cx-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [8, 'Yamaha GC42S GC GCX', 'Guitar Classic', 4, 'yamaha-gc42s-gc-gcx-1.jpg,yamaha-gc42s-gc-gcx-2.jpg,yamaha-gc42s-gc-gcx-3.jpg,yamaha-gc42s-gc-gcx-4.jpg,yamaha-gc42s-gc-gcx-5.jpg,yamaha-gc42s-gc-gcx-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [9, 'Yamaha GL1 Guitarlele', 'Guitar Classic', 4, 'yamaha-gl1-guitarlele-1.jpg,yamaha-gl1-guitarlele-2.jpg,yamaha-gl1-guitarlele-3.jpg,yamaha-gl1-guitarlele-4.jpg,yamaha-gl1-guitarlele-5.jpg,yamaha-gl1-guitarlele-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [10, 'Saga CC1', 'Guitar Acoustic', 1, 'saga-cc1-1.jpg,saga-cc1-2.jpg,saga-cc1-3.jpg,saga-cc1-4.jpg,saga-cc1-5.jpg,saga-cc1-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [11, 'Saga CL65', 'Guitar Acoustic', 1, 'saga-cl65-1.jpg,saga-cl65-2.jpg,saga-cl65-3.jpg,saga-cl65-4.jpg,saga-cl65-5.jpg,saga-cl65-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [12, 'Saga SS 8CE', 'Guitar Acoustic', 1, 'saga-ss-8ce-1.jpg,saga-ss-8ce-2.jpg,saga-ss-8ce-3.jpg,saga-ss-8ce-4.jpg,saga-ss-8ce-5.jpg,saga-ss-8ce-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [13, 'Enya EA X2', 'Guitar Acoustic', 5, 'enya-ea-x2-1.jpg,enya-ea-x2-2.jpg,enya-ea-x2-3.jpg,enya-ea-x2-4.jpg,enya-ea-x2-5.jpg,enya-ea-x2-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [14, 'Enya EGA X0 PRO SP1', 'Guitar Acoustic', 5, 'enya-ega-x0-pro-sp1-1.jpg,enya-ega-x0-pro-sp1-2.jpg,enya-ega-x0-pro-sp1-3.jpg,enya-ega-x0-pro-sp1-4.jpg,enya-ega-x0-pro-sp1-5.jpg,enya-ega-x0-pro-sp1-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [15, 'Enya EM X1 SP1', 'Guitar Acoustic', 5, 'enya-em-x1-sp1-1.jpg,enya-em-x1-sp1-2.jpg,enya-em-x1-sp1-3.jpg,enya-em-x1-sp1-4.jpg,enya-em-x1-sp1-5.jpg,enya-em-x1-sp1-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [16, 'Taylor 110E', 'Guitar Acoustic', 2, 'taylor-110e-1.jpg,taylor-110e-2.jpg,taylor-110e-3.jpg,taylor-110e-4.jpg,taylor-110e-5.jpg,taylor-110e-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
    [17, 'Yamaha APX1200ii', 'Guitar Acoustic', 4, 'yamaha-apx1200ii-1.jpg,yamaha-apx1200ii-2.jpg,yamaha-apx1200ii-3.jpg,yamaha-apx1200ii-4.jpg,yamaha-apx1200ii-5.jpg,yamaha-apx1200ii-6.jpg', NULL, NULL, 0, 20.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
];
foreach ($products as $r) {
    runSeed(
        $pdo,
        "Product: {$r[1]}",
        "INSERT INTO products (id, product_name, product_type, brand_id, product_images, summary_description, detailed_overview, cost_price, profit_margin, discount_percent, selling_price, highlight_1_title, highlight_1_content, highlight_2_title, highlight_2_content, highlight_3_title, highlight_3_content, highlight_4_title, highlight_4_content, accessories) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
         ON DUPLICATE KEY UPDATE product_name=VALUES(product_name), product_type=VALUES(product_type), brand_id=VALUES(brand_id), product_images=VALUES(product_images), summary_description=VALUES(summary_description), detailed_overview=VALUES(detailed_overview), cost_price=VALUES(cost_price), profit_margin=VALUES(profit_margin), discount_percent=VALUES(discount_percent), selling_price=VALUES(selling_price), highlight_1_title=VALUES(highlight_1_title), highlight_1_content=VALUES(highlight_1_content), highlight_2_title=VALUES(highlight_2_title), highlight_2_content=VALUES(highlight_2_content), highlight_3_title=VALUES(highlight_3_title), highlight_3_content=VALUES(highlight_3_content), highlight_4_title=VALUES(highlight_4_title), highlight_4_content=VALUES(highlight_4_content), accessories=VALUES(accessories)",
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