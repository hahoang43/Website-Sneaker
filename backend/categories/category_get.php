<?php
require_once "category_add.php";
$category = new Category();
$data = [];
$result = $category->get_all_categories();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>