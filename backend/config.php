<?php
$host = 'localhost';
$db   = 'sneakers';
$user = 'root';      // XAMPP mặc định là root
$pass = '';          // Mật khẩu trống
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=sneakers;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Kết nối thất bại: " . $e->getMessage());
}
?>
