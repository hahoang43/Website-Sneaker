<?php
require_once '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$fullname = trim($data['fullname'] ?? '');
$phone = trim($data['phone_number'] ?? '');
$address = trim($data['address'] ?? '');
$user_id = $_SESSION['user_id'];

if ($fullname === '') {
    echo json_encode(['status' => 'error', 'message' => 'Họ tên không được để trống']);
    exit;
}

$stmt = $pdo->prepare('UPDATE User SET fullname = ?, phone_number = ?, address = ? WHERE id = ? AND deleted = 0');
$ok = $stmt->execute([$fullname, $phone, $address, $user_id]);

if ($ok) {
    echo json_encode(['status' => 'success', 'message' => 'Cập nhật thành công']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Cập nhật thất bại']);
}
