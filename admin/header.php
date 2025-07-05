<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Admin</title>
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../jquery-3.7.1.js"></script>
</head>

<?php
session_start();
$admin_name = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
?>
<body>
    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <h2><a href="/Website-Sneaker/admin/admin.php"><img src="/Website-Sneaker/images/anh_banner/logo.jpg" alt="Logo"></a></h2>
        </div>
        <div class="admin-user-dropdown">
            <button id="adminDropdownBtn">
                <span class="admin-avatar"></span>
                <span>Xin chào, <b><?php echo htmlspecialchars($admin_name); ?></b></span>
                <span class="dropdown-arrow">&#9662;</span>
            </button>
            <div id="adminDropdownMenu">
                <a href="../backend/auth/logout.php" class="logout-link">Đăng xuất</a>
            </div>
        </div>
    </div>
    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('adminDropdownBtn');
        var menu = document.getElementById('adminDropdownMenu');
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        });
        document.addEventListener('click', function() {
            menu.style.display = 'none';
        });
    });
    </script>


