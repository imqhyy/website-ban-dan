<?php
require_once 'forms/init.php';
require_once "forms/modules/products/list.php";
?>
<?php $title = "Kết Quả Tìm Kiếm - Guitar Xì Gòn";
include 'forms/head.php';
?>

<body class="search-results-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
        <!-- Search Results Header Section -->
        <section id="search-results-header" class="search-results-header section" style="padding-bottom: 0px;">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="search-results-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="results-count" data-aos="fade-right" data-aos-delay="200">
                                <h2>Kết quả tìm kiếm</h2>
                                <p>
                                    Chúng tôi tìm thấy
                                    <span class="results-number"><?= $maxData ?></span> kết quả cho
                                    <span
                                        class="search-term">"<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                            <form method="GET" action="search-results.php" class="search-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search..." name="search"
                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                        required />
                                    <button class="btn search-btn" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--Tắt bớt đỡ phải code-->
                    <!-- <div class="search-filters mt-4" data-aos="fade-up" data-aos-delay="400">
            <div class="row">
              <div class="col-lg-8">
                <div class="filter-tags">
                  <span class="filter-label">Filters:</span>
                  <div class="tags-wrapper">
                    <span class="filter-tag">
                      Phân loại: Acoustics
                      <i class="bi bi-x-circle"></i>
                    </span>
                    <span class="filter-tag">
                      Date: Last Month
                      <i class="bi bi-x-circle"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="sort-options">
                  <label for="sort-select" class="me-2">Sort by:</label>
                  <select id="sort-select" class="form-select form-select-sm d-inline-block w-auto"
                    style="border-radius: 25px;">
                    <option value="relevance">Liên quan</option>
                    <option value="date-desc">Mới nhất</option>
                    <option value="date-asc">Cũ nhất</option>
                    <option value="title-asc">A-Z</option>
                    <option value="title-desc">Z-A</option>
                  </select>
                </div>
              </div>
            </div>
          </div> -->

                    <div class="advanced-search-bar" data-aos="fade-up" data-aos-delay="400">
                        <form method="GET" action="search-results.php"
                            class="d-flex flex-wrap align-items-center gap-3">
                            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                            <div class="search-item">
                                <label>Sắp xếp:</label>
                                <select name="sort" class="custom-pill-select">

                                    <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                                    <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                                    <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : '' ?>>Tên A-Z</option>
                                    <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : '' ?>>Tên Z-A</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Search Results Header Section -->




        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar">
                    <form method="GET" action="search-results.php" id="filter-product-form">
                        <div class="widgets-container">
                            <!-- Promotion Filter Widget -->
                            <div class="promotion-filter-widget widget-item">
                                <h3 class="widget-title">Chương trình ưu đãi</h3>
                                <div class="promo-options">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="filter_promo" value="all"
                                            id="promo_all"
                                            <?= (!isset($_GET['filter_promo']) || $_GET['filter_promo'] == 'all') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="promo_all">
                                            Tất cả sản phẩm
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="filter_promo"
                                            value="discount" id="promo_discount"
                                            <?= (isset($_GET['filter_promo']) && $_GET['filter_promo'] == 'discount') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="promo_discount">
                                            Đang giảm giá
                                        </label>
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
                                    $selected_types = isset($_GET['type']) ? (array) $_GET['type'] : [];

                                    // 3. Vòng lặp hiển thị từng loại
                                    if (!empty($all_types)):
                                        foreach ($all_types as $t):
                                            $type_name = $t['category_name']; // Chú ý: dùng category_name thay vì product_type
                                            $type_id = 'type_' . create_slug($type_name);
                                            ?>
                                            <li class="category-item">
                                                <div class="category-header">
                                                    <input class="form-check-input" type="checkbox" name="type[]"
                                                        value="<?= $t['id'] ?>" id="<?= $type_id ?>" <?= in_array($t['id'], $selected_types) ? 'checked' : '' ?>>
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
                                        <input type="range" class="min-range" min="0" max="100000000"
                                            value="<?= str_replace('.', '', $_GET['min_price'] ?? 0) ?>">
                                        <input type="range" class="max-range" min="0" max="100000000"
                                            value="<?= str_replace('.', '', $_GET['max_price'] ?? 50000000) ?>">
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

                            <!-- Brand Filter Widget -->
                            <div class="brand-filter-widget widget-item">
                                <h3 class="widget-title">Lọc theo thương hiệu</h3>
                                <div class="brand-filter-content">
                                    <div class="brand-search">
                                        <input type="text" class="form-control" placeholder="Tìm kiếm thương hiệu...">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <div class="brand-list">
                                        <?php
                                        $brands_db = getAll("SELECT * FROM brands ORDER BY brand_name ASC");
                                        $selected_brands = isset($_GET['brand']) ? (array) $_GET['brand'] : [];

                                        foreach ($brands_db as $b):
                                            ?>
                                            <div class="brand-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="brand[]"
                                                        value="<?= $b['id'] ?>" id="brand_<?= $b['id'] ?>"
                                                        <?= in_array($b['id'], $selected_brands) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="brand_<?= $b['id'] ?>">
                                                        <?= $b['brand_name'] ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- <div class="brand-actions">
                                        <button type="button" class="btn btn-sm btn-outline-primary">Áp dụng bộ lọc</button>
                                        <a href="search-results.php?search=<?= urlencode($_GET['search'] ?? '') ?>" class="btn btn-sm btn-link">Xóa tất cả</a>
                                    </div> -->
                                </div>
                            </div>
                            <!--/Brand Filter Widget -->
                        </div>
                        <div class="filter-group-actions mt-4">
                            <button type="submit" class="btn btn-primary w-100 mb-2 py-2 fw-bold">
                                <i class="bi bi-funnel"></i> Tra cứu
                            </button>
                            <a href="search-results.php?search=<?= urlencode($_GET['search'] ?? '') ?>"
                                class="btn btn-outline-secondary w-100 py-2">
                                <i class="bi bi-arrow-counterclockwise"></i> Xóa tất cả
                            </a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-8">
                    <!-- Category Header Section -->
                    <section id="category-header" class="category-header section">
                        <div class="container" data-aos="fade-up"> </div>
                    </section><!-- /Category Header Section -->




                    <!-- Danh sách sản phẩm -->
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
                                        $brand_folder = create_slug($product['brand_name']);
                                        $product_folder = create_slug($product['product_name']);

                                        // Kết hợp lại: assets/img/product/guitar/guitar_classic/saga/ten_san_pham/
                                        $base_path = $guitarimg_direct . $type_folder . '/' . $brand_folder . '/' . $product_folder . '/';

                                        // 3. Xác định 2 ảnh đầu tiên (Sử dụng cấu trúc thư mục phân cấp)
                                        $main_img = !empty($images[0]) ? $base_path . trim($images[0]) : 'assets/img/default-1.jpg';
                                        $hover_img = !empty($images[1]) ? $base_path . trim($images[1]) : 'assets/img/default-2.jpg';

                                        // 4. Tính toán giá hiển thị
                                        $has_discount = ($product['discount_percent'] > 0);
                                        $selling_price = $product['selling_price'];
                                        $original_price = $has_discount ? ($selling_price / (1 - ($product['discount_percent'] / 100))) : 0;
                                        ?>

                                        <div class="col-6 col-xl-4">
                                            <div class="product-card" data-aos="zoom-in">
                                                <div class="product-image">
                                                    <a href="product-details.php?id=<?= $product['id'] ?>">
                                                        <img src="<?= $main_img ?>" class="main-image img-fluid"
                                                            alt="<?= htmlspecialchars($product['product_name']) ?>">

                                                        <img src="<?= $hover_img ?>" class="hover-image img-fluid"
                                                            alt="<?= htmlspecialchars($product['product_name']) ?>">
                                                    </a>

                                                    <?php if ($has_discount): ?>
                                                        <div class="product-badge sale">-<?= round($product['discount_percent']) ?>%
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="product-details">
                                                    <div class="product-category">
                                                        <?= htmlspecialchars($product['category_name']) ?>
                                                    </div>
                                                    <h4 class="product-title">
                                                        <a
                                                            href="product-details.php?id=<?= $product['id'] ?>"><?= htmlspecialchars($product['product_name']) ?></a>
                                                    </h4>
                                                    <div class="product-meta">
                                                        <div class="product-price">
                                                            <?= number_format($selling_price, 0, ',', '.') ?> VND
                                                            <?php if ($has_discount): ?>
                                                                <span
                                                                    class="original-price"><?= number_format($original_price, 0, ',', '.') ?>
                                                                    VND</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="product-rating"
                                                        style="display: flex; justify-content: flex-end; align-items:center; gap:4px; font-size:14px;">
                                                        <?php
                                                        $avg_r = (float) ($product['avg_rating'] ?? 0);
                                                        $tot_r = (int) ($product['total_reviews'] ?? 0);
                                                        ?>
                                                        <i class="bi bi-star-fill"
                                                            style="color:<?= $tot_r > 0 ? '#FBBF24' : '#D1D5DB' ?>;"></i>
                                                        <span
                                                            style="font-weight:600;color:<?= $tot_r > 0 ? '#111827' : '#9CA3AF' ?>;"><?= $tot_r > 0 ? number_format($avg_r, 1) : '0.0' ?></span>
                                                        <span style="color:#9CA3AF;">(<?= $tot_r ?>)</span>
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
                            <nav class="d-flex justify-content-center" aria-label="Page navigation">
                                <ul>
                                    <?php
                                    // Tạo base_url chứa sẵn các filter hiện tại (trừ page)
                                    $params = $_GET;
                                    unset($params['page']);
                                    $query = http_build_query($params);
                                    $base_url = "search-results.php?" . ($query ? $query . "&" : "");
                                    ?>

                                    <?php if ($currentPage > 1): ?>
                                        <li><a href="<?= $base_url ?>page=<?= $currentPage - 1 ?>"><i
                                                    class="bi bi-arrow-left"></i></a></li>
                                    <?php endif; ?>

                                    <?php if ($maxPage <= $maxPanigation): ?>
                                        <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                                            <li>
                                                <a href="<?= $base_url ?>page=<?= $i ?>"
                                                    class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    <?php else: ?>
                                        <?php
                                        $startPage = 1;
                                        $endPage = $maxPanigation;
                                        if ($currentPage > $maxPanigation) {
                                            echo "<li class='ellipsis'>...</li>";
                                            $startPage = ($maxPage - $currentPage + 1) < $maxPanigation ? ($maxPage - $maxPanigation + 1) : $currentPage - 1;
                                            $endPage = ($currentPage + $maxPanigation - 1) > $maxPage ? $maxPage : ($currentPage + $maxPanigation - 1) - 1;
                                        } else if ($currentPage == $maxPanigation) {
                                            echo "<li class='ellipsis'>...</li>";
                                            $startPage++;
                                            $endPage++;
                                        }

                                        for ($i = $startPage; $i <= $endPage; $i++):
                                            ?>
                                            <li>
                                                <a href="<?= $base_url ?>page=<?= $i ?>"
                                                    class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($endPage < $maxPage)
                                            echo "<li class='ellipsis'>...</li>"; ?>
                                    <?php endif; ?>

                                    <?php if ($currentPage < $maxPage): ?>
                                        <li><a href="<?= $base_url ?>page=<?= $currentPage + 1 ?>"><i
                                                    class="bi bi-arrow-right"></i></a></li>
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

</html>