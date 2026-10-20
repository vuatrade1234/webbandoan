<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<style>
    .mid-grid-left {
        display: none;
    }
</style>

<body>
    <?php
    include("./Layout_KhachHang_Header.php");
    $MaLoaiSP = isset($_GET['MaLSP']) ? (int) $_GET['MaLSP'] : 0;
    $cateQuery = mysqli_query($con, "SELECT TenLoaiSP FROM loaisanpham WHERE MaLSP = '$MaLoaiSP'");
    $cateRow = mysqli_fetch_assoc($cateQuery);
    $categoryName = $cateRow['TenLoaiSP'] ?? 'Danh mục sản phẩm';

    $query = "SELECT s.MaSP AS MaSP, s.TenSP AS TenSP, s.GiaBan, s.GiaBanCu, s.AnhBia, l.TenLoaiSP AS TenLoaiSP
              FROM sanpham s
              JOIN loaisanpham l ON s.MaLSP = l.MaLSP
              WHERE s.MaLSP = '$MaLoaiSP' AND s.HienThiSanPham = 1
              ORDER BY s.MaSP DESC";
    $result = mysqli_query($con, $query);
    ?>

    <!----//End-bottom-header---->
    <!---//End-header---->
    <!----start-image-slider---->
    <div class="clear"> </div>
    <!----//End-image-slider---->
    <!----start-price-rage--->

    <!----//End-price-rage--->
    <!--- start-content---->
    <ul class="product-head" style="width:985px; margin-left:190px">
        <li><a href="HienThiTatCaSanPham.php">SẢN PHẨM</a> <span>::</span></li>
        <li class="active-page"><a href="#"><?php echo htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8'); ?></a></li>
        <div class="clear"> </div>
    </ul>
    <div class="content">
        <div class="wrap">
            <div class="content-right">
                <div class="product-grids" style="display:flex;flex-wrap: wrap;">
                    <!--- start-rate---->
                    <script src="js/jstarbox.js"></script>
                    <link rel="stylesheet" href="css/jstarbox.css" type="text/css" media="screen" charset="utf-8" />
                    <script type="text/javascript">
                        jQuery(function() {
                            jQuery('.starbox').each(function() {
                                var starbox = jQuery(this);
                                starbox.starbox({
                                    average: starbox.attr('data-start-value'),
                                    changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
                                    ghosting: starbox.hasClass('ghosting'),
                                    autoUpdateAverage: starbox.hasClass('autoupdate'),
                                    buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
                                    stars: starbox.attr('data-star-count') || 5
                                }).bind('starbox-value-changed', function(event, value) {
                                    if (starbox.hasClass('random')) {
                                        var val = Math.random();
                                        starbox.next().text(' ' + val);
                                        return val;
                                    }
                                })
                            });
                        });
                    </script>

                    <!---//End-rate---->
                    <!---caption-script---->
                    <!---//caption-script---->
                    <style>
                        s {
                            flex-direction: column;
                        }
                    </style>
                    <?php if (mysqli_num_rows($result) != 0) { ?>
                        <?php while ($row = mysqli_fetch_array($result)) { ?>
                            <div style="cursor: pointer; display:flex;flex-direction: column;" onclick="location.href='details.php?MaSP=<?php echo $row['MaSP'] ?>';" class="product-grid fade">
                                <div class="product-grid-head">
                                    <ul class="grid-social">
                                        <li><a class="facebook" href="#"><span> </span></a></li>
                                        <li><a class="twitter" href="#"><span> </span></a></li>
                                        <li><a class="googlep" href="#"><span> </span></a></li>
                                        <div class="clear"> </div>
                                    </ul>
                                    <div class="block">
                                        <div class="starbox small ghosting"> </div> <span> (46)</span>
                                    </div>
                                </div>

                                <div class="product-pic" style="display:flex;flex-direction: column;flex:1">

                                    <?php echo "<a href='details.php?MaSP=" . $row['MaSP'] . " '>" ?>
                                    <?php echo '<img class="hinh" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80" width="200px" height="150px" alt="Món ăn vặt">'; ?>
                                    <?php "</a>" ?>
                                    <style>
                                        .hinh {
                                            flex-shrink: 0;
                                        }
                                    </style>
                                    <p class="p" style="display:flex;flex-direction: column;flex:1">

                                        <?php echo "<a style='display:flex;flex-direction: column;flex:1'  href='details.php?MaSP=" . $row['MaSP'] . " '>" .  $row['TenSP'] . "</a>" ?>

                                        <span style="color:blue;text-decoration-line:line-through;margin-top:auto"><?php echo number_format($row['GiaBanCu'], 0, ',', '.')  . ' VNĐ' ?></span>


                                    </p>
                                </div>
                                <div class="product-info" style="margin-top:auto">
                                    <div class="product-info-cust">
                                        <?php echo "<a href='details.php?MaSP=" . $row['MaSP'] . " '>" . 'Chi tiết' . "</a>" ?>
                                    </div>
                                    <div class="product-info-price">
                                        <?php echo "<a href='details.php?MaSP=" . $row['MaSP'] . " '>" . number_format($row['GiaBan'], 0, ',', '.') . 'Đ' . "</a>" ?>
                                    </div>
                                    <div class="clear"> </div>
                                </div>


                            </div>
                        <?php    } ?>
                    <?php } ?>
                </div>
            </div>

            <!---- //End-bottom-grids---->
            <!--- //End-content---->
            <!---start-footer---->
        </div>
        <div></div>
        <div></div>
        <?php include("Layout_KhachHang_Footer.php"); ?>
</body>

</html>