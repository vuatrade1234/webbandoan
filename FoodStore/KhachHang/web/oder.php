<?php
include("Layout_KhachHang_Header.php");
include("../../ProductPricing.php");
include("connection.php");
include("voucher_helper.php");
ensure_voucher_schema($con);

$MaKH = isset($_SESSION["MaKH"]) ? (int) $_SESSION["MaKH"] : 0;

function has_column($con, $table, $column)
{
    $result = mysqli_query($con, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $result && mysqli_num_rows($result) > 0;
}

function ensure_order_columns($con)
{
  $columns = [
    'PhuongThucThanhToan' => "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `PhuongThucThanhToan` VARCHAR(20) NOT NULL DEFAULT 'tienmat'",
    'DienThoaiKH' => "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `DienThoaiKH` VARCHAR(20) NULL DEFAULT NULL"
  ];

  foreach ($columns as $column => $sql) {
    if (!has_column($con, 'dondathang', $column)) {
      mysqli_query($con, $sql) or die(mysqli_error($con));
    }
  }
}

ensure_order_columns($con);

function payment_label($value)
{
    if ($value === 'qr') {
        return 'Chuyển khoản QR';
    }

    if ($value === 'tienmat') {
        return 'Tiền mặt khi nhận hàng';
    }

    return 'Chưa cập nhật';
}

  function reserve_cart_stock($con, $customerId, &$error)
  {
    $cartResult = mysqli_query($con, "SELECT MaSP, soluong FROM giohang WHERE MaKH = '$customerId' FOR UPDATE");
    if (!$cartResult || mysqli_num_rows($cartResult) === 0) {
      $error = 'Giỏ hàng trống hoặc không thể kiểm tra tồn kho. Vui lòng tải lại trang.';
      return false;
    }

    $requiredStock = [];
    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
      $productId = (int) $cartItem['MaSP'];
      $requiredStock[$productId] = ($requiredStock[$productId] ?? 0) + (int) $cartItem['soluong'];
    }

    foreach ($requiredStock as $productId => $quantity) {
      if ($quantity <= 0) {
        $error = 'Số lượng sản phẩm trong giỏ không hợp lệ.';
        return false;
      }

      $updated = mysqli_query($con, "UPDATE sanpham SET SoLuongTon = SoLuongTon - '$quantity' WHERE MaSP = '$productId' AND SoLuongTon >= '$quantity'");
      if (!$updated || mysqli_affected_rows($con) !== 1) {
        $error = 'Một hoặc nhiều sản phẩm không đủ tồn kho. Vui lòng kiểm tra lại giỏ hàng.';
        return false;
      }
    }

    return true;
  }

$cart_order_success = false;
$payment_method = 'tienmat';
$latest_order_id = null;
$qr_code_url = '';
$total_amount = 0;

if ($MaKH <= 0) {
    echo "<script>alert('Bạn cần đăng nhập để đặt hàng.');location='./login.php';</script>";
    exit;
}

$query = "SELECT giohang.*, sanpham.MaSP AS MaSP, sanpham.TenSP AS TenSP, sanpham.AnhBia, sanpham.GiaBan, sanpham.QuyCach AS ProductSize
          FROM giohang
          JOIN sanpham ON giohang.MaSP = sanpham.MaSP
          JOIN khachhang ON giohang.MaKH = khachhang.MaKH
          WHERE giohang.MaKH = '$MaKH'";
$result = mysqli_query($con, $query);

$total_amount = 0;
$cartItemsForOrder = [];
if (mysqli_num_rows($result) != 0) {
    while ($rowItem = mysqli_fetch_assoc($result)) {
        $rowItem['unit_price'] = get_selected_size_price($rowItem['ProductSize'], $rowItem['QuyCach'], $rowItem['GiaBan']);
        $rowItem['line_total'] = $rowItem['unit_price'] * (int) $rowItem['soluong'];
        $cartItemsForOrder[] = $rowItem;
        $total_amount += $rowItem['line_total'];
    }
}
mysqli_data_seek($result, 0);

$query2 = "SELECT COUNT(*) as count
           FROM giohang
           JOIN sanpham ON giohang.MaSP = sanpham.MaSP
           JOIN khachhang ON giohang.MaKH = khachhang.MaKH
           WHERE giohang.MaKH = '$MaKH'";
$result1 = mysqli_query($con, $query2);
$row1 = mysqli_fetch_assoc($result1);
$count = $row1['count'] ?? 0;

$customer = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM khachhang WHERE MaKH = '$MaKH' LIMIT 1"));

$voucher_code = normalize_voucher_code($_SESSION['voucher_code'] ?? '');
$voucher_details = null;
$voucher_discount = 0;
$final_total = (float) $total_amount;
$order_error = '';

if ($voucher_code !== '') {
  $voucher_details = get_valid_voucher_for_total($con, $voucher_code, $total_amount, $MaKH);
  if ($voucher_details) {
    $voucher_discount = (float) ($voucher_details['discount_amount'] ?? 0);
    $final_total = max(0, $total_amount - $voucher_discount);
  } else {
    $voucherCandidate = get_voucher_by_code($con, $voucher_code);
    $order_error = get_voucher_customer_eligibility_reason($con, $voucherCandidate, $MaKH);
    if ($order_error === '' && $voucherCandidate) {
      $neededAmount = max(0, (float) $voucherCandidate['DieuKienDonToiThieu'] - (float) $total_amount);
      $order_error = 'Đơn hàng chưa đủ điều kiện voucher. Cần thêm ' . number_format($neededAmount, 0, ',', '.') . ' VND để áp dụng.';
    }
  }
}

if (isset($_POST['dathangne'])) {
    $diachi = trim($_POST['diachi'] ?? '');
    $phone = trim($_POST['dienthoai'] ?? '');
    $payment_method = $_POST['phuong_thuc'] ?? 'tienmat';
  $voucher_code = normalize_voucher_code($_SESSION['voucher_code'] ?? '');
  $voucher_details = $voucher_code !== '' ? get_valid_voucher_for_total($con, $voucher_code, $total_amount, $MaKH) : null;
  $voucher_discount = $voucher_details ? (float) ($voucher_details['discount_amount'] ?? 0) : 0;
  $final_total = max(0, $total_amount - $voucher_discount);

    if ($voucher_code !== '' && !$voucher_details) {
      $voucherCandidate = get_voucher_by_code($con, $voucher_code);
      $order_error = get_voucher_customer_eligibility_reason($con, $voucherCandidate, $MaKH);
      if ($order_error === '' && $voucherCandidate) {
        $neededAmount = max(0, (float) $voucherCandidate['DieuKienDonToiThieu'] - (float) $total_amount);
        $order_error = 'Đơn hàng chưa đủ điều kiện voucher. Cần thêm ' . number_format($neededAmount, 0, ',', '.') . ' VND để áp dụng.';
      }
    } elseif ($diachi === '') {
        echo "<script>alert('Vui lòng nhập địa chỉ giao hàng.');</script>";
    } else {
        if ($phone === '' && !empty($customer['DienThoaiKH'])) {
            $phone = $customer['DienThoaiKH'];
        }

        if (!mysqli_begin_transaction($con)) {
          $order_error = 'Không thể xử lý đơn hàng lúc này. Vui lòng thử lại.';
          echo "<script>alert('" . addslashes($order_error) . "');location='./cart2.php';</script>";
          exit;
        }
        if (!reserve_cart_stock($con, $MaKH, $order_error)) {
          mysqli_rollback($con);
          echo "<script>alert('" . addslashes($order_error) . "');location='./cart2.php';</script>";
          exit;
        }

        $sqlInsert = "INSERT INTO dondathang (MaKH, NgayGiao, DaThanhToan, TinhTrangGiaoHang, NgayDat, DiaChiGiaoHang, MaNVGH";
        $sqlValues = "VALUES ('$MaKH', NULL, 0, 'Chờ xác nhận', NOW(), '$diachi', NULL";

        if (has_column($con, 'dondathang', 'PhuongThucThanhToan')) {
            $sqlInsert .= ', PhuongThucThanhToan';
            $sqlValues .= ", '$payment_method'";
        }

        if (has_column($con, 'dondathang', 'VoucherCode')) {
          $sqlInsert .= ', VoucherCode';
          $safeVoucherCode = mysqli_real_escape_string($con, $voucher_code);
          $sqlValues .= $voucher_code !== '' ? ", '$safeVoucherCode'" : ', NULL';
        }

        if (has_column($con, 'dondathang', 'MaVoucher')) {
          $sqlInsert .= ', MaVoucher';
          $voucherId = $voucher_details ? (int) $voucher_details['MaVC'] : 0;
          $sqlValues .= $voucherId > 0 ? ", '$voucherId'" : ', NULL';
        }

        if (has_column($con, 'dondathang', 'TienGiam')) {
          $sqlInsert .= ', TienGiam';
          $sqlValues .= ", '$voucher_discount'";
        }

        if (has_column($con, 'dondathang', 'TongTienSauGiam')) {
          $sqlInsert .= ', TongTienSauGiam';
          $sqlValues .= ", '$final_total'";
        }

        if (has_column($con, 'dondathang', 'DienThoaiKH')) {
            $sqlInsert .= ', DienThoaiKH';
            $sqlValues .= ", '$phone'";
        }

        $sqlInsert .= ') ' . $sqlValues . ')';
        mysqli_query($con, $sqlInsert) or die(mysqli_error($con));

        $latest_order_id = mysqli_insert_id($con);
        if ($voucher_code !== '' && $voucher_details) {
          $voucherId = (int) $voucher_details['MaVC'];
          $usageSql = "INSERT INTO `voucher_customer_usage` (`MaVC`, `MaKH`, `SoDH`) VALUES ('$voucherId', '$MaKH', '$latest_order_id')";
          if (!mysqli_query($con, $usageSql)) {
            mysqli_query($con, "DELETE FROM `dondathang` WHERE `SoDH` = '$latest_order_id'");
            $latest_order_id = null;
            $order_error = 'Voucher vừa được sử dụng hoặc đã hết lượt. Vui lòng tải lại giỏ hàng.';
          } else {
            $updatedVoucher = mysqli_query($con, "UPDATE `voucher` SET `SoLanDaDung` = `SoLanDaDung` + 1 WHERE `MaVC` = '$voucherId' AND `SoLanDaDung` < `SoLuong`");
            if (!$updatedVoucher || mysqli_affected_rows($con) !== 1) {
              mysqli_query($con, "DELETE FROM `voucher_customer_usage` WHERE `MaVC` = '$voucherId' AND `MaKH` = '$MaKH'");
              mysqli_query($con, "DELETE FROM `dondathang` WHERE `SoDH` = '$latest_order_id'");
              $latest_order_id = null;
              $order_error = 'Voucher vừa hết lượt sử dụng. Vui lòng tải lại giỏ hàng.';
            }
          }
        }
        if ($order_error !== '') {
          mysqli_rollback($con);
        }
        if ($order_error === '') {
        $cartItems = mysqli_query($con, "SELECT giohang.*, sanpham.MaSP AS MaSP, sanpham.TenSP AS TenSP, sanpham.AnhBia, sanpham.GiaBan, sanpham.QuyCach AS ProductSize, giohang.QuyCach, giohang.ViHuong FROM giohang JOIN sanpham ON giohang.MaSP = sanpham.MaSP WHERE giohang.MaKH = '$MaKH'");

        $detailsSaved = $cartItems && mysqli_num_rows($cartItems) > 0;
        if ($detailsSaved) {
            while ($rowItem = mysqli_fetch_array($cartItems)) {
                $soluong = (int) $rowItem['soluong'];
                $dongia = (int) get_selected_size_price($rowItem['ProductSize'], $rowItem['QuyCach'], $rowItem['GiaBan']);
                $mau = $rowItem['ViHuong'];
                $size = $rowItem['QuyCach'];
                $mag = $rowItem['MaSP'];
                if (!mysqli_query($con, "INSERT INTO chitietdathang (SoDH, MaSP, SoLuong, DonGia, QuyCach, ViHuong) VALUES ('$latest_order_id', '$mag', '$soluong', '$dongia', '$size', '$mau')")) {
                  $detailsSaved = false;
                  break;
                }
            }
        }

            if (!$detailsSaved || !mysqli_query($con, "DELETE FROM giohang WHERE MaKH = '$MaKH'") || !mysqli_commit($con)) {
              mysqli_rollback($con);
              $order_error = 'Không thể hoàn tất đơn hàng. Tồn kho và giỏ hàng đã được giữ nguyên, vui lòng thử lại.';
            } else {
        $cart_order_success = true;
        unset($_SESSION['voucher_code']);
        $qr_code_url = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode("SnackStore|{$MaKH}|{$latest_order_id}|{$final_total}|{$payment_method}");

        if (!empty($customer['Email'])) {
            try {
                require './PHPMailer/src/Exception.php';
                require './PHPMailer/src/PHPMailer.php';
                require './PHPMailer/src/SMTP.php';

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tmhaunct2001@gmail.com';
                $mail->Password = 'ooakwovagpxsevav';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('lehoanggiang0405@gmail.com', 'SnackStore Xác nhận');
                $mail->addAddress($customer['Email'], $customer['HoTen']);
                $mail->isHTML(true);
                $mail->Subject = 'Xác nhận đặt hàng';
                $mail->Body = "Cảm ơn {$customer['HoTen']} đã đặt hàng với tổng tiền: " . number_format($final_total, 0, ',', '.') . " VNĐ. Phương thức thanh toán: " . payment_label($payment_method) . ".";
                $mail->send();
            } catch (Exception $e) {
                // Không chặn luồng đặt hàng nếu gửi email thất bại.
            }
        }
          }
          }
    }
}
?>

<body>
  <div class="checkout-page">
    <div class="container py-4">
      <div class="page-top text-center mb-4">
        <span class="eyebrow">Checkout</span>
        <h1>Đặt hàng</h1>
      </div>

      <?php if ($count > 0 || $cart_order_success) { ?>
        <?php if ($order_error !== '') { ?>
          <div class="alert alert-danger rounded-4 shadow-sm border-0 mb-4"><?php echo htmlspecialchars($order_error); ?></div>
        <?php } ?>
        <?php if ($cart_order_success) { ?>
          <div class="alert alert-success rounded-4 shadow-sm border-0 mb-4">
            <strong>Đặt hàng thành công!</strong> Đơn hàng của bạn đã được ghi nhận. Vui lòng kiểm tra trạng thái trong mục đơn hàng của tôi.
          </div>
        <?php } ?>

        <div class="checkout-shell">
          <?php if (!$cart_order_success) { ?>
            <div class="checkout-panel cart-panel">
              <div class="panel-header">
                <h3>Giỏ hàng của bạn</h3>
                <span><?php echo $count; ?> sản phẩm</span>
              </div>

              <?php if (mysqli_num_rows($result) != 0) { while ($row = mysqli_fetch_array($result)) { $row['unit_price'] = get_selected_size_price($row['ProductSize'], $row['QuyCach'], $row['GiaBan']); ?>
                <div class="cart-item-row">
                  <div class="product-thumb">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80" alt="<?php echo $row['TenSP']; ?>" />
                  </div>
                  <div class="product-info">
                    <h4><?php echo $row['TenSP']; ?></h4>
                    <p><?php echo $row['QuyCach']; ?></p>
                  </div>
                  <div class="product-qty"><?php echo $row['soluong']; ?> x <?php echo number_format($row['unit_price'], 0, ',', '.'); ?>đ</div>
                  <div class="product-total"><?php echo number_format($row['unit_price'] * $row['soluong'], 0, ',', '.'); ?>đ</div>
                </div>
              <?php } } ?>

              <div class="order-summary">
                <div class="summary-row">
                  <span>Tổng tiền hàng</span>
                  <strong><?php echo number_format((float) $total_amount, 0, ',', '.'); ?> VND</strong>
                </div>
                <?php if ($voucher_discount > 0) { ?>
                  <div class="summary-row">
                    <span>Giảm giá (Voucher: <?php echo htmlspecialchars($voucher_code); ?>)</span>
                    <strong class="text-danger">-<?php echo number_format((float) $voucher_discount, 0, ',', '.'); ?> VND</strong>
                  </div>
                <?php } ?>
                <div class="summary-row total-row">
                  <span>Thành tiền</span>
                  <strong><?php echo number_format((float) $final_total, 0, ',', '.'); ?> VND</strong>
                </div>
              </div>
            </div>
          <?php } ?>

          <?php if ($cart_order_success && $payment_method === 'qr') { ?>
            <div class="checkout-panel payment-panel qr-panel">
              <div class="panel-header">
                <h3>Thông tin thanh toán QR</h3>
              </div>

              <div class="qr-box text-center">
                <p>Quý khách vui lòng quét mã QR dưới đây để thanh toán</p>
                <img src="<?php echo $qr_code_url; ?>" alt="QR thanh toán" class="qr-image" />
                <div class="amount-wrap">
                  <span>Số tiền</span>
                  <strong><?php echo number_format((float) $final_total, 0, ',', '.'); ?> VND</strong>
                </div>
                <p class="order-code">Mã đơn hàng: <strong>#<?php echo $latest_order_id; ?></strong></p>
              </div>
            </div>
          <?php } ?>

          <?php if (!$cart_order_success) { ?>
            <div class="checkout-panel form-panel">
              <div class="panel-header">
                <h3>Thông tin giao nhận</h3>
              </div>

              <form method="post" class="checkout-form">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Họ tên</label>
                    <input type="text" class="form-control form-control-lg" value="<?php echo htmlspecialchars($customer['HoTen'] ?? ''); ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control form-control-lg" name="dienthoai" value="<?php echo htmlspecialchars($customer['DienThoaiKH'] ?? ''); ?>" placeholder="Nhập số điện thoại">
                  </div>
                </div>

                <div class="mt-3">
                  <label class="form-label">Địa chỉ giao hàng</label>
                  <textarea class="form-control form-control-lg" rows="3" name="diachi" placeholder="Nhập địa chỉ nhận hàng chi tiết" required><?php echo htmlspecialchars($customer['DiaChiKH'] ?? ''); ?></textarea>
                </div>

                <div class="mt-4">
                  <?php if ($voucher_code !== '') { ?>
                    <div class="alert alert-success rounded-4 mb-3">
                      Đã áp dụng voucher: <strong><?php echo htmlspecialchars($voucher_code); ?></strong>
                    </div>
                  <?php } ?>
                  <label class="form-label">Phương thức thanh toán</label>
                  <div class="payment-options">
                    <label class="payment-option active" for="tienmat">
                      <input class="form-check-input" type="radio" name="phuong_thuc" id="tienmat" value="tienmat" checked>
                      <span>
                        <strong>Tiền mặt</strong>
                        <small>Thanh toán khi nhận hàng</small>
                      </span>
                    </label>

                    <label class="payment-option" for="qr">
                      <input class="form-check-input" type="radio" name="phuong_thuc" id="qr" value="qr">
                      <span>
                        <strong>Chuyển khoản QR</strong>
                        <small>Quét mã QR trước khi nhận hàng</small>
                      </span>
                    </label>
                  </div>
                </div>

                <div id="qrBox" class="alert alert-info mt-3 d-none mb-0 rounded-4">
                  <strong>QR thanh toán:</strong> bạn sẽ xem mã QR ngay sau khi xác nhận đặt hàng.
                </div>

                <div class="checkout-actions">
                  <a href="cart2.php" class="btn btn-outline-secondary btn-lg">Quay lại giỏ hàng</a>
                  <button type="submit" name="dathangne" class="btn btn-primary btn-lg">Xác nhận đặt hàng</button>
                </div>
              </form>
            </div>
          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="cart-empty">
          <span aria-hidden="true">🛍</span>
          <h2>Giỏ hàng đang trống</h2>
          <p>Chọn món ngon bạn thích, tụi mình chuẩn bị ngay.</p>
          <a class="btn btn-primary btn-lg" href="HienThiTatCaSanPham.php">Khám phá món ăn</a>
        </div>
      <?php } ?>
    </div>

    <?php include("Layout_KhachHang_Footer.php"); ?>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const qrRadio = document.getElementById('qr');
      const qrBox = document.getElementById('qrBox');
      const paymentOptions = document.querySelectorAll('.payment-option');

      const togglePaymentUI = function () {
        paymentOptions.forEach(function (option) {
          const input = option.querySelector('input');
          if (input && input.checked) {
            option.classList.add('active');
          } else {
            option.classList.remove('active');
          }
        });

        if (qrRadio && qrBox) {
          if (qrRadio.checked) {
            qrBox.classList.remove('d-none');
          } else {
            qrBox.classList.add('d-none');
          }
        }
      };

      paymentOptions.forEach(function (option) {
        option.addEventListener('click', function () {
          const input = option.querySelector('input');
          if (input) input.checked = true;
          togglePaymentUI();
        });
      });

      if (qrRadio) qrRadio.addEventListener('change', togglePaymentUI);
      const tienMatRadio = document.getElementById('tienmat');
      if (tienMatRadio) tienMatRadio.addEventListener('change', togglePaymentUI);
      togglePaymentUI();
    });
  </script>
</body>

</html>

<style>
  body {
    background: linear-gradient(180deg, #f5f3f0 0%, #f0f1f2 100%);
    color: #1f2937;
  }

  .checkout-page {
    padding: 20px 0 40px;
  }

  .page-top {
    margin-bottom: 24px;
  }

  .eyebrow {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(255, 126, 68, 0.10);
    color: #dc5a29;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .page-top h1 {
    margin-top: 12px;
    font-size: clamp(2rem, 3vw, 3rem);
    font-weight: 900;
    letter-spacing: -0.04em;
    color: #1a1a1a;
  }

  .checkout-shell {
    display: grid;
    grid-template-columns: 1.05fr 1.35fr;
    gap: 24px;
    align-items: start;
  }

  .checkout-panel {
    background: #fff;
    border: 1px solid rgba(176, 163, 146, 0.28);
    border-radius: 22px;
    box-shadow: 0 12px 28px rgba(58, 45, 35, 0.08);
    overflow: hidden;
  }

  .panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid #efe7dd;
    background: linear-gradient(180deg, #f5e7d3 0%, #f7f0e7 100%);
  }

  .panel-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 800;
    color: #1d1d1d;
  }

  .panel-header span {
    font-size: 0.9rem;
    color: #6e574e;
    font-weight: 700;
  }

  .cart-panel {
    padding-bottom: 12px;
  }

  .cart-item-row {
    display: grid;
    grid-template-columns: 78px 1.3fr auto auto;
    gap: 16px;
    align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid #f0e8df;
  }

  .product-thumb img {
    width: 78px;
    height: 78px;
    object-fit: cover;
    border-radius: 16px;
    border: 1px solid #ecd7bd;
    background: #f9f6f2;
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.4);
  }

  .product-info h4 {
    margin: 0 0 6px;
    font-size: 1rem;
    font-weight: 800;
    color: #212121;
  }

  .product-info p {
    margin: 0;
    color: #6d574c;
    font-size: 0.85rem;
  }

  .product-qty {
    color: #524641;
    font-weight: 700;
  }

  .product-total {
    font-weight: 900;
    color: #1f1f1f;
  }

  .order-summary {
    padding: 18px 22px 22px;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 1px solid #f0e8df;
    font-size: 1.05rem;
    color: #40352f;
  }

  .summary-row strong {
    color: #c5442a;
    font-weight: 900;
  }

  .summary-row.total-row {
    margin-top: 10px;
    padding-top: 16px;
    font-size: 1.2rem;
    font-weight: 800;
  }

  .form-panel,
  .payment-panel {
    padding-bottom: 18px;
  }

  .checkout-form {
    padding: 22px;
  }

  .form-label {
    font-weight: 800;
    color: #2a2827;
    margin-bottom: 8px;
  }

  .form-control {
    border: 1px solid #dad1c7;
    border-radius: 14px;
    box-shadow: none;
    background: #faf8f5;
    min-height: 46px;
    color: #1f1f1f;
    font-size: 1rem;
  }

  .form-control:focus {
    border-color: #d97b4e;
    box-shadow: 0 0 0 3px rgba(217,123,78,0.12);
    background: #fff;
  }

  textarea.form-control {
    min-height: 120px;
    resize: vertical;
  }

  .payment-options {
    display: grid;
    gap: 14px;
  }

  .payment-option {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 18px;
    border: 1px solid #dfe7f3;
    border-radius: 18px;
    background: #f8fbff;
    cursor: pointer;
    transition: 0.2s ease;
  }

  .payment-option.active {
    border-color: #3d9bff;
    background: rgba(61, 155, 255, 0.08);
    box-shadow: 0 0 0 3px rgba(61, 155, 255, 0.10);
  }

  .payment-option span {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .payment-option strong {
    color: #1d1d1d;
    font-size: 1.05rem;
  }

  .payment-option small {
    color: #5d615d;
  }

  .payment-option .form-check-input {
    width: 18px;
    height: 18px;
    margin-top: 0;
    accent-color: #1173ff;
  }

  .checkout-actions {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 28px;
  }

  .checkout-actions .btn {
    border-radius: 14px;
    padding: 14px 22px;
    font-weight: 800;
  }

  .btn-primary {
    background: linear-gradient(135deg, #d6502f 0%, #b73622 100%);
    border: none;
    box-shadow: 0 10px 20px rgba(183, 54, 34, 0.18);
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #c74828 0%, #9d2d1c 100%);
  }

  .btn-outline-secondary {
    border: 1px solid #d7d1cb;
    color: #3d3632;
    background: #fff;
    font-weight: 700;
  }

  .btn-outline-secondary:hover {
    background: #f5f1ec;
    color: #2e2927;
  }

  .qr-panel .qr-box {
    padding: 26px 20px 10px;
  }

  .qr-image {
    width: 220px;
    height: 220px;
    object-fit: cover;
    border-radius: 20px;
    border: 1px solid #e9e0d4;
    box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
    margin: 14px auto;
    background: #fff;
  }

  .amount-wrap {
    display: flex;
    justify-content: center;
    gap: 10px;
    align-items: center;
    margin-top: 8px;
    font-size: 1.08rem;
  }

  .amount-wrap strong {
    color: #b73b25;
    font-weight: 900;
  }

  .order-code {
    margin-top: 14px;
    color: #475569;
  }

  .cart-empty {
    text-align: center;
    padding: 80px 20px 40px;
    color: #475569;
  }

  .cart-empty span {
    display: block;
    font-size: 72px;
    margin-bottom: 18px;
  }

  .cart-empty h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #111827;
  }

  .cart-empty p {
    margin-bottom: 24px;
    font-size: 1.05rem;
  }

  @media (max-width: 920px) {
    .checkout-shell {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 560px) {
    .cart-item-row {
      grid-template-columns: 70px 1fr;
    }

    .product-qty,
    .product-total {
      grid-column: 2;
    }

    .checkout-actions {
      flex-direction: column;
    }

    .checkout-actions .btn {
      width: 100%;
    }
  }
</style>
