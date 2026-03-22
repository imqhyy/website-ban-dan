-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
<<<<<<< HEAD
-- Thời gian đã tạo: Th3 22, 2026 lúc 07:08 PM
=======
-- Thời gian đã tạo: Th3 22, 2026 lúc 09:06 PM
>>>>>>> 0313758680694f78cc239ec1d173b2363c4a1ff3
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
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` enum('Guitar Acoustic','Guitar Classic') NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `product_images` text DEFAULT NULL,
  `summary_description` text DEFAULT NULL,
  `detailed_overview` text DEFAULT NULL,
  `cost_price` decimal(15,2) DEFAULT 0.00,
  `profit_margin` decimal(5,2) DEFAULT 20.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `selling_price` decimal(15,2) DEFAULT 0.00,
  `highlight_1_title` varchar(255) DEFAULT NULL,
  `highlight_1_content` text DEFAULT NULL,
  `highlight_2_title` varchar(255) DEFAULT NULL,
  `highlight_2_content` text DEFAULT NULL,
  `highlight_3_title` varchar(255) DEFAULT NULL,
  `highlight_3_content` text DEFAULT NULL,
  `highlight_4_title` varchar(255) DEFAULT NULL,
  `highlight_4_content` text DEFAULT NULL,
  `accessories` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_type`, `brand_id`, `product_images`, `summary_description`, `detailed_overview`, `cost_price`, `profit_margin`, `discount_percent`, `selling_price`, `highlight_1_title`, `highlight_1_content`, `highlight_2_title`, `highlight_2_content`, `highlight_3_title`, `highlight_3_content`, `highlight_4_title`, `highlight_4_content`, `accessories`, `created_at`, `updated_at`) VALUES
(1, 'Saga A1 DE PRO', 'Guitar Acoustic', 1, 'saga-a1-de-pro-1.jpg,saga-a1-de-pro-2.jpg,saga-a1-de-pro-3.jpg,saga-a1-de-pro-4.jpg,saga-a1-de-pro-5.jpg,saga-a1-de-pro-6.jpg', 'Dòng đàn acoustic chuyên nghiệp với âm thanh mạnh mẽ.', 'Saga A1 DE PRO sở hữu mặt top bằng gỗ nguyên tấm (Solid), mang lại độ vang và ấm vượt trội.', 2000000.00, 20.00, 0.00, 2400000.00, 'Âm thanh nội lực', 'Thân đàn lớn giúp cộng hưởng âm thanh cực tốt.', 'Gỗ Solid Spruce', 'Mặt trước làm từ gỗ thông nguyên tấm chọn lọc.', 'Khóa đúc cao cấp', 'Giữ dây ổn định, không bị phô khi chơi lâu.', 'Action thấp', 'Dễ bấm, phù hợp cho người mới và chuyên nghiệp.', '{\"fixed\":[\"Bao đàn chính hãng cao cấp (Gig Bag)\",\"Lục giác chỉnh cần (Ty chỉnh cần)\"],\"others\":\"Khăn lau đàn\"}', '2026-03-05 13:14:52', '2026-03-09 08:39:22'),
(2, 'Taylor A12E', 'Guitar Acoustic', 2, 'taylor-a12e-1.jpg,taylor-a12e-2.jpg,taylor-a12e-3.jpg,taylor-a12e-4.jpg,taylor-a12e-5.jpg,taylor-a12e-6.jpg', 'Huyền thoại của Taylor cho sự thoải mái tối đa.', 'Thiết kế Grand Concert nhỏ gọn với vát cạnh (Armrest) giúp người chơi không bị mỏi tay.', 70000000.00, 21.43, 0.00, 85000000.00, 'Thiết kế vát cạnh', 'Tăng sự thoải mái khi tì tay chơi đàn.', 'Hệ thống ES2', 'Bộ thu âm độc quyền cho âm thanh chân thực khi ra loa.', 'Phím đàn Ebony', 'Cảm giác lướt phím cực mượt mà.', 'Thân đàn nhỏ gọn', 'Phù hợp cho fingerstyle và phòng thu.', '{\"fixed\":[\"Bao đàn chính hãng cao cấp (Gig Bag)\",\"Dây đàn dự phòng/Bộ dây đi kèm\",\"Capo (Kẹp tăng tông) hoặc Pick (Miếng gảy đàn)\"],\"others\":\"Dây đeo da cừu\"}', '2026-03-05 13:14:52', '2026-03-09 09:08:26'),
(3, 'Ba đờn C100', 'Guitar Classic', 3, 'badon-c100-1.jpg,badon-c100-2.jpg,badon-c100-3.jpg,badon-c100-4.jpg,badon-c100-5.jpg,badon-c100-6.jpg', 'Đàn guitar cổ điển chất lượng cao sản xuất tại Việt Nam.', 'C100 là lựa chọn hàng đầu cho học sinh sinh viên bắt đầu học guitar cổ điển với âm thanh ấm áp.', 4000000.00, 25.00, 10.00, 5000000.00, 'Gỗ thịt 100%', 'Toàn thân được làm từ gỗ thật, càng chơi càng hay.', 'Cần đàn chắc chắn', 'Thiết kế chuẩn classic, dễ cầm nắm.', 'Âm thanh ấm', 'Phù hợp với các bản nhạc trữ tình, cổ điển.', 'Giá thành hợp lý', 'Chất lượng vượt trội trong tầm giá.', '{\"fixed\":[\"Lục giác chỉnh cần (Ty chỉnh cần)\"],\"others\":\"Giá để nhạc\"}', '2026-03-05 13:14:52', '2026-03-09 09:11:20'),
(4, 'Ba Đờn C150', 'Guitar Classic', 3, 'ba-don-c150-1.jpg,ba-don-c150-2.jpg,ba-don-c150-3.jpg,ba-don-c150-4.jpg,ba-don-c150-5.jpg,ba-don-c150-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:09:33', '2026-03-08 13:38:37'),
(5, 'Ba Đờn C170', 'Guitar Classic', 3, 'ba-don-c170-1.jpg,ba-don-c170-2.jpg,ba-don-c170-3.jpg,ba-don-c170-4.jpg,ba-don-c170-5.jpg,ba-don-c170-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:12:22', '2026-03-08 13:38:37'),
(6, 'Ba Đờn C250', 'Guitar Classic', 3, 'ba-don-c250-1.jpg,ba-don-c250-2.jpg,ba-don-c250-3.jpg,ba-don-c250-4.jpg,ba-don-c250-5.jpg,ba-don-c250-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:13:18', '2026-03-08 13:38:37'),
(7, 'Yamaha C40mii C CX', 'Guitar Classic', 4, 'yamaha-c40mii-c-cx-1.jpg,yamaha-c40mii-c-cx-2.jpg,yamaha-c40mii-c-cx-3.jpg,yamaha-c40mii-c-cx-4.jpg,yamaha-c40mii-c-cx-5.jpg,yamaha-c40mii-c-cx-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:14:36', '2026-03-08 13:38:37'),
(8, 'Yamaha GC42S GC GCX', 'Guitar Classic', 4, 'yamaha-gc42s-gc-gcx-1.jpg,yamaha-gc42s-gc-gcx-2.jpg,yamaha-gc42s-gc-gcx-3.jpg,yamaha-gc42s-gc-gcx-4.jpg,yamaha-gc42s-gc-gcx-5.jpg,yamaha-gc42s-gc-gcx-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:15:47', '2026-03-08 13:38:37'),
(9, 'Yamaha GL1 Guitarlele', 'Guitar Classic', 4, 'yamaha-gl1-guitarlele-1.jpg,yamaha-gl1-guitarlele-2.jpg,yamaha-gl1-guitarlele-3.jpg,yamaha-gl1-guitarlele-4.jpg,yamaha-gl1-guitarlele-5.jpg,yamaha-gl1-guitarlele-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:17:08', '2026-03-08 13:38:37'),
(10, 'Saga CC1', 'Guitar Acoustic', 1, 'saga-cc1-1.jpg,saga-cc1-2.jpg,saga-cc1-3.jpg,saga-cc1-4.jpg,saga-cc1-5.jpg,saga-cc1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:17:59', '2026-03-08 13:38:37'),
(11, 'Saga CL65', 'Guitar Acoustic', 1, 'saga-cl65-1.jpg,saga-cl65-2.jpg,saga-cl65-3.jpg,saga-cl65-4.jpg,saga-cl65-5.jpg,saga-cl65-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:18:32', '2026-03-08 13:38:37'),
(12, 'Saga SS 8CE', 'Guitar Acoustic', 1, 'saga-ss-8ce-1.jpg,saga-ss-8ce-2.jpg,saga-ss-8ce-3.jpg,saga-ss-8ce-4.jpg,saga-ss-8ce-5.jpg,saga-ss-8ce-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:19:41', '2026-03-08 13:38:37'),
(13, 'Enya EA X2', 'Guitar Acoustic', 5, 'enya-ea-x2-1.jpg,enya-ea-x2-2.jpg,enya-ea-x2-3.jpg,enya-ea-x2-4.jpg,enya-ea-x2-5.jpg,enya-ea-x2-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:25:28', '2026-03-08 13:38:37'),
(14, 'Enya EGA X0 PRO SP1', 'Guitar Acoustic', 5, 'enya-ega-x0-pro-sp1-1.jpg,enya-ega-x0-pro-sp1-2.jpg,enya-ega-x0-pro-sp1-3.jpg,enya-ega-x0-pro-sp1-4.jpg,enya-ega-x0-pro-sp1-5.jpg,enya-ega-x0-pro-sp1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:26:43', '2026-03-08 13:38:37'),
(15, 'Enya EM X1 SP1', 'Guitar Acoustic', 5, 'enya-em-x1-sp1-1.jpg,enya-em-x1-sp1-2.jpg,enya-em-x1-sp1-3.jpg,enya-em-x1-sp1-4.jpg,enya-em-x1-sp1-5.jpg,enya-em-x1-sp1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:27:38', '2026-03-08 13:38:37'),
(16, 'Taylor 110E', 'Guitar Acoustic', 2, 'taylor-110e-1.jpg,taylor-110e-2.jpg,taylor-110e-3.jpg,taylor-110e-4.jpg,taylor-110e-5.jpg,taylor-110e-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:28:36', '2026-03-08 13:38:37'),
(17, 'Yamaha APX1200ii', 'Guitar Acoustic', 4, 'yamaha-apx1200ii-1.jpg,yamaha-apx1200ii-2.jpg,yamaha-apx1200ii-3.jpg,yamaha-apx1200ii-4.jpg,yamaha-apx1200ii-5.jpg,yamaha-apx1200ii-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:29:25', '2026-03-08 13:38:37'),
(23, 'Jack', 'Guitar Acoustic', 5, NULL, NULL, NULL, 0.00, 20.00, 0.00, 3500000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 07:53:46', '2026-03-09 07:53:46'),
(26, 'jack', 'Guitar Acoustic', 2, 'jack-1.png,jack-2.png,jack-3.png,jack-4.png,jack-5.png,jack-6.png', '', '', 0.00, 20.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', '2026-03-22 17:08:03', '2026-03-22 17:08:03'),
<<<<<<< HEAD
(27, 'tày enzo', 'Guitar Acoustic', 2, 'tay-enzo-1.png,tay-enzo-2.png,tay-enzo-3.png,tay-enzo-4.png,tay-enzo-5.png,tay-enzo-6.png', '', '', 0.00, 20.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', '2026-03-22 17:08:39', '2026-03-22 17:08:39');
=======
(27, 'tày enzoo', 'Guitar Acoustic', 2, 'tay-enzo-1.png,tay-enzo-2.png,tay-enzo-3.png,tay-enzo-4.png,tay-enzo-5.png,tay-enzo-6.png', '', '', 0.00, 20.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', '2026-03-22 17:08:39', '2026-03-22 20:03:16'),
(29, 'akkakaka', 'Guitar Acoustic', 1, 'akkakaka-1.jpeg,akkakaka-2.jpg,akkakaka-3.jpg,akkakaka-4.jpg,akkakaka-17742063870.jpg,akkakaka-17742096540.png', 'hih', 'hihihi', 0.00, 20.00, 0.00, 0.00, 'a', 'a', '', '', '', '', '', '', '[]', '2026-03-22 18:54:23', '2026-03-22 20:00:54');
>>>>>>> 0313758680694f78cc239ec1d173b2363c4a1ff3

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_brand` (`brand_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
