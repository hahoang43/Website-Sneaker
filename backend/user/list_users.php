<?php
require_once '../config.php';
header('Content-Type: application/json');

$stmt = $pdo->query('SELECT id, fullname, email, phone_number, address, created_at, locked FROM User WHERE deleted = 0 ORDER BY id ASC');
$users = $stmt->fetchAll();

echo json_encode(['status' => 'success', 'users' => $users]);
