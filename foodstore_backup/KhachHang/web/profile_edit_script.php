<?php
require 'connection.php';
session_start();

$email = $_SESSION['MaKH'];
$query = "SELECT * FROM khachhang WHERE MaKH='$email'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
if (mysqli_num_rows($result) <> 0) {
    $hoten = $_POST['hoten'];
    if (isset($hoten)) {
        $result = mysqli_query($con, "update khachhang set HoTen='$hoten' where MaKH='$email'") or die(mysqli_error($con));
    }
    $taikhoan = $_POST['taikhoan'];
    if (isset($taikhoan)) {
        $result = mysqli_query($con, "update khachhang set TaiKhoan='$taikhoan' where MaKH='$email'") or die(mysqli_error($con));
    }
    $diachikh = $_POST['diachikh'];
    if (isset($diachikh)) {
        $result = mysqli_query($con, "update khachhang set DiaChiKH='$diachikh' where MaKH='$email'") or die(mysqli_error($con));
    }
    $dienthoaikh = $_POST['dienthoaikh'];
    if (isset($dienthoaikh)) {
        $result = mysqli_query($con, "update khachhang set DienThoaiKH='$dienthoaikh' where MaKH='$email'") or die(mysqli_error($con));
    }
    $ngaysinh = $_POST['ngaysinh'];
    if (isset($ngaysinh) and $ngaysinh != $row['NgaySinh'] and !(empty(trim($ngaysinh)) and $ngaysinh != 0)) {
        $result = mysqli_query($con, "update khachhang set NgaySinh='$ngaysinh' where MaKH='$email'") or die(mysqli_error($con));
    }
    $gioitinh = $_POST['gioitinh'];
    if (isset($gioitinh) and $gioitinh != $row['GioiTinh'] and !(empty(trim($gioitinh)) and $gioitinh != 0)) {
        $result = mysqli_query($con, "update khachhang set GioiTinh='$gioitinh' where MaKH='$email'") or die(mysqli_error($con));
    }
    // $anhkh=$_POST['anhkh'];
    $imgname = $_FILES['anhkh']['name'];
    $extension = pathinfo($imgname, PATHINFO_EXTENSION);
    $randomno = rand(0, 100000);
    $rename = 'Image' . date('Ymd') . $randomno;
    $newname = $rename . '.' . $extension;
    $filename = $_FILES['anhkh']['tmp_name'];
    $path = "./imgKH/" . $newname;
    $fileSize = $_FILES["anhkh"]["size"];
    $anhcu = $_POST['anhcu'];
    $pathcu = "./imgKH/" . $anhcu;

    if ($fileSize > 100000000) {
        echo
        "
                <script>
                  alert('Kích thước quá qui định');
                </script>
                ";
    } else {
        if (move_uploaded_file($filename, $path)) {
            $result = mysqli_query($con, "update khachhang set AnhKH='$newname' where MaKH='$email'") or die(mysqli_error($con));
            if ($anhcu != 'user.jpg') {
                unlink($pathcu);
            }

            echo
            "
                    <script>
                      alert('Cập nhật thành công');
                    </script>
                    ";
        }
    }


?>

    <meta http-equiv="refresh" content="1;url=profileKH.php" />
<?php
}

?>