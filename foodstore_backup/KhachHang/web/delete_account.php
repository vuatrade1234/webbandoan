<style>
    .mid-grid-left {
        display: none;
    }
</style>
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./css/bootstrap-icons.css">
<?php
include("Layout_KhachHang_Header.php");
?>

<?php
require 'connection.php';
if (!isset($_SESSION['MaKH'])) {
    header('location:index.php');
}
// include("Layout_KhachHang_Header.php");
?>

<?php
$email = $_SESSION['MaKH'];
$query = "SELECT * FROM khachhang WHERE MaKH='$email'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
if (mysqli_num_rows($result) <> 0) {
?>
    <div class="row col-lg-8 border rounded mx-auto mt-3 p-2 shadow-lg">
        <div class="col-md-4 text-center" style="display: block; justify-content: center; margin-top: auto; margin-bottom: auto;">
            <?php
            if (!($row['AnhKH'])) {
            ?>
                <img src="imgKH/user.jpg" class="js-image img-fluid rounded" style="width: 180px;height:180px;object-fit: cover;">
            <?php
            } else {
                $anh = $row['AnhKH'];
                echo "<img src='imgKH/$anh'  class='js-image img-fluid rounded' style='width: 180px;height:180px;object-fit: cover;'>";
            }
            ?>
        </div>
        <div class="col-md-8">
            <div class="h2">Xóa tài khoản</div>

            <div class="alert-danger alert text-center my-2">Bạn có muốn xóa tài khoản không?</div>

            <form method="post" action="delete_account_script.php">

                <table class="table table-striped">
                </table>
                <div class="progress my-3 d-none">

                </div>
                <div class="p-2">
                    <button class="btn btn-danger float-end">Chắc chắn</button>
                    <a href="index.php">
                        <label class="btn btn-secondary">Không muốn</label>
                    </a>
                </div>
            </form>

        </div>
    </div>
<?php } ?>
<?php include("Layout_KhachHang_Footer.php"); ?>
</body>

</html>