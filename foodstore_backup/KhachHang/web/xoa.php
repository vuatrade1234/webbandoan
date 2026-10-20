<?php
    include("connection.php");
    $id = $_GET["id"];
    $qr ="delete from giohang where id='$id'";
    mysqli_query($con,$qr);
    echo "<script>
    alert('Xoá thanh cong')
    </script>";
    header("location: cart2.php");

?>