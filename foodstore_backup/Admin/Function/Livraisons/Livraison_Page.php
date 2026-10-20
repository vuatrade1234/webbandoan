<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Livraisons/Handle.php");
?>




<?php
$query = "SELECT * FROM nhanviengiaohang";
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
                        <label for="Them_HoTen">Họ Tên</label>
                        <input required value="<?php if (isset($Them_HoTen))  echo $Them_HoTen ?>" required type="text" name="Them_HoTen" class="form-control" id="Them_HoTen" placeholder="Nhập họ tên">
                    </div>

                    <div class="form-group ">
                        <label for="Them_DienThoaiNV">Điện thoại</label>
                        <input required value="<?php if (isset($Them_DienThoaiNV))  echo $Them_DienThoaiNV ?>" required type="text" name="Them_DienThoaiNV" class="form-control" id="Them_DienThoaiNV" placeholder="Nhập điện thoại">
                        <small class="text-danger"><?php if (isset($loi))  echo $loi ?></small>

                    </div>

                    <div class="form-group ">
                        <label for="Them_AnhDaiDien">Ảnh</label>
                        <label for="input-img1" class="preview1">
                        </label>
                        <input id="input-img1" accept=".jpg, .jpeg, .png" required value="<?php if (isset($Them_AnhDaiDien))  echo $Them_AnhDaiDien ?>" required type="file" name="Them_AnhDaiDien" class="form-control">


                    </div>
                    <div class="form-group ">

                        <label for="Them_DiaChi">Địa chỉ</label>
                        <input required value="<?php if (isset($Them_DiaChi))  echo $Them_DiaChi ?>" required type="text" name="Them_DiaChi" class="form-control" id="Them_DiaChi" placeholder="Nhập Địa chỉ">

                    </div>
                    <div class="form-group ">

                        <label for="Them_Email">Email</label>
                        <input required value="<?php if (isset($Them_Email))  echo $Them_Email ?>" required type="text" name="Them_Email" class="form-control" id="Them_Email" placeholder="Nhập Email">

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
        <h1 class="font-weight-bold text-center"> QUẢN LÍ NHÂN VIÊN GIAO HÀNG </h1>
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
                        <th>Họ tên</th>
                        <th>Điện thoại </th>
                        <th>Ảnh</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td> <?php echo $index;
                                        $index++; ?></td>
                                <td> <?php echo $row['MaNVGH']; ?></td>
                                <td> <?php echo $row['HoTen']; ?> </td>
                                <td> <?php echo $row['DienThoaiNV']; ?> </td>
                                <td style="width:50px"><img style="width:100%" src="../Images/ImgLivraisons/<?php echo $row['AnhDaiDien'] ?>" alt=""></td>

                                <td>
                                    <!-- DETAIL  -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['MaNVGH']; ?>">
                                        Chi tiết
                                    </button>
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['MaNVGH']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
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


                                                                            <img src="../Images/ImgLivraisons/<?php echo $row['AnhDaiDien'] ?>" width="200" height="200" alt="">

                                                                        </div>

                                                                        <div class="media-body">
                                                                            <h6 class="media-title font-weight-semibold">

                                                                                <p class="text-primary"><?php echo $row['HoTen']; ?></p>
                                                                            </h6>



                                                                            <p class="mb-3"><?php echo $row['DienThoaiNV']; ?></p>



                                                                            <p class="mb-3"><span class="font-weight-bold"> Địa chỉ: </span> <?php echo $row['DiaChi']; ?> </p>
                                                                            <p class="mb-3"><span class="font-weight-bold"> Email: </span> <?php echo $row['Email']; ?></p>



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


                                    <!-- EDIT  -->

                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['MaNVGH']; ?>">
                                        Sửa
                                    </button>

                                    <div class="modal fade" id="ModalEdit<?php echo $row['MaNVGH']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Sửa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="MaNVGH" id="MaNVGH" value="<?php echo $row['MaNVGH']; ?>">
                                                        <div class="form-group ">
                                                            <label for="Sua_HoTen">Họ tên</label>
                                                            <input required value="<?php echo $row['HoTen']; ?>" required type="text" name="Sua_HoTen" class="form-control" id="Sua_HoTen" placeholder="Nhập họ tên">
                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="Sua_DienThoaiNV">Điện thoại</label>
                                                            <input required value="<?php echo $row['DienThoaiNV']; ?>" required type="text" name="Sua_DienThoaiNV" class="form-control" id="Sua_DienThoaiNV" placeholder="Nhập số điện thoại">
                                                            <small class="text-danger"><?php if (isset($loi))  echo $loi ?></small>

                                                        </div>

                                                        <div class="form-group ">
                                                            <label for="">Ảnh</label>
                                                            <img class="preview" height="200px" src="../Images/ImgLivraisons/<?php echo $row['AnhDaiDien'] ?>" alt="" srcset="">
                                                            <input id="input-img" accept=".jpg, .jpeg, .png" value="" type="file" name="Sua_AnhDaiDien" class="form-control" id="AnhDaiDien" placeholder="Nhập tên ảnh">
                                                            <input type="hidden" name="AnhDaiDienCu" id="" value="<?php echo $row["AnhDaiDien"] ?>">

                                                        </div>

                                                        <div class="form-group ">

                                                            <label for="Sua_DiaChi">Địa chỉ</label>
                                                            <input required value="<?php echo $row['DiaChi']; ?>" required type="text" name="Sua_DiaChi" class="form-control" id="Sua_DiaChi" placeholder="Địa chỉ">

                                                        </div>
                                                        <div class="form-group ">
                                                            <label for="Sua_Email">Email</label>
                                                            <input required value="<?php echo $row['Email']; ?>" required type="text" name="Sua_Email" class="form-control" id="Sua_Email" placeholder="Email">

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

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['MaNVGH']; ?>">
                                        Xoá
                                    </button>
                                    <div class="modal fade" id="ModalDelete<?php echo $row['MaNVGH']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Xoá</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="Xoa_MaNVGH" id="Xoa_MaNVGH" value="<?php echo $row['MaNVGH']; ?>">
                                                        <input type="hidden" name="Xoa_AnhDaiDienCu" id="" value="<?php echo $row["AnhDaiDien"] ?>">

                                                        <div class="form-group">
                                                            <label>Bạn có chắc muốn nhân viên giao hàng <span class="text-danger font-weight-bold"> <?php echo $row['HoTen']; ?></span> không?</label>
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
<script>
    const inputImg = document.querySelector('#input-img')
    inputImg.addEventListener('change', (e) => {
        let file = e.target.files[0]
        console.log(file)
        if (!file) return
        let img = document.createElement('img')
        img = URL.createObjectURL(file)
        document.querySelector('.preview').src = img;
    })
</script>
<style>
    .preview1 img {
        width: 50%;
    }
</style>
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