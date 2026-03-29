<?php
$title = "Quản lý nhập sản phẩm";
require_once(__DIR__ . '/forms/init.php');
require_once(__DIR__ . '/forms/quanlynhapsanpham/list.php');
include __DIR__ . "/forms/head.php";
?>
<style>
    /* Style cho hộp gợi ý tự chế */
    .custom-suggestion-box {
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        margin-top: 2px;
    }

    /* Từng mục sản phẩm */
    .sug-item {
        transition: background 0.2s;
        font-size: 14px;
    }

    .sug-item:hover {
        background-color: #f0f0f0 !important;
        color: #28a745;
        /* Màu xanh giống theme của Huy */
    }

    /* Tùy chỉnh thanh cuộn cho đẹp */
    .custom-suggestion-box::-webkit-scrollbar {
        width: 6px;
    }

    .custom-suggestion-box::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>

<body class="login-page">
    <?php require_once __DIR__ . "/forms/header.php" ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Quản lý nhập sản phẩm</h1>
                <nav class="breadcrumbs">
                    <ol>

                        <li class="current">Quản lý nhập sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->





        <!-- Container phiếu nhập và nơi nhập phiếu -->
        <div class="container-manage-import-products">
            <h2 style="margin: 20px 0px;">Thêm Phiếu Nhập Mới</h2>
            <button class="create-import-btn">Tạo Phiếu Nhập</button>

            <!-- Pop-up Phiếu Nhập Mới -->
            <div id="ImportReceiptModal" class="modal">
                <div class="modal-content-admin">
                    <span class="close-button" id="close-import-modal">&times;</span>
                    <h2>Thông tin phiếu nhập</h2>
                    <div id="import-form-container">
                        <div class="header-fields-row-manage-import">
                            <div class="input-info-manage-import">
                                <label>Ngày nhập:</label>
                                <input type="date">
                            </div>
                            <input type="text" id="import-receipt-code" placeholder="Đang tạo mã..." readonly>
                        </div>
                        <!-- Điền thông tin sản phẩm -->
                        <div class="product-fields-template">
                            <hr>

                            <label for="manage-product-types">Loại sản phẩm:</label>
                            <select class="manage-product-type">
                                <option value="" selected disabled>-- Chọn loại --</option>
                                <?php
                                // Lấy động từ bảng categories đã upload
                                $categories = getAll("SELECT category_name FROM categories WHERE status = 'visible'");
                                foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['category_name']) ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="manage-product-brands">Thương hiệu:</label>
                            <select class="manage-product-brands">
                                <!-- Điền bằng JS -->
                            </select>
                            <div style="margin-top: 10px; margin-bottom: 20px;">
                                <label>Tên sản phẩm:</label>
                                <input type="text" class="product-name-input" placeholder="Nhập tên sản phẩm" autocomplete="off">
                            </div>
                            <label>Số Lượng:</label>
                            <input type="number" min="1" style="width: 40px;">
                            <label>Đơn giá:</label>
                            <input type="text" class="unit-price-input" style="width: 150px;">
                            <br>
                            <button type="button" class="remove-product-btn">Xóa sản phẩm</button>
                            <br>
                        </div>
                        <div id="manage-add-and-save-container">
                            <button id="add-product-fields-template">Thêm sản phẩm</button>
                            <button id="save-import-product">Lưu</button>
                        </div>

                    </div>
                </div>
            </div>


            <hr style="border: 1px solid black;">
            <!-- Danh sách phiếu nhập -->
            <h2>Danh Sách Phiếu Nhập Sản Phẩm</h2>
            <!-- Search -->
            <form action="" class="search-container" method="get">
                <input type="text" id="search-input"
                    placeholder="Tìm mã phiếu hoặc tên sản phẩm..."
                    name="search"
                    value="<?= $_GET['search'] ?? '' ?>">
                <button type="submit" id="search-button"><i class="fa fa-search"></i> Tìm kiếm</button>
            </form>
            <?php if (!empty($_GET['product_id'])):
                // Lấy tên sản phẩm để hiển thị cho thân thiện
                $p_info = getOne("SELECT product_name FROM products WHERE id = ?", [$_GET['product_id']]);
            ?>
                <div class="alert alert-info py-2 d-flex justify-content-between align-items-center mt-3">
                    <span>Đang xem các phiếu nhập có sản phẩm: <strong><?= $p_info['product_name'] ?? 'ID: ' . $_GET['product_id'] ?></strong></span>
                    <a href="admin_quanlynhapsanpham.php" class="btn btn-sm btn-outline-secondary">Xóa lọc</a>
                </div>
            <?php endif; ?>

            <form action="" method="get" class="sort-container">
                <div class="sort-by-date-container">
                    <label>Từ ngày:<input type="date" name="date_from" class="input-sort-date"
                            value="<?= $_GET['date_from'] ?? '' ?>"></label>
                    <label>Đến ngày:<input type="date" name="date_to" class="input-sort-date"
                            value="<?= $_GET['date_to'] ?? '' ?>"></label>
                </div>
                <div class="sort-by-order-status">
                    <label for="sort-order">Sắp xếp:</label>
                    <select id="sort-order" name="sort" class="status-select-custom">
                        <option value="newest"
                            <?= (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : '' ?>>Mới nhất
                        </option>
                        <option value="oldest"
                            <?= (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'selected' : '' ?>>Cũ nhất
                        </option>
                    </select>
                </div>
                <button type="submit" class="status-button"><i class="bi bi-funnel"></i> Tra cứu</button>
            </form>

            <?php if (!empty($receipts)): ?>
                <?php foreach ($receipts as $r):
                    // Lấy chi tiết sản phẩm cho từng phiếu
                    $sqlDetails = "SELECT d.*, p.product_name, c.category_name 
                       FROM import_receipt_details d
                       JOIN products p ON d.product_id = p.id
                       JOIN categories c ON p.category_id = c.id
                       WHERE d.receipt_id = " . $r['id'];
                    $details = getAll($sqlDetails);
                ?>
                    <hr>
                    <h3>Ngày nhập: <?= date("d/m/Y", strtotime($r['import_date'])) ?></h3>
                    <h3>Mã phiếu: <?= htmlspecialchars($r['receipt_code']) ?></h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Sản phẩm</th>
                                <th style="width:10%">Loại</th>
                                <th style="width: 10%;">Số lượng</th>
                                <th style="width: 20%;">Đơn giá</th>
                                <th style="width: 20%;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $index => $d): ?>
                                <tr class="<?= $index > 0 ? 'extra-product d-none' : '' ?>">
                                    <td><?= htmlspecialchars($d['product_name']) ?></td>
                                    <td><?= htmlspecialchars($d['category_name']) ?></td>
                                    <td><?= $d['quantity'] ?></td>
                                    <td><?= number_format($d['unit_price'], 0, ',', '.') ?> VND</td>
                                    <td><?= number_format($d['quantity'] * $d['unit_price'], 0, ',', '.') ?> VND</td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (count($details) > 1): ?>
                                <tr class="toggle-row">
                                    <td colspan="5" class="p-0">
                                        <button type="button"
                                            class="btn btn-link btn-sm text-decoration-none w-100 py-2 show-more-products"
                                            data-count="<?= count($details) - 1 ?>"
                                            style="color: #28a745; font-weight: bold; background: #f8f9fa; border: none;">
                                            <i class="bi bi-chevron-double-down"></i> Xem thêm <?= count($details) - 1 ?> sản phẩm khác
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                                <th><?= number_format($r['total_amount'], 0, ',', '.') ?> VND</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; margin-top: 20px;">Không tìm thấy phiếu nhập nào.</p>
            <?php endif; ?>





            <!-- Category Pagination Section -->
            <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0px;">
                <div class="container">
                    <nav class="d-flex justify-content-center" aria-label="Page navigation">
                        <ul>
                            <?php
                            // Tạo URL giữ nguyên các tham số tìm kiếm
                            $queryData = $_GET;
                            unset($queryData['page']);
                            $queryString = http_build_query($queryData);
                            $baseUrl = "admin_quanlynhapsanpham.php?" . ($queryString ? $queryString . "&" : "");
                            ?>

                            <?php if ($currentPage > 1): ?>
                                <li><a href="<?= $baseUrl ?>page=<?= $currentPage - 1 ?>"><i
                                            class="bi bi-arrow-left"></i></a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $maxPage; $i++): ?>
                                <?php
                                // Logic hiển thị dấu ... nếu quá nhiều trang có thể thêm ở đây 
                                // Hiện tại hiển thị đơn giản giống yêu cầu của Huy
                                ?>
                                <li>
                                    <a href="<?= $baseUrl ?>page=<?= $i ?>"
                                        class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $maxPage): ?>
                                <li><a href="<?= $baseUrl ?>page=<?= $currentPage + 1 ?>"><i
                                            class="bi bi-arrow-right"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </section>
            <!-- /Category Pagination Section -->
        </div>








    </main>

    <?php require_once __DIR__ . "/forms/footer.php" ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php
    require_once __DIR__ . "/forms/scripts.php"
    ?>
    <script src="./assets/js/quanlynhapsanpham.js"></script>
</body>


</html>