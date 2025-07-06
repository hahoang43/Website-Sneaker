<?php
require '../config.php';

$data = json_decode(file_get_contents("php://input"));

$fullname = $data->fullname ?? '';
$email = $data->email ?? '';
$password = $data->password ?? '';

if (!$fullname || !$email || !$password) {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
    exit;
}

// Kiểm tra email đã tồn tại
$check = $db->prepare("SELECT id FROM User WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email đã tồn tại"]);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
// Thêm user mới với role_id = 2 (user)
$stmt = $db->prepare("INSERT INTO User (fullname, email, password, role_id) VALUES (?, ?, ?, 2)");
$stmt->bind_param("sss", $fullname, $email, $hashed);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Đăng ký thành công"]);
} else {
    echo json_encode(["status" => "error", "message" => "Đăng ký thất bại"]);
}
