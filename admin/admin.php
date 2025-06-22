<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="../css/style_admin.css">
</head>

<body>
<div class="header">
    <p> Quản lý Admin </p>
</div>
   

<div class="admin-left-container" id="left">
    <div class="admin-left">
        <ul>
            <p> Menu </p>
            <li><a href="product.php">Danh Mục Sản Phẩm</a> </li>
            <li><a href="quanly_donhang.php">Quản lí Đơn hàng</a></li>
            <li><a href="customer.php">Quản lí Khách hàng</a></li>
            <li><a href="logout.php">Đăng xuất</a></li>
        </ul>
    </div>
</div>

<script>
        $("#left a").click(function() {
            var url = $(this).attr("href");
        $("#right").load(url);
            return false;
        });
</script>

<div class="admin-right-container">
    <div class="admin-right" id="right">
        <h2>Nội dung chính</h2>
    <p>Thông tin admin, báo cáo, thống kê,... sẽ hiển thị tại đây.</p>
    </div>
</div>

</body>
</html>