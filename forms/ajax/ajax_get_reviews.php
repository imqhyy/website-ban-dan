<?php
require_once __DIR__ . '/../../forms/init.php';

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$reviewFilter = isset($_POST['review_filter']) ? $_POST['review_filter'] : 'all';

if ($product_id <= 0) {
    echo '<p style="text-align:center;color:#9ca3af;padding:40px 0;">Sản phẩm không hợp lệ.</p>';
    exit;
}

// 1. Logic lọc
$reviewConditions = ["r.product_id = ?", "r.status = 'visible'"];
$reviewParams = [$product_id];

if ($reviewFilter === 'image') {
  $reviewConditions[] = "r.image_path IS NOT NULL AND r.image_path != ''";
} elseif ($reviewFilter === 'purchased') {
  $reviewConditions[] = "r.is_purchased = 1";
} elseif (in_array($reviewFilter, ['1', '2', '3', '4', '5'])) {
  $reviewConditions[] = "r.rating = ?";
  $reviewParams[] = (int) $reviewFilter;
}
$reviewWhere = implode(' AND ', $reviewConditions);

// 2. Query lấy đánh giá
$reviews = getAll("SELECT r.*, u.fullname, u.avatar FROM reviews r
    LEFT JOIN users u ON r.user_id = u.id
    WHERE {$reviewWhere}
    ORDER BY r.created_at DESC", $reviewParams);

// 3. Render HTML
if (!empty($reviews)) {
    foreach ($reviews as $rv) {
        $avt = !empty($rv['avatar']) ? $rv['avatar'] : 'assets/img/default-avatar.jpg';
        $fullname = htmlspecialchars($rv['fullname'] ?? 'Ẩn danh');
        $date = date('d/m/Y', strtotime($rv['created_at']));
        $comment = nl2br(htmlspecialchars($rv['comment']));
        $purchasedBadge = $rv['is_purchased'] ? '<span style="font-size:11px;background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:10px;margin-left:6px;">Đã mua</span>' : '';
        
        $starsHtml = '';
        for ($s = 1; $s <= 5; $s++) {
            $starsHtml .= $s <= $rv['rating'] ? '<i class="bi bi-star-fill" style="color:#FBBF24;"></i>' : '<i class="bi bi-star" style="color:#D1D5DB;"></i>';
        }
        
        $imagesHtml = '';
        if (!empty($rv['image_path'])) {
            $imagesHtml .= '<div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;">';
            foreach (explode(',', $rv['image_path']) as $imgPath) {
                $imgPath = trim($imgPath);
                if (!$imgPath) continue;
                $imagesHtml .= '<img src="' . htmlspecialchars($imgPath) . '" alt="Review image" style="width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #E5E7EB;cursor:pointer;" onclick="window.open(this.src,\'_blank\')">';
            }
            $imagesHtml .= '</div>';
        }
        
        $soundStars = '';
        for ($s = 1; $s <= 5; $s++) {
            $soundStars .= $s <= $rv['sound_rating'] ? '★' : '☆';
        }
        
        $specsStars = '';
        for ($s = 1; $s <= 5; $s++) {
            $specsStars .= $s <= $rv['specs_rating'] ? '★' : '☆';
        }

        echo "
        <div class=\"review-card\" style=\"border-bottom:1px solid #f3f4f6;\">
            <div class=\"reviewer-profile\">
                <img src=\"{$avt}\" alt=\"Avatar\" class=\"profile-pic\" style=\"width:46px;height:46px;border-radius:50%;object-fit:cover;\" />
                <div class=\"profile-details\">
                    <div class=\"customer-name\" style=\"font-weight:600;\">{$fullname}{$purchasedBadge}</div>
                    <div class=\"review-meta\" style=\"display:flex;align-items:center;gap:10px;margin-top:4px;\">
                        <div class=\"review-stars\">{$starsHtml}</div>
                        <span class=\"review-date\" style=\"font-size:12px;color:#9ca3af;\">{$date}</span>
                    </div>
                </div>
            </div>
            <div class=\"review-text\" style=\"margin-top:12px;color:#374151;\">
                <p>{$comment}</p>
            </div>
            {$imagesHtml}
            <div style=\"display:flex;gap:20px;margin-top:10px;font-size:13px;color:#6b7280;\">
                <span>Âm thanh: {$soundStars}</span>
                <span>Cấu hình: {$specsStars}</span>
            </div>
        </div>
        ";
    }
} else {
    echo '<p style="text-align:center;color:#9ca3af;padding:40px 0;">Chưa có đánh giá nào phù hợp với thao tác lọc của bạn.</p>';
}
?>
