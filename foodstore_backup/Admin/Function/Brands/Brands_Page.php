<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Brands/Handle.php");
?>

<?php
$query = "SELECT * FROM ThuongHieu";
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
                        <label for="TenTH">Tên thương hiệu</label>
                        <input required value="" required type="text" name="I_TenTH" class="form-control" id="I_TenTH" placeholder="Nhập tên thương hiệu">

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="reset" name="reset" class="btn btn-warning">Xoá dữ liệu</button>
                <button type="submit" name="insertdata" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END ADD  -->



<div class="container-fluid ">

    <div class="card p-3">
        <h1 class="font-weight-bold text-center"> QUẢN LÍ THƯƠNG HIỆU </h1>
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
                        <th>Tên thương hiệu</th>
                        <th>Chức năng </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td> <?php echo $index;
                                        $index++; ?></td>
                                <td> <?php echo $row['MaTH']; ?></td>
                                <td> <?php echo $row['TenTH']; ?> </td>
                                <td>
                                    <!-- DETAIL  -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['MaTH']; ?>">
                                        Chi tiết
                                    </button> |
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['MaTH']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
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
                                                            <p><span class="font-weight-bold">Mã thương hiệu: </span> <?php echo $row['MaTH']; ?></p>
                                                            <p><span class="font-weight-bold">Tên thương hiệu: </span>  <?php echo $row['TenTH']; ?></p>

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

                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['MaTH']; ?>">
                                        Sửa
                                    </button> |

                                    <div class="modal fade" id="ModalEdit<?php echo $row['MaTH']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Sửa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="MaTH" id="MaTH" value="<?php echo $row['MaTH']; ?>">

                                                        <div class="form-group">
                                                            <label> Tên thương hiệu </label>
                                                            <input required value="<?php echo $row['TenTH']; ?>" type="text" name="TenTH" id="TenTH" class="form-control" placeholder="Nhập tên thương hiệu ">
                                                        </div>



                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="updatedata" class="btn btn-primary">Cập nhật</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- END-EDITL  -->


                                    <!-- DELETE  -->

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['MaTH']; ?>">
                                        Xoá
                                    </button>
                                    <div class="modal fade" id="ModalDelete<?php echo $row['MaTH']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Xoá</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="D_MaTH" id="D_MaTH" value="<?php echo $row['MaTH']; ?>">

                                                        <div class="form-group">

                                                            <label>Xoá thương hiệu <span class="text-danger font-weight-bold"> <?php echo $row['TenTH']; ?></span> sẽ xoá các sản phẩm có thương hiệu này ?</label>

                                                        </div>



                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" name="deletedata" class="btn btn-primary">Xoá</button>
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