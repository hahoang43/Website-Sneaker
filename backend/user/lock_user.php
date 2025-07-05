<?php
require_once '../config.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
$lock = isset($_POST['lock']) ? intval($_POST['lock']) : 0;
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
    exit;
}
$stmt = $pdo->prepare('UPDATE User SET locked = ? WHERE id = ?');
$ok = $stmt->execute([$lock, $id]);
if ($ok) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Cập nhật trạng thái thất bại']);
}
