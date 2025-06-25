<?php

require_once __DIR__ . '/product_add.php';

$product = new Product();

// Lấy id sản phẩm
if (!isset($_GET['id'])) {
    header("Location: ../../admin/product.php");
    exit;
}
$product_id = intval($_GET['id']);

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM product WHERE id = $product_id";
$result = $product->query($sql);
if (!$result || !$result->num_rows) {
    header("Location: ../../admin/product.php");
    exit;
}
$row = $result->fetch_assoc();

// Lấy danh sách size hiện tại của sản phẩm
$size_arr = [];
$sql_size = "SELECT s.size_value FROM Product_Size ps JOIN Size s ON ps.size_id = s.id WHERE ps.product_id = $product_id";
$result_size = $product->query($sql_size);
if ($result_size) {
    while ($sz = $result_size->fetch_assoc()) {
        $size_arr[] = $sz['size_value'];
    }
}
$sizes_str = implode(',', $size_arr);

// Xử lý cập nhật sản phẩm
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
    $thumbnail = $row['thumbnail'];

    // Xử lý upload file mới nếu có
    if (!empty($_FILES['thumbnail']['name'])) {
        $upload_dir = "../../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $thumbnail = time() . '_' . $_FILES['thumbnail']['name'];
        $upload_path = $upload_dir . $thumbnail;
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_path);
    }

    // Cập nhật sản phẩm
    $title = $product->db->link->real_escape_string($title);
    $color = $product->db->link->real_escape_string($color);
    $description = $product->db->link->real_escape_string($description);
    $thumbnail = $product->db->link->real_escape_string($thumbnail);
    $category_id = intval($category_id);
    $price = floatval($price);

    $sql_update = "UPDATE product SET 
        title='$title',
        category_id=$category_id,
        price=$price,
        color='$color',
        description='$description',
        thumbnail='$thumbnail'
        WHERE id=$product_id";
    $product->query($sql_update);

    // Xóa size cũ
    $product->query("DELETE FROM Product_Size WHERE product_id = $product_id");

    // Lưu size mới
    if (!empty($sizes)) {
        foreach ($sizes as $size_value) {
            // Kiểm tra size đã tồn tại chưa
            $size_query = $product->query("SELECT id FROM Size WHERE size_value = '$size_value'");
            if ($size_query && $row_sz = $size_query->fetch_assoc()) {
                $size_id = $row_sz['id'];
            } else {
                $product->query("INSERT INTO Size (size_value) VALUES ('$size_value')");
                $get_id = $product->query("SELECT id FROM Size WHERE size_value = '$size_value' ORDER BY id DESC LIMIT 1");
                $size_id = $get_id->fetch_assoc()['id'];
            }
            $product->query("INSERT INTO Product_Size (product_id, size_id) VALUES ($product_id, $size_id)");
        }
    }

    header("Location: ../../admin/product.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="../../css/style_admin.css">
</head>
<body>
<div class="admin-right-container">
    <div class="admin-product-add">
        <h2>Sửa Sản Phẩm</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="category_id">Danh Mục Sản Phẩm</label>
            <select name="category_id" id="category_id" required>
                <option value="">--Chọn--</option>
                <?php
                $get_all_categories = $product->get_all_categories();
                if ($get_all_categories) {
                    while ($cat = $get_all_categories->fetch_assoc()) {
                        $selected = ($cat['id'] == $row['category_id']) ? 'selected' : '';
                        echo '<option value="' . $cat['id'] . '" ' . $selected . '>' . $cat['name'] . '</option>';
                    }
                }
                ?>
            </select>
            <label for="title">Tên sản phẩm</label>
            <input required type="text" name="title" id="title" value="<?php echo htmlspecialchars($row['title']); ?>">

            <label for="price">Giá sản phẩm</label>
            <input required type="number" name="price" id="price" value="<?php echo htmlspecialchars($row['price']); ?>">

            <label for="color">Màu sắc sản phẩm</label>
            <input required type="text" name="color" id="color" value="<?php echo htmlspecialchars($row['color']); ?>">

            <label for="sizes">Kích cỡ giày (cách nhau bằng dấu phẩy)</label>
            <input type="text" name="sizes" id="sizes" value="<?php echo htmlspecialchars($sizes_str); ?>">

            <label for="description">Mô tả sản phẩm</label>
            <textarea required name="description" id="description" cols="30" rows="5"><?php echo htmlspecialchars($row['description']); ?></textarea>

            <label for="thumbnail">Ảnh sản phẩm</label>
            <input type="file" name="thumbnail" id="thumbnail">
            <div>
                <img src="../../uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" width="80" alt="Ảnh sản phẩm">
            </div>

            <button type="submit" class="btn-green">Cập nhật</button>
            <a href="../../admin/product.php" class="btn-green" style="background:#888;margin-left:10px;">Quay lại</a>
        </form>
    </div>
</div>