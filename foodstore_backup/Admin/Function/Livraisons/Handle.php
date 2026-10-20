

<?php
if (isset($_POST['updatedata'])) {
  $id = $_POST['MaNVGH'];
  $Sua_HoTen = $_POST['Sua_HoTen'];
  $Sua_DienThoaiNV = $_POST['Sua_DienThoaiNV'];
  $Sua_DiaChi = $_POST['Sua_DiaChi'];
  $Sua_Email = $_POST['Sua_Email'];
  $imgname = $_FILES['Sua_AnhDaiDien']['name'];
  $extension = pathinfo($imgname, PATHINFO_EXTENSION);
  $randomno = rand(0, 100000);
  $rename = 'ImageLi' . date('Ymd') . $randomno;
  $newname = $rename . '.' . $extension;
  $filename = $_FILES['Sua_AnhDaiDien']['tmp_name'];
  $path = "../Images/ImgLivraisons/" . $newname;
  $AnhDaiDienCu = $_POST['AnhDaiDienCu'];
  $path1 = "../Images/ImgLivraisons/" . $AnhDaiDienCu;
  $fileSize = $_FILES["Sua_AnhDaiDien"]["size"];
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
        if (is_numeric($Sua_DienThoaiNV)) {
          $query = "UPDATE nhanviengiaohang SET HoTen='$Sua_HoTen',DienThoaiNV =$Sua_DienThoaiNV,AnhDaiDien ='$newname',DiaChi ='$Sua_DiaChi',Email ='$Sua_Email'  WHERE MaNVGH ='$id'  ";
          mysqli_query($conn, $query);
          Edit();
          unlink($path1);
        } else {
          if (!is_numeric($Sua_DienThoaiNV)) {
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
    if (is_numeric($Sua_DienThoaiNV)) {
      $query = "UPDATE nhanviengiaohang SET HoTen='$Sua_HoTen',DienThoaiNV =$Sua_DienThoaiNV,DiaChi ='$Sua_DiaChi',Email ='$Sua_Email'  WHERE MaNVGH ='$id'  ";
      mysqli_query($conn, $query);
      Edit();
    } else {
      if (!is_numeric($Sua_DienThoaiNV)) {
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


<?php
if (isset($_POST['deletedata'])) {
  $id = $_POST['Xoa_MaNVGH'];
  $AnhDaiDienCu = $_POST['Xoa_AnhDaiDienCu'];
  $path1 = "../Images/ImgLivraisons/" . $AnhDaiDienCu;
  $query = "DELETE FROM nhanviengiaohang WHERE MaNVGH ='$id'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {
    unlink($path1);
    Delete();
  } else {
    echo '<script> alert("Chưa xoá"); </script>';
  }
}

?>


<?php

if (isset($_POST['insertdata'])) {
  $Them_HoTen = $_POST['Them_HoTen'];
  $Them_DienThoaiNV = $_POST['Them_DienThoaiNV'];
  $Them_DiaChi = $_POST['Them_DiaChi'];
  $Them_Email = $_POST['Them_Email'];
  $imgname = $_FILES['Them_AnhDaiDien']['name'];
  $extension = pathinfo($imgname, PATHINFO_EXTENSION);
  $randomno = rand(0, 100000);
  $rename = 'ImageLi' . date('Ymd') . $randomno;
  $newname = $rename . '.' . $extension;
  $filename = $_FILES['Them_AnhDaiDien']['tmp_name'];
  $path = "../Images/ImgLivraisons/" . $newname;
  $fileSize = $_FILES["Them_AnhDaiDien"]["size"];
  if ($fileSize > 100000000) {
    echo
    "
      <script>
        alert('Kích thước quá qui định');
      </script>
      ";
  } else {
    if (is_numeric($Them_DienThoaiNV)) {
      if (move_uploaded_file($filename, $path)) {
        try {
          $query1 = "
          INSERT INTO nhanviengiaohang
          VALUES (
          NULL ,
          '$Them_HoTen',
          '$Them_DienThoaiNV',
          '$newname',
          '$Them_DiaChi',
          '$Them_Email'
     
          );";
          mysqli_query($conn, $query1);
          Add();
        } catch (ErrorException $e) {
        }
      } else {
        echo
        "
      <script>
        alert('Chưa thêm');
      </script>
      ";
      }
    } else { {
        if (!is_numeric($Them_DienThoaiNV)) {
          $loi = "Vui lòng nhập dạng số !";
        }

        echo
        "
      <script>
        alert('Dữ liệu chưa được thêm, vui lòng kiểm tra lại các thông tin');
      </script>
      ";
      }
    }
  }
}
?>

<?php
if (isset($_POST['hidedata'])) {
  $id = $_POST['S_MaGiay'];
  $query = "UPDATE Giay SET HienThiSanPham=0  WHERE MaGiay='$id'  ";
  $query_run = mysqli_query($conn, $query);
  if ($query_run) {
    Edit();
  } else {
    echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
  }
}
?>


<?php


if (isset($_POST['showdata'])) {
  $id = $_POST['SS_MaGiay'];
  $query = "UPDATE Giay SET HienThiSanPham=1  WHERE MaGiay='$id'  ";
  $query_run = mysqli_query($conn, $query);
  if ($query_run) {
    Edit();
  } else {
    echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
  }
}

?>

