<?php
$servername = "localhost";
$usename = "root";
$pass = "";
$dbname = "ql_bangiay";
$conn = mysqli_connect($servername, $usename, $pass, $dbname);
 ?>
  <?php  
  $columnHeader = '';  
  $columnHeader = "Thang" . "\t" . "Tong don hang" . "\t" . "Doanh thu" . "\t" . "Tong san pham ban" . "\t";  
  $setData = '';  
  $query_detail = "SELECT  Month(NgayGiao) as 'thang',COUNT(dondathang.SoDH) as 'donhang',Sum(chitietdathang.SoLuong * chitietdathang.DonGia) as 'tienban',SUM(chitietdathang.SoLuong) as 'soluong' FROM chitietdathang join dondathang on dondathang.SoDH = chitietdathang.SoDH WHERE Year(NgayGiao) = year(now()) GROUP BY thang ORDER BY thang;";
  $result_detail = mysqli_query($conn, $query_detail);
  while ($rec = mysqli_fetch_row($result_detail)) {  
      $rowData = '';  
      foreach ($rec as $value) {  
          $value = '"' . $value . '"' . "\t";  
          $rowData .= $value;  
      }  
      $setData .= trim($rowData) . "\n";  
  }  
    
    
  header("Content-type: application/octet-stream");  
  header("Content-Disposition: attachment; filename=thongke.xls");  
  header("Pragma: no-cache");  
  header("Expires: 0");  
    
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
    
  ?>  