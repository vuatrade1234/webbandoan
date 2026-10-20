<?php
if (isset($_POST['suadulieu'])) {
    $id = $_POST['Sua_MaNCC'];
    $TenNCC = $_POST['Sua_TenNCC'];
    $SDT = $_POST['Sua_DienThoaiNCC'];
    $DiaChi = $_POST['Sua_DiaChiNCC'];

    $query = "UPDATE nhacungcap SET TenNCC='$TenNCC', DienThoaiNCC='$SDT', DiaChiNCC='$DiaChi'  WHERE MaNCC='$id'  ";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
            Edit();
    } else {
        echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
    }
}
?>

<?php
if(isset($_POST['xoadulieu']))
{
    $id = $_POST['Xoa_MaNCC'];
   
    $query = "DELETE FROM Giay WHERE MaNCC='$id'";
    $query1=  "DELETE FROM nhacungcap WHERE MaNCC='$id'";
    $query_run = mysqli_query($conn, $query);
    $query_run1 = mysqli_query($conn, $query1);
    if($query_run and $query_run1)
    {
        Delete();
    }
    else
    {
        echo '<script> alert("Chưa xoá"); </script>';
    }
}

?>
<?php


if(isset($_POST['themdulieu']))
{   
    
    $Them_TenNCC= $_POST['Them_TenNCC'];
    $Them_SDTNCC= $_POST['Them_SDT'];
    $Them_DiaChiNCC= $_POST['Them_DiaChi'];
    $query = "insert into nhacungcap values (null,'$Them_TenNCC','$Them_SDTNCC','$Them_DiaChiNCC')";
    $query_run = mysqli_query($conn, $query);
    if($query_run)
    {
        Add();     
    }
    else
    {
        echo '<script> alert("Dữ liệu chưa được thêm"); </script>';
    }
}
?>
