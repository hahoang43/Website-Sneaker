<?php
require_once '../config.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($products);
?>
