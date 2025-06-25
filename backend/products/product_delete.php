<?php
require_once __DIR__ . '/../database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
}
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $db = new Database();

    // Xóa các size liên kết với sản phẩm này trước
    $db->select("DELETE FROM Product_Size WHERE product_id = $product_id");

    // Xóa sản phẩm
    $db->select("DELETE FROM Product WHERE id = $product_id");

    // Quay lại trang danh sách sản phẩm
    header("Location: ../../admin/product.php?deleted=1");
    exit;
} else {
    // Không có id, quay lại trang sản phẩm
    header("Location: ../../admin/product.php");
    exit;
}   

?>