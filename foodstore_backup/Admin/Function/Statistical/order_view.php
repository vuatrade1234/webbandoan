<?php
include_once("../../Function/Sup/Success.php");
include_once("../../connect_DB/connect.php");

if (!isset($conn)) {
    die("Không thể kết nối CSDL.");
}

if (!isset($_GET['sodh'])) {
    echo "Thiếu mã đơn hàng!";
    exit;
}

$sodh = $_GET['sodh'];

// Lấy thông tin đơn hàng + khách hàng
$query = "
    SELECT dh.*, kh.HoTen, kh.DienThoaiKH, kh.Email, kh.DiaChiKH, kh.AnhKH
    FROM dondathang dh
    JOIN khachhang kh ON dh.MaKH = kh.MaKH
    WHERE dh.SoDH = '$sodh'
";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Không tìm thấy đơn hàng.";
    exit;
}
$order = mysqli_fetch_assoc($result);

// Lấy chi tiết sản phẩm từ đơn hàng
$details = mysqli_query($conn, "
    SELECT 
        ct.*, 
        g.TenGiay, 
        g.AnhBia, 
        g.GiaBan, 
        ct.Sizegiay AS Size, 
        ct.Maugiay AS Mau
    FROM chitietdathang ct
    JOIN giay g ON ct.MaGiay = g.MaGiay
    WHERE ct.SoDH = '$sodh'
");
if (!$details) {
    die("Lỗi truy vấn chi tiết sản phẩm: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng #<?php echo htmlspecialchars($sodh); ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2>Đơn hàng #<?php echo htmlspecialchars($sodh); ?></h2>

  <!-- Ảnh khách hàng -->
  <?php if (!empty($order['AnhKH'])): ?>
    <img src="../../../KhachHang/web/imgKH/<?php echo htmlspecialchars($order['AnhKH']); ?>" width="100" class="mb-3 rounded shadow">
  <?php endif; ?>

  <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['HoTen']); ?></p>
  <p><strong>Email:</strong> <?php echo htmlspecialchars($order['Email']); ?></p>
  <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['DienThoaiKH']); ?></p>
  <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['DiaChiKH']); ?></p>
  <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['NgayDat']); ?></p>
  <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($order['TinhTrangGiaoHang']); ?></p>

  <h4 class="mt-4">Sản phẩm trong đơn hàng:</h4>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Ảnh</th>
        <th>Tên giày</th>
        <th>Size</th>
        <th>Màu</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $tong = 0;
        while ($row = mysqli_fetch_assoc($details)) {
          $thanhtien = $row['SoLuong'] * $row['GiaBan'];
          $tong += $thanhtien;
      ?>
        <tr>
          <td><img src="../../../Images/ImgProducts/<?php echo htmlspecialchars($row['AnhBia']); ?>" width="80"></td>
          <td><?php echo htmlspecialchars($row['TenGiay']); ?></td>
          <td><?php echo htmlspecialchars($row['Size']); ?></td>
          <td><?php echo htmlspecialchars($row['Mau']); ?></td>
          <td><?php echo number_format($row['GiaBan']); ?>đ</td>
          <td><?php echo $row['SoLuong']; ?></td>
          <td><?php echo number_format($thanhtien); ?>đ</td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="6" class="text-right">Tổng cộng:</th>
        <th><?php echo number_format($tong); ?>đ</th>
      </tr>
    </tfoot>
  </table>

  <!-- Nút quay lại -->
  <?php if (isset($_GET['back'])): ?>
    <a href="<?php echo urldecode($_GET['back']); ?>" class="btn btn-secondary mt-3">⬅️ Quay lại thống kê</a>
<?php else: ?>
    <a href="javascript:history.back()" class="btn btn-secondary mt-3">⬅️ Quay lại</a>
<?php endif; ?>



</body>
</html>
