<?php
require 'connection.php';
session_start();
$email = mysqli_real_escape_string($con, $_POST['email']);
$regex_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$/";
if (!preg_match($regex_email, $email)) {
    echo "Email không chính xác. Đang chuyển hướng bạn trở lại trang đăng nhập...";
?>
    <meta http-equiv="refresh" content="2;url=login.php" />
<?php
}
$password = mysqli_real_escape_string($con, $_POST['password']);
if (strlen($password) < 6) {
    echo "Mật khẩu nên có ít nhất 6 ký tự. Đang chuyển hướng bạn trở lại trang đăng nhập...";
?>
    <meta http-equiv="refresh" content="2;url=login.php" />
<?php
}
$user_authentication_query = "select * from khachhang where Email='$email' and MatKhau='$password'";
$user_authentication_result = mysqli_query($con, $user_authentication_query) or die(mysqli_error($con));
$rows_fetched = mysqli_num_rows($user_authentication_result);
if ($rows_fetched == 0) {
    //no user
    //redirecting to same login page
?>
    <script>
        window.alert("Tên người dùng hoặc mật khẩu sai. Đang chuyển hướng bạn trở lại trang đăng nhập...");
    </script>
    <meta http-equiv="refresh" content="1;url=login.php" />
<?php
    //header('location: login');
    //echo "Wrong email or password.";
} else {
    $row = mysqli_fetch_array($user_authentication_result);
    $_SESSION['MaKH'] = $row['MaKH'];  //cus id
    header('location: index.php');
}

?>