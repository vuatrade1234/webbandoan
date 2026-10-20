<body>
    <?php

    include("Layout_KhachHang_Header.php");

    if (isset($_GET['Ten']) && !empty($_GET['Ten'])) {
        $t = $_GET['Ten'];
        $query = "SELECT MaGiay,`TenGiay`, `GiaBan`,GiaBanCu, `AnhBia`,TenLoaiGiay FROM `giay`,loaigiay where loaigiay.MaLG= giay.MaLG and  GiaBan > 1000000 and HienThiSanPham=1 and (TenGiay like '%$t%' or GiaBan like '%$t%' )";
        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);
        echo "<p style='text-align:center; font-weight:bold'>" . "Có " . $row . " sản phẩm được tìm thấy" . "</p>";
    } else {
        $query = "SELECT MaGiay,`TenGiay`, `GiaBan`,GiaBanCu, `AnhBia`,TenLoaiGiay FROM `giay`,loaigiay where loaigiay.MaLG= giay.MaLG and  GiaBan > 1000000  and HienThiSanPham=1";
        $result = mysqli_query($con, $query);
    }


    ?>
    <form action="" method="post">
        <!---start-wrap---->
        <!---start-header---->

        <!----//End-bottom-header---->
        <!---//End-header---->
        <!----start-image-slider---->
        <div class="img-slider">
            <div class="wrap">
                <ul id="jquery-demo">
                    <li>
                        <a href="#slide1">
                            <img src="images/slide-1.jpg" alt="" />
                        </a>
                        <div class="slider-detils">
                            <h3>BÓNG ĐÁ NAM <label>GIÀY</label></h3>
                            <span>
                                Mọi trận đấu đều quan trọng như đôi giày đang mang</span>
                        </div>
                    </li>
                    <li>
                        <a href="#slide2">
                            <img src="images/slide-4.jpg" alt="" />
                        </a>
                        <div class="slider-detils">
                            <h3>BÓNG ĐÁ NAM <label>GIÀY</label></h3>
                            <span>
                                Mọi trận đấu đều quan trọng như đôi giày đang mang</span>
                        </div>
                    </li>
                    <li>
                        <a href="#slide3">
                            <img src="images/slide-1.jpg" alt="" />
                        </a>
                        <div class="slider-detils">

                            <h3>BÓNG ĐÁ NAM <label>GIÀY</label></h3>
                            <span>
                                Mọi trận đấu đều quan trọng như đôi giày đang mang</span>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"> </div>
        <!----//End-image-slider---->
        <!----start-price-rage--->
        <div class="wrap">
            <div class="price-rage">
                <h3>MẶT HÀNG GIÁ CAO NHẤT:</h3>
                <div id="slider-range">
                </div>
            </div>
        </div>
        <!----//End-price-rage--->
        <!--- start-content---->
        <div class="content">
            <div class="wrap">

                <style>
                    /* a {
                        flex-direction: column;
                        flex-wrap: wrap;
                    } */
                </style>
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
                                <div style="cursor: pointer; display:flex;flex-direction: column;" onclick="location.href='details.php?MaGiay=<?php echo $row['MaGiay'] ?>';" class="product-grid fade">
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

                                        <?php echo "<a href='details.php?MaGiay=" . $row['MaGiay'] . " '>" ?>
                                        <?php echo '<img class="hinh" src="../../Images/ImgProducts/' . $row['AnhBia'] . '" width="200px" height="150px">'; ?>
                                        <?php "</a>" ?>
                                        <style>
                                            .hinh {
                                                flex-shrink: 0;
                                            }
                                        </style>
                                        <p class="p" style="display:flex;flex-direction: column;flex:1">

                                            <?php echo "<a style='display:flex;flex-direction: column;flex:1'  href='details.php?MaGiay=" . $row['MaGiay'] . " '>" .  $row['TenGiay'] . "</a>" ?>

                                            <span style="color:blue;text-decoration-line:line-through;margin-top:auto"><?php echo number_format($row['GiaBanCu'], 0, ',', '.')  . ' VNĐ' ?></span>


                                        </p>
                                    </div>
                                    <div class="product-info" style="margin-top:auto">
                                        <div class="product-info-cust">
                                            <?php echo "<a href='details.php?MaGiay=" . $row['MaGiay'] . " '>" . 'Chi Tiết' . "</a>" ?>
                                        </div>
                                        <div class="product-info-price">
                                            <?php echo "<a href='details.php?MaGiay=" . $row['MaGiay'] . " '>" . number_format($row['GiaBan'], 0, ',', '.') . 'Đ' . "</a>" ?>
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

        </div>
        <div></div>
        <div></div>
        <?php include("Layout_KhachHang_Footer.php"); ?>

    </form>

</body>

</html>