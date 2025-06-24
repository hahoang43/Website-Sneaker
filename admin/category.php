<?php

include "header.php";
include "slider.php";
include "../backend/categories/category_add.php";

$category = new Category();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $insert_category = $category->insert_category($category_name);   
    header("Location: category.php");
    exit;
}

// Lấy danh sách danh mục
$categories = $category->get_all_categories();
?>

<div class="admin-right-container" style="display: flex; align-items: flex-start; gap: 40px;">
    <div class="admin-category-left" style="width: 35%;">
        <h2>Quản Lý Danh Mục Sản Phẩm</h2>
        <form action="" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            <label for="category_name" style="font-weight: 600;">Tên Danh Mục:</label>
            <input required name="category_name" id="category_name" type="text" placeholder="Nhập tên danh mục" style="padding: 10px 14px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
            <button type="submit" class="btn-green" style="width: 100px;">Lưu</button>
        </form>
    </div>
    <div class="admin-category-right" style="width: 65%;">
        <table style="width:100%; border-collapse: collapse; background: #fff;">
            <tr>
                <th style="padding: 12px 10px; border: 1px solid #e0e0e0;">STT</th>
                <th style="padding: 12px 10px; border: 1px solid #e0e0e0;">Tên Danh Mục</th>
                <th style="padding: 12px 10px; border: 1px solid #e0e0e0;">Lựa chọn</th>
            </tr>
            <?php
            if ($categories) {
                $i = 1;
                while($row = $categories->fetch_assoc()) {
                    echo "<tr>
                        <td style='padding: 10px; border: 1px solid #e0e0e0; text-align:center;'>{$i}</td>
                        <td style='padding: 10px; border: 1px solid #e0e0e0;'>" . htmlspecialchars($row['name']) . "</td>
                        <td style='padding: 10px; border: 1px solid #e0e0e0; text-align:center;'>
                            <a href='category_edit.php?id={$row['id']}' class='btn-edit' style='background: #ffc107; color: #222; border-radius: 4px; padding: 7px 18px; font-weight: bold; margin-right: 8px; text-decoration: none;'>Sửa</a>
                            <a href='../backend/categories/category_delete.php?id={$row['id']}' class='btn-delete' style='background: #e74c3c; color: #fff; border-radius: 4px; padding: 7px 18px; font-weight: bold; text-decoration: none;' onclick=\"return confirm('Bạn có chắc muốn xóa?')\">Xóa</a>
                        </td>
                    </tr>";
                    $i++;
                }
            }
            ?>
       </table>
    </div>
</div> 

