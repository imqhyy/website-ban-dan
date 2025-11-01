// Dán code này vào file assets/js/product-details.js
// Đây là code cho Cách 2 (trang tĩnh)

document.addEventListener("DOMContentLoaded", function () {
  // Luôn luôn lấy sản phẩm có id = 1 làm mẫu để thêm vào giỏ
  const sampleProductID = 1;
  const productToAdd = products.find((p) => p.id === sampleProductID);

  if (!productToAdd) {
    console.error(
      "Lỗi: Không tìm thấy sản phẩm mẫu (id=1) trong file products.js"
    );
    return;
  }

  const quantityInput = document.getElementById("quantity-input");
  const addToCartBtn = document.getElementById("add-to-cart-btn");
  const increaseBtn = document.querySelector(".quantity-btn.increase");
  const decreaseBtn = document.querySelector(".quantity-btn.decrease");

  // if (increaseBtn) {
  //     increaseBtn.addEventListener('click', () => {
  //         let currentVal = parseInt(quantityInput.value);
  //         quantityInput.value = currentVal + 1;
  //     });
  // }
  // if (decreaseBtn) {
  //     decreaseBtn.addEventListener('click', () => {
  //         let currentVal = parseInt(quantityInput.value);
  //         if (currentVal > 1) {
  //             quantityInput.value = currentVal - 1;
  //         }
  //     });
  // }

  if (addToCartBtn) {
    addToCartBtn.addEventListener("click", function () {
      const quantity = parseInt(quantityInput.value);
      if (quantity < 1) return;

      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      const existingItem = cart.find((item) => item.id === productToAdd.id);

      if (existingItem) {
        existingItem.quantity += quantity;
      } else {
        cart.push({
          id: productToAdd.id,
          name: productToAdd.name,
          price: productToAdd.price,
          image: productToAdd.image,
          quantity: quantity,
        });
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      Toast.fire({
        icon: "success",
        title: `Đã thêm ${quantity} "${productToAdd.name}" vào giỏ hàng!`,
      });

      updateCartIcon();
    });
  }
});

// // Hàm update icon giỏ hàng (phải có trong file auth.js hoặc ở đây)
// function updateCartIcon() {
//     let cart = JSON.parse(localStorage.getItem('cart')) || [];
//     const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
//     const cartBadges = document.querySelectorAll('.cart-item-count-badge');
//     cartBadges.forEach(badge => {
//         if (badge) {
//             badge.textContent = totalItems;
//         }
//     });
// }
// setTimeout(updateCartIcon, 200);
