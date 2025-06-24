<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function delete_category($id) {
        $id = intval($id);
        $query = "DELETE FROM category WHERE id = $id";
        return $this->db->delete($query);
    }
}

// Xử lý xóa khi có tham số id
if (isset($_GET['id'])) {
    $category = new Category();
    $category->delete_category($_GET['id']);
    header("Location: ../../admin/category.php");
    exit;
}
?>