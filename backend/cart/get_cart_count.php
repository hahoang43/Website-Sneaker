<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$count = array_sum(array_column($cart, 'quantity'));
echo json_encode(['count' => $count]);
