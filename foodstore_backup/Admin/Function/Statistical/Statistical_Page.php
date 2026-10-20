<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Statistical/Handle.php");
include_once './Connect_DB/connect.php';
include_once './Connect_DB/connect_ex.php';

// Xử lý dữ liệu cho biểu đồ và modal
$thongke_query = "
  SELECT 
    DATE_FORMAT(dh.NgayDat, '%Y-%m') AS thang,
    COUNT(DISTINCT dh.SoDH) AS donhang,
    SUM(ct.SoLuong * ct.DonGia) AS tienban,
    SUM(ct.SoLuong) AS soluong
  FROM dondathang dh
  JOIN chitietdathang ct ON dh.SoDH = ct.SoDH
  GROUP BY thang
  ORDER BY thang ASC
";

$thongke_result = mysqli_query($conn, $thongke_query);

$chart_array = [];
$result_detail = [];

if ($thongke_result && mysqli_num_rows($thongke_result) > 0) {
  while ($row = mysqli_fetch_assoc($thongke_result)) {
    $chart_array[] = [
      'thang' => $row['thang'],
      'doanhthu' => $row['tienban']
    ];
    $result_detail[] = $row;
  }
}

$chart_data = json_encode($chart_array);
?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
  <h1>Thống kê</h1>

  <!-- Form lọc thời gian cho Top 5 khách hàng -->
  <form method="POST" action="">
    <div class="row mb-3">
      <div class="col-md-3">
        <label>Từ ngày:</label>
        <input type="date" name="from_date" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label>Đến ngày:</label>
        <input type="date" name="to_date" class="form-control" required>
      </div>
      <div class="col-md-2 align-self-end">
        <button type="submit" name="filter_top5" class="btn btn-primary">Thống kê Top 5 KH</button>
      </div>
    </div>
  </form>

  <?php
  if (isset($_POST['filter_top5'])) {
    $from = $_POST['from_date'];
    $to = $_POST['to_date'];

    $query = "
      SELECT kh.MaKH, kh.HoTen, SUM(ct.SoLuong * ct.DonGia) AS tong_mua
      FROM dondathang dh
      JOIN khachhang kh ON dh.MaKH = kh.MaKH
      JOIN chitietdathang ct ON dh.SoDH = ct.SoDH
      WHERE dh.NgayDat BETWEEN '$from' AND '$to'
      GROUP BY kh.MaKH
      ORDER BY tong_mua DESC
      LIMIT 5
    ";

    $result = mysqli_query($conn, $query);
    if (!$result) {
      die("Lỗi truy vấn SQL (Top 5 KH): " . mysqli_error($conn));
    }

    echo "<h3 class='mt-4'>Top 5 khách hàng từ $from đến $to</h3>";

    $current_url = urlencode($_SERVER['REQUEST_URI']);

    while ($row = mysqli_fetch_assoc($result)) {
      echo "<div class='card mb-3'><div class='card-body'>";
      echo "<h5 class='card-title'>" . htmlspecialchars($row['HoTen']) . " - Tổng mua: " . number_format($row['tong_mua']) . "đ</h5>";

      $makh = $row['MaKH'];

      $donhang = mysqli_query($conn, "
        SELECT dh.SoDH, dh.NgayDat, SUM(ct.SoLuong * ct.DonGia) AS tongdon
        FROM dondathang dh
        JOIN chitietdathang ct ON dh.SoDH = ct.SoDH
        WHERE dh.MaKH = '$makh' AND dh.NgayDat BETWEEN '$from' AND '$to'
        GROUP BY dh.SoDH
      ");

      if (!$donhang) {
        die("Lỗi truy vấn SQL (Đơn hàng KH): " . mysqli_error($conn));
      }

      echo "<ul>";
      while ($dh = mysqli_fetch_assoc($donhang)) {
        $sodh = htmlspecialchars($dh['SoDH']);
        $ngaydat = htmlspecialchars($dh['NgayDat']);
        $tongdon = number_format($dh['tongdon']) . "đ";
        echo "<li>Đơn hàng #$sodh - $tongdon - $ngaydat 
              <a href=\"./Function/Statistical/order_view.php?sodh=$sodh&back=$current_url\" 
                 target=\"_blank\" class=\"ms-2\">Xem chi tiết</a></li>";
      }
      echo "</ul></div></div>";
    }
  }
  ?>

  <!-- BIỂU ĐỒ + MODAL -->
  <div class="container-fluid">
    <div id="chart-container">
      <canvas id="myHorizontalBarChart" width="400" height="300"></canvas>
    </div>

    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#ModalDelete">
      Chi tiết
    </button>

    <!-- Modal chi tiết -->
    <div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="Label_Edit">Chi tiết</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table id="data-table1" class="table table-bordered table-secondary table-hover display">
              <thead class="thead-dark">
                <tr>
                  <th>Tháng</th>
                  <th>Tổng đơn hàng</th>
                  <th>Doanh thu</th>
                  <th>Tổng sản phẩm bán</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($result_detail)) {
                  foreach ($result_detail as $row) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row["thang"]) ?></td>
                      <td><?php echo htmlspecialchars($row["donhang"]) ?></td>
                      <td><?php echo number_format($row["tienban"], 0, ',', '.'); ?> đồng</td>
                      <td><?php echo htmlspecialchars($row["soluong"]) ?></td>
                    </tr>
                  <?php }
                } else {
                  echo "<tr><td colspan='4'>Chưa có dữ liệu chi tiết.</td></tr>";
                } ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <a class="btn btn-secondary" href="./Function/Statistical/excel.php">Xuất Excel</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script Chart.js -->
<script>
  const chartDataRaw = <?php echo $chart_data; ?>;
  const labels = chartDataRaw.map(item => item.thang);
  const data = chartDataRaw.map(item => item.doanhthu);

  const ctx = document.getElementById('myHorizontalBarChart').getContext('2d');
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Doanh thu',
        data: data,
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Biểu đồ doanh thu theo tháng'
        }
      },
      scales: {
        x: {
          beginAtZero: true
        }
      }
    }
  });

  // Ẩn biểu đồ khi mở modal
  $('#ModalDelete').on('shown.bs.modal', function () {
    $('#chart-container').hide();
  });

  // Hiện lại khi đóng modal
  $('#ModalDelete').on('hidden.bs.modal', function () {
    $('#chart-container').show();
  });
</script>

<!-- Style -->
<style>
  #data-table1 thead th {
    background: black;
    color: #fff;
  }
</style>
