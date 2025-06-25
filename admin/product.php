<?php
include "header.php";
include "slider.php";
include "../backend/products/product_add.php";

$product = new Product();

// Thêm hàm lấy danh sách size trong class Product nếu chưa có
if (!method_exists($product, 'get_all_sizes')) {
    class_alias('Product', 'ProductWithSizes');
    class ProductWithSizes extends Product {
        public function get_all_sizes() {
            $query = "SELECT * FROM Size";
            return $this->db->select($query);
        }
        public function query($sql) {
            return $this->db->select($sql);
        }
    }
    $product = new ProductWithSizes();
}

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
$color = $_POST['color'];
$sizes_input = isset($_POST['sizes']) ? $_POST['sizes'] : '';
$sizes = array_filter(array_map('trim', explode(',', $sizes_input)), function($v) {
    return $v !== '';
});
$description = $_POST['description'];
$thumbnail = '';

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

    // Thêm sản phẩm, trả về id sản phẩm vừa thêm

$product_id = $product->insert_product($title, $category_id, $price, $color, $description, $thumbnail);
// Lưu size cho sản phẩm vào bảng Product_Size
if ($product_id && !empty($sizes)) {
    foreach ($sizes as $size_value) {
        // Kiểm tra size đã tồn tại chưa
        $size_query = $product->query("SELECT id FROM Size WHERE size_value = '$size_value'");
        if ($size_query && $row = $size_query->fetch_assoc()) {
            $size_id = $row['id'];
        } else {
            $product->query("INSERT INTO Size (size_value) VALUES ('$size_value')");
            $get_id = $product->query("SELECT id FROM Size WHERE size_value = '$size_value' ORDER BY id DESC LIMIT 1");
            $size_id = $get_id->fetch_assoc()['id'];
        }
        $product->query("INSERT INTO Product_Size (product_id, size_id) VALUES ($product_id, $size_id)");
    }
}
    header("Location: product.php?success=1");
    exit;
}


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
            
            <label for="color">Màu sắc sản phẩm</label>
            <input required type="text" name="color" id="color" >
            <label for="sizes">Kích cỡ giày </label>
            <input type="text" name="sizes" id="sizes" >

            

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
                <th>Màu sắc</th>
                <th>Kích cỡ</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
                <th>Chức năng</th>
            </tr>
            <?php
            if ($products) {
                $i = 1;
                while ($row = $products->fetch_assoc()) {
                    // Lấy danh sách size cho sản phẩm này
                    $product_id = $row['id'];
                    $size_arr = [];
                    $sql = "SELECT s.size_value FROM Product_Size ps JOIN Size s ON ps.size_id = s.id WHERE ps.product_id = $product_id";
                    $result = $product->query($sql);
                    if ($result) {
                        while ($sz = $result->fetch_assoc()) {
                            $size_arr[] = $sz['size_value'];
                        }
                    }
                    $size_str = implode(', ', $size_arr);

                    echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['color']}</td>
                        <td>{$size_str}</td>
                        <td><img src='../uploads/{$row['thumbnail']}' width='60'></td>
                        <td>{$row['category_id']}</td>
                        <td>
                            <a href='../backend/products/product_edit.php?id={$row['id']}'>Sửa</a> | 
                            <a href='../backend/products/product_delete.php?id={$row['id']}' onclick=\"return confirm('Xóa sản phẩm này?')\">Xóa</a>
                        </td>
                    </tr>";
                    $i++;
                }
            }
            ?>
        </table>
    </div>
</div>