<?php
require_once 'forms/init.php';

// 1. Lấy ID hoặc slug/tên từ URL
$brand_id_param = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
$brand_id = !empty($brand_id_param) ? (int)$brand_id_param[0] : 0;
$brand_name_url = $_GET['brand_name'] ?? '';

// 2. Truy vấn kiểm tra sự tồn tại và trạng thái của Thương hiệu
// Ưu tiên kiểm tra theo ID nếu có, nếu không thì theo tên
$check_brand = getOne("SELECT * FROM brands WHERE (id = ? OR brand_name = ?) AND status = 'visible'", [$brand_id, $brand_name_url]);

// 3. Nếu thương hiệu không tồn tại hoặc bị ẩn (hidden), chuyển hướng ngay
if (!$check_brand) {
    header('Location: all.php');
    exit();
}

$current_brand = $check_brand['brand_name'];
$title = "Thương hiệu $current_brand - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="page-all">
    <?php include 'forms/header.php' ?>
    <main class="main"> <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <?php
                $current_brand = $_GET['brand_name'];
                ?>
                <h1 class="mb-2 mb-lg-0">Thương hiệu: <?= $current_brand ?></h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.php">Trang chủ</a></li>
                        <li class="current">Saga</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar">
                    <form method="GET" action="brand.php" id="filter-product-form">
                        <div class="widgets-container">
                            <!--Tránh để mất lọc thương hiệu dành cho trang brand khi áp dụng các bộ lọc khác-->
                            <?php if (isset($_GET['brand'])): foreach ((array)$_GET['brand'] as $id): ?>
                                    <input type="hidden" name="brand[]" value="<?= htmlspecialchars($id) ?>">
                            <?php endforeach;
                            endif; ?>

                            <input type="hidden" name="brand_name" value="<?= htmlspecialchars($current_brand) ?>">
                            <!--radio chọn hiển thị tất cả hay sản phẩm đang giảm giá-->
                            <div class="promotion-filter-widget widget-item">
                                <h3 class="widget-title">Chương trình ưu đãi</h3>
                                <div class="promo-options">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="filter_promo" value="all" id="promo_all"
                                            <?= (!isset($_GET['filter_promo']) || $_GET['filter_promo'] == 'all') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="promo_all">Tất cả sản phẩm</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="filter_promo" value="discount" id="promo_discount"
                                            <?= (isset($_GET['filter_promo']) && $_GET['filter_promo'] == 'discount') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="promo_discount">Đang giảm giá</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Categories Widget -->
                            <div class="product-categories-widget widget-item">
                                <h3 class="widget-title">Phân loại</h3>
                                <ul class="category-tree list-unstyled mb-0">
                                    <?php
                                    // 1. Lấy danh sách phân loại duy nhất từ bảng products
                                    $sql_types = "SELECT * FROM categories ORDER BY category_name ASC";
                                    $all_types = getAll($sql_types);

                                    // 2. Lấy các loại đang được chọn từ URL (nếu có) để giữ trạng thái checked
                                    $selected_types = isset($_GET['type']) ? (array)$_GET['type'] : [];

                                    // 3. Vòng lặp hiển thị từng loại
                                    if (!empty($all_types)):
                                        foreach ($all_types as $t):
                                            $type_name = $t['category_name']; // Chú ý: dùng category_name thay vì product_type
                                            $type_id = 'type_' . create_slug($type_name);
                                    ?>
                                            <li class="category-item">
                                                <div class="category-header">
                                                    <input class="form-check-input" type="checkbox" name="type[]"
                                                        value="<?= htmlspecialchars($type_name) ?>"
                                                        id="<?= $type_id ?>"
                                                        <?= in_array($type_name, $selected_types) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="<?= $type_id ?>">
                                                        <?= htmlspecialchars($type_name) ?>
                                                    </label>
                                                </div>
                                            </li>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </ul>
                            </div>
                            <!--/Product Categories Widget -->

                            <!-- Pricing Range Widget -->
                            <div class="pricing-range-widget widget-item">
                                <h3 class="widget-title">Khoảng giá</h3>
                                <div class="price-range-container">
                                    <div class="current-range mb-3">
                                        <span class="min-price">0 VND</span>
                                        <span class="max-price float-end">50.000.000 VND</span>
                                    </div>
                                    <div class="range-slider">
                                        <div class="slider-track"></div>
                                        <div class="slider-progress"></div>
                                        <input type="range" class="min-range" min="0" max="100000000" value="<?= str_replace('.', '', $_GET['min_price'] ?? 0) ?>">
                                        <input type="range" class="max-range" min="0" max="100000000" value="<?= str_replace('.', '', $_GET['max_price'] ?? 50000000) ?>">
                                    </div>
                                    <div class="price-inputs mt-3">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">VND</span>
                                                    <!-- ĐỔI type="number" → type="text" -->
                                                    <input type="text" class="form-control min-price-input"
                                                        placeholder="Min" value="<?= $_GET['min_price'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">VND</span>
                                                    <!-- ĐỔI type="number" → type="text" -->
                                                    <input type="text" class="form-control max-price-input"
                                                        placeholder="Max" value="<?= $_GET['max_price'] ?? '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="filter-actions mt-3">
                                        <button type="button" id="btn-apply-price" class="btn btn-sm btn-primary w-100">Áp dụng bộ lọc</button>
                                    </div> -->
                                </div>
                            </div>
                            <!--/Pricing Range Widget -->

                        </div>
                        <div class="filter-group-actions mt-4">
                            <button type="submit" class="btn btn-primary w-100 mb-2 py-2 fw-bold">
                                <i class="bi bi-funnel"></i> Tra cứu
                            </button>
                            <?php
                            // Khởi tạo mảng các tham số gốc cần giữ lại
                            $reset_params = [];

                            // 1. Giữ lại ID thương hiệu
                            if (isset($_GET['brand'])) {
                                $reset_params['brand'] = $_GET['brand'];
                            }

                            // 2. Giữ lại tên thương hiệu (để hiển thị tiêu đề trang)
                            if (isset($_GET['brand_name'])) {
                                $reset_params['brand_name'] = $_GET['brand_name'];
                            }

                            // 3. Giữ lại phân loại (Type) - Đáp ứng yêu cầu của Huy
                            if (isset($_GET['type'])) {
                                $reset_params['type'] = $_GET['type'];
                            }

                            // Tạo chuỗi truy vấn: brand[]=...&brand_name=...&type[]=...
                            $reset_url = "brand.php?" . http_build_query($reset_params);
                            ?>

                            <a href="<?= $reset_url ?>" class="btn btn-outline-secondary w-100 py-2">
                                <i class="bi bi-arrow-counterclockwise"></i> Xóa tất cả
                            </a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-8"> <!-- Category Header Section -->
                    <section id="category-header" class="category-header section">
                        <div class="container" data-aos="fade-up"> </div>
                    </section><!-- /Category Header Section -->




                    <!-- Danh sách sản phẩm -->
                    <?php
                    require_once "forms/modules/products/list.php";
                    ?>
                    <section id="category-product-list" class="category-product-list section">
                        <div class="container" data-aos="fade-up" data-aos-delay="100">
                            <div class="row">
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product):
                                        // 1. Lấy danh sách tên file ảnh từ DB
                                        $images = explode(',', $product['product_images']);

                                        // 2. Tạo đường dẫn thư mục dựa trên quy tắc của bạn
                                        // Ví dụ: "Guitar Classic" -> "guitar_classic", "Saga" -> "saga"
                                        $type_folder = create_slug($product['category_name']);
                                        $brand_folder   = create_slug($product['brand_name']);
                                        $product_folder = create_slug($product['product_name']);

                                        // Kết hợp lại: assets/img/product/guitar/guitar_classic/saga/ten_san_pham/
                                        $base_path = $guitarimg_direct . $type_folder . '/' . $brand_folder . '/' . $product_folder . '/';

                                        // 3. Xác định 2 ảnh đầu tiên (Sử dụng cấu trúc thư mục phân cấp)
                                        $main_img  = !empty($images[0]) ? $base_path . trim($images[0]) : 'assets/img/default-1.jpg';
                                        $hover_img = !empty($images[1]) ? $base_path . trim($images[1]) : 'assets/img/default-2.jpg';

                                        // MỚI: Kiểm tra hết hàng
                                        $is_out_of_stock = ($product['stock_quantity'] <= 0);
                                        // 4. Tính toán giá hiển thị
                                        $has_discount = ($product['discount_percent'] > 0);

                                        // ĐỊNH NGHĨA LẠI THEO Ý HUY:
                                        // 1. Giá niêm yết (Giá gốc bị gạch) chính là giá lưu trong DB
                                        $original_price = $product['selling_price'];

                                        // 2. Giá bán thực tế (Giá hiện màu xanh/đậm) = Giá gốc * (1 - % giảm)
                                        if ($has_discount) {
                                            $selling_price = $original_price * (1 - ($product['discount_percent'] / 100));
                                        } else {
                                            $selling_price = $original_price;
                                        }
                                    ?>

                                        <div class="col-6 col-xl-4">
                                            <div class="product-card" data-aos="zoom-in">
                                                <div class="product-image">
                                                    <a href="product-details.php?id=<?= $product['id'] ?>">
                                                        <img src="<?= $main_img ?>" class="main-image img-fluid <?= $is_out_of_stock ? 'opacity-50' : '' ?>"
                                                            alt="<?= htmlspecialchars($product['product_name']) ?>">

                                                        <img src="<?= $hover_img ?>" class="hover-image img-fluid"
                                                            alt="<?= htmlspecialchars($product['product_name']) ?>">
                                                    </a>

                                                    <?php if ($is_out_of_stock): ?>
                                                        <div class="product-badge bg-secondary text-white" style="left: auto; right: 1rem;">Hết hàng</div>
                                                    <?php elseif ($has_discount): ?>
                                                        <div class="product-badge sale">-<?= round($product['discount_percent']) ?>%</div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="product-details">
                                                    <div class="product-category">
                                                        <?= htmlspecialchars($product['category_name']) ?></div>
                                                    <h4 class="product-title">
                                                        <a
                                                            href="product-details.php?id=<?= $product['id'] ?>"><?= htmlspecialchars($product['product_name']) ?></a>
                                                    </h4>
                                                    <div class="product-meta">
                                                        <div class="product-price">
                                                            <?= number_format($selling_price, 0, ',', '.') ?> VND
                                                                <?php if ($has_discount): ?>
                                                                    <span class="original-price"><?= number_format($original_price, 0, ',', '.') ?> VND</span>
                                                                <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="product-rating"
                                                        style="display: flex; justify-content: flex-end;">
                                                        <i class="bi bi-star-fill"></i> 5.0 <span>(0)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-center py-5">
                                        <p class="text-muted">Hiện chưa có sản phẩm nào để hiển thị.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                    <!-- Hết phần danh sách sản phẩm -->


                    <!-- Category Pagination Section -->
                    <section id="category-pagination" class="category-pagination section">
                        <div class="container">
                            <nav class="d-flex justify-content-center">
                                <ul>
                                    <?php
                                    // Tạo base_url giữ lại brand_name, brand[], type[], giá...
                                    $params = $_GET;
                                    unset($params['page']);
                                    $query = http_build_query($params);
                                    $base_url = "brand.php?" . ($query ? $query . "&" : "");
                                    ?>

                                    <?php if ($currentPage > 1): ?>
                                        <li><a href="<?= $base_url ?>page=<?= $currentPage - 1 ?>"><i class="bi bi-arrow-left"></i></a></li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                                        <li>
                                            <a href="<?= $base_url ?>page=<?= $i ?>" class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $maxPage): ?>
                                        <li><a href="<?= $base_url ?>page=<?= $currentPage + 1 ?>"><i class="bi bi-arrow-right"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </section>
                    <!-- /Category Pagination Section -->
                </div>
            </div>
        </div>
    </main>
    <?php include 'forms/footer.php' ?>
    <?php include 'forms/scripts.php' ?>

</body>