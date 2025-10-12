document.addEventListener('DOMContentLoaded', function() {
    // 1. Lấy id sản phẩm từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = parseInt(urlParams.get('id'));

    // 2. Tìm sản phẩm trong "cơ sở dữ liệu"
    const product = products.find(p => p.id === productId);

    // 3. Nếu không tìm thấy sản phẩm, báo lỗi
    if (!product) {
        document.querySelector('.product-details.section .container').innerHTML = 
            '<h1 class="text-center py-5">Lỗi: Sản phẩm không tồn tại!</h1>';
        return;
    }

    // 4. Lấy tất cả các phần tử HTML cần điền thông tin
    const productName = document.getElementById('product-name');
    const productBreadcrumb = document.querySelector('.page-title .current');
    const productDescription = document.getElementById('product-description');
    const mainImage = document.getElementById('main-product-image');
    const priceContainer = document.getElementById('product-price-container');
    const savingsContainer = document.getElementById('product-savings-container');
    const categoryBadge = document.getElementById('product-category');
    const ratingContainer = document.getElementById('product-rating-container');
    const stockStatus = document.getElementById('product-stock-status');
    const stockQuantity = document.getElementById('product-stock-quantity');
    const quantityInput = document.getElementById('quantity-input');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    // 5. Điền thông tin sản phẩm vào trang
    document.title = `${product.name} - Guitar Xì Gòn`;
    productName.textContent = product.name;
    if(productBreadcrumb) productBreadcrumb.textContent = product.name;
    productDescription.textContent = product.description;
    mainImage.src = product.image;
    mainImage.alt = product.name;
    // Cập nhật cả data-zoom cho hiệu ứng zoom ảnh
    if (mainImage.classList.contains('drift-zoom')) {
      mainImage.setAttribute('data-zoom', product.image);
    }
    categoryBadge.textContent = product.category;

    if (product.originalPrice) {
        priceContainer.innerHTML = `<span class="sale-price">${product.price.toLocaleString('vi-VN')} VNĐ</span> <span class="regular-price">${product.originalPrice.toLocaleString('vi-VN')} VNĐ</span>`;
        const savedAmount = product.originalPrice - product.price;
        const discountPercent = Math.round((savedAmount / product.originalPrice) * 100);
        savingsContainer.innerHTML = `<span class="save-amount">Tiết kiệm ${savedAmount.toLocaleString('vi-VN')} VNĐ</span> <span class="discount-percent">(${discountPercent}% off)</span>`;
    } else {
        priceContainer.innerHTML = `<span class="sale-price">${product.price.toLocaleString('vi-VN')} VNĐ</span>`;
        savingsContainer.innerHTML = '';
    }

    ratingContainer.innerHTML = `<div class="stars">${'★'.repeat(Math.floor(product.rating))}<span>${'☆'.repeat(5 - Math.floor(product.rating))}</span></div> <span class="review-text">(${product.reviews} đánh giá)</span>`;
    stockStatus.textContent = product.stock > 0 ? 'Còn hàng' : 'Hết hàng';
    stockQuantity.textContent = `Chỉ còn ${product.stock} sản phẩm`;
    quantityInput.max = product.stock;

    // --- XỬ LÝ NÚT TĂNG/GIẢM SỐ LƯỢNG ---
    document.querySelector('.quantity-btn.increase').addEventListener('click', () => {
        if (parseInt(quantityInput.value) < product.stock) {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }
    });
    document.querySelector('.quantity-btn.decrease').addEventListener('click', () => {
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });

    // --- XỬ LÝ THÊM VÀO GIỎ HÀNG ---
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const quantity = parseInt(quantityInput.value);
            if (quantity < 1) { return; }

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id === product.id);

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ id: product.id, name: product.name, price: product.price, image: product.image, quantity: quantity });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            Toast.fire({ icon: 'success', title: `Đã thêm ${quantity} sản phẩm vào giỏ hàng!` });
            updateCartIcon();
        });
    }
});

function updateCartIcon() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.querySelector('.header-actions .bi-cart3 + .badge');
    if (cartBadge) {
        cartBadge.textContent = totalItems;
    }
}
setTimeout(updateCartIcon, 200);