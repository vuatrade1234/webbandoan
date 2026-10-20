<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Customer/Handle.php");

$query = "SELECT * FROM khachhang";
$query_run = mysqli_query($conn, $query);

// Cập nhật đường dẫn ảnh
$imgPath = "../Images/ImgCustomer/";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!-- Modal: Thêm mới User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="HoTen" class="form-control mb-2" placeholder="Họ tên" required>
                    <input type="text" name="TaiKhoan" class="form-control mb-2" placeholder="Tài khoản" required>
                    <input type="password" name="MatKhau" class="form-control mb-2" placeholder="Mật khẩu" required>
                    <input type="email" name="Email" class="form-control mb-2" placeholder="Email">
                    <input type="text" name="DiaChiKH" class="form-control mb-2" placeholder="Địa chỉ">
                    <input type="text" name="DienThoaiKH" class="form-control mb-2" placeholder="Số điện thoại">
                    <input type="date" name="NgaySinh" class="form-control mb-2">
                    <select name="GioiTinh" class="form-control mb-2">
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                    </select>
                    <input type="file" name="AnhKH" class="form-control mb-2" accept="image/*">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="insertUser" class="btn btn-primary">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-3">
        <h2 class="text-center font-weight-bold">QUẢN LÝ NGƯỜI DÙNG</h2>
    </div>

    <div class="card mb-3">
        <div class="card-body text-right">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Thêm người dùng</button>
        </div>
    </div>

    <div class="card">
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
                        $trangthai = $row['MatKhau'] === 'locked' ? 'Khoá' : 'Hoạt động';
                        $anh = !empty($row['AnhKH']) ? $imgPath . $row['AnhKH'] : "https://via.placeholder.com/50";
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
                                        <p><strong>Email:</strong> <?= $row['Email'] ?></p>
                                        <p><strong>Địa chỉ:</strong> <?= $row['DiaChiKH'] ?></p>
                                        <p><strong>Số điện thoại:</strong> <?= $row['DienThoaiKH'] ?></p>
                                        <p><strong>Ngày sinh:</strong> <?= date('d-m-Y', strtotime($row['NgaySinh'])) ?></p>
                                        <p><strong>Giới tính:</strong> <?= $gioitinh ?></p>
                                        <p><strong>Trạng thái:</strong> <?= $trangthai ?></p>
                                        <p><strong>Ảnh đại diện:</strong></p>
                                        <img src="<?= $imgPath . $row['AnhKH'] ?>" width="100" height="100" class="mb-2 rounded">
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
<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>