
<?php
if (isset($_POST['updatedata'])) {
    $id = $_POST['SoDH'];
    $TinhTrangGiaoHang = $_POST['TinhTrangGiaoHang'];
    if(isset($_POST["diachidangden"])) {
        $diachidangden = $_POST['diachidangden'];
    }
    if(isset($_POST["nhanviengiaohang"])) {
        $nhanviengiaohang = $_POST['nhanviengiaohang'];
    }
    $TinhTrangMoi = $TinhTrangGiaoHang . " ".$diachidangden;
    if($nhanviengiaohang != "") {
        $query = "UPDATE dondathang SET TinhTrangGiaoHang='$TinhTrangMoi',MaNVGH = $nhanviengiaohang WHERE SoDH='$id'  ";
        $query_run = mysqli_query($conn, $query);
    }else {
        $query = "UPDATE dondathang SET TinhTrangGiaoHang='$TinhTrangMoi'  WHERE SoDH='$id'  ";
        $query_run = mysqli_query($conn, $query);
    }
    if ($query_run) {
            Edit();
    } else {
        echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
    }
}
?>

<?php
if(isset($_POST['success']))
{
    $id = $_POST['S_SoDH'];
   
    $query = "UPDATE dondathang SET TinhTrangGiaoHang='Giao hàng thành công',DaThanhToan = true,NgayGiao = now()  WHERE SoDH='$id'  ";
    $query_run = mysqli_query($conn, $query);
    if($query_run)
    {
        Edit();
    }
    else
    {
        echo '<script> alert("Chưa xác nhận"); </script>';
    }
}

?>
