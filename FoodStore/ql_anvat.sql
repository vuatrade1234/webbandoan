-- phpMyAdmin SQL Dump
-- Database: `ql_anvat` (Tiệm Đồ Ăn Vặt SnackStore - 13 bảng)
-- Host: 127.0.0.1
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_anvat`
--

-- --------------------------------------------------------
-- BẢNG 1: quantrivien (Quản trị viên / Nhân viên hệ thống)
-- --------------------------------------------------------
CREATE TABLE `quantrivien` (
  `MaQTV` int(11) NOT NULL,
  `TaiKhoan` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `QuanLi` bit(1) DEFAULT NULL,
  `HoTen` varchar(50) NOT NULL,
  `DienThoaiNV` varchar(20) DEFAULT NULL,
  `AnhDaiDien` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `quantrivien` (`MaQTV`, `TaiKhoan`, `MatKhau`, `QuanLi`, `HoTen`, `DienThoaiNV`, `AnhDaiDien`, `DiaChi`, `Email`) VALUES
(1, 'LanAnh', '$2y$10$U7362CGJwf6kUw6BdfmkxuMBtlwz338ybnyefoERtbZ4Ypz5X8M0.', b'1', 'Trần Thị Lan Anh', '0355587440', 'NV2.jpg', 'TP HCM', 'lananh@gmail.com'),
(2, 'NghiaNguyen', '$2y$10$U7362CGJwf6kUw6BdfmkxuMBtlwz338ybnyefoERtbZ4Ypz5X8M0.', b'1', 'Nghĩa Nguyễn', '0879150375', 'NV1.jpg', 'TP HCM', 'nghia@gmail.com'),
(3, 'ThanhGiang', '$2y$10$U7362CGJwf6kUw6BdfmkxuMBtlwz338ybnyefoERtbZ4Ypz5X8M0.', b'1', 'Lê Thanh Giang', '0909 022 966', 'NV1.jpg', 'TP HCM', 'giang@gmail.com');

-- --------------------------------------------------------
-- BẢNG 2: khachhang (Khách hàng)
-- --------------------------------------------------------
CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `TaiKhoan` varchar(50) DEFAULT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL DEFAULT 1,
  `Email` varchar(100) DEFAULT NULL,
  `DiaChiKH` varchar(200) DEFAULT NULL,
  `DienThoaiKH` varchar(20) DEFAULT NULL,
  `NgaySinh` datetime DEFAULT NULL,
  `NgayTaoTaiKhoan` datetime DEFAULT NULL,
  `GioiTinh` bit(1) DEFAULT NULL,
  `AnhKH` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `TaiKhoan`, `MatKhau`, `Email`, `DiaChiKH`, `DienThoaiKH`, `NgaySinh`, `GioiTinh`, `AnhKH`) VALUES
(15, 'Trịnh Minh Hậu', 'MinhHau', '224cf2b695a5e8ecaecfb9015161fa4b', 'hau.tm.61cntt@ntu.edu.vn', 'Ninh Hòa, Khánh Hòa', '0355587440', '2001-12-03 00:00:00', b'1', 'KH1.jpg'),
(16, 'Trịnh Khánh Minh', 'KhanhMinh', '14e1b600b1fd579f47433b88e8d85291', 'khanhminh@gmail.com', 'Quận 1, TP HCM', '0987654321', '2000-01-15 00:00:00', b'1', 'KH2.jpg'),
(17, 'Lê Minh Triết', 'TrietLe', 'bdda07b6bc4b3c15853d9c9878c6f1aa', 'thanhnhan@gmail.com', 'Bình Thạnh, TP HCM', '0987654325', '1998-07-20 00:00:00', b'1', 'KH3.jpg'),
(18, 'Trần Minh Anh', 'minhanh', '0eefcf00ff53279a1c125c0ceccca471', 'khachhang@gmail.com', 'Quận 12, TP HCM', '0987654324', '2002-08-09 00:00:00', b'1', 'KH4.jpg'),
(19, 'Khách Hàng Tên Danh', 'khachhangtendanh', '4e28e766ee51993315fd938cf673320d', 'khachhang2@gmail.com', 'Gò Vấp, TP HCM', '0987654322', '2001-05-12 00:00:00', b'1', 'KH5.jpg'),
(21, 'Cao Thái Phương Thanh', 'Mr.Thanh', 'Thanh123', 'mrthanh@gmail.com', 'Quận 5, TP HCM', '0901122334', '1985-03-21 00:00:00', b'1', 'KH7.jpg'),
(22, 'Nguyễn Văn Bình', 'ngb123', '123456', 'ngb123@gmail.com', 'Hải Châu, Đà Nẵng', '0911111111', '1990-01-01 00:00:00', b'1', 'KH8.jpg'),
(23, 'Phạm Thị Linh', 'ptc456', 'abcdef', 'ptc456@gmail.com', 'TP Huế', '0922222222', '1992-02-02 00:00:00', b'1', 'KH9.jpg');

-- --------------------------------------------------------
-- BẢNG 3: nhanviengiaohang (Nhân viên giao hàng / Shipper)
-- --------------------------------------------------------
CREATE TABLE `nhanviengiaohang` (
  `MaNVGH` int(11) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `DienThoaiNV` varchar(20) DEFAULT NULL,
  `AnhDaiDien` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nhanviengiaohang` (`MaNVGH`, `HoTen`, `DienThoaiNV`, `AnhDaiDien`, `DiaChi`, `Email`) VALUES
(1, 'Phạm Minh Hùng', '0366843210', 'gh1.jpg', 'TP HCM', 'hung@gmail.com'),
(2, 'Nguyễn Văn Trí', '0377889706', 'gh2.jpg', 'Hà Nội', 'tringuyen@gmail.com'),
(3, 'Hồ Hoàng Khôi', '0388776443', 'gh3.jpg', 'Vũng Tàu', 'khoi@gmail.com');

-- --------------------------------------------------------
-- BẢNG 4: loaisanpham (Danh mục loại đồ ăn vặt)
-- --------------------------------------------------------
CREATE TABLE `loaisanpham` (
  `MaLSP` int(11) NOT NULL,
  `TenLoaiSP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `loaisanpham` (`MaLSP`, `TenLoaiSP`) VALUES
(1, 'Bánh tráng trộn & Bánh tráng cuốn'),
-- (2) KHÔ GÀ, BÒ, HEO CHÁY TỎI
(2, 'Khô gà, khô bò & khô heo cháy tỏi'),
-- (3) CƠM CHÁY & RONG BIỂN
(3, 'Cơm cháy chà bông & Rong biển cháy tỏi'),
-- (4) ĐỒ ĂN VẶT NỘI ĐỊA TRUNG
(4, 'Đồ ăn vặt cay nội địa Trung'),
-- (5) CÁC LOẠI HẠT DINH DƯỠNG
(5, 'Hạt dinh dưỡng & Trái cây sấy dẻo'),
-- (6) BÁNH NGỌT & BÁNH QUY NHẬP KHẨU
(6, 'Bánh ngọt, bánh quy & bông lan trứng muối'),
-- (7) KẸO DẺO & SOCOLA
(7, 'Kẹo dẻo trái cây & Socola tươi'),
-- (8) MỰC & HẢI SẢN ĂN VẶT
(8, 'Mực cán cay, mực rim me & cá mai sốt me'),
-- (9) MỨT & TRÁI CÂY CHUA NGỌT
(9, 'Mứt sấy mộc, xoài sấy dẻo & me lào chấm muối ớt'),
-- (10) TRÀ SỮA & NƯỚC GIẢI KHÁT ĂN VẶT
(10, 'Trà sữa đóng chai & Nước giải khát đóng lon');

-- --------------------------------------------------------
-- BẢNG 5: thuonghieu (Thương hiệu / Nhãn hàng đồ ăn vặt)
-- --------------------------------------------------------
CREATE TABLE `thuonghieu` (
  `MaTH` int(11) NOT NULL,
  `TenTH` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `thuonghieu` (`MaTH`, `TenTH`) VALUES
(1, 'Ăn Vặt Ba Anh Em'),
(2, 'Oishi'),
(3, 'Orion'),
(4, 'Lay\'s'),
(5, 'Ghé Ăn Vặt'),
(6, 'Foody Snack'),
(7, 'G Kitchen'),
(8, 'Tân Huê Viên'),
(9, 'Bánh Tráng Cô Ba'),
(10, 'Haidilao Snack'),
(11, 'Heo Cao Bồi'),
(12, 'Snack Mực Bento'),
(13, 'Vinamit'),
(14, 'Richy'),
(15, 'Chupa Chups');

-- --------------------------------------------------------
-- BẢNG 6: nhacungcap (Nhà cung cấp nguyên liệu / sỉ ăn vặt)
-- --------------------------------------------------------
CREATE TABLE `nhacungcap` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(200) NOT NULL,
  `DienThoaiNCC` varchar(20) DEFAULT NULL,
  `DiaChiNCC` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `DienThoaiNCC`, `DiaChiNCC`) VALUES
(1, 'Tổng Kho Sỉ Đồ Ăn Vặt Sài Gòn', '02837621076', '907/19 Hương Lộ 2, Bình Trị Đông A, Bình Tân, TP.HCM'),
(2, 'Công Ty Nông Sản & Trái Cây Sấy Việt', '02838641386', '15 Trường Sơn, Phường 15, Quận 10, TP.HCM'),
(3, 'Xưởng Chế Biến Thực Phẩm Khô Cô Tám', '02837540958', '1016A Hương Lộ 2, P. Bình Trị Đông A, Q. Bình Tân, TP.HCM'),
(4, 'Nhà Phân Phối Bánh Kẹo Nhập Khẩu Á Châu', '02837269110', 'Số 552 Quốc Lộ 13, P. Hiệp Bình Phước, TP. Thủ Đức, TP.HCM'),
(5, 'Công Ty TNHH Thực Phẩm An Toàn Xanh', '02513813887', '1/1 Phạm Văn Thuận, P. Tam Hiệp, TP. Biên Hòa, Đồng Nai'),
(6, 'Đại Lý Phân Phối Đồ Ăn Vặt Nội Địa Ba Miền', '02253769981', '1166 Nguyễn Bỉnh Khiêm, Hải An, TP. Hải Phòng'),
(7, 'Công Ty Chế Biến Hải Sản Ăn Liền Biển Đông', '0932762456', 'S12 Tôn Thất Thuyết, Phường 18, Quận 4, TP.HCM'),
(8, 'Xưởng Bánh Tráng & Muối Nhuyễn Tây Ninh', '0909917959', '43/34 Đường Vườn Lài, An Phú Đông, Quận 12, TP.HCM');

-- --------------------------------------------------------
-- BẢNG 7 (MỚI BỔ SUNG 1/5): nhasanxuat (Cơ sở / Xưởng sản xuất)
-- --------------------------------------------------------
CREATE TABLE `nhasanxuat` (
  `MaNSX` int(11) NOT NULL,
  `TenNSX` varchar(150) NOT NULL,
  `XuatXu` varchar(100) DEFAULT 'Việt Nam',
  `DiaChi` varchar(200) DEFAULT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `nhasanxuat` (`MaNSX`, `TenNSX`, `XuatXu`, `DiaChi`, `SoDienThoai`) VALUES
(1, 'Cơ sở Sản Xuất Bánh Tráng Tây Ninh Hoàng Yến', 'Tây Ninh, Việt Nam', 'Gò Dầu, Tây Ninh', '0981122334'),
(2, 'Xưởng Chế Biến Thịt Khô & Thảo Mộc Đà Lạt', 'Lâm Đồng, Việt Nam', 'Đức Trọng, Lâm Đồng', '0972233445'),
(3, 'Nhà Máy Nông Sản Sấy Chân Không Vinamit', 'Bình Dương, Việt Nam', 'KCN VSIP 1, Bình Dương', '02743789123'),
(4, 'Công Ty TNHH Snack Thực Phẩm Hảo Vị', 'Hồ Chí Minh, Việt Nam', 'KCN Tân Bình, TP.HCM', '02838123456'),
(5, 'Xí Nghiệp Hải Sản Tẩm Gia Vị Nha Trang', 'Khánh Hòa, Việt Nam', 'Vĩnh Nguyên, Nha Trang', '02583889900');

-- --------------------------------------------------------
-- BẢNG 8: sanpham (Sản phẩm đồ ăn vặt)
-- --------------------------------------------------------
CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(200) NOT NULL,
  `GiaBan` int(11) DEFAULT NULL,
  `MoTa` varchar(1000) DEFAULT NULL,
  `AnhBia` varchar(100) DEFAULT NULL,
  `NgayCapNhat` datetime DEFAULT NULL,
  `SoLuongTon` int(11) DEFAULT NULL,
  `MaLSP` int(11) DEFAULT NULL,
  `MaTH` int(11) DEFAULT NULL,
  `MaNCC` int(11) DEFAULT NULL,
  `MaNSX` int(11) DEFAULT 1,
  `HienThiSanPham` bit(1) DEFAULT b'1',
  `GiaBanCu` int(11) DEFAULT NULL,
  `QuyCach` varchar(100) NOT NULL DEFAULT 'Hũ 200g,Hũ 300g,Hũ 500g',
  `ViHuong` varchar(255) NOT NULL DEFAULT 'Truyền thống,Cay cay,Cay nồng,Phô mai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `GiaBan`, `MoTa`, `AnhBia`, `NgayCapNhat`, `SoLuongTon`, `MaLSP`, `MaTH`, `MaNCC`, `MaNSX`, `HienThiSanPham`, `GiaBanCu`, `QuyCach`, `ViHuong`) VALUES
(1, 'Bánh tráng cuộn tôm hành sốt bơ béo ngậy', 35000, 'Bánh tráng dẻo tôm phơi sương cuộn tròn ngập sốt bơ trứng vàng ươm, ruốc hành phi giòn rụm và khô bò xé sợi thơm nức.', 'anh1_Loai1.jpg', '2023-08-01 10:00:00', 120, 1, 9, 8, 1, b'1', 45000, 'Hộp 200g,Hộp 300g,Hộp 500g', 'Sốt bơ trứng,Sốt me chua ngọt,Sốt phô mai cay'),
(2, 'Bánh tráng phơi sương chấm sốt me bơ hành phi', 40000, 'Combo bánh tráng phơi sương dẻo mềm kèm chén sốt me rim chua ngọt, bơ trứng béo mịn, đậu phộng rang giòn và hành phi thơm lừng.', 'anh2_Loai1.jpg', '2023-08-01 10:00:00', 150, 1, 9, 8, 1, b'1', 50000, 'Set nhỏ 200g,Set vừa 350g,Set lớn 500g', 'Cay vừa,Siêu cay,Ít cay'),
(3, 'Khô gà lá chanh cay giòn sợi vàng ươm', 65000, 'Thịt ức gà tươi 100% tẩm ướp gia vị đậm đà, sấy giòn rụm cùng lá chanh tươi thơm ngát và ớt hiểm cay nồng kích thích vị giác.', 'anh3_Loai1.jpg', '2023-08-01 10:00:00', 200, 2, 6, 3, 2, b'1', 80000, 'Hũ 250g,Hũ 500g,Túi Zip 1kg', 'Cay lá chanh,Cay bơ tỏi,Phô mai lắc'),
(4, 'Khô bò que cay ngọt vị truyền thống Tây Bắc', 95000, 'Thịt bò tươi nguyên thớ chọn lọc, sấy đều lửa với sả ớt, mắc khén tạo nên từng que khô bò đậm vị dai mềm ngọt thanh khó cưỡng.', 'anh4_Loai1.jpg', '2023-08-01 10:00:00', 80, 2, 7, 3, 2, b'1', 120000, 'Hũ 200g,Hũ 300g,Hũ 500g', 'Cay nồng,Cay ngọt,Siêu cay'),
(5, 'Khô heo cháy tỏi ớt giòn thơm đậm vị', 70000, 'Thịt nạc heo sạch rim cùng tép tỏi bắc phi vàng ruộm, nước mắm nhĩ thơm ngon và ớt chỉ thiên cay tê đầu lưỡi.', 'anh5_Loai1.jpg', '2023-08-01 10:00:00', 110, 2, 1, 1, 2, b'1', 85000, 'Hũ 250g,Hũ 500g', 'Cháy tỏi ớt,Cháy tỏi cay vừa,Mật ong cháy tỏi'),
(6, 'Cơm cháy chà bông đáy nồi nước mắm giòn rụm', 55000, 'Cơm cháy chiên phồng xốp giòn rụm, phủ ngập lớp chà bông heo hảo hạng cùng sốt ớt mắm ớt cay mặn ngọt bùng nổ.', 'anh1_Loai2.jpg', '2023-08-01 10:00:00', 90, 3, 5, 1, 4, b'1', 70000, 'Gói 250g,Gói 500g', 'Chà bông cay,Chà bông phô mai,Chà bông gà cay'),
(7, 'Rong biển sấy tỏi ớt giòn tan thơm bùi mè rang', 45000, 'Rong biển thiên nhiên sấy giòn tan, tẩm gia vị tỏi ớt phi cùng mè trắng rang vàng, món ăn vặt lành mạnh và cực kỳ bắt miệng.', 'anh2_Loai2.jpg', '2023-08-01 10:00:00', 130, 3, 6, 2, 4, b'1', 55000, 'Hũ 150g,Hũ 250g,Hũ 400g', 'Cháy tỏi ớt,Phô mai,Chay mặn đều dùng được'),
(8, 'Que cay nội địa Trung sốt cay nồng Tứ Xuyên', 25000, 'Que cay thơm lừng chuẩn vị Tứ Xuyên, sợi dẻo dai đượm nước sốt dầu ớt tê cay đặc trưng của ẩm thực đồ ăn vặt đường phố.', 'anh3_Loai2.jpg', '2023-08-01 10:00:00', 250, 4, 10, 4, 4, b'1', 35000, 'Gói 70g,Gói 120g,Thùng 20 gói', 'Tê cay Tứ Xuyên,Vị thịt nướng,Vị cay ngọt'),
(9, 'Chân vịt cay rút xương đóng gói hút chân không', 35000, 'Chân vịt rút xương ủ muối chua cay, sần sật ngấm trọn gia vị ớt ngâm, thảo mộc phương bắc thơm nức mũi.', 'anh4_Loai2.jpg', '2023-08-01 10:00:00', 160, 4, 10, 4, 4, b'1', 45000, 'Gói 1 chân,Gói 3 chân,Hộp 10 chân', 'Cay ớt xanh,Cay nồng ớt đỏ,Ủ muối truyền thống'),
(10, 'Hạt điều rang muối vỏ lụa Bình Phước loại A', 110000, 'Hạt điều cùi to mập mạp béo ngậy, rang muối củi giữ trọn hương vị ngọt bùi nguyên bản, ăn hoài không ngán.', 'anh5_Loai2.jpg', '2023-08-01 10:00:00', 85, 5, 13, 2, 3, b'1', 135000, 'Hũ 250g,Hũ 500g', 'Rang muối vỏ lụa,Tách vỏ sấy mộc,Vị tỏi ớt'),
(11, 'Xoài sấy dẻo muối ớt chua ngọt dẻo thơm', 60000, 'Xoài cát chín cây sấy lạnh giữ độ ẩm dẻo dai tự nhiên, rắc nhẹ muối tôm Tây Ninh chua chua cay cay hài hòa.', 'anh1_Loai3.jpg', '2023-08-01 10:00:00', 140, 9, 13, 2, 3, b'1', 75000, 'Túi Zip 200g,Hũ 350g,Túi 500g', 'Chua ngọt cay nhẹ,Chua cay đậm đà,Không ớt'),
(12, 'Mực cán tẩm cay thơm lừng nước sốt sa tế', 125000, 'Mực ống tươi đánh bắt vùng biển Phan Thiết, cán mỏng tẩm ướp sa tế mật ong nướng chín vàng ươm dai ngọt.', 'anh2_Loai3.jpg', '2023-08-01 10:00:00', 60, 8, 12, 7, 5, b'1', 150000, 'Hũ 200g,Hũ 350g,Hũ 500g', 'Sa tế cay nồng,Sốt me chua ngọt,Mực rim tỏi ớt'),
(13, 'Bánh bông lan trứng muối sốt phô mai tan chảy', 55000, 'Cốt bánh chiffon xốp mềm mịn như mây, phủ lớp sốt phô mai hoàng kim béo ngậy kết hợp trứng muối bùi béo và chà bông giòn.', 'anh3_Loai3.jpg', '2023-08-01 10:00:00', 70, 6, 8, 1, 4, b'1', 70000, 'Hộp 250g,Hộp 450g', 'Sốt phô mai,Sốt kim sa,Sốt bơ trứng'),
(14, 'Kẹo dẻo trái cây nhiệt đới ngập vị nước cốt', 30000, 'Kẹo dẻo ngào ngạt hương xoài, đào, dâu tây và nho tím chua ngọt thanh mát, dai dẻo kích thích vị giác mọi lứa tuổi.', 'anh4_Loai3.jpg', '2023-08-01 10:00:00', 180, 7, 15, 4, 4, b'1', 40000, 'Gói 150g,Hũ 300g,Hũ 500g', 'Hỗn hợp 5 vị,Vị đào thanh mát,Vị nho đen'),
(15, 'Mực rim me chua ngọt cay nồng đậm đà', 85000, 'Mực sữa nguyên con rim ngập trong nước sốt me sánh mịn chua thanh, điểm xuyết hạt mè rang và ớt bột thơm phức.', 'anh5_Loai3.jpg', '2023-08-01 10:00:00', 95, 8, 12, 7, 5, b'1', 105000, 'Hũ 200g,Hũ 350g,Hũ 500g', 'Rim me truyền thống,Rim sa tế cay,Rim tỏi ớt');

-- --------------------------------------------------------
-- BẢNG 9: giohang (Giỏ hàng của khách hàng)
-- --------------------------------------------------------
CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `TrangThai` int(11) NOT NULL DEFAULT 1,
  `soluong` int(11) NOT NULL DEFAULT 1,
  `QuyCach` varchar(100) NOT NULL,
  `ViHuong` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `giohang` (`id`, `MaKH`, `MaSP`, `TrangThai`, `soluong`, `QuyCach`, `ViHuong`) VALUES
(1, 15, 1, 1, 2, 'Hộp 300g', 'Sốt bơ trứng'),
(2, 15, 3, 1, 1, 'Hũ 250g', 'Cay lá chanh'),
(3, 16, 6, 1, 3, 'Gói 250g', 'Chà bông cay');

-- --------------------------------------------------------
-- BẢNG 10: dondathang (Đơn đặt hàng)
-- --------------------------------------------------------
CREATE TABLE `dondathang` (
  `SoDH` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `NgayGiao` datetime DEFAULT NULL,
  `DaThanhToan` bit(1) DEFAULT b'0',
  `TinhTrangGiaoHang` varchar(100) DEFAULT 'Chờ xác nhận',
  `NgayDat` datetime DEFAULT NULL,
  `DiaChiGiaoHang` varchar(100) DEFAULT NULL,
  `MaNVGH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `dondathang` (`SoDH`, `MaKH`, `NgayGiao`, `DaThanhToan`, `TinhTrangGiaoHang`, `NgayDat`, `DiaChiGiaoHang`, `MaNVGH`) VALUES
(76, 15, '2023-06-09 12:15:21', b'1', 'Giao hàng thành công', '2023-06-08 00:30:11', 'Ninh Hòa, Khánh Hòa', 1),
(77, 16, '2023-08-09 12:15:21', b'1', 'Giao hàng thành công', '2023-08-09 11:56:45', 'Quận 1, TP HCM', 2),
(78, 17, '2023-09-09 13:07:18', b'1', 'Giao hàng thành công', '2023-08-09 13:05:50', 'Bình Thạnh, TP HCM', 1),
(80, 18, '2023-08-09 13:23:11', b'1', 'Giao hàng thành công', '2023-08-09 13:21:30', 'Quận 9, TP HCM', 1),
(81, 19, '2023-08-09 13:37:57', b'1', 'Giao hàng thành công', '2023-08-09 13:36:50', 'Quận 2, TP HCM', 3),
(82, 19, NULL, b'0', 'Lấy hàng thành công', '2023-08-09 13:44:56', 'Gò Vấp, TP HCM', 1),
(83, 19, NULL, b'0', 'Chờ xác nhận', '2023-08-09 13:56:29', 'Tân Bình, TP HCM', NULL);

-- --------------------------------------------------------
-- BẢNG 11: chitietdathang (Chi tiết đơn đặt hàng)
-- --------------------------------------------------------
CREATE TABLE `chitietdathang` (
  `SoDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `DonGia` int(11) DEFAULT NULL,
  `QuyCach` varchar(50) NOT NULL,
  `ViHuong` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `chitietdathang` (`SoDH`, `MaSP`, `SoLuong`, `DonGia`, `QuyCach`, `ViHuong`) VALUES
(76, 1, 4, 35000, 'Hộp 300g', 'Sốt bơ trứng'),
(76, 2, 1, 40000, 'Set vừa 350g', 'Cay vừa'),
(76, 3, 2, 65000, 'Hũ 250g', 'Cay lá chanh'),
(77, 4, 2, 95000, 'Hũ 200g', 'Cay nồng'),
(78, 5, 2, 70000, 'Hũ 250g', 'Cháy tỏi ớt'),
(78, 6, 3, 55000, 'Gói 250g', 'Chà bông cay'),
(80, 7, 2, 45000, 'Hũ 150g', 'Cháy tỏi ớt'),
(80, 8, 5, 25000, 'Gói 70g', 'Tê cay Tứ Xuyên'),
(81, 9, 2, 35000, 'Gói 3 chân', 'Cay ớt xanh'),
(81, 10, 1, 110000, 'Hũ 250g', 'Rang muối vỏ lụa'),
(82, 11, 2, 60000, 'Túi Zip 200g', 'Chua ngọt cay nhẹ'),
(83, 12, 1, 125000, 'Hũ 200g', 'Sa tế cay nồng'),
(83, 13, 2, 55000, 'Hộp 250g', 'Sốt phô mai');

-- --------------------------------------------------------
-- BẢNG 12 (MỚI BỔ SUNG 2/5): phieunhap (Phiếu nhập kho hàng hóa)
-- --------------------------------------------------------
CREATE TABLE `phieunhap` (
  `MaPN` int(11) NOT NULL,
  `MaNCC` int(11) NOT NULL,
  `MaQTV` int(11) NOT NULL,
  `NgayNhap` datetime DEFAULT CURRENT_TIMESTAMP,
  `TongTien` decimal(15,2) DEFAULT 0,
  `GhiChu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `phieunhap` (`MaPN`, `MaNCC`, `MaQTV`, `NgayNhap`, `TongTien`, `GhiChu`) VALUES
(1, 1, 1, '2023-07-15 08:30:00', 12500000, 'Nhập lô bánh tráng cuộn & bánh tráng phơi sương đầu tháng'),
(2, 3, 2, '2023-07-20 09:15:00', 18900000, 'Nhập khô gà lá chanh và khô heo cháy tỏi thơm ngon'),
(3, 2, 1, '2023-08-02 14:00:00', 15400000, 'Nhập trái cây sấy dẻo và hạt điều Bình Phước');

-- --------------------------------------------------------
-- BẢNG 13 (MỚI BỔ SUNG 3/5): chitietphieunhap (Chi tiết phiếu nhập kho)
-- --------------------------------------------------------
CREATE TABLE `chitietphieunhap` (
  `MaPN` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuongNhap` int(11) NOT NULL,
  `DonGiaNhap` decimal(15,2) NOT NULL,
  `ThanhTien` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `chitietphieunhap` (`MaPN`, `MaSP`, `SoLuongNhap`, `DonGiaNhap`, `ThanhTien`) VALUES
(1, 1, 200, 25000, 5000000),
(1, 2, 250, 30000, 7500000),
(2, 3, 300, 45000, 13500000),
(2, 5, 100, 54000, 5400000),
(3, 10, 100, 85000, 8500000),
(3, 11, 150, 46000, 6900000);

-- --------------------------------------------------------
-- BẢNG 14: voucher (Mã giảm giá cho khách hàng)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `voucher` (
  `MaVC` int(11) NOT NULL AUTO_INCREMENT,
  `MaCode` varchar(50) NOT NULL,
  `TenVoucher` varchar(100) NOT NULL,
  `LoaiGiam` varchar(20) NOT NULL DEFAULT 'percent',
  `GiaTri` decimal(15,2) NOT NULL DEFAULT 0,
  `DieuKienDonToiThieu` decimal(15,2) NOT NULL DEFAULT 0,
  `NgayBatDau` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NgayKetThuc` datetime DEFAULT NULL,
  `TrangThai` tinyint(1) NOT NULL DEFAULT 1,
  `SoLuong` int(11) NOT NULL DEFAULT 1,
  `SoLanDaDung` int(11) NOT NULL DEFAULT 0,
  `DoiTuong` varchar(20) NOT NULL DEFAULT 'all',
  `SoNgayKhachMoi` int(11) NOT NULL DEFAULT 30,
  `SoDonTu` int(11) NOT NULL DEFAULT 0,
  `SoDonDen` int(11) DEFAULT NULL,
  PRIMARY KEY (`MaVC`),
  UNIQUE KEY `uk_voucher_code` (`MaCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`) VALUES
('WELCOME10', 'Chào mừng mới', 'percent', 10, 200000, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY), 1, 999, 0),
('FREESHIP', 'Miễn phí ship', 'fixed', 30000, 300000, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY), 1, 999, 0),
('SAVE50', 'Giảm 50k', 'fixed', 50000, 500000, NOW(), DATE_ADD(NOW(), INTERVAL 120 DAY), 1, 999, 0)
ON DUPLICATE KEY UPDATE `TenVoucher` = VALUES(`TenVoucher`);

INSERT INTO `voucher` (`MaCode`, `TenVoucher`, `LoaiGiam`, `GiaTri`, `DieuKienDonToiThieu`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`, `SoLuong`, `SoLanDaDung`, `DoiTuong`, `SoNgayKhachMoi`, `SoDonTu`, `SoDonDen`) VALUES
('KHMOI10', 'Khách hàng mới giảm 10%', 'percent', 10, 0, NOW(), NULL, 1, 999999, 0, 'new', 30, 0, NULL),
('DON100K20', 'Đơn từ 100.000đ giảm 20%', 'percent', 20, 100000, NOW(), NULL, 1, 999999, 0, 'all', 30, 0, NULL),
('DON500K30', 'Đơn từ 500.000đ giảm 30%', 'percent', 30, 500000, NOW(), NULL, 1, 999999, 0, 'all', 30, 0, NULL)
ON DUPLICATE KEY UPDATE `TenVoucher` = VALUES(`TenVoucher`);

CREATE TABLE IF NOT EXISTS `voucher_customer_usage` (
  `MaVC` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `SoDH` int(11) DEFAULT NULL,
  `NgaySuDung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MaVC`, `MaKH`),
  KEY `idx_voucher_usage_customer` (`MaKH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `dondathang`
  ADD COLUMN IF NOT EXISTS `MaVoucher` INT NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `VoucherCode` VARCHAR(50) NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `TienGiam` DECIMAL(15,2) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `TongTienSauGiam` DECIMAL(15,2) NOT NULL DEFAULT 0;

ALTER TABLE `khachhang`
  ADD COLUMN IF NOT EXISTS `NgayTaoTaiKhoan` DATETIME NULL DEFAULT NULL;

ALTER TABLE `voucher`
  ADD COLUMN IF NOT EXISTS `DoiTuong` VARCHAR(20) NOT NULL DEFAULT 'all',
  ADD COLUMN IF NOT EXISTS `SoNgayKhachMoi` INT NOT NULL DEFAULT 30,
  ADD COLUMN IF NOT EXISTS `SoDonTu` INT NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `SoDonDen` INT NULL DEFAULT NULL;

-- --------------------------------------------------------
-- BẢNG 14 (MỚI BỔ SUNG 4/5): thanhtoan (Lịch sử thanh toán đơn hàng)
-- --------------------------------------------------------
CREATE TABLE `thanhtoan` (
  `MaTT` int(11) NOT NULL,
  `SoDH` int(11) NOT NULL,
  `PhuongThucTT` varchar(50) NOT NULL COMMENT 'COD, MoMo, VNPay, Chuyển khoản',
  `SoTien` decimal(15,2) NOT NULL,
  `NgayThanhToan` datetime DEFAULT CURRENT_TIMESTAMP,
  `TrangThaiTT` varchar(50) DEFAULT 'Thành công'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `thanhtoan` (`MaTT`, `SoDH`, `PhuongThucTT`, `SoTien`, `NgayThanhToan`, `TrangThaiTT`) VALUES
(1, 76, 'COD - Tiền mặt', 310000, '2023-06-09 12:15:21', 'Thành công'),
(2, 77, 'Ví MoMo', 190000, '2023-08-09 12:15:21', 'Thành công'),
(3, 78, 'Chuyển khoản NH', 305000, '2023-09-09 13:07:18', 'Thành công'),
(4, 80, 'VNPay QR', 215000, '2023-08-09 13:23:11', 'Thành công'),
(5, 81, 'COD - Tiền mặt', 180000, '2023-08-09 13:37:57', 'Thành công');

-- --------------------------------------------------------
-- BẢNG 15 (MỚI BỔ SUNG 5/5): yeuthich (Sản phẩm yêu thích của khách hàng)
-- --------------------------------------------------------
CREATE TABLE `yeuthich` (
  `MaYT` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `NgayThem` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `yeuthich` (`MaYT`, `MaKH`, `MaSP`, `NgayThem`) VALUES
(1, 15, 1, '2023-08-01 11:20:00'),
(2, 15, 3, '2023-08-02 15:45:00'),
(3, 16, 4, '2023-08-05 09:10:00'),
(4, 17, 6, '2023-08-08 19:30:00'),
(5, 18, 7, '2023-08-09 10:00:00'),
(6, 19, 10, '2023-08-10 14:15:00');

-- --------------------------------------------------------
-- Khóa chính & Chỉ mục (Indexes)
-- --------------------------------------------------------

ALTER TABLE `quantrivien`
  ADD PRIMARY KEY (`MaQTV`,`TaiKhoan`);

ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `TaiKhoan` (`TaiKhoan`),
  ADD UNIQUE KEY `Email` (`Email`);

ALTER TABLE `nhanviengiaohang`
  ADD PRIMARY KEY (`MaNVGH`);

ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MaLSP`);

ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`MaTH`);

ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`MaNSX`);

ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `FK_SP_LSP` (`MaLSP`),
  ADD KEY `FK_SP_TH` (`MaTH`),
  ADD KEY `FK_SP_NCC` (`MaNCC`),
  ADD KEY `FK_SP_NSX` (`MaNSX`);

ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_GH_KH` (`MaKH`),
  ADD KEY `FK_GH_SP` (`MaSP`);

ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`SoDH`),
  ADD KEY `FK_DDH_KH` (`MaKH`),
  ADD KEY `FK_DDH_NVGH` (`MaNVGH`);

ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SoDH`,`MaSP`,`QuyCach`,`ViHuong`),
  ADD KEY `FK_CTDH_SP` (`MaSP`);

ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPN`),
  ADD KEY `FK_PN_NCC` (`MaNCC`),
  ADD KEY `FK_PN_QTV` (`MaQTV`);

ALTER TABLE `chitietphieunhap`
  ADD PRIMARY KEY (`MaPN`,`MaSP`),
  ADD KEY `FK_CTPN_SP` (`MaSP`);

ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaTT`),
  ADD KEY `FK_TT_DDH` (`SoDH`);

ALTER TABLE `yeuthich`
  ADD PRIMARY KEY (`MaYT`),
  ADD UNIQUE KEY `UK_YT_KH_SP` (`MaKH`,`MaSP`),
  ADD KEY `FK_YT_SP` (`MaSP`);

-- --------------------------------------------------------
-- Cấu hình AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `quantrivien`
  MODIFY `MaQTV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `nhanviengiaohang`
  MODIFY `MaNVGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `loaisanpham`
  MODIFY `MaLSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `thuonghieu`
  MODIFY `MaTH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `nhacungcap`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `nhasanxuat`
  MODIFY `MaNSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `giohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `dondathang`
  MODIFY `SoDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

ALTER TABLE `phieunhap`
  MODIFY `MaPN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `thanhtoan`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `yeuthich`
  MODIFY `MaYT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- --------------------------------------------------------
-- Khóa ngoại (Constraints / Foreign Keys)
-- --------------------------------------------------------

ALTER TABLE `sanpham`
  ADD CONSTRAINT `FK_SP_LSP` FOREIGN KEY (`MaLSP`) REFERENCES `loaisanpham` (`MaLSP`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SP_NCC` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SP_NSX` FOREIGN KEY (`MaNSX`) REFERENCES `nhasanxuat` (`MaNSX`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SP_TH` FOREIGN KEY (`MaTH`) REFERENCES `thuonghieu` (`MaTH`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `giohang`
  ADD CONSTRAINT `FK_GH_KH` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GH_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `dondathang`
  ADD CONSTRAINT `FK_DDH_KH` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_DDH_NVGH` FOREIGN KEY (`MaNVGH`) REFERENCES `nhanviengiaohang` (`MaNVGH`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `FK_CTDH_DDH` FOREIGN KEY (`SoDH`) REFERENCES `dondathang` (`SoDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CTDH_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `phieunhap`
  ADD CONSTRAINT `FK_PN_NCC` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PN_QTV` FOREIGN KEY (`MaQTV`) REFERENCES `quantrivien` (`MaQTV`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `FK_CTPN_PN` FOREIGN KEY (`MaPN`) REFERENCES `phieunhap` (`MaPN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CTPN_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `FK_TT_DDH` FOREIGN KEY (`SoDH`) REFERENCES `dondathang` (`SoDH`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `yeuthich`
  ADD CONSTRAINT `FK_YT_KH` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_YT_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
