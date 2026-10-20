<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['MaKH'])) {
    header('location:index.php');
}
$old_password = md5(md5(mysqli_real_escape_string($con, $_POST['oldPassword'])));
$new_password = md5(md5(mysqli_real_escape_string($con, $_POST['newPassword'])));
$retype_Password = md5(md5(mysqli_real_escape_string($con, $_POST['retypePassword'])));
$email = $_SESSION['MaKH'];
//echo $email;
$password_from_database_query = "select MatKhau from khachhang where MaKH='$email'";
$password_from_database_result = mysqli_query($con, $password_from_database_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($password_from_database_result);
//echo $row['MatKhau'];
if ($row['MatKhau'] == $old_password) {
    if ($retype_Password != $new_password) {
        //duplicate registration
        //header('location: changepwd.php');
?>
        <script>
            window.alert("Mật khẩu không trùng khớp!");
        </script>
        <meta http-equiv="refresh" content="1;url=changepwd.php" />
    <?php
    } else {
        $update_password_query = "update khachhang set MatKhau='$new_password' where MaKH='$email'";
        $update_password_result = mysqli_query($con, $update_password_query) or die(mysqli_error($con));
        // echo "Your password has been updated.";
    ?>
        <script>
            window.alert("Mật khẩu của bạn đã được cập nhật!");
        </script>
        <meta http-equiv="refresh" content="1;url=index.php" />
    <?php
    }
} else {
    ?>
    <script>
        window.alert("Sai mật khẩu!");
    </script>
    <meta http-equiv="refresh" content="1;url=changepwd.php" />
<?php
    //header('location:changepwd.php');
}
?>