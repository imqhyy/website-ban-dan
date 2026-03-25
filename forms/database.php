<?php
//kết nối database
$host = 'localhost';
$db   = 'guitar_xigon'; // Tên database vừa tạo ở trên
$user = 'root';
$pass = ''; // XAMPP mặc định không có mật khẩu
date_default_timezone_set('Asia/Ho_Chi_Minh');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

$guitarimg_direct = 'assets/img/products/guitar/';
// Hàm chuyển đổi tiếng Việt có dấu và khoảng trắng thành dạng chuẩn cho thư mục
function create_slug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str); // Xóa ký tự đặc biệt
    $str = preg_replace('/([\s]+)/', '-', $str);    // Thay khoảng trắng bằng dấu gạch ngang
    return $str;
}

// Cập nhật lại các hàm trong database.php
function getAll($sql, $params = []) {
    global $pdo;
    $stm = $pdo->prepare($sql);
    $stm->execute($params); // Truyền mảng tham số vào đây
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

function getOne($sql, $params = []) {
    global $pdo;
    $stm = $pdo->prepare($sql);
    $stm->execute($params); // Truyền mảng tham số vào đây
    return $stm->fetch(PDO::FETCH_ASSOC);
}

function getRows($sql, $params = []) {
    global $pdo;
    $stm = $pdo->prepare($sql);
    $stm->execute($params);
    return $stm->rowCount();
}