<?php
require '../config.php';
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập email và mật khẩu']);
    exit;
}
// Truy vấn User kèm quyền
$stmt = $pdo->prepare("
    SELECT u.id, u.fullname, u.email, u.password, r.name AS role_name
    FROM User u
    JOIN Role r ON u.role_id = r.id
    WHERE u.email = ?
");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['authenticated'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['role'] = $user['role_name'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Đăng nhập thành công',
        'role' => $user['role_name'],
        'fullname' => $user['fullname']
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không đúng']);