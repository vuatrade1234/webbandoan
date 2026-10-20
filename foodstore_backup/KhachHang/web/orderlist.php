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
$query = "SELECT *,Sum(chitietdathang.SoLuong) as 'TongSanPham' FROM dondathang 
join KhachHang on dondathang.MaKH = KhachHang.MaKH join chitietdathang 
ON chitietdathang.SoDH = dondathang.SoDH where dondathang.MaKH = $MaKH and dondathang.TinhTrangGiaoHang!='Giao hàng thành công' GROUP BY dondathang.SoDH";
$query_run = mysqli_query($con, $query);


?>

<body>

    <div class="container-fluid ">

        <div class="card p-3">
            <h1 class="font-weight-bold text-center"> ĐƠN ĐẶT HÀNG CỦA TÔI</h1>
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
                                        <div class="modal fade" id="Modal_Detail<?php echo $row['SoDH']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
                                            <div class="modal-dialog modal-xl ">
                                                <!-- modal-xl -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="LabelModal">Chi tiết</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <?php $query_run_chitiet = mysqli_query($con, "select * from chitietdathang JOIN dondathang ON chitietdathang.SoDH = dondathang.SoDH join giay ON chitietdathang.MaGiay = giay.MaGiay where chitietdathang.SoDH = '$row[SoDH]'"); ?>
                                                        <table class="table table-bordered table-secondary table-hover display text-center">
                                                            <thead class="thead-dark">
                                                                <th>#</th>
                                                                <th>Size giày</th>
                                                                <th>Màu giày</th>
                                                                <th>Tên giày</th>
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

                                                                            <td><?php echo $r["Sizegiay"] ?></td>
                                                                            <td><?php echo $r["Maugiay"] ?></td>
                                                                            <td><?php echo $r["TenGiay"] ?></td>
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

                                                        <p style="font-size:20px ;" class="text-end">Tổng tiền: <strong class="text-primary"><?php echo number_format($row_tongtien["tong"], 0, ',', '.'); ?></strong> đồng</p>



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
    .img {
        align-items: center;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }


    h1 {
        align-items: center;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        font-size: 40px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .gradient-custom {
        /* fallback for old browsers */
        background: #6a11cb;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
    }

    .mid-grid-left {
        display: none;
    }

    th {
        font-weight: bold;
    }
</style>