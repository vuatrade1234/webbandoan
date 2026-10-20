<?php
require 'connection.php';
session_start();
// hàm mysql_real_escape_string() để loại bỏ những kí tự có thể gây ảnh hưởng đến câu lệnh SQL.
$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$sodt = mysqli_real_escape_string($con, $_POST['sodt']);
$regex_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$/";
// preg_match kiểm tra 1 chuỗi  xem có định dạng đúng với các yêu cầu hay không 
if (!preg_match($regex_email, $email)) {
    echo "Email không chính xác. Đang chuyển hướng bạn trở lại trang đăng ký...";
?>
    <!-- sau 2s chuyển sang trang register.php -->
    <meta http-equiv="refresh" content="2;url=register.php" />
<?php
}
$password = md5(md5(mysqli_real_escape_string($con, $_POST['password'])));
if (strlen($password) < 6) {
    echo "Mật khẩu nên có ít nhất 6 ký tự. Đang chuyển hướng bạn trở lại trang đăng ký...";
?>
    <!-- sau 2s chuyển sang trang register.php -->
    <meta http-equiv="refresh" content="2;url=register.php" />
<?php
}
$duplicate_user_query = "select MaKH from khachhang where Email='$email'";
$duplicate_user_result = mysqli_query($con, $duplicate_user_query) or die(mysqli_error($con));
$rows_fetched = mysqli_num_rows($duplicate_user_result);
$ConfirmPassword = md5(md5(mysqli_real_escape_string($con, $_POST['ConfirmPassword'])));
if ($rows_fetched > 0) {
    //duplicate registration
    //header('location: register.php');
?>
    <script>
        window.alert("Email đã tồn tại trong cơ sở dữ liệu của chúng tôi!");
    </script>
    <meta http-equiv="refresh" content="1;url=register.php" />
    <?php
} else {
    if ($ConfirmPassword != $password) {
        //duplicate registration
        //header('location: register.php');
    ?>
        <script>
            window.alert("Mật khẩu không trùng khớp!");
        </script>
        <meta http-equiv="refresh" content="1;url=register.php" />
    <?php
    } else {
        $hoten = $lastname . " " . $firstname;
        $user_registration_query = "insert into khachhang(hoten,Email,MatKhau,AnhKH,DienThoaiKH) values ('$hoten','$email','$password','user.jpg','$sodt')";
        //die($user_registration_query);
        $user_registration_result = mysqli_query($con, $user_registration_query) or die(mysqli_error($con));
        // echo "User successfully registered";
        $_SESSION['email'] = $email;
        // Hàm mysqli_insert_id() trả về id (được tạo bằng AUTO_INCREMENT) được sử dụng trong truy vấn cuối cùng.
        $_SESSION['MaKH'] = mysqli_insert_id($con);
        header('location: index.php');  //for redirecting
    ?>
        <!-- <meta http-equiv="refresh" content="3;url=index.php" /> -->
<?php
    }
}
?>