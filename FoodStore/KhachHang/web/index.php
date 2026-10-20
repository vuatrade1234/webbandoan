<body>
    <?php

    include("Layout_KhachHang_Header.php");

    $searchTerm = isset($_GET['Ten']) && is_string($_GET['Ten']) ? trim($_GET['Ten']) : '';
    $itemsPerPage = 8;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    $whereSql = "WHERE loaisanpham.MaLSP = sanpham.MaLSP AND sanpham.HienThiSanPham = 1";
    if ($searchTerm !== '') {
        $searchTermSafe = mysqli_real_escape_string($con, $searchTerm);
        $whereSql .= " AND (sanpham.TenSP LIKE '%$searchTermSafe%' OR sanpham.GiaBan LIKE '%$searchTermSafe%')";
    }

    $countQuery = "SELECT COUNT(*) AS total FROM sanpham, loaisanpham $whereSql";
    $countResult = mysqli_query($con, $countQuery);
    $totalProducts = $countResult && mysqli_num_rows($countResult) > 0 ? (int) mysqli_fetch_assoc($countResult)['total'] : 0;
    $totalPages = max(1, (int) ceil($totalProducts / $itemsPerPage));
    $page = min($page, $totalPages);
    $offset = ($page - 1) * $itemsPerPage;

    $query = "SELECT sanpham.MaSP, sanpham.TenSP, sanpham.GiaBan, sanpham.GiaBanCu, sanpham.AnhBia, loaisanpham.TenLoaiSP
              FROM sanpham, loaisanpham
              $whereSql
              ORDER BY sanpham.MaSP DESC
              LIMIT $offset, $itemsPerPage";
    $result = mysqli_query($con, $query);

    if ($searchTerm !== '') {
        echo "<p style='text-align:center; font-weight:bold'>Có " . $totalProducts . " sản phẩm được tìm thấy</p>";
    }

    ?>
    <form action="" method="post">
        <style>
            .snack-hero {
                background: linear-gradient(135deg, #fff5e6 0%, #ffe0b2 35%, #fff8ef 100%);
                border: 1px solid rgba(255, 166, 0, 0.18);
                border-radius: 26px;
                box-shadow: 0 16px 35px rgba(196, 112, 0, 0.12);
                overflow: hidden;
                margin: 14px auto !important;
                padding: 22px 28px !important;
            }

            .snack-hero-inner {
                display: flex;
                align-items: center;
                gap: 22px;
                padding: 0;
            }

            .snack-hero-copy {
                flex: 1.2;
            }

            .snack-hero-copy .badge {
                display: inline-block;
                background: #ff8a00;
                color: white;
                font-size: 12px;
                letter-spacing: 1px;
                padding: 7px 12px;
                border-radius: 999px;
                font-weight: 700;
                text-transform: uppercase;
            }

            .snack-hero-copy h2 {
                font-size: 2em;
                line-height: 1.1;
                color: #3a2d25;
                margin: 8px 0;
                font-weight: 800;
            }

            .snack-hero-copy h2 span {
                color: #ef6c00;
            }

            .snack-hero-copy p {
                color: #5e4c42;
                font-size: 0.95em;
                line-height: 1.5;
                margin-bottom: 12px;
            }

            .snack-hero-cta {
                display: inline-flex;
                align-items: center;
                padding: 10px 16px;
                border-radius: 5px;
                background: #b51d1a;
                color: #fff;
                font-weight: 700;
                text-decoration: none;
            }

            .snack-hero-cta:hover {
                background: #8f1715;
                color: #fff;
                text-decoration: none;
            }

            .category-strip {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 8px;
            }

            .category-pill {
                background: #fff;
                border: 1px solid #f2d7b2;
                color: #7f4e1c;
                padding: 8px 12px;
                border-radius: 999px;
                font-size: 0.8em;
                font-weight: 700;
            }

            .feature-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
                margin: 8px 0 26px;
            }

            .feature-box {
                background: white;
                border: 1px solid #f3e0c7;
                border-radius: 18px;
                padding: 18px 16px;
                text-align: center;
                box-shadow: 0 10px 24px rgba(145, 88, 15, 0.06);
            }

            .feature-box .emoji {
                font-size: 2em;
                display: block;
                margin-bottom: 8px;
            }

            .feature-box h4 {
                font-weight: 800;
                color: #513522;
                font-size: 1.1em;
                margin-bottom: 6px;
            }

            .feature-box p {
                color: #72584a;
                font-size: 0.87em;
                line-height: 1.6;
            }

            .section-title {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 12px 0 16px;
            }

            .section-title h3 {
                font-size: 1.8em;
                color: #3b2b21;
                font-weight: 800;
            }

            .section-title a {
                color: #f67200;
                font-weight: 700;
            }

            .product-grid {
                background: #fff;
                border: 1px solid #f6e3c8;
                border-radius: 20px;
                padding: 12px;
                box-shadow: 0 12px 18px rgba(120, 75, 22, 0.04);
                transition: all 0.25s ease;
            }

            .product-grid:hover {
                transform: translateY(-5px);
                box-shadow: 0 18px 30px rgba(244, 132, 18, 0.14);
                border-color: #ffbf69;
            }

            .product-pic img {
                border-radius: 14px;
                object-fit: cover;
                border: 1px solid #f7e7d8;
                background: #fffaf5;
            }

            .product-info {
                border-top: 1px solid #f6e7d8;
                padding-top: 12px;
                margin-top: 10px;
            }

            .product-info-cust a,
            .product-info-price a {
                font-weight: 700;
                color: #f26f00;
            }

            .product-info-price a {
                color: #1f9d4b;
                font-size: 1.1em;
            }

            .product-grid p a {
                color: #3d2b22;
                font-weight: 700;
                line-height: 1.4;
            }

            .old-price {
                color: #9a8d82;
                text-decoration: line-through;
                font-size: 0.87em;
            }

            @media (max-width: 768px) {
                .snack-hero-inner {
                    flex-direction: column;
                }

                .feature-grid {
                    grid-template-columns: 1fr;
                }

                .section-title {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 8px;
                }
            }
        </style>

        <div class="wrap snack-hero" style="background: linear-gradient(135deg,#fff7ef 0%,#ffe4b5 20%,#f7f0ea 100%); border: 1px solid rgba(180, 33, 25, 0.17);">
            <div class="snack-hero-inner">
                <div class="snack-hero-copy">
                    <span class="badge" style="background:linear-gradient(90deg,#cf1e21,#ef5a2a);">Chu Chu Shop</span>
                    <h2 style="color:#3f1d17;">Ăn vặt <span style="color:#c72022;">đúng gu</span></h2>
                    <p style="color:#5c413d;">Món ngon chọn lọc, đóng gói chỉn chu, giao nhanh tận nhà.</p>
                    <a class="snack-hero-cta" href="HienThiTatCaSanPham.php">Xem sản phẩm</a>
                </div>
            </div>
        </div>

        <div class="wrap">
            <div class="feature-grid">
                <div class="feature-box" style="background: linear-gradient(180deg,#fffaf5,#fff); border-color: #f9d4b8;">
                    <span class="emoji">🍿</span>
                    <h4>Hàng hóa</h4>
                    <p>Luôn tươi ngon, thơm giòn, đặc sản xứng đáng cho mỗi bữa nhâm nhi.</p>
                </div>
                <div class="feature-box" style="background: linear-gradient(180deg,#fffaf5,#fff); border-color: #f9d4b8;">
                    <span class="emoji">🚚</span>
                    <h4>Giao hàng</h4>
                    <p>Nhanh chóng, tiết kiệm, đúng giờ cho mọi đơn hàng nội thành.</p>
                </div>
                <div class="feature-box" style="background: linear-gradient(180deg,#fffaf5,#fff); border-color: #f9d4b8;">
                    <span class="emoji">💬</span>
                    <h4>Tư vấn</h4>
                    <p>Chu đáo, tận tâm, sẵn sàng hỗ trợ bạn chọn món phù hợp nhất.</p>
                </div>
            </div>
        </div>

        <div class="wrap" style="margin: 8px auto 22px;">
            <div style="background: linear-gradient(90deg,#7d1d1a 0%,#c21a1d 38%,#ef5d2e 100%); border-radius: 20px; padding: 18px 24px; color: #fff; display: flex; justify-content: space-between; align-items: center; gap: 16px; box-shadow: 0 18px 32px rgba(180,31,23,.2);">
                <div>
                    <div style="font-size: 12px; letter-spacing: 2px; opacity: .85; text-transform: uppercase;">Flash sale</div>
                    <div style="font-size: 1.7em; font-weight: 800; margin-top: 4px;">Mua 2, giảm 15% cho combo ăn vặt</div>
                </div>
                <a href="HienThiTatCaSanPham.php" style="display:inline-block; background:#fff; color:#b51d1a; text-decoration:none; padding:10px 18px; border-radius:999px; font-weight:800;">Mua ngay</a>
            </div>
        </div>

        <!-- DANH MỤC NỔI BẬT ĐÃ ĐƯỢC CẬP NHẬT CÓ THỂ BẤM ĐƯỢC -->
        <div class="wrap" style="margin-bottom: 20px;">
            <div class="section-title">
                <h3>Danh mục nổi bật</h3>
            </div>
            <div style="display:grid; grid-template-columns: repeat(5, minmax(0,1fr)); gap: 14px;">
                <a href="HienThiTatCaSanPham.php?Ten=Bánh+tráng" style="background:#fff7ef; border:1px solid #f8d7af; border-radius:18px; padding:18px 12px; text-align:center; font-weight:700; color:#6a3421; text-decoration:none; display:block; transition:all 0.2s ease;" onmouseover="this.style.background='#ffe8cc'" onmouseout="this.style.background='#fff7ef'">🥨 Bánh tráng</a>
                
                <a href="HienThiTatCaSanPham.php?Ten=Khô+gà" style="background:#fff7ef; border:1px solid #f8d7af; border-radius:18px; padding:18px 12px; text-align:center; font-weight:700; color:#6a3421; text-decoration:none; display:block; transition:all 0.2s ease;" onmouseover="this.style.background='#ffe8cc'" onmouseout="this.style.background='#fff7ef'">🍗 Khô gà</a>
                
                <a href="HienThiTatCaSanPham.php?Ten=Rong+biển" style="background:#fff7ef; border:1px solid #f8d7af; border-radius:18px; padding:18px 12px; text-align:center; font-weight:700; color:#6a3421; text-decoration:none; display:block; transition:all 0.2s ease;" onmouseover="this.style.background='#ffe8cc'" onmouseout="this.style.background='#fff7ef'">🧂 Rong biển</a>
                
                <a href="HienThiTatCaSanPham.php?Ten=Cơm+cháy" style="background:#fff7ef; border:1px solid #f8d7af; border-radius:18px; padding:18px 12px; text-align:center; font-weight:700; color:#6a3421; text-decoration:none; display:block; transition:all 0.2s ease;" onmouseover="this.style.background='#ffe8cc'" onmouseout="this.style.background='#fff7ef'">🥟 Cơm cháy</a>
                
                <a href="HienThiTatCaSanPham.php?Ten=Kẹo" style="background:#fff7ef; border:1px solid #f8d7af; border-radius:18px; padding:18px 12px; text-align:center; font-weight:700; color:#6a3421; text-decoration:none; display:block; transition:all 0.2s ease;" onmouseover="this.style.background='#ffe8cc'" onmouseout="this.style.background='#fff7ef'">🍬 Kẹo & mứt</a>
            </div>
        </div>

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
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1400&q=80" alt="Food dish" />
                        </a>
                        <div class="slider-detils">
                            <h3>THIÊN ĐƯỜNG <label>ĂN VẶT</label></h3>
                            <span>
                                Bánh tráng phơi sương, khô gà cay xé lưỡi, giòn tan đậm vị</span>
                        </div>
                    </li>
                    <li>
                        <a href="#slide2">
                            <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?auto=format&fit=crop&w=1200&q=80" alt="Đặc sản" />
                        </a>
                        <div class="slider-detils">
                            <h3>ĐẶC SẢN 3 MIỀN <label>CHÍNH HÃNG</label></h3>
                            <span>
                                Cơm cháy chà bông, rong biển tỏi ớt, hạt dinh dưỡng sấy giòn</span>
                        </div>
                    </li>
                    <li>
                        <a href="#slide3">
                            <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?auto=format&fit=crop&w=1200&q=80" alt="Snack nội địa" />
                        </a>
                        <div class="slider-detils">

                            <h3>SNACK NỘI ĐỊA <label>SIÊU CAY</label></h3>
                            <span>
                                Cay tê kích thích vị giác - Giao hàng siêu tốc tận nơi</span>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"> </div>
        <!----//End-image-slider---->
        <!--- start-content---->
        <div class="content">
            <div class="wrap">
                <div class="section-title">
                    <h3>Món ăn vặt hot</h3>
                    <a href="HienThiTatCaSanPham.php">Xem tất cả</a>
                </div>
                <div class="content-right">
                    <div class="product-grids" style="display:flex;flex-wrap: wrap; gap: 18px;">
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
                                <div style="cursor: pointer; display:flex;flex-direction: column;" onclick="location.href='details.php?MaSP=<?php echo $row['MaSP'] ?>';" class="product-grid fade snack-card">
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
                                        <?php 
                                        $picName = $row['AnhBia'] ?? '';
                                        $picPath = (!empty($picName) && file_exists('../../Images/ImgProducts/' . $picName)) 
                                            ? '../../Images/ImgProducts/' . $picName 
                                            : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80';
                                        ?>
                                        <?php echo "<a href='details.php?MaSP=" . $row['MaSP'] . " '>" ?>
                                        <?php echo '<img class="hinh" src="' . htmlspecialchars($picPath, ENT_QUOTES, 'UTF-8') . '" width="200px" height="150px" style="object-fit:cover;" alt="' . htmlspecialchars($row['TenSP'], ENT_QUOTES, 'UTF-8') . '">'; ?>
                                        <?php "</a>" ?>
                                        <style>
                                            .hinh {
                                                flex-shrink: 0;
                                            }
                                        </style>
                                        <p class="p" style="display:flex;flex-direction: column;flex:1">
                                            <?php echo "<a style='display:flex;flex-direction: column;flex:1'  href='details.php?MaSP=" . $row['MaSP'] . " '>" .  $row['TenSP'] . "</a>" ?>
                                            <span class="old-price"><?php echo number_format($row['GiaBanCu'], 0, ',', '.')  . ' VNĐ' ?></span>
                                        </p>
                                    </div>
                                    <div class="product-info" style="margin-top:auto">
                                        <div class="product-info-cust">
                                            <?php echo "<a href='details.php?MaSP=" . $row['MaSP'] . " '>" . 'Chi Tiết' . "</a>" ?>
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

        </div>

        <div class="wrap" style="text-align:center; margin: 18px auto 28px;">
            <?php if ($totalPages > 1) { ?>
                <div class="pagination" style="display:inline-flex; gap:8px; flex-wrap:wrap; justify-content:center; align-items:center;">
                    <?php
                    $baseParams = $_GET;
                    unset($baseParams['page']);
                    $queryString = http_build_query($baseParams);
                    $separator = $queryString === '' ? '' : '&';

                    if ($page > 1) {
                        $prevUrl = 'index.php' . ($queryString !== '' ? '?' . $queryString . $separator . 'page=' . ($page - 1) : '?page=' . ($page - 1));
                        echo '<a href="' . htmlspecialchars($prevUrl, ENT_QUOTES, 'UTF-8') . '" style="display:inline-block; min-width:38px; padding:10px 14px; border:1px solid #f3d1a7; border-radius:999px; background:#fff; color:#522f24; font-weight:700; text-decoration:none;">&laquo; Trước</a>';
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        $pageUrl = 'index.php' . ($queryString !== '' ? '?' . $queryString . $separator . 'page=' . $i : '?page=' . $i);
                        $currentClass = $i === $page ? 'active' : '';
                        echo '<a class="' . $currentClass . '" href="' . htmlspecialchars($pageUrl, ENT_QUOTES, 'UTF-8') . '" style="display:inline-block; min-width:38px; padding:10px 12px; border:1px solid #f3d1a7; border-radius:999px; background:' . ($i === $page ? '#d93a29' : '#fff') . '; color:' . ($i === $page ? '#fff' : '#522f24') . '; font-weight:700; text-decoration:none;">' . $i . '</a>';
                    }

                    if ($page < $totalPages) {
                        $nextUrl = 'index.php' . ($queryString !== '' ? '?' . $queryString . $separator . 'page=' . ($page + 1) : '?page=' . ($page + 1));
                        echo '<a href="' . htmlspecialchars($nextUrl, ENT_QUOTES, 'UTF-8') . '" style="display:inline-block; min-width:38px; padding:10px 14px; border:1px solid #f3d1a7; border-radius:999px; background:#fff; color:#522f24; font-weight:700; text-decoration:none;">Sau &raquo;</a>';
                    }
                    ?>
                </div>
            <?php } ?>
        </div>

        <div></div>
        <div></div>
        <?php include("Layout_KhachHang_Footer.php"); ?>

    </form>

</body>

</html>