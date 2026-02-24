<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Thanh toán - Guitar Xì Gòn</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link
      href="assets/vendor/glightbox/css/glightbox.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: NiceShop
  * Template URL: https://bootstrapmade.com/niceshop-bootstrap-ecommerce-template/
  * Updated: Aug 26 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  </head>

  <body class="checkout-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
      <!-- Page Title -->
      <div class="page-title light-background">
        <div
          class="container d-lg-flex justify-content-between align-items-center"
        >
          <h1 class="mb-2 mb-lg-0">Thanh toán</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.html">Trang chủ</a></li>
              <li class="current">Thanh toán</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- End Page Title -->

      <section id="checkout" class="checkout section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row">
            <div class="col-lg-7">
              <div class="checkout-container" data-aos="fade-up">
                <form class="checkout-form" id="checkout-form">
                  <div class="checkout-section">
                    <div class="section-header">
                      <div class="section-number">1</div>
                      <h3>Thông tin khách hàng</h3>
                    </div>
                    <div class="section-content">
                      <!-- <div class="row">
                        <div class="col-md-6 form-group">
                          <label for="first-name">Tên</label>
                          <input
                            type="text"
                            name="first-name"
                            class="form-control"
                            id="first-name"
                          />
                        </div>
                        <div class="col-md-6 form-group">
                          <label for="last-name">Họ</label>
                          <input
                            type="text"
                            name="last-name"
                            class="form-control"
                            id="last-name"
                          />
                        </div>
                      </div> -->

                      <div class="form-group">
                        <label for="hovatennguoinhan"
                          >Họ và tên người nhận</label
                        >
                        <input
                          type="text"
                          value="Long G"
                          class="form-control"
                          name="nameinfo"
                          id="name"
                        />
                      </div>
                      <div class="form-group">
                        <label for="email">Địa chỉ Email</label>
                        <input
                          type="email"
                          value="dragonG@gmai.com"
                          class="form-control"
                          name="email"
                          id="email"
                        />
                      </div>
                      <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input
                          type="phone"
                          class="form-control"
                          name="phone"
                          id="phone"
                          value="(096) 969-6969"
                        />
                      </div>
                      <div class="form-group">
                        <label for="note">Lưu ý</label>
                        <input
                          type="text"
                          class="form-control"
                          name="note"
                          id="note"
                        />
                      </div>
                    </div>
                  </div>

                  <div class="checkout-section">
                    <div class="section-header">
                      <div class="section-number">2</div>
                      <h3>Địa chỉ giao hàng</h3>
                    </div>
                    <div class="section-content">
                      <div class="address-options mb-4">
                        <div class="form-check address-option">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="address-option"
                            id="default-address"
                            value="default"
                            checked
                          />
                          <label class="form-check-label" for="default-address">
                            Địa chỉ Mặc định
                            <i class="bi bi-geo-alt-fill text-danger ms-2"></i>
                          </label>
                          <p id="default-address-display" class="form-text ms-4">273 An Dương Vương, Phường Chợ Quán, Quận 5, Thành phố Hồ Chí Minh</p>
                        </div>
                        <div class="form-check address-option mt-3">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="address-option"
                            id="new-address"
                            value="new"
                          />
                          <label class="form-check-label" for="new-address">
                            Thêm địa chỉ mới
                          <!-- </label> -->
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="address"
                          >Địa chỉ chi tiết (Số nhà, tên đường,
                          phường/xã...)</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="address"
                          id="address"
                          value="273 An Dương Vương, Phường Chợ Quán, Quận 5, Thành phố Hồ Chí Minh"
                          
                        />
                      </div>
                    </div>
                    <div class="checkout-section" id="payment-method">
                      <div class="section-header">
                        <div class="section-number">3</div>
                        <h3>Phương thức thanh toán</h3>
                      </div>
                      <div class="section-content">
                        <div class="payment-options">
                          <div class="payment-option active">
                            <input
                              type="radio"
                              name="payment-method"
                              id="cod"
                              value="COD"
                              checked=""
                            />
                            <label for="cod">
                              <span class="payment-icon"
                                ><i class="bi bi-cash-coin"></i
                              ></span>
                              <span class="payment-label"
                                >Thanh toán khi nhận hàng (COD)</span
                              >
                            </label>
                          </div>
                          <div class="payment-option">
                            <input
                              type="radio"
                              name="payment-method"
                              id="bank-transfer"
                              value="Bank Transfer"
                            />
                            <label for="bank-transfer">
                              <span class="payment-icon"
                                ><i class="bi bi-bank"></i
                              ></span>
                              <span class="payment-label"
                                >Chuyển khoản ngân hàng</span
                              >
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="checkout-section">
                    <div class="section-header">
                      <div class="section-number">3</div>
                      <h3>Hoàn tất đơn hàng</h3>
                    </div>
                    <div class="section-content">
                      <div class="place-order-container">
                        <button
                          type="submit"
                          class="btn btn-primary place-order-btn"
                        >
                          <span class="btn-text">Đặt Hàng</span>
                          <span class="btn-price" id="place-order-btn-price"
                            >0 VNĐ</span
                          >
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-lg-5">
              <div
                class="order-summary"
                data-aos="fade-left"
                data-aos-delay="200"
              >
                <div class="order-summary-header">
                  <h3>Tóm tắt đơn hàng</h3>
                  <span class="item-count" id="item-count">0 sản phẩm</span>
                </div>
                <div class="order-summary-content">
                  <div class="order-items" id="order-summary-items"></div>

                  <div class="order-totals">
                    <div class="order-subtotal d-flex justify-content-between">
                      <span>Tạm tính</span>
                      <span id="order-subtotal">0 VNĐ</span>
                    </div>
                    <div class="order-shipping d-flex justify-content-between">
                      <span>Vận chuyển</span>
                      <span>Miễn phí</span>
                    </div>
                    <div class="order-shipping d-flex justify-content-between">
                      <span>Thuế</span>
                      <span>0 VND</span>
                    </div>
                    <div class="order-total d-flex justify-content-between">
                      <span>Tổng cộng</span>
                      <span id="order-total">0 VNĐ</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <?php include 'forms/footer.php' ?>

    <!-- Scroll Top -->
    <a
      href="#"
      id="scroll-top"
      class="scroll-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/drift-zoom/Drift.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/checkout.js"></script>
  </body>
</html>
