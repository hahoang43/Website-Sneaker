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

    public function insert_product($title, $category_id, $price, $description, $thumbnail) {
        $title = $this->db->link->real_escape_string($title);
        $description = $this->db->link->real_escape_string($description);
        $thumbnail = $this->db->link->real_escape_string($thumbnail);
        $category_id = intval($category_id);
        $price = floatval($price);

        $query = "INSERT INTO product (title, category_id, price, description, thumbnail) 
                  VALUES ('$title', $category_id, $price, '$description', '$thumbnail')";
        return $this->db->insert($query);
    }
}