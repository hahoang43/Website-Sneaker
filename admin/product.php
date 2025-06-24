<?php
include "header.php";
include "slider.php";
include "../backend/products/product_add.php";

$product = new Product();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Xử lý upload file
    $thumbnail = '';
    if (!empty($_FILES['thumbnail']['name'])) {
        $upload_dir = "../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $thumbnail = time() . '_' . $_FILES['thumbnail']['name'];
        $upload_path = $upload_dir . $thumbnail;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_path);
    }
    $product->insert_product($title, $category_id, $price, $description, $thumbnail);

    header("Location: product.php?success=1");
    exit;
}

// Lấy danh sách sản phẩm
$products = $product->get_all_products();
?>
<div class="admin-right-container">
    <div class="admin-product-add">
        <h2>Quản Lý Sản Phẩm</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="category_id">Danh Mục Sản Phẩm</label>
            <select name="category_id" id="category_id" required>
                <option value="">--Chọn--</option>
                <?php
                $get_all_categories = $product->get_all_categories();
                if ($get_all_categories) {
                    while ($row = $get_all_categories->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                }
                ?>
            </select>
            <label for="title">Nhập tên sản phẩm</label>
            <input required type="text" name="title" id="title">

            <label for="price">Nhập giá sản phẩm</label>
            <input required type="number" name="price" id="price">

            <label for="description">Mô tả sản phẩm</label>
            <textarea required name="description" id="description" cols="30" rows="5"></textarea>

            <label for="thumbnail">Ảnh sản phẩm</label>
            <input required type="file" name="thumbnail" id="thumbnail">

            <button type="submit" class="btn-green">Thêm</button>
        </form>
    </div>
    <div class="admin-product-list">
        <h3>Danh sách sản phẩm</h3>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
                <th>Chức năng</th>
            </tr>
            <?php
            if ($products) {
                $i = 1;
                while ($row = $products->fetch_assoc()) {
                    echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['price']}</td>
                        <td><img src='../uploads/{$row['thumbnail']}' width='60'></td>
                        <td>{$row['category_id']}</td>
                        <td>
                            <a href='product_edit.php?id={$row['id']}'>Sửa</a> | 
                            <a href='product_delete.php?id={$row['id']}' onclick=\"return confirm('Xóa sản phẩm này?')\">Xóa</a>
                        </td>
                    </tr>";
                    $i++;
                }
            }
            ?>
        </table>
    </div>
</div>