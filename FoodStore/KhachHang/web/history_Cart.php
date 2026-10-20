<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="~/css/cart.css">


</head>

<?php
include("Layout_KhachHang_Header.php");
include("connection.php");

$MaKH =  $_SESSION["MaKH"];

if (isset($_POST['reorder_submit'])) {
    $reorder_sodh = (int) $_POST['reorder_sodh'];
    $check_dh = mysqli_query($con, "SELECT SoDH FROM dondathang WHERE SoDH = '$reorder_sodh' AND MaKH = '$MaKH'");
    if (mysqli_num_rows($check_dh) > 0) {
        $get_items = mysqli_query($con, "SELECT * FROM chitietdathang WHERE SoDH = '$reorder_sodh'");
        while ($item = mysqli_fetch_assoc($get_items)) {
            $masp = (int) $item['MaSP'];
            $sl = (int) $item['SoLuong'];
            $qc = mysqli_real_escape_string($con, $item['QuyCach']);
            $vh = mysqli_real_escape_string($con, $item['ViHuong']);

            $check_gh = mysqli_query($con, "SELECT id, soluong FROM giohang WHERE MaKH = '$MaKH' AND MaSP = '$masp' AND QuyCach = '$qc' AND ViHuong = '$vh'");
            if (mysqli_num_rows($check_gh) > 0) {
                $gh_row = mysqli_fetch_assoc($check_gh);
                $new_sl = $gh_row['soluong'] + $sl;
                mysqli_query($con, "UPDATE giohang SET soluong = '$new_sl' WHERE id = '{$gh_row['id']}'");
            } else {
                mysqli_query($con, "INSERT INTO giohang (MaKH, MaSP, TrangThai, soluong, QuyCach, ViHuong) VALUES ('$MaKH', '$masp', 1, '$sl', '$qc', '$vh')");
            }
        }
        echo "<script>alert('Đã thêm toàn bộ món từ đơn hàng vào giỏ! Đang chuyển hướng...'); location.href='cart2.php';</script>";
        exit;
    }
}

$query = "SELECT *,Sum(chitietdathang.SoLuong) as 'TongSanPham' FROM dondathang 
join KhachHang on dondathang.MaKH = KhachHang.MaKH join chitietdathang 
ON chitietdathang.SoDH = dondathang.SoDH where dondathang.MaKH = $MaKH and dondathang.TinhTrangGiaoHang='Giao hàng thành công' GROUP BY dondathang.SoDH";
$query_run = mysqli_query($con, $query);


?>

<body>

    <div class="container-fluid ">

        <div class="card p-3">
            <h1 class="font-weight-bold text-center">LỊCH SỬ ĐẶT HÀNG</h1>
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

                            <th>Số sản phẩm</th>
                            <th>Ngày đặt</th>
                            <th>Địa chỉ giao</th>
                            <th>Điện thoại</th>
                            <th>Tình trạng</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($query_run) != 0) {
                            while ($row = mysqli_fetch_array($query_run)) { ?>
                                <tr>
                                    <td> <?php echo $index;
                                            $index++; ?></td>

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
                                        <form method="post" style="display:inline-block; margin-left: 5px;">
                                            <input type="hidden" name="reorder_sodh" value="<?php echo $row['SoDH']; ?>">
                                            <button type="submit" name="reorder_submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn đặt lại các món từ đơn hàng này vào giỏ?');">
                                                🔄 Đặt lại đơn
                                            </button>
                                        </form>
                                        <div class="modal fade" id="Modal_Detail<?php echo $row['SoDH']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl ">
                                                <!-- modal-xl -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="LabelModal">Chi tiết</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <?php $query_run_chitiet = mysqli_query($con, "SELECT * FROM chitietdathang JOIN dondathang ON chitietdathang.SoDH = dondathang.SoDH JOIN sanpham ON chitietdathang.MaSP = sanpham.MaSP WHERE chitietdathang.SoDH = '$row[SoDH]'"); ?>
                                                        <table class="table table-bordered table-secondary table-hover display text-center">
                                                            <thead class="thead-dark">
                                                                <th>#</th>

                                                                <th>Quy cách</th>
                                                                <th>Hương vị</th>
                                                                <th>Tên món ăn</th>
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

                                                                            <td><?php echo $r["QuyCach"] ?></td>
                                                                            <td><?php echo $r["ViHuong"] ?></td>
                                                                            <td><?php echo $r["TenSP"] ?></td>
                                                                            <td><?php echo $r["SoLuong"] ?></td>
                                                                            <td><?php echo number_format($r["DonGia"], 0, ',', '.'); ?></td>
                                                                            <td><?php echo number_format($r["SoLuong"] * $r["DonGia"], 0, ',', '.'); ?></td>

                                                                        </tr>

                                                                <?php  }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php $qr_tongtien = mysqli_query($con, "select *,sum(SoLuong * DonGia) as 'tong' from chitietdathang where SoDH = '$row[SoDH]'");

                                                        $row_tongtien = mysqli_fetch_array($qr_tongtien);
                                                        ?>

                                                        <p style="font-size:20px ;" class="text-end">Tổng tiền hàng: <strong class="text-primary"><?php echo number_format($row_tongtien["tong"], 0, ',', '.'); ?></strong> đồng</p>
                                                        <?php
                                                        $has_tien_giam = false;
                                                        try {
                                                            $result_col = mysqli_query($con, "SHOW COLUMNS FROM `dondathang` LIKE 'TienGiam'");
                                                            $has_tien_giam = $result_col && mysqli_num_rows($result_col) > 0;
                                                        } catch (Exception $e) {}
                                                        if ($has_tien_giam) {
                                                            $voucherInfo = mysqli_fetch_assoc(mysqli_query($con, "SELECT TienGiam, TongTienSauGiam, VoucherCode FROM dondathang WHERE SoDH = '{$row['SoDH']}'"));
                                                            if ($voucherInfo && (float)$voucherInfo['TienGiam'] > 0) {
                                                                $tienGiam = (float)$voucherInfo['TienGiam'];
                                                                $tongSauGiam = (float)$voucherInfo['TongTienSauGiam'];
                                                        ?>
                                                        <p style="font-size:18px;" class="text-end text-danger">Voucher (<?php echo htmlspecialchars($voucherInfo['VoucherCode'] ?? ''); ?>): <strong>-<?php echo number_format($tienGiam, 0, ',', '.'); ?></strong> đồng</p>
                                                        <p style="font-size:20px; font-weight:bold;" class="text-end">Thành tiền: <strong class="text-success"><?php echo number_format($tongSauGiam, 0, ',', '.'); ?></strong> đồng</p>
                                                        <?php } } ?>



                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>


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


    <?php include("Layout_KhachHang_Footer.php"); ?>
</body>

</html>
<style>
    body {
        background: #f3f1ee;
        color: #1f2937;
    }

    .container-fluid {
        max-width: 1500px;
        margin: 0 auto;
        padding: 24px 18px 32px;
    }

    .card {
        border: 1px solid #e5dccd;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 12px 26px rgba(46, 36, 26, 0.06);
    }

    .card.p-3 {
        background: linear-gradient(180deg, #fffdf9 0%, #f4efe7 100%);
        border: 1px solid #e9dcc7;
        box-shadow: none;
        margin-bottom: 18px;
    }

    h1 {
        align-items: center;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        font-size: clamp(2rem, 3vw, 2.8rem);
        font-weight: 900;
        margin-bottom: 0;
        color: #1f1f1f;
        letter-spacing: -0.04em;
    }

    .img {
        align-items: center;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }

    .mid-grid-left {
        display: none;
    }

    #data-table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        background: #f4f4f2;
        font-size: 1rem;
    }

    #data-table thead th {
        background: linear-gradient(180deg, #d9c4a3 0%, #cfb282 100%);
        color: #2b241f;
        font-weight: 800;
        text-transform: none;
        letter-spacing: 0.01em;
        padding: 20px 18px;
        border-bottom: 1px solid #caa977;
        vertical-align: middle;
    }

    #data-table tbody td {
        padding: 18px 16px;
        vertical-align: middle;
        color: #2c2c2c;
        border-bottom: 1px solid #e9e2d9;
        background: rgba(255,255,255,0.12);
    }

    #data-table tbody tr:nth-child(even) td {
        background: rgba(255,255,255,0.08);
    }

    #data-table tbody tr:hover td {
        background: rgba(255,255,255,0.22);
    }

    .btn-primary {
        background: linear-gradient(135deg, #d6502f 0%, #b73622 100%);
        border: none;
        border-radius: 10px;
        font-weight: 800;
        padding: 10px 18px;
        box-shadow: 0 8px 18px rgba(183, 54, 34, 0.15);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #c94527 0%, #9d2d1c 100%);
    }

    .modal-content {
        border-radius: 18px;
        border: 1px solid #ebdfcf;
        overflow: hidden;
    }

    .modal-header {
        background: #fff8f1;
        border-bottom: 1px solid #f0dfc8;
        padding: 16px 20px;
    }

    .modal-title {
        font-weight: 800;
        color: #2d261f;
    }

    .modal-body {
        background: #fff;
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid #f0dfc8;
        padding: 16px 20px;
    }

    .btn-secondary {
        border-radius: 10px;
        font-weight: 700;
    }

    .table-secondary {
        background: #fff;
    }

    .thead-dark th {
        background: #d9c4a3 !important;
        color: #2f261f !important;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        #data-table {
            font-size: 0.88rem;
        }

        #data-table thead th,
        #data-table tbody td {
            padding: 12px 10px;
        }
    }
</style>