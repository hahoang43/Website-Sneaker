<?php
require_once '../backend/products/product_add.php';
$product = new Product();

$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$category_name = $product->get_category_name($category_id);

// Xử lý lọc
$where = "category_id = $category_id";

// Lọc thương hiệu
if (!empty($_GET['brand'])) {
    $brands = is_array($_GET['brand']) ? $_GET['brand'] : [$_GET['brand']];
    $brands = array_map('addslashes', $brands);
    $brands_in = "'" . implode("','", $brands) . "'";
    $where .= " AND brand IN ($brands_in)";
}

// Lọc giá
if (!empty($_GET['price'])) {
    $prices = is_array($_GET['price']) ? $_GET['price'] : [$_GET['price']];
    $price_sql = [];
    foreach ($prices as $price) {
        if ($price == 'duoi2tr') $price_sql[] = "price < 2000000";
        if ($price == '2-5tr') $price_sql[] = "(price >= 2000000 AND price <= 5000000)";
        if ($price == 'tren5tr') $price_sql[] = "price > 5000000";
    }
    if ($price_sql) $where .= " AND (" . implode(' OR ', $price_sql) . ")";
}

// Lọc size
if (!empty($_GET['size'])) {
    $sizes = is_array($_GET['size']) ? $_GET['size'] : [$_GET['size']];
    $sizes = array_map('addslashes', $sizes);
    $sizes_in = "'" . implode("','", $sizes) . "'";
    $where .= " AND id IN (
        SELECT product_id FROM Product_Size 
        JOIN Size ON Product_Size.size_id = Size.id 
        WHERE Size.size_value IN ($sizes_in) AND Product_Size.quantity > 0
    )";
}

// Số sản phẩm mỗi trang
$limit = 6; // hoặc số bạn muốn

// Trang hiện tại
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Đếm tổng số sản phẩm sau khi lọc
$sql_count = "SELECT COUNT(*) as total FROM Product WHERE $where";
$count_result = $product->query($sql_count);
$total = $count_result ? $count_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total / $limit);

// Lấy sản phẩm cho trang hiện tại
$sql = "SELECT * FROM Product WHERE $where LIMIT $offset, $limit";
$result = $product->query($sql);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/auth.css">
    <script src="../jquery-3.7.1.js"></script>
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
            <input type="text" id="searchInput">
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
                    <input type="checkbox" name="brand[]" value="Nike" <?php if(!empty($_GET['brand']) && in_array('Nike', (array)$_GET['brand'])) echo 'checked'; ?>> Nike<br>
                    <input type="checkbox" name="brand[]" value="Adidas" <?php if(!empty($_GET['brand']) && in_array('Adidas', (array)$_GET['brand'])) echo 'checked'; ?>> Adidas<br>
                    <input type="checkbox" name="brand[]" value="Puma" <?php if(!empty($_GET['brand']) && in_array('Puma', (array)$_GET['brand'])) echo 'checked'; ?>> Puma<br>
                    <input type="checkbox" name="brand[]" value="Khác" <?php if(!empty($_GET['brand']) && in_array('Khác', (array)$_GET['brand'])) echo 'checked'; ?>> Khác<br>
                </div>
                <div class="filter-group">
                    <label>Giá</label><br>
                    <input type="checkbox" name="price[]" value="duoi2tr" <?php if(!empty($_GET['price']) && in_array('duoi2tr', (array)$_GET['price'])) echo 'checked'; ?>> Dưới 2 triệu<br>
                    <input type="checkbox" name="price[]" value="2-5tr" <?php if(!empty($_GET['price']) && in_array('2-5tr', (array)$_GET['price'])) echo 'checked'; ?>> 2 - 5 triệu<br>
                    <input type="checkbox" name="price[]" value="tren5tr" <?php if(!empty($_GET['price']) && in_array('tren5tr', (array)$_GET['price'])) echo 'checked'; ?>> Trên 5 triệu<br>
                </div>
                <div class="filter-group">
                    <label>Kích cỡ</label><br>
                    <input type="checkbox" name="size[]" value="38" <?php if(!empty($_GET['size']) && in_array('38', (array)$_GET['size'])) echo 'checked'; ?>> 38<br>
                    <input type="checkbox" name="size[]" value="39" <?php if(!empty($_GET['size']) && in_array('39', (array)$_GET['size'])) echo 'checked'; ?>> 39<br>
                    <input type="checkbox" name="size[]" value="40" <?php if(!empty($_GET['size']) && in_array('40', (array)$_GET['size'])) echo 'checked'; ?>> 40<br>
                    <input type="checkbox" name="size[]" value="41" <?php if(!empty($_GET['size']) && in_array('41', (array)$_GET['size'])) echo 'checked'; ?>> 41<br>
                    <input type="checkbox" name="size[]" value="42" <?php if(!empty($_GET['size']) && in_array('42', (array)$_GET['size'])) echo 'checked'; ?>> 42<br>
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>
        <div class="product-list" id="productList">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    echo '<a href="chitietsanpham.php?id=' . $row['id'] . '">';
                    echo '<img src="../uploads/' . htmlspecialchars($row['thumbnail']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                    echo '<div class="product-name">' . htmlspecialchars($row['title']) . '</div>';
                    echo '</a>';
                    echo '<div class="product-price">' . number_format($row['price'], 0, ',', '.') . ' VNĐ</div>';
                    echo '<div class="add-to-cart-btn"> Thêm vào giỏ hàng </div>';
                    echo '</div>';
                }
            } else {
                echo "Không có sản phẩm nào!";
            }
            ?>
        </div>
    </div> <!-- Kết thúc .main-content -->
    <?php include 'phantrang.php'; ?>
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
     <script src="../js/add_product.js"></script>
    <script src="../js/auth.js"></script>
</body>
</html>