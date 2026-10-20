

<?php
include_once __DIR__ . '/ProductPricing.php';

function save_product_images($field, $productId)
{
  if (!isset($_FILES[$field]['name'])) {
    return [];
  }

  $fileNames = is_array($_FILES[$field]['name']) ? $_FILES[$field]['name'] : [$_FILES[$field]['name']];
  $fileErrors = is_array($_FILES[$field]['error']) ? $_FILES[$field]['error'] : [$_FILES[$field]['error']];
  $fileSizes = is_array($_FILES[$field]['size']) ? $_FILES[$field]['size'] : [$_FILES[$field]['size']];
  $fileTemps = is_array($_FILES[$field]['tmp_name']) ? $_FILES[$field]['tmp_name'] : [$_FILES[$field]['tmp_name']];
  $savedImages = [];
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
  
  $uploadDirectory = __DIR__ . '/../../../../Images/ImgProducts/';
  if (!is_dir($uploadDirectory)) {
    $uploadDirectory = '../Images/ImgProducts/';
  }
  if (!is_dir($uploadDirectory)) {
    @mkdir($uploadDirectory, 0777, true);
  }

  foreach ($fileNames as $index => $originalName) {
    if ($fileErrors[$index] === UPLOAD_ERR_NO_FILE) {
      continue;
    }

    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    if ($fileErrors[$index] !== UPLOAD_ERR_OK || !in_array($extension, $allowedExtensions, true) || $fileSizes[$index] > 10000000) {
      foreach ($savedImages as $savedImage) {
        @unlink($uploadDirectory . $savedImage);
      }
      return false;
    }

    $fileName = 'product_' . (int) $productId . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    if (!move_uploaded_file($fileTemps[$index], $uploadDirectory . $fileName)) {
      foreach ($savedImages as $savedImage) {
        @unlink($uploadDirectory . $savedImage);
      }
      return false;
    }
    $savedImages[] = $fileName;
  }

  return $savedImages;
}

if (isset($_POST['updatedata'])) {
  $id = $_POST['MaSP'];
  $TenSP = $_POST['TenSP'];
  $GiaBan = $_POST['GiaBan'];
  $Size = $_POST['Size'];
  $Màu = $_POST['Màu'];
  $MoTa = $_POST['MoTa'];
  // $NgayCapNhat = $_POST['NgayCapNhat'];
  $SoLuongTon = $_POST['SoLuongTon'];
  $MaLSP = $_POST['MaLSP'];
  $MaTH = !empty($_POST['MaTH']) ? "'" . (int) $_POST['MaTH'] . "'" : "NULL";
  $MaNCC = $_POST['MaNCC'];

  $GiaBanCu = 0;
  if (!empty($_POST["GiaBanCu"])) {
    $GiaBanCu = $_POST['GiaBanCu'];
  }
  $uploadedCover = save_product_images('AnhBia', $id);
  $uploadedGallery = save_product_images('AnhPhu', $id);
  if ($uploadedCover !== false && $uploadedGallery !== false && is_numeric($SoLuongTon) && is_numeric($GiaBan) && is_numeric($GiaBanCu)) {
    $coverUpdate = empty($uploadedCover) ? '' : ", AnhBia = '" . mysqli_real_escape_string($conn, $uploadedCover[0]) . "'";
    $query = "UPDATE Giay SET TenSP='$TenSP',GiaBan =$GiaBan,MoTa ='$MoTa',NgayCapNhat = now(),SoLuongTon =$SoLuongTon,MaLSP =$MaLSP,MaTH =$MaTH ,MaNCC =$MaNCC  ,GiaBanCu =$GiaBanCu,Size = '$Size',Màu = '$Màu'$coverUpdate WHERE MaSP='$id'  ";
    if (mysqli_query($conn, $query)) {
      if (!empty($uploadedCover)) {
        $previousCover = $_POST['AnhBiaCu'] ?? '';
        if ($previousCover !== $uploadedCover[0] && strpos($previousCover, 'product_' . (int) $id . '_') === 0 && is_file('../Images/ImgProducts/' . basename($previousCover))) {
          unlink('../Images/ImgProducts/' . basename($previousCover));
        }
      }
      Edit();
    } else {
      foreach (array_merge($uploadedCover ?: [], $uploadedGallery ?: []) as $uploadedImage) {
        if (is_file('../Images/ImgProducts/' . $uploadedImage)) {
          unlink('../Images/ImgProducts/' . $uploadedImage);
        }
      }
      echo "<script>alert('Không thể cập nhật sản phẩm.');</script>";
    }
  } else {
    foreach (array_merge($uploadedCover ?: [], $uploadedGallery ?: []) as $uploadedImage) {
      if (is_file('../Images/ImgProducts/' . $uploadedImage)) {
        unlink('../Images/ImgProducts/' . $uploadedImage);
      }
    }
    echo "<script>alert('Dữ liệu chưa được sửa hoặc ảnh không hợp lệ. Vui lòng kiểm tra ảnh (JPG/PNG, tối đa 10MB mỗi ảnh) và các thông tin.');</script>";
  }
}
?>


<?php
if (isset($_POST['deletedata'])) {
  $id = $_POST['D_MaSP'];
  $AnhBiaCu = $_POST['D_AnhBiaCu'];
  $path1 = "../Images/ImgProducts/". $AnhBiaCu;
  $query = "DELETE FROM sanpham WHERE MaSP='$id'";
  $query_run_1 = mysqli_query($conn,"DELETE FROM chitietdathang WHERE MaSP='$id'");
  $query_run = mysqli_query($conn, $query);
  

  if ($query_run and  $query_run_1) {
    if (is_file($path1)) {
      unlink($path1);
    }
    foreach (glob('../Images/ImgProducts/product_' . (int) $id . '_*') as $productImage) {
      if (is_file($productImage)) {
        unlink($productImage);
      }
    }
    Delete();
  } else {
    echo '<script> alert("Chưa xoá"); </script>';
  }
}

?>


<?php

if (isset($_POST['insertdata'])) {
  $I_TenSP = $_POST['I_TenSP'];
  $I_GiaBan = $_POST['I_GiaBan'];
  $I_Size = $_POST['I_Size'];
  $I_Màu = $_POST['I_Màu'];

  $I_MoTa = $_POST['I_MoTa'];
  // $I_NgayCapNhat = $_POST['I_NgayCapNhat'];
  $I_SoLuongTon = $_POST['I_SoLuongTon'];
  $I_MaLSP = $_POST['I_MaLSP'];
  $I_MaTH = !empty($_POST['I_MaTH']) ? "'" . (int) $_POST['I_MaTH'] . "'" : "NULL";
  $I_MaNCC = $_POST['I_MaNCC'];
  if (!is_numeric($I_SoLuongTon) || !is_numeric($I_GiaBan) || empty($_FILES['I_AnhBia']['name'])) {
    echo "<script>alert('Vui lòng nhập đúng giá, tồn kho và chọn một ảnh bìa.');</script>";
  } else {
    $query1 = "INSERT INTO Giay (MaSP, TenSP, GiaBan, MoTa, AnhBia, NgayCapNhat, SoLuongTon, MaLSP, MaTH, MaNCC, HienThiSanPham, GiaBanCu, Size, `Màu`) VALUES (NULL, '$I_TenSP', '$I_GiaBan', '$I_MoTa', NULL, NOW(), '$I_SoLuongTon', '$I_MaLSP', $I_MaTH, '$I_MaNCC', 1, NULL, '$I_Size', '$I_Màu')";
    if (mysqli_query($conn, $query1)) {
      $productId = mysqli_insert_id($conn);
      $uploadedCover = save_product_images('I_AnhBia', $productId);
      $uploadedGallery = save_product_images('I_AnhPhu', $productId);
      if ($uploadedCover !== false && count($uploadedCover) === 1 && $uploadedGallery !== false) {
        $coverImage = mysqli_real_escape_string($conn, $uploadedCover[0]);
        if (mysqli_query($conn, "UPDATE Giay SET AnhBia = '$coverImage' WHERE MaSP = '$productId'")) {
          Add();
        } else {
          mysqli_query($conn, "DELETE FROM sanpham WHERE MaSP = '$productId'");
          foreach (array_merge($uploadedCover, $uploadedGallery) as $uploadedImage) {
            if (is_file('../Images/ImgProducts/' . $uploadedImage)) {
              unlink('../Images/ImgProducts/' . $uploadedImage);
            }
          }
          echo "<script>alert('Không thể lưu ảnh bìa sản phẩm. Vui lòng thử lại.');</script>";
        }
      } else {
        mysqli_query($conn, "DELETE FROM sanpham WHERE MaSP = '$productId'");
        foreach (array_merge($uploadedCover ?: [], $uploadedGallery ?: []) as $uploadedImage) {
          if (is_file('../Images/ImgProducts/' . $uploadedImage)) {
            unlink('../Images/ImgProducts/' . $uploadedImage);
          }
        }
        echo "<script>alert('Không thể lưu ảnh sản phẩm. Chọn ảnh JPG/PNG tối đa 10MB mỗi ảnh.');</script>";
      }
    } else {
      echo "<script>alert('Chưa thêm được sản phẩm.');</script>";
    }
  }
}
?>

<?php
if (isset($_POST['hidedata'])) {
  $id = $_POST['S_MaSP'];
  $query = "UPDATE Giay SET HienThiSanPham=0  WHERE MaSP='$id'  ";
  $query_run = mysqli_query($conn, $query);
  if ($query_run) {
    Edit();
  } else {
    echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
  }
}
?>


<?php


if (isset($_POST['showdata'])) {
  $id = $_POST['SS_MaSP'];
  $query = "UPDATE Giay SET HienThiSanPham=1  WHERE MaSP='$id'  ";
  $query_run = mysqli_query($conn, $query);
  if ($query_run) {
    Edit();
  } else {
    echo '<script> alert("Dữ liệu chưa được cập nhật"); </script>';
  }
}

?>

