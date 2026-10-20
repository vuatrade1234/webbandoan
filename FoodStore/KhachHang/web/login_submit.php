<?php
require 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Email không hợp lệ. Đang chuyển hướng bạn trở lại trang đăng nhập...';
    echo '<meta http-equiv="refresh" content="2;url=login.php" />';
    exit;
}

if (strlen($password) < 6) {
    echo 'Mật khẩu phải có ít nhất 6 ký tự. Đang chuyển hướng bạn trở lại trang đăng nhập...';
    echo '<meta http-equiv="refresh" content="2;url=login.php" />';
    exit;
}

$stmt = mysqli_prepare($con, 'SELECT * FROM khachhang WHERE LOWER(Email) = LOWER(?) LIMIT 1');
if (!$stmt) {
    die('Lỗi truy vấn tài khoản: ' . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo '<script>window.alert("Email hoặc mật khẩu không đúng!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=login.php" />';
    exit;
}

$row = mysqli_fetch_assoc($result);
if (isset($row['TrangThai']) && (int)$row['TrangThai'] !== 1) {
    echo '<script>window.alert("Tài khoản đã bị khóa. Vui lòng liên hệ cửa hàng.");</script>';
    echo '<meta http-equiv="refresh" content="1;url=login.php" />';
    exit;
}

$storedPassword = $row['MatKhau'] ?? '';
$isValid = false;

if (password_verify($password, $storedPassword)) {
    $isValid = true;
} elseif (hash_equals(md5(md5($password)), $storedPassword) || hash_equals(md5($password), $storedPassword)) {
    $isValid = true;
}

if (!$isValid) {
    echo '<script>window.alert("Email hoặc mật khẩu không đúng!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=login.php" />';
    exit;
}

$_SESSION['MaKH'] = (int)$row['MaKH'];
$_SESSION['HoTen'] = $row['HoTen'];
unset($_SESSION['voucher_notice_seen'], $_SESSION['voucher_schema_ready']);
header('Location: index.php');
exit;
?>