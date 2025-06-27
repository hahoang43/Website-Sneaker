<?php
require '../config.php';
session_start();
session_unset();
session_destroy();
header("Location: ../../page/index.html");
exit();
// Nếu gọi từ trình duyệt → chuyển trang
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header("Location: /Website-Sneaker/page/dangnhap.html");
    exit;
}

// Nếu gọi bằng JS fetch → trả JSON
echo json_encode(["status" => "success", "message" => "Đăng xuất thành công"]);
