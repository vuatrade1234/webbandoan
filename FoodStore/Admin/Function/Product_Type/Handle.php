<?php
if (isset($_POST['suadulieu'])) {
    $id = $_POST['Sua_MaLSP'];
    $TenLoaiSP = $_POST['Sua_TenLoaiSP'];
    $query = "UPDATE loaisanpham SET TenLoaiSP='$TenLoaiSP'  WHERE MaLSP='$id'  ";
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
    $id = $_POST['Xoa_MaLSP'];
   
    $query = "DELETE FROM sanpham WHERE MaLSP='$id'";
    $query1=  "DELETE FROM loaisanpham WHERE MaLSP='$id'";
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
    
    $Them_TenLoaiSP= $_POST['Them_TenLoaiSP'];
    $query = "insert into loaisanpham values (null,'$Them_TenLoaiSP')";
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
