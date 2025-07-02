<?php
require_once '../backend/products/product_add.php';
$productObj = new Product();

$keyword = isset($_GET['q']) ? $productObj->escape($_GET['q']) : '';

$sql = "SELECT * FROM Product WHERE title LIKE '%$keyword%' OR description LIKE '%$keyword%'";
$result = $productObj->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
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
            <a href="index.html"> 
            <img src="../images/anh_banner/logo.jpg" > </a> 
        </h2>
    </div>
    
     <!-- search- -->
    <div class="search-container">
    <input type="text" id="search-input">
    <i class="fas fa-search search-icon" id="search-button" ></i>
    </div>

    <script src="../js/search.js" > </script>
    <!-- sign -->
    <div class="sign">
   <a href="dangnhap.html" class="cart-btn">
        <i class="fa-solid fa-user"></i>
    </a>
    <a href="giohang.html" class="cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>
    </a>
    </div>
</div>

<!-- MENU -->
    <div class="menu" id="main-menu"> </div>
<script>
$(function(){
    $.getJSON('../backend/categories/category_get.php', function(data){
        let html = '<a href="index.html">Trang chủ</a>';
       data.forEach(function(item) {
    html += '<a href="danhmuc.php?id=' + item.id + '">' + item.name + '</a>';
});
        $('#main-menu').html(html);
    });
});
</script>
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
</body>
</html>