<?php

include "header.php";
include "slider.php";
include "../backend/categories/category_add.php";

$category = new Category();

// Xử lý thêm mới danh mục
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $category->insert_category($category_name);
    header("Location: category.php");
    exit;
}

// Lấy danh sách danh mục
$categories = $category->get_all_categories();
?>

<div class="admin-right-container">
    <div class="admin-right-add">
        <h2>Quản Lý Danh Mục</h2>
        <form action="" method="POST">
            <input required name="category_name" id="category_name" type="text" placeholder="Nhập tên danh mục">
            <button type="submit" class="btn-green">Thêm</button>
        </form>
    </div>
    <div class="admin-left-delete">
        <table>
            <tr>
                <th>STT</th>
                <th>Tên Danh Mục</th>
                <th>Lựa chọn</th>
            </tr>
            <?php
            if ($categories) {
                $i = 1;
                while($row = $categories->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>
                            <a href='../backend/categories/category_edit.php?id={$row['id']}' class='btn-edit'>Sửa</a>
                            <a href='../backend/categories/category_delete.php?id={$row['id']}' class='btn-delete' onclick=\"return confirm('Bạn có chắc muốn xóa?')\">Xóa</a>
                        </td>
                    </tr>";
                    $i++;
                }
            }
            ?>
        </table>
    </div>
</div>