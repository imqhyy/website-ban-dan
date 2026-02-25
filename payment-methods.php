<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Phương thức thanh toán - Guitar Xì Gòn</title>
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

  <body class="payment-methods-page">
    <?php include 'forms/header.php' ?>

    <main class="main">
      <!-- Page Title -->
      <div class="page-title light-background">
        <div
          class="container d-lg-flex justify-content-between align-items-center"
        >
          <h1 class="mb-2 mb-lg-0">Phương thức thanh toán</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.php">Trang chủ</a></li>
              <li class="current">Phương thức thanh toán</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- End Page Title -->

      <!-- Paymnt Methods Section -->
      <section id="paymnt-methods" class="paymnt-methods section">
        <div class="container" data-aos="fade-up">
          <!-- Header -->
          <div class="payment-header text-center" data-aos="fade-up">
            <h2>Payment Methods</h2>
            <p>Choose from our secure and convenient payment options</p>
          </div>

          <!-- Payment Options Grid -->
          <div class="payment-options" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">
              <div class="col-md-6 col-lg-4">
                <div class="payment-card credit-card">
                  <div class="card-content">
                    <div class="icon-box">
                      <i class="bi bi-credit-card"></i>
                    </div>
                    <h4>Credit / Debit Cards</h4>
                    <p>Visa, Mastercard, American Express</p>
                    <div class="accepted-cards">
                      <span class="card-icon visa">Visa</span>
                      <span class="card-icon mastercard">Mastercard</span>
                      <span class="card-icon amex">Amex</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-4">
                <div class="payment-card paypal">
                  <div class="card-content">
                    <div class="icon-box">
                      <i class="bi bi-paypal"></i>
                    </div>
                    <h4>PayPal</h4>
                    <p>Fast and secure online payments</p>
                    <div class="accepted-cards">
                      <span class="card-icon paypal">PayPal</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-4">
                <div class="payment-card bank-transfer">
                  <div class="card-content">
                    <div class="icon-box">
                      <i class="bi bi-bank"></i>
                    </div>
                    <h4>Bank Transfer</h4>
                    <p>Direct bank-to-bank transfers</p>
                    <div class="accepted-cards">
                      <span class="card-icon bank">Bank</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Security Features -->
          <div
            class="security-features"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            <div class="row align-items-center">
              <div class="col-lg-6">
                <div class="security-content">
                  <h3>Secure Payments</h3>
                  <p class="subtitle">Your security is our top priority</p>
                  <ul class="security-list">
                    <li>
                      <i class="bi bi-shield-check"></i>
                      <div class="feature-text">
                        <h5>SSL Encryption</h5>
                        <p>
                          All transactions are protected with 256-bit SSL
                          encryption
                        </p>
                      </div>
                    </li>
                    <li>
                      <i class="bi bi-lock"></i>
                      <div class="feature-text">
                        <h5>PCI Compliant</h5>
                        <p>We follow strict PCI DSS security standards</p>
                      </div>
                    </li>
                    <li>
                      <i class="bi bi-shield-lock"></i>
                      <div class="feature-text">
                        <h5>Fraud Protection</h5>
                        <p>Advanced fraud detection and prevention systems</p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="process-steps">
                  <h4>Payment Process</h4>
                  <div class="steps-list">
                    <div class="step">
                      <div class="step-number">1</div>
                      <div class="step-content">
                        <h5>Choose Payment Method</h5>
                        <p>Select your preferred payment option at checkout</p>
                      </div>
                    </div>
                    <div class="step">
                      <div class="step-number">2</div>
                      <div class="step-content">
                        <h5>Enter Details</h5>
                        <p>Provide your payment information securely</p>
                      </div>
                    </div>
                    <div class="step">
                      <div class="step-number">3</div>
                      <div class="step-content">
                        <h5>Confirm Payment</h5>
                        <p>Review and confirm your payment details</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- FAQ Section -->
          <div class="payment-faqs" data-aos="fade-up" data-aos-delay="300">
            <h3>Payment FAQs</h3>
            <div class="faq-grid">
              <div class="faq-item">
                <h3>
                  When will I be charged?
                  <i class="bi bi-chevron-down faq-toggle"></i>
                </h3>
                <div class="faq-answer">
                  <p>
                    Your payment will be processed immediately after you place
                    your order. The charge will appear on your statement within
                    1-2 business days.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <h3>
                  Is it safe to save my card?
                  <i class="bi bi-chevron-down faq-toggle"></i>
                </h3>
                <div class="faq-answer">
                  <p>
                    Yes, we use industry-standard encryption to protect your
                    payment information. Your card details are never stored on
                    our servers.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <h3>
                  What currencies do you accept?
                  <i class="bi bi-chevron-down faq-toggle"></i>
                </h3>
                <div class="faq-answer">
                  <p>
                    We accept payments in USD, EUR, GBP, and many other major
                    currencies. The available currencies will be shown at
                    checkout.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Support Section -->
          <div class="payment-support" data-aos="fade-up" data-aos-delay="400">
            <div class="support-content">
              <i class="bi bi-headset"></i>
              <h4>Need Help?</h4>
              <p>Our payment support team is available 24/7 to assist you</p>
              <div class="support-actions">
                <a href="#" class="btn-primary">
                  <i class="bi bi-chat-dots"></i>
                  Chat Now
                </a>
                <span class="divider">or</span>
                <a href="#" class="contact-email">
                  <i class="bi bi-envelope"></i>
                  payment.support@example.com
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Paymnt Methods Section -->
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
  </body>
</html>
