<?php
require 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$firstname = trim($_POST['firstname'] ?? '');
$lastname = trim($_POST['lastname'] ?? '');
$email = trim($_POST['email'] ?? '');
$sodt = trim($_POST['sodt'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirmPassword = trim($_POST['ConfirmPassword'] ?? '');

if ($firstname === '' || $lastname === '' || $email === '' || $sodt === '' || $password === '' || $confirmPassword === '') {
    echo '<script>window.alert("Vui lòng điền đầy đủ thông tin!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=register.php" />';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<script>window.alert("Email không hợp lệ!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=register.php" />';
    exit;
}

if (strlen($password) < 6) {
    echo '<script>window.alert("Mật khẩu phải có ít nhất 6 ký tự!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=register.php" />';
    exit;
}

if ($password !== $confirmPassword) {
    echo '<script>window.alert("Mật khẩu xác nhận không khớp!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=register.php" />';
    exit;
}

$duplicateCheck = mysqli_prepare($con, 'SELECT MaKH FROM khachhang WHERE LOWER(Email) = LOWER(?) LIMIT 1');
mysqli_stmt_bind_param($duplicateCheck, 's', $email);
mysqli_stmt_execute($duplicateCheck);
$duplicateResult = mysqli_stmt_get_result($duplicateCheck);

if (mysqli_num_rows($duplicateResult) > 0) {
    echo '<script>window.alert("Email này đã được sử dụng!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=register.php" />';
    exit;
}

$ngaysinh = trim($_POST['ngaysinh'] ?? '');
if ($ngaysinh === '') {
    $ngaysinh = null;
}

$fullName = trim($lastname . ' ' . $firstname);
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($con, "ALTER TABLE `khachhang` ADD COLUMN IF NOT EXISTS `NgayTaoTaiKhoan` DATETIME NULL DEFAULT NULL") or die(mysqli_error($con));

$stmt = mysqli_prepare($con, 'INSERT INTO khachhang (HoTen, TaiKhoan, Email, MatKhau, AnhKH, DienThoaiKH, DiaChiKH, NgaySinh, NgayTaoTaiKhoan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
if (!$stmt) {
    die('Lỗi tạo tài khoản: ' . mysqli_error($con));
}

$avatar = 'user.jpg';
$address = '';
$accountName = $fullName;
mysqli_stmt_bind_param($stmt, 'ssssssss', $fullName, $accountName, $email, $hashedPassword, $avatar, $sodt, $address, $ngaysinh);

if (!mysqli_stmt_execute($stmt)) {
    echo '<script>window.alert("Đăng ký thất bại. Vui lòng thử lại!");</script>';
    echo '<meta http-equiv="refresh" content="1;url=register.php" />';
    exit;
}

$_SESSION['email'] = $email;
$_SESSION['MaKH'] = mysqli_insert_id($con);
$_SESSION['HoTen'] = $fullName;
unset($_SESSION['voucher_notice_seen'], $_SESSION['voucher_schema_ready']);
header('Location: index.php');
exit;
?>