<?php
require_once '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
    exit;
}
$user_id = $_SESSION['user_id'];
// Lấy danh sách đơn hàng của user
$stmt = $pdo->prepare('SELECT * FROM Orders WHERE user_id = ? ORDER BY order_date DESC');
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

// Lấy chi tiết từng đơn hàng
foreach ($orders as &$order) {
    $stmt2 = $pdo->prepare('SELECT od.*, p.title, p.thumbnail FROM Order_Details od JOIN Product p ON od.product_id = p.id WHERE od.order_id = ?');
    $stmt2->execute([$order['id']]);
    $order['items'] = $stmt2->fetchAll();
}

if ($orders) {
    echo json_encode(['status' => 'success', 'orders' => $orders]);
} else {
    echo json_encode(['status' => 'success', 'orders' => []]);
}
