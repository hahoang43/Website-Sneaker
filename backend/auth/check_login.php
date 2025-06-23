<?php
require '../config.php';
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['fullname'])) {
    echo json_encode([
        "loggedIn" => true,
        "fullname" => $_SESSION['fullname'],
        "role" => $_SESSION['role'] ?? 'user'
    ]);
} else {
    echo json_encode(["loggedIn" => false]);
}
?>
