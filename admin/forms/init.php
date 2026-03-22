<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../../forms/database.php');

// Các trang không cần kiểm tra đăng nhập
$public_pages = ['admin_login.php'];
$current_page = basename($_SERVER['PHP_SELF']);

if (!in_array($current_page, $public_pages) && empty($_SESSION['admin'])) {
    $_SESSION['toast_type'] = 'warning';
    $_SESSION['toast_message'] = 'Vui lòng đăng nhập để sử dụng tính năng này!';
    header('Location: admin_login.php');
    exit();
}
?>