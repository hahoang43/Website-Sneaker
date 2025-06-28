<?php
require_once '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT id, fullname, email, phone_number, address, created_at FROM User WHERE id = ? AND deleted = 0');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($user) {
    echo json_encode(['status' => 'success', 'user' => $user]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy thông tin người dùng']);
}

