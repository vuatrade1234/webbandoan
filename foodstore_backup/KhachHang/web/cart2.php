<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="~/css/cart.css">


  <title>Giohang</title>
</head>

<?php
include("Layout_KhachHang_Header.php");
require('Changquantity.php');
$MaKH =  $_SESSION["MaKH"];

// Truy vấn giỏ hàng
$query = "SELECT * FROM giohang 
          JOIN giay ON giohang.MaGiay = giay.MaGiay 
          JOIN khachhang ON giohang.MaKH = khachhang.MaKH 
          WHERE giohang.MaKH = '$MaKH'";
$result = mysqli_query($con, $query);

// Tính tổng tiền
$tongtien = "SELECT SUM(giay.GiaBan * giohang.soluong) 
             FROM giohang 
             JOIN giay ON giohang.MaGiay = giay.MaGiay 
             WHERE giohang.MaKH = '$MaKH'";
$run_tongtien = mysqli_query($con, $tongtien);
$row = mysqli_fetch_row($run_tongtien);
$tinh = $row[0]; // Tổng tiền

// Đếm số lượng sản phẩm
$query2 = "SELECT COUNT(*) as count 
           FROM giohang 
           JOIN giay ON giohang.MaGiay = giay.MaGiay 
           JOIN khachhang ON giohang.MaKH = khachhang.MaKH 
           WHERE giohang.MaKH = '$MaKH'";
$result1 = mysqli_query($con, $query2);
$row1 = mysqli_fetch_assoc($result1);
$count = $row1['count'];

// echo "count".$count;
?>


<body>
  <div class="card-body">
    <h1>Giỏ Hàng Của Tôi</h1>
    <?php if ($count > 0) { ?>

      <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-header py-3">
                <h5 class="mb-0">Giỏ Hàng - <?php echo $count ?> sản phẩm</h5>
              </div>
              <div class="containner" style="margin-top: 10px ;">
                <div class="row text-center">
                  <div class="col-lg-2">
                    <h3>Ảnh</h3>
                  </div>
                  <div class="col-lg-3">
                    <h3>Tên giày</h3>
                  </div>
                  <div class="col-lg-1">
                    <h3>Size giày</h3>
                  </div>
                  <div class="col-lg-1">
                    <h3>Màu giày</h3>
                  </div>
                  <div class="col-lg-2">
                    <h3>Số lượng</h3>
                  </div>
                  <div class="col-lg-2" style="margin-left: -25px ;">
                    <h3>Tổng tiền</h3>
                  </div>

                </div>

                <div class="card-body">
                  <?php if (mysqli_num_rows($result) != 0) { ?>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>

                      <!-- Single item -->
                      <div class="row text-center" style="margin-bottom: 20px">
                        <div class="col-lg-2 col-md-12 mb-4 mb-lg-0">
                          <!-- Image -->
                          <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                            <a href="./details.php?MaGiay=<?php echo $row['MaGiay'] ?>"><img style="width:100px; height: 75px;" src="../../Images/ImgProducts/<?php echo $row['AnhBia']  ?>" /></a>
                            <a href="#!">
                              <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                            </a>
                          </div>
                          <!-- Image -->
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Data -->
                          <p><strong><?php echo $row["TenGiay"]  ?></strong></p>
                          <!-- Data -->
                        </div>
                        <div class="col-lg-1 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Data -->
                          <p><strong><?php echo $row["Sizeee"]  ?></strong></p>
                          <!-- Data -->
                        </div>
                        <div class="col-lg-1 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Data -->
                          <p><strong><?php echo $row["Mauuu"]  ?></strong></p>
                          <!-- Data -->
                        </div>

                        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <!-- Quantity -->
                          <div class="d-flex mb-4" style="max-width: 300px">
                            <form method="post" style="display: flex">
                              <input type="submit" class="btn btn-primary" name="tru" style="width: 40px; text-align: center;" value="-">

                              <div class="form-outline fw-bold">
                                <input name="soluong" value="<?php echo $row["soluong"]  ?>" type="text" class="form-control w-5" style="width: 100px; text-align: center;" />
                                <input type="hidden" name="maId" value="<?php echo $row['id'] ?>">

                              </div>

                              <input type="submit" class="btn btn-primary" name="cong" style="width: 40px;text-align: center;" value="+">
                              </input>
                            </form>
                          </div>
                          <!-- Quantity -->

                          <!-- Price -->

                          <!-- Price -->

                        </div>

                        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 fw-bold ">
                          <!-- Data -->
                          <p class="text-start text-md-center fw-bold " style="margin-left: 20px ;">
                            <strong style="padding-right: 30px;"><?php echo number_format($row['GiaBan'] * $row['soluong'], 0, ',', '.')   ?>
                            </strong>
                          </p>
                          <!-- Data -->
                        </div>
                        <div class="col-lg-1 col-md-6 mb-4 mb-lg-0 fw-bold">
                          <a href="xoa.php?id=<?php echo $row["id"] ?>" class="btn btn-danger" style="height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                          </a>
                        </div>
                      </div>







                  <?php  }
                  } ?>
                </div>

              </div>
              <div class="card-body ">
                <ul class="list-group list-group-flush justify-content-end">
                  <li class="list-group-item d-flex justify-content-start align-items-center border-0 px-0 mb-3" style="color: #20E3B2; font-size: 30px;   font-weight: bold;">
                    <span style="margin-left:auto"> </span>
                    <p> <?php echo "Tổng Tiền: ";
                        echo number_format((float) $tinh, 0, ',', '.') . " VND";
                        ?></p>
                  </li>
                  <a href="./oder.php" class="btn btn-primary btn-lg align-items-end">
                    Đặt hàng ngay
                  </a>
                </ul>


              </div>
              <!-- <div class="text-right mt-4">
            <label class="text-muted font-weight-normal m-0">Total price</label>
            <div class="text-large"><strong>

              </strong></div>
          </div>
          <div class="float-right">
            <a href="./oder.php" class="btn btn-lg btn-primary mt-2 text-light">Mua Hàng</a>
          </div> -->
            <?php echo "</div>
          </div>
        </div>
      </div>
    </div>";
          } else { ?>
              <img src="trong.png" class="img">
            <?php } ?>
            <?php include("Layout_KhachHang_Footer.php"); ?>
</body>

</html>
<style>
  .img {
    align-items: center;
    margin: 0 auto;
    display: flex;
    justify-content: center;
  }


  h1 {
    align-items: center;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    font-size: 40px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .gradient-custom {
    /* fallback for old browsers */
    background: #6a11cb;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
  }

  .mid-grid-left {
    display: none;
  }
</style>