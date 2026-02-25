<?php 
require_once 'forms/db.php'; 

// Truy vấn lấy danh sách sản phẩm
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Tất cả sản phẩm - Guitar Xì Gòn</title>
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
    <main class="main">
        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Tất cả</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.html">Trang chủ</a></li>
                        <li class="current">Tất cả</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 sidebar">
                    <div class="widgets-container">
                        <!-- Product Categories Widget -->
                        <div class="product-categories-widget widget-item">
                            <h3 class="widget-title">Phân loại</h3>
                            <ul class="category-tree list-unstyled mb-0">
                                <!-- Guitar Category -->
                                <li class="category-item">
                                    <div class="d-flex justify-content-between align-items-center category-header collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#categories-1-clothing-subcategories"
                                        aria-expanded="false" aria-controls="categories-1-clothing-subcategories">
                                        <a href="javascript:void(0)" class="category-link"><input
                                                class="form-check-input" type="checkbox" id="brand1"> <label
                                                class="form-check-label" for="brand1">Guitar
                                                Classic</a>
                                    </div>

                                </li> <!-- Electronics Category -->
                                <li class="category-item">
                                    <div class="d-flex justify-content-between align-items-center category-header collapsed"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#categories-1-electronics-subcategories" aria-expanded="false"
                                        aria-controls="categories-1-electronics-subcategories">
                                        <a href="javascript:void(0)" class="category-link"><input
                                                class="form-check-input" type="checkbox" id="brand1"> <label
                                                class="form-check-label" for="brand1">Guitar
                                                Acoustic</a>
                                    </div>

                                </li>
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
                                    <input type="range" class="min-range" min="0" max="100000000" value="0">
                                    <input type="range" class="max-range" min="0" max="100000000" value="5000000">
                                </div>
                                <div class="price-inputs mt-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">VND</span>
                                                <!-- ĐỔI type="number" → type="text" -->
                                                <input type="text" class="form-control min-price-input"
                                                    placeholder="Min" value="0">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">VND</span>
                                                <!-- ĐỔI type="number" → type="text" -->
                                                <input type="text" class="form-control max-price-input"
                                                    placeholder="Max" value="5.000.000">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-actions mt-3">
                                    <button type="button" class="btn btn-sm btn-primary w-100">Áp dụng bộ lọc</button>
                                </div>
                            </div>
                        </div>
                        <!--/Pricing Range Widget -->
                        <!-- Brand Filter Widget -->
                        <div class="brand-filter-widget widget-item">
                            <h3 class="widget-title">Lọc theo thương hiệu</h3>
                            <div class="brand-filter-content">
                                <div class="brand-search"> <input type="text" class="form-control"
                                        placeholder="Tìm kiếm thương hiệu...">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div class="brand-list">
                                    <div class="brand-item">
                                        <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                id="brand1"> <label class="form-check-label" for="brand1"> Ba đờn <span
                                                    class="brand-count">(23)</span>
                                            </label> </div>
                                    </div>
                                    <div class="brand-item">
                                        <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                id="brand1"> <label class="form-check-label" for="brand1"> Saga <span
                                                    class="brand-count">(24)</span>
                                            </label> </div>
                                    </div>
                                    <div class="brand-item">
                                        <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                id="brand2"> <label class="form-check-label" for="brand2"> Tayor
                                                <span class="brand-count">(18)</span>
                                            </label> </div>
                                    </div>
                                    <div class="brand-item">
                                        <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                id="brand3"> <label class="form-check-label" for="brand3"> Enya
                                                <span class="brand-count">(12)</span>
                                            </label> </div>
                                    </div>
                                    <div class="brand-item">
                                        <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                id="brand4"> <label class="form-check-label" for="brand4"> Yamaha
                                                <span class="brand-count">(9)</span>
                                            </label> </div>
                                    </div>
                                </div>
                                <div class="brand-actions"> <button class="btn btn-sm btn-outline-primary">Áp
                                        dụng bộ lọc</button> <button class="btn btn-sm btn-link">Xóa tất
                                        cả</button> </div>
                            </div>
                        </div>
                        <!--/Brand Filter Widget -->
                    </div>
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
                                <?php foreach ($products as $product): ?>
                                <div class="col-6 col-xl-4">
                                    <div class="product-card" data-aos="zoom-in" data-aos-delay="0">
                                        <div class="product-image">
                                            <a href="product-details.php?id=<?= $product['id'] ?>">
                                                <img src="<?= $product['image_main'] ?>" class="main-image img-fluid"
                                                    alt="<?= $product['name'] ?>">
                                                <img src="<?= $product['image_hover'] ?>" class="hover-image img-fluid"
                                                    alt="<?= $product['name'] ?>">
                                            </a>

                                            <?php if ($product['discount_percent'] > 0): ?>
                                            <div class="product-badge sale">-<?= $product['discount_percent'] ?>%</div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-details">
                                            <div class="product-category"><?= $product['category'] ?></div>
                                            <h4 class="product-title">
                                                <a
                                                    href="product-details.php?id=<?= $product['id'] ?>"><?= $product['name'] ?></a>
                                            </h4>
                                            <div class="product-meta">
                                                <div class="product-price">
                                                    <?= number_format($product['price'], 0, ',', '.') ?> VND
                                                    <?php if ($product['original_price'] > $product['price']): ?>
                                                    <span
                                                        class="original-price"><?= number_format($product['original_price'], 0, ',', '.') ?>
                                                        VND</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="product-rating"
                                                style="display: flex; justify-content: flex-end;">
                                                <i class="bi bi-star-fill"></i>
                                                <?= $product['rating'] ?> <span>(<?= $product['review_count'] ?>)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>
                    <!-- Hết phần danh sách sản phẩm -->


                    <!-- Category Pagination Section -->
                    <section id="category-pagination" class="category-pagination section">
                        <div class="container">
                            <nav class="d-flex justify-content-center" aria-label="Page navigation">
                                <ul>
                                    <li> <a href="#" aria-label="Previous page"> <i class="bi bi-arrow-left"></i>
                                            <span class="d-none d-sm-inline">Trước</span>
                                        </a> </li>
                                    <li><a href="#" class="active">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li class="ellipsis">...</li>
                                    <li><a href="#">8</a></li>
                                    <li><a href="#">9</a></li>
                                    <li><a href="#">10</a></li>
                                    <li> <a href="#" aria-label="Next page"> <span class="d-none d-sm-inline">Sau</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a> </li>
                                </ul>
                            </nav>
                        </div>
                    </section><!-- /Category Pagination Section -->
                </div>
            </div>
        </div>
    </main>
    <?php include 'forms/footer.php' ?>
    <!-- Scroll Top --> <a href="#" id="scroll-top"
        class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Preloader -->
    <div id="preloader"></div> <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/drift-zoom/Drift.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script> <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/auth.js"></script>
</body>