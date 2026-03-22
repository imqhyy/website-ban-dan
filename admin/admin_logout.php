<?php
require_once(__DIR__ . '/forms/init.php');

// Xóa session admin
unset($_SESSION['admin']);
unset($_SESSION['admin_role']);

// Nếu không còn session nào thì destroy luôn
if (empty($_SESSION)) {
    session_destroy();
}

header('Location: admin_login.php');
exit();
?>