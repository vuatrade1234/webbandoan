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

if (!isset($_SESSION['MaKH'])) {
    header('location:index.php');
}

?>


< <?php

    $email = $_SESSION['MaKH'];
    $query = "SELECT * FROM khachhang WHERE MaKH='$email'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) <> 0) {
    ?> <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg">
    <div class="col-md-4 text-center" style="display: block; justify-content: center; margin-top: auto; margin-bottom: auto;">
        <?php
        if (!($row['AnhKH'])) {
        ?>
            <img src="imgKH/user.jpg" class="img-fluid rounded" style="width: 180px;height:180px;object-fit: cover;">
        <?php
        } else {
            $anh = $row['AnhKH'];
            echo "<img src='imgKH/$anh'  class='img-fluid rounded' style='width: 180px;height:180px;object-fit: cover;'>";
        }
        ?>
        <div>
            <a href="index.php">
                <button class="mx-auto m-1 btn-sm btn btn-warning text-white">Về trang chủ</button>
            </a>
        </div>
    </div>
<?php
    }
?>
<div class="col-md-8">

    <div class="h2" style="font-weight: bold;">Đổi mật khẩu</div>

    <form method="post" action="changepwd_script.php">
        <table class="table table-striped">
            <tr>
                <th> Mật khẩu cũ</th>
                <td>
                    <input type="password" name="oldPassword" class="form-control" pattern=".{6,}" required>
                </td>
            </tr>
            <tr>
                <th> Mật khẩu mới</th>
                <td>
                    <input type="password" name="newPassword" class="form-control" pattern=".{6,}" required>
                </td>
            </tr>
            <tr>
                <th> Nhập lại mật khẩu mới</th>
                <td>
                    <input type="password" name="retypePassword" class="form-control" pattern=".{6,}" required>
                </td>
            </tr>

        </table>

        <div class="p-2">
            <a href="changepwd_script.php">
                <button class="btn btn-primary float-end">Lưu</button>
            </a>
        </div>
    </form>

</div>
</div>
<div>
    <br><br><br><br><br>
    <?php include("Layout_KhachHang_Footer.php"); ?>
</div>
</body>

</html>

<style>
    /* Nút Dropdown*/
    .nut_dropdown {
        background: black;
        color: white;

        font-size: 16px;
        border: none;
    }

    /* Thiết lập vị trí cho thẻ div với class dropdown*/
    .dropdown {
        position: absolute;
        display: inline-block;
        z-index: 100000;
    }

    /* Nội dung Dropdown */
    .noidung_dropdown {
        /*Ẩn nội dụng các đường dẫn*/
        display: none;
        position: absolute;
        color: black;
        background: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);


    }


    /* Thiết kế style cho các đường dẫn tronng Dropdown */
    .noidung_dropdown a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;

    }

    /* thay đổi màu background khi hover vào đường dẫn */
    .noidung_dropdown a:hover {
        background-color: #ddd;

    }

    /* hiển thị nội dung dropdown khi hover */

    /* Thay đổi màu background cho nút khi được hover */
    .dropdown:hover .noidung_dropdown {
        display: block;
        z-index: 1000000000000;
    }

    /*Dùng Để hiển thị nội dung*/
    .hienThi {
        display: block;
    }

    .o {

        top: 12px;
        position: absolute;
        right: 230px;
    }

    .o img {
        width: 20px;
        height: 20px;
        border-radius: 50%;

    }
</style>