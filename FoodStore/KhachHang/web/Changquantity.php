<?php

$id = "";
$soluong = "";
if (isset($_POST['tru'])) {
  if (isset($_POST['maId'])) {
    $id = $_POST['maId'];
  }
  if (isset($_POST['soluong'])) {
    $soluong = $_POST['soluong'];
  }

  $soluong = $soluong - 1;
  $update = "UPDATE `giohang` SET `soluong` = '$soluong' WHERE `giohang`.`id` = '$id';";
  mysqli_query($con, $update);
} else {
  if (isset($_POST['cong'])) {
    if (isset($_POST['maId'])) {
      $id = $_POST['maId'];
    }
    if (isset($_POST['soluong'])) {
      $soluong = $_POST['soluong'];
    }
    $soluong = $soluong + 1;
    $update = "UPDATE `giohang` SET `soluong` = '$soluong' WHERE `giohang`.`id` = '$id';";
    mysqli_query($con, $update);
  }
}
if ($soluong <= 0) {
  $qr = "delete from giohang where id='$id'";
  mysqli_query($con, $qr);
}
