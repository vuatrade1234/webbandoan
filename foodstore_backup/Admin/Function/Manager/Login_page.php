
<?php 
	    include("Check_login.php");
?>
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
          <a href="#" class="logo d-flex align-items-center w-auto">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">MeoSammy_Store</span>
          </a>
        </div><!-- End Logo -->

        <div class="card mb-3">

          <div class="card-body">
         

            <div class="pt-4 pb-2">
              <h5 class="card-title text-center pb-0 fs-4"> Đăng nhập</h5>
              <p class="text-center small">Nhập tên người dùng và mật khẩu của bạn để đăng nhập</p>
            </div>

            <form method="post" class="row g-3 needs-validation" novalidate>

              <div class="col-12">
                <label for="yourUsername" class="form-label">Tài khoản</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                  <input type="text" name="TaiKhoan" class="form-control" id="yourUsername" required value="<?php if(isset($tai_khoan)) echo $tai_khoan ?>">
                  <div class="invalid-feedback">Vui lòng nhập tài khoản!</div>
                </div>
              </div>

              <div class="col-12">
                <label for="yourPassword" class="form-label">Mật khẩu</label>
                <input type="password" name="MatKhau" class="form-control" id="yourPassword" required value="<?php if(isset($mat_khau)) echo $mat_khau ?>">
                <div class="invalid-feedback">Vui lòng nhập mật khẩu!</div>
              </div>

              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">Lưu thông tin</label>
                </div>
              </div>
              <div class="col-12">
                <!-- <input type="submit" name="login_admin" value="login"> -->
                <button class="btn btn-primary w-100" name="login_admin" type="submit">Đăng nhập</button>
              </div>
              <div class="col-12 text-danger">
        
                <?php if (isset($loi)) echo $loi ?>
              </div>

            </form>

          </div>
        </div>


      </div>
    </div>
  </div>

</section>
<!-- Button trigger modal -->
