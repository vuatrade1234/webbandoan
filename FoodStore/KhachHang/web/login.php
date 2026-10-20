<?php
session_start();
if (isset($_SESSION['MaKH'])) {
    header('Location: index.php');
    exit;
}
include("Layout_KhachHang_Header.php");
?>

<div class="auth-shell">
    <div class="auth-panel auth-panel-login">
        <div class="auth-visual">
            <span class="auth-badge">SnackStore</span>
            <h1>Ăn vặt ngon, giao hàng nhanh, trải nghiệm cực đã.</h1>
            <p>Đăng nhập để theo dõi đơn hàng, lưu địa chỉ giao hàng và nhận ưu đãi đặc biệt mỗi tuần.</p>
            <ul>
                <li>✅ Tích điểm mua hàng</li>
                <li>✅ Đặt hàng nhanh trong 2 phút</li>
                <li>✅ Theo dõi trạng thái theo thời gian thực</li>
            </ul>
        </div>

        <div class="auth-form-box">
            <div class="auth-header">
                <span class="auth-subtitle">Đăng nhập</span>
                <h2>Chào mừng quay lại</h2>
            </div>

            <form method="post" action="login_submit.php" class="auth-form">
                <div class="field-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="name@example.com" required>
                </div>

                <div class="field-group">
                    <label for="password">Mật khẩu</label>
                    <input id="password" type="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="auth-extra">
                    <label class="remember-me"><input type="checkbox" /> Ghi nhớ tôi</label>
                    <a href="#">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="primary-btn">Đăng nhập</button>
            </form>

            <div class="auth-divider"><span>hoặc</span></div>

            <a href="register.php" class="secondary-btn">Tạo tài khoản mới</a>
        </div>
    </div>
</div>

<?php include("Layout_KhachHang_Footer.php"); ?>
</body>
</html>