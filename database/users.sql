-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 23, 2026 lúc 07:10 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `guitar_xigon`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'assets/img/person/images.jpg',
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `locked_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `fullname`, `email`, `phone`, `address`, `city`, `district`, `ward`, `avatar`, `is_locked`, `locked_reason`) VALUES
(1, 'rpt.mckkk', 'mck', '2026-03-21 00:10:33', 'Nghiêm Vũ Hoàng Long', 'nghiemtong@gmail.com', '(012) 345-6789', NULL, NULL, NULL, NULL, 'assets/img/person/mckhutthuocbangchan.jpeg', 0, NULL),
(22, 'wxrdie', 'wxrdie', '2026-03-21 00:14:28', 'Phạm Nam Hải', 'wrxdie@gmail.com', '(012) 345-1111', 'Nhà của MCK', 'Hà Nội', 'Phố Quan Hoa', 'Cầu Giấy', 'assets/img/avatars/1774078406_wxrdie.jpg', 0, NULL),
(23, 'tlinh', 'tlinh', '2026-03-21 00:14:28', 'Nguyễn Thảo Linh', 'tlinh@gmail.com', '(012) 345-2222', NULL, NULL, NULL, NULL, 'assets/img/avatars/1774079282_tlinhdautroc.jpg', 0, NULL),
(24, 'longchimloi', 'long123', '2026-03-22 21:13:39', 'Nguyễn Hoàng Long', 'longchimloi@gmail.com', '0912345678', '12 Nguyễn Trãi', 'Hồ Chí Minh', 'Quận 1', 'Phường Bến Thành', 'assets/img/person/longchimloi.jpg', 1, 'Nghi ngờ gian lận / lừa đảo'),
(25, 'wxrdie2', 'wxr123', '2026-03-22 21:13:39', 'Trần Minh Khoa', 'minhkhoa@gmail.com', '0923456789', '45 Lê Lợi', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/wxrdie.jpg', 0, NULL),
(26, 'gdragon_vn', 'gd123', '2026-03-22 21:13:39', 'Kwon Ji Young', 'gdragon@gmail.com', '0934567890', '7 Phạm Ngũ Lão', 'Hồ Chí Minh', 'Quận 1', 'Phường Phạm Ngũ Lão', 'assets/img/person/gdragon.png', 0, NULL),
(27, 'jackj97', 'jack123', '2026-03-22 21:13:39', 'Trịnh Trần Phương Tuấn', 'jackj97@gmail.com', '0945678901', '99 Cách Mạng Tháng 8', 'Hồ Chí Minh', 'Quận 10', 'Phường 5', 'assets/img/person/jack.png', 0, NULL),
(28, 'soicodoc2', 'soi123', '2026-03-22 21:13:39', 'Nguyễn Văn Sói', 'soicodoc@gmail.com', '0956789012', '33 Đinh Tiên Hoàng', 'Hà Nội', 'Hoàn Kiếm', 'Phường Tràng Tiền', 'assets/img/person/soicodoc.jpg', 0, NULL),
(29, 'namperfect2', 'nam123', '2026-03-22 21:13:39', 'Trần Nam Perfect', 'namperfect@gmail.com', '0967890123', '88 Bà Triệu', 'Hà Nội', 'Hai Bà Trưng', 'Phường Bùi Thị Xuân', 'assets/img/person/namperfect.jpg', 0, NULL),
(30, 'datvantay2', 'dat123', '2026-03-22 21:13:39', 'Nguyễn Đạt Văn Tây', 'datvantay@gmail.com', '0978901234', '15 Nguyễn Huệ', 'Đà Nẵng', 'Hải Châu', 'Phường Thạch Thang', 'assets/img/person/datvantay.jpg', 0, NULL),
(31, 'dangrangcom', 'dang123', '2026-03-22 21:13:39', 'Đặng Rang Cơm', 'dangrangcom@gmail.com', '0989012345', '22 Trần Phú', 'Đà Nẵng', 'Hải Châu', 'Phường Nam Dương', 'assets/img/person/dangrangcom.jpg', 0, NULL),
(32, 'anhnhancobap', 'anh123', '2026-03-22 21:13:39', 'Lê Văn Nhân', 'anhnhancobap@gmail.com', '0990123456', '56 Hùng Vương', 'Cần Thơ', 'Ninh Kiều', 'Phường Tân An', 'assets/img/person/anhnhancobap.jpg', 0, NULL),
(33, 'chautinhtri2', 'chau123', '2026-03-22 21:13:39', 'Châu Tinh Trì Fan', 'chautinhtri@gmail.com', '0901234567', '100 Võ Văn Tần', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/chautinhtri.jpg', 0, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
