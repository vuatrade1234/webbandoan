<?php
include("./Function/Manager/Check_login.php");
include("./Function/Voucher/Handle.php");

$query = "SELECT * FROM `voucher` ORDER BY `MaVC` DESC";
$query_run = mysqli_query($conn, $query);
?>

<div class="container-fluid">
    <div class="card p-3 mb-3">
        <h1 class="font-weight-bold text-center mb-0">QUẢN LÍ MÃ GIẢM GIÁ</h1>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#voucherAddModal">
                <i class="bi bi-plus-lg"></i> Thêm mã
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="data-table" class="table table-bordered table-secondary table-hover display" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                        <th>Điều kiện</th>
                        <th>Nhóm khách</th>
                        <th>Lượt dùng / số lượng</th>
                        <th>Hiệu lực</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) { $index = 1; while ($row = mysqli_fetch_array($query_run)) { ?>
                        <tr>
                            <td><?php echo $index++; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['MaCode']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['TenVoucher']); ?></td>
                            <td><?php echo $row['LoaiGiam'] === 'fixed' ? 'Cố định' : 'Phần trăm'; ?></td>
                            <td><?php echo $row['LoaiGiam'] === 'fixed' ? number_format($row['GiaTri'], 0, ',', '.') . 'đ' : $row['GiaTri'] . '%'; ?></td>
                            <td><?php echo number_format((float) $row['DieuKienDonToiThieu'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <?php
                                if ($row['DoiTuong'] === 'new') {
                                    echo 'Khách mới (' . (int) $row['SoNgayKhachMoi'] . ' ngày)';
                                } elseif ($row['DoiTuong'] === 'returning') {
                                    echo 'Đã có đơn thành công';
                                } else {
                                    echo 'Tất cả khách';
                                }
                                ?>
                            </td>
                            <td><?php echo (int) $row['SoLanDaDung']; ?> / <?php echo (int) $row['SoLuong']; ?></td>
                            <td><?php echo $row['NgayBatDau']; ?> <br> <?php echo $row['NgayKetThuc'] ?? 'Không giới hạn'; ?></td>
                            <td><?php echo $row['TrangThai'] ? '<span class="badge bg-success">Kích hoạt</span>' : '<span class="badge bg-secondary">Tắt</span>'; ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#voucherEditModal<?php echo $row['MaVC']; ?>">Sửa</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#voucherDeleteModal<?php echo $row['MaVC']; ?>">Xoá</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="voucherEditModal<?php echo $row['MaVC']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sửa mã giảm giá</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body row g-3">
                                            <input type="hidden" name="MaVC" value="<?php echo $row['MaVC']; ?>">
                                            <div class="col-md-6">
                                                <label>Mã code</label>
                                                <input required type="text" name="MaCode" value="<?php echo htmlspecialchars($row['MaCode']); ?>" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Tên voucher</label>
                                                <input required type="text" name="TenVoucher" value="<?php echo htmlspecialchars($row['TenVoucher']); ?>" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Loại giảm</label>
                                                <select name="LoaiGiam" class="form-select">
                                                    <option value="percent" <?php echo $row['LoaiGiam'] === 'percent' ? 'selected' : ''; ?>>Phần trăm</option>
                                                    <option value="fixed" <?php echo $row['LoaiGiam'] === 'fixed' ? 'selected' : ''; ?>>Cố định</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Giá trị</label>
                                                <input required type="number" name="GiaTri" value="<?php echo $row['GiaTri']; ?>" class="form-control" min="0">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Điều kiện</label>
                                                <input required type="number" name="DieuKienDonToiThieu" value="<?php echo $row['DieuKienDonToiThieu']; ?>" class="form-control" min="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Nhóm khách hàng</label>
                                                <select name="DoiTuong" class="form-select">
                                                    <option value="all" <?php echo $row['DoiTuong'] === 'all' ? 'selected' : ''; ?>>Tất cả khách</option>
                                                    <option value="new" <?php echo $row['DoiTuong'] === 'new' ? 'selected' : ''; ?>>Khách mới chưa có đơn thành công</option>
                                                    <option value="returning" <?php echo $row['DoiTuong'] === 'returning' ? 'selected' : ''; ?>>Khách đã mua</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Khách mới trong số ngày</label>
                                                <input type="number" name="SoNgayKhachMoi" value="<?php echo (int) $row['SoNgayKhachMoi']; ?>" class="form-control" min="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Ngày bắt đầu</label>
                                                <input type="datetime-local" name="NgayBatDau" value="<?php echo date('Y-m-d\TH:i', strtotime($row['NgayBatDau'])); ?>" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Ngày kết thúc</label>
                                                <input type="datetime-local" name="NgayKetThuc" value="<?php echo $row['NgayKetThuc'] ? date('Y-m-d\TH:i', strtotime($row['NgayKetThuc'])) : ''; ?>" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Số lượng</label>
                                                <input type="number" name="SoLuong" value="<?php echo $row['SoLuong']; ?>" class="form-control" min="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="d-block mb-2">Trạng thái</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="TrangThai" <?php echo $row['TrangThai'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label">Kích hoạt</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="update_voucher" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="voucherDeleteModal<?php echo $row['MaVC']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xoá voucher</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="MaVC" value="<?php echo $row['MaVC']; ?>">
                                            <p>Bạn có chắc muốn xoá mã <strong><?php echo htmlspecialchars($row['MaCode']); ?></strong> không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                                            <button type="submit" name="delete_voucher" class="btn btn-danger">Xoá</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="voucherAddModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mã giảm giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Mã code</label>
                        <input required type="text" name="MaCode" class="form-control" placeholder="WELCOME10">
                    </div>
                    <div class="col-md-6">
                        <label>Tên voucher</label>
                        <input required type="text" name="TenVoucher" class="form-control" placeholder="Chào mừng mới">
                    </div>
                    <div class="col-md-4">
                        <label>Loại giảm</label>
                        <select name="LoaiGiam" class="form-select">
                            <option value="percent">Phần trăm</option>
                            <option value="fixed">Cố định</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Giá trị</label>
                        <input required type="number" name="GiaTri" class="form-control" min="0" value="10">
                    </div>
                    <div class="col-md-4">
                        <label>Điều kiện</label>
                        <input required type="number" name="DieuKienDonToiThieu" class="form-control" min="0" value="200000">
                    </div>
                    <div class="col-md-6">
                        <label>Nhóm khách hàng</label>
                        <select name="DoiTuong" class="form-select">
                            <option value="all">Tất cả khách</option>
                            <option value="new">Khách mới chưa có đơn thành công</option>
                            <option value="returning">Khách đã mua</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Khách mới trong số ngày</label>
                        <input type="number" name="SoNgayKhachMoi" class="form-control" min="1" value="30">
                    </div>
                    <div class="col-md-6">
                        <label>Ngày bắt đầu</label>
                        <input type="datetime-local" name="NgayBatDau" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Ngày kết thúc</label>
                        <input type="datetime-local" name="NgayKetThuc" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Số lượng</label>
                        <input type="number" name="SoLuong" class="form-control" min="1" value="100">
                    </div>
                    <div class="col-md-6">
                        <label class="d-block mb-2">Trạng thái</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="TrangThai" checked>
                            <label class="form-check-label">Kích hoạt</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" name="insert_voucher" class="btn btn-primary">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#data-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/vi.json'
            }
        });
    });
</script>
