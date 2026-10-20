<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Customer/Handle.php");

// ===== BỘ LỌC KHÁCH HÀNG =====
$f_key_kh   = isset($_GET['f_key_kh'])  ? trim(mysqli_real_escape_string($conn, $_GET['f_key_kh'])) : '';
$f_gioitinh = isset($_GET['f_gt'])      ? $_GET['f_gt']   : '';
$f_tt_kh    = isset($_GET['f_tt_kh'])   ? $_GET['f_tt_kh']: '';

$where_kh = [];
if ($f_key_kh !== '')   $where_kh[] = "(HoTen LIKE '%$f_key_kh%' OR TaiKhoan LIKE '%$f_key_kh%' OR Email LIKE '%$f_key_kh%' OR DienThoaiKH LIKE '%$f_key_kh%')";
if ($f_gioitinh === '1') $where_kh[] = "GioiTinh = 1";
if ($f_gioitinh === '0') $where_kh[] = "GioiTinh = 0";
if ($f_tt_kh === '1')   $where_kh[] = "TrangThai = 1";
if ($f_tt_kh === '0')   $where_kh[] = "TrangThai = 0";

$whereSQL_kh = count($where_kh) ? 'WHERE ' . implode(' AND ', $where_kh) : '';

$query = "SELECT * FROM khachhang $whereSQL_kh ORDER BY MaKH DESC";
$query_run = mysqli_query($conn, $query);
$total_all_kh = mysqli_num_rows(mysqli_query($conn, "SELECT MaKH FROM khachhang"));
$total_filtered_kh = mysqli_num_rows($query_run);

// Cập nhật đường dẫn ảnh
$imgPath = "../Images/ImgCustomer/";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<style>
.filter-bar{background:linear-gradient(135deg,#f8f9fa,#e9ecef);border-radius:12px;padding:20px;margin-bottom:16px;border:1px solid #dee2e6;box-shadow:0 2px 8px rgba(0,0,0,.06);}
.filter-bar .filter-title{font-weight:700;font-size:14px;color:#495057;margin-bottom:14px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;}
.filter-bar .form-select,.filter-bar .form-control{font-size:13px;border-radius:8px;border:1px solid #ced4da;}
.filter-bar .form-select:focus,.filter-bar .form-control:focus{border-color:#0d6efd;box-shadow:0 0 0 3px rgba(13,110,253,.12);}
.filter-badge{display:inline-flex;align-items:center;gap:4px;background:#0d6efd;color:#fff;border-radius:20px;padding:2px 10px;font-size:12px;}
.filtered-count{font-size:13px;color:#6c757d;}
</style>

    <div class="container-fluid">
    <div class="card p-3 mb-3">
        <h2 class="text-center font-weight-bold">QUẢN LÝ NGƯỜI DÙNG</h2>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="filter-title">
            <i class="bi bi-funnel-fill text-primary"></i> Bộ lọc khách hàng
            <?php if(count($where_kh)>0): ?><span class="filter-badge"><?= count($where_kh) ?> bộ lọc đang áp dụng</span><?php endif; ?>
            <span class="filtered-count">Tìm thấy <strong><?= $total_filtered_kh ?></strong> / <?= $total_all_kh ?> khách hàng</span>
        </div>
        <form method="GET" action="">
            <input type="hidden" name="thamso" value="khachhang">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:12px">🔍 Từ khoá</label>
                    <input type="text" name="f_key_kh" class="form-control" placeholder="Tên, tài khoản, email, SĐT..." value="<?= htmlspecialchars($f_key_kh) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">⚧ Giới tính</label>
                    <select name="f_gt" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="1" <?= $f_gioitinh==='1'?'selected':'' ?>>👨 Nam</option>
                        <option value="0" <?= $f_gioitinh==='0'?'selected':'' ?>>👩 Nữ</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">📌 Trạng thái</label>
                    <select name="f_tt_kh" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="1" <?= $f_tt_kh==='1'?'selected':'' ?>>✅ Hoạt động</option>
                        <option value="0" <?= $f_tt_kh==='0'?'selected':'' ?>>🔒 Bị khoá</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex flex-column justify-content-end gap-1">
                    <button type="submit" class="btn btn-primary" style="border-radius:8px;font-size:13px;"><i class="bi bi-search"></i> Lọc</button>
                    <a href="?thamso=khachhang" class="btn btn-outline-secondary" style="border-radius:8px;font-size:13px;"><i class="bi bi-x-circle"></i> Xoá lọc</a>
                </div>
            </div>
        </form>
    </div>

        <div class="card-body">
            <table id="data-table" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Tài khoản</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_array($query_run)) {
                        $gioitinh = $row['GioiTinh'] ? "Nam" : "Nữ";
                        $trangthai = empty($row['TrangThai']) ? 'Khoá' : 'Hoạt động';
                        $avatarFile = $row['AnhKH'] ?? '';
                        if (!empty($avatarFile) && file_exists("../Images/ImgCustomer/" . $avatarFile)) {
                            $anh = "../Images/ImgCustomer/" . $avatarFile;
                        } elseif (!empty($avatarFile) && file_exists("../KhachHang/web/imgKH/" . $avatarFile)) {
                            $anh = "../KhachHang/web/imgKH/" . $avatarFile;
                        } else {
                            $anh = "../KhachHang/web/imgKH/user.jpg";
                        }
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><img src="<?= $anh ?>" width="50" height="50" style="object-fit: cover;" class="rounded-circle"></td>
                            <td><?= $row['TaiKhoan'] ?></td>
                            <td><?= $row['HoTen'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['DienThoaiKH'] ?></td>
                            <td><?= $gioitinh ?></td>
                            <td><?= $trangthai ?></td>
                            <td>
                                <form action="" method="post" style="display:inline-block;">
                                    <input type="hidden" name="MaKH" value="<?= $row['MaKH'] ?>">
                                    <button type="submit" name="toggleUser" class="btn btn-warning btn-sm"><?= $trangthai == 'Khoá' ? 'Mở khoá' : 'Khoá' ?></button>
                                </form>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['MaKH'] ?>">Sửa</button>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal<?= $row['MaKH'] ?>">Xem chi tiết</button>
                            </td>
                        </tr>

                        <!-- Modal: Xem chi tiết -->
                        <div class="modal fade" id="viewUserModal<?= $row['MaKH'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chi tiết người dùng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Họ tên:</strong> <?= $row['HoTen'] ?></p>
                                        <p><strong>Tài khoản:</strong> <?= $row['TaiKhoan'] ?></p>
                                        <p><strong>Mật khẩu:</strong> <?= $row['MatKhau'] === '!password-reset-required!' ? 'Cần đặt lại' : 'Được bảo vệ, không hiển thị' ?></p>
                                        <p><strong>Email:</strong> <?= $row['Email'] ?></p>
                                        <p><strong>Địa chỉ:</strong> <?= $row['DiaChiKH'] ?></p>
                                        <p><strong>Số điện thoại:</strong> <?= $row['DienThoaiKH'] ?></p>
                                        <p><strong>Ngày sinh:</strong> <?= date('d-m-Y', strtotime($row['NgaySinh'])) ?></p>
                                        <p><strong>Giới tính:</strong> <?= $gioitinh ?></p>
                                        <p><strong>Trạng thái:</strong> <?= $trangthai ?></p>
                                        <p><strong>Ảnh đại diện:</strong></p>
                                        <img src="<?= $anh ?>" width="100" height="100" style="object-fit:cover;" class="mb-2 rounded">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal: Sửa -->
                        <div class="modal fade" id="editUserModal<?= $row['MaKH'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa thông tin người dùng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="MaKH" value="<?= $row['MaKH'] ?>">
                                            <input type="text" name="HoTen" value="<?= $row['HoTen'] ?>" class="form-control mb-2" required>
                                            <input type="text" name="TaiKhoan" value="<?= $row['TaiKhoan'] ?>" class="form-control mb-2" required>
                                            <input type="password" name="MatKhau" class="form-control mb-2" placeholder="Mật khẩu mới (để trống nếu không đổi)" minlength="6" autocomplete="new-password">
                                            <input type="email" name="Email" value="<?= $row['Email'] ?>" class="form-control mb-2">
                                            <input type="text" name="DiaChiKH" value="<?= $row['DiaChiKH'] ?>" class="form-control mb-2">
                                            <input type="text" name="DienThoaiKH" value="<?= $row['DienThoaiKH'] ?>" class="form-control mb-2">
                                            <input type="date" name="NgaySinh" value="<?= date('Y-m-d', strtotime($row['NgaySinh'])) ?>" class="form-control mb-2">
                                            <select name="GioiTinh" class="form-control mb-2">
                                                <option value="1" <?= $row['GioiTinh'] ? 'selected' : '' ?>>Nam</option>
                                                <option value="0" <?= !$row['GioiTinh'] ? 'selected' : '' ?>>Nữ</option>
                                            </select>
                                            <label>Ảnh đại diện hiện tại:</label><br>
                                            <img src="<?= $imgPath . $row['AnhKH'] ?>" width="80" height="80" class="mb-2 rounded">
                                            <input type="file" name="AnhKH" class="form-control">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="updateUser" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#data-table').DataTable({
            language: {
                lengthMenu: 'Hiển thị _MENU_ bản ghi/trang',
                zeroRecords: 'Không tìm thấy dữ liệu',
                info: 'Trang _PAGE_ / _PAGES_',
                infoEmpty: 'Không có dữ liệu',
                infoFiltered: '(lọc từ _MAX_ bản ghi)',
                search: "Tìm kiếm:",
                paginate: {
                    first: "Đầu",
                    last: "Cuối",
                    next: "Sau",
                    previous: "Trước"
                },
            },
        });
    });
</script>