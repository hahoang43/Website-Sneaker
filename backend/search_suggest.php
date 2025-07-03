<?php
header('Content-Type: application/json');
require_once 'products/product_add.php';
$product = new Product();
$q = isset($_GET['q']) ? addslashes($_GET['q']) : '';
$suggestions = [];

if ($q !== '') {
    // Gợi ý sản phẩm
    $sql = "SELECT title FROM Product WHERE title LIKE '%$q%' LIMIT 5";
    $res = $product->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $suggestions[] = $row['title'];
        }
    }
    // Gợi ý danh mục
    $sql2 = "SELECT name FROM Category WHERE name LIKE '%$q%' LIMIT 5";
    $res2 = $product->query($sql2);
    if ($res2) {
        while ($row = $res2->fetch_assoc()) {
            $suggestions[] = $row['name'];
        }
    }
}
echo json_encode($suggestions);