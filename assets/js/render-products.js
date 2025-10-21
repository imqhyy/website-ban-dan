document.addEventListener('DOMContentLoaded', function() {
    
    const productContainer = document.getElementById('product-list-container');

    if (typeof products !== 'undefined' && productContainer) {
        
        let allProductsHTML = ''; 
        products.forEach(product => {
            
            // ... (code xử lý giá, % giảm giá) ...
            let priceHTML = '';
            let badgeHTML = '';
            if (product.originalPrice) {
                priceHTML = `${product.price.toLocaleString('vi-VN')} VND <span class="original-price">${product.originalPrice.toLocaleString('vi-VN')} VND</span>`;
                const discountPercent = Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100);
                badgeHTML = `<div class="product-badge sale">-${discountPercent}%</div>`;
            } else {
                priceHTML = `${product.price.toLocaleString('vi-VN')} VND`;
            }

            // --- TẠO HTML CHO SẢN PHẨM ---
            const productHTML = `
                <div class="col-6 col-xl-4">
                    <div class="product-card" data-aos="zoom-in">
                        <div class="product-image">
                            <a href="product-details.html">
                                <img src="${product.image}" class="main-image img-fluid" alt="${product.name}">
                                <img src="${product.hoverImage}" class="hover-image img-fluid" alt="${product.name}">
                            </a>
                            <div class="product-overlay">
                                <div class="product-actions">
                                    <button type="button" class="action-btn" title="Xem nhanh"><i class="bi bi-eye"></i></button>
                                    <button type="button" class="action-btn" title="Thêm vào giỏ hàng"><i class="bi bi-cart-plus"></i></button>
                                </div>
                            </div>
                            ${badgeHTML} 
                        </div>
                        <div class="product-details">
                            <div class="product-category">${product.category}</div>
                            <h4 class="product-title">
                                <a href="product-details.html">${product.name}</a>
                            </h4>
                            <div class="product-meta">
                                <div class="product-price">
                                    ${priceHTML}
                                </div>
                                <div class="product-rating">
                                    <i class="bi bi-star-fill"></i>
                                    ${product.rating} <span>(${product.reviews})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            allProductsHTML += productHTML; 
        });
        productContainer.innerHTML = allProductsHTML;
    }
});