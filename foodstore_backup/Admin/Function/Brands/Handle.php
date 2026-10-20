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
if(isset($_POST['deletedata']))
{
    $id = $_POST['D_MaTH'];
   
    $query = "DELETE FROM Giay WHERE MaTH='$id'";
    $query1=  "DELETE FROM ThuongHieu WHERE MaTH='$id'";
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
