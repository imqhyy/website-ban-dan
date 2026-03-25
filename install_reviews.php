<?php
require_once __DIR__ . '/forms/init.php';
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id           INT AUTO_INCREMENT PRIMARY KEY,
        product_id   INT NOT NULL,
        user_id      INT NOT NULL,
        rating       TINYINT NOT NULL DEFAULT 5,
        sound_rating TINYINT NOT NULL DEFAULT 5,
        specs_rating TINYINT NOT NULL DEFAULT 5,
        comment      TEXT NOT NULL,
        image_path   VARCHAR(255) DEFAULT NULL,
        is_purchased TINYINT DEFAULT 0,
        status       ENUM('visible','hidden') DEFAULT 'visible',
        created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_review (product_id, user_id),
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "Bang reviews da duoc tao thanh cong!";
} catch(Exception $e) {
    echo "Loi: " . $e->getMessage();
}
?>
