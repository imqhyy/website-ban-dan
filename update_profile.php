<?php
require_once('forms/init.php');

// 1. Chặn nếu chưa đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['user'];

    // 2. Lấy dữ liệu từ form và loại bỏ khoảng trắng thừa
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $ward = trim($_POST['ward'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $avatarPath = null; // Mặc định không có ảnh mới

    // 3. Xử lý Upload Ảnh Đại Diện (Nếu người dùng có chọn ảnh)
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileSize = $_FILES['avatar']['size'];
        $fileType = $_FILES['avatar']['type'];

        // Kiểm tra dung lượng (< 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            $_SESSION['toast_type'] = 'error';
            $_SESSION['toast_message'] = 'Kích thước ảnh quá lớn (Tối đa 2MB)!';
            header("Location: account.php");
            exit();
        }

        // Kiểm tra định dạng (Chỉ cho phép JPG, PNG)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['toast_type'] = 'error';
            $_SESSION['toast_message'] = 'Chỉ chấp nhận file ảnh định dạng JPG hoặc PNG!';
            header("Location: account.php");
            exit();
        }

        // Tạo thư mục lưu ảnh nếu chưa có
        $uploadDir = 'assets/img/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Tự động tạo folder cấp quyền read/write
        }

        // Đổi tên file để tránh trùng lặp (Gắn thêm thời gian hiện tại)
        $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9.-]/', '_', $fileName);
        $destPath = $uploadDir . $newFileName;

        // Chuyển file từ thư mục tạm vào thư mục chính
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $avatarPath = $destPath;
        } else {
            $_SESSION['toast_type'] = 'error';
            $_SESSION['toast_message'] = 'Có lỗi xảy ra khi lưu ảnh!';
            header("Location: account.php");
            exit();
        }
    }

    // 4. Cập nhật vào Database
    try {
        if ($avatarPath) {
            // Trường hợp 1: Có cập nhật ảnh đại diện
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, city = ?, district = ?, ward = ?, address = ?, avatar = ? WHERE username = ?");
            $stmt->execute([$fullname, $email, $phone, $city, $district, $ward, $address, $avatarPath, $username]);
        } else {
            // Trường hợp 2: Chỉ cập nhật chữ, giữ nguyên ảnh cũ
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, city = ?, district = ?, ward = ?, address = ? WHERE username = ?");
            $stmt->execute([$fullname, $email, $phone, $city, $district, $ward, $address, $username]);
        }

        // Cập nhật lại biến Session (Để thanh Header tự động đổi tên hiển thị ngay lập tức)
        $_SESSION['fullname'] = $fullname;

        // Gọi Global Toast báo thành công
        $_SESSION['toast_type'] = 'success';
        $_SESSION['toast_message'] = 'Cập nhật hồ sơ thành công!';

    } catch (PDOException $e) {
        // Bắt lỗi nếu Database có vấn đề
        $_SESSION['toast_type'] = 'error';
        $_SESSION['toast_message'] = 'Lỗi hệ thống: Không thể cập nhật.';
    }

    // 5. Chuyển hướng về lại trang account
    header("Location: account.php");
    exit();
} else {
    // Nếu ai đó cố tình gõ url update_profile.php lên trình duyệt, đá họ về trang chủ
    header("Location: index.php");
    exit();
}
?>