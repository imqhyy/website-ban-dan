<?php
require_once 'forms/init.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Phân loại Acoustic - Guitar Xì Gòn</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <link href="assets/css/main.css" rel="stylesheet">
    <!-- ======================================================= * Template Name: NiceShop * Template URL: https://bootstrapmade.com/niceshop-bootstrap-ecommerce-template/ * Updated: Aug 26 2025 with Bootstrap v5.3.7 * Author: BootstrapMade.com * License: https://bootstrapmade.com/license/ ======================================================== -->
</head>

<body class="page-all">
    <?php include 'forms/header.php' ?>
    <main class="main"> <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <?php 
                // Lấy loại sản phẩm hiện tại từ URL
                $current_type = $_GET['product_type'] ?? ''; 
                ?>
                <h1 class="mb-2 mb-lg-0">Phân loại: <?= urldecode($current_type) ?></h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.php">Trang chủ</a></li>
                        <li class="current">Acoustic</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar">
                    <form method="GET" action="category_detail.php" id="filter-product-form">
                        <div class="widgets-container">
                            <!--Đảm bảo khi áp dụng các bộ lọc sẽ không làm mất phân loại sẵn có dành riêng cho trang category_detail-->
                            <input type="hidden" name="product_type" value="<?= htmlspecialchars($_GET['product_type'] ?? '') ?>">
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
                                    <div class="filter-actions mt-3">
                                        <button type="button" id="btn-apply-price" class="btn btn-sm btn-primary w-100">Áp dụng bộ lọc</button>
                                    </div>
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
                                        $selected_brands = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
                                        
                                        foreach ($brands_db as $b):
                                        ?>
                                        <div class="brand-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="brand[]" 
                                                    value="<?= $b['id'] ?>" 
                                                    id="brand_<?= $b['id'] ?>"
                                                    <?= in_array($b['id'], $selected_brands) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="brand_<?= $b['id'] ?>">
                                                    <?= $b['brand_name'] ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <!--/Brand Filter Widget -->
                        </div>
                        <div class="filter-group-actions mt-4">
                            <button type="submit" class="btn btn-primary w-100 mb-2 py-2 fw-bold">
                                <i class="bi bi-funnel"></i> Tra cứu
                            </button>
                            <?php 
                            // Lấy loại sản phẩm hiện tại từ URL
                            $current_type = $_GET['product_type'] ?? ''; 
                            ?>
                            <a href="category_detail.php?product_type=<?= urlencode($current_type) ?>" class="btn btn-outline-secondary w-100 py-2">
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
                                        $type_folder    = create_slug($product['product_type']);
                                        $brand_folder   = create_slug($product['brand_name']);
                                        $product_folder = create_slug($product['product_name']);

                                        // Kết hợp lại: assets/img/product/guitar/guitar_classic/saga/ten_san_pham/
                                        $base_path = $guitarimg_direct . $type_folder . '/' . $brand_folder . '/' . $product_folder . '/';

                                        // 3. Xác định 2 ảnh đầu tiên (Sử dụng cấu trúc thư mục phân cấp)
                                        $main_img  = !empty($images[0]) ? $base_path . trim($images[0]) : 'assets/img/default-1.jpg';
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
                                                    <img src="<?= $main_img ?>" class="main-image img-fluid" alt="<?= htmlspecialchars($product['product_name']) ?>">
                                                    
                                                    <img src="<?= $hover_img ?>" class="hover-image img-fluid" alt="<?= htmlspecialchars($product['product_name']) ?>">
                                                </a>
                                                
                                                <?php if ($has_discount): ?>
                                                    <div class="product-badge sale">-<?= round($product['discount_percent']) ?>%</div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="product-details">
                                                <div class="product-category"><?= htmlspecialchars($product['product_type']) ?></div>
                                                <h4 class="product-title">
                                                    <a href="product-details.php?id=<?= $product['id'] ?>"><?= htmlspecialchars($product['product_name']) ?></a>
                                                </h4>
                                                <div class="product-meta">
                                                    <div class="product-price">
                                                        <?= number_format($selling_price, 0, ',', '.') ?> VND
                                                        <?php if ($has_discount): ?>
                                                            <span class="original-price"><?= number_format($original_price, 0, ',', '.') ?> VND</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="product-rating" style="display: flex; justify-content: flex-end;">
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
                            <nav class="d-flex justify-content-center" aria-label="Page navigation">
                                <ul>
                                    <?php if ($currentPage > 1): ?>
                                    <li><a href="?page=<?= $currentPage - 1 ?>"><i class="bi bi-arrow-left"></i></a>
                                    </li>
                                    <?php endif; ?>

                                    <!--Nếu $maxPage <= phân trang tối đa thì hiện hết phân trang -->
                                    <?php if($maxPage <= $maxPanigation): ?>
                                    <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                                    <li>
                                        <a href="?page=<?= $i ?>" class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    <!--Nếu &maxPage > phân trang tối đa thì rút gọn phân trang -->
                                    <?php else: ?>
                                    <?php 
                                        $startPage = 1;
                                        $endPage = $maxPanigation;
                                        if($currentPage > $maxPanigation) {
                                            echo "<li class='ellipsis'>...</li>";
                                            
                                            /**
                                             *  $currentPage -1 và (currentPage + $maxPanigation -1) -1 
                                             *  để đảm bảo $current luôn nằm giữa thay vì ở 2 bên đầu phân trang
                                             *  nếu currentPage không phải trang 1 và trang cuối
                                             *  VD: <- .., [7], 8, 9, ... -> và <- ..., 5, 6, [7], ... ->
                                             *  sẽ thành: <- ..., 6, [7], 8, ... ->
                                             * 
                                             *  Nếu số lượng trang hiển thị còn lại nhỏ hơn $maxPanigation
                                             *  thì đặt $startPage và &endPage sao cho hiện đủ số lượng $maxPanigation
                                             * */    
                                            $startPage = ($maxPage - $currentPage + 1) < $maxPanigation ? ($maxPage - $maxPanigation + 1): $currentPage - 1;
                                            $endPage = ($currentPage + $maxPanigation - 1) > $maxPage ? $maxPage : ($currentPage + $maxPanigation - 1) -1;
                                        }
                                        else if($currentPage == $maxPanigation) {
                                            echo "<li class='ellipsis'>...</li>";
                                            // Nếu currentPage = maxPagination thì hiện thị trang kế tiếp của currentPage
                                            // vd: <- 1, 2, 3, ... ->
                                            // sẽ thành <- ..., 2, 3, 4, ... ->
                                            $startPage++;
                                            $endPage++;
                                        }
                
                                        for ($i = $startPage; $i <= $endPage; $i++): 
                                    ?>

                                    <li>
                                        <a href="?page=<?= $i ?>" class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>

                                    <?php
                                        if($endPage < $maxPage) {
                                            echo "<li class='ellipsis'>...</li>";
                                        }
                                        
                                    ?>



                                    <?php endif; ?>

                                    <?php if ($currentPage < $maxPage): ?>
                                    <li><a href="?page=<?= $currentPage + 1 ?>"><i class="bi bi-arrow-right"></i></a>
                                    </li>
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