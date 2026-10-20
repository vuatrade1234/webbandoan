<?php 
  if (isset($_POST['changepass'])) {
    $id = $_SESSION["MaQTV"];
    $query = "SELECT * FROM quantrivien where MaQTV='$id'";
    $query_run = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($query_run);
    $password = $_POST["password"];
    $newpassword = $_POST["newpassword"];
    $renewpassword = $_POST["renewpassword"];
    if(password_verify($password,$row["MatKhau"])) {
          $has_pass = password_hash($newpassword,PASSWORD_DEFAULT); 
          if($newpassword == $renewpassword) {
            $query = "UPDATE quantrivien SET MatKhau='$has_pass' WHERE MaQTV='$id'  ";
            mysqli_query($conn, $query);
            $password = $newpassword = $renewpassword = "";
            Edit();
          }else {
            $loi = "Nhập lại mật khẩu sai!";
          }
         

     }
     else {
      $loi1 = "Mật khẩu cũ sai!";
     }

  }

?>






<?php
if (isset($_POST['updatedata'])) {
  $id = $_SESSION["MaQTV"];
  $HoTen = $_POST["HoTen"];
  $DienThoaiNV = $_POST["DienThoaiNV"];
  $DiaChi = $_POST["DiaChi"];
  $Email = $_POST["Email"];


  $imgname = $_FILES['AnhDaiDien']['name'];
  $extension = pathinfo($imgname, PATHINFO_EXTENSION);
  $randomno = rand(0, 100000);
  $rename = 'Image' . date('Ymd') . $randomno;
  $newname = $rename . '.' . $extension;
  $filename = $_FILES['AnhDaiDien']['tmp_name'];
  $path = "../Images/ImgAdmins/" . $newname;
  $AnhDaiDienCu = $_POST['AnhDaiDienCu'];
  $path1 = "../Images/ImgAdmins/". $AnhDaiDienCu;
  $fileSize = $_FILES["AnhDaiDien"]["size"];
  if ($imgname != "") {
    if ($fileSize > 100000000) {
      echo
      "
          <script>
            alert('Kích thước quá qui định');
          </script>
          ";
    } else {
      if (move_uploaded_file($filename, $path)) {
        if (is_numeric($DienThoaiNV)) {
          $query = "UPDATE quantrivien SET HoTen='$HoTen',DienThoaiNV ='$DienThoaiNV',DiaChi ='$DiaChi',AnhDaiDien ='$newname',Email ='$Email'  WHERE MaQTV='$id'  ";
          mysqli_query($conn, $query);
          Edit();
          if($AnhDaiDienCu != 'user.png') {
            unlink($path1);
          }
        } else {
          if (!is_numeric($DienThoaiNV)) {
            $loi = "Vui lòng nhập dạng số !";
          }
          echo
          "
          <script>
            alert('Dữ liệu chưa được sửa, vui lòng kiểm tra lại các thông tin');
          </script>
          ";
        }
      }
    }
  } else {
    if (is_numeric($DienThoaiNV)) {
        $query = "UPDATE quantrivien SET HoTen='$HoTen',DienThoaiNV ='$DienThoaiNV',DiaChi ='$DiaChi',Email ='$Email'  WHERE MaQTV='$id'  ";
        mysqli_query($conn, $query);
    Edit();}
    else {
      if (!is_numeric($DienThoaiNV)) {
        $loi = "Vui lòng nhập dạng số !";
      }
      echo
      "
      <script>
        alert('Dữ liệu chưa được sửa, vui lòng kiểm tra lại các thông tin');
      </script>
      ";
    }
  }
}
?>