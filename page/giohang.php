<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$totalQuantity = array_sum(array_column($cart, 'quantity'));
$totalPrice = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng - SNEAKERS</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/auth.css">
    <script src="../jquery-3.7.1.js"></script>

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
        <a href="giohang.php" class="cart-btn" style="position: relative;">
    <i class="fa-solid fa-cart-shopping" style="font-size: 20px;"></i>
    <span id="cart-count"
          style="
              position: absolute;
              top: -6px;
              right: -10px;
              background: red;
              color: white;
              font-size: 12px;
              border-radius: 50%;
              padding: 2px 6px;
              min-width: 16px;
              text-align: center;
              line-height: 1;
          ">0</span>
</a>

        </a>
    </div>
</div>
<!-- Menu -->
    <div class="menu" id="main-menu"></div>

<!-- Giỏ hàng -->
<div class="cart">
    <div class="cart-top-wrap">
        <div class="cart-top">
            <div class="step-cart"><i class="fa fa-shopping-cart"></i></div>
            <div class="step-fill"><i class="fa fa-map-marker-alt"></i></div>
            <div class="step-payment"><i class="fa fa-credit-card"></i></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="container-left">
        <?php if (empty($cart)): ?>
            <p style="text-align:center;">🛒 Giỏ hàng đang trống!</p>
        <?php else: ?>
        <form method="POST" action="thanhtoan.php">
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
                <?php foreach ($cart as $index => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $totalPrice += $subtotal;
                ?>
                <tr>
                    <td><input type="checkbox" name="selected_items[]" value="<?= $index ?>" checked></td>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                     
                   <td>
    <select class="cart-size-select" data-index="<?= $index ?>">
        <?php
        
        for ($sizeVal = 38; $sizeVal <= 43; $sizeVal++) {
            $selected = ($sizeVal == $item['size']) ? 'selected' : '';
            echo "<option value=\"$sizeVal\" $selected>$sizeVal</option>";
        }
        ?>
    </select>
</td>

                    <td>
                        <input type="number" name="quantities[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1">
                    </td>
                    <td data-total><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>

                    <td><a href="../backend/cart/remove_item.php?index=<?= $index ?>" onclick="return confirm('Xóa sản phẩm này?')">❌</a></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <div style="text-align:right; margin-top:10px;">
                <button type="submit" class="btn-checkout">Tiến hành thanh toán</button>
            </div>
        </form>
        <?php endif; ?>
    </div>

    <div class="container-right">
    <?php
    $selectedTotalQty = 0;
    $selectedTotalPrice = 0;

    foreach ($cart as $index => $item) {
        // Kiểm tra nếu sản phẩm được tick chọn
        if (isset($_POST['selected_items']) && in_array($index, $_POST['selected_items'])) {
            $selectedTotalQty += $item['quantity'];
            $selectedTotalPrice += $item['quantity'] * $item['price'];
        }
    }
    ?>
    <table>
        <tr><th colspan="2">Đơn hàng</th></tr>
        <tr><td>Tổng sản phẩm:</td><td><span id="total-product"><?= $selectedTotalQty ?></span></td></tr>
        <tr><td>Tổng tiền:</td><td><span id="total-price"><?= number_format($selectedTotalPrice, 0, ',', '.') ?> VNĐ</span></td></tr>
        <tr><td>Tạm tính:</td><td><strong><span id="subtotal"><?= number_format($selectedTotalPrice, 0, ',', '.') ?> VNĐ</span></strong></td></tr>
    </table>
    <div class="container-right-button">
        <button type="button" onclick="window.location.href='index.php'" class="btn-continue">Tiếp tục mua sắm</button>
    </div>
</div>

</div>

<!-- Footer -->
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
<script src="../js/auth.js"></script>
<script src="../js/cart.js"></script>
<script>
    $(function(){
        $.getJSON('../backend/categories/category_get.php', function(data){
            let html = '<a href="index.php">Trang chủ</a>';
            data.forEach(function(item){
                html += `<a href="danhmuc.php?id=${item.id}">${item.name}</a>`;
            });
            $('#main-menu').html(html);
        });
    });
    </script>
</body>
</html>