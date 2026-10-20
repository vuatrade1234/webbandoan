-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 09:04 AM
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
-- Database: `ql_bangiay`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SoDH` int(11) NOT NULL,
  `MaGiay` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `DonGia` int(11) DEFAULT NULL,
  `Sizegiay` varchar(50) NOT NULL,
  `Maugiay` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitietdathang`
--

INSERT INTO `chitietdathang` (`SoDH`, `MaGiay`, `SoLuong`, `DonGia`, `Sizegiay`, `Maugiay`) VALUES
(76, 3, 4, 800000, '43', 'yellow'),
(76, 4, 1, 850000, '35', 'orange'),
(76, 4, 1, 850000, '43', 'green'),
(76, 44, 2, 750000, '41', 'blue'),
(77, 7, 1, 2590000, '42', 'blue'),
(78, 5, 2, 800000, '42', 'red'),
(78, 7, 3, 2590000, '41', 'red'),
(80, 7, 2, 2590000, '40', 'red'),
(80, 33, 3, 750000, '43', 'red'),
(81, 5, 1, 800000, '41', 'red'),
(81, 10, 1, 1950000, '42', 'red'),
(82, 7, 1, 2590000, '35', 'red'),
(83, 12, 1, 1830000, '35', 'red'),
(83, 28, 11, 950000, '35', 'red');

-- --------------------------------------------------------

--
-- Table structure for table `dondathang`
--

CREATE TABLE `dondathang` (
  `SoDH` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `NgayGiao` datetime DEFAULT NULL,
  `DaThanhToan` bit(1) DEFAULT NULL,
  `TinhTrangGiaoHang` varchar(100) DEFAULT NULL,
  `NgayDat` datetime DEFAULT NULL,
  `DiaChiGiaoHang` varchar(100) DEFAULT NULL,
  `MaNVGH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dondathang`
--

INSERT INTO `dondathang` (`SoDH`, `MaKH`, `NgayGiao`, `DaThanhToan`, `TinhTrangGiaoHang`, `NgayDat`, `DiaChiGiaoHang`, `MaNVGH`) VALUES
(76, 15, '2023-06-09 12:15:21', b'1', 'Giao hàng thành công', '2022-12-03 00:30:11', 'Ninh Hòa', 1),
(77, 16, '2023-08-09 12:15:21', b'1', 'Giao hàng thành công', '2023-08-09 11:56:45', 'xxxx', NULL),
(78, 17, '2023-09-09 13:07:18', b'1', 'Giao hàng thành công', '2023-08-09 13:05:50', 'hcm', NULL),
(80, 18, '2023-08-09 13:23:11', b'1', 'Giao hàng thành công', '2023-08-09 13:21:30', 'hcm q9', 1),
(81, 19, '2023-08-09 13:37:57', b'1', 'Giao hàng thành công', '2023-08-09 13:36:50', 'hcm q2', 1),
(82, 19, NULL, b'0', 'Lấy hàng thành công', '2023-08-09 13:44:56', 'hcm', NULL),
(83, 19, NULL, b'0', 'Chờ xác nhận', '2023-08-09 13:56:29', 'g', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `giay`
--

CREATE TABLE `giay` (
  `MaGiay` int(11) NOT NULL,
  `TenGiay` varchar(100) NOT NULL,
  `GiaBan` int(11) DEFAULT NULL,
  `MoTa` varchar(500) DEFAULT NULL,
  `AnhBia` varchar(100) DEFAULT NULL,
  `NgayCapNhat` datetime DEFAULT NULL,
  `SoLuongTon` int(11) DEFAULT NULL,
  `MaLG` int(11) DEFAULT NULL,
  `MaTH` int(11) DEFAULT NULL,
  `MaNCC` int(11) DEFAULT NULL,
  `HienThiSanPham` bit(1) DEFAULT NULL,
  `GiaBanCu` int(11) DEFAULT NULL,
  `Size` varchar(50) NOT NULL,
  `Màu` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `giay`
--

INSERT INTO `giay` (`MaGiay`, `TenGiay`, `GiaBan`, `MoTa`, `AnhBia`, `NgayCapNhat`, `SoLuongTon`, `MaLG`, `MaTH`, `MaNCC`, `HienThiSanPham`, `GiaBanCu`, `Size`, `Màu`) VALUES
(1, 'Giày trẻ em Nike Air Force 1 cổ điển màu ghi xanh', 800000, 'NK2022 Giày trẻ em không quân màu mới‼\r\n\r\nGiày trẻ em Nike Air Force cổ điển màu trắng xanh\r\n\r\nSê-ri chuyển đổi dành cho trẻ em, sắp ra mắt ~\r\n\r\nKiểu giày cổ điển nhất, có thể chịu đựng thử thách của “lịch sử”!\r\n\r\nGiày cổ điển! Vẫn còn giày thể thao chống lại ~\r\n\r\nChất liệu da, ngón chân rộng, đế ngoài cao su', 'anh1_Loai1.jpg', '0000-00-00 00:00:00', 20, 1, 3, 4, b'0', 700000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(2, 'Giày trẻ em Nike Air Force 1 cổ điển màu trắng đỏ', 800000, 'NK2022 Giày trẻ em không quân màu mới‼\r\n\r\nGiày trẻ em Nike Air Force cổ điển màu trắng xanh\r\n\r\nSê-ri chuyển đổi dành cho trẻ em, sắp ra mắt ~\r\n\r\nKiểu giày cổ điển nhất, có thể chịu đựng thử thách của “lịch sử”!\r\n\r\nGiày cổ điển! Vẫn còn giày thể thao chống lại ~\r\n\r\nChất liệu da, ngón chân rộng, đế ngoài cao su', 'anh2_Loai1.jpg', '0000-00-00 00:00:00', 50, 1, 2, 5, b'0', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(3, 'Giày trẻ em Adidas Drop Step cỏ ba lá màu xanh ghi', 800000, 'NK2022 Giày trẻ em không quân màu mới‼\r\n\r\nGiày trẻ em Nike Air Force cổ điển màu trắng xanh\r\n\r\nSê-ri chuyển đổi dành cho trẻ em, sắp ra mắt ~\r\n\r\nKiểu giày cổ điển nhất, có thể chịu đựng thử thách của “lịch sử”!\r\n\r\nGiày cổ điển! Vẫn còn giày thể thao chống lại ~\r\n\r\nChất liệu da, ngón chân rộng, đế ngoài cao su', 'anh3_Loai1.jpg', '0000-00-00 00:00:00', 75, 1, 1, 6, b'1', 900000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(4, 'Giày trẻ em cao cổ đế mềm Adidas màu trắng đen', 850000, 'Giày trẻ em đế cao mềm và sáp siêu bất khả chiến bại\r\n\r\nPhong cách giày thể thao mới mẻ và bắt mắt, đồ đôi đỉnh cao là phong cách thời trang nước ngoài‼ ️Bạn nên mua đôi này, chúng thực sự đủ tốt để mặc', 'anh4_Loai1.jpg', '0000-00-00 00:00:00', 60, 1, 6, 2, b'1', 650000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(5, 'Giày trẻ em Nike Dunk Low Disrupt 2 màu xanh tím than', 800000, 'NK2022 Giày trẻ em không quân màu mới‼\r\n\r\nGiày trẻ em Nike Air Force cổ điển màu trắng xanh\r\n\r\nSê-ri chuyển đổi dành cho trẻ em, sắp ra mắt ~\r\n\r\nKiểu giày cổ điển nhất, có thể chịu đựng thử thách của “lịch sử”!\r\n\r\nGiày cổ điển! Vẫn còn giày thể thao chống lại ~\r\n\r\nChất liệu da, ngón chân rộng, đế ngoài cao su', 'anh5_Loai1.jpg', '0000-00-00 00:00:00', 100, 1, 4, 9, b'1', 960000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(6, 'Giày Balmain Sock Style B-Bold Sneakers siêu cấp màu trắng gót xanh', 2590000, '# Giày thể thao nam nữ tăng chiều cao\r\n\r\n#6.0cm bên ngoài tác dụng tăng chiều cao\r\n\r\n# Vamp nhiều chất liệu công nghệ đàn hồi cao khâu bên trong lưới thoáng khí\r\n\r\n# Chất liệu EVA được phát triển độc lập ở đế giữa nhẹ, độ đàn hồi tốt và nhẹ\r\n\r\n# Nhà thiết kế thời trang người Pháp Pierre Balmain đã tạo ra thương hiệu Balmain\r\n\r\n# Balmain Sock Style B-Bold Sneakers Sàn diễn thời trang mang phong cách cũ để tăng cảm giác tương lai công nghệ cao', 'anh1_Loai2.jpg', '0000-00-00 00:00:00', 50, 2, 7, 10, b'1', 2000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(7, 'Giày Balmain Sock Style B-Bold Sneakers đen trắng', 2590000, '# Giày thể thao nam nữ tăng chiều cao\r\n\r\n# 6.0cm bên ngoài tác dụng tăng chiều cao\r\n\r\n# Vamp nhiều chất liệu công nghệ đàn hồi cao khâu bên trong lưới thoáng khí\r\n\r\n# Chất liệu EVA được phát triển độc lập ở đế giữa nhẹ, độ đàn hồi tốt và nhẹ\r\n\r\n# Nhà thiết kế thời trang người Pháp Pierre Balmain đã tạo ra thương hiệu Balmain\r\n\r\n# Balmain Sock Style B-Bold Sneakers Sàn diễn thời trang mang phong cách cũ để tăng cảm giác tương lai công nghệ cao\r\n\r\n', 'anh2_Loai2.jpg', '0000-00-00 00:00:00', 75, 2, 8, 6, b'1', 2900000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(8, 'Giày Balmain Sock Style B-Bold Sneakers Paris full đen', 2960000, '# Giày thể thao nam nữ tăng chiều cao\r\n\r\n#6.0cm bên ngoài tác dụng tăng chiều cao\r\n\r\n# Vamp nhiều chất liệu công nghệ đàn hồi cao khâu bên trong lưới thoáng khí\r\n\r\n# Chất liệu EVA được phát triển độc lập ở đế giữa nhẹ, độ đàn hồi tốt và nhẹ\r\n\r\n# Nhà thiết kế thời trang người Pháp Pierre Balmain đã tạo ra thương hiệu Balmain\r\n\r\n# Balmain Sock Style B-Bold Sneakers Sàn diễn thời trang mang phong cách cũ để tăng cảm giác tương lai công nghệ cao', 'anh3_Loai2.jpg', '0000-00-00 00:00:00', 60, 2, 9, 12, b'1', 4050000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(9, 'Giày Balmain Sock Style B-Bold Sneakers siêu cấp nhiều màu', 2590000, '# Giày thể thao nam nữ tăng chiều cao\r\n\r\n#6.0cm bên ngoài tác dụng tăng chiều cao\r\n\r\n# Vamp nhiều chất liệu công nghệ đàn hồi cao khâu bên trong lưới thoáng khí\r\n\r\n# Chất liệu EVA được phát triển độc lập ở đế giữa nhẹ, độ đàn hồi tốt và nhẹ\r\n\r\n# Nhà thiết kế thời trang người Pháp Pierre Balmain đã tạo ra thương hiệu Balmain\r\n\r\n# Balmain Sock Style B-Bold Sneakers Sàn diễn thời trang mang phong cách cũ để tăng cảm giác tương lai công nghệ cao', 'anh4_Loai2.jpg', '0000-00-00 00:00:00', 100, 2, 9, 12, b'1', 3400000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(10, 'Giày Nike Air Force 1 – 10’7 siêu cấp họa tiết Doremon', 1950000, 'Giày Nike Air Force 1 – 10’7 của nam và nữ nửa cỡ\r\n\r\n# Nâng cấp phiên bản phát triển dữ liệu phiên bản giấy gốc hẹp mới nhất\r\n\r\n# Sử dụng lớp đầu tiên của chất liệu da nubuck mờ cứng đầu tiên\r\n\r\n# Đệm không khí Air Sole toàn chiều dài được tích hợp sẵn', 'anh5_Loai2.jpg', '0000-00-00 00:00:00', 75, 2, 11, 5, b'1', 1500000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(11, 'Giày Converse Chuck Taylor All Star 1970s x Kim Jones x Dior màu be', 1830000, 'Kim Jones x Converse Chuck Taylor All Star 1970 Blockbuster Collaboration‼ ️ Dior giám đốc thiết kế Converse cao cấp đình đám‼ ️\r\n\r\nVề giày, Kim Jones thiết kế dựa trên phom dáng giày Chuck 70 cổ điển, và phác thảo toàn bộ đôi giày với những đường nét thẩm mỹ tiện dụng.\r\n\r\nMột miếng lớn bằng chất liệu TPU retro bao phủ cả hai bên thân giày và khóa dây giày bằng chất liệu trong suốt so le với mắt dây giày bằng kim loại, kết hợp hoàn hảo giữa phong cách ngoài trời và cảm giác chức năng.\r\n\r\nCác dải', 'anh1_Loai3.jpg', '0000-00-00 00:00:00', 50, 3, 5, 5, b'1', 2000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(12, 'Giày Converse Chuck Taylor All Star 1970s x Kim Jones x Dior màu đen trắng', 1830000, 'Kim Jones x Converse Chuck Taylor All Star 1970 Blockbuster Collaboration‼ ️ Dior giám đốc thiết kế Converse cao cấp đình đám‼ ️\r\n\r\nVề giày, Kim Jones thiết kế dựa trên phom dáng giày Chuck 70 cổ điển, và phác thảo toàn bộ đôi giày với những đường nét thẩm mỹ tiện dụng.\r\n\r\nMột miếng lớn bằng chất liệu TPU retro bao phủ cả hai bên thân giày và khóa dây giày bằng chất liệu trong suốt so le với mắt dây giày bằng kim loại, kết hợp hoàn hảo giữa phong cách ngoài trời và cảm giác chức năng.\r\n\r\nCác dải', 'anh2_Loai3.jpg', '0000-00-00 00:00:00', 75, 3, 4, 4, b'1', 2900000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(13, 'Giày Dior Nữ siêu cấp Oblique Low”Walk’n’Dior” họa tiết màu xám', 1870000, 'Phiên bản ưu tiên Giày Dior Nữ siêu cấp Oblique Low cổ thấp\r\n\r\n# Giày nữ được sản xuất với chất lượng tốt nhất\r\n\r\n# sử dụng quy trình thêu máy vi tính chính xác\r\n\r\n# để nâng cao cảm giác ba chiều của ma cà rồng, để đảm bảo rằng phiên bản ma cà rồng không bị lỗi mốt\r\n\r\n# lót và đế bằng da cừu mềm mại ❗️ chứng thực mô hình, bản dịch lại màu sắc trang nhã mới của mô hình cổ điển', 'anh3_Loai3.jpg', '0000-00-00 00:00:00', 60, 3, 3, 3, b'1', 3050000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(14, 'Giày Dior Nữ siêu cấp Oblique Low”Walk’n’Dior” họa tiết màu đen', 1900000, 'Phiên bản ưu tiên Giày Dior Nữ siêu cấp Oblique Low cổ thấp\r\n\r\n# Giày nữ được sản xuất với chất lượng tốt nhất\r\n\r\n# sử dụng quy trình thêu máy vi tính chính xác\r\n\r\n# để nâng cao cảm giác ba chiều của ma cà rồng, để đảm bảo rằng phiên bản ma cà rồng không bị lỗi mốt\r\n\r\n# lót và đế bằng da cừu mềm mại ❗️ chứng thực mô hình, bản dịch lại màu sắc trang nhã mới của mô hình cổ điển', 'anh4_Loai3.jpg', '0000-00-00 00:00:00', 100, 3, 2, 2, b'1', 2000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(15, 'Giày Dior Nữ siêu cấp Oblique Low”Walk’n’Dior” họa tiết màu hồng', 1950000, 'Phiên bản ưu tiên Giày Dior Nữ siêu cấp Oblique Low cổ thấp\r\n\r\n# Giày nữ được sản xuất với chất lượng tốt nhất\r\n\r\n# sử dụng quy trình thêu máy vi tính chính xác\r\n\r\n# để nâng cao cảm giác ba chiều của ma cà rồng, để đảm bảo rằng phiên bản ma cà rồng không bị lỗi mốt\r\n\r\n# lót và đế bằng da cừu mềm mại ❗️ chứng thực mô hình, bản dịch lại màu sắc trang nhã mới của mô hình cổ điển', 'anh5_Loai3.jpg', '0000-00-00 00:00:00', 75, 3, 1, 1, b'1', 2000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(16, 'Giày Jordan 1 trẻ em màu trắng gót đen', 950000, 'Middle Top Velcro Gradient Color Sneakers dành cho trẻ em\r\n\r\nKÍCH THƯỚC: 26-37 thước Anh\r\n\r\nPhong cách Joe cổ điển ❤️\r\n\r\nMàu gradient mẫu tự làm đẹp quá 👏🏻\r\n\r\nThiết kế khóa dán, dễ dàng mặc vào và cởi ra✌🏻\r\n\r\nĐơn giản và phong cách ✔️', 'anh1_Loai4.jpg', '0000-00-00 00:00:00', 50, 4, 10, 10, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(17, 'Giày Jordan 1 trẻ em màu trắng gót tím pastel', 950000, 'Middle Top Velcro Gradient Color Sneakers dành cho trẻ em\r\n\r\nKÍCH THƯỚC: 26-37 thước Anh\r\n\r\nPhong cách Joe cổ điển ❤️\r\n\r\nMàu gradient mẫu tự làm đẹp quá 👏🏻\r\n\r\nThiết kế khóa dán, dễ dàng mặc vào và cởi ra✌🏻\r\n\r\nĐơn giản và phong cách ✔️\r\n\r\n', 'anh2_Loai4.jpg', '0000-00-00 00:00:00', 75, 4, 9, 9, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(18, 'Giày Jordan 1 trẻ em màu hồng pastel', 950000, 'Middle Top Velcro Gradient Color Sneakers dành cho trẻ em\r\n\r\nKÍCH THƯỚC: 26-37 thước Anh\r\n\r\nPhong cách Joe cổ điển ❤️\r\n\r\nMàu gradient mẫu tự làm đẹp quá 👏🏻\r\n\r\nThiết kế khóa dán, dễ dàng mặc vào và cởi ra✌🏻\r\n\r\nĐơn giản và phong cách ✔️', 'anh3_Loai4.jpg', '0000-00-00 00:00:00', 60, 4, 8, 8, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(19, 'Giày Jordan 1 trẻ em x LV màu nâu họa tiết caro mũi ghi', 950000, 'Jordan 1 Checkerboard Gele High School High School Top Velcro Sneakers\r\n\r\nKÍCH THƯỚC: 26-37\r\n\r\nBàn cờ chung với các viên gạch LEGO\r\n\r\nĐầy niềm vui 🌈\r\n\r\nĐế ngoài bằng cao su chống mài mòn, chống trơn trượt, cảm giác chân tuyệt vời\r\n\r\nThiết kế khóa dán, dễ dàng mặc vào và cởi ra', 'anh4_Loai4.jpg', '0000-00-00 00:00:00', 100, 4, 7, 7, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(20, 'Giày Jordan 1 trẻ em x LV màu nâu', 950000, 'Jordan 1 Checkerboard Gele High School High School Top Velcro Sneakers\r\n\r\nKÍCH THƯỚC: 26-37\r\n\r\nBàn cờ chung với các viên gạch LEGO\r\n\r\nĐầy niềm vui 🌈\r\n\r\nĐế ngoài bằng cao su chống mài mòn, chống trơn trượt, cảm giác chân tuyệt vời\r\n\r\nThiết kế khóa dán, dễ dàng mặc vào và cởi ra', 'anh5_Loai4.jpg', '0000-00-00 00:00:00', 75, 4, 1, 6, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(21, 'Giày trẻ em cao cổ đế mềm Adidas màu trắng đen', 850000, 'Giày trẻ em đế cao mềm và sáp siêu bất khả chiến bại👇👇\r\n\r\nPhong cách giày thể thao mới mẻ và bắt mắt, đồ đôi đỉnh cao là phong cách thời trang nước ngoài‼ ️Bạn nên mua đôi này, chúng thực sự đủ tốt để mặc', 'anh1_Loai5.jpg', '0000-00-00 00:00:00', 50, 5, 1, 1, b'1', 900000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(22, 'Giày trẻ em cao cổ đế mềm Adidas màu trắng xanh', 850000, 'Giày trẻ em đế cao mềm và sáp siêu bất khả chiến bại👇👇\r\n\r\nPhong cách giày thể thao mới mẻ và bắt mắt, đồ đôi đỉnh cao là phong cách thời trang nước ngoài‼ ️Bạn nên mua đôi này, chúng thực sự đủ tốt để mặc\r\n\r\nSize: 26-35\r\n\r\n', 'anh2_Loai5.jpg', '0000-00-00 00:00:00', 75, 5, 14, 14, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(23, 'Giày trẻ em Adidas Drop Step cỏ ba lá màu xanh ghi', 950000, '🍒ADIDAS DROP STEP cỏ ba lá cộng với nhung trang web chính thức hàng đầu cao cấp giày thể thao thông thường chữ lớn 💝\r\n\r\n💖Adidas mùa đông mới nhất dây thun cổ điển Velcro giày bóng rổ ấm áp thể thao\r\n\r\n🔥Giày da nam nữ hàng hiệu màu xanh da trời chiên bắt mắt và rực rỡ nhất một bàn đạp ánh sáng\r\n\r\n💥 Màu sắc: xanh, đỏ, xám\r\n\r\nKích thước: 26-35', 'anh3_Loai5.jpg', '0000-00-00 00:00:00', 60, 5, 8, 13, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(24, 'Giày trẻ em Adidas Drop Step cỏ ba lá màu đỏ ghi', 950000, '🍒ADIDAS DROP STEP cỏ ba lá cộng với nhung trang web chính thức hàng đầu cao cấp giày thể thao thông thường chữ lớn 💝\r\n\r\n💖Adidas mùa đông mới nhất dây thun cổ điển Velcro giày bóng rổ ấm áp thể thao\r\n\r\n🔥Giày da nam nữ hàng hiệu màu xanh da trời chiên bắt mắt và rực rỡ nhất một bàn đạp ánh sáng\r\n\r\n💥 Màu sắc: xanh, đỏ, xám\r\n\r\nKích thước: 26-35', 'anh4_Loai5.jpg', '0000-00-00 00:00:00', 100, 5, 12, 12, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(25, 'Giày trẻ em Adidas Drop Step cỏ ba lá màu đen trắng', 950000, '🍒ADIDAS DROP STEP cỏ ba lá cộng với nhung trang web chính thức hàng đầu cao cấp giày thể thao thông thường chữ lớn 💝\r\n\r\n💖Adidas mùa đông mới nhất dây thun cổ điển Velcro giày bóng rổ ấm áp thể thao\r\n\r\n🔥Giày da nam nữ hàng hiệu màu xanh da trời chiên bắt mắt và rực rỡ nhất một bàn đạp ánh sáng\r\n\r\n💥 Màu sắc: xanh, đỏ, xám\r\n\r\nKích thước: 26-35', 'anh5_Loai5.jpg', '0000-00-00 00:00:00', 75, 5, 1, 11, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(26, 'Giày Nike Jordan 8 trẻ em màu xanh – AJ8 Velcro Kids', 950000, 'AJ8 Joe 8 Velcro Kids Casual Sneakers\r\n\r\nKích thước: 22-27 cho trẻ em; 28-37 cho trẻ lớn,\r\n\r\nDây đai Velcro dạng chéo, thiết kế dây đeo đàn hồi tích hợp, tăng cường sự vừa vặn và hỗ trợ của em bé, logo “23” ở mặt trước của dây đeo tuyên bố rằng nó thuộc về gia đình AJ8.', 'anh1_Loai6.jpg', '0000-00-00 00:00:00', 60, 6, 2, 2, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(27, 'Giày jordan trẻ em họa tiết LV màu xanh', 900000, 'Giày jordan trẻ em họa tiết LV cao cấp phối hợp chống lão thị mới Velvet Joey\r\nLông cừu mịn tự tạo cộng với lông cừu, chăm sóc thân mật💓\r\nVelcro thiết kế đàn hồi, dễ dàng mặc vào và cởi ra\r\nĐế ngoài bằng cao su chống mài mòn, chống trơn trượt, tạo cảm giác thoải mái cho bàn chân ☁️\r\nBản in hoa cổ điển, thời trang và phóng khoáng🆒\r\nKÍCH THƯỚC: 26-37', 'anh2_Loai6.jpg', '0000-00-00 00:00:00', 60, 6, 3, 3, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(28, 'Giày jordan trẻ em họa tiết LV màu hồng bóng', 950000, 'Giày jordan trẻ em họa tiết LV cao cấp phối hợp chống lão thị mới Velvet Joey\r\nLông cừu mịn tự tạo cộng với lông cừu, chăm sóc thân mật💓\r\nVelcro thiết kế đàn hồi, dễ dàng mặc vào và cởi ra\r\nĐế ngoài bằng cao su chống mài mòn, chống trơn trượt, tạo cảm giác thoải mái cho bàn chân ☁️\r\nBản in hoa cổ điển, thời trang và phóng khoáng🆒\r\nKÍCH THƯỚC: 26-37', 'anh3_Loai6.jpg', '0000-00-00 00:00:00', 60, 6, 4, 4, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(29, 'Giày jordan trẻ em họa tiết LV màu ghi đen', 950000, 'Giày jordan trẻ em họa tiết LV cao cấp phối hợp chống lão thị mới Velvet Joey\r\nLông cừu mịn tự tạo cộng với lông cừu, chăm sóc thân mật💓\r\nVelcro thiết kế đàn hồi, dễ dàng mặc vào và cởi ra\r\nĐế ngoài bằng cao su chống mài mòn, chống trơn trượt, tạo cảm giác thoải mái cho bàn chân ☁️\r\nBản in hoa cổ điển, thời trang và phóng khoáng🆒\r\nKÍCH THƯỚC: 26-37', 'anh4_Loai6.jpg', '0000-00-00 00:00:00', 60, 6, 4, 4, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(30, 'Giày Nike SB Dunk Low trẻ em màu ghi dây hồng', 950000, 'Nike SB Dunk Giày trẻ em cấu trúc khớp thấp‼ ️\r\nMô hình chung NK sắp ra mắt, dòng dunk thấp nhất,\r\nGiày này rất thiết kế và dây rút ở trên rất sang trọng! da đầu 👍\r\nSize: 26-37', 'anh5_Loai6.jpg', '0000-00-00 00:00:00', 60, 6, 6, 6, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(31, 'Giày Balenciaga cao cổ màu đen đế đỏ', 850000, 'Đây là bản phối mẫu mới nhất của dòng Balenciaga Speed Trainer. Một đôi giày được thiết kế đơn giản nhưng độc đáo, tinh tế, sang trọng. Mẫu giày đang được đón nhận rất tích cực ☑️\r\n\r\nPhong cách thời trang, thể hiện cá tính, giúp tự tin ☑️\r\n\r\nSize bé: 24-35\r\nHàng chuẩn xuất, được gia công tỉ mỉ từ đường kim mũi chỉ.', 'anh1_Loai7.jpg', '0000-00-00 00:00:00', 60, 7, 7, 7, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(32, 'Giày Balenciaga cao cổ màu đen kim tuyến\r\n', 700000, 'Giày jordan trẻ em họa tiết LV cao cấp phối hợp chống lão thị mới Velvet Joey\r\nLông cừu mịn tự tạo cộng với lông cừu, chăm sóc thân mật💓\r\nVelcro thiết kế đàn hồi, dễ dàng mặc vào và cởi ra\r\nĐế ngoài bằng cao su chống mài mòn, chống trơn trượt, tạo cảm giác thoải mái cho bàn chân ☁️\r\nBản in hoa cổ điển, thời trang và phóng khoáng🆒\r\nKÍCH THƯỚC: 26-37', 'anh2_Loai7.jpg', '0000-00-00 00:00:00', 60, 7, 8, 8, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(33, 'Giày Balenciaga cao cổ màu hồng đế trắng đen', 750000, 'Đây là bản phối mẫu mới nhất của dòng Balenciaga Speed Trainer. Một đôi giày được thiết kế đơn giản nhưng độc đáo, tinh tế, sang trọng. Mẫu giày đang được đón nhận rất tích cực ☑️\r\n\r\nPhong cách thời trang, thể hiện cá tính, giúp tự tin ☑️\r\n\r\nSize bé: 24-35\r\nHàng chuẩn xuất, được gia công tỉ mỉ từ đường kim mũi chỉ.', 'anh3_Loai7.jpg', '0000-00-00 00:00:00', 60, 7, 9, 9, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(34, 'Giày Balenciaga cao cổ màu đỏ đế trắng đen', 750000, 'Đây là bản phối mẫu mới nhất của dòng Balenciaga Speed Trainer. Một đôi giày được thiết kế đơn giản nhưng độc đáo, tinh tế, sang trọng. Mẫu giày đang được đón nhận rất tích cực ☑️\r\n\r\nPhong cách thời trang, thể hiện cá tính, giúp tự tin ☑️\r\n\r\nSize bé: 24-35\r\nHàng chuẩn xuất, được gia công tỉ mỉ từ đường kim mũi chỉ.', 'anh4_Loai7.jpg', '0000-00-00 00:00:00', 60, 7, 10, 10, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(35, 'Giày Balenciaga cao cổ màu full đỏ', 850000, 'Đây là bản phối mẫu mới nhất của dòng Balenciaga Speed Trainer. Một đôi giày được thiết kế đơn giản nhưng độc đáo, tinh tế, sang trọng. Mẫu giày đang được đón nhận rất tích cực ☑️\r\n\r\nPhong cách thời trang, thể hiện cá tính, giúp tự tin ☑️\r\n\r\nSize bé: 24-35\r\nHàng chuẩn xuất, được gia công tỉ mỉ từ đường kim mũi chỉ.', 'anh5_Loai7.jpg', '0000-00-00 00:00:00', 60, 7, 11, 11, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(36, 'Giày Newbalance trẻ em mẫu mới da lộn nhiều màu', 850000, 'Giày NB TRẺ EM XC72 Retro Kids Sneakers\r\n\r\nCú hích nóng bỏng của Fashionista 🔥\r\n\r\nĐế cao su hạt cọ hoàn toàn, chống mài mòn và không trơn trượt ✔️\r\n\r\nChất liệu chống lông khâu, kết cấu chất lượng cao👍🏻\r\n\r\nThiết kế khóa ren, bé có thể dễ dàng mặc vào và cởi ra✌🏻\r\n\r\nKÍCH THƯỚC: 26-37', 'anh1_Loai8.jpg', '0000-00-00 00:00:00', 60, 8, 12, 12, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(37, 'Giày Newbalance trẻ em mẫu mới màu ghi trắng dây xanh\r\n', 700000, 'Giày NB TRẺ EM XC72 Retro Kids Sneakers\r\n\r\nCú hích nóng bỏng của Fashionista 🔥\r\n\r\nĐế cao su hạt cọ hoàn toàn, chống mài mòn và không trơn trượt ✔️\r\n\r\nChất liệu chống lông khâu, kết cấu chất lượng cao👍🏻\r\n\r\nThiết kế khóa ren, bé có thể dễ dàng mặc vào và cởi ra✌🏻\r\n\r\nKÍCH THƯỚC: 26-37', 'anh2_Loai8.jpg', '0000-00-00 00:00:00', 60, 8, 13, 13, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(38, 'Giày Newbalance trẻ em mẫu mới màu ghi xanh', 750000, 'Giày NB TRẺ EM XC72 Retro Kids Sneakers\r\n\r\nCú hích nóng bỏng của Fashionista 🔥\r\n\r\nĐế cao su hạt cọ hoàn toàn, chống mài mòn và không trơn trượt ✔️\r\n\r\nChất liệu chống lông khâu, kết cấu chất lượng cao👍🏻\r\n\r\nThiết kế khóa ren, bé có thể dễ dàng mặc vào và cởi ra✌🏻\r\n\r\nKÍCH THƯỚC: 26-37', 'anh3_Loai8.jpg', '0000-00-00 00:00:00', 60, 8, 14, 14, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(39, 'Giày Newbalance trẻ em mẫu mới màu ghi xanh', 750000, 'Giày NB 550 Retro trẻ em không chỉ về màu sắc mà còn về cấu tạo, đôi giày này dựa trên một công cụ màu vàng hoàn hảo bổ sung cho phần da phía trên.\r\n\r\nPhần upper được khâu nhiều chất liệu làm cho tổng thể của thân giày rất phong phú. Việc sử dụng da đục lỗ cung cấp độ thoáng khí cho phần trên.\r\n\r\nChữ 550 được in bên cạnh logo “N”, và lưỡi gà được tô điểm bằng logo thương hiệu N B và họa tiết bóng rổ, làm nổi bật bản sắc chủ đề của giày.\r\n\r\nThiết kế tổng thể là đơn giản và có một nét quyến rũ ret', 'anh4_Loai8.jpg', '0000-00-00 00:00:00', 60, 8, 1, 1, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(40, 'Giày NB 550 trẻ em màu vàng xanh', 850000, 'Giày NB 550 Retro trẻ em không chỉ về màu sắc mà còn về cấu tạo, đôi giày này dựa trên một công cụ màu vàng hoàn hảo bổ sung cho phần da phía trên.\r\n\r\nPhần upper được khâu nhiều chất liệu làm cho tổng thể của thân giày rất phong phú. Việc sử dụng da đục lỗ cung cấp độ thoáng khí cho phần trên.\r\n\r\nChữ 550 được in bên cạnh logo “N”, và lưỡi gà được tô điểm bằng logo thương hiệu N B và họa tiết bóng rổ, làm nổi bật bản sắc chủ đề của giày.\r\n\r\nThiết kế tổng thể là đơn giản và có một nét quyến rũ ret', 'anh5_Loai8.jpg', '0000-00-00 00:00:00', 60, 8, 2, 2, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(41, 'Giày Puma minions trẻ em màu trắng vàng', 850000, 'Minion là cảm hứng của thương hiệu giày Puma. Các fan của những chú Minion màu vàng đáng yêu có lẽ đã được thưởng thức bộ phim hoạt hình Despicable 3 của hãng phim Universal trên màn ảnh rộng.\r\n\r\nNhững chú Minion màu vàng này không những được trẻ em yêu thích mà còn có một lượng fan hùng hậu từ các khán giả nhiều tuổi.', 'anh1_Loai9.jpg', '0000-00-00 00:00:00', 60, 10, 13, 13, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(42, 'Giày Puma minions màu vàng – PU003\r\n', 700000, 'Minion là cảm hứng của thương hiệu giày Puma. Các fan của những chú Minion màu vàng đáng yêu có lẽ đã được thưởng thức bộ phim hoạt hình Despicable 3 của hãng phim Universal trên màn ảnh rộng. Những chú Minion màu vàng này không những được trẻ em yêu thích mà còn có một lượng fan hùng hậu từ các khán giả nhiều tuổi.', 'anh2_Loai9.jpg', '0000-00-00 00:00:00', 60, 10, 5, 5, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(43, 'Giày Puma minions màu trắng – PU002', 750000, 'Minion là cảm hứng của thương hiệu giày Puma. Các fan của những chú Minion màu vàng đáng yêu có lẽ đã được thưởng thức bộ phim hoạt hình Despicable 3 của hãng phim Universal trên màn ảnh rộng. Những chú Minion màu vàng này không những được trẻ em yêu thích mà còn có một lượng fan hùng hậu từ các khán giả nhiều tuổi.', 'anh3_Loai9.jpg', '0000-00-00 00:00:00', 60, 10, 7, 7, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(44, 'Giày Puma minions màu xanh – PU001', 750000, 'Minion là cảm hứng của thương hiệu giày Puma. Các fan của những chú Minion màu vàng đáng yêu có lẽ đã được thưởng thức bộ phim hoạt hình Despicable 3 của hãng phim Universal trên màn ảnh rộng. Những chú Minion màu vàng này không những được trẻ em yêu thích mà còn có một lượng fan hùng hậu từ các khán giả nhiều tuổi.', 'anh4_Loai9.jpg', '0000-00-00 00:00:00', 60, 10, 11, 11, b'1', 1000000, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple'),
(45, 'Thượng đình loại 1', 900000, 'Thượng đình mãi đỉnh', 'td1.jpg', '2022-12-02 23:43:01', 56, 2, 1, 1, b'1', NULL, '34,35,36,37,38', 'red,blue,green'),
(46, 'Thượng đình loại 2', 900000, 'Thượng đình mãi đỉnh', 'td2.jpg', '2022-12-03 00:04:15', 56, 2, 1, 1, b'1', NULL, '34,35,36,37,38', 'red,blue,green'),
(47, 'Thượng đình loại 3', 900000, 'Thượng đình mãi đỉnh', 'td3.jpg', '2022-12-03 00:04:22', 56, 2, 1, 1, b'1', NULL, '34,35,36,37,38', 'red,blue,green'),
(48, 'Thượng đình loại 4', 900000, 'Thượng đình mãi đỉnh', 'td4.jpg', '2022-12-03 00:07:03', 56, 2, 1, 1, b'1', NULL, '34,35,36,37,38', 'red,blue,green'),
(50, 'demonew', 99999, 'xxxx', 'Image2023080941975.jpg', '2023-08-09 13:27:16', 22, 1, 1, 1, b'0', NULL, '35,36,37,38,39,40,41,42,43,44,45', 'red,orange,yellow,green,blue,purple');

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `MaGiay` int(11) NOT NULL,
  `TrangThai` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `Sizeee` varchar(50) NOT NULL,
  `Mauuu` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `TaiKhoan` varchar(50) DEFAULT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DiaChiKH` varchar(200) DEFAULT NULL,
  `DienThoaiKH` varchar(20) DEFAULT NULL,
  `NgaySinh` datetime DEFAULT NULL,
  `GioiTinh` bit(1) DEFAULT NULL,
  `AnhKH` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `TaiKhoan`, `MatKhau`, `Email`, `DiaChiKH`, `DienThoaiKH`, `NgaySinh`, `GioiTinh`, `AnhKH`) VALUES
(15, 'Trịnh Minh Hậu', 'MinhHau', '224cf2b695a5e8ecaecfb9015161fa4b', 'hau.tm.61cntt@ntu.edu.vn', 'Ninh Hòa', '0355587440', '2001-12-03 00:00:00', b'1', 'KH1.jpg'),
(16, 'Trịnh Khánh Minh', 'KhanhMinh', '14e1b600b1fd579f47433b88e8d85291', 'nnnn@gmail.com', 'ty', '0987654321', '0976548132', b'1', 'KH2.jpg'),
(17, 'Lê Minh Triết', 'TrietLe', 'bdda07b6bc4b3c15853d9c9878c6f1aa', 'thanhnhan@gmail.com', 'TPHCM', '0987654325', '0912567213', b'1', 'KH3.jpg'),
(18, 'Trần Minh Anh', 'minhanh', '0eefcf00ff53279a1c125c0ceccca471', 'khachhang@gmail.com', 'hcm q12', '0987654324', '2023-08-09 00:00:00', b'1', 'KH4.jpg'),
(19, 'Khách Hàng Tên Danh', 'khachhangtendanh', '4e28e766ee51993315fd938cf673320d', 'khachhang2@gmail.com', 'hcm vn q12', '0987654322', '2023-08-09 00:00:00', b'1', 'KH5.jpg'),

-- Thêm 2 khách đặc biệt như yêu cầu
(20, 'Lê Hoàng Giang', 'Giang Lê', 'Giang0405', 'giangle@gmail.com', 'Hà Nội', '0912345678', '1999-05-04 00:00:00', b'1', 'KH6.jpg'),
(21, 'Cao Thái Phương Thanh', 'Mr.Thanh', 'Thanh123', 'mrthanh@gmail.com', 'TPHCM', '0901122334', '1985-03-21 00:00:00', b'1', 'KH7.jpg'),

-- Thêm 3 khách nữa để đủ 10
(22, 'Nguyễn Văn Bình', 'ngb123', '123456', 'ngb123@gmail.com', 'Đà Nẵng', '0911111111', '1990-01-01 00:00:00', b'1', 'KH8.jpg'),
(23, 'Phạm Thị Linh', 'ptc456', 'abcdef', 'ptc456@gmail.com', 'Huế', '0922222222', '1992-02-02 00:00:00', b'1', 'KH9.jpg'),
(24, 'Đỗ Văn Dự', 'dvd789', 'pass123', 'dvd789@gmail.com', 'Cần Thơ', '0933333333', '1993-03-03 00:00:00', b'1', 'KH10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `loaigiay`
--

CREATE TABLE `loaigiay` (
  `MaLG` int(11) NOT NULL,
  `TenLoaiGiay` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaigiay`
--

INSERT INTO `loaigiay` (`MaLG`, `TenLoaiGiay`) VALUES
(1, 'TRẺ EM'),
(2, 'NAM'),
(3, 'NỮ'),
(4, 'GIÀY BÓNG RỔ'),
(5, 'GIÀY ADIDAS'),
(6, 'GIÀY NIKE'),
(7, 'BALENCIAGA'),
(8, 'NEW BALANCE'),
(10, 'GIÀY PUMA');

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(200) NOT NULL,
  `DienThoaiNCC` varchar(20) DEFAULT NULL,
  `DiaChiNCC` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `DienThoaiNCC`, `DiaChiNCC`) VALUES
(1, 'Công Ty TNHH Thương Mại Sản Xuất Hùng Huy', '02837621076', '907/19 Khu Phố 8, Hương Lộ 2, P. Bình Trị Đông A, Q. Bình Tân,Tp. Hồ Chí Minh (TPHCM)'),
(2, 'Công Ty CP Giày Da Và May Mặc Xuất Khẩu', '02838641386', '15 Trường Sơn, Phường 15, Quận 10,Tp. Hồ Chí Minh (TPHCM)'),
(3, 'BITAS - Công Ty TNHH Sản Xuất Hàng Tiêu Dùng Bình Tân', ' 02837540958', '1016A Hương Lộ 2, P. Bình Trị Đông A, Q. Bình Tân,Tp. Hồ Chí Minh (TPHCM)'),
(4, 'Công Ty TNHH Giày Gia Định\r\n', '02837269110', 'Số 552 Quốc Lộ 13, P. Hiệp Bình Phước, Q. Thủ Đức,Tp. Hồ Chí Minh (TPHCM)'),
(5, 'Giày Dép Biti’s - Công Ty TNHH Sản Xuất Hàng Tiêu Dùng Bình Tiên', '02513813887', '1/1 Phạm Văn Thuận, P. Tam Hiệp, Tp. Biên Hòa,Đồng Nai'),
(6, 'Công Ty TNHH Đỉnh Vàng', '02253769981', '1166 Nguyễn Bỉnh Khiêm, P. ông Hải 2, Q. ải An,Tp. Hải Phòng'),
(7, 'Giày Dép Hưng Mỹ - Công Ty TNHH Sản Xuất Thương Mại Giày Dép Hưng Mỹ', '0932762456', 'S12 Tôn Thất Thuyết, P. 18, Q. 4,Tp. Hồ Chí Minh (TPHCM)'),
(8, 'Công Ty TNHH Sản Xuất Dép Huy Hoàng Việt Nam', '0909917959', '43/34 Đường Vườn Lài, P. An Phú Đông, Q. 12,Tp. Hồ Chí Minh (TPHCM)'),
(9, 'Công Ty TNHH Tuấn Kiệt Xuân Cầu', '0366361188', 'Thôn Lê Cao, Xã Nghĩa Trụ, Huyện Văn Giang,Hưng Yên'),
(10, 'Công Ty TNHH Thời Trang Mai Thị', '0933172299', '292/9 Khu Phố 4, Đường Lê Văn Khương, P. Thới An, Q. 12,Tp. Hồ Chí Minh (TPHCM)'),
(11, 'Công Ty TNHH Thương Mại Và Sản Xuất Giày Dép Da Việt Anh', '0913399287', 'Tư Sản, Phú Túc, Phú Xuyên,Hà Nội\r\n\r\n'),
(12, 'Công Ty TNHH Sản Xuất Phân Phối Giày Dép Sao Việt', '0966865121', '213/38b Liên khu 4-5, Bình Hưng Hòa B , Q. Bình Tân,Tp. Hồ Chí Minh (TPHCM)'),
(13, 'Công Ty CP Quốc Tế VIT', '0989333588', 'Số 12/12 Phạm Tuấn Tài, P. Dịch Vọng, Q. Cầu Giấy,Hà Nội'),
(14, 'Công Ty TNHH Sản Xuất Thương Mại Dịch Vụ Nguyên Đán', '0933338373', 'Số 1186/3E, Đường An Phú Đông 25, P. An Phú Đông, Q. 12,Tp. Hồ Chí Minh (TPHCM)');

-- --------------------------------------------------------

--
-- Table structure for table `nhanviengiaohang`
--

CREATE TABLE `nhanviengiaohang` (
  `MaNVGH` int(11) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `DienThoaiNV` varchar(20) DEFAULT NULL,
  `AnhDaiDien` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanviengiaohang`
--

INSERT INTO `nhanviengiaohang` (`MaNVGH`, `HoTen`, `DienThoaiNV`, `AnhDaiDien`, `DiaChi`, `Email`) VALUES
(1, 'Phạm Minh Huy', '0366843210', 'gh1.jpg', 'TP HCM', 'pmhuy@gmail.com'),
(2, 'Nguyền Hoàng Trí', '0377889706', 'gh2.jpg', 'Hà Nội', 'tringuyen@gmail.com'),
(3, 'Hồ Ngọc Phương Nhi', '0388776443', 'gh3.jpg', 'Vũng Tàu', 'nhiho123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `quantrivien`
--

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

--
-- Dumping data for table `quantrivien`
--

INSERT INTO `quantrivien` (`MaQTV`, `TaiKhoan`, `MatKhau`, `QuanLi`, `HoTen`, `DienThoaiNV`, `AnhDaiDien`, `DiaChi`, `Email`) VALUES
(1, 'LanPhuong', '$2y$10$U7362CGJwf6kUw6BdfmkxuMBtlwz338ybnyefoERtbZ4Ypz5X8M0.', b'1', 'Lê Thị Lan Phương', '0355587440', 'NV2.jpg', 'TP HCM', 'lanphuong@gmail.com'),
(2, 'HoangGiang', '$2y$10$U7362CGJwf6kUw6BdfmkxuMBtlwz338ybnyefoERtbZ4Ypz5X8M0.', b'1', 'Lê Hoàng Giang', '0879150375', 'NV3.jpg', 'Bình Dương', 'lehoanggiang0405@gmail.com'),
(3, 'Thanh', '$2y$10$U7362CGJwf6kUw6BdfmkxuMBtlwz338ybnyefoERtbZ4Ypz5X8M0.', b'1', 'Cao Thái Phương Thanh', '0909 022 966', 'NV1.jpg', 'TP HCM', 'thanh.ctp@sgu.edu.vn');
-- --------------------------------------------------------

--
-- Table structure for table `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `MaTH` int(11) NOT NULL,
  `TenTH` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thuonghieu`
--

INSERT INTO `thuonghieu` (`MaTH`, `TenTH`) VALUES
(1, 'Gucci '),
(2, 'Jordan'),
(3, 'Lego'),
(4, 'MLB'),
(5, 'Onitsuka Tiger'),
(6, 'Under Armour'),
(7, 'Converse'),
(8, 'Mc Queen'),
(9, 'New Balance'),
(10, 'Nike Jordan'),
(11, 'Vans'),
(12, 'Nike'),
(13, 'Adidas'),
(14, 'Puma'),
(15, 'Balenciaga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SoDH`,`MaGiay`,`Sizegiay`,`Maugiay`),
  ADD KEY `Fk_CTDH_G` (`MaGiay`);

--
-- Indexes for table `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`SoDH`),
  ADD KEY `Fk_DDH_KH` (`MaKH`),
  ADD KEY `Fk_DDH_NVGH` (`MaNVGH`);

--
-- Indexes for table `giay`
--
ALTER TABLE `giay`
  ADD PRIMARY KEY (`MaGiay`),
  ADD KEY `Fk_G_LG` (`MaLG`),
  ADD KEY `Fk_G_TH` (`MaTH`),
  ADD KEY `Fk_G_NCC` (`MaNCC`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Indexes for table `loaigiay`
--
ALTER TABLE `loaigiay`
  ADD PRIMARY KEY (`MaLG`);

--
-- Indexes for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Indexes for table `nhanviengiaohang`
--
ALTER TABLE `nhanviengiaohang`
  ADD PRIMARY KEY (`MaNVGH`);

--
-- Indexes for table `quantrivien`
--
ALTER TABLE `quantrivien`
  ADD PRIMARY KEY (`MaQTV`,`TaiKhoan`);

--
-- Indexes for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`MaTH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `SoDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `giay`
--
ALTER TABLE `giay`
  MODIFY `MaGiay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `loaigiay`
--
ALTER TABLE `loaigiay`
  MODIFY `MaLG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nhanviengiaohang`
--
ALTER TABLE `nhanviengiaohang`
  MODIFY `MaNVGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quantrivien`
--
ALTER TABLE `quantrivien`
  MODIFY `MaQTV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thuonghieu`
--
ALTER TABLE `thuonghieu`
  MODIFY `MaTH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `Fk_CTDH_DDH` FOREIGN KEY (`SoDH`) REFERENCES `dondathang` (`SoDH`),
  ADD CONSTRAINT `Fk_CTDH_G` FOREIGN KEY (`MaGiay`) REFERENCES `giay` (`MaGiay`);

--
-- Constraints for table `dondathang`
--
ALTER TABLE `dondathang`
  ADD CONSTRAINT `Fk_DDH_KH` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `Fk_DDH_NVGH` FOREIGN KEY (`MaNVGH`) REFERENCES `nhanviengiaohang` (`MaNVGH`);

--
-- Constraints for table `giay`
--
ALTER TABLE `giay`
  ADD CONSTRAINT `Fk_G_LG` FOREIGN KEY (`MaLG`) REFERENCES `loaigiay` (`MaLG`),
  ADD CONSTRAINT `Fk_G_NCC` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`),
  ADD CONSTRAINT `Fk_G_TH` FOREIGN KEY (`MaTH`) REFERENCES `thuonghieu` (`MaTH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
