<?php
require_once __DIR__ . '/../database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function get_all_categories() {
        $query = "SELECT * FROM category ORDER BY id DESC";
        return $this->db->select($query);
    }
    
public function get_all_products() {
    $query = "SELECT * FROM product ORDER BY id DESC";
    return $this->db->select($query);
}

public function get_all_sizes() {
    $query = "SELECT * FROM Size";
    return $this->db->select($query);
}
public function query($sql) {
    return $this->db->select($sql);
}


public function insert_product($title, $category_id, $price, $color, $description, $thumbnail) {
    $title = $this->db->link->real_escape_string($title);
    $color = $this->db->link->real_escape_string($color);
    $description = $this->db->link->real_escape_string($description);
    $thumbnail = $this->db->link->real_escape_string($thumbnail);
    $category_id = intval($category_id);
    $price = floatval($price);

    $query = "INSERT INTO product (title, category_id, price, color, description, thumbnail) 
              VALUES ('$title', $category_id, $price, '$color', '$description', '$thumbnail')";
    $result = $this->db->insert($query);
    if ($result) {
        return $this->db->link->insert_id; 
    }
    return false;
}

public function get_category_name($category_id) {
    $category_id = intval($category_id);
    $result = $this->query("SELECT name FROM Category WHERE id = $category_id");
    if ($result && $row = $result->fetch_assoc()) {
        return $row['name'];
    }
    return "Danh mục không tồn tại";
}
}
?>