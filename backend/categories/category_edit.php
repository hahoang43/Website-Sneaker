<?php
require_once "category_add.php"; 
include "../../admin/header.php";
include "../../admin/slider.php";

$category = new Category();

// Kiểm tra ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../../admin/category.php");
    exit;
}

$category_id = intval($_GET['id']);
$result = $category->get_category($category_id);
$row = $result ? $result->fetch_assoc() : null;

if (!$row) {
    echo "Không tìm thấy danh mục.";
    exit;
}

$error = "";

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['category_name']);

    if ($new_name !== "") {
        $category->update_category($category_id, $new_name);
        header("Location: ../../admin/category.php");
        exit;
    } else {
        $error = "Tên danh mục không được để trống.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Danh Mục</title>
    <link rel="stylesheet" href="../../css/style_admin.css">
    <style>
        .form-wrapper {
            width: 350px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 24px;
            font-family: Arial, sans-serif;
        }
        .form-wrapper h3 {
            margin-bottom: 16px;
            text-align: center;
        }
        .form-wrapper input[type="text"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .form-wrapper .btn-green {
            background-color: #28a745;
            color: #fff;
            padding: 10px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .form-wrapper a {
            margin-left: 10px;
            color: #888;
            text-decoration: none;
        }
        .form-wrapper .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-wrapper">
        <h3>Sửa Danh Mục</h3>
        <form method="POST">
            <input type="text" name="category_name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            <button type="submit" class="btn-green">Cập nhật</button>
            <a href="../../admin/category.php">Hủy</a>
        </form>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
