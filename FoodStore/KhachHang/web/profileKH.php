<?php
session_start();
if (!isset($_SESSION['MaKH'])) {
    header('Location: index.php');
    exit;
}
include("Layout_KhachHang_Header.php");

$customerId = (int)$_SESSION['MaKH'];
$query = "SELECT * FROM khachhang WHERE MaKH = '$customerId' LIMIT 1";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) === 0) {
    echo '<div class="empty-state">Không tìm thấy thông tin khách hàng.</div>';
    include("Layout_KhachHang_Footer.php");
    exit;
}

$row = mysqli_fetch_assoc($result);
$avatar = !empty($row['AnhKH']) ? 'imgKH/' . $row['AnhKH'] : 'imgKH/user.jpg';
$gender = $row['GioiTinh'] == 1 ? 'Nam' : ($row['GioiTinh'] == 0 ? 'Nữ' : 'Khác');
?>

<div class="profile-shell">
    <div class="profile-card">
        <aside class="profile-sidebar">
            <div class="profile-avatar-wrap">
                <img src="<?php echo $avatar; ?>" alt="avatar" class="profile-avatar">
            </div>
            <h2><?php echo htmlspecialchars($row['HoTen']); ?></h2>
            <p><?php echo htmlspecialchars($row['Email']); ?></p>
            <div class="profile-actions">
                <a href="profile_edit.php" class="primary-btn">Chỉnh sửa</a>
                <a href="index.php" class="secondary-btn">Trang chủ</a>
            </div>
        </aside>

        <section class="profile-content">
            <div class="profile-title-row">
                <span class="auth-subtitle">Hồ sơ</span>
                <h1>Thông tin người dùng</h1>
            </div>

            <div class="profile-grid">
                <div class="profile-item">
                    <span>Họ tên</span>
                    <strong><?php echo htmlspecialchars($row['HoTen']); ?></strong>
                </div>
                <div class="profile-item">
                    <span>Tên tài khoản</span>
                    <strong><?php echo htmlspecialchars($row['TaiKhoan'] ?? 'Chưa cập nhật'); ?></strong>
                </div>
                <div class="profile-item">
                    <span>Email</span>
                    <strong><?php echo htmlspecialchars($row['Email']); ?></strong>
                </div>
                <div class="profile-item">
                    <span>Điện thoại</span>
                    <strong><?php echo htmlspecialchars($row['DienThoaiKH'] ?? 'Chưa cập nhật'); ?></strong>
                </div>
                <div class="profile-item">
                    <span>Địa chỉ</span>
                    <strong><?php echo htmlspecialchars($row['DiaChiKH'] ?? 'Chưa cập nhật'); ?></strong>
                </div>
                <div class="profile-item">
                    <span>Ngày sinh</span>
                    <strong><?php echo htmlspecialchars($row['NgaySinh'] ?? 'Chưa cập nhật'); ?></strong>
                </div>
                <div class="profile-item">
                    <span>Giới tính</span>
                    <strong><?php echo $gender; ?></strong>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include("Layout_KhachHang_Footer.php"); ?>
</body>
</html>