<?php
session_start();

if (isset($_GET['index'])) {
    $index = intval($_GET['index']);
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset key
    }
}

header("Location: ../../page/giohang.php");
exit;
?>
