<?php
require_once '../../backend/config.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu id sản phẩm']);
    exit;
}
// Lấy thông tin sản phẩm
$stmt = $pdo->prepare('SELECT p.*, c.name as category_name FROM Product p JOIN Category c ON p.category_id = c.id WHERE p.id = ? AND p.deleted = 0');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm']);
    exit;
}
// Lấy đánh giá
$stmt2 = $pdo->prepare('SELECT * FROM FeedBack WHERE subject_name = ? ORDER BY created_at DESC LIMIT 10');
$stmt2->execute([$product['title']]);
$reviews = $stmt2->fetchAll();
// Lấy sản phẩm liên quan
$stmt3 = $pdo->prepare('SELECT id, title, price, thumbnail FROM Product WHERE category_id = ? AND id != ? AND deleted = 0 LIMIT 4');
$stmt3->execute([$product['category_id'], $id]);
$related = $stmt3->fetchAll();
// Tính điểm trung bình đánh giá
$avg = 0; $count = 0;
foreach ($reviews as $r) {
    $avg += (int)($r['status'] ?? 5);
    $count++;
}
$avg = $count ? round($avg/$count, 1) : 5;

// Trả về dữ liệu
echo json_encode([
    'status' => 'success',
    'product' => $product,
    'reviews' => $reviews,
    'related' => $related,
    'avg_rating' => $avg,
    'review_count' => $count
]);
