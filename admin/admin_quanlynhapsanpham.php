<?php
$title = "Quản lý nhập sản phẩm";
require_once(__DIR__ . '/forms/init.php');
require_once(__DIR__ . '/forms/quanlynhapsanpham/list.php');
include __DIR__ . "/forms/head.php";
?>

<body class="login-page">
    <?php require_once __DIR__ . "/forms/header.php" ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Quản lý nhập sản phẩm</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="admin.html">Trang chủ</a></li>
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
                                <option value="Guitar Classic">Classic</option>
                                <option value="Guitar Acoustic">Acoustic</option>
                            </select>
                            <label for="manage-product-brands">Thương hiệu:</label>
                            <select class="manage-product-brands">
                                <!-- Điền bằng JS -->
                            </select>
                            <div style="margin-top: 10px; margin-bottom: 20px;">
                                <label>Tên sản phẩm:</label>
                                <input type="text" class="product-name-input" placeholder="Nhập tên sản phẩm"
                                    list="productNameList">
                                <datalist id="productNameList"></datalist>
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
                <input type="text" id="search-input" placeholder="Tìm kiếm mã phiếu nhập" name="search"
                    value="<?= $_GET['search'] ?? '' ?>">
                <button type="submit" id="search-button"><i class="fa fa-search"></i> Tìm kiếm</button>
            </form>

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
                    <?php foreach ($details as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['product_name']) ?></td>
                        <td><?= htmlspecialchars($d['category_name']) ?></td>
                        <td><?= $d['quantity'] ?></td>
                        <td><?= number_format($d['unit_price'], 0, ',', '.') ?> VND</td>
                        <td><?= number_format($d['quantity'] * $d['unit_price'], 0, ',', '.') ?> VND</td>
                    </tr>
                    <?php endforeach; ?>
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
</body>


</html>