<?php
// admin/forms/ajax_admin_update.php
require_once(__DIR__ . '/../init.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$adminUsername = $_SESSION['admin'] ?? '';
if (empty($adminUsername)) {
    echo json_encode(['status' => 'error', 'message' => 'Phiên đăng nhập không hợp lệ hoặc đã hết hạn!']);
    exit;
}

$action = $_POST['action'] ?? 'update_profile'; // mặc định nếu không gửi kèm

if ($action === 'update_password') {
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đủ tất cả các trường mật khẩu!']);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Mật khẩu xác nhận không trùng khớp!']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$adminUsername]);
    $admin = $stmt->fetch();

    if (!$admin) {
        echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tài khoản để xử lý!']);
        exit;
    }

    // Do bản DB website-ban-dan đang lưu mật khẩu là Chuỗi trơn (Plain Text) nên so sánh trực tiếp
    // Nếu sếp dùng Hash, thì thay bằng password_verify()
    if ($currentPassword !== $admin['password']) {
        echo json_encode(['status' => 'error', 'message' => 'Mật khẩu hiện tại cung cấp không chính xác!']);
        exit;
    }

    if ($currentPassword === $newPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Mật khẩu mới không được giống hệt mật khẩu cũ!']);
        exit;
    }

    try {
        $updateStmt = $pdo->prepare("UPDATE admin_users SET password = ? WHERE username = ?");
        $updateStmt->execute([$newPassword, $adminUsername]);
        echo json_encode(['status' => 'success', 'message' => 'Đổi mật khẩu bảo mật thành công!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi DB: ' . $e->getMessage()]);
    }
} elseif ($action === 'update_profile') {

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $avatarPath = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES['avatar']['type'], $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF, WEBP.']);
            exit;
        }

        if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'Kích thước ảnh tối đa là 2MB. Vui lòng nén lại ảnh.']);
            exit;
        }

        $uploadDir = __DIR__ . '/../../../assets/img/avatars/';

        // 2. Kiểm tra và tạo thư mục nếu chưa có
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES['avatar']['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
            $avatarPath = $fileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Có lỗi khi lưu file ảnh lên Server.']);
            exit;
        }
    }

    try {
        if ($avatarPath) {
            $stmt = $pdo->prepare("UPDATE admin_users SET fullname = ?, email = ?, phone = ?, avatar = ? WHERE username = ?");
            $stmt->execute([$fullname, $email, $phone, $avatarPath, $adminUsername]);
        } else {
            $stmt = $pdo->prepare("UPDATE admin_users SET fullname = ?, email = ?, phone = ? WHERE username = ?");
            $stmt->execute([$fullname, $email, $phone, $adminUsername]);
        }
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật Thông tin Admin thành công!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi DB: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lệnh xử lý không tồn tại!']);
}
