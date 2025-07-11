<?php
require_once '../backend/products/product_add.php';
$productObj = new Product();

$keyword = isset($_GET['q']) ? $productObj->escape($_GET['q']) : '';


$where = "1";
if ($keyword !== '') {
    $where .= " AND (
        title LIKE '%$keyword%' 
        OR description LIKE '%$keyword%' 
        OR category_id IN (SELECT id FROM Category WHERE name LIKE '%$keyword%')
    )";
}

// Lọc thương hiệu
if (!empty($_GET['brand'])) {
    $brands = is_array($_GET['brand']) ? $_GET['brand'] : [$_GET['brand']];
    $brands = array_map('addslashes', $brands);

    $known_brands = ['Nike', 'Adidas', 'Puma'];
    $where_brand = [];

    $selected_brands = array_intersect($brands, $known_brands);
    if (!empty($selected_brands)) {
        $brands_in = "'" . implode("','", $selected_brands) . "'";
        $where_brand[] = "brand IN ($brands_in)";
    }
    if (in_array('Khác', $brands)) {
        $brands_not_in = "'" . implode("','", $known_brands) . "'";
        $where_brand[] = "brand NOT IN ($brands_not_in)";
    }
    if (!empty($where_brand)) {
        $where .= " AND (" . implode(' OR ', $where_brand) . ")";
    }
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

// Lọc phụ kiện theo giá (nếu có)
if (!empty($_GET['accessory_price'])) {
    $acc_sql = [];
    foreach ($_GET['accessory_price'] as $acc) {
        if ($acc == '50-100k') $acc_sql[] = "(price >= 50000 AND price <= 100000)";
        if ($acc == '100-200k') $acc_sql[] = "(price > 100000 AND price <= 200000)";
        if ($acc == '200-500k') $acc_sql[] = "(price > 200000 AND price <= 500000)";
    }
    if ($acc_sql) $where .= " AND (" . implode(' OR ', $acc_sql) . ")";
}

// Số sản phẩm mỗi trang
$limit = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Đếm tổng số sản phẩm sau khi lọc
$sql_count = "SELECT COUNT(*) as total FROM Product WHERE $where";
$count_result = $productObj->query($sql_count);
$total = $count_result ? $count_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total / $limit);

// Lấy sản phẩm cho trang hiện tại
$sql = "SELECT * FROM Product WHERE $where LIMIT $offset, $limit";
$result = $productObj->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
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
        <div class="search-container" style="position:relative;">
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>">
            <i class="fas fa-search search-icon" id="search-button"></i>
        </div>
        <script src="../js/search.js"></script>
        <!-- Sign -->
        <div class="sign">
            <a href="dangnhap.html" class="cart-btn">
                <i class="fa-solid fa-user"></i>
            </a>
             <a href="giohang.php" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </div>

    <!-- MENU động -->
    <div class="menu" id="main-menu"></div>
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

    <!-- Body -->
    <div class="main-content">
        <div class="sidebar">
            <form id="filterForm" method="get">
                <input type="hidden" name="q" value="<?php echo htmlspecialchars($keyword); ?>">
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
                <div class="filter-group">
                    <label>Phụ kiện</label><br>
                    <input type="checkbox" name="accessory_price[]" value="50-100k" <?php if(!empty($_GET['accessory_price']) && in_array('50-100k', (array)$_GET['accessory_price'])) echo 'checked'; ?>> 50k - 100k<br>
                    <input type="checkbox" name="accessory_price[]" value="100-200k" <?php if(!empty($_GET['accessory_price']) && in_array('100-200k', (array)$_GET['accessory_price'])) echo 'checked'; ?>> 100k - 200k<br>
                    <input type="checkbox" name="accessory_price[]" value="200-500k" <?php if(!empty($_GET['accessory_price']) && in_array('200-500k', (array)$_GET['accessory_price'])) echo 'checked'; ?>> 200k - 500k<br>
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
                </p>
            </div> 
            <div class="footer-col"></div>
            <div class="footer-col"></div>
        </div>
    </div>
    <script src="../js/add_product.js"></script>
    <script src="../js/auth.js"></script>
</body>
</html>
