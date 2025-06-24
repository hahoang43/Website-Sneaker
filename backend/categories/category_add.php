<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function insert_category($category_name) {
        $name = $this->db->link->real_escape_string($category_name);
        $query = "INSERT INTO category (name) VALUES ('$name')";
        $result= $this->db->insert($query);
        return $result;
    }
    public function get_all_categories() {
        $query = "SELECT * FROM category ORDER BY id DESC";
        return $this->db->select($query);
    }
}