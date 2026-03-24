<?php
require_once __DIR__ . '/forms/init.php';

try {
    // Tạo bảng settings
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        setting_key VARCHAR(50) PRIMARY KEY,
        setting_value TEXT
    )");

    // Thêm các dòng mặc định
    $pdo->exec("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES 
        ('mega_sale_end_date', '2026/05/01'),
        ('mega_sale_title', 'Đếm ngược ngày đại ưu đãi'),
        ('mega_sale_desc', 'Nếu bạn đã lỡ tay hoặc vô tình đập đi cây đàn yêu dấu của mình thì đừng buồn, những con số dưới đây biểu hiện cho thời điểm để bạn mua và trải nghiệm một cây đàn cao cấp với mức giá siêu hời.')
    ");

    echo "Database Settings Created Successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
