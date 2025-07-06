<?php
session_start();
require_once '../backend/products/product_add.php';
$product = new Product();

// Lấy sản phẩm bán chạy nhất (ví dụ: lấy 4 sản phẩm đầu)
$sqlHot = "SELECT * FROM Product ORDER BY id DESC LIMIT 4";
$resultHot = $product->query($sqlHot);

// Lấy sản phẩm mới nhất (ví dụ: lấy 4 sản phẩm tiếp theo)
$sqlNew = "SELECT * FROM Product ORDER BY id DESC LIMIT 4 OFFSET 4";
$resultNew = $product->query($sqlNew);

// Lấy banner từ CSDL
$banners = $product->query("SELECT image FROM Banner ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SNEAKERS</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../jquery-3.7.1.js"></script>
    <script src="../js/banner.js"></script>
    <script src="../js/dangnhap.js"></script>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <h2>
                <a href="index.php">
                    <img src="../images/anh_banner/logo.jpg">
                </a>
            </h2>
        </div>
        <!-- search -->
        <div class="search-container">
            <input type="text" id="search-input">
            <i class="fas fa-search search-icon" id="search-button"></i>
        </div>
        <script src="../js/search.js"></script>
        <!-- sign -->
        <div class="sign">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="user-name">
                    <i class="fa-solid fa-user"></i>
                    <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                </span>
                <a href="dangxuat.php" class="cart-btn">Đăng xuất</a>
            <?php else: ?>
                <a href="dangnhap.php" class="cart-btn">
                    <i class="fa-solid fa-user"></i>
                </a>
            <?php endif; ?>
            <a href="giohang.php" class="cart-btn">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>
    <!-- MENU -->
    <div class="menu" id="main-menu"></div>
    <script>
    $(function(){
        $.getJSON('../backend/categories/category_get.php', function(data){
            let html = '<a href="index.php">Trang chủ</a>';
            data.forEach(function(item) {
                html += '<a href="danhmuc.php?id=' + item.id + '">' + item.name + '</a>';
            });
            $('#main-menu').html(html);
        });
    });
    </script>
    <!--banner-->
    <div class="banner-inner">
        <?php if ($banners && $banners->num_rows > 0): ?>
            <?php while($b = $banners->fetch_assoc()): ?>
                <img class="banner-img" src="../uploads/<?php echo htmlspecialchars($b['image']); ?>">
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <!-- San pham noi bat -->
    <div class="noibat">
        <div class="noibat-title">Sản phẩm bán chạy nhất</div>
        <div class="noibat-desc">Những sản phẩm được mua nhiều nhất</div>
    </div>
    <div class="product-list">
        <?php if ($resultHot && $resultHot->num_rows > 0): ?>
            <?php while($row = $resultHot->fetch_assoc()): ?>
                <div class="product-item">
                    <a href="chitietsanpham.php?id=<?php echo $row['id']; ?>">
                        <img src="../uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="product-name"><?php echo htmlspecialchars($row['title']); ?></div>
                        <div class="product-price"><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</div>
                    </a>
                    
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <div class="noibat">
        <div class="noibat-title">Sản phẩm mới nhất</div>
    </div>
    <div class="product-list">
        <?php if ($resultNew && $resultNew->num_rows > 0): ?>
            <?php while($row = $resultNew->fetch_assoc()): ?>
                <div class="product-item">
                    <a href="chitietsanpham.php?id=<?php echo $row['id']; ?>">
                        <img src="../uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="product-name"><?php echo htmlspecialchars($row['title']); ?></div>
                        <div class="product-price"><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</div>
                    </a>
                 
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
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
    <script src="../js/auth.js"></script>
</body>
</html>