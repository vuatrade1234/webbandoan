<?php
// Kết nối cơ sở dữ liệu

// Thêm người dùng mới
if (isset($_POST['insertUser'])) {
    $HoTen = $_POST['HoTen'];
    $TaiKhoan = $_POST['TaiKhoan'];
    $MatKhau = $_POST['MatKhau'];
    $has_pass = password_hash($MatKhau, PASSWORD_DEFAULT);
    $Email = $_POST['Email'];
    $DiaChiKH = $_POST['DiaChiKH'];
    $DienThoaiKH = $_POST['DienThoaiKH'];
    $NgaySinh = $_POST['NgaySinh'];
    $GioiTinh = $_POST['GioiTinh'];

    // Xử lý ảnh đại diện
    $AnhKH = $_FILES['AnhKH']['name'];
    $Anh_tmp = $_FILES['AnhKH']['tmp_name'];
    $target_dir = "../Images/ImgCustomer/";
    move_uploaded_file($Anh_tmp, $target_dir . $AnhKH);

    $checkQuery = "SELECT * FROM khachhang WHERE TaiKhoan = '$TaiKhoan'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $insertQuery = "INSERT INTO khachhang 
                        (HoTen, TaiKhoan, MatKhau, Email, DiaChiKH, DienThoaiKH, NgaySinh, GioiTinh, AnhKH)
                        VALUES ('$HoTen', '$TaiKhoan', '$has_pass', '$Email', '$DiaChiKH', '$DienThoaiKH', '$NgaySinh', '$GioiTinh', '$AnhKH')";
        $insertResult = mysqli_query($conn, $insertQuery);

        echo $insertResult ? '<script>alert("Đăng ký người dùng thành công!");</script>' 
                           : '<script>alert("Có lỗi khi thêm người dùng!");</script>';
    } else {
        echo '<script>alert("Tài khoản đã tồn tại!");</script>';
    }
}

// Cập nhật thông tin người dùng (có xử lý ảnh mới nếu có)
if (isset($_POST['updateUser'])) {
    $MaKH = $_POST['MaKH'];
    $HoTen = $_POST['HoTen'];
    $TaiKhoan = $_POST['TaiKhoan'];
    $Email = $_POST['Email'];
    $DiaChiKH = $_POST['DiaChiKH'];
    $DienThoaiKH = $_POST['DienThoaiKH'];
    $NgaySinh = $_POST['NgaySinh'];
    $GioiTinh = $_POST['GioiTinh'];

    // Lấy ảnh hiện tại
    $getOld = mysqli_query($conn, "SELECT AnhKH FROM khachhang WHERE MaKH = '$MaKH'");
    $oldRow = mysqli_fetch_assoc($getOld);
    $oldImage = $oldRow['AnhKH'];

    // Nếu có ảnh mới
    if (!empty($_FILES['AnhKH']['name'])) {
        $AnhKH = $_FILES['AnhKH']['name'];
        $Anh_tmp = $_FILES['AnhKH']['tmp_name'];
        $target_dir = "../Images/ImgCustomer/";

        // Xoá ảnh cũ nếu không phải mặc định
        if ($oldImage && $oldImage != 'user.png' && file_exists($target_dir . $oldImage)) {
            unlink($target_dir . $oldImage);
        }

        move_uploaded_file($Anh_tmp, $target_dir . $AnhKH);
        $updateQuery = "UPDATE khachhang SET 
                        HoTen='$HoTen', 
                        TaiKhoan='$TaiKhoan', 
                        Email='$Email', 
                        DiaChiKH='$DiaChiKH', 
                        DienThoaiKH='$DienThoaiKH', 
                        NgaySinh='$NgaySinh', 
                        GioiTinh='$GioiTinh',
                        AnhKH='$AnhKH' 
                        WHERE MaKH='$MaKH'";
    } else {
        // Không đổi ảnh
        $updateQuery = "UPDATE khachhang SET 
                        HoTen='$HoTen', 
                        TaiKhoan='$TaiKhoan', 
                        Email='$Email', 
                        DiaChiKH='$DiaChiKH', 
                        DienThoaiKH='$DienThoaiKH', 
                        NgaySinh='$NgaySinh', 
                        GioiTinh='$GioiTinh' 
                        WHERE MaKH='$MaKH'";
    }

    $updateResult = mysqli_query($conn, $updateQuery);
    echo $updateResult ? '<script>alert("Cập nhật thông tin người dùng thành công!");</script>'
                       : '<script>alert("Có lỗi khi cập nhật thông tin người dùng!");</script>';
}

// Khóa/Mở khóa người dùng
if (isset($_POST['toggleUser'])) {
    $MaKH = $_POST['MaKH'];

    $checkQuery = "SELECT * FROM khachhang WHERE MaKH = '$MaKH'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $row = mysqli_fetch_array($checkResult);

    if ($row['MatKhau'] === 'locked') {
        $updateQuery = "UPDATE khachhang SET MatKhau = 'active' WHERE MaKH = '$MaKH'";
        $status = 'Hoạt động';
    } else {
        $updateQuery = "UPDATE khachhang SET MatKhau = 'locked' WHERE MaKH = '$MaKH'";
        $status = 'Khoá';
    }

    $updateResult = mysqli_query($conn, $updateQuery);
    echo $updateResult ? '<script>alert("Thay đổi trạng thái người dùng thành công!");</script>'
                       : '<script>alert("Có lỗi khi thay đổi trạng thái người dùng!");</script>';
}

// Xóa người dùng
if (isset($_POST['deletedata'])) {
    $id = $_POST['Xoa_MaKH'];
    $AnhDaiDienCu = $_POST['Xoa_AnhDaiDienCu'];

    $path = "../Images/ImgCustomer/" . $AnhDaiDienCu;
    $deleteQuery = "DELETE FROM khachhang WHERE MaKH = '$id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        if ($AnhDaiDienCu != 'user.png' && file_exists($path)) {
            unlink($path); // Xoá ảnh
        }
        echo '<script>alert("Xóa người dùng thành công!");</script>';
    } else {
        echo '<script>alert("Có lỗi khi xóa người dùng!");</script>';
    }
}
?>
