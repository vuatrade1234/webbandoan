<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Profile/Handle.php");
?>
<?php
  $id = $_SESSION["MaQTV"];
  $query = "SELECT * FROM quantrivien where MaQTV='$id'";
  $query_run = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($query_run);
?>


<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

          <img src="../Images/ImgAdmins/<?php
                                                echo $row["AnhDaiDien"]                
                                                                ?>" alt="Profile" class="rounded-circle">
          <h2><?php
                                                echo $row["HoTen"]                
                                                                ?></h2>
          <h3><?php
                                                              
                                                                  if($row["QuanLi"]) {
                                                                    echo "Quản lí";
                                                                  }else echo "Nhân viên";
                                                                 
                                                               
                                                                ?></h3>
          <div class="social-links mt-2">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Tổng quát</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Chỉnh sửa</button>
            </li>

          
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Đối mật khẩu</button>
            </li>

          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">
             

              <h5 class="card-title">Chi tiết hồ sơ</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Họ tên</div>
                <div class="col-lg-9 col-md-8"><?php
                                                            echo $row["HoTen"]
                                                                ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Điện thoại</div>
                <div class="col-lg-9 col-md-8"><?php
                                                                
                                                                  echo $row["DienThoaiNV"];
                                                                
                                                                ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Địa chỉ</div>
                <div class="col-lg-9 col-md-8"><?php
                                                               
                                                                  echo $row["DiaChi"];
                                                              
                                                                ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?php
                                                             
                                                                  echo $row["Email"];
                                                              
                                                                ?></div>
              </div>

  

            </div>

            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Hình ảnh</label>
                  <div class="col-md-8 col-lg-9">
                  <input type="hidden"  name="AnhDaiDienCu"  value="<?php
                                                               
                                                                  echo $row["AnhDaiDien"];
                                                               
                                                                ?>">
                  <img class="preview" src="../Images/ImgAdmins/<?php
                                                               
                                                                  echo $row["AnhDaiDien"];
                                                                
                                                                ?>" alt="Profile" class="rounded-circle">
                                                                
                    <div class="pt-2">
                    <input id="input-img" accept=".jpg, .jpeg, .png" value="" type="file" name="AnhDaiDien" class="form-control" id="AnhDaiDien" placeholder="Nhập tên ảnh">

                      <!-- <input accept=".jpg, .jpeg, .png" name="AnhDaiDien" type="file" class="btn btn-primary btn-sm" title="Chọn ảnh mới"> -->
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="HoTen" class="col-md-4 col-lg-3 col-form-label">Họ tên</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="HoTen" type="text" class="form-control" id="HoTen" value="<?php
                                                               
                                                                  echo $row["HoTen"];
                                                               
                                                                ?>">
                  </div>
                </div>

  
                <div class="row mb-3">
                  <label for="DienThoaiNV" class="col-md-4 col-lg-3 col-form-label">Điện thoại</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="DienThoaiNV" type="text" class="form-control" id="DienThoaiNV" value="<?php
                                                               
                                                                  echo $row["DienThoaiNV"];
                                                               
                                                                ?>">
                                                                <small class="text-danger"><?php if(isset($loi)) echo $loi ?></small>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="DiaChi" class="col-md-4 col-lg-3 col-form-label">Địa chỉ</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="DiaChi" type="text" class="form-control" id="DiaChi" value="<?php
                                                               
                                                                  echo $row["DiaChi"];
                                                               
                                                                ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="Email" type="text" class="form-control" id="Email" value="<?php
                                                               
                                                                  echo $row["Email"];
                                                               
                                                                ?>">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="updatedata" class="btn btn-primary">Lưu thay đổi</button>
                </div>
              </form><!-- End Profile Edit Form -->

            </div>

    

            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form method="post">

                <div class="row mb-3">
                  <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu hiện tại</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="password" type="password" class="form-control" id="currentPassword" value="<?php if(isset($password))  echo $password?>">
                    <small class="text-danger"><?php if(isset($loi1))  echo $loi1?></small>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu mới</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="newpassword" type="password" class="form-control" id="newPassword" value="<?php if(isset($newpassword))  echo $newpassword?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Nhập lại mật khẩu</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="renewpassword" type="password" class="form-control" id="renewPassword" value="<?php if(isset($renewpassword))  echo $renewpassword?>">
                    <small class="text-danger"><?php if(isset($loi))  echo $loi?></small>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" name="changepass" class="btn btn-primary">Đổi mật khẩu</button>
                </div>
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>

<script>
const inputImg = document.querySelector('#input-img')
inputImg.addEventListener('change', (e) => {
    let file = e.target.files[0]
    console.log(file)
    if (!file) return
    let img = document.createElement('img')
    img = URL.createObjectURL(file)
    document.querySelector('.preview').src = img;
})
</script>