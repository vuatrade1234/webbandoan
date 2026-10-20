<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include_once './Connect_DB/connect.php';

// ===== BO LOC PHIEU NHAP =====
$f_ngay_tu_pn = isset($_GET['f_ngay_tu_pn']) ? $_GET['f_ngay_tu_pn'] : '';
$f_ngay_den_pn= isset($_GET['f_ngay_den_pn'])? $_GET['f_ngay_den_pn']: '';
$f_ncc_pn     = isset($_GET['f_ncc_pn'])     ? (int)$_GET['f_ncc_pn']     : 0;
$f_mahn_pn    = isset($_GET['f_mahn_pn'])    ? (int)$_GET['f_mahn_pn']    : 0;

$where_pn = [];
if ($f_ngay_tu_pn  !== '') $where_pn[] = "DATE(pn.NgayNhap) >= '$f_ngay_tu_pn'";
if ($f_ngay_den_pn !== '') $where_pn[] = "DATE(pn.NgayNhap) <= '$f_ngay_den_pn'";
if ($f_ncc_pn      > 0)   $where_pn[] = "pn.MaNCC = $f_ncc_pn";
if ($f_mahn_pn     > 0)   $where_pn[] = "pn.MaPN = $f_mahn_pn";

$whereSQL_pn = count($where_pn) ? 'WHERE ' . implode(' AND ', $where_pn) : '';

$query_pn = "SELECT pn.*, ncc.TenNCC, qtv.HoTen AS TenNV,
              COALESCE(SUM(ctpn.ThanhTien), pn.TongTien) AS TongTienThucTe,
              COUNT(DISTINCT ctpn.MaSP) AS SoLoaiSP,
              SUM(ctpn.SoLuongNhap) AS TongSoLuong
             FROM phieunhap pn
             LEFT JOIN nhacungcap ncc ON pn.MaNCC = ncc.MaNCC
             LEFT JOIN quantrivien qtv ON pn.MaQTV = qtv.MaQTV
             LEFT JOIN chitietphieunhap ctpn ON pn.MaPN = ctpn.MaPN
             $whereSQL_pn
             GROUP BY pn.MaPN
             ORDER BY pn.MaPN DESC";
$query_run_pn = mysqli_query($conn, $query_pn);
$total_all_pn = mysqli_num_rows(mysqli_query($conn, "SELECT MaPN FROM phieunhap"));
$total_filtered_pn = mysqli_num_rows($query_run_pn);
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<style>
.filter-bar{background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:12px;padding:20px;margin-bottom:16px;border:1px solid #86efac;box-shadow:0 2px 8px rgba(0,0,0,.06);}
.filter-bar .filter-title{font-weight:700;font-size:14px;color:#166534;margin-bottom:14px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;}
.filter-bar .form-select,.filter-bar .form-control{font-size:13px;border-radius:8px;border:1px solid #86efac;}
.filter-bar .form-select:focus,.filter-bar .form-control:focus{border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.15);}
.filter-badge{display:inline-flex;align-items:center;background:#16a34a;color:#fff;border-radius:20px;padding:2px 10px;font-size:12px;}
.filtered-count{font-size:13px;color:#6c757d;}
.badge-sp{background:#dbeafe;color:#1e40af;border-radius:20px;padding:2px 8px;font-size:11px;font-weight:600;}
.badge-tien{background:#fef9c3;color:#713f12;border-radius:20px;padding:2px 8px;font-size:11px;font-weight:600;}
</style>
<div class="container-fluid">
    <div class="card p-3">
        <h1 class="font-weight-bold text-center">QUAN LI PHIEU NHAP KHO</h1>
    </div>
    <div class="filter-bar">
        <div class="filter-title">
            Bo loc phieu nhap
            <?php if(count($where_pn)>0): ?><span class="filter-badge"><?= count($where_pn) ?> bo loc dang ap dung</span><?php endif; ?>
            <span class="filtered-count">Hien thi <strong><?= $total_filtered_pn ?></strong> / <?= $total_all_pn ?> phieu nhap</span>
        </div>
        <form method="GET" action="">
            <input type="hidden" name="thamso" value="phieunhap">
            <div class="row g-2">
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">Tu ngay</label>
                    <input type="date" name="f_ngay_tu_pn" class="form-control" value="<?= htmlspecialchars($f_ngay_tu_pn) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">Den ngay</label>
                    <input type="date" name="f_ngay_den_pn" class="form-control" value="<?= htmlspecialchars($f_ngay_den_pn) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:12px">Nha cung cap</label>
                    <select name="f_ncc_pn" class="form-select">
                        <option value="0">-- Tat ca --</option>
                        <?php $tmp_ncc = mysqli_query($conn, "SELECT * FROM nhacungcap ORDER BY TenNCC"); while($r_ncc = mysqli_fetch_assoc($tmp_ncc)): ?>
                        <option value="<?= $r_ncc['MaNCC'] ?>" <?= $f_ncc_pn == $r_ncc['MaNCC'] ? 'selected' : '' ?>><?= htmlspecialchars($r_ncc['TenNCC']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">Ma phieu</label>
                    <input type="number" name="f_mahn_pn" class="form-control" placeholder="VD: 1" value="<?= $f_mahn_pn ?: '' ?>" min="1">
                </div>
                <div class="col-md-2 d-flex flex-column justify-content-end gap-1">
                    <button type="submit" class="btn btn-success" style="border-radius:8px;font-size:13px;">Loc</button>
                    <a href="?thamso=phieunhap" class="btn btn-outline-secondary" style="border-radius:8px;font-size:13px;">Xoa loc</a>
                </div>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-body">
            <?php $index = 1; ?>
            <table id="data-table-pn" class="table table-bordered table-hover display">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th><th>Ma PN</th><th>Nha cung cap</th><th>NV lap phieu</th><th>Ngay nhap</th><th>So loai SP</th><th>Tong SL</th><th>Tong tien</th><th>Ghi chu</th><th>Chi tiet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($query_run_pn && mysqli_num_rows($query_run_pn) > 0): while ($row = mysqli_fetch_assoc($query_run_pn)): ?>
                    <tr>
                        <td><?= $index++ ?></td>
                        <td><strong>#<?= $row['MaPN'] ?></strong></td>
                        <td><?= htmlspecialchars($row['TenNCC'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['TenNV'] ?? 'N/A') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['NgayNhap'])) ?></td>
                        <td><span class="badge-sp"><?= $row['SoLoaiSP'] ?> loai</span></td>
                        <td><?= number_format($row['TongSoLuong'], 0, ',', '.') ?></td>
                        <td><span class="badge-tien"><?= number_format($row['TongTienThucTe'], 0, ',', '.') ?>d</span></td>
                        <td><?= htmlspecialchars($row['GhiChu'] ?? '--') ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_PN_<?= $row['MaPN'] ?>">Xem</button>
                            <div class="modal fade" id="Modal_PN_<?= $row['MaPN'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Chi tiet phieu nhap #<?= $row['MaPN'] ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p><strong>Nha cung cap:</strong> <?= htmlspecialchars($row['TenNCC'] ?? '--') ?></p>
                                                    <p><strong>Nhan vien lap:</strong> <?= htmlspecialchars($row['TenNV'] ?? '--') ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Ngay nhap:</strong> <?= date('d/m/Y H:i', strtotime($row['NgayNhap'])) ?></p>
                                                    <p><strong>Ghi chu:</strong> <?= htmlspecialchars($row['GhiChu'] ?? 'Khong co') ?></p>
                                                </div>
                                            </div>
                                            <?php $q_ctpn = mysqli_query($conn, "SELECT ctpn.*, sp.TenSP, sp.AnhBia FROM chitietphieunhap ctpn JOIN sanpham sp ON ctpn.MaSP = sp.MaSP WHERE ctpn.MaPN = {$row['MaPN']}"); ?>
                                            <table class="table table-bordered table-sm table-hover">
                                                <thead class="thead-dark">
                                                    <tr><th>#</th><th>Anh</th><th>Ma SP</th><th>Ten san pham</th><th>So luong nhap</th><th>Don gia nhap</th><th>Thanh tien</th></tr>
                                                </thead>
                                                <tbody>
                                                    <?php $idx2=1; $tongTien=0; while ($ct = mysqli_fetch_assoc($q_ctpn)): $tongTien+=$ct['ThanhTien']; ?>
                                                    <tr>
                                                        <td><?= $idx2++ ?></td>
                                                        <td><img src="../Images/ImgProducts/<?= $ct['AnhBia'] ?>" width="50" height="50" style="object-fit:cover;border-radius:4px;"></td>
                                                        <td><?= $ct['MaSP'] ?></td>
                                                        <td><?= htmlspecialchars($ct['TenSP']) ?></td>
                                                        <td><?= number_format($ct['SoLuongNhap'], 0, ',', '.') ?></td>
                                                        <td><?= number_format($ct['DonGiaNhap'], 0, ',', '.') ?>d</td>
                                                        <td><strong><?= number_format($ct['ThanhTien'], 0, ',', '.') ?>d</strong></td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-success"><td colspan="6" class="text-end"><strong>Tong tien:</strong></td><td><strong class="text-success"><?= number_format($tongTien, 0, ',', '.') ?>d</strong></td></tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dong</button></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="10" class="text-center text-muted py-4">Khong tim thay phieu nhap nao phu hop.</td></tr>
                    <?php endif; ?>
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
    $('#data-table-pn').DataTable({
        language: {
            lengthMenu: 'Hien thi _MENU_ phieu / trang', zeroRecords: 'Khong tim thay du lieu!',
            info: 'Trang _PAGE_ / _PAGES_', infoEmpty: 'Khong co ban ghi nao',
            infoFiltered: '(loc tu _MAX_ ban ghi)', search: "Tim nhanh:",
            paginate: { first: "Dau", last: "Cuoi", next: "Sau", previous: "Truoc" }
        }
    });
});
</script>
