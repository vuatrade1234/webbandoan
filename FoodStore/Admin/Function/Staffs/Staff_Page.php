<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Staffs/Handle.php");
?>

<?php
$query = "SELECT * FROM quantrivien";
$query_run = mysqli_query($conn, $query);

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!-- ADD  -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="Label_Add" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Label_Add">Thêm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group ">
                        <label for="Them_TaiKhoan">Tài khoản</label>
                        <input required value="<?php if (isset($Them_TaiKhoan))  echo $Them_TaiKhoan ?>" required type="text" name="Them_TaiKhoan" class="form-control" id="Them_TaiKhoan" placeholder="Nhập tài khoản">
                    </div>

                    <div class="form-group ">
                        <label for="Them_MatKhau">Mật khẩu</label>
                        <input required value="<?php if (isset($Them_MatKhau))  echo $Them_MatKhau ?>" required type="password" name="Them_MatKhau" class="form-control" id="Them_MatKhau" placeholder="Nhập mật khẩu">
                        <small class="text-danger"><?php if (isset($loi))  echo $loi ?></small>

                    </div>
                    <div class="form-group ">
                        <label for="Them_HoTen">Họ tên</label>
                        <div class="form-group">
                            <input required value="<?php if (isset($Them_HoTen))  echo $Them_HoTen ?>" required type="text" name="Them_HoTen" class="form-control" id="Them_HoTen" placeholder="Nhập họ tên">

                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="Them_DienThoai">Điện thoại</label>
                        <input required value="<?php if (isset($Them_DienThoai))  echo $Them_DienThoai ?>" required type="text" name="Them_DienThoai" class="form-control" id="Them_DienThoai" placeholder="Nhập điện thoại">
                    </div>
                    <!-- <div class="form-group ">
                        <label for="Them_ChucVu">Chức vụ</label>
                        <select class="form-control" name="Them_ChucVu" id="">
                            <option  <?php if (isset($Them_ChucVu) and ($Them_ChucVu) == true) echo "selected='selected' ";  ?> value="1">Quản lí</option>
                            <option <?php if (isset($Them_ChucVu) and ($Them_ChucVu) == false) echo "selected='selected' ";  ?> value="0">Nhân viên</option>
                        </select>
                    </div> -->

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
        <h1 class="font-weight-bold text-center"> QUẢN LÍ NHÂN VIÊN</h1>
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
                        <th>Tài khoản</th>
                        <th>Quản lí </th>
                        <th>Ảnh </th>
                        <th>Tên</th>
                        <th>Điện thoại</th>
                        <th>Chức năng</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td> <?php echo $index;
                                        $index++; ?></td>
                                <td> <?php echo $row['MaQTV']; ?></td>
                                <td> <?php echo $row['TaiKhoan']; ?> </td>
                                <td> <?php if($row['QuanLi']) echo "Quản lí"; else echo "Nhân viên" ; ?> </td>
                                <td style="width:50px"><img style="width:100%" src="../Images/ImgAdmins/<?php echo $row['AnhDaiDien'] ?>" alt=""></td>
                                <td> <?php echo $row['HoTen']; ?> </td>
                                <td> <?php echo $row['DienThoaiNV']; ?> </td>
                                <td>
                                    <!-- DETAIL  -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['MaQTV']; ?>">
                                        Chi tiết
                                    </button>
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['MaQTV']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
                                        <div class="modal-dialog modal-xl ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="LabelModal">Chi tiết</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container d-flex justify-content-center mt-50 mb-50">
                                                        <div class="row">
                                                            <div class="col-md-12 ">

                                                                <div class="card card-body ">
                                                                    <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                                                                        <div class="mr-2 mb-3 mb-lg-0">


                                                                            <img src="../Images/ImgAdmins/<?php echo $row['AnhDaiDien'] ?>" width="200" height="200" alt="">

                                                                        </div>

                                                                        <div class="media-body">
                                                                            <h6 class="media-title font-weight-semibold">

                                                                                <p class="text-primary"><?php echo $row['HoTen']; ?></p>
                                                                            </h6>

                                                                            <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                                                                                <li class="list-inline-item text-muted"><?php if ($row['QuanLi'] == 1) echo "Quản lí"; else echo "Nhân viên"?></li>
                                                                                <li class="list-inline-item text-muted"><?php  $row['DienThoaiNV']; ?></li>

                                                                            </ul>

                                                                            <p class="mb-3"><span class="font-weight-bold"> Địa chỉ: </span> <?php if($row["DiaChi"] != null) echo $row['DiaChi']; else echo "Chưa cập nhật"; ?></p>
                                                                            <p class="mb-3"><span class="font-weight-bold"> Email: </span> <?php if($row["Email"] != null) echo $row['Email']; else echo "Chưa cập nhật"; ?></p>



                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>





                                                        </div>
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




                                    <!-- DELETE  -->

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['MaQTV']; ?>">
                                        Xoá
                                    </button>
                                    <div class="modal fade" id="ModalDelete<?php echo $row['MaQTV']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Xoá</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="Xoa_MaQTV" id="Xoa_MaQTV" value="<?php echo $row['MaQTV']; ?>">
                                                  
                                                        <input type="hidden" name="Xoa_AnhDaiDienCu" id="" value="<?php echo $row["AnhDaiDien"] ?>">
                                                   
                                                        <input type="hidden" name="Xoa_QuanLi" id="" value="<?php echo $row["QuanLi"] ?>">
                                                      

                                                        <div class="form-group">
                                                            <label>Bạn có chắc muốn xoá nhân viên <span class="text-danger font-weight-bold"> <?php echo $row['HoTen']; ?></span> không?</label>
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

<style>
.preview1 img{
    width: 50%;
}
</style>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>
<script>
const inputImg1 = document.querySelector('#input-img1')

inputImg1.addEventListener('change', (e) => {
    let file = e.target.files[0]
    console.log(file)
    if (!file) return

    let img = document.createElement('img')
    img.src = URL.createObjectURL(file)

    document.querySelector('.preview1').appendChild(img)
})
</script>
<!-- <img src="../Images/ImgProducts/Image202211051378.jpg" alt="" srcset=""> -->