<?php
$id = $_SESSION["MaQTV"];
$query = "SELECT * FROM quantrivien where MaQTV='$id'";
$query_run = mysqli_query($conn, $query);
$row = mysqli_fetch_array($query_run);


$donhangmoi  = mysqli_query($conn, "select count(SoDH) as 'donhangmoi' from dondathang where TinhTrangGiaoHang = 'cho xac nhan'");
$ketqua = mysqli_fetch_array($donhangmoi);

?>
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="?thamso=sanpham" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">MeoSammy_Store</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">


      <li  class="nav-item dropdown">

        <a  class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number"> <?php  echo $ketqua["donhangmoi"]; ?></span>
         
        </a><!-- End Notification Icon -->

        <ul style="transform: translate(-42px, 51px) !important;"  class="dropdown-menu  dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            Bạn có <?php  echo $ketqua["donhangmoi"]; ?> đơn hàng mới
         
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>



        </ul><!-- End Notification Dropdown Items -->

      </li><!-- End Notification Nav -->


      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

          <img src="../Images/ImgAdmins/<?php
                                        echo $row["AnhDaiDien"];

                                        ?>" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php

                                                                echo $row["TaiKhoan"];

                                                                ?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6> <?php


                  echo $row["TaiKhoan"];




                  ?></h6>
            <span><?php
                  if ($row["QuanLi"]) {
                    echo "Quản lí";
                  } else {
                    echo "Nhân viên";
                  }


                  ?></span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="?thamso=thongtincanhan">
              <i class="bi bi-person"></i>
              <span>Thông tin cá nhân</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>


          <li>
            <a class="dropdown-item d-flex align-items-center" href="?thamso=thoat">
              <i class="bi bi-box-arrow-right"></i>
              <span>Đăng xuất</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->