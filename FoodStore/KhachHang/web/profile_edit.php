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
    header('location: index.php');
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
    <form method="post" action="profile_edit_script.php" enctype="multipart/form-data">
        <div class="row col-lg-8 border rounded mx-auto mt-3 p-2 shadow-lg">
            <div class="col-md-4 text-center" style="display: block; justify-content: center; margin-top: auto; margin-bottom: auto;">
                <?php

                $anh = $row['AnhKH'];
                echo "<img src='imgKH/$anh'  class='js-image img-fluid rounded' style='width: 180px;height:180px;object-fit: cover;'>";

                ?>
                <input type="hidden" name="anhcu" value="<?php echo $row['AnhKH'] ?>">
                <div>
                    <!-- <div class="mb-3">
					  <label for="formFile" class="form-label" style="font-style: italic; font-size: 12px;">(Nhấn bên dưới để chọn ảnh từ thư viện)</label>
					  <input onchange="display_image(this.files[0])" class="js-image-input form-control" type="file" id="formFile" name="anhkh">
					</div> -->
                </div>
            </div>
            <div class="col-md-8">

                <div class="h2" style="font-weight: bold;">CHỈNH SỬA THÔNG TIN</div>


                <table class="table table-striped">
                    <tr>
                        <th style="font-weight: bold;"> Họ tên</th>
                        <td>
                            <input value="<?php if (isset($row['HoTen'])) echo $row['HoTen']; ?>" type="text" class="form-control" name="hoten">
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Tên tài khoản</th>
                        <td>
                            <input value="<?php if (isset($row['TaiKhoan'])) echo $row['TaiKhoan']; ?>" type="text" class="form-control" name="taikhoan">
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Email</th>
                        <td>
                            <input value="<?php if (isset($row['Email'])) echo $row['Email']; ?>" type="text" class="form-control" name="email" style="background-color: #dedeed;" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Địa chỉ</th>
                        <td>
                            <input value="<?php if (isset($row['DiaChiKH'])) echo $row['DiaChiKH']; ?>" type="text" class="form-control" name="diachikh">
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Điện thoại</th>
                        <td>
                            <input value="<?php if (isset($row['DienThoaiKH'])) echo $row['DienThoaiKH']; ?>" type="text" class="form-control" name="dienthoaikh">
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Ngày sinh</th>
                        <td>
                            <input value="<?php if (isset($row['NgaySinh'])) echo $row['NgaySinh']; ?>" type="date" class="form-control" name="ngaysinh">
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Giới tính</th>
                        <td>
                            <select name="gioitinh" class="form-select form-select mb-3" aria-label=".form-select-lg example">
                                <?php if ($row['GioiTinh'] == 1) { ?>
                                    <option value="1">Nam</option>
                                    <option value="0">Nữ</option>
                                <?php
                                }
                                if ($row['GioiTinh'] == 0) { ?>
                                    <option value="0">Nữ</option>
                                    <option value="1">Nam</option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold;"> Ảnh đại diện</th>
                        <td>
                            <input type="file" onchange="display_image(this.files[0])" class="js-image-input form-control" id="formFile" name="anhkh" value="<? if ($row['AnhKH']) echo ($row['AnhKH']); ?>">
                        </td>
                    </tr>
                </table>
            <?php
        }
            ?>
            <div class="p-2">

                <a href="profile_edit_script.php">
                    <button class="btn btn-primary float-end">Lưu</button>
                </a>

                <a href="delete_account.php">
                    <label class="btn btn-danger float-end" style="margin-right: 10px;">Xóa tài khoản</label>
                </a>

                <a href="javascript:window.history.back(-1);">
                    <label class="btn btn-secondary">Thoát</label>
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
    <script>
        var image_added = false;

        function display_image(file) {
            var img = document.querySelector(".js-image");
            img.src = URL.createObjectURL(file);

            image_added = true;
        }
    </script>

    <style>
        .login-box {
            padding: 0;
            min-height: 700px;
        }

        .login-main h1 {
            color: #08080b;
            font-weight: 700;
            font-size: 1.2em;
            padding: 1em 0;
        }

        .login-main {
            border-top: 1px solid #eee;
        }

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