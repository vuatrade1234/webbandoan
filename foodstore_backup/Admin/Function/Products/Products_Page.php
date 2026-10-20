<?php
include("./Function/Manager/Check_login.php");
include("./Function/Sup/Success.php");
include("./Function/Products/Handle.php");
?>




<?php
$query = "SELECT * FROM Giay join LoaiGiay on Giay.MaLG = LoaiGiay.MaLG join ThuongHieu on Giay.MaTH = ThuongHieu.MaTH";
$query_run = mysqli_query($conn, $query);

$query_brands = "SELECT * FROM ThuongHieu";
$query_run_brands = mysqli_query($conn, $query_brands);
$query_run_brands1 = mysqli_query($conn, $query_brands);
$query_run_brands2 = mysqli_query($conn, $query_brands);



$query_products_type = "SELECT * FROM LoaiGiay";
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
    array_push($arr, $row["MaLG"]);
}
while ($row = mysqli_fetch_array($query_run_products_type2)) {
    array_push($arr1, $row["TenLoaiGiay"]);
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

<!-- ADD  -->
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
                            <div class="form-group ">
                                <label for="I_TenGiay">Tên giày</label>
                                <input required value="<?php if (isset($I_TenGiay))  echo $I_TenGiay ?>" required type="text" name="I_TenGiay" class="form-control" id="I_TenGiay" placeholder="Nhập tên giày">
                            </div>

                            <div class="form-group ">
                                <label for="I_GiaBan">Giá bán</label>
                                <input required value="<?php if (isset($I_GiaBan))  echo $I_GiaBan ?>" required type="text" name="I_GiaBan" class="form-control" id="I_GiaBan" placeholder="Nhập giá bán">
                                <small class="text-danger"><?php if (isset($loi))  echo $loi ?></small>

                            </div>
                            <div class="form-group ">
                                <label for="I_MoTa">Mô tả</label>
                                <div class="form-group shadow-textarea">

                                    <textarea name="I_MoTa" class="form-control z-depth-1" id="I_MoTa" rows="3" placeholder="Nhập mô tả..."><?php if (isset($I_MoTa))  echo $I_MoTa ?></textarea>
                                </div>
                            </div>
                            <!-- <div class="form-group ">
                        <label for="I_AnhBia">Ảnh</label>
                        <input accept=".jpg, .jpeg, .png" required value="<?php if (isset($I_AnhBia))  echo $I_AnhBia ?>" required type="file" name="I_AnhBia" class="form-control" id="I_AnhBia" placeholder="Nhập tên ảnh">
                    </div> -->
                            <div class="form-group ">
                                <label for="I_AnhBia">Ảnh</label>
                                <label for="input-img1" class="preview1">
                                </label>
                                <input id="input-img1" accept=".jpg, .jpeg, .png" required value="<?php if (isset($I_AnhBia))  echo $I_AnhBia ?>" required type="file" name="I_AnhBia" class="form-control">


                            </div>
                            <div class="form-group ">

                                <label for="I_SoLuongTon">Số lượng</label>
                                <input required value="<?php if (isset($I_SoLuongTon))  echo $I_SoLuongTon ?>" required type="text" name="I_SoLuongTon" class="form-control" id="I_SoLuongTon" placeholder="Số lượng">
                                <small class="text-danger"><?php if (isset($loi2))  echo $loi2 ?></small>

                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group ">

                                <label for="I_Size">Size giày</label>
                                <input required value="<?php if (isset($I_Size))  echo $I_Size ?>" required type="text" name="I_Size" class="form-control" id="I_Size" placeholder="Size giày">
                             

                            </div>
                            <div class="form-group ">

                                <label for="I_Màu">Màu sắc</label>
                                <input required value="<?php if (isset($I_Màu))  echo $I_Màu ?>" required type="text" name="I_Màu" class="form-control" id="I_Màu" placeholder="Màu sắc">
                               

                            </div>
                            <div class="form-group ">

                                <label for="I_MaLG">Loại giày</label>
                                <select name="I_MaLG" class="form-select" id="I_MaLG">

                                    <?php while ($row = mysqli_fetch_array($query_run_products_type)) { ?>
                                        <option value="<?php echo $row["MaLG"] ?>"><?php echo $row["TenLoaiGiay"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group ">

                                <label for="I_MaTH">Thương hiệu</label>
                                <select name="I_MaTH" class="form-select" id="I_MaTH">
                                    <?php while ($row = mysqli_fetch_array($query_run_brands)) { ?>
                                        <option value="<?php echo $row["MaTH"] ?>"><?php echo $row["TenTH"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="I_MaNCC">Nhà cung cấp</label>
                                <select name="I_MaNCC" class="form-select" id="I_MaNCC">
                                    <?php while ($row = mysqli_fetch_array($query_run_suppliers)) { ?>
                                        <option value="<?php echo $row["MaNCC"] ?>"><?php echo $row["TenNCC"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
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
        <h1 class="font-weight-bold text-center"> QUẢN LÍ SẢN PHẨM </h1>
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
                        <th>Tên giày</th>
                        <th>Giá bán </th>
                        <th>Ảnh</th>
                        <th>Số lượng</th>
                        <th>Chức năng </th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_run) != 0) {
                        while ($row = mysqli_fetch_array($query_run)) { ?>
                            <tr>
                                <td> <?php echo $index;
                                        $index++; ?></td>
                                <td> <?php echo $row['MaGiay']; ?></td>
                                <td> <?php echo $row['TenGiay']; ?> </td>
                                <td><?php echo number_format($row["GiaBan"], 0, ',', '.'); ?> </td>
                                <td style="width:50px"><img style="width:100%" src="../Images/ImgProducts/<?php echo $row['AnhBia'] ?>" alt=""></td>
                                <td> <?php echo $row['SoLuongTon']; ?> </td>
                                <td>
                                    <!-- DETAIL  -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal_Detail<?php echo $row['MaGiay']; ?>">
                                        Chi tiết
                                    </button>
                                    <div class="modal fade" id="Modal_Detail<?php echo $row['MaGiay']; ?>" tabindex="-1" aria-labelledby="LabelModal" aria-hidden="true">
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


                                                                            <img src="../Images/ImgProducts/<?php echo $row['AnhBia'] ?>" width="200" height="200" alt="">

                                                                        </div>

                                                                        <div class="media-body">
                                                                            <h6 class="media-title font-weight-semibold">

                                                                                <p class="text-primary"><?php echo $row['TenGiay']; ?></p>
                                                                            </h6>

                                                                            <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                                                                                <li class="list-inline-item text-muted"><?php echo $row['TenLoaiGiay']; ?></li>
                                                                                <li class="list-inline-item text-muted"><?php echo $row['TenTH']; ?></li>

                                                                            </ul>

                                                                            <p class="mb-3"><?php echo $row['MoTa']; ?></p>
                                                                            <p class="mb-3"><span class="font-weight-bold">Màu sắc: </span> <?php echo $row['Màu']; ?></p>
                                                                            <p class="mb-3"><span class="font-weight-bold">Size giày: </span> <?php echo $row['Size']; ?></p>


                                                                            <p class="mb-3"><span class="font-weight-bold"> Hiển thị ở trang khách hàng: </span><?php if ($row['HienThiSanPham'] == 1) echo "Có";
                                                                                                                                                                else echo "Không"; ?></p>
                                                                            <p class="mb-3"><span class="font-weight-bold"> Giá bán cũ: </span><?php if ($row["GiaBanCu"] != null) echo number_format($row["GiaBanCu"], 0, ',', '.') . "đồng";
                                                                                                                                                else echo "Chưa cập nhật" ?> </p>
                                                                            <p class="mb-3"><span class="font-weight-bold"> Ngày cập nhật cuối: </span> <?php echo $row['NgayCapNhat']; ?></p>



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

                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['MaGiay']; ?>">
                                        Sửa
                                    </button>

                                    <div class="modal fade" id="ModalEdit<?php echo $row['MaGiay']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-xl ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Sửa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <input type="hidden" name="MaGiay" id="MaGiay" value="<?php echo $row['MaGiay']; ?>">
                                                                <div class="form-group ">
                                                                    <label for="TenGiay">Tên giày</label>
                                                                    <input required value="<?php echo $row['TenGiay']; ?>" required type="text" name="TenGiay" class="form-control" id="TenGiay" placeholder="Nhập tên giày">
                                                                </div>

                                                                <div class="form-group ">
                                                                    <label for="GiaBan">Giá bán</label>
                                                                    <input required value="<?php echo $row['GiaBan']; ?>" required type="text" name="GiaBan" class="form-control" id="GiaBan" placeholder="Nhập giá bán">
                                                                    <small class="text-danger"><?php if (isset($loi))  echo $loi ?></small>

                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="MoTa">Mô tả</label>
                                                                    <div class="form-group shadow-textarea">

                                                                        <textarea name="MoTa" class="form-control z-depth-1" id="MoTa" rows="3" placeholder="Nhập mô tả..."><?php echo $row['MoTa']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="">Ảnh</label>
                                                                    <img class="preview" height="200px" src="../Images/ImgProducts/<?php echo $row['AnhBia'] ?>" alt="" srcset="">
                                                                    <input id="input-img" accept=".jpg, .jpeg, .png" value="" type="file" name="AnhBia" class="form-control" id="AnhBia" placeholder="Nhập tên ảnh">
                                                                    <input type="hidden" name="AnhBiaCu" id="" value="<?php echo $row["AnhBia"] ?>">

                                                                </div>


                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group ">

                                                                    <label for="SoLuongTon">Số lượng</label>
                                                                    <input required value="<?php echo $row['SoLuongTon']; ?>" required type="text" name="SoLuongTon" class="form-control" id="SoLuongTon" placeholder="Số lượng">
                                                                    <small class="text-danger"><?php if (isset($loi2))  echo $loi2 ?></small>

                                                                </div>
                                                                <div class="form-group ">

                                                                    <label for="Size">Size giày</label>
                                                                    <input required value="<?php echo $row['Size']; ?>" required type="text" name="Size" class="form-control" id="Size" placeholder="Size giày">
                                                              

                                                                </div>
                                                                <div class="form-group ">

                                                                    <label for="Màu">Màu sắc</label>
                                                                    <input required value="<?php echo $row['Màu']; ?>" required type="text" name="Màu" class="form-control" id="Màu" placeholder="Số lượng">
 

                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="GiaBanCu">Giá Bán Cũ</label>
                                                                    <input class="form-control" type="text" name="GiaBanCu" value="<?php echo $row["GiaBanCu"] ?>">
                                                                    <small class="text-danger"><?php if (isset($loi3))  echo $loi3 ?></small>

                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="MaLG">Loại giày</label>
                                                                    <select name="MaLG" class="form-select" id="MaLG">
                                                                        <?php for ($i = 0; $i < count($arr); $i++) {  ?>
                                                                            <option <?php if ($row["MaLG"] == $arr[$i]) echo "selected='selected' ";  ?> value="<?php echo $arr[$i]; ?>"><?php echo $arr1[$i]; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="MaTH">Thương hiệu</label>
                                                                    <select name="MaTH" class="form-select" id="MaTH">
                                                                        <?php for ($i = 0; $i < count($arr2); $i++) {  ?>
                                                                            <option <?php if ($row["MaTH"] == $arr2[$i]) echo "selected='selected' ";  ?> value="<?php echo $arr2[$i]; ?>"><?php echo $arr3[$i]; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="MaNCC">Nhà cung cấp</label>
                                                                    <select name="MaNCC" class="form-select" id="MaNCC">
                                                                        <?php for ($i = 0; $i < count($arr4); $i++) {  ?>
                                                                            <option <?php if ($row["MaNCC"] == $arr4[$i]) echo "selected='selected' ";  ?> value="<?php echo $arr4[$i]; ?>"><?php echo $arr5[$i]; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                            </div>
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

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete<?php echo $row['MaGiay']; ?>">
                                        Xoá
                                    </button>
                                    <div class="modal fade" id="ModalDelete<?php echo $row['MaGiay']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg ">
                                            <!-- modal-xl -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Label_Edit">Xoá</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="post">

                                                        <input type="hidden" name="D_MaGiay" id="D_MaGiay" value="<?php echo $row['MaGiay']; ?>">
                                                        <input type="hidden" name="D_AnhBiaCu" id="" value="<?php echo $row["AnhBia"] ?>">

                                                        <div class="form-group">
                                                            <label>Bạn có chắc muốn xoá sản phẩm <span class="text-danger font-weight-bold"> <?php echo $row['TenGiay']; ?></span> không?</label>
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
                                <td>
                                    <!-- Status  -->
                                    <?php if ($row["HienThiSanPham"] == 1) { ?>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModelStatus<?php echo $row['MaGiay']; ?>">
                                            Bật <i class="bi bi-lightbulb"></i>
                                        </button>
                                        <div class="modal fade" id="ModelStatus<?php echo $row['MaGiay']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                            <div class="modal-dialog modal-lg ">
                                                <!-- modal-xl -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Label_Edit">Ẩn sản phẩm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">

                                                            <input type="hidden" name="S_MaGiay" id="S_MaGiay" value="<?php echo $row['MaGiay']; ?>">

                                                            <div class="form-group">
                                                                <label>Bạn có chắc muốn ẩn sản phẩm <span class="text-danger font-weight-bold"> <?php echo $row['TenGiay']; ?></span> không?</label>
                                                            </div>



                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" name="hidedata" class="btn btn-primary">Ẩn</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>

                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModelStatus<?php echo $row['MaGiay']; ?>">
                                            Tắt <i class="bi bi-lightbulb-off"></i>
                                        </button>
                                        <div class="modal fade" id="ModelStatus<?php echo $row['MaGiay']; ?>" tabindex="-1" aria-labelledby="Label_Edit" aria-hidden="true">
                                            <div class="modal-dialog modal-lg ">
                                                <!-- modal-xl -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Label_Edit">Xoá</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">

                                                            <input type="hidden" name="SS_MaGiay" id="SS_MaGiay" value="<?php echo $row['MaGiay']; ?>">

                                                            <div class="form-group">
                                                                <label>Bạn có chắc muốn hiện sản phẩm <span class="text-danger font-weight-bold"> <?php echo $row['TenGiay']; ?></span> không?</label>
                                                            </div>



                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" name="showdata" class="btn btn-primary">Hiện</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                    <!-- END-Status  -->
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
        width: 30%;
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