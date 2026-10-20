<?php
if (isset($_POST["getProSuccess"])) {
    $sodh = $_POST["sodh"];
    $query_run = mysqli_query($conn, "update dondathang set TinhTrangGiaoHang = 'Lấy hàng thành công' where SoDH = '$sodh'");
    if ($query_run) {
        SuccessOder();
    } else {
        echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
    }
}

?>
