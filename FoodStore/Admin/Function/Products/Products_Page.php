<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include_once __DIR__ . '/ProductPricing.php';
include("./Function/Products/Handle.php");

// ===== BỘ LỌC SẢN PHẨM =====
$f_loai   = isset($_GET['f_loai'])   ? (int)$_GET['f_loai']                        : 0;
$f_hang   = isset($_GET['f_hang'])   ? (int)$_GET['f_hang']                        : 0;
$f_giatoi = isset($_GET['f_giatoi']) ? (int)str_replace('.','',trim($_GET['f_giatoi'])) : 0;
$f_giamax = isset($_GET['f_giamax']) ? (int)str_replace('.','',trim($_GET['f_giamax'])) : 0;
$f_tt     = isset($_GET['f_tt'])     ? $_GET['f_tt']                                : '';
$f_key    = isset($_GET['f_key'])    ? trim(mysqli_real_escape_string($conn, $_GET['f_key'])) : '';

$where = [];
if ($f_loai > 0)  $where[] = "sanpham.MaLSP = $f_loai";
if ($f_hang > 0)  $where[] = "sanpham.MaTH = $f_hang";
if ($f_giatoi > 0) $where[] = "sanpham.GiaBan >= $f_giatoi";
if ($f_giamax > 0) $where[] = "sanpham.GiaBan <= $f_giamax";
if ($f_tt === '1') $where[] = "sanpham.HienThiSanPham = 1";
if ($f_tt === '0') $where[] = "sanpham.HienThiSanPham = 0";
if ($f_key !== '') $where[] = "(sanpham.TenSP LIKE '%$f_key%' OR sanpham.MoTa LIKE '%$f_key%')";

$whereSQL = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$query = "SELECT sanpham.*, loaisanpham.TenLoaiSP, COALESCE(ThuongHieu.TenTH, 'Không có') AS TenTH 
          FROM sanpham 
          LEFT JOIN loaisanpham on sanpham.MaLSP = loaisanpham.MaLSP 
          LEFT JOIN ThuongHieu on sanpham.MaTH = ThuongHieu.MaTH 
          $whereSQL
          ORDER BY sanpham.MaSP DESC";
$query_run = mysqli_query($conn, $query);
$total_all = mysqli_num_rows(mysqli_query($conn, "SELECT MaSP FROM sanpham"));
$total_filtered = mysqli_num_rows($query_run);

$query_brands = "SELECT * FROM ThuongHieu";
$query_run_brands = mysqli_query($conn, $query_brands);
$query_run_brands1 = mysqli_query($conn, $query_brands);
$query_run_brands2 = mysqli_query($conn, $query_brands);

$query_products_type = "SELECT * FROM loaisanpham";
$query_run_products_type = mysqli_query($conn, $query_products_type);
$query_run_products_type1 = mysqli_query($conn, $query_products_type);
$query_run_products_type2 = mysqli_query($conn, $query_products_type);

$query_suppliers = "SELECT * FROM NhaCungCap";
$query_run_suppliers  = mysqli_query($conn, $query_suppliers);
$query_run_suppliers1  = mysqli_query($conn, $query_suppliers);
$query_run_suppliers2  = mysqli_query($conn, $query_suppliers);

$arr = [];
$arr1 = [];
while ($row = mysqli_fetch_array($query_run_products_type1)) {
    array_push($arr, $row["MaLSP"]);
}
while ($row = mysqli_fetch_array($query_run_products_type2)) {
    array_push($arr1, $row["TenLoaiSP"]);
}

$arr2 = [];
$arr3 = [];
while ($row = mysqli_fetch_array($query_run_brands1)) {
    array_push($arr2, $row["MaTH"]);
}
while ($row = mysqli_fetch_array($query_run_brands2)) {
    array_push($arr3, $row["TenTH"]);
}

$arr4 = [];
$arr5 = [];
while ($row = mysqli_fetch_array($query_run_suppliers1)) {
    array_push($arr4, $row["MaNCC"]);
}
while ($row = mysqli_fetch_array($query_run_suppliers2)) {
    array_push($arr5, $row["TenNCC"]);
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!-- ADD MODAL -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="Label_Add" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Label_Add">Thêm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="I_TenSP">Tên món ăn</label>
                                <input required value="<?php if (isset($I_TenSP)) echo $I_TenSP; ?>" type="text" name="I_TenSP" class="form-control" id="I_TenSP" placeholder="Nhập tên món ăn">
                            </div>
                            <div class="form-group">
                                <label for="I_GiaBan">Giá bán</label>
                                <input required value="<?php if (isset($I_GiaBan)) echo $I_GiaBan; ?>" type="text" name="I_GiaBan" class="form-control" id="I_GiaBan" placeholder="Nhập giá bán">
                            </div>
                            <div class="form-group">
                                <label for="I_MoTa">Mô tả</label>
                                <div class="form-group shadow-textarea">
                                    <textarea name="I_MoTa" class="form-control z-depth-1" id="I_MoTa" rows="3" placeholder="Nhập mô tả..."><?php if (isset($I_MoTa)) echo $I_MoTa; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-cover-add">Ảnh bìa (chọn 1 ảnh)</label>
                                <input id="input-cover-add" accept=".jpg, .jpeg, .png" required type="file" name="I_AnhBia" class="form-control product-image-input">
                                <div class="image-preview-list"></div>
                            </div>
                            <div class="form-group">
                                <label for="input-gallery-add">Ảnh phụ (có thể chọn nhiều ảnh)</label>
                                <input id="input-gallery-add" accept=".jpg, .jpeg, .png" type="file" name="I_AnhPhu[]" class="form-control product-image-input" multiple>
                                <div class="image-preview-list"></div>
                            </div>
                            <div class="form-group">
                                <label for="I_SoLuongTon">Số lượng</label>
                                <input required value="<?php if (isset($I_SoLuongTon)) echo $I_SoLuongTon; ?>" type="text" name="I_SoLuongTon" class="form-control" id="I_SoLuongTon" placeholder="Số lượng">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="I_Size">Quy cách đóng gói</label>
                                <input required value="<?php if (isset($I_Size)) echo $I_Size; ?>" type="text" name="I_Size" class="form-control" id="I_Size" placeholder="Ví dụ: Hũ 250g:50000, Hũ 300g:70000">
                            </div>
                            <div class="form-group">
                                <label for="I_Màu">Hương vị</label>
                                <input required value="<?php if (isset($I_Màu)) echo $I_Màu; ?>" type="text" name="I_Màu" class="form-control" id="I_Màu" placeholder="Ví dụ: Cay vừa, Phô mai">
                            </div>
                            <div class="form-group">
                                <label for="I_MaLSP">Danh mục món ăn</label>
                                <select name="I_MaLSP" class="form-select" id="I_MaLSP">
                                    <?php while ($row_type = mysqli_fetch_array($query_run_products_type)) { ?>
                                        <option value="<?php echo $row_type["MaLSP"]; ?>"><?php echo $row_type["TenLoaiSP"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="I_MaTH">Thương hiệu</label>
                                <select name="I_MaTH" class="form-select" id="I_MaTH">
                                    <option value="">-- Không có thương hiệu --</option>
                                    <?php while ($row_brand = mysqli_fetch_array($query_run_brands)) { ?>
                                        <option value="<?php echo $row_brand["MaTH"]; ?>"><?php echo $row_brand["TenTH"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="I_MaNCC">Nhà cung cấp</label>
                                <select name="I_MaNCC" class="form-select" id="I_MaNCC">
                                    <?php while ($row_sup = mysqli_fetch_array($query_run_suppliers)) { ?>
                                        <option value="<?php echo $row_sup["MaNCC"]; ?>"><?php echo $row_sup["TenNCC"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="reset" name="reset" class="btn btn-warning">Xoá dữ liệu</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.filter-bar{background:linear-gradient(135deg,#f8f9fa,#e9ecef);border-radius:12px;padding:20px;margin-bottom:16px;border:1px solid #dee2e6;box-shadow:0 2px 8px rgba(0,0,0,.06);}
.filter-bar .filter-title{font-weight:700;font-size:14px;color:#495057;margin-bottom:14px;display:flex;align-items:center;gap:6px;}
.filter-bar .form-select,.filter-bar .form-control{font-size:13px;border-radius:8px;border:1px solid #ced4da;transition:border-color .2s,box-shadow .2s;}
.filter-bar .form-select:focus,.filter-bar .form-control:focus{border-color:#0d6efd;box-shadow:0 0 0 3px rgba(13,110,253,.12);}
.filter-badge{display:inline-flex;align-items:center;gap:4px;background:#0d6efd;color:#fff;border-radius:20px;padding:2px 10px;font-size:12px;}
.btn-filter{border-radius:8px;font-size:13px;font-weight:600;}
.btn-reset-filter{border-radius:8px;font-size:13px;}
.filtered-count{font-size:13px;color:#6c757d;margin-left:8px;}
</style>

<div class="container-fluid">
    <div class="card p-3">
        <h1 class="font-weight-bold text-center"> QUẢN LÍ SẢN PHẨM </h1>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="filter-title"><i class="bi bi-funnel-fill text-primary"></i> Bộ lọc sản phẩm
            <?php if(count($where)>0): ?><span class="filter-badge"><?= count($where) ?> bộ lọc đang áp dụng</span><?php endif; ?>
            <span class="filtered-count">Hiển thị <strong><?= $total_filtered ?></strong> / <?= $total_all ?> sản phẩm</span>
        </div>
        <form method="GET" action="" id="filter-form-sp">
            <input type="hidden" name="thamso" value="sanpham">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">🔍 Từ khoá</label>
                    <input type="text" name="f_key" class="form-control" placeholder="Tên sản phẩm, mô tả..." value="<?= htmlspecialchars($f_key) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">📂 Danh mục</label>
                    <select name="f_loai" class="form-select">
                        <option value="0">-- Tất cả --</option>
                        <?php
                        $tmp = mysqli_query($conn,"SELECT * FROM loaisanpham ORDER BY TenLoaiSP");
                        while($r=mysqli_fetch_assoc($tmp)):
                        ?>
                        <option value="<?=$r['MaLSP']?>" <?= $f_loai==$r['MaLSP']?'selected':'' ?>><?= htmlspecialchars($r['TenLoaiSP']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">🏷️ Thương hiệu</label>
                    <select name="f_hang" class="form-select">
                        <option value="0">-- Tất cả --</option>
                        <?php
                        $tmp2 = mysqli_query($conn,"SELECT * FROM ThuongHieu ORDER BY TenTH");
                        while($r=mysqli_fetch_assoc($tmp2)):
                        ?>
                        <option value="<?=$r['MaTH']?>" <?= $f_hang==$r['MaTH']?'selected':'' ?>><?= htmlspecialchars($r['TenTH']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">💰 Giá từ (đ)</label>
                    <input type="number" name="f_giatoi" class="form-control" placeholder="0" value="<?= $f_giatoi ?: '' ?>" min="0" step="1000">
                </div>
                <div class="col-md-1" style="max-width:130px">
                    <label class="form-label fw-semibold" style="font-size:12px">💰 Đến (đ)</label>
                    <input type="number" name="f_giamax" class="form-control" placeholder="∞" value="<?= $f_giamax ?: '' ?>" min="0" step="1000">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold" style="font-size:12px">📌 Trạng thái</label>
                    <select name="f_tt" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="1" <?= $f_tt==='1'?'selected':'' ?>>✅ Đang hiển thị</option>
                        <option value="0" <?= $f_tt==='0'?'selected':'' ?>>❌ Đã ẩn</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex gap-2 align-items-end justify-content-end mt-1">
                    <button type="submit" class="btn btn-primary btn-filter"><i class="bi bi-search"></i> Lọc</button>
                    <a href="?thamso=sanpham" class="btn btn-outline-secondary btn-reset-filter"><i class="bi bi-x-circle"></i> Xoá lọc</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body d-flex flex-row justify-content-between align-items-center">
            <button type="button" class="btn btn-primary p-3" data-bs-toggle="modal" data-bs-target="#addmodal">
                <i class="bi bi-plus-lg"></i> Thêm mới
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php $index = 1; ?>
            <table id="data-table" class="table table-bordered table-secondary table-hover display">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Tên món ăn</th>
                        <th>Giá bán</th>
                        <th>Ảnh</th>
                        <th>Số lượng</th>
                        <th>Chức năng</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td><?php echo $index; $index++; ?></td>
                                <td><?php echo $row['MaSP']; ?></td>
                                <td><?php echo $row['TenSP']; ?></td>
                                <td><?php echo number_format($row["GiaBan"], 0, ',', '.'); ?></td>
                                <td style="width:50px"><img style="width:100%" src="../Images/ImgProducts/<?php echo $row['AnhBia']; ?>" alt=""></td>
                                <td><?php echo $row['SoLuongTon']; ?></td>
                                <td>
                                    <!-- NÚT CHI TIẾT -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['MaSP']; ?>">Chi tiết</button>
                                    
                                    <!-- MODAL CHI TIẾT -->
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['MaSP']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 text-center">
                                                            <img src="../Images/ImgProducts/<?php echo $row['AnhBia']; ?>" width="200" height="200" alt="" style="object-fit:cover; border-radius:8px;">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="text-primary"><?php echo $row['TenSP']; ?></h4>
                                                            <p><b>Danh mục:</b> <?php echo $row['TenLoaiSP']; ?> | <b>Thương hiệu:</b> <?php echo $row['TenTH']; ?></p>
                                                            <p><b>Mô tả:</b> <?php echo $row['MoTa']; ?></p>
                                                            <p><b>Hương vị:</b> <?php echo $row['Màu']; ?></p>
                                                            <p><b>Quy cách:</b> <?php echo $row['Size']; ?></p>
                                                            <p><b>Số lượng tồn:</b> <?php echo $row['SoLuongTon']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- NÚT SỬA -->
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['MaSP']; ?>">Sửa</button>
                                    
                                    <!-- MODAL SỬA -->
                                    <div class="modal fade" id="ModalEdit<?php echo $row['MaSP']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="MaSP" value="<?php echo $row['MaSP']; ?>">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label>Tên món ăn</label>
                                                                    <input required value="<?php echo $row['TenSP']; ?>" type="text" name="TenSP" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Giá bán</label>
                                                                    <input required value="<?php echo $row['GiaBan']; ?>" type="text" name="GiaBan" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Mô tả</label>
                                                                    <textarea name="MoTa" class="form-control" rows="3"><?php echo $row['MoTa']; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label>Số lượng</label>
                                                                    <input required value="<?php echo $row['SoLuongTon']; ?>" type="text" name="SoLuongTon" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Quy cách đóng gói</label>
                                                                    <input required value="<?php echo $row['Size']; ?>" type="text" name="Size" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Hương vị</label>
                                                                    <input required value="<?php echo $row['Màu']; ?>" type="text" name="Màu" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" name="updatedata" class="btn btn-primary">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- NÚT XÓA -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['MaSP']; ?>">Xoá</button>
                                    
                                    <!-- MODAL XÓA -->
                                    <div class="modal fade" id="ModalDelete<?php echo $row['MaSP']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xoá sản phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">
                                                        <input type="hidden" name="D_MaSP" value="<?php echo $row['MaSP']; ?>">
                                                        <p>Bạn có chắc muốn xoá sản phẩm <b class="text-danger"><?php echo $row['TenSP']; ?></b> không?</p>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" name="deletedata" class="btn btn-danger">Xoá</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($row["HienThiSanPham"] == 1) { ?>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModelStatus<?php echo $row['MaSP']; ?>">Bật</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModelStatus<?php echo $row['MaSP']; ?>">Tắt</button>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php  }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ĐẢM BẢO TẢI ĐẦY ĐỦ THƯ VIỆN BOOTSTRAP JS ĐỂ KÍCH HOẠT MODAL -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            language: {
                lengthMenu: 'Hiển thị _MENU_ trường một trang',
                zeroRecords: 'Không tìm thấy dữ liệu !',
                info: 'Đang hiển thị trang _PAGE_ / _PAGES_',
                infoEmpty: 'Không có bản ghi nào',
                infoFiltered: '(được lọc từ _MAX_ bản ghi)',
                "search": "Tìm kiếm:",
                searchPlaceholder: "Nhập từ khoá !",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước"
                }
            }
        });
    });
</script>