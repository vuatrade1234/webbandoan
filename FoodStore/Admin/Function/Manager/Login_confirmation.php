<?php 
	    include("Check_login.php");
?>

<?php   
	if(isset($_POST['login_admin']))
	{
		$tai_khoan=$_POST['TaiKhoan'];
		$mat_khau = $_POST['MatKhau'];	
        $truyvan = "select * from quantrivien where TaiKhoan = '$tai_khoan'";
        $ketqua = mysqli_query($conn, $truyvan);
        if (mysqli_num_rows($ketqua) == 0) {
			$loi =  "Tài khoản không tồn tại !";
        }
        else {
            $each = mysqli_fetch_array($ketqua);
            if(password_verify($mat_khau,$each["MatKhau"])) {
				$_SESSION["MaQTV"] = $each["MaQTV"];
                $_SESSION["TaiKhoan"] = "$tai_khoan";
                $_SESSION["QuanLi"] = $each["QuanLi"];


            }
            else {
                $loi =  "Mật khẩu không đúng !";
            }

        }
	}

    if(isset($_SESSION['TaiKhoan']))
	{
		$tk=$_SESSION['TaiKhoan'];
		$tv="select count(*) from quantrivien  where TaiKhoan='$tk' ";
		$tv_1=mysqli_query($conn,$tv);
		$tv_2=mysqli_fetch_array($tv_1);
		if($tv_2[0]==1)
		{
			$xac_dinh_dang_nhap="co";
		}
	}

?>