<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$selectedIndexes = $_POST['selected_items'] ?? [];
$quantities = $_POST['quantities'] ?? [];
$sizes = $_POST['sizes'] ?? [];

$selectedCart = [];

// Gán sản phẩm được chọn vào mảng selectedCart
foreach ($selectedIndexes as $index) {
    $index = (int)$index;
    if (isset($cart[$index])) {
        $item = $cart[$index];
        // Cập nhật số lượng nếu có
        if (isset($quantities[$index])) {
            $item['quantity'] = max(1, (int)$quantities[$index]);
        }
        // Cập nhật size nếu có
        if (isset($sizes[$index])) {
            $item['size'] = $sizes[$index];
        }
        $selectedCart[] = $item;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SNEAKERS - Thanh toán</title>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>

<!-- Header -->
<div class="header">
    <div class="logo">
        <h2><a href="index.php"><img src="../images/anh_banner/logo.jpg"></a></h2>
    </div>
    <div class="search-container">
        <input type="text">
        <i class="fas fa-search search-icon"></i>
    </div>
    <div class="sign">
        <a href="dangnhap.php" class="cart-btn"><i class="fa-solid fa-user"></i></a>
        <a href="giohang.php" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>

<!-- Menu -->
<div class="menu">
    <a href="index.php">Trang chủ</a>
    <a href="danhmuc/giaynam.php">Giày Nam</a>
    <a href="danhmuc/giaynu.php">Giày Nữ</a>
    <a href="danhmuc/giaytreem.php">Giày trẻ em</a>
    <a href="danhmuc/phukiengiay.php">Phụ kiện giày</a>
</div>

<!-- Body -->
<div class="cart">
    <div class="cart-top-wrap">
        <div class="cart-top">
            <div class="step-cart"><i class="fa fa-shopping-cart"></i></div>
            <div class="step-fill"><i class="fa fa-map-marker-alt"></i></div>
            <div class="step-payment"><i class="fa fa-credit-card"></i></div>
        </div>
    </div>
</div>

<section class="payment">
    <div class="container">
        <form id="checkout-form" action="giaohang.php" method="post" style="display: flex; width: 100%;">
            <div class="container-left" style="width:70%;">
                <table>
                    <tr>
                        <th>Chọn</th>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                    <?php if (empty($selectedCart)): ?>
                        <tr><td colspan="7" style="text-align:center;">🛒 Giỏ hàng đang trống</td></tr>
                    <?php else: ?>
                        <?php foreach ($selectedCart as $index => $item): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_items[]" value="<?= $index ?>" checked></td>
                           <td><img src="../uploads/<?= htmlspecialchars($item['image']) ?>" width="80"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <select name="sizes[<?= $index ?>]" class="cart-size-select" data-index="<?= $index ?>">
                                    <?php for ($sizeVal = 38; $sizeVal <= 43; $sizeVal++): ?>
                                        <option value="<?= $sizeVal ?>" <?= ($sizeVal == $item['size']) ? 'selected' : '' ?>>
                                            <?= $sizeVal ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantities[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1" class="quantity-input" data-index="<?= $index ?>">
                            </td>
                            <td data-unit-price="<?= $item['price'] ?>">
                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ
                            </td>
                            <td>
                                <a href="../backend/cart/remove_item.php?index=<?= $index ?>" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
                <div class="total" style="text-align:right; margin-top:10px;">
                    <p>Tổng cộng: <span id="total-price">
                        <?php
                        $total = 0;
                        foreach ($selectedCart as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        echo number_format($total, 0, ',', '.') . ' VNĐ';
                        ?>
                    </span></p>
                </div>
            </div>

            <div class="right" style="width:30%;">
                <div class="payment-content-left-method-delivery">
                    <p class="section-title">Phương thức giao hàng</p>
                    <div class="payment-content-left-method-delivery-item">
                        <input type="radio" name="delivery" value="fast" id="delivery1" checked>
                        <label for="delivery1">Giao hàng chuyển phát nhanh</label>
                    </div>
                    <p class="section-title">Phương thức thanh toán</p>
                    <div style="color:#444; margin-bottom:8px;">Mọi giao dịch đều được bảo mật và mã hóa.</div>
                    <div class="payment-content-left-method-payment-item">
                        <input type="radio" name="payment" value="momo" id="momo">
                        <label for="momo">Thanh toán Momo</label>
                    </div>
                    <div class="payment-logo-row">
                        <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="Momo" style="height:28px;">
                    </div>
                    <div class="payment-content-left-method-payment-item">
                        <input type="radio" name="payment" value="cod" id="cod" checked>
                        <label for="cod">Thanh toán khi nhận hàng</label>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn-return" onclick="window.location.href='index.php'">Tiếp tục mua sắm</button>
                    <button type="submit" class="btn-complete">Thanh toán</button>
                </div>
            </div>
        </form>
    </div>
</section>

<div class="footer">
    <div class="footer-row">
        <div class="footer-col">
            <h4>Giới thiệu</h4>
            <p>SNEAKERS - Cửa hàng giày uy tín, chất lượng hàng đầu Việt Nam.</p>
        </div>
        <div class="footer-col">
            <h4>Địa chỉ</h4>
            <p><i class="fa-solid fa-location-dot"></i> 123 Trần Hưng Đạo, Q1, TP.HCM</p>
        </div>
        <div class="footer-col">
            <h4>Liên hệ</h4>
            <p><i class="fa-solid fa-phone"></i> 0123 456 789</p>
            <p><i class="fa-solid fa-envelope"></i> contact@sneakers.vn</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('input', function(e) {
    if (e.target.matches('.quantity-input') || e.target.matches('.cart-size-select')) {
        updateCheckoutSummary();
    }
});

function updateCheckoutSummary() {
    let total = 0;
    document.querySelectorAll('table tr').forEach(row => {
        const qtyInput = row.querySelector('.quantity-input');
        const priceCell = row.querySelector('td[data-unit-price]');
        if (qtyInput && priceCell) {
            const qty = parseInt(qtyInput.value) || 1;
            const unitPrice = parseInt(priceCell.getAttribute('data-unit-price')) || 0;
            const subtotal = qty * unitPrice;
            priceCell.textContent = subtotal.toLocaleString('vi-VN') + ' VNĐ';
            total += subtotal;
        }
    });
    document.getElementById('total-price').textContent = total.toLocaleString('vi-VN') + ' VNĐ';
}
</script>
<script src="../js/auth.js"></script>
</body>
</html>
