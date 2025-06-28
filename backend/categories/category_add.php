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
        $query = "SELECT * FROM category ORDER BY id ";
        return $this->db->select($query);
    }
    public function update_category($id, $name) {
    $id = intval($id);
    $name = $this->db->link->real_escape_string($name);
    $query = "UPDATE category SET name = '$name' WHERE id = $id";
    return $this->db->update($query);
}
    public function get_category($id) {
    $id = intval($id);
    $query = "SELECT * FROM category WHERE id = $id";
    return $this->db->select($query);
}

}