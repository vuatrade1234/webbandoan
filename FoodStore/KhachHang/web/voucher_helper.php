<?php
if (!function_exists('ensure_voucher_schema')) {
    function ensure_voucher_schema($con)
    {
        mysqli_query($con, "
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
        ") or die(mysqli_error($con));

        mysqli_query($con, "
            CREATE TABLE IF NOT EXISTS `voucher_customer_usage` (
                `MaVC` int NOT NULL,
                `MaKH` int NOT NULL,
                `SoDH` int NULL DEFAULT NULL,
                `NgaySuDung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`MaVC`, `MaKH`),
                KEY `idx_voucher_usage_customer` (`MaKH`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ") or die(mysqli_error($con));

        mysqli_query($con, "ALTER TABLE `khachhang` ADD COLUMN IF NOT EXISTS `NgayTaoTaiKhoan` DATETIME NULL DEFAULT NULL") or die(mysqli_error($con));
        mysqli_query($con, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `DoiTuong` VARCHAR(20) NOT NULL DEFAULT 'all'") or die(mysqli_error($con));
        mysqli_query($con, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `SoNgayKhachMoi` INT NOT NULL DEFAULT 30") or die(mysqli_error($con));
        mysqli_query($con, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `SoDonTu` INT NOT NULL DEFAULT 0") or die(mysqli_error($con));
        mysqli_query($con, "ALTER TABLE `voucher` ADD COLUMN IF NOT EXISTS `SoDonDen` INT NULL DEFAULT NULL") or die(mysqli_error($con));

        $orderColumns = [
            'MaVoucher' => "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `MaVoucher` INT NULL DEFAULT NULL",
            'VoucherCode' => "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `VoucherCode` VARCHAR(50) NULL DEFAULT NULL",
            'TienGiam' => "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `TienGiam` DECIMAL(15,2) NOT NULL DEFAULT 0",
            'TongTienSauGiam' => "ALTER TABLE `dondathang` ADD COLUMN IF NOT EXISTS `TongTienSauGiam` DECIMAL(15,2) NOT NULL DEFAULT 0",
        ];

        foreach ($orderColumns as $sql) {
            mysqli_query($con, $sql) or die(mysqli_error($con));
        }

        mysqli_query($con, "INSERT IGNORE INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`) VALUES
            ('WELCOME10', 'Chào mừng mới', 'percent', 10, 200000, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY), 1, 999, 0),
            ('FREESHIP', 'Miễn phí ship', 'fixed', 30000, 300000, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY), 1, 999, 0),
            ('SAVE50', 'Giảm 50k', 'fixed', 50000, 500000, NOW(), DATE_ADD(NOW(), INTERVAL 120 DAY), 1, 999, 0)
        ") or die(mysqli_error($con));

        mysqli_query($con, "INSERT IGNORE INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`, `DoiTuong`, `SoNgayKhachMoi`, `SoDonTu`, `SoDonDen`) VALUES
            ('KHMOI10', 'Khách hàng mới giảm 10%', 'percent', 10, 0, NOW(), NULL, 1, 999999, 0, 'new', 30, 0, NULL),
            ('DON100K20', 'Đơn từ 100.000đ giảm 20%', 'percent', 20, 100000, NOW(), NULL, 1, 999999, 0, 'all', 30, 0, NULL),
            ('DON500K30', 'Đơn từ 500.000đ giảm 30%', 'percent', 30, 500000, NOW(), NULL, 1, 999999, 0, 'all', 30, 0, NULL)
        ") or die(mysqli_error($con));
        mysqli_query($con, "INSERT IGNORE INTO `voucher_customer_usage` (`MaVC`, `MaKH`, `SoDH`, `NgaySuDung`)
            SELECT v.`MaVC`, d.`MaKH`, d.`SoDH`, COALESCE(d.`NgayDat`, NOW())
            FROM `dondathang` d
            JOIN `voucher` v ON v.`MaCode` = d.`VoucherCode`
            WHERE d.`MaKH` IS NOT NULL AND d.`VoucherCode` IS NOT NULL AND d.`VoucherCode` <> ''") or die(mysqli_error($con));
    }
}

if (!function_exists('normalize_voucher_code')) {
    function normalize_voucher_code($value)
    {
        return strtoupper(trim((string) $value));
    }
}

if (!function_exists('get_voucher_by_code')) {
    function get_voucher_by_code($con, $code)
    {
        $normalized = normalize_voucher_code($code);
        if ($normalized === '') {
            return null;
        }

        $safeCode = mysqli_real_escape_string($con, $normalized);
        $query = "SELECT * FROM `voucher` WHERE `MaCode` = '$safeCode' LIMIT 1";
        $result = mysqli_query($con, $query);
        if (!$result || mysqli_num_rows($result) === 0) {
            return null;
        }

        return mysqli_fetch_assoc($result);
    }
}

if (!function_exists('is_voucher_date_active')) {
    function is_voucher_date_active($con, $voucher)
    {
        $start = !empty($voucher['NgayBatDau']) ? "'" . mysqli_real_escape_string($con, $voucher['NgayBatDau']) . "'" : "'1970-01-01 00:00:00'";
        $end = !empty($voucher['NgayKetThuc']) ? "'" . mysqli_real_escape_string($con, $voucher['NgayKetThuc']) . "'" : 'NULL';
        $result = mysqli_query($con, "SELECT (NOW() >= $start AND ($end IS NULL OR NOW() <= $end)) AS `IsActive`");
        if (!$result) {
            return false;
        }

        $row = mysqli_fetch_assoc($result);
        return (int) ($row['IsActive'] ?? 0) === 1;
    }
}

if (!function_exists('calculate_voucher_discount')) {
    function calculate_voucher_discount($voucher, $subtotal, $con = null)
    {
        if (!$voucher) {
            return 0;
        }

        $subtotal = (float) $subtotal;
        if ($subtotal < (float) ($voucher['DieuKienDonToiThieu'] ?? 0)) {
            return 0;
        }

        if ((int) ($voucher['TrangThai'] ?? 1) !== 1) {
            return 0;
        }

        if ($con && !is_voucher_date_active($con, $voucher)) {
            return 0;
        }

        $type = strtolower((string) ($voucher['LoaiGiam'] ?? 'percent'));
        $value = (float) ($voucher['GiaTri'] ?? 0);

        if ($type === 'percent') {
            return min($subtotal * ($value / 100), $subtotal);
        }

        if ($type === 'fixed') {
            return min($value, $subtotal);
        }

        return 0;
    }
}

if (!function_exists('get_customer_purchase_profile')) {
    function get_customer_purchase_profile($con, $customerId)
    {
        $customerId = (int) $customerId;
        $query = "SELECT kh.`NgayTaoTaiKhoan`, TIMESTAMPDIFF(SECOND, kh.`NgayTaoTaiKhoan`, NOW()) AS `AccountAgeSeconds`, COUNT(DISTINCT dh.`SoDH`) AS `SoDonThanhCong`
                  FROM `khachhang` kh
                  LEFT JOIN `dondathang` dh ON dh.`MaKH` = kh.`MaKH` AND dh.`TinhTrangGiaoHang` = 'Giao hàng thành công'
                  WHERE kh.`MaKH` = '$customerId'
                  GROUP BY kh.`MaKH`, kh.`NgayTaoTaiKhoan`";
        $result = mysqli_query($con, $query);
        return $result ? mysqli_fetch_assoc($result) : null;
    }
}

if (!function_exists('get_voucher_customer_eligibility')) {
    function get_voucher_customer_eligibility_reason($con, $voucher, $customerId)
    {
        $customerId = (int) $customerId;
        if (!$voucher) {
            return 'Không tìm thấy mã voucher này. Hãy chọn mã trong mục Voucher.';
        }
        if ($customerId <= 0) {
            return 'Vui lòng đăng nhập để sử dụng voucher.';
        }
        if ((int) ($voucher['TrangThai'] ?? 0) !== 1) {
            return 'Voucher đang được tắt.';
        }

        if ((int) ($voucher['SoLanDaDung'] ?? 0) >= (int) ($voucher['SoLuong'] ?? 0)) {
            return 'Voucher đã hết lượt sử dụng.';
        }

        if (!is_voucher_date_active($con, $voucher)) {
            return 'Voucher chưa đến thời gian áp dụng hoặc đã hết hạn.';
        }

        $profile = get_customer_purchase_profile($con, $customerId);
        if (!$profile) {
            return 'Không thể xác định thông tin mua hàng của tài khoản.';
        }

        $completedOrders = (int) ($profile['SoDonThanhCong'] ?? 0);
        $audience = strtolower((string) ($voucher['DoiTuong'] ?? 'all'));

        if ($audience === 'new') {
            if ($completedOrders > 0) {
                return 'Mã này chỉ dành cho khách chưa có đơn giao thành công.';
            }
            if (empty($profile['NgayTaoTaiKhoan'])) {
                return 'Mã khách mới chỉ áp dụng cho tài khoản được tạo trong vòng ' . (int) ($voucher['SoNgayKhachMoi'] ?? 30) . ' ngày.';
            }

            $newCustomerDays = max(1, (int) ($voucher['SoNgayKhachMoi'] ?? 30));
            $accountAgeSeconds = $profile['AccountAgeSeconds'] !== null ? (int) $profile['AccountAgeSeconds'] : -1;
            if ($accountAgeSeconds < 0 || $accountAgeSeconds > $newCustomerDays * 86400) {
                return 'Mã khách mới chỉ áp dụng trong ' . $newCustomerDays . ' ngày kể từ khi tạo tài khoản.';
            }
        } elseif ($audience === 'returning' && $completedOrders === 0) {
            return 'Mã này chỉ dành cho khách đã có đơn giao thành công.';
        } elseif ($audience === 'orders') {
            $minimumOrders = (int) ($voucher['SoDonTu'] ?? 0);
            $maximumOrders = $voucher['SoDonDen'] !== null ? (int) $voucher['SoDonDen'] : null;
            if ($completedOrders < $minimumOrders || ($maximumOrders !== null && $maximumOrders > 0 && $completedOrders > $maximumOrders)) {
                return 'Voucher chưa phù hợp với số đơn giao thành công của tài khoản.';
            }
        } elseif (!in_array($audience, ['all', 'new', 'returning'], true)) {
            return 'Voucher không áp dụng cho nhóm tài khoản này.';
        }

        $voucherId = (int) $voucher['MaVC'];
        $usageResult = mysqli_query($con, "SELECT 1 FROM `voucher_customer_usage` WHERE `MaVC` = '$voucherId' AND `MaKH` = '$customerId' LIMIT 1");
        if (!$usageResult) {
            return 'Không thể kiểm tra lượt sử dụng voucher. Vui lòng thử lại.';
        }
        if (mysqli_num_rows($usageResult) > 0) {
            return 'Tài khoản này đã sử dụng voucher này rồi.';
        }

        return '';
    }
}

if (!function_exists('get_voucher_customer_eligibility')) {
    function get_voucher_customer_eligibility($con, $voucher, $customerId)
    {
        return get_voucher_customer_eligibility_reason($con, $voucher, $customerId) === '';
    }
}

if (!function_exists('get_valid_voucher_for_total')) {
    function get_valid_voucher_for_total($con, $code, $subtotal, $customerId = 0)
    {
        $voucher = get_voucher_by_code($con, $code);
        if (!$voucher || !get_voucher_customer_eligibility($con, $voucher, $customerId)) {
            return null;
        }

        $discount = calculate_voucher_discount($voucher, $subtotal, $con);
        if ($discount <= 0) {
            return null;
        }

        $voucher['discount_amount'] = $discount;
        return $voucher;
    }
}

if (!function_exists('get_available_vouchers_for_customer')) {
    function get_available_vouchers_for_customer($con, $customerId)
    {
        $result = mysqli_query($con, "SELECT * FROM `voucher` WHERE `TrangThai` = 1 AND `SoLanDaDung` < `SoLuong` ORDER BY `MaVC` DESC");
        if (!$result) {
            return [];
        }

        $vouchers = [];
        while ($voucher = mysqli_fetch_assoc($result)) {
            if (get_voucher_customer_eligibility($con, $voucher, $customerId)) {
                $vouchers[] = $voucher;
            }
        }

        return $vouchers;
    }
}
