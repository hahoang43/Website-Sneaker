<?php
require '../config.php';

$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? '';
$email = $data->email ?? '';
$password = $data->password ?? '';

if (!$username || !$email || !$password) {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $hashed]);

if ($stmt->rowCount()) {
    echo json_encode(["status" => "success", "message" => "Đăng ký thành công"]);
} else {
    echo json_encode(["status" => "error", "message" => "Email hoặc username đã tồn tại"]);
}
