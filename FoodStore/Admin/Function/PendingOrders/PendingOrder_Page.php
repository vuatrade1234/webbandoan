<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/PendingOrders/Handle.php");

// ===== BỘ LỌC ĐỎ HÀNG =====
$f_ngay_tu = isset($_GET['f_ngay_tu']) ? $_GET['f_ngay_tu'] : '';
$f_ngay_den= isset($_GET['f_ngay_den'])? $_GET['f_ngay_den']: '';
$f_ten_kh  = isset($_GET['f_ten_kh'])  ? trim(mysqli_real_escape_string($conn, $_GET['f_ten_kh'])) : '';
$f_sodh    = isset($_GET['f_sodh'])    ? (int)$_GET['f_sodh'] : 0;

$where_dh = ["dondathang.TinhTrangGiaoHang = 'Chờ xác nhận'"];
if ($f_ngay_tu  !== '') $where_dh[] = "DATE(dondathang.NgayDat) >= '$f_ngay_tu'";
if ($f_ngay_den !== '') $where_dh[] = "DATE(dondathang.NgayDat) <= '$f_ngay_den'";
if ($f_ten_kh   !== '') $where_dh[] = "KhachHang.HoTen LIKE '%$f_ten_kh%'";
if ($f_sodh     > 0)    $where_dh[] = "dondathang.SoDH = $f_sodh";

$whereSQL_dh = 'WHERE ' . implode(' AND ', $where_dh);

$query = "SELECT *,Sum(chitietdathang.SoLuong) as 'TongSanPham' FROM dondathang join KhachHang on dondathang.MaKH = KhachHang.MaKH join chitietdathang ON chitietdathang.SoDH = dondathang.SoDH $whereSQL_dh GROUP BY dondathang.SoDH ORDER BY dondathang.SoDH DESC";
$query_run = mysqli_query($conn, $query);
$total_all_dh = mysqli_num_rows(mysqli_query($conn, "SELECT SoDH FROM dondathang WHERE TinhTrangGiaoHang = 'Chờ xác nhận'"));
$total_filtered_dh = mysqli_num_rows($query_run);
?>



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<style>
.filter-bar{background:linear-gradient(135deg,#f8f9fa,#e9ecef);border-radius:12px;padding:20px;margin-bottom:16px;border:1px solid #dee2e6;box-shadow:0 2px 8px rgba(0,0,0,.06);}
.filter-bar .filter-title{font-weight:700;font-size:14px;color:#495057;margin-bottom:14px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;}
.filter-bar .form-control{font-size:13px;border-radius:8px;border:1px solid #ced4da;}
.filter-bar .form-control:focus{border-color:#fd7e14;box-shadow:0 0 0 3px rgba(253,126,20,.12);}
.filter-badge{display:inline-flex;align-items:center;background:#fd7e14;color:#fff;border-radius:20px;padding:2px 10px;font-size:12px;}
.filtered-count{font-size:13px;color:#6c757d;}
</style>

<div class="container-fluid ">

    <div class="card p-3">
        <h1 class="font-weight-bold text-center"> ĐƠN ĐẶT HÀNG CHỜ XÁC NHẬN</h1>
    </div>

    <!-- FILTER BAR ĐƠN HÀNG -->
    <div class="filter-bar">
        <div class="filter-title">
            <i class="bi bi-funnel-fill text-warning"></i> Bộ lọc đơn hàng
            <?php if(count($where_dh)>1): ?><span class="filter-badge"><?= count($where_dh)-1 ?> bộ lọc đang áp dụng</span><?php endif; ?>
            <span class="filtered-count">Hiển thị <strong><?= $total_filtered_dh ?></strong> / <?= $total_all_dh ?> đơn hàng</span>
        </div>
        <form method="GET" action="">
            <input type="hidden" name="thamso" value="hangchoxacnhan">
            <div class="row g-2">
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">📅 Từ ngày</label>
                    <input type="date" name="f_ngay_tu" class="form-control" value="<?= htmlspecialchars($f_ngay_tu) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">📅 Đến ngày</label>
                    <input type="date" name="f_ngay_den" class="form-control" value="<?= htmlspecialchars($f_ngay_den) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">👤 Tên khách hàng</label>
                    <input type="text" name="f_ten_kh" class="form-control" placeholder="Tìm theo tên..." value="<?= htmlspecialchars($f_ten_kh) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">🔢 Số đơn hàng</label>
                    <input type="number" name="f_sodh" class="form-control" placeholder="VD: 76" value="<?= $f_sodh ?: '' ?>" min="1">
                </div>
                <div class="col-md-3 d-flex flex-column justify-content-end gap-1">
                    <button type="submit" class="btn btn-warning" style="border-radius:8px;font-size:13px;color:#fff;"><i class="bi bi-search"></i> Lọc</button>
                    <a href="?thamso=hangchoxacnhan" class="btn btn-outline-secondary" style="border-radius:8px;font-size:13px;"><i class="bi bi-x-circle"></i> Xoá lọc</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <?php
            $index = 1;
            ?>
            <table id="data-table" class="table table-bordered table-secondary table-hover display">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Số đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Số sản phẩm</th>
                        <th>Ngày đặt</th>
                        <th>Địa chỉ giao</th>
                        <th>Điện thoại</th>
                        <th>Tình trạng</th>
                        <th>Chức năng </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td> <?php echo $index;
                                        $index++; ?></td>
                                <td> <?php echo $row['SoDH']; ?></td>
                                <td> <?php echo $row['HoTen']; ?> </td>
                                <td> <?php echo $row['TongSanPham']; ?> </td>
                                <td> <?php echo $row['NgayDat']; ?> </td>
                                <td> <?php echo $row['DiaChiGiaoHang']; ?> </td>
                                <td> <?php echo $row['DienThoaiKH']; ?> </td>
                                <td> <?php echo $row['TinhTrangGiaoHang']; ?> </td>


                                <td>
                                    <!-- DETAIL  -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['SoDH']; ?>">
                                        Chi tiết
                                    </button>
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['SoDH']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="LabelModal">Chi tiết</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">

                                                    <?php $query_run_chitiet = mysqli_query($conn, "SELECT * FROM chitietdathang JOIN dondathang ON chitietdathang.SoDH = dondathang.SoDH JOIN sanpham ON chitietdathang.MaSP = sanpham.MaSP WHERE chitietdathang.SoDH = '$row[SoDH]'"); ?>
                                                    <table class="table table-bordered table-secondary table-hover display text-center">
                                                        <thead class="thead-dark">
                                                            <th>#</th>
                                                            <th>Số đơn hàng</th>
                                                            <th>Mã món ăn</th>
                                                            <th>Tên món ăn</th>
                                                            <th>Quy cách</th>
                                                            <th>Hương vị</th>
                                                            <th>Số lượng</th>
                                                            <th>Đơn giá</th>
                                                            <th>Tổng tiền</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $index1 = 1;
                                                            ?>
                                                            <?php if (mysqli_num_rows($query_run_chitiet) != 0) {
                                                                while ($r = mysqli_fetch_array($query_run_chitiet)) { ?>
                                                                    <tr>
                                                                        <td> <?php echo $index1;
                                                                                $index1++; ?></td>
                                                                        <td><?php echo $r["SoDH"] ?></td>
                                                                        <td><?php echo $r["MaSP"] ?></td>
                                                                        <td><?php echo $r["TenSP"] ?></td>
                                                                        <td><?php echo $r["QuyCach"] ?></td>
                                                                        <td><?php echo $r["ViHuong"] ?></td>
                                                                        <td><?php echo $r["SoLuong"] ?></td>
                                                                        <td><?php echo number_format($r["DonGia"], 0, ',', '.'); ?></td>
                                                                        <td><?php echo number_format($r["SoLuong"] * $r["DonGia"], 0, ',', '.'); ?></td>

                                                                    </tr>

                                                            <?php  }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php $qr_tongtien = mysqli_query($conn, "select *,sum(SoLuong * DonGia) as 'tong' from chitietdathang where SoDH = '$row[SoDH]'");

                                                    $row_tongtien = mysqli_fetch_array($qr_tongtien);
                                                    ?>

                                                    <p style="font-size:20px ;" class="text-end">Tổng tiền: <strong class="text-primary"><?php echo number_format($row_tongtien["tong"], 0, ',', '.'); ?></strong> đồng</p>



                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>

                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- END-DETAIL  -->
                                    <form  method="post">
                                        <input type="hidden" name="sodh" value="<?php echo $row["SoDH"] ?>">
                                         <button type="submit" name="getProSuccess" class="btn btn-danger btn-sm">
                                        Xác nhận
                                    </button>
                                    </form>
                                 

                                    <!-- EDIT  -->



                                    <!-- END-DELETE  -->

                                </td>
                              
                            </tr>

                    <?php  }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>



</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            language: {
                lengthMenu: 'Hiển thị _MENU_ trường một trang',
                zeroRecords: 'Không tìm thấy dữ liệu !',
                info: 'Đang hiển thị trang _PAGE_ / _PAGES_',
                infoEmpty: 'Không có bản ghi nào',
                infoFiltered: '(được lọc từ _MAX_ bản ghi)',
                "search": "Tìm kiếm:",
                searchPlaceholder: "Nhập từ khoá !",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước"
                },
            },
        });
    });
</script>





<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>
