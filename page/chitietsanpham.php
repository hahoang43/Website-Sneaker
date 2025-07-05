<?php
session_start();
require_once '../backend/products/product_add.php';
$product = new Product();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$row = null;
if ($id > 0) {
    $sql = "SELECT * FROM Product WHERE id = $id";
    $result = $product->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
if (!$row) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/style_chitietsp.css">
   <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <h2>
                <a href="index.html">
                    <img src="../images/anh_banner/logo.jpg" alt="Logo">
                </a>
            </h2>
        </div>
        <!-- search -->
        <div class="search-container">
            <input type="text">
            <i class="fas fa-search search-icon"></i>
        </div>
        <!-- sign -->
        <div class="sign">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="user-name">
                    <i class="fa-solid fa-user"></i>
                    <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                </span>
                <a href="dangxuat.php" class="cart-btn">Đăng xuất</a>
            <?php else: ?>
                <a href="dangnhap.html" class="cart-btn">
                    <i class="fa-solid fa-user"></i>
                </a>
            <?php endif; ?>
            <a href="giohang.php" class="cart-btn" id="cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>

    <!-- MENU -->
    <div class="menu" id="main-menu"></div>

    <!-- San pham chi tiet -->
    <div class="product-detail-container">
        <div class="product-detail-flex">
            <!-- Product Images -->
            <div class="product-detail-image">
                <!-- Ảnh sản phẩm -->
                <img id="main-product-img" src="../uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
            </div>
            <!-- Product Details -->
            <div class="product-detail-info">
                <h1 class="product-title"><?php echo htmlspecialchars($row['title']); ?></h1>
                <p class="product-price">Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?>₫</p>
        
                <!-- Size options -->
                <div class="product-size">
                    <label for="size">Chọn size:</label>
                    <select id="size">
                        <?php
                        $product_id = $row['id'];
                        $sqlSize = "SELECT Size.size_value 
                                    FROM Product_Size 
                                    JOIN Size ON Product_Size.size_id = Size.id 
                                    WHERE Product_Size.product_id = $product_id AND Product_Size.quantity > 0";
                        $resultSize = $product->query($sqlSize);
                        if ($resultSize && $resultSize->num_rows > 0) {
                            while ($sizeRow = $resultSize->fetch_assoc()) {
                                $size = htmlspecialchars($sizeRow['size_value']);
                                echo "<option value=\"$size\">$size</option>";
                            }
                        } else {
                            echo '<option disabled>Hết size</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Quantity -->
                <div class="product-quantity">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" id="quantity" value="1" min="1">
                </div>
                <!-- Buttons -->
                <div class="product-buttons">
                    <button class="btn-add-cart">Thêm vào giỏ hàng</button>
                    <button class="btn-buy-now">Mua ngay</button>
                </div>
            </div>
        </div>
        
       
        <!-- Mô  sản phẩm -->
        <div class="product-description">
            <h2>Mô tả</h2>
            <p>
                 <p class="product-desc"><?php echo nl2br(htmlspecialchars($row['description'] ?? '')); ?></p>
            </p>
        </div>

        <!-- Sản phẩm khác -->
        <div class="related-products">
            <h2>Sản phẩm khác</h2>
            <div class="product-list" id="related-products-list">
            <?php
                // Lấy tất cả sản phẩm khác, khác sản phẩm đang xem
                $sqlRelated = "SELECT id, title, price, thumbnail FROM Product WHERE id != $id";
                $resultRelated = $product->query($sqlRelated);
                $relatedProducts = [];
                if ($resultRelated && $resultRelated->num_rows > 0) {
                    while ($r = $resultRelated->fetch_assoc()) {
                        $relatedProducts[] = $r;
                    }
                }
                // Hiển thị 4 sản phẩm đầu tiên
                for ($i = 0; $i < min(4, count($relatedProducts)); $i++) {
                    $r = $relatedProducts[$i];
                    echo '<div class="product-item">';
                    echo '<a href="chitietsanpham.php?id=' . $r['id'] . '">';
                    echo '<img src="../uploads/' . htmlspecialchars($r['thumbnail']) . '" alt="' . htmlspecialchars($r['title']) . '">';
                    echo '<div class="product-title">' . htmlspecialchars($r['title']) . '</div>';
                    echo '<div class="product-price">' . number_format($r['price'], 0, ',', '.') . '₫</div>';
                    echo '</a>';
                    echo '</div>';
                }
            ?>
            </div>
            <?php if (count($relatedProducts) > 4): ?>
            <div class="related-pagination" style="text-align:center;margin-top:10px;">
                <button id="prev-related" disabled>&laquo; Trước</button>
                <button id="next-related">Sau &raquo;</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="review-form">
    <h3 class="review-title">Gửi đánh giá của bạn</h3>
    <form>
        <label for="reviewerName" class="review-label">Tên của bạn:</label>
        <input type="text" id="reviewerName" name="reviewerName" class="review-input">
        <label for="reviewContent" class="review-label">Nội dung đánh giá:</label>
        <textarea id="reviewContent" name="reviewContent" rows="4" class="review-textarea"></textarea>

        <button type="submit" class="review-button">Gửi đánh giá</button>
    </form>
</div>

    </div>
 <!-- Footer -->
<div class="footer">
    <div class="footer-row">
        <div class="footer-col">
            <h4>Giới thiệu</h4>
            <p>
                SNEAKERS - Cửa hàng giày uy tín, chất lượng hàng đầu Việt Nam. Chào mừng bạn đến với ngôi nhà Sneaker. 
                Tại đây, mỗi một dòng chữ, mỗi chi tiết và hình ảnh đều là những bằng chứng mang dấu ấn lịch sử Sneaker 100 năm, 
                và đang không ngừng phát triển lớn mạnh.
            </p>
        </div> 
        <div class="footer-col">
            <h4>Địa chỉ</h4>
            <p>
                <i class="fa-solid fa-location-dot"></i>
                123 Đường Trần Hưng Đạo, Quận 1, TP. Hồ Chí Minh
            </p>
        </div>
        <div class="footer-col">  
            <h4>Liên hệ</h4>
            <p>
                <i class="fa-solid fa-phone"></i>
                Điện thoại: 0123 456 789
            </p>
            <p>
                <i class="fa-solid fa-envelope"></i>
                Email: contact@sneakers.vn
            </p>
        </div>
    </div>
</div>
<script src="../jquery-3.7.1.js"></script>
    <script>
    $(function(){
        $.getJSON('../backend/categories/category_get.php', function(data){
            let html = '<a href="index.html">Trang chủ</a>';
            data.forEach(function(item){
                html += `<a href="danhmuc.php?id=${item.id}">${item.name}</a>`;
            });
            $('#main-menu').html(html);
        });
    });
    </script>
    <script src="../js/auth.js"></script>
    <script src="../js/cart.js"></script>
    <script>
$(document).ready(function() {
    $('.btn-add-cart').click(function() {
        const id = $('.btn-add-cart').data('id') || parseInt($('body').data('product-id')) || <?php echo (int)$row['id']; ?>;
        const name = $('.product-title').text().trim();
        const price = <?php echo (int)$row['price']; ?>;
        const image = <?php echo json_encode($row['thumbnail']); ?>;
        const size = $('#size').val();
        const quantity = $('#quantity').val();

        $.ajax({
            url: '../backend/cart/add_to_cart.php',
            type: 'POST',
            data: {
                id: id,
                name: name,
                price: price,
                image: image,
                size: size,
                quantity: quantity
            },
            success: function(response) {
                alert("✅ Đã thêm vào giỏ hàng!");
                
            },
            error: function() {
                alert("❌ Có lỗi xảy ra khi thêm vào giỏ hàng!");
            }
        });
    });
});
</script>
</body>
</html>