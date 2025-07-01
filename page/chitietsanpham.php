<?php
// filepath: c:\xampp\htdocs\Website-Sneaker\page\chitietsanpham.php
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
   <link rel="stylesheet" href="../css/style.css">
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
            <a href="giohang.html" class="cart-btn" id="cart-icon">
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
                <p class="product-desc"><?php echo nl2br(htmlspecialchars($row['description'] ?? '')); ?></p>
                <div class="product-rating">
                    <strong>4.8/5</strong>
                    <a href="#review-section" class="star-link">★★★★★</a>
                    <p>(<a href="#review-section" class="review-link">Dựa trên 123 đánh giá</a>)</p>
                </div>
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

        <!-- Chi tiết sản phẩm -->
        <div class="product-description">
            <h2>Mô tả</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($row['content'] ?? 'Giày Nike Air Max 270 mang đến cảm giác thoải mái với đế Air lớn nhất từng có từ Nike. Thiết kế hiện đại, màu sắc trẻ trung và phong cách năng động giúp bạn nổi bật trong mọi hoàn cảnh.')); ?>
            </p>
            <ul>
                <li>Chất liệu: Vải lưới thoáng khí</li>
                <li>Đế giữa: Đệm khí Air Max đàn hồi</li>
                <li>Phù hợp: Đi học, đi chơi, thể thao nhẹ</li>
                <li>Thương hiệu: Nike chính hãng</li>
            </ul>
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
<script>
document.querySelector('.btn-add-cart').addEventListener('click', function(e) {
    var img = document.getElementById('main-product-img');
    var cart = document.getElementById('cart-icon');
    if (!img || !cart) return;
                               
    // Lấy vị trí ảnh và giỏ hàng
    var imgRect = img.getBoundingClientRect();
    var cartRect = cart.getBoundingClientRect();

    // Tạo ảnh bay
    var flyImg = img.cloneNode(true);
    flyImg.classList.add('fly-img');
    document.body.appendChild(flyImg);

    // Đặt vị trí ban đầu
    flyImg.style.left = imgRect.left + 'px';
    flyImg.style.top = imgRect.top + 'px';
    flyImg.style.width = imgRect.width + 'px';
    flyImg.style.height = imgRect.height + 'px';

    // Bắt buộc browser render lại
    flyImg.offsetWidth;

    // Di chuyển đến giỏ hàng
    flyImg.style.left = cartRect.left + (cartRect.width/2 - 30) + 'px';
    flyImg.style.top = cartRect.top + (cartRect.height/2 - 30) + 'px';
    flyImg.style.width = '60px';
    flyImg.style.height = '60px';
    flyImg.style.opacity = '0.5';

    // Xóa ảnh bay sau khi kết thúc hiệu ứng
    setTimeout(function() {
        flyImg.remove();
    }, 900);
});
</script>
</body>
</html>