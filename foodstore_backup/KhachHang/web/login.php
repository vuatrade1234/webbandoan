<style>
	.mid-grid-left {
		display: none;
	}
</style>
<?php include("Layout_KhachHang_Header.php") ?>
<!----//End-bottom-header---->
<!---//End-header---->
<!--- start-content---->
<div class="content login-box">
	<div class="login-main">
		<div class="wrap">
			<h1>ĐĂNG NHẬP HOẶC TẠO MỘT TÀI KHOẢN</h1>
			<div class="login-left">
				<h3>KHÁCH HÀNG MỚI</h3>
				<p>Bằng cách tạo tài khoản với cửa hàng của chúng tôi, bạn có thể lưu trữ địa chỉ giao hàng, xem và theo dõi đơn hàng trong tài khoản của mình, v.v.</p>
				<a class="acount-btn" href="register.php">Tạo một tài khoản</a>
			</div>
			<div class="login-right">
				<h3>ĐÃ ĐĂNG KÝ</h3>
				<p>Nếu bạn đã có tài khoản, xin vui lòng đăng nhập!!!</p>
				<form method="post" action="login_submit.php">
					<div>
						<span>Địa chỉ email<label>*</label></span>
						<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
					</div>
					<div>
						<span>mật khẩu<label>*</label></span>
						<input type="password" name="password" pattern=".{6,}" required>
					</div>
					<a class="forgot" href="#">Quên mật khẩu?</a>
					<input type="submit" value="đăng nhập" />
				</form>
			</div>
			<div class="clear"> </div>
		</div>
	</div>
</div>
<!---- start-bottom-grids---->

<!---- //End-bottom-grids---->
<!--- //End-content---->
<!---start-footer---->

<?php include("Layout_KhachHang_Footer.php"); ?>
<!---//End-footer---->
<!---//End-wrap---->
</body>

</html>