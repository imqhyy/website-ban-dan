<?php
$title = "Quản lý danh mục sản phẩm";
include __DIR__ . "/forms/head.php";
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
        <div class="modal-content-admin" style="max-width: 900px;"> <span class="close-button">&times;</span>
          <h2 class="mb-4">Thêm sản phẩm mới</h2>
          
          <form id="add-product-form">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-bold">Tên sản phẩm:</label>
                  <input type="text" class="form-control custom-input" placeholder="Nhập tên sản phẩm" required>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Phân loại:</label>
                    <select class="form-select custom-input" id="modal-product-type">
                      <option value="Guitar Acoustic">Guitar Acoustic</option>
                      <option value="Guitar Classic">Guitar Classic</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Thương hiệu:</label>
                    <select class="form-select custom-input" id="modal-product-brand">
                      </select>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Ảnh sản phẩm (Tối đa 6 ảnh):</label>
                  <input type="file" class="form-control custom-input" multiple accept="image/*" id="product-images-upload">
                  <div id="image-preview-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-bold">Mô tả tóm tắt:</label>
                  <textarea class="form-control custom-input" rows="2" placeholder="Mô tả ngắn gọn về sản phẩm"></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Tổng quan sản phẩm:</label>
                  <textarea class="form-control custom-input" rows="4" placeholder="Thông tin chi tiết về cấu tạo, chất liệu..."></textarea>
                </div>
              </div>
            </div>

            <hr>
            <h4 class="fw-bold mb-3">Thông tin tài chính & Giá bán</h4>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Giá nhập (VNĐ):</label>
                        <div class="input-group">
                            <input type="number" id="modal-product-cost-price" class="form-control custom-input bg-light" 
                                  placeholder="0" readonly>
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        </div>
                        <small class="text-info"><i>Lấy từ phiếu nhập gần nhất</i></small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">% Lợi nhuận mong muốn:</label>
                        <div class="input-group">
                            <input type="number" id="modal-product-profit-margin" class="form-control custom-input" value="20">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">% Giảm giá:</label>
                        <div class="input-group">
                            <input type="number" id="modal-product-discount" class="form-control custom-input text-danger" value="0">
                            <span class="input-group-text text-danger">%</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">Giá bán niêm yết:</label>
                        <input type="text" id="modal-product-selling-price" 
                              class="form-control custom-input border-primary fw-bold text-primary" 
                              value="0 VND" readonly>
                        <small class="text-muted">Giá sau khi cộng lời & trừ giảm giá</small>
                    </div>
                </div>
            </div>

            <hr>
            <h4 class="fw-bold mb-3">Điểm nổi bật (Hiển thị 4 khối)</h4>
            <div class="row g-3">
              <script>
                for(let i=1; i<=4; i++) {
                  document.write(`
                    <div class="col-md-6">
                      <div class="highlight-input-group p-3 border rounded shadow-sm">
                        <span class="badge bg-secondary mb-2">Điểm ${i}</span>
                        <input type="text" class="form-control mb-2 fw-bold" placeholder="Tiêu đề in đậm (VD: Âm thanh nội lực)">
                        <textarea class="form-control form-control-sm text-muted" placeholder="Nội dung mờ phía dưới (VD: Âm thanh vang, mạnh mẽ...)"></textarea>
                      </div>
                    </div>
                  `);
                }
              </script>
            </div>

            <hr>
            <h4 class="fw-bold mb-3">Điểm nổi bật (Hiển thị 4 khối)</h4>
            <div class="row g-3" id="accessories-container">
                <div class="col-12 d-flex flex-wrap gap-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input accessory-checkbox" type="checkbox" value="Bao đàn chính hãng cao cấp (Gig Bag)" id="acc1">
                        <label class="form-check-label" for="acc1">Bao đàn Gig Bag</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input accessory-checkbox" type="checkbox" value="Lục giác chỉnh cần (Ty chỉnh cần)" id="acc2">
                        <label class="form-check-label" for="acc2">Lục giác chỉnh cần</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input accessory-checkbox" type="checkbox" value="Dây đàn dự phòng/Bộ dây đi kèm" id="acc3">
                        <label class="form-check-label" for="acc3">Dây dự phòng</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input accessory-checkbox" type="checkbox" value="Capo (Kẹp tăng tông) hoặc Pick (Miếng gảy đàn)" id="acc4">
                        <label class="form-check-label" for="acc4">Capo/Pick</label>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label text-muted small">Hoặc nhập danh sách phụ kiện khác (mỗi dòng một món):</label>
                    <textarea class="form-control custom-input" id="modal-product-accessories" rows="3" 
                              placeholder="Ví dụ: &#10;Dây đeo (Guitar Strap)&#10;Thẻ bảo hành và Hướng dẫn sử dụng"></textarea>
                </div>
            </div>

            <div class="modal-footer-admin d-flex justify-content-between">
              <button type="button" class="btn btn-secondary action-btn-common nutsua" id="cancel-add-product">Hủy bỏ</button>
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
                  <div class="row">
                      <div class="col-md-6">
                          <div class="mb-3">
                              <label class="form-label fw-bold">Tên sản phẩm:</label>
                              <input type="text" id="edit-product-name" class="form-control custom-input" required>
                          </div>
                          <div class="row">
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Phân loại:</label>
                                  <select class="form-select custom-input" id="edit-product-type">
                                      <option value="Guitar Acoustic">Guitar Acoustic</option>
                                      <option value="Guitar Classic">Guitar Classic</option>
                                  </select>
                              </div>
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Thương hiệu:</label>
                                  <select class="form-select custom-input" id="edit-product-brand">
                                      </select>
                              </div>
                          </div>
                          <div class="mb-3">
                              <label class="form-label fw-bold">Thay đổi ảnh (Tối đa 6 ảnh):</label>
                              <input type="file" class="form-control custom-input" multiple accept="image/*" id="edit-images-upload">
                              <div id="edit-preview-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="mb-3">
                              <label class="form-label fw-bold">Mô tả tóm tắt:</label>
                              <textarea id="edit-product-summary" class="form-control custom-input" rows="2"></textarea>
                          </div>
                          <div class="mb-3">
                              <label class="form-label fw-bold">Tổng quan sản phẩm:</label>
                              <textarea id="edit-product-overview" class="form-control custom-input" rows="4"></textarea>
                          </div>
                      </div>
                  </div>

                  <hr>
                  <h4 class="fw-bold mb-3">Thông tin tài chính & Giá bán</h4>
                  <div class="row g-3">
                      <div class="col-md-3">
                          <div class="mb-3">
                              <label class="form-label fw-bold text-muted">Giá nhập (VNĐ):</label>
                              <div class="input-group">
                                  <input type="number" id="modal-product-cost-price" class="form-control custom-input bg-light" 
                                        placeholder="0" readonly>
                                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                              </div>
                              <small class="text-info"><i>Lấy từ phiếu nhập gần nhất</i></small>
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="mb-3">
                              <label class="form-label fw-bold">% Lợi nhuận mong muốn:</label>
                              <div class="input-group">
                                  <input type="number" id="modal-product-profit-margin" class="form-control custom-input" value="20">
                                  <span class="input-group-text">%</span>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="mb-3">
                              <label class="form-label fw-bold">% Giảm giá:</label>
                              <div class="input-group">
                                  <input type="number" id="modal-product-discount" class="form-control custom-input text-danger" value="0">
                                  <span class="input-group-text text-danger">%</span>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="mb-3">
                              <label class="form-label fw-bold text-primary">Giá bán niêm yết:</label>
                              <input type="text" id="modal-product-selling-price" 
                                    class="form-control custom-input border-primary fw-bold text-primary" 
                                    value="0 VND" readonly>
                              <small class="text-muted">Giá sau khi cộng lời & trừ giảm giá</small>
                          </div>
                      </div>
                  </div>

                  <hr>
                  <h4 class="fw-bold mb-3">Phụ kiện kèm theo</h4>
                  <div class="row g-3" id="edit-accessories-container">
                      <div class="col-12 d-flex flex-wrap gap-3 mb-2">
                          <div class="form-check">
                              <input class="form-check-input edit-accessory-checkbox" type="checkbox" value="Bao đàn chính hãng cao cấp (Gig Bag)" id="edit-acc1">
                              <label class="form-check-label" for="edit-acc1">Bao đàn Gig Bag</label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input edit-accessory-checkbox" type="checkbox" value="Lục giác chỉnh cần (Ty chỉnh cần)" id="edit-acc2">
                              <label class="form-check-label" for="edit-acc2">Lục giác chỉnh cần</label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input edit-accessory-checkbox" type="checkbox" value="Dây đàn dự phòng/Bộ dây đi kèm" id="edit-acc3">
                              <label class="form-check-label" for="edit-acc3">Dây dự phòng</label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input edit-accessory-checkbox" type="checkbox" value="Capo (Kẹp tăng tông) hoặc Pick (Miếng gảy đàn)" id="edit-acc4">
                              <label class="form-check-label" for="edit-acc4">Capo/Pick</label>
                          </div>
                      </div>
                      
                      <div class="col-md-12">
                          <label class="form-label text-muted small">Danh sách phụ kiện khác (mỗi dòng một món):</label>
                          <textarea class="form-control custom-input" id="edit-product-accessories" rows="3" 
                                    placeholder="Nhập thêm phụ kiện ngoài danh sách trên..."></textarea>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <!-- Thanh tìm kiếm -->
      <form action="" class="search-container" method="get"><!-- Search box -->
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
          <div class="col-md-3" style="width: 150px;">
            <label for="sort-product-category" class="form-label">Loại sản phẩm</label>
            <select id="sort-product-category" class="form-select">
              <option value="">-- Chọn loại --</option>
              <option value="Acoustic">Acoustic</option>
              <option value="Classic">Classic</option>
            </select>
          </div>

          <div class="col-md-3" style="width: 200px;">
            <label for="sort-product-brand" class="form-label">Thương hiệu</label>
            <select id="sort-product-brand" class="form-select">
              <option value="">-- Chọn thương hiệu --</option>
            </select>
          </div>
        </div>


        <!--Chỗ này là cái bảng -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover data-table">
              <thead>
                <tr>
                  <th scope="col" style="width: 7%;">Hình ảnh</th>
                  <th scope="col" style="width: 25%;">Tên sản phẩm</th>
                  <th scope="col" style="width: 9%;">Loại</th>
                  <th scope="col" style="width: 20%;">Giá Vốn</th>
                  <th scope="col" style="width: 7%;">% Lợi nhuận</th>
                  <th scope="col" style="width: 20%">Giá bán</th>
                  <th scope="col" style="width: 10%">Chức năng</th>
                </tr>
              </thead>
              <tbody id="product-list-container">
                <tr>
                  <td><img
                      src="assets/img/product/guitar/acoustic/saga/saga-a1-de-pro/dan-guitar-acoustic-saga-a1-de-pro--1000x1000.jpg"
                      alt="Saga A1 DE PRO" class="avt-product-mini"></td>
                  <td>Saga A1 DE PRO</td>
                  <td>Acoustic</td>
                  <td><span class="font-weight-bold">2.000.000 VND</span></td>
                  <td>20%</td>
                  <td><span class="font-weight-bold">2.400.000 VND</span></td>

                  <td class="action-cell">
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img
                      src="assets/img/product/guitar/acoustic/taylor/taylor-a12e/dan-guitar-acoustic-taylor-academy-12e-grand-concert-wbag-.jpg"
                      alt="Taylor A12E" class="avt-product-mini"></td>
                  <td>Taylor A12E</td>
                  <td>Acoustic</td>
                  <td><span class="font-weight-bold">70.000.000 VND</span></td>
                  <td>21.43%</td>
                  <td><span class="font-weight-bold">85.000.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img src="assets/img/product/guitar/acoustic/saga/saga-cl65/dan-guitar-acoustic-saga-cl65-.jpg"
                      alt="Saga CL65" class="avt-product-mini"></td>
                  <td>Saga CL65</td>
                  <td>Acoustic</td>
                  <td><span class="font-weight-bold">2.000.000 VND</span></td>
                  <td>20%</td>
                  <td><span class="font-weight-bold">2.400.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img
                      src="assets/img/product/guitar/classic/badon/dan-guitar-classic-ba-don-c100/dan-guitar-classic-ba-don-c100-.jpg"
                      alt="Ba đờn C100" class="avt-product-mini"></td>
                  <td>Ba đờn C100</td>
                  <td>Classic</td>
                  <td><span class="font-weight-bold">4.000.000 VND</span></td>
                  <td>25%</td>
                  <td><span class="font-weight-bold">5.000.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img
                      src="assets/img/product/guitar/classic/yamaha/dan-guitar-classic-yamaha-cgs102aii-school-series/dan-guitar-classic-yamaha-cgs102aii-school-series-.jpg"
                      alt="Yamaha CGS102AII" class="avt-product-mini"></td>
                  <td>Yamaha CGS102AII</td>
                  <td>Classic</td>
                  <td><span class="font-weight-bold">5.600.000 VND</span></td>
                  <td>25%</td>
                  <td><span class="font-weight-bold">7.000.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img
                      src="assets/img/product/guitar/acoustic/enya/enya ega-x0-pro-sp1/dan-guitar-acoustic-enya-ega-x0-pro-sp1-acousticplus-smart-guitar-2-1536x1536.jpg"
                      alt="Enya EGA X0 PRO SP1" class="avt-product-mini"></td>
                  <td>Enya EGA X0 PRO SP1</td>
                  <td>Acoustic</td>
                  <td><span class="font-weight-bold">9.416.667 VND</span></td>
                  <td>20%</td>
                  <td><span class="font-weight-bold">11.300.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img src="assets/img/product/guitar/acoustic/yamaha/yamaha-ls36-are/1.jpg" alt="Yamaha LS36 ARE"
                      class="avt-product-mini"></td>
                  <td>Yamaha LS36 ARE</td>
                  <td>Acoustic</td>
                  <td><span class="font-weight-bold">6.560.000 VND</span></td>
                  <td>25%</td>
                  <td><span class="font-weight-bold">8.200.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
                <tr>
                  <td><img
                      src="assets/img/product/guitar/acoustic/saga/saga-ss-8ce/dan-guitar-acoustic-saga-ss-8ce-.jpg"
                      alt="Saga SS 8CE" class="avt-product-mini"></td>
                  <td>Saga SS 8CE</td>
                  <td>Acoustic</td>
                  <td><span class="font-weight-bold">5.416.667 VND</span></td>
                  <td>20%</td>
                  <td><span class="font-weight-bold">6.500.000 VND</span></td>

                  <td>
                    <button class="edit-btn action-icon-btn edit-product-btn" title="Sửa"><img src="assets/img/iconbutton/pencil.png"
                  class="button-icon" alt="Sửa"></button>
                    <button class="delete-btn action-icon-btn" title="Xoá"><img src="assets/img/iconbutton/trash.png"
                  class="button-icon" alt="Xoá"></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>


      


      <!-- Category Pagination Section -->
      <section id="category-pagination" class="category-pagination section" style="padding-bottom: 0px;">
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
              <li> <a href="#" aria-label="Next page">
                  <span class="d-none d-sm-inline">Sau</span>
                  <i class="bi bi-arrow-right"></i>
                </a> </li>
            </ul>
          </nav>
        </div>
      </section><!-- /Category Pagination Section -->

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