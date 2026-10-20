<?php
include("Check_login.php");
?>
<?php
	if(!isset($_GET['thamso'])){$thamso="";}else{$thamso=$_GET['thamso'];}
    if (isset($_GET['thamso'])) {
    if ($_GET['thamso'] == "thoat") {
	   unset($_SESSION['TaiKhoan']);
       header("Location:  ./");
      
    }
}
?>



