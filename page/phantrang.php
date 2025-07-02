<?php
// filepath: c:\xampp\htdocs\Website-Sneaker\page\phantrang.php
if (!isset($total_pages) || !isset($page)) return;

// Giữ lại các tham số GET khác khi chuyển trang
$query = $_GET;
?>
<div class="pagination" style="text-align:center; margin: 32px 0;">
    <?php
    for ($i = 1; $i <= $total_pages; $i++) {
        $query['page'] = $i;
        $link = '?' . http_build_query($query);
        if ($i == $page) {
            echo "<span class='pnow'>$i</span> ";
        } else {
            echo "<a href='$link'>$i</a> ";
        }
    }
    ?>
</div>