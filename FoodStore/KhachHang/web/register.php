<?php
session_start();
if (isset($_SESSION['MaKH'])) {
    header('Location: index.php');
    exit;
}
include("Layout_KhachHang_Header.php");
?>

<div class="auth-shell auth-shell-compact">
    <div class="auth-panel auth-panel-register">
        <div class="auth-visual">
            <span class="auth-badge">Đăng ký</span>
            <h1>Tạo tài khoản để thưởng thức món ngon mỗi ngày.</h1>
            <p>Đăng ký ngay để lưu địa chỉ, theo dõi đơn hàng và nhận chương trình ưu đãi hấp dẫn cho thành viên.</p>
            <ul>
                <li>✅ Theo dõi lịch sử mua hàng</li>
                <li>✅ Đặt hàng nhanh hơn</li>
                <li>✅ Ưu đãi riêng cho khách hàng thân thiết</li>
            </ul>
        </div>

        <div class="auth-form-box">
            <div class="auth-header">
                <span class="auth-subtitle">Tạo tài khoản</span>
                <h2>Thông tin cá nhân</h2>
            </div>

            <form action="user_registration_script.php" method="post" class="auth-form">
                <div class="field-row">
                    <div class="field-group">
                        <label for="firstname">Tên</label>
                        <input id="firstname" type="text" name="firstname" placeholder="Tên" required>
                    </div>
                    <div class="field-group">
                        <label for="lastname">Họ và tên lót</label>
                        <input id="lastname" type="text" name="lastname" placeholder="Họ và tên lót" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="name@example.com" required>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label for="sodt">Số điện thoại</label>
                        <input id="sodt" type="text" name="sodt" placeholder="0909 000 000" required>
                    </div>
                    <div class="field-group">
                        <label for="ngaysinh">Ngày sinh</label>
                        <input id="ngaysinh" type="date" name="ngaysinh" required>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label for="password">Mật khẩu</label>
                        <input id="password" type="password" name="password" placeholder="Ít nhất 6 ký tự" required>
                    </div>
                    <div class="field-group">
                        <label for="ConfirmPassword">Xác nhận mật khẩu</label>
                        <input id="ConfirmPassword" type="password" name="ConfirmPassword" placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <button type="submit" class="primary-btn">Tạo tài khoản</button>
            </form>

            <div class="auth-divider"><span>đã có tài khoản?</span></div>
            <a href="login.php" class="secondary-btn">Đăng nhập ngay</a>
        </div>
    </div>
</div>

<?php include("Layout_KhachHang_Footer.php"); ?>
</body>
</html>