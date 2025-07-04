// ✅ Cập nhật số lượng hiển thị trên icon giỏ hàng
function updateCartCount() {
    fetch('../backend/cart/get_cart_count.php')
        .then(res => res.json())
        .then(data => {
            const count = data.count || 0;
            const cartCountEl = document.getElementById('cart-count');
            if (cartCountEl) {
                cartCountEl.textContent = count;
                cartCountEl.style.display = count > 0 ? 'inline-block' : 'none';
            }
        })
        .catch(() => console.error("❌ Không thể lấy dữ liệu giỏ hàng."));
}

// ✅ Cập nhật tổng số lượng + tổng tiền
function updateCartSummary() {
    let totalQuantity = 0;
    let totalPrice = 0;

    document.querySelectorAll('table tr').forEach(row => {
        const checkbox = row.querySelector('input[type="checkbox"]');
        const qtyInput = row.querySelector('input[type="number"]');
        const priceCell = row.querySelector('td[data-price]');
        const totalCell = row.querySelector('td[data-total]');

        if (qtyInput && priceCell && totalCell) {
            const quantity = parseInt(qtyInput.value) || 0;
            const price = parseInt(priceCell.getAttribute('data-price')) || 0;
            const lineTotal = quantity * price;

            totalCell.textContent = lineTotal.toLocaleString('vi-VN') + ' VNĐ';

            if (checkbox && checkbox.checked) {
                totalQuantity += quantity;
                totalPrice += lineTotal;
            }
        }
    });

    document.getElementById('total-product').textContent = totalQuantity;
    document.getElementById('total-price').textContent = totalPrice.toLocaleString('vi-VN') + ' VNĐ';
    document.getElementById('subtotal').textContent = totalPrice.toLocaleString('vi-VN') + ' VNĐ';
}

// ✅ Xử lý cập nhật size sản phẩm
function setupSizeChange() {
    document.querySelectorAll('.cart-size-select').forEach(select => {
        select.addEventListener('change', function() {
            const newSize = this.value;
            const index = this.dataset.index;

            fetch('../backend/cart/update_size.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `index=${index}&size=${encodeURIComponent(newSize)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("✅ Đã cập nhật size!");
                } else {
                    alert("❌ Lỗi: " + data.message);
                }
            })
            .catch(() => alert("❌ Không thể cập nhật size."));
        });
    });
}

// ✅ Xử lý thêm vào giỏ hàng
function setupAddToCart() {
    document.querySelectorAll('.add-to-cart-btn, .btn-add-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            const formData = new FormData();
            formData.append('id', btn.dataset.id);
            formData.append('name', btn.dataset.name);
            formData.append('price', btn.dataset.price);
            formData.append('image', btn.dataset.image);
            formData.append('size', btn.dataset.size || '');
            formData.append('quantity', btn.dataset.quantity || 1);

            fetch('../backend/cart/add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message || "✅ Đã thêm vào giỏ hàng!");
                updateCartCount();
            })
            .catch(() => alert("❌ Có lỗi xảy ra khi thêm giỏ hàng!"));
        });
    });
}

// ✅ Gắn sự kiện toàn cục sau khi trang load
document.addEventListener('DOMContentLoaded', function () {
    updateCartCount();
    updateCartSummary();
    setupAddToCart();
    setupSizeChange();

    document.addEventListener('change', function (e) {
        if (
            e.target.matches('input[type="checkbox"]') ||
            e.target.matches('input[type="number"]') ||
            e.target.matches('select.cart-size-select')
        ) {
            updateCartSummary();
            updateCartCount();
        }
    });
});
