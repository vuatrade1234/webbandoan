<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Suppliers/Handle.php");
?>

<?php
$query = "SELECT * FROM nhacungcap";
$query_run = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!-- ADD  -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="Label_Add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Label_Add">Thêm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="Them_TenNCC">Tên nhà cung cấp</label>
                        <input required value="" required type="text" name="Them_TenNCC" class="form-control" id="Them_TenNCC" placeholder="Nhập tên nhà cung cấp">

                    </div>
                    <div class="form-group">
                        <label for="Them_SDT">Điện thoại</label>
                        <input required value="" required type="text" name="Them_SDT" class="form-control" id="Them_SDT" placeholder="Nhập số điện thoại nhà cung cấp">

                    </div>
                    <div class="form-group">
                        <label for="Them_DiaChi">Địa chỉ</label>
                        <input required value="" required type="text" name="Them_DiaChi" class="form-control" id="Them_DiaChi" placeholder="Nhập địa chỉ nhà cung cấp">

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="reset" name="reset" class="btn btn-warning">Xoá dữ liệu</button>
                <button type="submit" name="themdulieu" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END ADD  -->



<div class="container-fluid ">

    <div class="card p-3">
        <h1 class="font-weight-bold text-center"> QUẢN LÍ NHÀ CUNG CẤP</h1>
    </div>

    <div class="card">
        <div class="card-body d-flex flex-row justify-content-between align-items-center">

            <button type="button" class="btn btn-primary p-3" data-bs-toggle="modal" data-bs-target="#addmodal">
                <i class="bi bi-plus-lg"></i>Thêm mới
            </button>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php

            $index = 1;
            ?>
            <table id="data-table" class="table table-bordered table-secondary table-hover display">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Tên nhà cung cấp</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>

                        <th>Chức năng </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td> <?php echo $index;
                                        $index++; ?></td>
                                <td> <?php echo $row['MaNCC']; ?></td>
                                <td> <?php echo $row['TenNCC']; ?> </td>
                                <td> <?php echo $row['DienThoaiNCC']; ?></td>
                                <td> <?php echo $row['DiaChiNCC']; ?> </td>
                                <td>
                                    <!-- DETAIL  -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['MaNCC']; ?>">
                                        Chi tiết
                                    </button> |
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['MaNCC']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="LabelModal">Chi tiết</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <div class="form-group">
                                                            <p><span class="font-weight-bold">Mã nhà cung cấp: </span> <?php echo $row['MaNCC']; ?></p>
                                                            <p><span class="font-weight-bold">Tên nhà cung cấp: </span>  <?php echo $row['TenNCC']; ?></p>
                                                            <p><span class="font-weight-bold">Số điện thoại: </span> <?php echo $row['DienThoaiNCC']; ?></p>
                                                            <p><span class="font-weight-bold">Địa chỉ: </span>  <?php echo $row['DiaChiNCC']; ?></p>

                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- END-DETAIL  -->


                                    <!-- EDIT  -->

                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['MaNCC']; ?>">
                                        Sửa
                                    </button> |

                                    <div class="modal fade" id="ModalEdit<?php echo $row['MaNCC']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Sửa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="Sua_MaNCC" id="MaNCC" value="<?php echo $row['MaNCC']; ?>">

                                                        <div class="form-group">
                                                            <label> Tên nhà cung cấp </label>
                                                            <input required value="<?php echo $row['TenNCC']; ?>" type="text" name="Sua_TenNCC" id="Sua_TenNCC" class="form-control" placeholder="Nhập tên nhà cung cấp">
                                                        </div>
                                                        <div class="form-group">
                                                            <label> Số điện thoại </label>
                                                            <input required value="<?php echo $row['DienThoaiNCC']; ?>" type="text" name="Sua_DienThoaiNCC" id="Sua_DienThoaiNCC" class="form-control" placeholder="Nhập số điện thoại nhà cung cấp">
                                                        </div>
                                                        <div class="form-group">
                                                            <label> Địa chỉ </label>
                                                            <input required value="<?php echo $row['DiaChiNCC']; ?>" type="text" name="Sua_DiaChiNCC" id="Sua_DiaChiNCC" class="form-control" placeholder="Nhập địa chỉ nhà cung cấp">
                                                        </div>



                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="suadulieu" class="btn btn-primary">Cập nhật</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- END-EDITL  -->


                                    <!-- DELETE  -->

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['MaNCC']; ?>">
                                        Xoá
                                    </button>
                                    <div class="modal fade" id="ModalDelete<?php echo $row['MaNCC']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Xoá</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="Xoa_MaNCC" id="Xoa_MaNCC" value="<?php echo $row['MaNCC']; ?>">

                                                        <div class="form-group">

                                                            <label>Xoá nhà cung cấp <span class="text-danger font-weight-bold"> <?php echo $row['TenNCC']; ?></span> sẽ xoá các sản phẩm có loại giày này ?</label>

                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="xoadulieu" class="btn btn-primary">Xoá</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- END-DELETE  -->

                                </td>
                            </tr>

                    <?php  }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>



</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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