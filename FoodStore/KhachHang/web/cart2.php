<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="~/css/cart.css">


  <title>Giohang</title>
</head>

<?php
include("Layout_KhachHang_Header.php");
include("../../ProductPricing.php");
require('Changquantity.php');
include("voucher_helper.php");
ensure_voucher_schema($con);

$MaKH =  $_SESSION["MaKH"];

// Truy vấn giỏ hàng
$query = "SELECT giohang.*, sanpham.MaSP AS MaSP, sanpham.TenSP AS TenSP, sanpham.AnhBia, sanpham.GiaBan, sanpham.QuyCach AS ProductSize
          FROM giohang
          JOIN sanpham ON giohang.MaSP = sanpham.MaSP
          JOIN khachhang ON giohang.MaKH = khachhang.MaKH
          WHERE giohang.MaKH = '$MaKH'";
$result = mysqli_query($con, $query);

$tinh = 0;
$cartItems = [];
if (mysqli_num_rows($result) != 0) {
  while ($rowItem = mysqli_fetch_assoc($result)) {
    $rowItem['unit_price'] = get_selected_size_price($rowItem['ProductSize'], $rowItem['QuyCach'], $rowItem['GiaBan']);
    $rowItem['line_total'] = $rowItem['unit_price'] * (int) $rowItem['soluong'];
    $tinh += $rowItem['line_total'];
    $cartItems[] = $rowItem;
  }
}
mysqli_data_seek($result, 0);

// Đếm số lượng sản phẩm
$query2 = "SELECT COUNT(*) as count
           FROM giohang
           JOIN sanpham ON giohang.MaSP = sanpham.MaSP
           JOIN khachhang ON giohang.MaKH = khachhang.MaKH
           WHERE giohang.MaKH = '$MaKH'";
$result1 = mysqli_query($con, $query2);
$row1 = mysqli_fetch_assoc($result1);
$count = $row1['count'];

$voucher_code = trim($_POST['voucher_code'] ?? $_SESSION['voucher_code'] ?? '');
$voucher_error = '';
$voucher_details = null;
$voucher_discount = 0;

if (isset($_POST['apply_voucher'])) {
  $voucher_code = normalize_voucher_code($_POST['voucher_code'] ?? '');

  if ($voucher_code === '') {
    $voucher_error = 'Vui lòng nhập mã voucher.';
  } else {
    $candidateVoucher = get_voucher_by_code($con, $voucher_code);

    if ($candidateVoucher && get_voucher_customer_eligibility($con, $candidateVoucher, $MaKH)) {
      $_SESSION['voucher_code'] = $voucher_code;
    } else {
      $voucher_error = get_voucher_customer_eligibility_reason($con, $candidateVoucher, $MaKH);
      unset($_SESSION['voucher_code']);
    }
  }
}

if (isset($_POST['remove_voucher'])) {
  unset($_SESSION['voucher_code']);
  $voucher_code = '';
  $voucher_details = null;
  $voucher_discount = 0;
}

if (!empty($_SESSION['voucher_code'])) {
  $voucher_code = normalize_voucher_code($_SESSION['voucher_code']);
  $candidateVoucher = get_voucher_by_code($con, $voucher_code);
  if ($candidateVoucher && get_voucher_customer_eligibility($con, $candidateVoucher, $MaKH)) {
    $voucher_details = $candidateVoucher;
    $minimumOrder = (float) ($candidateVoucher['DieuKienDonToiThieu'] ?? 0);
    if ((float) ($tinh ?? 0) >= $minimumOrder) {
      $voucher_discount = (float) calculate_voucher_discount($candidateVoucher, $tinh ?? 0, $con);
      $voucher_details['discount_amount'] = $voucher_discount;
    } else {
      $voucher_error = 'Mã đã chọn. Thêm ' . number_format($minimumOrder - (float) ($tinh ?? 0), 0, ',', '.') . ' VND để đủ điều kiện áp dụng.';
    }
  } else {
    unset($_SESSION['voucher_code']);
    $voucher_error = get_voucher_customer_eligibility_reason($con, $candidateVoucher, $MaKH);
  }
}

$discounted_total = max(0, ((float) ($tinh ?? 0)) - $voucher_discount);

// echo "count".$count;
?>


<body>
  <div class="card-body cart-page">
    <h1>Giỏ Hàng Của Tôi</h1>
    <?php if ($count > 0) { ?>

      <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-header py-3">
                <h5 class="mb-0">Giỏ Hàng - <?php echo $count ?> sản phẩm</h5>
              </div>
              <div class="containner" style="margin-top: 10px ;">
                <div class="row text-center cart-label-row">
                  <div class="col-lg-2">
                    <h3>Ảnh</h3>
                  </div>
                  <div class="col-lg-3">
                    <h3>Tên món ăn</h3>
                  </div>
                  <div class="col-lg-1">
                    <h3>Quy cách</h3>
                  </div>
                  <div class="col-lg-1">
                    <h3>Hương vị</h3>
                  </div>
                  <div class="col-lg-2">
                    <h3>Số lượng</h3>
                  </div>
                  <div class="col-lg-2" style="margin-left: -25px ;">
                    <h3>Tổng tiền</h3>
                  </div>

                </div>

                <div class="card-body">
                  <?php if (mysqli_num_rows($result) != 0) { ?>
                    <?php
                    foreach ($cartItems as $row) {
                    ?>

                      <!-- Single item -->
                      <div class="row text-center cart-item-row" style="margin-bottom: 20px">
                        <div class="col-lg-2 col-md-12 mb-4 mb-lg-0">
                          <!-- Image -->
                          <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                            <a href="./details.php?MaSP=<?php echo $row['MaSP'] ?>"><img style="width:100px; height: 75px;" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80" alt="Món ăn vặt" /></a>
                            <a href="#!">
                              <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                            </a>
                          </div>
                          <!-- Image -->
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Data -->
                          <p><strong><?php echo $row["TenSP"]  ?></strong></p>
                          <!-- Data -->
                        </div>
                        <div class="col-lg-1 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Data -->
                          <p><strong><?php echo $row["QuyCach"]  ?></strong></p>
                          <!-- Data -->
                        </div>
                        <div class="col-lg-1 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Data -->
                          <p><strong><?php echo $row["ViHuong"]  ?></strong></p>
                          <!-- Data -->
                        </div>

                        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Quantity -->
                          <div class="d-flex mb-4" style="max-width: 300px">
                            <form method="post" style="display: flex">
                              <input type="submit" class="btn btn-primary" name="tru" style="width: 40px; text-align: center;" value="-">

                              <div class="form-outline fw-bold">
                                <input name="soluong" value="<?php echo $row["soluong"]  ?>" type="text" class="form-control w-5" style="width: 100px; text-align: center;" />
                                <input type="hidden" name="maId" value="<?php echo $row['id'] ?>">

                              </div>

                              <input type="submit" class="btn btn-primary" name="cong" style="width: 40px;text-align: center;" value="+">
                              </input>
                            </form>
                          </div>
                          <!-- Quantity -->

                          <!-- Price -->

                          <!-- Price -->

                        </div>

                        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 fw-bold ">
                          <!-- Data -->
                          <p class="text-start text-md-center fw-bold " style="margin-left: 20px ;">
                            <strong style="padding-right: 30px;"><?php echo number_format($row['line_total'], 0, ',', '.')   ?>
                            </strong>
                          </p>
                          <!-- Data -->
                        </div>
                        <div class="col-lg-1 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <a href="xoa.php?id=<?php echo $row["id"] ?>" class="btn btn-danger" style="height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                          </a>
                        </div>
                      </div>







                  <?php  }
                  } ?>
                </div>

              </div>
              <div class="card-body ">
                <ul class="list-group list-group-flush justify-content-end">
                  <li class="list-group-item border-0 px-0 mb-3">
                    <form method="post" class="row g-2 align-items-center">
                      <div class="col-md-8">
                        <label class="form-label fw-bold">Mã giảm giá</label>
                        <input type="text" class="form-control" name="voucher_code" value="<?php echo htmlspecialchars($voucher_code); ?>" placeholder="Nhập mã voucher">
                      </div>
                      <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" name="apply_voucher" class="btn btn-warning w-100">Áp dụng</button>
                        <?php if (!empty($_SESSION['voucher_code'] ?? '')) { ?>
                          <button type="submit" name="remove_voucher" class="btn btn-outline-secondary">Xoá</button>
                        <?php } ?>
                      </div>
                    </form>
                    <?php if (!empty($voucher_error)) { ?>
                      <div class="alert alert-danger mt-2 mb-0 py-2"><?php echo $voucher_error; ?></div>
                    <?php } elseif (!empty($_SESSION['voucher_code'] ?? '')) { ?>
                      <div class="alert alert-success mt-2 mb-0 py-2">Áp dụng mã <strong><?php echo htmlspecialchars($_SESSION['voucher_code']); ?></strong> thành công.</div>
                    <?php } ?>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-2">
                    <span>Tổng tiền hàng</span>
                    <strong><?php echo number_format((float) $tinh, 0, ',', '.'); ?> VND</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-2">
                    <span>Giảm giá</span>
                    <strong class="text-danger">-<?php echo number_format((float) $voucher_discount, 0, ',', '.'); ?> VND</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-start align-items-center border-0 px-0 mb-3 cart-total" style="color: #20E3B2; font-size: 30px;   font-weight: bold;">
                    <span style="margin-left:auto"> </span>
                    <p> <?php echo "Thành tiền: ";
                        echo number_format((float) $discounted_total, 0, ',', '.') . " VND";
                        ?></p>
                  </li>
                  <a href="./oder.php" class="btn btn-primary btn-lg align-items-end">
                    Đặt hàng ngay
                  </a>
                </ul>


              </div>
              <!-- <div class="text-right mt-4">
            <label class="text-muted font-weight-normal m-0">Total price</label>
            <div class="text-large"><strong>

              </strong></div>
          </div>
          <div class="float-right">
            <a href="./oder.php" class="btn btn-lg btn-primary mt-2 text-light">Mua Hàng</a>
          </div> -->
            <?php echo "</div>
          </div>
        </div>
      </div>
    </div>";
          } else { ?>
              <div class="cart-empty">
                <span aria-hidden="true">🛍</span>
                <h2>Giỏ hàng đang trống</h2>
                <?php if (!empty($_SESSION['voucher_code'])) { ?>
                  <p>Mã <strong><?php echo htmlspecialchars($_SESSION['voucher_code'], ENT_QUOTES, 'UTF-8'); ?></strong> đã được lưu. Mã sẽ tự áp dụng khi giỏ hàng đạt giá trị tối thiểu.</p>
                <?php } ?>
                <p>Chọn món ngon bạn thích, tụi mình chuẩn bị ngay.</p>
                <a class="btn btn-primary" href="HienThiTatCaSanPham.php">Khám phá món ăn</a>
              </div>
            <?php } ?>
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
</style>