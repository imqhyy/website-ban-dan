document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. CHỨC NĂNG MUA NGAY (BUY NOW)
    // ==========================================
    const btnBuyNow = document.getElementById('btn-buy-now');
    const qtyInput = document.getElementById('quantity-input');

    if (btnBuyNow) {
        btnBuyNow.addEventListener('click', function (e) {
            e.preventDefault();

            const productId = this.getAttribute('data-id');
            const quantity = parseInt(qtyInput ? qtyInput.value : 1);

            if (isNaN(quantity) || quantity < 1) {
                Toast.fire({ icon: 'warning', title: 'Số lượng không hợp lệ!' });
                return;
            }

            const formData = new FormData();
            formData.append('action', 'buy_now');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            const originalText = btnBuyNow.innerHTML;
            btnBuyNow.innerHTML = '<i class="spinner-border spinner-border-sm"></i> Đang xử lý...';
            btnBuyNow.style.pointerEvents = 'none';

            fetch('forms/ajax/ajax_cart.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = 'checkout.php?type=buynow';
                    } else {
                        Toast.fire({ icon: 'error', title: data.message }).then(() => {
                            if (data.message.toLowerCase().includes('đăng nhập')) window.location.href = 'login.php';
                        });
                        btnBuyNow.innerHTML = originalText;
                        btnBuyNow.style.pointerEvents = 'auto';
                    }
                })
                .catch(() => {
                    Toast.fire({ icon: 'error', title: 'Không thể kết nối đến máy chủ!' });
                    btnBuyNow.innerHTML = originalText;
                    btnBuyNow.style.pointerEvents = 'auto';
                });
        });
    }

    // ==========================================
    // 2. CHỨC NĂNG THÊM VÀO GIỎ HÀNG (ADD TO CART)
    // ==========================================
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            let quantity = parseInt(qtyInput ? qtyInput.value : 1);
            if (quantity < 1) quantity = 1;

            const formData = new FormData();
            formData.append('action', 'add');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            fetch('forms/ajax/ajax_cart.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Toast.fire({ icon: 'success', title: 'Đã thêm ' + productName + ' vào giỏ!' });
                        if (data.is_new_item) {
                            const badge = document.getElementById('cart-badge');
                            if (badge) badge.innerText = (parseInt(badge.innerText) || 0) + 1;
                        }
                    } else {
                        // Backend sẽ tự báo lỗi nếu chưa đăng nhập hoặc hết hàng
                        Toast.fire({ icon: 'error', title: data.message }).then(() => {
                            if (data.message.toLowerCase().includes('đăng nhập')) window.location.href = 'login.php';
                        });
                    }
                })
                .catch(() => Toast.fire({ icon: 'error', title: 'Không thể kết nối đến máy chủ!' }));
        });
    }

    // ==========================================
    // 3. XỬ LÝ GIAO DIỆN FORM ĐÁNH GIÁ (REVIEW STARS)
    // ==========================================
    const labels = {
        sound: { 1: 'Rất tệ', 2: 'Tệ', 3: 'Tạm ổn', 4: 'Hay', 5: 'Tuyệt phẩm' },
        specs: { 1: 'Rất kém', 2: 'Kém', 3: 'Bình thường', 4: 'Cao cấp', 5: 'Hoàn hảo' }
    };

    function setColor(el, color) {
        let current = el.getAttribute('style') || '';
        current = current.replace(/color\s*:[^;]+;?/gi, '').trim();
        el.setAttribute('style', current + ';color:' + color + ';');
    }

    // Đánh giá chung
    const genItems = Array.from(document.querySelectorAll('#star-general .star-item'));
    const ratingInput = document.getElementById('rating-input');
    if (genItems.length && ratingInput) {
        let curGeneral = 5;
        const paintGeneral = (n) => genItems.forEach(item => {
            const icon = item.querySelector('i');
            if (icon) setColor(icon, parseInt(item.dataset.value) <= n ? '#FBBF24' : '#D1D5DB');
        });
        paintGeneral(5);

        genItems.forEach(item => {
            item.addEventListener('mouseover', () => paintGeneral(parseInt(item.dataset.value)));
            item.addEventListener('click', () => {
                curGeneral = parseInt(item.dataset.value);
                ratingInput.value = curGeneral;
                paintGeneral(curGeneral);
            });
        });
        document.getElementById('star-general')?.addEventListener('mouseleave', () => paintGeneral(curGeneral));
    }

    // Đánh giá chi tiết (Sound & Specs)
    ['sound', 'specs'].forEach(group => {
        const container = document.getElementById('star-' + group);
        const stars = Array.from(document.querySelectorAll('#star-' + group + ' .star-sub'));
        const input = document.getElementById(group + '-input');
        const label = document.getElementById(group + '-label');
        if (!stars.length || !input) return;

        let curSub = 5;
        const paintSub = (n) => {
            stars.forEach(star => setColor(star, parseInt(star.dataset.value) <= n ? '#FBBF24' : '#D1D5DB'));
            if (label) label.textContent = labels[group][n] || '';
            input.value = n;
        };
        paintSub(5);

        stars.forEach(star => {
            star.addEventListener('mouseover', () => paintSub(parseInt(star.dataset.value)));
            star.addEventListener('click', () => {
                curSub = parseInt(star.dataset.value);
                paintSub(curSub);
            });
        });
        container?.addEventListener('mouseleave', () => paintSub(curSub));
    });

    // ==========================================
    // 4. CHỨC NĂNG UPLOAD ẢNH & SUBMIT REVIEW
    // ==========================================
    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        const imagesRow = document.getElementById('review-images-row');
        const addImgBtn = document.getElementById('review-add-img-btn');
        const imageInput = document.getElementById('review-image-input');
        const MAX_IMAGES = 3;
        let selectedFiles = [];

        if (imageInput && addImgBtn) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file || selectedFiles.length >= MAX_IMAGES) return;

                selectedFiles.push(file);
                this.value = '';

                const idx = selectedFiles.length - 1;
                const reader = new FileReader();
                reader.onload = e => {
                    const thumb = document.createElement('div');
                    thumb.style.cssText = 'position:relative;display:inline-block;';
                    thumb.dataset.idx = idx;

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #E5E7EB;display:block;';

                    const rmBtn = document.createElement('button');
                    rmBtn.type = 'button';
                    rmBtn.textContent = '×';
                    rmBtn.style.cssText = 'position:absolute;top:-8px;right:-8px;background:#ef4444;color:white;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:13px;line-height:1;';
                    rmBtn.addEventListener('click', () => {
                        selectedFiles.splice(parseInt(thumb.dataset.idx), 1);
                        imagesRow.querySelectorAll('[data-idx]').forEach((t, i) => t.dataset.idx = i);
                        thumb.remove();
                        if (selectedFiles.length < MAX_IMAGES) addImgBtn.style.display = '';
                    });

                    thumb.appendChild(img);
                    thumb.appendChild(rmBtn);
                    imagesRow.insertBefore(thumb, addImgBtn);

                    if (selectedFiles.length >= MAX_IMAGES) addImgBtn.style.display = 'none';
                };
                reader.readAsDataURL(file);
            });
        }

        let isSubmitting = false;
        reviewForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (isSubmitting) return;

            const comment = document.getElementById('review-comment').value.trim();
            if (comment.length < 15) {
                Toast.fire({ icon: 'warning', title: 'Cảm nhận phải có tối thiểu 15 ký tự!' });
                return;
            }

            const btn = reviewForm.querySelector('button[type=submit]');
            btn.disabled = true;
            btn.textContent = 'Đang gửi...';
            isSubmitting = true;

            const fd = new FormData(reviewForm);
            selectedFiles.forEach(file => fd.append('images[]', file));

            fetch('forms/ajax/ajax_review.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        Toast.fire({ icon: 'success', title: data.message });
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Toast.fire({ icon: 'error', title: data.message });
                        btn.disabled = false; btn.textContent = 'Gửi đánh giá';
                    }
                })
                .catch(() => {
                    Toast.fire({ icon: 'error', title: 'Lỗi kết nối máy chủ' });
                    btn.disabled = false; btn.textContent = 'Gửi đánh giá';
                    isSubmitting = false;
                });
        });
    }

    // ==========================================
    // 5. AJAX LỌC REVIEW
    // ==========================================
    const reviewFilterBtns = document.querySelectorAll('.review-filter-btn');
    const reviewContainer = document.getElementById('top-comment');

    // Lấy Product ID trực tiếp từ URL, không cần nhúng PHP nữa
    const urlParams = new URLSearchParams(window.location.search);
    const filterProductId = urlParams.get('id');

    if (reviewFilterBtns.length > 0 && reviewContainer && filterProductId) {
        reviewFilterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                reviewFilterBtns.forEach(b => {
                    b.style.background = '#f3f4f6';
                    b.style.color = '#374151';
                });
                this.style.background = '#111827';
                this.style.color = '#fff';

                const filterVal = this.dataset.filter;
                reviewContainer.innerHTML = '<p style="text-align:center;padding:40px 0; color:#6b7280;"><i class="bi bi-arrow-repeat spin"></i> Đang tải dữ liệu...</p>';

                const formData = new FormData();
                formData.append('product_id', filterProductId);
                formData.append('review_filter', filterVal);

                fetch('forms/ajax/ajax_get_reviews.php', { method: 'POST', body: formData })
                    .then(res => res.text())
                    .then(html => reviewContainer.innerHTML = html)
                    .catch(() => reviewContainer.innerHTML = '<p style="text-align:center;color:#ef4444;padding:40px 0;">Đã xảy ra lỗi khi lọc đánh giá. Vui lòng thử lại sau.</p>');
            });
        });
    }
});