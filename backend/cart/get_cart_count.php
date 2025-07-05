<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$count = 0;

foreach ($cart as $item) {
    $count += $item['quantity'];
}

echo json_encode(['count' => $count]);
