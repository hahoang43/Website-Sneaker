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

// ✅ Cập nhật tổng số lượng + tổng tiền bên phải
function updateCartSummary() {
    let totalQuantity = 0;
    let totalPrice = 0;

    document.querySelectorAll('table tr').forEach(row => {
        const checkbox = row.querySelector('input[type="checkbox"]');
        const qtyInput = row.querySelector('input[type="number"]');
        const priceAttr = row.querySelector('td[data-price]');
        const totalCell = row.querySelector('td[data-total]');

        if (qtyInput && priceAttr && totalCell) {
            const quantity = parseInt(qtyInput.value) || 0;
            const price = parseInt(priceAttr.getAttribute('data-price')) || 0;
            const lineTotal = quantity * price;

            totalCell.textContent = lineTotal.toLocaleString('vi-VN') + ' VNĐ';

            if (checkbox && checkbox.checked) {
                totalQuantity += quantity;
                totalPrice += lineTotal;
            }
        }
    });

    // ✅ Cập nhật khu vực đơn hàng bên phải
    const totalProductEl = document.getElementById('total-product');
    const totalPriceEl = document.getElementById('total-price');
    const subtotalEl = document.getElementById('subtotal');

    if (totalProductEl) totalProductEl.textContent = totalQuantity;
    if (totalPriceEl) totalPriceEl.textContent = totalPrice.toLocaleString('vi-VN') + ' VNĐ';
    if (subtotalEl) subtotalEl.textContent = totalPrice.toLocaleString('vi-VN') + ' VNĐ';
}

// ✅ Gửi size mới về server nếu người dùng đổi
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

// ✅ Khởi động toàn bộ sau khi DOM sẵn sàng
document.addEventListener('DOMContentLoaded', function () {
    updateCartCount();
    updateCartSummary();
    setupSizeChange();

    // ✅ Mỗi khi người dùng thay đổi checkbox, số lượng hoặc size → cập nhật lại
    document.addEventListener('input', function (e) {
        if (
            e.target.matches('input[type="number"]') ||
            e.target.matches('input[type="checkbox"]')
        ) {
            updateCartSummary();
            updateCartCount();
        }
    });

    document.addEventListener('change', function (e) {
        if (
            e.target.matches('input[type="checkbox"]') ||
            e.target.matches('select.cart-size-select')
        ) {
            updateCartSummary();
        }
    });
});
