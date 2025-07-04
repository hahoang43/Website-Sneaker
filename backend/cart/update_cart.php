<?php
session_start();

// Cập nhật số lượng
if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $index => $quantity) {
        $quantity = max(1, intval($quantity)); // tránh số âm hoặc 0
        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        }
    }
}

// Lưu danh sách sản phẩm được chọn
$selectedIndexes = $_POST['selected_items'] ?? [];
$_SESSION['selected_cart'] = [];  // reset

foreach ($selectedIndexes as $index) {
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['selected_cart'][] = $_SESSION['cart'][$index];
    }
}

// Chuyển về trang giỏ hàng (hoặc thanh toán nếu bạn muốn)
header("Location: ../giohang.php");
// Hoặc: header("Location: ../thanhtoan.php");
exit;
