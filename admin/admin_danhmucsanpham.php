<?php
$title = "Quản lý danh mục sản phẩm";
require_once(__DIR__ . '/forms/init.php');
// Nạp file logic vừa tạo ở trên
require_once(__DIR__ . '/forms/danhmucsanpham/list_admin.php'); 
include __DIR__ . "/forms/head.php";

// Lấy danh sách phân loại cho bộ lọc (vẫn giữ nguyên)
$filter_categories = getAll("SELECT * FROM categories ORDER BY category_name ASC");
?>

<body class="login-page">
    <?php require_once __DIR__ . "/forms/header.php" ?>

    <main class="main">

        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Quản lý danh mục sản phẩm</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="admin.html">Trang chủ</a></li>
                        <li class="current">Quản lý danh mục sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-manage-import-products">
            <div class="card custom-add-card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h4 class="fw-semibold text-dark mb-0">Thêm sản phẩm</h4>
                </div>
                <div class="card-body pt-3">
                    <button id="open-add-product" class="add-products-btn">
                        <span>Thêm sản phẩm</span>
                    </button>

                </div>

            </div>

            <div id="addProductModal" class="modal">
                <div class="modal-content-admin" style="max-width: 900px;">
                    <span class="close-button">&times;</span>
                    <h2 class="mb-4">Thêm sản phẩm mới</h2>

                    <form id="add-product-form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên sản phẩm:</label>
                                    <input type="text" name="product_name" class="form-control custom-input"
                                        placeholder="Nhập tên sản phẩm" required>
                                </div>
                                <div class="row">
                                    <?php 
                                    $all_categories = getAll("SELECT * FROM categories"); 
                                    ?>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Phân loại:</label>
                                            <select class="form-select custom-input" id="modal-product-type"
                                                name="product_type">
                                                <option value="" selected disabled required>-- Chọn phân loại --
                                                </option>
                                                <?php foreach($all_categories as $cat): ?>
                                                <option value="<?= htmlspecialchars($cat['category_name']) ?>">
                                                    <?= htmlspecialchars($cat['category_name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Thương hiệu:</label>
                                            <select class="form-select custom-input" id="modal-product-brand"
                                                name="brand_id">
                                                <option value="" selected disabled required>-- Chọn thương hiệu --
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ảnh sản phẩm (Tối đa 6 ảnh):</label>
                                    <input type="file" name="product_images[]" class="form-control custom-input"
                                        multiple accept="image/*" id="product-images-upload">
                                    <div id="image-preview-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Mô tả tóm tắt:</label>
                                    <textarea name="summary_description" class="form-control custom-input" rows="2"
                                        placeholder="Mô tả ngắn gọn về sản phẩm"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tổng quan sản phẩm:</label>
                                    <textarea name="detailed_overview" class="form-control custom-input" rows="4"
                                        placeholder="Thông tin chi tiết về cấu tạo, chất liệu..."></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h4 class="fw-bold mb-3">Thông tin tài chính & Giá bán</h4>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">% Lợi nhuận mong muốn:</label>
                                    <div class="input-group">
                                        <input type="number" name="profit_margin" id="modal-product-profit-margin"
                                            class="form-control custom-input" value="">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">% Giảm giá:</label>
                                    <div class="input-group">
                                        <input type="number" name="discount_percent" id="modal-product-discount"
                                            class="form-control custom-input text-danger" value="0">
                                        <span class="input-group-text text-danger">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h4 class="fw-bold mb-3">Điểm nổi bật</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="highlight-input-group p-3 border rounded shadow-sm">
                                    <span class="badge bg-secondary mb-2">Điểm 1</span>
                                    <input type="text" name="h1_t" class="form-control mb-2 fw-bold"
                                        placeholder="Tiêu đề điểm 1">
                                    <textarea name="highlight_1_content" class="form-control form-control-sm text-muted"
                                        placeholder="Nội dung điểm 1"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="highlight-input-group p-3 border rounded shadow-sm">
                                    <span class="badge bg-secondary mb-2">Điểm 2</span>
                                    <input type="text" name="h2_t" class="form-control mb-2 fw-bold"
                                        placeholder="Tiêu đề điểm 2">
                                    <textarea name="highlight_2_content" class="form-control form-control-sm text-muted"
                                        placeholder="Nội dung điểm 2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="highlight-input-group p-3 border rounded shadow-sm">
                                    <span class="badge bg-secondary mb-2">Điểm 3</span>
                                    <input type="text" name="h3_t" class="form-control mb-2 fw-bold"
                                        placeholder="Tiêu đề điểm 3">
                                    <textarea name="highlight_3_content" class="form-control form-control-sm text-muted"
                                        placeholder="Nội dung điểm 3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="highlight-input-group p-3 border rounded shadow-sm">
                                    <span class="badge bg-secondary mb-2">Điểm 4</span>
                                    <input type="text" name="h4_t" class="form-control mb-2 fw-bold"
                                        placeholder="Tiêu đề điểm 4">
                                    <textarea name="highlight_4_content" class="form-control form-control-sm text-muted"
                                        placeholder="Nội dung điểm 4"></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h4 class="fw-bold mb-3">Phụ kiện đi kèm</h4>
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Mỗi dòng một món:</label>
                            <textarea class="form-control custom-input" name="accessories"
                                id="modal-product-accessories" rows="3"
                                placeholder="Ví dụ: &#10;Dây đeo&#10;Phím gảy"></textarea>
                        </div>

                        <div class="modal-footer-admin d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="cancel-add-product">Hủy bỏ</button>
                            <button type="submit" class="save-all-brands-btn">Lưu sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="editProductModal" class="modal">
                <div class="modal-content-admin" style="max-width: 900px;">
                    <span class="close-button" id="close-edit-modal">&times;</span>
                    <h2 class="mb-4">Chỉnh sửa thông tin sản phẩm</h2>

                    <form id="edit-product-form">
                      <input type="hidden" name="product_id" id="edit-product-id">

                      <div class="row">
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label fw-bold">Tên sản phẩm:</label>
                                  <input type="text" id="edit-product-name" name="product_name" class="form-control custom-input" required>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 mb-3">
                                      <label class="form-label fw-bold">Phân loại:</label>
                                      <select class="form-select custom-input" id="edit-product-type" name="product_type">
                                          <option value="Guitar Acoustic">Guitar Acoustic</option>
                                          <option value="Guitar Classic">Guitar Classic</option>
                                      </select>
                                  </div>
                                  <div class="col-md-6 mb-3">
                                      <label class="form-label fw-bold">Thương hiệu:</label>
                                      <select class="form-select custom-input" id="edit-product-brand" name="brand_id">
                                          </select>
                                  </div>
                              </div>
                              <div class="mb-3">
                                  <label class="form-label fw-bold">Thay đổi ảnh (Tối đa 6 ảnh):</label>
                                  <input type="file" name="product_images[]" class="form-control custom-input" multiple accept="image/*" id="edit-images-upload">
                                  <div id="edit-preview-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label fw-bold">Mô tả tóm tắt:</label>
                                  <textarea id="edit-product-summary" name="summary_description" class="form-control custom-input" rows="2"></textarea>
                              </div>
                              <div class="mb-3">
                                  <label class="form-label fw-bold">Tổng quan sản phẩm:</label>
                                  <textarea id="edit-product-overview" name="detailed_overview" class="form-control custom-input" rows="4"></textarea>
                              </div>
                          </div>
                      </div>

                      <hr>
                      <h4 class="fw-bold mb-3">Thông tin tài chính & Giá bán</h4>
                      <div class="row g-3">
                          <div class="col-md-3">
                              <div class="mb-3">
                                  <label class="form-label fw-bold">% Lợi nhuận:</label>
                                  <div class="input-group">
                                      <input type="number" id="edit-product-profit-margin" name="profit_margin" class="form-control custom-input">
                                      <span class="input-group-text">%</span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="mb-3">
                                  <label class="form-label fw-bold">% Giảm giá:</label>
                                  <div class="input-group">
                                      <input type="number" id="edit-product-discount" name="discount_percent" class="form-control custom-input text-danger">
                                      <span class="input-group-text text-danger">%</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <hr>
                      <h4 class="fw-bold mb-3">Điểm nổi bật</h4>
                      <div class="row g-3">
                          <div class="col-md-6">
                              <div class="highlight-input-group p-3 border rounded shadow-sm">
                                  <span class="badge bg-secondary mb-2">Điểm 1</span>
                                  <input type="text" name="highlight_1_title" id="edit-h1_t" class="form-control mb-2 fw-bold" placeholder="Tiêu đề điểm 1">
                                  <textarea name="highlight_1_content" id="edit-h1_c" class="form-control form-control-sm text-muted" placeholder="Nội dung điểm 1"></textarea>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="highlight-input-group p-3 border rounded shadow-sm">
                                  <span class="badge bg-secondary mb-2">Điểm 2</span>
                                  <input type="text" name="highlight_2_title" id="edit-h2_t" class="form-control mb-2 fw-bold" placeholder="Tiêu đề điểm 2">
                                  <textarea name="highlight_2_content" id="edit-h2_c" class="form-control form-control-sm text-muted" placeholder="Nội dung điểm 2"></textarea>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="highlight-input-group p-3 border rounded shadow-sm">
                                  <span class="badge bg-secondary mb-2">Điểm 3</span>
                                  <input type="text" name="highlight_3_title" id="edit-h3_t" class="form-control mb-2 fw-bold" placeholder="Tiêu đề điểm 3">
                                  <textarea name="highlight_3_content" id="edit-h3_c" class="form-control form-control-sm text-muted" placeholder="Nội dung điểm 3"></textarea>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="highlight-input-group p-3 border rounded shadow-sm">
                                  <span class="badge bg-secondary mb-2">Điểm 4</span>
                                  <input type="text" name="highlight_4_title" id="edit-h4_t" class="form-control mb-2 fw-bold" placeholder="Tiêu đề điểm 4">
                                  <textarea name="highlight_4_content" id="edit-h4_c" class="form-control form-control-sm text-muted" placeholder="Nội dung điểm 4"></textarea>
                              </div>
                          </div>
                      </div>
                      <hr>
                      <h4 class="fw-bold mb-3">Phụ kiện kèm theo</h4>
                      <div class="col-md-12">
                          <textarea class="form-control custom-input" id="edit-product-accessories" name="accessories" rows="3"></textarea>
                      </div>
                      <div class="modal-footer-admin d-flex justify-content-between mt-4">
                          <button type="button" class="btn btn-secondary" id="cancel-edit-product">Hủy bỏ</button>
                          <button type="submit" class="save-all-brands-btn">Lưu thay đổi</button>
                      </div>

                    </form>
                </div>
            </div>
            <!-- Thanh tìm kiếm -->
            <form action="" class="search-container" method="get">
                <!-- Search box -->
                <input type="text" id="search-input" placeholder="Tra cứu sản phẩm" name="search">
                <button id="search-button">
                    <i class="fa fa-search"></i> Tìm kiếm
                </button>
            </form>

            <!-- Bộ lọc -->
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách sản phẩm hiện có</h4>
                </div>
                <div class="sort-danhmucsanpham-container" style="display: flex; padding: 20px; gap: 20px">
                    <div class="col-md-3" style="width: 250px;">
                        <label for="sort-product-category" class="form-label">Loại sản phẩm</label>
                        <select class="form-select custom-input" id="filter-product-type" name="product_type">
                            <option value="" selected>-- Tất cả loại --</option>
                            <?php foreach($filter_categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['category_name']) ?>">
                                <?= htmlspecialchars($cat['category_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3" style="width: 250px;">
                        <label for="sort-product-brand" class="form-label">Thương hiệu</label>
                        <select id="filter-product-brand" class="form-select custom-input" name="brand_id">
                            <option value="">-- Tất cả thương hiệu --</option>
                        </select>
                    </div>
                </div>


                <!--Chỗ này là cái bảng -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover data-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;">ID</th>
                                    <th scope="col" style="width: 22%;">Tên sản phẩm</th>
                                    <th scope="col" style="width: 10%;">Loại</th>
                                    <th scope="col" style="width: 12%;">Thương hiệu</th>
                                    <th scope="col" style="width: 18%;">Giá Vốn</th>
                                    <th scope="col" style="width: 7%;">% Lợi</th>
                                    <th scope="col" style="width: 18%">Giá bán</th>
                                    <th scope="col" style="width: 8%">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody id="product-list-container">
                                <?php if (empty($all_products)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Chưa có sản phẩm nào trong hệ thống.</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($all_products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['id']) ?></td>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td>
                                        <?php 
                        // Hiển thị Acoustic hoặc Classic cho gọn
                        echo str_replace('Guitar ', '', htmlspecialchars($product['product_type'])); 
                    ?>
                                    </td>
                                    <td><?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?></td>
                                    <td><span class="font-weight-bold text-muted">Đang cập nhật...</span></td>
                                    <td><?= htmlspecialchars((float)$product['profit_margin']) ?>%</td>
                                    <td><span class="font-weight-bold text-muted">Đang cập nhật...</span></td>

                                    <td class='function-button-container'>
                                        <button class='action-icon-btn edit-product-btn' title='Sửa'
                                            data-id="<?= $product['id'] ?>">
                                            <i class='bi bi-pencil-square' style='color: #ffc107;'></i>
                                        </button>
                                        <button class="action-icon-btn hide-btn" title="Ẩn">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class='action-icon-btn delete-product-btn' title='Xóa' data-id="<?= $product['id'] ?>">
                                            <i class='bi bi-trash3 text-danger'></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <!-- Category Pagination Section -->
            <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0px;">
                <ul class="d-flex justify-content-center">
                </ul>
            </section>
            <!-- /Category Pagination Section -->

        </div>

    </main>
    <?php require_once __DIR__ . "/forms/footer.php" ?>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <?php 
    require_once __DIR__ . "/forms/scripts.php"
  ?>

</body>





</html>