<?php
require_once '../backend/products/product_add.php';
$product = new Product();

$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy tên danh mục
$category_name = $product->get_category_name($category_id);

// Lấy sản phẩm thuộc danh mục
$sql = "SELECT * FROM Product WHERE category_id = $category_id";
$result = $product->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($category_name); ?></title>
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
            <h2>
                <a href="index.html"> 
                    <img src="../images/anh_banner/logo.jpg" alt="Logo"> 
                </a>
            </h2>
        </div>
        <!-- Search -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm...">
            <i class="fas fa-search search-icon"></i>
        </div>
        <!-- Sign -->
        <div class="sign">
            <a href="dangnhap.html" class="cart-btn">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="giohang.html" class="cart-btn">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>

    <!-- MENU động -->
    <div class="menu" id="main-menu"></div>

    <!-- Body -->
    <div class="main-content">
        <div class="sidebar">
            <form id="filterForm" method="get">
                <input type="hidden" name="id" value="<?php echo $category_id; ?>">
                <div class="filter-group">
                    <label>Thương hiệu</label><br>
                    <input type="checkbox" name="brand" value="Nike"> Nike<br>
                    <input type="checkbox" name="brand" value="Adidas"> Adidas<br>
                    <input type="checkbox" name="brand" value="Puma"> Puma<br>
                    <input type="checkbox" name="brand" value="Khác"> Khác<br>
                </div>
                <div class="filter-group">
                    <label>Giá</label><br>
                    <input type="checkbox" name="price" value="duoi2tr"> Dưới 2 triệu<br>
                    <input type="checkbox" name="price" value="2-5tr"> 2 - 5 triệu<br>
                    <input type="checkbox" name="price" value="tren5tr"> Trên 5 triệu<br>
                </div>
                <div class="filter-group">
                    <label>Kích cỡ</label><br>
                    <input type="checkbox" name="size" value="38"> 38<br>
                    <input type="checkbox" name="size" value="39"> 39<br>
                    <input type="checkbox" name="size" value="40"> 40<br>
                    <input type="checkbox" name="size" value="41"> 41<br>
                    <input type="checkbox" name="size" value="42"> 42<br>
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>
        <div class="product-list" id="productList">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<img src="../uploads/' . $row['thumbnail'] . '" width="200"><br>';
                    echo '<b>' . htmlspecialchars($row['title']) . '</b><br>';
                    echo number_format($row['price'], 0, ',', '.') . ' VNĐ<br>';
                    echo '<button>Thêm vào giỏ hàng</button>';
                    echo '</div>';
                }
            } else {
                echo "Không có sản phẩm nào!";
            }
            ?>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
</body>
</html>