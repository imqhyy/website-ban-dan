<?php
//kết nối database
$host = 'localhost';
$db   = 'guitar_xigon'; // Tên database vừa tạo ở trên
$user = 'root';
$pass = ''; // XAMPP mặc định không có mật khẩu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>