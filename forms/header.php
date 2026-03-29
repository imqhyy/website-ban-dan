<header id="header" class="header sticky-top">
    <!-- Top Bar -->
    <div class="top-bar py-2 d-none">
        <div class="container-fluid container-xl">
            <div class="row align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <div class="top-bar-item">
                        <i class="bi bi-telephone-fill me-2"></i>
                        <span>Cần giúp đỡ? Liên hệ chúng tôi: </span>
                        <a href="tel:+1234567890">0123456789</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 text-center">
                    <div class="announcement-slider swiper init-swiper">
                        <script type="application/json" class="swiper-config">
                            {
                                "loop": false,
                                "speed": 600,
                                "autoplay": {
                                    "delay": 5000
                                },
                                "slidesPerView": 1,
                                "direction": "vertical",
                                "effect": "slide"
                            }
                        </script>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                🚚 Không miễn phí giao hàng cho đơn hàng trên 2.000.000VND
                            </div>
                            <div class="swiper-slide">
                                💰 Không đảm bảo hoàn tiền trong 30 ngày.
                            </div>
                            <div class="swiper-slide">
                                🎁 Không giảm giá 20% cho đơn hàng đầu tiên
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="container-fluid container-xl">
            <div class="d-flex py-3 align-items-center justify-content-between">
                <!-- Logo -->
                <a href="index.php" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="assets/img/logo.webp" alt=""> -->
                    <h1 class="sitename">Guitar Xì Gòn</h1>
                </a>

                <!-- Search -->
                <form class="search-form desktop-search-form" action="search-results.php" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                        <button class="btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Actions -->
                <div class="header-actions d-flex align-items-center justify-content-end">
                    <!-- Mobile Search Toggle -->
                    <button class="header-action-btn mobile-search-toggle d-xl-none" type="button"
                        data-bs-toggle="collapse" data-bs-target="#mobileSearch" aria-expanded="false"
                        aria-controls="mobileSearch">
                        <i class="bi bi-search"></i>
                    </button>

                    <!-- Account -->
                    <div class="dropdown account-dropdown">
                        <button class="header-action-btn" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <h6>
                                    Chào mừng đến với
                                    <span class="sitename">Guitar Xì Gòn</span>
                                </h6>
                                <p class="mb-0">
                                    Truy cập tài khoản &amp; quản lý đơn hàng
                                </p>
                            </div>
                            <div class="dropdown-body">
                                <a class="dropdown-item d-flex align-items-center" href="account.php#">
                                    <i class="bi bi-person-circle me-2"></i>
                                    <span>Hồ sơ của tôi</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="account.php#orders">
                                    <i class="bi bi-bag-check me-2"></i>
                                    <span>Đơn hàng của tôi</span>
                                </a>
                                <!-- <a class="dropdown-item d-flex align-items-center" href="account.php#wishlist">
                    <i class="bi bi-heart me-2"></i>
                    <span>Danh sách mong muốn</span>
                  </a> -->
                                <a class="dropdown-item d-flex align-items-center" href="account.php#settings">
                                    <i class="bi bi-gear me-2"></i>
                                    <span>Cài đặt</span>
                                </a>
                            </div>
                            <div class="dropdown-footer" id="user-session">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <div class="text-center mb-2">
                                        <span class="d-block text-muted" style="font-size: 0.85rem;">Xin chào,</span>
                                        <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong>
                                    </div>
                                    <a href="logout.php" class="btn btn-danger w-100">Đăng xuất</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary w-100 mb-2">Đăng nhập</a>
                                    <a href="register.php" class="btn btn-outline-primary w-100">Đăng ký</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Cart -->
                    <a href="cart.php" class="header-action-btn">
                        <i class="bi bi-cart3"></i>
                        <span class="badge" id="cart-badge">
                            <?php
                            $cart_count = 0;
                            if (isset($_SESSION['user']) && isset($pdo)) {
                                $session_user = is_array($_SESSION['user']) ? $_SESSION['user']['id'] : $_SESSION['user'];
                                $header_uid = -1; // Đặt mặc định là -1

                                if (!is_numeric($session_user)) {
                                    $stmt_u = $pdo->prepare("SELECT id FROM users WHERE username = ?");
                                    $stmt_u->execute([$session_user]);
                                    $u = $stmt_u->fetch();
                                    if ($u !== false)
                                        $header_uid = $u['id'];
                                } else {
                                    $header_uid = $session_user;
                                }

                                // Chấp nhận cả ID = 0
                                if ($header_uid >= 0) {
                                    $stmt_c = $pdo->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
                                    $stmt_c->execute([$header_uid]);
                                    $cart_count = $stmt_c->fetchColumn() ?: 0;
                                }
                            }
                            echo (int) $cart_count;
                            ?>
                        </span>
                    </a>

                    <!-- Mobile Navigation Toggle -->
                    <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="header-nav">
        <div class="container-fluid container-xl position-relative">
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="all.php">Tất cả sản phẩm</a></li>
                    <li class="dropdown">
                        <a href="#"><span>Phân loại</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <?php
                            // 1. Lấy tất cả Phân loại từ bảng categories mới
                            $header_categories = getAll("SELECT * FROM categories WHERE status = 'visible' ORDER BY category_name ASC");
                            if (!empty($header_categories)):
                                foreach ($header_categories as $cat):
                                    $catID = $cat['id'];
                                    $catName = $cat['category_name'];

                                    // 2. Lấy thương hiệu thông qua bảng trung gian (Chỉ lấy hãng đang hiển thị và có bán loại đàn này)
                                    $sql_brands = "SELECT b.* FROM brands b 
                                        JOIN brand_category bc ON b.id = bc.brand_id 
                                        WHERE bc.category_id = $catID 
                                        AND b.status = 'visible' 
                                        ORDER BY b.brand_name ASC";
                                    $brands_by_type = getAll($sql_brands);
                            ?>
                                    <li class="dropdown">
                                        <a href="category_detail.php?product_type=<?= urlencode($catName) ?>">
                                            <span><?= htmlspecialchars($catName) ?></span>
                                            <i class="bi bi-chevron-right toggle-dropdown"></i>
                                        </a>
                                        <ul>
                                            <?php if (!empty($brands_by_type)): ?>
                                                <?php foreach ($brands_by_type as $brand): ?>
                                                    <li>
                                                        <a href="brand.php?brand[]=<?= $brand['id'] ?>&brand_name=<?= urlencode($brand['brand_name']) ?>&type[]=<?= $catID ?>">
                                                            <?= htmlspecialchars($brand['brand_name']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li><a href="#">Đang cập nhật...</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </li>
                    <li><a href="cart.php">Giỏ Hàng</a></li>
                    <li><a href="checkout.php">Thanh toán</a></li>
                    <li><a href="about.php">Về chúng tôi</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Mobile Search Form -->
    <div class="collapse" id="mobileSearch">
        <div class="container">
            <form class="search-form" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm" />
                    <button class="btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
<?php
// Kiểm tra nếu có lệnh gọi Toast từ bất kỳ trang nào
if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_type'])) {
    echo "<script>
        window.globalToast = {
            type: '" . $_SESSION['toast_type'] . "',
            message: '" . $_SESSION['toast_message'] . "'
        };
    </script>";

    // Đọc xong thì xóa đi để không hiện lại khi F5
    unset($_SESSION['toast_message']);
    unset($_SESSION['toast_type']);
}
?>