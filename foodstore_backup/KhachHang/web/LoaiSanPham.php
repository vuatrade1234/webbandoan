<style>
    /* thiết lập style cho thẻ a */
    .pagination a {
        color: black;

        padding: 12px 18px;
        text-decoration: none;
    }

    /* thiết lập style cho class active */
    .pagination a.active {
        background-color: dodgerblue;
        color: white;
        /*Thiết kế hình tròn với CSS*/
        border-radius: 50%;
    }

    /* thêm màu nền khi người dùng hover vào class không active */
    .pagination a:hover:not(.active) {
        background-color: #ddd;
        /*Thiết kế hình tròn với CSS*/
        border-radius: 50%;
    }

    #gia select {
        width: 200px;
        height: 38px;
        background-color: #fff;
        margin-bottom: 5px;
        border-radius: 5%;
        text-align: center;
        color: #333;
        cursor: pointer;
        border: none;
        border: 2px solid green;
    }

    #loc button {
        width: fit-content;
        padding: 0.5em 1em;
        text-align: center;
        float: inherit;
        margin: 0em auto;
        color: #ffffff;
        background: blue;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<body>
    <?php
    require 'Layout_KhachHang_Header.php';
    ?>



    <div></div>
    <form action="" method="get">
        <div>


            <div style="margin-left: 170px; margin-bottom: 10px;" id="gia">
                <ul>

                    <li><select name="timgia" id="timgia">

                            <option value="1">Tất cả</option>
                            <option value="2">0~1.000.000 VNĐ</option>
                            <option value="3">1.000.000VNĐ~2.000.000VNĐ</option>
                            <option value="4">>2.000.000VNĐ </option>
                        </select></li>

                </ul>
            </div>
            <div id="loc" style="margin-left: 170px; margin-bottom: 10px;">
                <button stype="submit">Lọc</button>
            </div>
        </div>
    </form>

    <?php

    if (isset($_GET['Ten']) && !empty($_GET['Ten'])) {
        $t = $_GET['Ten'];
        $per_page_record = 6;

        $query = "SELECT * FROM `giay` where HienThiSanPham=1 and (TenGiay like '%$t%' or GiaBan like '%$t%' ) ";

        $result = mysqli_query($con, $query);
        $number_of_result = mysqli_num_rows($result);
        $number_of_page = ceil($number_of_result / $per_page_record);
        if (isset($_GET['page'])) {

            $page  = $_GET['page'];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $per_page_record;

        $query = "SELECT * FROM `giay` where HienThiSanPham=1 and (TenGiay like '%$t%' or GiaBan like '%$t%' ) LIMIT $start_from,$per_page_record ";
        $result = mysqli_query($con, $query);
        $dem  = mysqli_query($con, "SELECT * FROM `giay` where HienThiSanPham=1 and (TenGiay like '%$t%' or GiaBan like '%$t%' ) ");
        $row = mysqli_num_rows($dem);
        echo "<p style='text-align:center; font-weight:bold'>" . "Có " . $row . " sản phẩm được tìm thấy" . "</p>";
    } else if (isset($_GET['timgia'])) {
        $t = $_GET['timgia'];
        if ($t == '2') {
            $per_page_record = 6;
            $query = "SELECT * FROM `giay` where HienThiSanPham=1 and GiaBan >0 and GiaBan < 1000000 ";
            $result = mysqli_query($con, $query);
            $number_of_result = mysqli_num_rows($result);
            $number_of_page = ceil($number_of_result / $per_page_record);
            if (isset($_GET['page'])) {

                $page  = $_GET['page'];
            } else {
                $page = 1;
            }
            $start_from = ($page - 1) * $per_page_record;

            $query = "SELECT * FROM `giay` where HienThiSanPham=1 and GiaBan >0 and GiaBan < 1000000 LIMIT $start_from,$per_page_record ";
            $result = mysqli_query($con, $query);
            $dem  = mysqli_query($con, "SELECT * FROM `giay` where HienThiSanPham=1 and GiaBan >0 and GiaBan < 1000000  ");
            $row = mysqli_num_rows($dem);
            echo "<p style='text-align:center; font-weight:bold'>" . "Có " . $row . " sản phẩm được tìm thấy" . "</p>";
        }
        if ($t == '3') {
            $per_page_record = 6;
            $query = "SELECT * FROM `giay` where HienThiSanPham=1 and GiaBan >=1000000 and GiaBan < 2000000 ";
            $result = mysqli_query($con, $query);
            $number_of_result = mysqli_num_rows($result);
            $number_of_page = ceil($number_of_result / $per_page_record);
            if (isset($_GET['page'])) {

                $page  = $_GET['page'];
            } else {
                $page = 1;
            }
            $start_from = ($page - 1) * $per_page_record;

            $query = "SELECT * FROM `giay` where HienThiSanPham=1 and GiaBan >=1000000 and GiaBan < 2000000  LIMIT $start_from,$per_page_record ";
            $result = mysqli_query($con, $query);
            $dem  = mysqli_query($con, "SELECT * FROM `giay` where HienThiSanPham=1 and GiaBan >=1000000 and GiaBan < 2000000  ");
            $row = mysqli_num_rows($dem);
            echo "<p style='text-align:center; font-weight:bold'>" . "Có " . $row . " sản phẩm được tìm thấy" . "</p>";
        }
        if ($t == '4') {
            $per_page_record = 6;
            $query = "SELECT * FROM `giay` where HienThiSanPham=1 and  GiaBan > 2000000 ";
            $result = mysqli_query($con, $query);
            $number_of_result = mysqli_num_rows($result);
            $number_of_page = ceil($number_of_result / $per_page_record);
            if (isset($_GET['page'])) {

                $page  = $_GET['page'];
            } else {
                $page = 1;
            }
            $start_from = ($page - 1) * $per_page_record;

            $query = "SELECT * FROM `giay` where HienThiSanPham=1 and  GiaBan > 2000000 LIMIT $start_from,$per_page_record ";
            $result = mysqli_query($con, $query);
            $dem  = mysqli_query($con, "SELECT * FROM `giay` where HienThiSanPham=1 and  GiaBan > 2000000  ");
            $row = mysqli_num_rows($dem);
            echo "<p style='text-align:center; font-weight:bold'>" . "Có " . $row . " sản phẩm được tìm thấy" . "</p>";
        }
        if ($t == '1') {
            $per_page_record = 6;
            $query = "SELECT * FROM `giay` where HienThiSanPham=1 ";
            $result = mysqli_query($con, $query);
            $number_of_result = mysqli_num_rows($result);
            $number_of_page = ceil($number_of_result / $per_page_record);
            if (isset($_GET['page'])) {

                $page  = $_GET['page'];
            } else {
                $page = 1;
            }
            $start_from = ($page - 1) * $per_page_record;

            $query = "SELECT * FROM `giay` where HienThiSanPham=1 LIMIT $start_from,$per_page_record ";
            $result = mysqli_query($con, $query);
            $dem  = mysqli_query($con, "SELECT * FROM `giay` where HienThiSanPham=1");
            $row = mysqli_num_rows($dem);
            echo "<p style='text-align:center; font-weight:bold'>" . "Có " . $row . " sản phẩm được tìm thấy" . "</p>";
        }
    } else {

        $per_page_record = 6;
        $query = "SELECT * FROM `giay` where HienThiSanPham=1";
        $result = mysqli_query($con, $query);
        $number_of_result = mysqli_num_rows($result);
        $number_of_page = ceil($number_of_result / $per_page_record);
        if (isset($_GET['page'])) {

            $page  = $_GET['page'];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $per_page_record;

        $query = "SELECT * FROM `giay` where HienThiSanPham=1 LIMIT $start_from,$per_page_record ";

        $result = mysqli_query($con, $query);
    }
    ?>

    <!----//End-bottom-header---->
    <!---//End-header---->
    <!--- start-content---->

    <div class="content product-box-main">
        <div class="wrap">
            <div class="content-left" style="width:120px;">
                <div class="content-left-top-brands">
                    <h3>DANH MỤC</h3>
                    <ul>
                        <?php while ($row = mysqli_fetch_array($result1)) { ?>
                            <li> <?php echo  "<a href='HienThiLoaiGiay.php?MaLG=" . $row['MaLG'] . " '>" . $row['TenLoaiGiay'] . "</a>" ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="content-right product-box" style="width:950px">
                <div class="product-box-head">
                    <div class="product-box-head-left">
                        <h3>SẢN PHẨM
                    </div>

                    <div class="clear"> </div>
                </div>
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
                                        starbox.Tiếp().text(' ' + val);
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
                <div class="clear"> </div>
            </div>
        </div>
        <div style="clear: both ;"></div>
        <div style="text-align:center">

            <div class="pagination">


                <?php

                if (isset($_GET['Ten']) && !empty($_GET['Ten'])) {
                    $pagLink = "";
                    if ($page >= 2) {

                        echo "<a href='LoaiSanPham.php?Ten=" . $_GET['Ten'] . "&page=" . ($page - 1) . "'>  Trước </a>";
                    }

                    for ($i = 1; $i <= $number_of_page; $i++) {

                        if ($i == $page) {

                            $pagLink .= "<a class = 'active' href='LoaiSanPham.php?Ten=" . $_GET['Ten'] . "&page="

                                . $i . "'>" . $i . "</a>";
                        } else {

                            $pagLink .= "<a href='LoaiSanPham.php?Ten=" . $_GET['Ten'] . "&page=" . $i . "'>
                 
                 " . $i . " </a>";
                        }
                    };
                    echo $pagLink;


                    if ($page < $number_of_page) {

                        echo "<a href='LoaiSanPham.php?page=" . ($page + 1) . "'>  Tiếp </a>";
                    }
                } else if (isset($_GET['timgia'])) {
                    $pagLink = "";
                    if ($page >= 2) {

                        echo "<a href='LoaiSanPham.php?timgia=" . $_GET['timgia'] . "&page=" . ($page - 1) . "'>  Trước </a>";
                    }

                    for ($i = 1; $i <= $number_of_page; $i++) {

                        if ($i == $page) {

                            $pagLink .= "<a class = 'active' href='LoaiSanPham.php?timgia=" . $_GET['timgia'] . "&page="

                                . $i . "'>" . $i . "</a>";
                        } else {

                            $pagLink .= "<a href='LoaiSanPham.php?timgia=" . $_GET['timgia'] . "&page=" . $i . "'>
                 
                 " . $i . " </a>";
                        }
                    };
                    echo $pagLink;


                    if ($page < $number_of_page) {

                        echo "<a href='LoaiSanPham.php?timgia=" . $_GET['timgia'] . "&page=" . ($page + 1) . "'>  Tiếp </a>";
                    }
                } else {
                    $pagLink = "";
                    if ($page >= 2) {

                        echo "<a href='LoaiSanPham.php?page=" . ($page - 1) . "'>  Trước </a>";
                    }

                    for ($i = 1; $i <= $number_of_page; $i++) {

                        if ($i == $page) {

                            $pagLink .= "<a class = 'active' href='LoaiSanPham.php?page="

                                . $i . "'>" . $i . "</a>";
                        } else {

                            $pagLink .= "<a href='LoaiSanPham.php?page=" . $i . "'>
                 
                 " . $i . " </a>";
                        }
                    };
                    echo $pagLink;


                    if ($page < $number_of_page) {

                        echo "<a href='LoaiSanPham.php?page=" . ($page + 1) . "'>  Tiếp </a>";
                    }
                }





                ?>
            </div>
        </div>
        <!---- start-bottom-grids---->
        <div class="bottom-grids">
            <div class="bottom-top-grids">
                <div class="wrap">
                    <!-- <div class="bottom-top-grid">
						<h4>ORDERS</h4>
						<ul>
							<li><a href="#">Payment options</a></li>
							<li><a href="#">Shipping and delivery</a></li>
							<li><a href="#">Returns</a></li>
						</ul>
					</div>
					<div class="bottom-top-grid last-bottom-top-grid">
						<h4>REGISTER</h4>
						<p>Create one account to manage everything you do with Nike, from your shopping preferences to your Nike+ activity.</p>
						<a class="learn-more" href="#">Learn more</a>
					</div> -->
                    <div class="clear"> </div>
                </div>
            </div>

        </div>
    </div>
    <!---- //End-bottom-grids---->
    <!--- //End-content---->
    <!---start-footer---->
    </div>
    <div></div>

    <?php include("Layout_KhachHang_Footer.php"); ?>


</body>

</html>