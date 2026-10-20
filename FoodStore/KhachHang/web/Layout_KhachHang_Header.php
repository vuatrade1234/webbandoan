<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Tiệm Đồ Ăn Vặt SnackStore - Nhóm 11</title>

  <link href="css/style.css" rel='stylesheet' type='text/css' />
  <link href="css/snack-theme.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="application/x-javascript">
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  </script>
  <!----webfonts---->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <!----//webfonts---->
  <!----start-alert-scroller---->
  <script src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.easy-ticker.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#demo').hide();
      $('.vticker').easyTicker();
    });
  </script>
  <!----start-alert-scroller---->
  <!-- start menu -->
  <link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
  <script type="text/javascript" src="js/megamenu.js"></script>
  <script>
    $(document).ready(function() {
      $(".megamenu").megamenu();
    });
  </script>
  <script src="js/menu_jquery.js"></script>
  <!-- //End menu -->
  <!---slider---->
  <link rel="stylesheet" href="css/slippry.css">
  <script src="js/jquery-ui.js" type="text/javascript"></script>
  <script src="js/scripts-f0e4e0c2.js" type="text/javascript"></script>
  <script>
    jQuery('#jquery-demo').slippry({
      // general elements & wrapper
      slippryWrapper: '<div class="sy-box jquery-demo" />', // wrapper to wrap everything, including pager
      // options
      adaptiveHeight: false, // height of the sliders adapts to current slide
      useCSS: false, // true, false -> fallback to js if no browser support
      autoHover: false,
      transition: 'fade'
    });
  </script>
  <!----start-pricerage-seletion---->
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
  <script type='text/javascript'>
    //<![CDATA[
    $(window).load(function() {
      $("#slider-range").slider({
        range: true,
        min: 0,
        max: 500,
        values: [100, 400],
        slide: function(event, ui) {
          $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
      });
      $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values",
        1));

    }); //]]>
  </script>
  <!----//End-pricerage-seletion---->
  <!---move-top-top---->
  <script type="text/javascript" src="js/move-top.js"></script>
  <script type="text/javascript" src="js/easing.js"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".scroll").click(function(event) {
        event.preventDefault();
        $('html,body').animate({
          scrollTop: $(this.hash).offset().top
        }, 1200);
      });
    });
  </script>
  <!---//move-top-top---->
  <style>
    .header-search-wrap {
      display: flex;
      align-items: center;
      width: 100%;
      max-width: 520px;
      border: 2px solid rgba(185, 106, 35, 0.75);
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.92);
      box-shadow: 0 14px 26px rgba(180, 93, 25, 0.12);
      overflow: hidden;
    }

    .header-search-wrap input {
      flex: 1;
      border: none;
      outline: none;
      background: transparent;
      color: #3a2d25;
      font-size: 15px;
      padding: 15px 18px;
    }

    .header-search-wrap button {
      border: none;
      background: linear-gradient(135deg, #f29d4a, #c9422b);
      color: #fff;
      font-weight: 800;
      padding: 15px 22px;
      cursor: pointer;
      transition: 0.2s ease;
      min-width: 70px;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.18);
    }

    .header-search-wrap button:hover {
      background: linear-gradient(135deg, #ee8e35, #b93620);
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
      justify-content: flex-end;
      margin-left: auto;
    }

    .header-cart-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #d65a2b 0%, #7a2d1d 100%);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.18);
      padding: 9px 16px;
      border-radius: 999px;
      text-decoration: none;
      font-weight: 800;
      transition: 0.2s ease;
      box-shadow: 0 10px 18px rgba(122, 45, 29, 0.22);
    }

    .header-cart-btn:hover {
      background: linear-gradient(135deg, #c84c1e 0%, #692413 100%);
      text-decoration: none;
      color: #fff;
    }

    .user-dropdown-wrap {
      position: relative;
      display: inline-flex;
      align-items: center;
    }

    .user-dropdown-wrap .dropdown {
      position: relative;
      display: flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, #d65a2b 0%, #7a2d1d 100%);
      border: 1px solid rgba(255,255,255,0.18);
      border-radius: 999px;
      padding: 5px 12px 5px 6px;
      color: #fff;
      cursor: pointer;
      box-shadow: 0 10px 18px rgba(122, 45, 29, 0.22);
    }

    .user-dropdown-wrap img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.35);
    }

    .user-dropdown-wrap .nut_dropdown {
      background: transparent;
      border: none;
      color: #fff;
      font-weight: 800;
      max-width: 150px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      padding: 0;
    }

    .user-dropdown-wrap .noidung_dropdown {
      display: none;
      position: absolute;
      top: calc(100% - 1px);
      right: 0;
      min-width: 190px;
      background: #fff;
      border: 1px solid #eef2f7;
      border-radius: 14px;
      box-shadow: 0 18px 35px rgba(31,41,55,0.15);
      z-index: 999;
      overflow: hidden;
    }

    .user-dropdown-wrap .noidung_dropdown a {
      display: block;
      padding: 12px 14px;
      color: #1f2937;
      text-decoration: none;
      border-bottom: 1px solid #f1f5f9;
      font-weight: 600;
    }

    .user-dropdown-wrap .noidung_dropdown a:last-child {
      border-bottom: none;
    }

    .user-dropdown-wrap:hover .noidung_dropdown,
    .user-dropdown-wrap:focus-within .noidung_dropdown {
      display: block;
    }

    .top-header-custom {
      background: linear-gradient(180deg, #f7f0ea 0%, #f9f3ef 100%);
      border-bottom: 1px solid rgba(166, 100, 41, 0.25);
      box-shadow: 0 10px 20px rgba(106, 61, 30, 0.06);
    }

    .top-header-custom .wrap {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      min-height: 88px;
    }

    .brand-mini {
      display: flex;
      align-items: center;
      gap: 14px;
      min-width: 190px;
      color: inherit;
      text-decoration: none;
    }

    .brand-mini:hover {
      color: inherit;
      text-decoration: none;
    }

    .brand-badge {
      width: 64px;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      border: 2px solid #d9a86d;
      background: linear-gradient(135deg, #fffaf4 0%, #f6dfca 100%);
      box-shadow: 0 8px 18px rgba(186, 133, 63, 0.12);
      font-size: 2rem;
    }

    .brand-copy {
      display: flex;
      flex-direction: column;
      gap: 2px;
      color: #8a4d2b;
      line-height: 1.1;
    }

    .brand-copy strong {
      font-size: 1.75rem;
      letter-spacing: 0.08em;
      font-weight: 800;
    }

    .brand-copy small {
      font-size: 0.72rem;
      letter-spacing: 0.18em;
      opacity: 0.8;
    }

    .header-search-shell {
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: min(100%, 430px);
      flex: 1;
    }

    .link-auth {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      padding: 0 18px;
      border-radius: 999px;
      background: linear-gradient(135deg, #d65a2b, #7a2d1d);
      color: #fff;
      text-decoration: none;
      font-weight: 800;
      box-shadow: 0 10px 18px rgba(122, 45, 29, 0.2);
    }

    .link-auth:hover {
      color: #fff;
      text-decoration: none;
      background: linear-gradient(135deg, #c84c1e, #692413);
    }

    .voucher-notice-backdrop {
      position: fixed;
      inset: 0;
      z-index: 1000000;
      display: grid;
      place-items: center;
      padding: 18px;
      background: rgba(40, 25, 19, 0.58);
    }

    .voucher-notice-panel {
      position: relative;
      width: min(560px, 100%);
      max-height: min(82vh, 720px);
      overflow: auto;
      padding: 28px;
      border-radius: 12px;
      background: #fffaf3;
      color: #3a2d25;
      box-shadow: 0 24px 70px rgba(31, 18, 10, 0.32);
    }

    .voucher-notice-panel h2 {
      margin: 4px 42px 8px 0;
      color: #7a2d1d;
      font-size: 25px;
    }

    .voucher-notice-kicker {
      color: #b84b2b;
      font-size: 12px;
      font-weight: 800;
      text-transform: uppercase;
    }

    .voucher-notice-close {
      position: absolute;
      top: 14px;
      right: 14px;
      width: 36px;
      height: 36px;
      border: 0;
      border-radius: 50%;
      background: #f4e5d8;
      color: #54291e;
      font-size: 22px;
      cursor: pointer;
    }

    .voucher-notice-list {
      display: grid;
      gap: 10px;
      margin: 18px 0 0;
      padding: 0;
      list-style: none;
    }

    .voucher-notice-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      padding: 14px;
      border: 1px solid #efd8c0;
      border-left: 4px solid #c64d2b;
      border-radius: 8px;
      background: #fff;
    }

    .voucher-notice-code {
      color: #7a2d1d;
      font-size: 17px;
      font-weight: 900;
      letter-spacing: 0;
    }

    .voucher-notice-meta {
      margin-top: 3px;
      color: #69584d;
      font-size: 13px;
    }

    .voucher-notice-use {
      flex: 0 0 auto;
      border: 0;
      border-radius: 6px;
      padding: 9px 12px;
      background: #a63c2a;
      color: #fff;
      font-weight: 800;
      cursor: pointer;
    }

    .voucher-open-btn {
      border: 1px solid #a63c2a;
      border-radius: 999px;
      padding: 9px 14px;
      background: #fffaf3;
      color: #7a2d1d;
      font-weight: 800;
      cursor: pointer;
    }

    .voucher-open-btn:hover {
      background: #f7e5d6;
    }

    @media (max-width: 520px) {
      .voucher-notice-panel { padding: 22px 16px; }
      .voucher-notice-item { align-items: flex-start; flex-direction: column; }
    }

    @media (max-width: 980px) {
      .top-header-custom .wrap {
        flex-wrap: wrap;
        justify-content: center;
        padding: 12px 0;
      }

      .brand-mini {
        order: 1;
        min-width: unset;
      }

      .header-search-shell {
        order: 3;
        width: 100%;
      }

      .header-actions {
        order: 2;
        width: auto;
        justify-content: flex-end;
      }
    }

    @media (max-width: 820px) {
      .mid-grid-left {
        display: block !important;
        width: 100%;
        margin-bottom: 12px;
      }

      .mid-header .wrap {
        display: block;
      }

      .header-actions {
        justify-content: center;
        flex-wrap: wrap;
      }

      .brand-copy strong {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>
  <?php

  include("connection.php");

  $query1 = "SELECT * FROM loaisanpham";
  $result1 = mysqli_query($con, $query1);

  $availableCustomerVouchers = [];
  $showVoucherNotice = false;
  if (!empty($_SESSION['MaKH'])) {
    include_once("voucher_helper.php");
    if ((int) ($_SESSION['voucher_schema_ready'] ?? 0) < 2) {
      ensure_voucher_schema($con);
      $_SESSION['voucher_schema_ready'] = 2;
    }

    $availableCustomerVouchers = get_available_vouchers_for_customer($con, (int) $_SESSION['MaKH']);
    if (!empty($availableCustomerVouchers) && empty($_SESSION['voucher_notice_seen'])) {
      $showVoucherNotice = true;
      $_SESSION['voucher_notice_seen'] = true;
    }
  }
  ?>

  <!---start-wrap---->
  <!---start-header---->
  <div class="header">
    <div class="top-header top-header-custom">
      <div class="wrap">
        <a class="brand-mini" href="index.php" aria-label="Chu Chu Shop - Trang chủ">
          <div class="brand-badge">🍰</div>
          <div class="brand-copy">
            <strong>CHU CHU SHOP</strong>
            <small>ĐỒ ĂN VẶT</small>
          </div>
        </a>


        <div class="header-actions">
          <?php
          if (isset($_SESSION['MaKH'])) {
            $MaKH = $_SESSION["MaKH"];
            $qr = "select * from KhachHang where MaKH = '$MaKH'";
            $qr_run = mysqli_query($con, $qr);
            $r = mysqli_fetch_array($qr_run);
          ?>
            <a class="header-cart-btn" href="cart2.php" title="Giỏ hàng">
              <span>🛒</span>
              <span>Giỏ hàng</span>
            </a>
            <button type="button" class="voucher-open-btn" onclick="document.getElementById('voucherNotice').style.display='grid'">
              Voucher (<?php echo count($availableCustomerVouchers); ?>)
            </button>

            <div class="user-dropdown-wrap">
              <div class="dropdown">
                <img src="./imgKH/<?php echo $r["AnhKH"] ?>" alt="<?php echo $r["AnhKH"] ?>">
                <button class="nut_dropdown"><?php echo $r["HoTen"] ?></button>
              </div>
              <div class="noidung_dropdown">
                <a href="profileKH.php">Xem thông tin</a>
                <a href="orderlist.php">Xem đơn hàng</a>
                <a href="history_Cart.php">Xem lịch sử</a>
                <a href="changepwd.php">Đổi mật khẩu</a>
                <a href="logout.php">Đăng xuất</a>
              </div>
            </div>
          <?php
          } else {
          ?>
            <a class="link-auth" href="login.php">Đăng nhập</a>
            <a class="link-auth" href="register.php">Đăng ký</a>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

    <!----start-mid-head---->
    <div class="mid-header" style="padding-top: 0; background: linear-gradient(90deg,#f8e8e5 0%,#f4e5e1 100%); border-bottom: 1px solid rgba(166,100,41,.2);">
      <div class="wrap">
        <div class="mid-grid-left" style="display:none;"></div>
        <div class="mid-grid-right" style="width:100%; text-align:center; padding: 16px 0 12px;">
          <a class="logo" href="index.php" aria-label="Chu Chu Shop" style="display:inline-flex; align-items:center; justify-content:center; gap:12px;">
            <span class="logo-mark" style="font-size: 2.2rem;">🍿</span>
            <span class="logo-text" style="display:inline-flex; flex-direction:column; align-items:flex-start; color:#a63c2a;">
              <strong style="font-size:2.6rem; line-height:1; font-family:'Segoe Print', 'Comic Sans MS', cursive; font-style:italic;">Chu Chu Shop</strong>
              <small style="font-size:1.6rem; letter-spacing:0.22em; color:#7c4a2b;">Đồ ăn vặt nhà làm</small>
            </span>
          </a>
        </div>
        <div class="clear"> </div>
      </div>
    </div>
    <!----//End-mid-head---->
    <!----start-bottom-header---->
    <div class="header-bottom" style="background: linear-gradient(90deg,#fff5df,#fff8ef 45%,#feeddb 100%); border-bottom: 1px solid #f4d0a1;">
      <div class="wrap" style="margin-bottom:20px ;">

        <ul class="megamenu skyblue" style="display:flex; justify-content:center; gap:18px; padding:12px 0;">
          <li class="grid"><a class="color2" href="index.php" style="color:#7a1d1b; font-weight:700;">TRANG CHỦ</a></li>
          <li class="grid"><a class="color2" href="HienThiTatCaSanPham.php" style="color:#7a1d1b; font-weight:700;">SẢN PHẨM</a></li>
          <li class="grid"><a class="color2" href="mohom_csgo.php" style="color:#d93a29; font-weight:800;">🎁 MỞ HÒM CS:GO</a></li>
          <li class="grid"><a class="color2" href="contact.php" style="color:#7a1d1b; font-weight:700;">LIÊN HỆ</a></li>
          <li class="grid"><a class="color2" href="VeChungToi.php" style="color:#7a1d1b; font-weight:700;">VỀ CHÚNG TÔI</a></li>
        </ul>
      </div>
    </div>

  </div>
  <?php if (!empty($_SESSION['MaKH'])) { ?>
    <div class="voucher-notice-backdrop" id="voucherNotice" role="dialog" aria-modal="true" aria-labelledby="voucherNoticeTitle" style="display:<?php echo $showVoucherNotice ? 'grid' : 'none'; ?>" onclick="if (event.target === this) this.style.display='none'">
      <section class="voucher-notice-panel">
        <button type="button" class="voucher-notice-close" aria-label="Đóng thông báo" onclick="document.getElementById('voucherNotice').style.display='none'">&times;</button>
        <span class="voucher-notice-kicker">Ưu đãi dành riêng cho bạn</span>
        <h2 id="voucherNoticeTitle">Bạn có <?php echo count($availableCustomerVouchers); ?> voucher</h2>
        <?php if (!empty($availableCustomerVouchers)) { ?>
          <p>Chọn dùng ngay để đưa mã vào giỏ hàng, không cần nhập mã thủ công.</p>
          <ul class="voucher-notice-list">
            <?php foreach ($availableCustomerVouchers as $availableVoucher) { ?>
              <li class="voucher-notice-item">
                <div>
                  <div class="voucher-notice-code"><?php echo htmlspecialchars($availableVoucher['MaCode'], ENT_QUOTES, 'UTF-8'); ?></div>
                  <div><?php echo htmlspecialchars($availableVoucher['TenVoucher'], ENT_QUOTES, 'UTF-8'); ?> ·
                    <?php echo $availableVoucher['LoaiGiam'] === 'fixed' ? number_format((float) $availableVoucher['GiaTri'], 0, ',', '.') . 'đ' : rtrim(rtrim(number_format((float) $availableVoucher['GiaTri'], 2, '.', ''), '0'), '.') . '%'; ?>
                  </div>
                  <div class="voucher-notice-meta">
                    Đơn tối thiểu <?php echo number_format((float) $availableVoucher['DieuKienDonToiThieu'], 0, ',', '.'); ?>đ
                    <?php if (!empty($availableVoucher['NgayKetThuc'])) { ?> · Hạn <?php echo date('d/m/Y', strtotime($availableVoucher['NgayKetThuc'])); ?><?php } ?>
                  </div>
                </div>
                <form action="cart2.php" method="post">
                  <input type="hidden" name="voucher_code" value="<?php echo htmlspecialchars($availableVoucher['MaCode'], ENT_QUOTES, 'UTF-8'); ?>">
                  <button class="voucher-notice-use" type="submit" name="apply_voucher" value="1">Dùng ngay</button>
                </form>
              </li>
            <?php } ?>
          </ul>
        <?php } else { ?>
          <p>Hiện chưa có voucher còn hiệu lực phù hợp với tài khoản của bạn. Ưu đãi mới sẽ hiển thị tại đây.</p>
        <?php } ?>
      </section>
    </div>
  <?php } ?>
  <!----//End-bottom-header---->
  <!---//End-header---->
  <!----start-image-slider---->
  <div class="clear"> </div>
  <!----//End-image-slider---->
  <!----start-price-rage--->

  <!----//End-price-rage--->
  <!--- start-content---->
  <div></div>
  <div></div>


</body>

</html>
<style>
  /* Nút Dropdown*/
  .nut_dropdown {
    background: transparent;
    color: #fff;
    font-size: 16px;
    border: none;
    font-weight: 700;
  }

  /* Thiết lập vị trí cho thẻ div với class dropdown*/
  .dropdown {
    position: absolute;
    display: inline-block;
    z-index: 100000;
  }

  /* Nội dung Dropdown */
  .noidung_dropdown {
    /*Ẩn nội dụng các đường dẫn*/
    display: none;
    position: absolute;
    color: black;
    background: white;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);


  }


  /* Thiết kế style cho các đường dẫn tronng Dropdown */
  .noidung_dropdown a {
    color: #3d2a24;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-weight: 700;
  }

  /* thay đổi màu background khi hover vào đường dẫn */
  .noidung_dropdown a:hover {
    background: linear-gradient(135deg, #fff2db, #f5d5b9);
    color: #7a2d1d;
  }

  /* hiển thị nội dung dropdown khi hover */

  /* Thay đổi màu background cho nút khi được hover */
  .dropdown:hover .noidung_dropdown {
    display: block;
    z-index: 1000000000000;
  }

  /*Dùng Để hiển thị nội dung*/
  .hienThi {
    display: block;
  }

  .o {

    top: 12px;
    position: absolute;
    right: 230px;
  }

  .o img {
    width: 20px;
    height: 20px;
    border-radius: 50%;

  }
</style>