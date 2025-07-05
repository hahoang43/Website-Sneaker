<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'sneakers'; // Đổi tên CSDL nếu khác

$db = new mysqli($host, $user, $pass, $dbname);
if ($db->connect_error) {
    die("Kết nối CSDL thất bại: " . $db->connect_error);
}
?>
