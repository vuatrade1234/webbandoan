



<?php
if (isset($_POST['deletedata'])) {
  $id = $_POST['Xoa_MaQTV'];

  $AnhDaiDienCu = $_POST['Xoa_AnhDaiDienCu'];
  $Xoa_QuanLi = $_POST['Xoa_QuanLi'];
  if ($Xoa_QuanLi == false) {
    $path1 = "../Images/ImgAdmins/" . $AnhDaiDienCu;
    $query = "DELETE FROM quantrivien WHERE MaQTV='$id'";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
      if($AnhDaiDienCu != 'user.png') {
        unlink($path1);
      }
      Delete();
    } else {
      echo '<script> alert("Chưa xoá"); </script>';
    }
  } else {
    echo '<script> alert("Không thể xoá nhân viên quản lí"); </script>';
  }
}


?>


<?php

if (isset($_POST['insertdata'])) {
  $Them_TaiKhoan = $_POST['Them_TaiKhoan'];
  $Them_MatKhau = $_POST['Them_MatKhau'];
  $has_pass = password_hash($Them_MatKhau, PASSWORD_DEFAULT);
  $Them_HoTen = $_POST['Them_HoTen'];
  // $I_NgayCapNhat = $_POST['I_NgayCapNhat'];
  $Them_DienThoai = $_POST['Them_DienThoai'];
//  $Them_ChucVu = $_POST['Them_ChucVu'];
  $Kiem_Tra_Trung =mysqli_query($conn, "Select * from QuanTriVien where TaiKhoan = '$Them_TaiKhoan'");
  if (mysqli_num_rows($Kiem_Tra_Trung) == 0) {
    $query1 = "
    INSERT INTO QuanTriVien
    VALUES (
    NULL ,
    '$Them_TaiKhoan',
    '$has_pass',
      0,
      '$Them_HoTen',
      '$Them_DienThoai',
    'user.png',
    null,
    null
 
    );";
  mysqli_query($conn, $query1);
  Add();
  }else {
    echo '<script> alert("Tài khoản đã tồn tại"); </script>';
  }


}
?>

