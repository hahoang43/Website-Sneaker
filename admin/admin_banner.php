<?php
include "header.php";
include "slider.php";
require_once "../backend/config.php";

// Xử lý upload banner mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['banner'])) {
    $file = $_FILES['banner'];
    if ($file['error'] === 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'banner_' . time() . '.' . $ext;
        move_uploaded_file($file['tmp_name'], "../uploads/$filename");
        $stmt = $db->prepare("INSERT INTO Banner(image) VALUES(?)");
        $stmt->bind_param("s", $filename);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_banner.php");
        exit;
    }
}

// Xử lý xóa banner
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Lấy tên file để xóa file vật lý
    $result = $db->query("SELECT image FROM Banner WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $filePath = "../uploads/" . $row['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    $db->query("DELETE FROM Banner WHERE id = $id");
    header("Location: admin_banner.php");
    exit;
}

// Lấy danh sách banner
$banners = $db->query("SELECT * FROM Banner ORDER BY id DESC");
?>

<div class="admin-right-container">
    <div class="admin-right-add">
        <h2>Quản Lý Banner</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="banner" required>
            <button type="submit" class="btn-green">Tải lên</button>
        </form>
    </div>
    <div class="admin-left-delete">
        <table>
            <tr>
                <th>STT</th>
                <th>Ảnh Banner</th>
                <th>Lựa chọn</th>
            </tr>
            <?php
            if ($banners) {
                $i = 1;
                while($row = $banners->fetch_assoc()) {
                    echo "<tr>
                        <td>{$i}</td>
                        <td>
                            <img src='../uploads/{$row['image']}' style='max-width:180px;max-height:80px;'>
                        </td>
                        <td>
                            <a href='admin_banner.php?delete={$row['id']}' class='btn-delete' onclick=\"return confirm('Bạn có chắc muốn xóa banner này?')\">Xóa</a>
                        </td>
                    </tr>";
                    $i++;
                }
            }
            ?>
        </table>
    </div>
</div>