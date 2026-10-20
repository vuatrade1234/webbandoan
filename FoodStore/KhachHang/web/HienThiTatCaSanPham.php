<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->


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

    .advanced-search {
        display: grid;
        grid-template-columns: minmax(220px, 2fr) repeat(3, minmax(140px, 1fr)) auto;
        gap: 12px;
        align-items: end;
        max-width: 1200px;
        margin: 26px auto 10px;
        padding: 18px 20px;
        background: linear-gradient(180deg, #fffaf5 0%, #fff0e4 100%);
        border: 1px solid #f1d2b3;
        border-radius: 24px;
        box-shadow: 0 18px 32px rgba(169, 87, 28, 0.08);
    }

    .advanced-search label {
        display: block;
        margin-bottom: 7px;
        color: #7f3e2d;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.02em;
    }

    .advanced-search input,
    .advanced-search select {
        box-sizing: border-box;
        width: 100%;
        min-height: 46px;
        padding: 10px 12px;
        border: 1px solid #e4c6a3;
        border-radius: 14px;
        background: #fff;
        color: #3a2a24;
        outline: none;
    }

    .advanced-search input:focus,
    .advanced-search select:focus {
        border-color: #d67230;
        box-shadow: 0 0 0 3px rgba(210, 112, 48, 0.12);
    }

    .advanced-search button {
        min-height: 46px;
        padding: 10px 22px;
        border: 0;
        border-radius: 14px;
        background: linear-gradient(135deg, #bf2d23 0%, #de5d2e 100%);
        color: #fff;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 12px 18px rgba(190, 65, 32, 0.15);
    }

    .search-summary {
        margin: 8px auto 18px;
        text-align: center;
        font-weight: 800;
        color: #7d2f27;
        letter-spacing: 0.02em;
    }

    @media (max-width: 760px) {
        .advanced-search {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin: 18px 12px 8px;
        }

        .advanced-search .search-keyword {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 420px) {
        .advanced-search {
            grid-template-columns: 1fr;
        }

        .advanced-search .search-keyword {
            grid-column: auto;
        }
    }
</style>

<body>
    <?php
    require 'Layout_KhachHang_Header.php';
    ?>
    <?php
    $keyword = isset($_GET['Ten']) && is_string($_GET['Ten']) ? trim($_GET['Ten']) : '';
    $minInput = isset($_GET['gia_tu']) && is_scalar($_GET['gia_tu']) ? trim((string)$_GET['gia_tu']) : '';
    $maxInput = isset($_GET['gia_den']) && is_scalar($_GET['gia_den']) ? trim((string)$_GET['gia_den']) : '';
    $minPrice = $minInput === '' ? null : filter_var($minInput, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $maxPrice = $maxInput === '' ? null : filter_var($maxInput, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $minPrice = $minPrice === false ? null : $minPrice;
    $maxPrice = $maxPrice === false ? null : $maxPrice;

    if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
        [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        [$minInput, $maxInput] = [(string)$minPrice, (string)$maxPrice];
    }

    $categoryId = isset($_GET['MaLSP']) && is_scalar($_GET['MaLSP']) ? filter_var($_GET['MaLSP'], FILTER_VALIDATE_INT) : 0;
    $categoryId = $categoryId && $categoryId > 0 ? $categoryId : 0;

    $brandId = isset($_GET['MaTH']) && is_scalar($_GET['MaTH']) ? filter_var($_GET['MaTH'], FILTER_VALIDATE_INT) : 0;
    $brandId = $brandId && $brandId > 0 ? $brandId : 0;

    $sort = isset($_GET['sap_xep']) && is_string($_GET['sap_xep']) ? $_GET['sap_xep'] : 'newest';
    $sortOptions = [
        'newest' => 'MaSP DESC',
        'price_asc' => 'GiaBan ASC',
        'price_desc' => 'GiaBan DESC',
        'name' => 'TenSP ASC'
    ];
    if (!isset($sortOptions[$sort])) {
        $sort = 'newest';
    }

    $per_page_record = 6;
    $filterSql = " WHERE HienThiSanPham = 1
        AND (? = '' OR TenSP LIKE CONCAT('%', ?, '%'))
        AND (? IS NULL OR GiaBan >= ?)
        AND (? IS NULL OR GiaBan <= ?)
        AND (? = 0 OR MaLSP = ?)
        AND (? = 0 OR MaTH = ?)";
    $countStatement = mysqli_prepare($con, "SELECT COUNT(*) AS total FROM sanpham" . $filterSql);
    mysqli_stmt_bind_param($countStatement, 'ssiiiiiiii', $keyword, $keyword, $minPrice, $minPrice, $maxPrice, $maxPrice, $categoryId, $categoryId, $brandId, $brandId);
    mysqli_stmt_execute($countStatement);
    $countResult = mysqli_stmt_get_result($countStatement);
    $totalProducts = (int)mysqli_fetch_assoc($countResult)['total'];
    mysqli_stmt_close($countStatement);

    $number_of_page = max(1, (int)ceil($totalProducts / $per_page_record));
    $page = isset($_GET['page']) && is_scalar($_GET['page']) ? filter_var($_GET['page'], FILTER_VALIDATE_INT) : 1;
    $page = $page && $page > 0 ? min($page, $number_of_page) : 1;
    $start_from = ($page - 1) * $per_page_record;

    $productStatement = mysqli_prepare($con, "SELECT * FROM sanpham" . $filterSql . " ORDER BY " . $sortOptions[$sort] . " LIMIT ?, ?");
    mysqli_stmt_bind_param($productStatement, 'ssiiiiiiiiii', $keyword, $keyword, $minPrice, $minPrice, $maxPrice, $maxPrice, $categoryId, $categoryId, $brandId, $brandId, $start_from, $per_page_record);
    mysqli_stmt_execute($productStatement);
    $result = mysqli_stmt_get_result($productStatement);

    $categoryResult = mysqli_query($con, "SELECT MaLSP, TenLoaiSP FROM loaisanpham ORDER BY TenLoaiSP");
    $brandResult = mysqli_query($con, "SELECT MaTH, TenTH FROM thuonghieu ORDER BY TenTH");
    $snackProductImage = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80';
    ?>
    <a style="margin-left:200px;font-size:13px" href="LoaiSanPham.php">LOẠI SẢN PHẨM/</a><a style="font-size:14px" href="#">TẤT CẢ SẢN PHẨM</a>

    <form class="advanced-search" action="HienThiTatCaSanPham.php" method="get">
        <div class="search-keyword">
            <label for="search-keyword">Từ khóa</label>
            <input id="search-keyword" type="search" name="Ten" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Tên món ăn, sản phẩm...">
        </div>
        <div>
            <label for="search-min-price">Giá từ (VNĐ)</label>
            <input id="search-min-price" type="number" name="gia_tu" min="0" step="1000" value="<?php echo htmlspecialchars($minInput, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Tối thiểu">
        </div>
        <div>
            <label for="search-max-price">Giá đến (VNĐ)</label>
            <input id="search-max-price" type="number" name="gia_den" min="0" step="1000" value="<?php echo htmlspecialchars($maxInput, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Tối đa">
        </div>
        <div>
            <label for="search-category">Danh mục</label>
            <select id="search-category" name="MaLSP">
                <option value="0">Tất cả danh mục</option>
                <?php while ($category = mysqli_fetch_assoc($categoryResult)) { ?>
                    <option value="<?php echo (int)$category['MaLSP']; ?>" <?php echo $categoryId === (int)$category['MaLSP'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['TenLoaiSP'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="search-brand">Thương hiệu</label>
            <select id="search-brand" name="MaTH">
                <option value="0">Tất cả thương hiệu</option>
                <?php if ($brandResult) { while ($brand = mysqli_fetch_assoc($brandResult)) { ?>
                    <option value="<?php echo (int)$brand['MaTH']; ?>" <?php echo $brandId === (int)$brand['MaTH'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($brand['TenTH'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php } } ?>
            </select>
        </div>
        <div>
            <label for="search-sort">Sắp xếp</label>
            <select id="search-sort" name="sap_xep">
                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Giá tăng dần</option>
                <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Giá giảm dần</option>
                <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Tên A-Z</option>
            </select>
        </div>
        <button type="submit">Tìm sản phẩm</button>
    </form>
    <p class="search-summary">Tìm thấy <?php echo $totalProducts; ?> sản phẩm phù hợp</p>

    <!---start-wrap---->
    <!---start-header---->
    <!----//End-bottom-header---->
    <!---//End-header---->
    <!----start-image-slider---->
    <div class="clear"> </div>
    <!----//End-image-slider---->
    <!----start-price-rage--->

    <!----//End-price-rage--->
    <!--- start-content---->
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

                                    <?php 
                                    $picName = $row['AnhBia'] ?? '';
                                    $picPath = (!empty($picName) && file_exists('../../Images/ImgProducts/' . $picName)) 
                                        ? '../../Images/ImgProducts/' . $picName 
                                        : $snackProductImage;
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

                                        <span style="color:blue;text-decoration-line:line-through;margin-top:auto"><?php echo number_format($row['GiaBanCu'], 0, ',', '.')  . ' VNĐ' ?></span>


                                    </p>
                                </div>
                                <div class="product-info" style="margin-top:auto">
                                    <div class="product-info-cust">
                                        <?php echo "<a href='details.php?MaSP=" . $row['MaSP'] . " '>" . 'Details' . "</a>" ?>
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
            <div style="clear: both ;"></div>
            <div style="text-align:center">

                <div class="pagination">
                    <?php
                    if ($number_of_page > 1) {
                        if ($page > 1) {
                            $prevParams = $_GET;
                            $prevParams['page'] = $page - 1;
                            $prevUrl = 'HienThiTatCaSanPham.php?' . http_build_query($prevParams);
                            echo '<a href="' . htmlspecialchars($prevUrl, ENT_QUOTES, 'UTF-8') . '">&laquo; Trước</a>';
                        }

                        for ($i = 1; $i <= $number_of_page; $i++) {
                            $pageParams = $_GET;
                            $pageParams['page'] = $i;
                            $pageUrl = 'HienThiTatCaSanPham.php?' . http_build_query($pageParams);
                            $activeClass = $i === $page ? 'active' : '';
                            echo '<a class="' . $activeClass . '" href="' . htmlspecialchars($pageUrl, ENT_QUOTES, 'UTF-8') . '">' . $i . '</a>';
                        }

                        if ($page < $number_of_page) {
                            $nextParams = $_GET;
                            $nextParams['page'] = $page + 1;
                            $nextUrl = 'HienThiTatCaSanPham.php?' . http_build_query($nextParams);
                            echo '<a href="' . htmlspecialchars($nextUrl, ENT_QUOTES, 'UTF-8') . '">Sau &raquo;</a>';
                        }
                    }
                    ?>
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