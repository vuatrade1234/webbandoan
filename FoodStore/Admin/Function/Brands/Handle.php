<?php
if (isset($_POST['updatedata'])) {
    $id = $_POST['MaTH'];
    $TenTH = $_POST['TenTH'];
    $query = "UPDATE ThuongHieu SET TenTH='$TenTH'  WHERE MaTH='$id'  ";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
            Edit();
    } else {
        echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
    }
}
?>

<?php
if (isset($_POST['deletedata'])) {
    $id = (int) $_POST['D_MaTH'];
   
    // Cập nhật các món ăn của thương hiệu này về không có thương hiệu (NULL)
    mysqli_query($conn, "UPDATE sanpham SET MaTH = NULL WHERE MaTH = '$id'");
    $query1 = "DELETE FROM ThuongHieu WHERE MaTH = '$id'";
    $query_run1 = mysqli_query($conn, $query1);
    if ($query_run1) {
        Delete();
    } else {
        echo '<script> alert("Chưa xoá được thương hiệu"); </script>';
    }
}

?>
<?php


if(isset($_POST['insertdata']))
{   
    
    $I_TenTH = $_POST['I_TenTH'];
    $query = "insert into thuonghieu values (null,'$I_TenTH')";
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
