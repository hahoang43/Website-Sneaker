<?php

require_once '../backend/config.php';

// Lấy danh mục
$categories = $pdo->query("SELECT * FROM Categories")->fetchAll();
// Lấy thương hiệu
$brands = $pdo->query("SELECT * FROM Brands")->fetchAll();
// Lấy danh sách sản phẩm
$products = $pdo->query("SELECT p.*, c.name as category_name, b.name as brand_name 
    FROM products p 
    LEFT JOIN Categories c ON p.category_id = c.id 
    LEFT JOIN Brands b ON p.brand_id = b.id
    ORDER BY p.id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-content-right-product_list">
        <h2>Quản Lý Sản Phẩm</h2>
        <!-- Form Thêm Sản Phẩm -->
        <div class="admin-content-right-product_add" id="addProductForm">
            <h1>Thêm Sản Phẩm Giày Sneaker</h1>
            <form action="add_product.php" method="POST" enctype="multipart/form-data" id="productForm">
                <select name="category_id" required>
                    <option value="">--Chọn Danh mục--</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="error" id="category_error" style="display:none;">Vui lòng chọn danh mục</div>
                <input required name="product_name" type="text" placeholder="Tên sản phẩm" maxlength="100">
                <div class="error" id="product_name_error" style="display:none;">Vui lòng nhập tên sản phẩm</div>
                <select name="brand_id" required>
                    <option value="">--Chọn Thương hiệu--</option>
                    <?php foreach($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="error" id="brand_error" style="display:none;">Vui lòng chọn thương hiệu</div>
                <input type="number" name="price" placeholder="Giá sản phẩm (VND)" min="0" required>
                <div class="error" id="price_error" style="display:none;">Vui lòng nhập giá hợp lệ</div>
                <input type="number" name="discount_price" placeholder="Giá khuyến mãi (nếu có)" min="0">
                <select name="size" required>
                    <option value="">--Chọn Kích Cỡ--</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                </select>
                <div class="error" id="size_error" style="display:none;">Vui lòng chọn kích cỡ</div>
                <textarea name="description" placeholder="Mô tả sản phẩm" required></textarea>
                <div class="error" id="description_error" style="display:none;">Vui lòng nhập mô tả</div>
                <label>Ảnh sản phẩm:</label>
                <input type="file" name="thumbnail" accept="image/*" required>
                <div class="error" id="thumbnail_error" style="display:none;">Vui lòng chọn ảnh sản phẩm</div>
                <button type="submit">Thêm Sản Phẩm</button>
            </form>
        </div>

        <!-- Bảng Danh Sách Sản Phẩm -->
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thumbnail</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá (VND)</th>
                    <th>Danh Mục</th>
                    <th>Thương Hiệu</th>
                    <th>Mô Tả</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="productList">
                <?php $i=1; foreach($products as $row): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="../images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" width="50">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/50" alt="No image">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= number_format($row['price'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= htmlspecialchars($row['brand_name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td>
                        <button class="action-btn edit-btn" data-id="<?= $row['id'] ?>">Sửa</button>
                        <button class="action-btn delete-btn" data-id="<?= $row['id'] ?>">Xóa</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation and submission
        document.getElementById('productForm').addEventListener('submit', async function(e) {
            let isValid = true;
            const form = e.target;
            // Reset error messages
            document.querySelectorAll('.error').forEach(error => error.style.display = 'none');
            // Validate product name
            if (!form.querySelector('[name="product_name"]').value.trim()) {
                document.getElementById('product_name_error').style.display = 'block';
                isValid = false;
            }
            // Validate category
            if (!form.querySelector('[name="category_id"]').value) {
                document.getElementById('category_error').style.display = 'block';
                isValid = false;
            }
            // Validate brand
            if (!form.querySelector('[name="brand_id"]').value) {
                document.getElementById('brand_error').style.display = 'block';
                isValid = false;
            }
            // Validate price
            const price = form.querySelector('[name="price"]');
            if (!price.value || price.value < 0) {
                document.getElementById('price_error').style.display = 'block';
                isValid = false;
            }
            // Validate description
            if (!form.querySelector('[name="description"]').value.trim()) {
                document.getElementById('description_error').style.display = 'block';
                isValid = false;
            }
            // Validate thumbnail
            if (!form.querySelector('[name="thumbnail"]').files.length) {
                document.getElementById('thumbnail_error').style.display = 'block';
                isValid = false;
            }
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Edit product (placeholder)
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                alert(`Chỉnh sửa sản phẩm ID: ${id}`);
                // Thêm logic để điền dữ liệu vào form
            });
        });

        // Delete product (placeholder)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                    // Gọi AJAX xóa sản phẩm ở backend, sau đó xóa dòng khỏi bảng
                    // Ví dụ:
                    // fetch('delete_product.php?id=' + button.getAttribute('data-id'), { method: 'POST' })
                    //     .then(res => res.json())
                    //     .then(data => { if (data.success) button.closest('tr').remove(); });
                    button.closest('tr').remove();
                }
            });
        });
    });
    </script>
</body>
</html>