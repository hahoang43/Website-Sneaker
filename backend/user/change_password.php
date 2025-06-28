<?php
require_once '../config.php'; // Đảm bảo đường dẫn đúng
session_start();
header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
    exit;
}

// Lấy dữ liệu từ frontend
$data = json_decode(file_get_contents('php://input'), true);
$currentPassword = $data['current_password'] ?? '';
$newPassword = $data['new_password'] ?? '';
$userId = $_SESSION['user_id'];

// Kiểm tra input
if (!$currentPassword || !$newPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đủ thông tin']);
    exit;
}

// Lấy mật khẩu hiện tại trong DB
$stmt = $pdo->prepare("SELECT password FROM User WHERE id = ? AND deleted = 0");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user || !password_verify($currentPassword, $user['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Mật khẩu hiện tại không đúng']);
    exit;
}

// Cập nhật mật khẩu mới
$newHashed = password_hash($newPassword, PASSWORD_DEFAULT);
$update = $pdo->prepare("UPDATE User SET password = ? WHERE id = ?");
$update->execute([$newHashed, $userId]);

echo json_encode(['status' => 'success', 'message' => 'Đổi mật khẩu thành công']);
