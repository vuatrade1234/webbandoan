<?php
include("./Connect_DB/connect.php");

function ensure_voucher_admin_schema($conn)
{
    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS `voucher` (
            `MaVC` int NOT NULL AUTO_INCREMENT,
            `MaCode` varchar(50) NOT NULL,
            `TenVoucher` varchar(100) NOT NULL,
            `LoaiGiam` varchar(20) NOT NULL DEFAULT 'percent',
            `GiaTri` decimal(15,2) NOT NULL DEFAULT 0,
            `DieuKienDonToiThieu` decimal(15,2) NOT NULL DEFAULT 0,
            `NgayBatDau` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `NgayKetThuc` datetime NULL DEFAULT NULL,
            `TrangThai` tinyint(1) NOT NULL DEFAULT 1,
            `SoLuong` int NOT NULL DEFAULT 1,
            `SoLanDaDung` int NOT NULL DEFAULT 0,
            `DoiTuong` varchar(20) NOT NULL DEFAULT 'all',
            `SoNgayKhachMoi` int NOT NULL DEFAULT 30,
            `SoDonTu` int NOT NULL DEFAULT 0,
            `SoDonDen` int NULL DEFAULT NULL,
            PRIMARY KEY (`MaVC`),
            UNIQUE KEY `uk_voucher_code` (`MaCode`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ") or die(mysqli_error($conn));

    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS `voucher_customer_usage` (
            `MaVC` int NOT NULL,
            `MaKH` int NOT NULL,
            `SoDH` int NULL DEFAULT NULL,
            `NgaySuDung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`MaVC`, `MaKH`),
            KEY `idx_voucher_usage_customer` (`MaKH`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ") or die(mysqli_error($conn));

    mysqli_query($conn, "ALTER TABLE `khachhang` ADD COLUMN IF NOT EXISTS `NgayTaoTaiKhoan` DATETIME NULL DEFAULT NULL") or die(mysqli_error($conn));
    mysqli_query($conn, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `DoiTuong` VARCHAR(20) NOT NULL DEFAULT 'all'") or die(mysqli_error($conn));
    mysqli_query($conn, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `SoNgayKhachMoi` INT NOT NULL DEFAULT 30") or die(mysqli_error($conn));
    mysqli_query($conn, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `SoDonTu` INT NOT NULL DEFAULT 0") or die(mysqli_error($conn));
    mysqli_query($conn, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `SoDonDen` INT NULL DEFAULT NULL") or die(mysqli_error($conn));

    mysqli_query($conn, "INSERT IGNORE INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`) VALUES
        ('WELCOME10', 'Chào mừng mới', 'percent', 10, 200000, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY), 1, 999, 0),
        ('FREESHIP', 'Miễn phí ship', 'fixed', 30000, 300000, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY), 1, 999, 0),
        ('SAVE50', 'Giảm 50k', 'fixed', 50000, 500000, NOW(), DATE_ADD(NOW(), INTERVAL 120 DAY), 1, 999, 0)") or die(mysqli_error($conn));

    mysqli_query($conn, "INSERT IGNORE INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`, `DoiTuong`, `SoNgayKhachMoi`, `SoDonTu`, `SoDonDen`) VALUES
        ('KHMOI10', 'Khách hàng mới giảm 10%', 'percent', 10, 0, NOW(), NULL, 1, 999999, 0, 'new', 30, 0, NULL),
        ('DON100K20', 'Đơn từ 100.000đ giảm 20%', 'percent', 20, 100000, NOW(), NULL, 1, 999999, 0, 'all', 30, 0, NULL),
        ('DON500K30', 'Đơn từ 500.000đ giảm 30%', 'percent', 30, 500000, NOW(), NULL, 1, 999999, 0, 'all', 30, 0, NULL)") or die(mysqli_error($conn));
    foreach ([
        "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `MaVoucher` INT NULL DEFAULT NULL",
        "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `VoucherCode` VARCHAR(50) NULL DEFAULT NULL",
        "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `TienGiam` DECIMAL(15,2) NOT NULL DEFAULT 0",
        "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `TongTienSauGiam` DECIMAL(15,2) NOT NULL DEFAULT 0",
    ] as $sql) {
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }

    mysqli_query($conn, "INSERT IGNORE INTO `voucher_customer_usage` (`MaVC`, `MaKH`, `SoDH`, `NgaySuDung`)
        SELECT v.`MaVC`, d.`MaKH`, d.`SoDH`, COALESCE(d.`NgayDat`, NOW())
        FROM `dondathang` d
        JOIN `voucher` v ON v.`MaCode` = d.`VoucherCode`
        WHERE d.`MaKH` IS NOT NULL AND d.`VoucherCode` IS NOT NULL AND d.`VoucherCode` <> ''") or die(mysqli_error($conn));

}

ensure_voucher_admin_schema($conn);

if (isset($_POST['insert_voucher'])) {
    $maCode = strtoupper(trim($_POST['MaCode'] ?? ''));
    $tenVoucher = trim($_POST['TenVoucher'] ?? '');
    $loaiGiam = strtolower(trim($_POST['LoaiGiam'] ?? 'percent'));
    $giaTri = (float) ($_POST['GiaTri'] ?? 0);
    $dieuKien = (float) ($_POST['DieuKienDonToiThieu'] ?? 0);
    $ngayBatDau = $_POST['NgayBatDau'] ?? date('Y-m-d H:i:s');
    $ngayKetThuc = !empty($_POST['NgayKetThuc']) ? $_POST['NgayKetThuc'] : null;
    $trangThai = isset($_POST['TrangThai']) ? 1 : 0;
    $soLuong = max(1, (int) ($_POST['SoLuong'] ?? 1));
    $doiTuong = in_array($_POST['DoiTuong'] ?? 'all', ['all', 'new', 'returning'], true) ? $_POST['DoiTuong'] : 'all';
    $soNgayKhachMoi = max(1, (int) ($_POST['SoNgayKhachMoi'] ?? 30));

    // Validate ngày kết thúc không được trước ngày bắt đầu
    if ($ngayKetThuc && strtotime($ngayKetThuc) < strtotime($ngayBatDau)) {
        echo "<script>alert('Lỗi: Ngày kết thúc không thể trước ngày bắt đầu!');</script>";
    } elseif ($maCode !== '' && $tenVoucher !== '') {
        $safeCode = mysqli_real_escape_string($conn, $maCode);
        $safeTen = mysqli_real_escape_string($conn, $tenVoucher);
        $safeLoai = in_array($loaiGiam, ['percent', 'fixed']) ? $loaiGiam : 'percent';
        $safeStart = mysqli_real_escape_string($conn, $ngayBatDau);
        $safeEnd = $ngayKetThuc ? "'" . mysqli_real_escape_string($conn, $ngayKetThuc) . "'" : 'NULL';
        $safeAudience = mysqli_real_escape_string($conn, $doiTuong);
        mysqli_query($conn, "INSERT INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`, `DoiTuong`, `SoNgayKhachMoi`, `SoDonTu`, `SoDonDen`) VALUES ('$safeCode', '$safeTen', '$safeLoai', '$giaTri', '$dieuKien', '$safeStart', $safeEnd, '$trangThai', '$soLuong', 0, '$safeAudience', '$soNgayKhachMoi', 0, NULL)") or die(mysqli_error($conn));
    }
}

if (isset($_POST['update_voucher'])) {
    $maVC = (int) ($_POST['MaVC'] ?? 0);
    if ($maVC > 0) {
        $maCode = strtoupper(trim($_POST['MaCode'] ?? ''));
        $tenVoucher = trim($_POST['TenVoucher'] ?? '');
        $loaiGiam = strtolower(trim($_POST['LoaiGiam'] ?? 'percent'));
        $giaTri = (float) ($_POST['GiaTri'] ?? 0);
        $dieuKien = (float) ($_POST['DieuKienDonToiThieu'] ?? 0);
        $ngayBatDau = $_POST['NgayBatDau'] ?? date('Y-m-d H:i:s');
        $ngayKetThuc = !empty($_POST['NgayKetThuc']) ? $_POST['NgayKetThuc'] : null;
        $trangThai = isset($_POST['TrangThai']) ? 1 : 0;
        $soLuong = max(1, (int) ($_POST['SoLuong'] ?? 1));
        $doiTuong = in_array($_POST['DoiTuong'] ?? 'all', ['all', 'new', 'returning'], true) ? $_POST['DoiTuong'] : 'all';
        $soNgayKhachMoi = max(1, (int) ($_POST['SoNgayKhachMoi'] ?? 30));

        // Validate ngày kết thúc không được trước ngày bắt đầu
        if ($ngayKetThuc && strtotime($ngayKetThuc) < strtotime($ngayBatDau)) {
            echo "<script>alert('Lỗi: Ngày kết thúc không thể trước ngày bắt đầu!');</script>";
        } else {
            $safeCode = mysqli_real_escape_string($conn, $maCode);
            $safeTen = mysqli_real_escape_string($conn, $tenVoucher);
            $safeLoai = in_array($loaiGiam, ['percent', 'fixed']) ? $loaiGiam : 'percent';
            $safeAudience = mysqli_real_escape_string($conn, $doiTuong);
            $safeStart = mysqli_real_escape_string($conn, $ngayBatDau);
            $safeEnd = $ngayKetThuc ? "'" . mysqli_real_escape_string($conn, $ngayKetThuc) . "'" : 'NULL';

            mysqli_query($conn, "UPDATE `voucher` SET `MaCode` = '$safeCode', `TenVoucher` = '$safeTen', `LoaiGiam` = '$safeLoai', `GiaTri` = '$giaTri', `DieuKienDonToiThieu` = '$dieuKien', `NgayBatDau` = '$safeStart', `NgayKetThuc` = $safeEnd, `TrangThai` = '$trangThai', `SoLuong` = '$soLuong', `DoiTuong` = '$safeAudience', `SoNgayKhachMoi` = '$soNgayKhachMoi', `SoDonTu` = 0, `SoDonDen` = NULL WHERE `MaVC` = '$maVC'") or die(mysqli_error($conn));
        }
    }
}

if (isset($_POST['delete_voucher'])) {
    $maVC = (int) ($_POST['MaVC'] ?? 0);
    if ($maVC > 0) {
        mysqli_query($conn, "DELETE FROM `voucher` WHERE `MaVC` = '$maVC'") or die(mysqli_error($conn));
    }
}
