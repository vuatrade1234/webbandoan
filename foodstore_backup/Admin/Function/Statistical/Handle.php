<?php 
//index.php
$query = "SELECT  Month(NgayGiao) as 'thang',Sum(chitietdathang.SoLuong * chitietdathang.DonGia) as 'tienban' FROM chitietdathang join dondathang on dondathang.SoDH = chitietdathang.SoDH WHERE Year(NgayGiao) = year(now()) GROUP BY thang ORDER BY thang;";
$result = mysqli_query($conn, $query);
$query_detail = "SELECT  Month(NgayGiao) as 'thang',Sum(chitietdathang.SoLuong * chitietdathang.DonGia) as 'tienban',COUNT(dondathang.SoDH) as 'donhang',SUM(chitietdathang.SoLuong) as 'soluong' FROM chitietdathang join dondathang on dondathang.SoDH = chitietdathang.SoDH WHERE Year(NgayGiao) = year(now()) GROUP BY thang ORDER BY thang;";
$result_detail = mysqli_query($conn, $query_detail);
$chart_data ="";
while($row = mysqli_fetch_array($result))
{
 $chart_data .= "{ thang:'"."Tháng "  .$row["thang"]."', doanhthu:".$row["tienban"]."}, ";

}
?>

<!-- SELECT chitietdathang.MaGiay,SUM(chitietdathang.SoLuong),month(dondathang.NgayGiao) as 'month' 
FROM chitietdathang join dondathang on dondathang.SoDH = chitietdathang.SoDH
  GROUP BY month,chitietdathang.MaGiay -->
