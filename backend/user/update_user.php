<?php
require_once '../config.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
$fullname = trim($_POST['fullname'] ?? '');
$phone = trim($_POST['phone_number'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($id <= 0 || $fullname === '') {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin']);
    exit;
}

$stmt = $pdo->prepare('UPDATE User SET fullname = ?, phone_number = ?, address = ? WHERE id = ? AND deleted = 0');
$ok = $stmt->execute([$fullname, $phone, $address, $id]);

if ($ok) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Cập nhật thất bại']);
}
