<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Admin</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <script src="../jquery-3.7.1.js"></script>
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <p>Quản lý Admin</p>
    </div>

    <!-- SIDEBAR (LEFT) -->
    <div class="admin-layout">
        <div class="admin-left-container" id="left">
            <div class="admin-left">
                <p>Menu</p>
                <ul>
                    <li>
                        <a href="category.php">Danh Mục Sản Phẩm</a>
                    </li>
                    <li>
                        <a href="product.php">Quản Lí Sản Phẩm</a>
                    </li>
                    <li><a href="order.php">Quản Lí Đơn Hàng</a></li>
                    <li><a href="customer.php">Quản Lí Khách Hàng</a></li>
                    <li><a href="../backend/auth/logout.php">Đăng Xuất</a></li>
                </ul>
            </div>
        </div>
        <!-- Right -->
        <div class="admin-category-right"></div>
    </div>
</body>
</html>