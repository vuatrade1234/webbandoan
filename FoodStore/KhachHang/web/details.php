<style>
  .mid-grid-left {
    display: none;
  }

  .custom select {
    width: 108px;
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

  .mau button {
    outline: none;
    border: none;
    width: 15px;
    padding: 15px;
    cursor: pointer;
  }

  .product-colors label {
    width: 30px;
    height: 30px;
    cursor: pointer;
  }

  .product-colors label.Hien {
    border: 3px solid #333;
  }

  .product-colors input {
    display: none;
  }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<body>
  <?php
  include("Layout_KhachHang_Header.php");
  include("../../ProductPricing.php");

  // Ưu tiên nhận tham số MaSP, nếu không có thì nhận MaSP để tương thích ngược link cũ
  $MaSP = isset($_GET['MaSP']) ? $_GET['MaSP'] : (isset($_GET['MaSP']) ? $_GET['MaSP'] : 0);

  $query = "SELECT s.MaSP, s.TenSP, s.GiaBan, s.AnhBia, s.MoTa, s.GiaBanCu, s.SoLuongTon, s.MaLSP, s.QuyCach, s.ViHuong,
                   l.TenLoaiSP, ncc.TenNCC, th.TenTH
            FROM sanpham s
            LEFT JOIN loaisanpham l ON l.MaLSP = s.MaLSP
            LEFT JOIN nhacungcap ncc ON ncc.MaNCC = s.MaNCC
            LEFT JOIN thuonghieu th ON th.MaTH = s.MaTH
            WHERE s.MaSP = '$MaSP' AND s.HienThiSanPham = 1";

  $result = mysqli_query($con, $query);

  if (isset($_POST['submit_cart'])) {
    if (isset($_SESSION["MaKH"])) {
      $MaKH = $_SESSION["MaKH"];
      $size = $_POST["size"];
      $mau = $_POST["mau"];
      $giohang = "INSERT INTO giohang (MaKH, MaSP, TrangThai, soluong, QuyCach, ViHuong) VALUES ('$MaKH', '$MaSP', 1, 1, '$size', '$mau')";
      $giohang_trung = "SELECT * FROM giohang WHERE MaKH = '$MaKH' AND MaSP = '$MaSP' AND QuyCach = '$size' AND ViHuong = '$mau'";
      $giohang_trung_result = mysqli_query($con, $giohang_trung);
      $row = mysqli_fetch_array($giohang_trung_result);
      if (mysqli_num_rows($giohang_trung_result) != 0) {
        $soluongmoi = $row["soluong"] + 1;
        $u = "UPDATE giohang SET soluong = '$soluongmoi' WHERE MaKH = '$MaKH' AND MaSP = '$MaSP' AND QuyCach = '$size' AND ViHuong = '$mau';";
        mysqli_query($con, $u);
        echo "<script>alert('Thêm vào giỏ hàng thành công!!!');</script>";
      } else {
        mysqli_query($con, $giohang);
        echo "<script>alert('Thêm vào giỏ hàng thành công!!!');</script>";
      }
    } else {
      echo "<script>alert('Vui lòng đăng nhập!!!'); location = './login.php';</script>";
    }
  }

  if (mysqli_num_rows($result) == 0) {
    echo '<div class="wrap" style="padding: 40px 20px; text-align:center; color:#7a2d1d; font-weight:700;">Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.</div>';
    include("Layout_KhachHang_Footer.php");
    exit;
  }

  $product = mysqli_fetch_assoc($result);
  $sizeOptions = parse_size_price_map($product['QuyCach'], (int) $product['GiaBan']);
  $defaultSelectedSize = $sizeOptions !== [] ? array_key_first($sizeOptions) : trim((string) $product['QuyCach']);
  $defaultSelectedPrice = get_selected_size_price($product['QuyCach'], $defaultSelectedSize, (int) $product['GiaBan']);
  $imageDirectory = __DIR__ . '/../../Images/ImgProducts/';
  $productNameBase = pathinfo($product['AnhBia'], PATHINFO_FILENAME);
  $legacyGalleryPattern = preg_replace('/_Loai\d+$/', '', $productNameBase) . '*.jpg';
  $galleryFiles = array_merge(
    [$imageDirectory . $product['AnhBia']],
    glob($imageDirectory . 'product_' . (int) $product['MaSP'] . '_*') ?: [],
    glob($imageDirectory . $legacyGalleryPattern) ?: []
  );
  $galleryFiles = array_values(array_unique(array_map(function ($file) {
    return basename($file);
  }, $galleryFiles)));

  $sizes = array_map('trim', explode(',', $product['QuyCach']));
  $flavors = array_map('trim', explode(',', $product['ViHuong']));

  $suggestQuery = "SELECT * FROM sanpham WHERE HienThiSanPham = 1 AND MaSP != '$MaSP' AND MaLSP = '{$product['MaLSP']}' ORDER BY NgayCapNhat DESC LIMIT 4";
  $suggestResult = mysqli_query($con, $suggestQuery);
  if (mysqli_num_rows($suggestResult) == 0) {
    $suggestQuery = "SELECT * FROM sanpham WHERE HienThiSanPham = 1 AND MaSP != '$MaSP' ORDER BY NgayCapNhat DESC LIMIT 4";
    $suggestResult = mysqli_query($con, $suggestQuery);
  }

  mysqli_query($con, "
    CREATE TABLE IF NOT EXISTS `danhgia` (
      `MaDG` int NOT NULL AUTO_INCREMENT,
      `MaSP` int NOT NULL,
      `MaKH` int NULL DEFAULT NULL,
      `TenNguoiDG` varchar(100) NOT NULL,
      `SoSao` int NOT NULL DEFAULT 5,
      `NoiDung` text NOT NULL,
      `NgayDG` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`MaDG`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  ");

  if (isset($_POST['submit_review'])) {$reviewerName = trim($_POST['reviewer_name'] ?? '');$reviewerRating = max(1, min(5, (int) ($_POST['reviewer_rating'] ?? 5)));$reviewerComment = trim($_POST['reviewer_comment'] ?? '');$reviewerCustId = isset($_SESSION['MaKH']) ? (int)$_SESSION['MaKH'] : null;

    if ($reviewerName === '' && isset($_SESSION['HoTen'])) {
      $reviewerName =$_SESSION['HoTen'];
    }

    if ($reviewerName !== '' && $reviewerComment !== '') {$safeName = mysqli_real_escape_string($con,$reviewerName);
      $safeComment = mysqli_real_escape_string($con, $reviewerComment);$khVal = $reviewerCustId ? "'$reviewerCustId'" : "NULL";
      mysqli_query($con, "INSERT INTO danhgia (MaSP, MaKH, TenNguoiDG, SoSao, NoiDung, NgayDG) VALUES ('$MaSP', $khVal, '$safeName', '$reviewerRating', '$safeComment', NOW())");
      echo "<script>alert('Cảm ơn bạn đã gửi đánh giá món ăn!'); location.href='details.php?MaSP=$MaSP';</script>";
      exit;
    }
  }

  $reviews = [];
  $dbReviews = mysqli_query($con, "SELECT * FROM danhgia WHERE MaSP = '$MaSP' ORDER BY NgayDG DESC");
  if ($dbReviews && mysqli_num_rows($dbReviews) > 0) {
    while ($rev = mysqli_fetch_assoc($dbReviews)) {$reviews[] = [
        'name' => $rev['TenNguoiDG'],
        'rating' => (int) $rev['SoSao'],
        'text' => $rev['NoiDung'],
        'date' => date('d/m/Y', strtotime($rev['NgayDG']))
      ];
    }
  } else {
    $reviews = [
      ['name' => 'Ngọc Ánh', 'rating' => 5, 'text' => 'Món ăn rất ngon, hương vị đậm đà, nhân viên phục vụ tốt. Sẽ quay lại mua tiếp.', 'date' => '05/08/2026'],
      ['name' => 'Minh Khang', 'rating' => 4, 'text' => 'Bánh tráng giòn, sốt béo nhưng hơi cay với mình. Vị rất hợp khẩu vị.', 'date' => '02/08/2026'],
      ['name' => 'Linh Đan', 'rating' => 5, 'text' => 'Dịch vụ nhanh, đồ ăn thơm và tươi. Mình thích nhất là vị phô mai cay.', 'date' => '28/07/2026']
    ];
  }
  $avgRating = array_sum(array_map(function ($review) { return$review['rating']; }, $reviews)) / count($reviews);
  $mainProductImageSrc = (!empty($product['AnhBia']) && file_exists($imageDirectory .$product['AnhBia']))
    ? '../../Images/ImgProducts/' . $product['AnhBia']
    : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80';
  ?>

  <div class="content details-page">
    <div class="product-details">
      <div class="wrap">
        <ul class="product-head">
          <li><a href="index.php">Trang chủ</a> <span>::</span></li>
          <li><a href="HienThiTatCaSanPham.php">Sản phẩm</a> <span>::</span></li>
          <li class="active-page"><?php echo htmlspecialchars($product['TenSP'], ENT_QUOTES, 'UTF-8'); ?></li>
          <div class="clear"> </div>
        </ul>

        <div class="detail-product-wrapper" style="padding: 24px 0 10px;">
          <div class="detail-gallery" style="display:flex; gap:18px; align-items:flex-start;">
            <div class="detail-main-image" style="flex: 1; max-width: 520px; background: #fffaf5; border: 1px solid #f0d9b8; border-radius: 20px; padding: 16px; box-shadow: 0 16px 28px rgba(142, 89, 35, 0.08);">
              <img src="<?php echo htmlspecialchars($mainProductImageSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['TenSP'], ENT_QUOTES, 'UTF-8'); ?>" style="width:100%; height: 420px; object-fit: cover; border-radius: 16px; display:block; background:#f9efe7;" id="mainProductImage">
            </div>
            <div class="detail-gallery-list" style="width: 120px; display:flex; flex-direction:column; gap:12px;">
              <?php foreach ($galleryFiles as$index => $galleryFile) {$gSrc = file_exists($imageDirectory .$galleryFile) ? '../../Images/ImgProducts/' . $galleryFile :$mainProductImageSrc;
              ?>
                <img src="<?php echo htmlspecialchars($gSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="Ảnh sản phẩm <?php echo $index + 1; ?>" style="width:100%; height: 90px; object-fit: cover; border-radius: 12px; border: 2px solid #e8d3b6; background:#fff; cursor:pointer; <?php echo $index === 0 ? 'border-color:#d36a2d;' : ''; ?>" class="thumb-image" data-image="<?php echo htmlspecialchars($gSrc, ENT_QUOTES, 'UTF-8'); ?>">
              <?php } ?>
            </div>
          </div>

          <div class="detail-info" style="flex: 1; background: #fffaf5; border: 1px solid #f0d9b8; border-radius: 20px; padding: 24px; box-shadow: 0 16px 28px rgba(142, 89, 35, 0.08);">
            <div style="display:flex; align-items:center; flex-wrap:wrap; gap:8px; color:#a75b2a; font-weight:700; margin-bottom:12px;">
              <span style="display:inline-block; background:#fff1d9; border:1px solid #f5d5a3; color:#8a4d2b; border-radius:999px; padding:5px 12px; font-size:12px; text-transform:uppercase; letter-spacing:0.08em;">
                📁 <?php echo htmlspecialchars($product['TenLoaiSP'] ?? 'Món ăn vặt', ENT_QUOTES, 'UTF-8'); ?>
              </span>
              <?php if (!empty($product['TenTH'])) { ?>
                <span style="display:inline-block; background:#e8f4fd; border:1px solid #bee3f8; color:#2b6cb0; border-radius:999px; padding:5px 12px; font-size:12px; font-weight:700;">
                  🏷️ <?php echo htmlspecialchars($product['TenTH'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
              <?php } ?>
              <?php if (!empty($product['TenNCC'])) { ?>
                <span style="display:inline-block; background:#edfdf2; border:1px solid #c6f6d5; color:#22543d; border-radius:999px; padding:5px 12px; font-size:12px; font-weight:700;">
                  🏭 NCC: <?php echo htmlspecialchars($product['TenNCC'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
              <?php } ?>
            </div>

            <h1 style="margin: 0 0 12px; color:#603b2c; font-size: 2rem; font-weight:800; line-height:1.2;">
              <?php echo htmlspecialchars($product['TenSP'], ENT_QUOTES, 'UTF-8'); ?>
            </h1>

            <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px;">
              <div style="color:#f7a929; letter-spacing:2px; font-size:1.05rem;">★★★★★</div>
              <span style="font-weight:700; color:#7a2d1d;"><?php echo number_format($avgRating, 1); ?>/5</span>
              <span style="color:#7a2d1d; opacity:0.7;">(<?php echo count($reviews); ?> đánh giá)</span>
            </div>

            <div style="margin-bottom:18px; display:flex; align-items:baseline; gap:12px; flex-wrap:wrap;">
              <span id="selected-price" style="font-size: 1.9rem; font-weight:800; color:#d8572e;">
                <?php echo number_format($defaultSelectedPrice, 0, ',', '.') . ' VNĐ'; ?>
              </span>
              <span id="old-price" style="font-size: 1.05rem; color:#8d8d8d; text-decoration: line-through;">
                <?php echo number_format($product['GiaBanCu'], 0, ',', '.') . ' VNĐ'; ?>
              </span>
            </div>

            <p style="color:#5b3a31; line-height: 1.7; margin-bottom: 22px;">
              <?php echo nl2br(htmlspecialchars($product['MoTa'], ENT_QUOTES, 'UTF-8')); ?>
            </p>

            <div style="display:flex; gap:14px; margin-bottom:22px; flex-wrap:wrap;">
              <div style="min-width: 140px; background:#fff; border:1px solid #e7d2b2; border-radius:12px; padding: 10px 12px;">
                <div style="font-size: 11px; color:#8a5d39; letter-spacing:0.08em; text-transform:uppercase; font-weight:700;">Tồn kho</div>
                <div style="font-size: 1.1rem; font-weight:800; color:#3c2a28; margin-top:4px;">
                  <?php echo (int)$product['SoLuongTon']; ?> sản phẩm
                </div>
              </div>
              <div style="min-width: 140px; background:#fff; border:1px solid #e7d2b2; border-radius:12px; padding: 10px 12px;">
                <div style="font-size: 11px; color:#8a5d39; letter-spacing:0.08em; text-transform:uppercase; font-weight:700;">Giao hàng</div>
                <div style="font-size: 1.05rem; font-weight:800; color:#3c2a28; margin-top:4px;">Trong 30-60 phút</div>
              </div>
            </div>

            <form method="post" style="margin-top: 10px;">
              <div style="margin-bottom: 18px;">
                <label style="display:block; margin-bottom:8px; font-weight:800; color:#7a2d1d;">Chọn hương vị</label>
                <div style="display:flex; flex-wrap:wrap; gap:10px;">
                  <?php foreach ($flavors as $index =>$flavor) { ?>
                    <label style="display:inline-flex; align-items:center; gap:8px; padding:8px 14px; border:1px solid #e7d2b2; border-radius:999px; background:#fff; cursor:pointer; font-weight:700; color:#5a3d31;">
                      <input type="radio" name="mau" value="<?php echo htmlspecialchars(trim($flavor), ENT_QUOTES, 'UTF-8'); ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                      <?php echo htmlspecialchars(trim($flavor), ENT_QUOTES, 'UTF-8'); ?>
                    </label>
                  <?php } ?>
                </div>
              </div>

              <div style="display:none;">
                <select id="product-size-select" name="size">
                  <?php foreach ($sizeOptions as $sizeLabel =>$sizePrice) { ?>
                    <option value="<?php echo htmlspecialchars(trim($sizeLabel), ENT_QUOTES, 'UTF-8'); ?>" data-price="<?php echo (int) $sizePrice; ?>" <?php echo trim($sizeLabel) === trim($defaultSelectedSize) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars(trim($sizeLabel), ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <button type="submit" name="submit_cart" style="display:inline-flex; align-items:center; justify-content:center; min-height:52px; padding:0 26px; border:none; border-radius:14px; background:linear-gradient(135deg,#d65a2b,#7a2d1d); color:#fff; font-weight:800; box-shadow:0 12px 18px rgba(122,45,29,0.18); cursor:pointer;">
                Thêm vào giỏ hàng
              </button>
            </form>
          </div>
        </div>

        <script>
          (() => {
            const sizeSelect = document.getElementById('product-size-select');
            const priceLabel = document.getElementById('selected-price');
            if (!sizeSelect || !priceLabel) return;

            const updatePrice = () => {
              const selectedOption = sizeSelect.selectedOptions[0];
              const selectedPrice = Number(selectedOption?.dataset.price || 0);
              priceLabel.textContent = new Intl.NumberFormat('vi-VN').format(selectedPrice) + ' VNĐ';
            };

            sizeSelect.addEventListener('change', updatePrice);
            updatePrice();
          })();
        </script>

        <div class="detail-section" style="margin-top:28px; display:grid; grid-template-columns: 1.2fr 0.8fr; gap:20px;">
          <div style="background:#fffaf5; border:1px solid #f0d9b8; border-radius:20px; padding:22px; box-shadow:0 16px 28px rgba(142,89,35,0.05);">
            <h3 style="margin-top:0; color:#6d392d; font-weight:800;">Mô tả chi tiết</h3>
            <p style="margin: 0; color:#563f38; line-height:1.8;">
              <?php echo nl2br(htmlspecialchars($product['MoTa'], ENT_QUOTES, 'UTF-8')); ?>
            </p>
          </div>

          <div style="background:#fffaf5; border:1px solid #f0d9b8; border-radius:20px; padding:22px; box-shadow:0 16px 28px rgba(142,89,35,0.05);">
            <h3 style="margin-top:0; color:#6d392d; font-weight:800;">Đánh giá & bình luận</h3>
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px;">
              <strong style="font-size:1.8rem; color:#d8572e;"><?php echo number_format($avgRating, 1); ?></strong>
              <span style="color:#f7a929; letter-spacing:2px;">★★★★★</span>
              <span style="color:#8a6d63; font-size:0.9rem;">(<?php echo count($reviews); ?> lượt)</span>
            </div>

            <!-- Form gửi đánh giá -->
            <form method="post" style="background:#fff; border:1px solid #ebd9c5; border-radius:14px; padding:16px; margin-bottom:18px;">
              <h4 style="margin:0 0 10px; font-size:1rem; font-weight:800; color:#6d392d;">Gửi đánh giá của bạn</h4>
              <div style="display:flex; gap:10px; margin-bottom:10px; flex-wrap:wrap;">
                <input type="text" name="reviewer_name" value="<?php echo htmlspecialchars($_SESSION['HoTen'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Họ và tên của bạn" required style="flex:1; min-width:180px; padding:8px 12px; border:1px solid #e2cfb7; border-radius:8px; outline:none;">
                <select name="reviewer_rating" style="padding:8px 12px; border:1px solid #e2cfb7; border-radius:8px; outline:none; background:#fff; font-weight:700; color:#c05621;">
                  <option value="5">⭐⭐⭐⭐⭐ (5 sao - Tuyệt vời)</option>
                  <option value="4">⭐⭐⭐⭐ (4 sao - Rất ngon)</option>
                  <option value="3">⭐⭐⭐ (3 sao - Bình thường)</option>
                  <option value="2">⭐⭐ (2 sao - Cần cải thiện)</option>
                  <option value="1">⭐ (1 sao - Không ưng ý)</option>
                </select>
              </div>
              <textarea name="reviewer_comment" rows="2" placeholder="Chia sẻ cảm nhận về hương vị, độ tươi ngon của món ăn..." required style="width:100%; padding:8px 12px; border:1px solid #e2cfb7; border-radius:8px; outline:none; resize:vertical; margin-bottom:10px; font-family:inherit;"></textarea>
              <button type="submit" name="submit_review" style="background:linear-gradient(135deg,#d65a2b,#7a2d1d); color:#fff; border:none; padding:8px 18px; border-radius:8px; font-weight:700; cursor:pointer;">
                Gửi nhận xét
              </button>
            </form>

            <div style="max-height:360px; overflow-y:auto; padding-right:6px;">
              <?php foreach ($reviews as$review) { ?>
                <div style="padding:12px 0; border-top:1px solid #f0d9b8;">
                  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <strong style="color:#3f2d29; font-size:0.98rem;"><?php echo htmlspecialchars($review['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span style="color:#f7a929; letter-spacing:2px; font-size:0.85rem;"><?php echo str_repeat('★', $review['rating']); ?></span>
                  </div>
                  <p style="margin:0 0 4px; color:#5d433a; line-height:1.6; font-size:0.94rem;">
                    <?php echo htmlspecialchars($review['text'], ENT_QUOTES, 'UTF-8'); ?>
                  </p>
                  <?php if (!empty($review['date'])) { ?>
                    <small style="color:#9c857b;"><?php echo htmlspecialchars($review['date'], ENT_QUOTES, 'UTF-8'); ?></small>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="detail-suggest" style="margin-top:28px; background:#fffaf5; border:1px solid #f0d9b8; border-radius:20px; padding:22px; box-shadow:0 16px 28px rgba(142,89,35,0.05);">
          <h3 style="margin-top:0; color:#6d392d; font-weight:800;">Món ăn gợi ý</h3>
          <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:18px;">
            <?php while ($suggest = mysqli_fetch_assoc($suggestResult)) { 
              $suggestImg = (!empty($suggest['AnhBia']) && file_exists($imageDirectory .$suggest['AnhBia'])) 
                ? '../../Images/ImgProducts/' . $suggest['AnhBia'] 
                : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=900&q=80';
            ?>
              <a href="details.php?MaSP=<?php echo (int)$suggest['MaSP']; ?>" style="display:block; background:#fff; border:1px solid #f0d9b8; border-radius:16px; overflow:hidden; text-decoration:none; color:inherit; transition:transform .2s ease;">
                <img src="<?php echo htmlspecialchars($suggestImg, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($suggest['TenSP'], ENT_QUOTES, 'UTF-8'); ?>" style="width:100%; height:170px; object-fit:cover; display:block;">
                <div style="padding:12px;">
                  <div style="font-weight:800; color:#5b3a31; margin-bottom:6px; min-height:44px;">
                    <?php echo htmlspecialchars($suggest['TenSP'], ENT_QUOTES, 'UTF-8'); ?>
                  </div>
                  <div style="color:#d8572e; font-weight:800;">
                    <?php echo number_format($suggest['GiaBan'], 0, ',', '.') . ' VNĐ'; ?>
                  </div>
                </div>
              </a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("Layout_KhachHang_Footer.php"); ?>
</body>
</html>

<script>
  const thumbImages = document.querySelectorAll('.thumb-image');
  const mainProductImage = document.getElementById('mainProductImage');

  thumbImages.forEach(function (thumb) {
    thumb.addEventListener('click', function () {
      const imgUrl = this.getAttribute('data-image');
      mainProductImage.src = imgUrl;
      thumbImages.forEach(function (item) {
        item.style.borderColor = '#e8d3b6';
      });
      this.style.borderColor = '#d36a2d';
    });
  });
</script>