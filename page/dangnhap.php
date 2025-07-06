<?php
?>
<html>
<head>
    <title>SNEAKERS</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">    
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../jquery-3.7.1.js"> </script>
</head>

<body>
    <!-- Header -->
<div class="header">
    <div class="logo">
        <h2>
            <a href="index.php"> 
            <img src="../images/anh_banner/logo.jpg" > </a> 
        </h2>
    </div>
    
     <!-- search- -->
    <div class="search-container">
        <input type="text" >
        <i class="fas fa-search search-icon"></i>
    </div>

    <!-- sign -->
    <div class="sign">
   <a href="dangnhap.php" class="cart-btn">
        <i class="fa-solid fa-user"></i>
    </a>
    <a href="giohang.php" class="cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>
    </a>
    </div>
</div>

<!-- Menu -->
    <div class="menu" id="main-menu"></div>
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
    <!-- Auth Section -->
    <div class="auth-bg">
        <div class="auth-container">
            <div class="auth-left">
                <img src="/anh-banner/logo.jpg" alt="Logo" style="width: 100%;  ">
                <p>Kết nối những bước chân phong cách.</p>
            </div>
            <div class="auth-right">
                <!-- Đăng nhập -->
                <form class="login-form auth-form" id="login-form">
                    <input id="login-email" type="text" placeholder="Email hoặc số điện thoại" required>
                    <input id="login-password" type="password" placeholder="Mật khẩu" required>
                    <button type="submit" class="btn-login">Đăng nhập</button>
                    <a href="#" class="link" id="show-forgot">Quên mật khẩu?</a>
                    <hr>
                    <button type="button" class="btn-register" id="show-register">Tạo tài khoản mới</button>
                </form>
                <!-- Đăng ký -->
                <form class="register-form auth-form" id="register-form" style="display:none;">
                    <input type="text" id="register-fullname" placeholder="Họ và tên" required>


                    <input id="register-email" type="email" placeholder="Email hoặc số điện thoại" required>
                    <input id="register-password" type="password" placeholder="Mật khẩu" required>
                    <input id="register-password2" type="password" placeholder="Nhập lại mật khẩu" required>
                    <button type="submit" class="btn-login">Đăng ký</button>
                    <a href="#" class="link" id="back-login1">Quay lại đăng nhập</a>
                </form>
                <!-- Quên mật khẩu -->
                <form class="forgot-form auth-form" id="forgot-form" style="display:none;">
                    <input id="forgot-email" type="email" placeholder="Nhập email để lấy lại mật khẩu" required>
                    <button type="submit" class="btn-login">Gửi yêu cầu</button>
                    <a href="#" class="link" id="back-login2">Quay lại đăng nhập</a>
                </form>
            </div>
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

    
<script src="../js/dangnhap.js"> </script>

</body>
</html>