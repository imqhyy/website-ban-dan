<?php
require_once 'forms/init.php'; ?>
<?php $title = "Thương Hiệu Saga - Guitar Xì Gòn";
include 'forms/head.php' ?>

<body class="page-all">
	<?php include 'forms/header.php' ?>
	<main class="main"> <!-- Page Title -->
		<div class="page-title light-background">
			<div class="container d-lg-flex justify-content-between align-items-center">
				<h1 class="mb-2 mb-lg-0">Thương hiệu: Saga</h1>
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
					<div class="widgets-container"> <!-- Product Categories Widget -->
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

					</div>
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
                                        $main_img  = !empty($images[0]) ? $base_path . trim($images[0]) : 'assets/img/default.jpg';
                                        $hover_img = !empty($images[1]) ? $base_path . trim($images[1]) : $main_img;

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
                                        <li><a href="?page=<?= $currentPage - 1 ?>"><i class="bi bi-arrow-left"></i></a></li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                                        <li>
                                            <a href="?page=<?= $i ?>" class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $maxPage): ?>
                                        <li><a href="?page=<?= $currentPage + 1 ?>"><i class="bi bi-arrow-right"></i></a></li>
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