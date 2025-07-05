<?php
session_start();
$index = (int) ($_POST['index'] ?? -1);
$size = $_POST['size'] ?? '';

if ($index < 0 || !isset($_SESSION['cart'][$index])) {
    echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
    exit;
}

$_SESSION['cart'][$index]['size'] = $size;

echo json_encode(['status' => 'success']);
?>
