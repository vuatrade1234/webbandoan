
<?php
if(isset($_POST['deletedata']))

{



    $id = $_POST['D_SoDH'];
    echo $id;
    $query = "DELETE FROM chitietdathang WHERE SoDH='$id'";
    $query1=  "DELETE FROM dondathang WHERE SoDH='$id'";
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
