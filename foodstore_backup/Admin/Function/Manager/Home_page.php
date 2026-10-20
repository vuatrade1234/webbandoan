<?php
include("Check_login.php");
?>


<!-- ======= Header ======= -->
<?php
include("Header.php");
?>


<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="?thamso=thanhvien">
        <i class="bi bi-grid"></i>
        <span>Thành viên</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
    
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="?thamso=baitap">
            <i class="bi bi-circle"></i><span>PHP & FORM</span>
          </a>
        </li>
        <li>
          <a href="?thamso=baitapp2">
            <i class="bi bi-circle"></i><span>MẢNG, CHUỖI & HÀM</span>
          </a>
        </li>
        <li>
          <a href="?thamso=baitapp3">
            <i class="bi bi-circle"></i><span> PHP & MYSQL</span>
          </a>
        </li>


      </ul>
    </li><!-- End Components Nav -->

    
    <li class="nav-heading">Quản lí</li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="?thamso=sanpham">
        <i class="bi bi-gem"></i>
        <span>Sản phẩm</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="?thamso=thuonghieu">
        <i class="bi bi-card-list"></i>
        <span>Thương hiệu</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="?thamso=loaigiay">
        <i class="bi bi-layout-text-window-reverse"></i>
        <span>Loại giày</span>
      </a>
    </li><!-- End Contact Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="?thamso=nhacungcap">
        <i class="bi bi-card-list"></i>
        <span>Nhà cung cấp</span>
      </a>
    </li><!-- End Register Page Nav -->

    <?php if($_SESSION["QuanLi"] == true) { ?>
      <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-lines-fill"></i><span>Nhân viên</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="?thamso=quantrivien">
            <i class="bi bi-circle"></i><span>Nhân viên quản trị</span>
          </a>
        </li>
        <li>
          <a href="?thamso=nhanviengiaohang">
            <i class="bi bi-circle"></i><span>Nhân viên giao hàng</span>
          </a>
        </li>

      </ul>
    </li><!-- End Forms Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="?thamso=khachhang">
        <i class="bi bi-person-fill"></i> <!-- Biểu tượng đã thay đổi -->
        <span>Khách Hàng</span>
      </a>
    </li><!-- End Customer Page Nav -->

      <?php }
    ?>
     

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Đơn hàng</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="?thamso=hangchoxacnhan">
            <i class="bi bi-circle"></i><span>Chờ xác nhận</span>
          </a>
        </li>
        <li>
          <a href="?thamso=hangdangxuli">
            <i class="bi bi-circle"></i><span>Đã xác nhận</span>
          </a>
        </li>
        <li>
          <a href="?thamso=giaohangthanhcong">
            <i class="bi bi-circle"></i><span>Đã giao</span>
          </a>
        </li>
      </ul>
    </li><!-- End Charts Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="?thamso=thongke">
        <i class="bi bi-graph-up-arrow"></i>
        <span>Thống kê</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->
  </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">
  <?php
  include("./Function/Manager/Control.php");
  ?>
</main><!-- End #main -->

<?php
include("Footer.php");
?>
<!-- ======= Footer ======= -->