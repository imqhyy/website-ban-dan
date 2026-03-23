-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 23, 2026 lúc 05:21 PM
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
  `category_id` int(11) DEFAULT NULL,
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

INSERT INTO `products` (`id`, `product_name`, `category_id`, `brand_id`, `product_images`, `summary_description`, `detailed_overview`, `cost_price`, `profit_margin`, `discount_percent`, `selling_price`, `highlight_1_title`, `highlight_1_content`, `highlight_2_title`, `highlight_2_content`, `highlight_3_title`, `highlight_3_content`, `highlight_4_title`, `highlight_4_content`, `accessories`, `created_at`, `updated_at`) VALUES
(2, 'Taylor A12E', 1, 2, 'taylor-a12e-1.jpg,taylor-a12e-2.jpg,taylor-a12e-3.jpg,taylor-a12e-4.jpg,taylor-a12e-5.jpg,taylor-a12e-6.jpg', 'Huyền thoại của Taylor cho sự thoải mái tối đa.', 'Thiết kế Grand Concert nhỏ gọn với vát cạnh (Armrest) giúp người chơi không bị mỏi tay.', 70000000.00, 21.43, 0.00, 85000000.00, 'Thiết kế vát cạnh', 'Tăng sự thoải mái khi tì tay chơi đàn.', 'Hệ thống ES2', 'Bộ thu âm độc quyền cho âm thanh chân thực khi ra loa.', 'Phím đàn Ebony', 'Cảm giác lướt phím cực mượt mà.', 'Thân đàn nhỏ gọn', 'Phù hợp cho fingerstyle và phòng thu.', '{\"fixed\":[\"Bao đàn chính hãng cao cấp (Gig Bag)\",\"Dây đàn dự phòng/Bộ dây đi kèm\",\"Capo (Kẹp tăng tông) hoặc Pick (Miếng gảy đàn)\"],\"others\":\"Dây đeo da cừu\"}', '2026-03-05 13:14:52', '2026-03-23 13:42:36'),
(3, 'Ba đờn C100', 2, 3, 'badon-c100-1.jpg,badon-c100-2.jpg,badon-c100-3.jpg,badon-c100-4.jpg,badon-c100-5.jpg,badon-c100-6.jpg', 'Đàn guitar cổ điển chất lượng cao sản xuất tại Việt Nam.', 'C100 là lựa chọn hàng đầu cho học sinh sinh viên bắt đầu học guitar cổ điển với âm thanh ấm áp.', 4000000.00, 25.00, 10.00, 5000000.00, 'Gỗ thịt 100%', 'Toàn thân được làm từ gỗ thật, càng chơi càng hay.', 'Cần đàn chắc chắn', 'Thiết kế chuẩn classic, dễ cầm nắm.', 'Âm thanh ấm', 'Phù hợp với các bản nhạc trữ tình, cổ điển.', 'Giá thành hợp lý', 'Chất lượng vượt trội trong tầm giá.', '{\"fixed\":[\"Lục giác chỉnh cần (Ty chỉnh cần)\"],\"others\":\"Giá để nhạc\"}', '2026-03-05 13:14:52', '2026-03-23 13:42:36'),
(4, 'Ba Đờn C150', 2, 3, 'ba-don-c150-1.jpg,ba-don-c150-2.jpg,ba-don-c150-3.jpg,ba-don-c150-4.jpg,ba-don-c150-5.jpg,ba-don-c150-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:09:33', '2026-03-23 13:42:36'),
(5, 'Ba Đờn C170', 2, 3, 'ba-don-c170-1.jpg,ba-don-c170-2.jpg,ba-don-c170-3.jpg,ba-don-c170-4.jpg,ba-don-c170-5.jpg,ba-don-c170-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:12:22', '2026-03-23 13:42:36'),
(6, 'Ba Đờn C250', 2, 3, 'ba-don-c250-1.jpg,ba-don-c250-2.jpg,ba-don-c250-3.jpg,ba-don-c250-4.jpg,ba-don-c250-5.jpg,ba-don-c250-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:13:18', '2026-03-23 13:42:36'),
(7, 'Yamaha C40mii C CX', 2, 4, 'yamaha-c40mii-c-cx-1.jpg,yamaha-c40mii-c-cx-2.jpg,yamaha-c40mii-c-cx-3.jpg,yamaha-c40mii-c-cx-4.jpg,yamaha-c40mii-c-cx-5.jpg,yamaha-c40mii-c-cx-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:14:36', '2026-03-23 13:42:36'),
(8, 'Yamaha GC42S GC GCX', 2, 4, 'yamaha-gc42s-gc-gcx-1.jpg,yamaha-gc42s-gc-gcx-2.jpg,yamaha-gc42s-gc-gcx-3.jpg,yamaha-gc42s-gc-gcx-4.jpg,yamaha-gc42s-gc-gcx-5.jpg,yamaha-gc42s-gc-gcx-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:15:47', '2026-03-23 13:42:36'),
(9, 'Yamaha GL1 Guitarlele', 2, 4, 'yamaha-gl1-guitarlele-1.jpg,yamaha-gl1-guitarlele-2.jpg,yamaha-gl1-guitarlele-3.jpg,yamaha-gl1-guitarlele-4.jpg,yamaha-gl1-guitarlele-5.jpg,yamaha-gl1-guitarlele-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:17:08', '2026-03-23 13:42:36'),
(12, 'Saga SS 8CE', 1, 1, 'saga-ss-8ce-1.jpg,saga-ss-8ce-2.jpg,saga-ss-8ce-3.jpg,saga-ss-8ce-4.jpg,saga-ss-8ce-5.jpg,saga-ss-8ce-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:19:41', '2026-03-23 13:42:36'),
(13, 'Enya EA X2', 1, 5, 'enya-ea-x2-1.jpg,enya-ea-x2-2.jpg,enya-ea-x2-3.jpg,enya-ea-x2-4.jpg,enya-ea-x2-5.jpg,enya-ea-x2-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:25:28', '2026-03-23 13:42:36'),
(14, 'Enya EGA X0 PRO SP1', 1, 5, 'enya-ega-x0-pro-sp1-1.jpg,enya-ega-x0-pro-sp1-2.jpg,enya-ega-x0-pro-sp1-3.jpg,enya-ega-x0-pro-sp1-4.jpg,enya-ega-x0-pro-sp1-5.jpg,enya-ega-x0-pro-sp1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:26:43', '2026-03-23 13:42:36'),
(15, 'Enya EM X1 SP1', 1, 5, 'enya-em-x1-sp1-1.jpg,enya-em-x1-sp1-2.jpg,enya-em-x1-sp1-3.jpg,enya-em-x1-sp1-4.jpg,enya-em-x1-sp1-5.jpg,enya-em-x1-sp1-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:27:38', '2026-03-23 13:42:36'),
(16, 'Taylor 110E', 1, 2, 'taylor-110e-1.jpg,taylor-110e-2.jpg,taylor-110e-3.jpg,taylor-110e-4.jpg,taylor-110e-5.jpg,taylor-110e-6.jpg', NULL, NULL, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-07 19:28:36', '2026-03-23 13:42:36'),
(23, 'Jack', 1, 5, NULL, NULL, NULL, 0.00, 20.00, 0.00, 3500000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 07:53:46', '2026-03-23 13:42:36'),
(26, 'jack', 1, 2, 'jack-1.png,jack-2.png,jack-3.png,jack-4.png,jack-5.png,jack-6.png', '', '', 0.00, 20.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', '2026-03-22 17:08:03', '2026-03-23 13:42:36'),
(27, 'tày enzoo', 1, 2, 'tay-enzo-1.png,tay-enzo-2.png,tay-enzo-3.png,tay-enzo-4.png,tay-enzo-5.png,tay-enzo-6.png', '', '', 0.00, 20.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', '2026-03-22 17:08:39', '2026-03-23 13:42:36'),
(29, 'akkakaka', 1, 1, 'akkakaka-1.jpeg,akkakaka-2.jpg,akkakaka-3.jpg,akkakaka-4.jpg,akkakaka-17742063870.jpg,akkakaka-17742517870.png', 'hih', 'hihihi', 0.00, 20.00, 0.00, 0.00, 'Âm thanh', 'asdfsfsfssfs', 'Màu sắc', 'sdsfsfsdfs', 'Chiều cao', '15', 'Chiều dài', '18', '[\"dây xích meo\"]', '2026-03-22 18:54:23', '2026-03-23 13:42:36');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_brand` (`brand_id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
