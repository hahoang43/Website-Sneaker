<?php
require '../config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$email = trim($data['email'] ?? '');

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu email']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM User WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode(['status' => 'exists']);
} else {
    echo json_encode(['status' => 'available']);
}
