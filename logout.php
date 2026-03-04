<?php require_once('forms/init.php');

// Chỉ xóa thông tin user
unset($_SESSION['user']);
unset($_SESSION['fullname']);

// Gọi hệ thống Global Toast
$_SESSION['toast_type'] = 'success';
$_SESSION['toast_message'] = 'Đăng xuất thành công!';

// Chuyển hướng
header("Location: index.php");
exit();
?>