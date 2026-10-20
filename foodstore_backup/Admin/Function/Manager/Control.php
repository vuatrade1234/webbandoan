<?php
    if(!isset($_GET['thamso'])){$thamso="";}else{$thamso=$_GET['thamso'];}
    switch($thamso)
	{
		case "baitap":
            include("./Function/ThucHanh/ExerciseLink/Exercise_1.php");    
		break;
		case "baitapp2":
            include("./Function/ThucHanh/ExerciseLink/Exercise_2.php");    
		break;
		case "baitapp3":
            include("./Function/ThucHanh/ExerciseLink/Exercise_3.php");    
		break;
		case "thongtincanhan":
            include("./Function/Profile/Profile_Page.php");     
		break;
		case "thuonghieu":
            include("./Function/Brands/Brands_Page.php"); 
		break;
		case "sanpham":
            include("./Function/Products/Products_Page.php");     
		break;
		case "loaigiay":
            include("./Function/Product_Type/Product_Type_Page.php");     
		break;
		case "quantrivien":
            include("./Function/Staffs/Staff_Page.php");     
		break;
		case "nhacungcap":
            include("./Function/Suppliers/Suppliers_Page.php");     
		break;
		case "nhanviengiaohang":
            include("./Function/Livraisons/Livraison_Page.php");     
		break;
		case "hangchoxacnhan":
            include("./Function/PendingOrders/PendingOrder_Page.php");     
		break;
		case "hangdangxuli":
            include("./Function/ProcessingOrders/ProcessingOrder_Page.php");     
		break;
		case "giaohangthanhcong":
            include("./Function/ProcessedOrders/ProcessedOrder_Page.php");     
		break;
		case "thongke":
            include("./Function/Statistical/Statistical_Page.php");     
		break;
		case "khachhang":
            include("./Function/Customer/admin_khachhang.php");     
		break;
		default:
			include("./Function/Manager/Members.php");  
		
	}
?>
