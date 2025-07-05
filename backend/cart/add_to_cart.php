<?php
session_start();

// Nhận dữ liệu từ AJAX
$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$price = (int) ($_POST['price'] ?? 0);
$image = $_POST['image'] ?? '';
$size = $_POST['size'] ?? '';
$quantity = (int) ($_POST['quantity'] ?? 1);

if (!$id || $quantity < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$found = false;

// Duyệt giỏ hàng xem sản phẩm đã có chưa (cùng id và size)
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $id && $item['size'] == $size) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}

// Nếu chưa có thì thêm mới
if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'size' => $size,
        'quantity' => $quantity
    ];
}

// Tính tổng số sản phẩm
$totalItems = array_sum(array_column($_SESSION['cart'], 'quantity'));

// Trả kết quả
echo json_encode([
    'status' => 'success',
    'message' => '✅ Đã thêm vào giỏ hàng',
    'count' => $totalItems
]);
?>
