

<?php
if (isset($_POST['updatedata'])) {
  $id = $_POST['MaGiay'];
  $TenGiay = $_POST['TenGiay'];
  $GiaBan = $_POST['GiaBan'];
  $Size = $_POST['Size'];
  $Màu = $_POST['Màu'];
  $MoTa = $_POST['MoTa'];
  // $NgayCapNhat = $_POST['NgayCapNhat'];
  $SoLuongTon = $_POST['SoLuongTon'];
  $MaLG = $_POST['MaLG'];
  $MaTH = $_POST['MaTH'];
  $MaNCC = $_POST['MaNCC'];

  $GiaBanCu = 0;
  if (!empty($_POST["GiaBanCu"])) {
    $GiaBanCu = $_POST['GiaBanCu'];
  }
  $imgname = $_FILES['AnhBia']['name'];
  $extension = pathinfo($imgname, PATHINFO_EXTENSION);
  $randomno = rand(0, 100000);
  $rename = 'Image' . date('Ymd') . $randomno;
  $newname = $rename . '.' . $extension;
  $filename = $_FILES['AnhBia']['tmp_name'];
  $path = "../Images/ImgProducts/" . $newname;
  $AnhBiaCu = $_POST['AnhBiaCu'];
  $path1 = "../Images/ImgProducts/". $AnhBiaCu;
  $fileSize = $_FILES["AnhBia"]["size"];
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
        if (is_numeric($SoLuongTon) and is_numeric($GiaBan) and is_numeric($GiaBanCu) ) {
          $query = "UPDATE Giay SET TenGiay='$TenGiay',GiaBan =$GiaBan,MoTa ='$MoTa',AnhBia ='$newname',NgayCapNhat = now(),SoLuongTon =$SoLuongTon,MaLG =$MaLG,MaTH =$MaTH ,MaNCC =$MaNCC ,GiaBanCu =$GiaBanCu,Size = '$Size',Màu = '$Màu'   WHERE MaGiay='$id'  ";
          mysqli_query($conn, $query);
          Edit();
          unlink($path1);
         
          
        } else {
          if (!is_numeric($GiaBan)) {
            $loi = "Vui lòng nhập dạng số !";
          }
          if (!is_numeric($SoLuongTon)) {
            $loi2 = "Vui lòng nhập dạng số !";
          }
          if (!is_numeric($GiaBanCu)) {
            $loi3 = "Vui lòng nhập dạng số !";
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
    if (is_numeric($SoLuongTon) and is_numeric($GiaBan) and is_numeric($GiaBanCu)) {
    $query = "UPDATE Giay SET TenGiay='$TenGiay',GiaBan =$GiaBan,MoTa ='$MoTa',NgayCapNhat = now(),SoLuongTon =$SoLuongTon,MaLG =$MaLG,MaTH =$MaTH ,MaNCC =$MaNCC  ,GiaBanCu =$GiaBanCu,Size = '$Size',Màu = '$Màu'    WHERE MaGiay='$id'  ";
    mysqli_query($conn, $query);
    Edit();}
    else {
      if (!is_numeric($GiaBan)) {
        $loi = "Vui lòng nhập dạng số !";
      }
      if (!is_numeric($SoLuongTon)) {
        $loi2 = "Vui lòng nhập dạng số !";
      }
      if (!is_numeric($GiaBanCu)) {
        $loi3 = "Vui lòng nhập dạng số !";
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
  $id = $_POST['D_MaGiay'];
  $AnhBiaCu = $_POST['D_AnhBiaCu'];
  $path1 = "../Images/ImgProducts/". $AnhBiaCu;
  $query = "DELETE FROM Giay WHERE MaGiay='$id'";
  $query_run_1 = mysqli_query($conn,"DELETE FROM chitietdathang WHERE MaGiay='$id'");
  $query_run = mysqli_query($conn, $query);
  

  if ($query_run and  $query_run_1) {
    unlink($path1);
    Delete();
  } else {
    echo '<script> alert("Chưa xoá"); </script>';
  }
}

?>


<?php

if (isset($_POST['insertdata'])) {
  $I_TenGiay = $_POST['I_TenGiay'];
  $I_GiaBan = $_POST['I_GiaBan'];
  $I_Size = $_POST['I_Size'];
  $I_Màu = $_POST['I_Màu'];

  $I_MoTa = $_POST['I_MoTa'];
  // $I_NgayCapNhat = $_POST['I_NgayCapNhat'];
  $I_SoLuongTon = $_POST['I_SoLuongTon'];
  $I_MaLG = $_POST['I_MaLG'];
  $I_MaTH = $_POST['I_MaTH'];
  $I_MaNCC = $_POST['I_MaNCC'];
  $imgname = $_FILES['I_AnhBia']['name'];
  $extension = pathinfo($imgname, PATHINFO_EXTENSION);
  $randomno = rand(0, 100000);
  $rename = 'Image' . date('Ymd') . $randomno;
  $newname = $rename . '.' . $extension;
  $filename = $_FILES['I_AnhBia']['tmp_name'];
  $path = "../Images/ImgProducts/" . $newname;
  $fileSize = $_FILES["I_AnhBia"]["size"];
  if ($fileSize > 100000000) {
    echo
    "
      <script>
        alert('Kích thước quá qui định');
      </script>
      ";
  } else {
    if (is_numeric($I_SoLuongTon) and is_numeric($I_GiaBan)) {
    if (move_uploaded_file($filename, $path)) {
      try {
          $query1 = "
          INSERT INTO Giay
          VALUES (
          NULL ,
          '$I_TenGiay',
          '$I_GiaBan',
          '$I_MoTa',
          '$newname',
          now(),
          '$I_SoLuongTon',
          '$I_MaLG',
          '$I_MaTH',
          '$I_MaNCC',
          1,
          null,
          '$I_Size',
          '$I_Màu'
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
  }else {
    {
      if (!is_numeric($I_GiaBan)) {
        $loi = "Vui lòng nhập dạng số !";
      }
      if (!is_numeric($I_SoLuongTon)) {
        $loi2 = "Vui lòng nhập dạng số !";
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

