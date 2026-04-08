-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 06, 2026 lúc 09:45 AM
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
-- Cấu trúc bảng cho bảng `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `fullname`, `email`, `phone`, `avatar`, `password`, `created_at`, `last_login`) VALUES
(1, 'admin', 'Trần Hà Linh', 'linhhatran@gmail.com', '0783445439', NULL, '123', '2026-03-23 18:27:11', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `brand_slug` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('visible','hidden') DEFAULT 'visible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `description`, `brand_slug`, `created_at`, `status`) VALUES
(1, 'Saga', NULL, 'saga', '2026-03-08 13:38:37', 'visible'),
(2, 'Taylor', NULL, 'taylor', '2026-03-08 13:38:37', 'visible'),
(3, 'Ba Đờn', NULL, 'ba-don', '2026-03-08 13:38:37', 'visible'),
(4, 'Yamaha', '', 'yamaha', '2026-03-08 13:38:37', 'visible'),
(5, 'Enya', 'đàn cho nhà giàu', 'enya', '2026-03-08 13:38:37', 'visible');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand_category`
--

CREATE TABLE `brand_category` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_profit` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brand_category`
--

INSERT INTO `brand_category` (`brand_id`, `category_id`, `brand_profit`) VALUES
(1, 1, 20.00),
(2, 1, 20.00),
(3, 2, 20.00),
(4, 1, 20.00),
(4, 2, 20.00),
(5, 1, 32.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(73, 1, 13, 1, '2026-03-26 08:13:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `profit_margin` decimal(5,2) DEFAULT 20.00,
  `category_slug` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('visible','hidden') DEFAULT 'visible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `profit_margin`, `category_slug`, `description`, `status`) VALUES
(1, 'Guitar Acoustic', 25.00, 'guitar-acoustic', 'Dòng guitar thùng sử dụng dây kim loại.', 'visible'),
(2, 'Guitar Classic', 30.00, 'guitar-classic', 'Dòng guitar thùng sử dụng dây nylon.', 'visible');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipts`
--

CREATE TABLE `import_receipts` (
  `id` int(11) NOT NULL,
  `receipt_code` varchar(50) NOT NULL COMMENT 'Mã phiếu nhập (VD: PN001)',
  `import_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(15,2) DEFAULT 0.00 COMMENT 'Tổng giá trị phiếu nhập',
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `import_receipts`
--

INSERT INTO `import_receipts` (`id`, `receipt_code`, `import_date`, `total_amount`, `note`, `created_at`) VALUES
(19, 'PN-260326-002', '2026-03-02 00:00:00', 123500000.00, NULL, '2026-03-25 19:42:33'),
(20, 'PN-260326-003', '2026-03-06 00:00:00', 11000000.00, NULL, '2026-03-25 19:44:16'),
(21, 'PN-260326-004', '2026-03-21 00:00:00', 60000000.00, NULL, '2026-03-25 19:45:14'),
(22, 'PN-260326-005', '2026-03-26 00:00:00', 24000000.00, NULL, '2026-03-25 19:46:17'),
(23, 'PN-260326-006', '2026-03-01 00:00:00', 150700000.00, NULL, '2026-03-25 19:50:29'),
(30, 'PN-040426-001', '2026-04-04 00:00:00', 3023232.00, NULL, '2026-04-03 17:29:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipt_details`
--

CREATE TABLE `import_receipt_details` (
  `id` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL COMMENT 'Liên kết với bảng import_receipts',
  `product_id` int(11) NOT NULL COMMENT 'Liên kết với bảng products',
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Giá nhập tại thời điểm đó'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `import_receipt_details`
--

INSERT INTO `import_receipt_details` (`id`, `receipt_id`, `product_id`, `quantity`, `unit_price`) VALUES
(21, 19, 2, 25, 1300000.00),
(22, 19, 8, 4, 5000000.00),
(23, 19, 7, 8, 7000000.00),
(24, 19, 6, 1, 10000000.00),
(25, 20, 13, 5, 2200000.00),
(26, 21, 12, 15, 4000000.00),
(27, 22, 11, 4, 6000000.00),
(28, 23, 10, 12, 3200000.00),
(29, 23, 4, 20, 1200000.00),
(30, 23, 3, 19, 2200000.00),
(31, 23, 1, 15, 3100000.00),
(39, 30, 4, 2, 900000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_code` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `order_notes` text DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `order_status` enum('newest','processed','deliveried','cancel') DEFAULT 'newest',
  `payment_method` enum('COD','bank_transfer') NOT NULL DEFAULT 'COD',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `customer_name`, `phone`, `email`, `shipping_address`, `order_notes`, `total_amount`, `order_status`, `payment_method`, `created_at`, `updated_at`) VALUES
(17, 1, 'ORD-2026-EAD54', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', '111 đường Hoa Nguyễn Họe, Phường 1, Thành phố Hồ Chí Minh', 'Quăng vô nhà cho anh', 4921333.33, 'newest', 'COD', '2026-03-25 19:53:20', '2026-03-25 19:53:20'),
(18, 1, 'ORD-2026-C1754', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', 'Nhà của MCK, Cầu Giấy, Phố Quan Hoa, Hà Nội', '', 4788000.00, 'processed', 'COD', '2026-03-25 20:06:34', '2026-03-25 20:24:28'),
(19, 1, 'ORD-2026-8AE5F', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', 'Nhà của MCK, Cầu Giấy, Phố Quan Hoa, Hà Nội', '', 7800000.00, 'cancel', 'COD', '2026-03-25 20:06:51', '2026-03-25 22:19:05'),
(20, 1, 'ORD-2026-D9534', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', 'Nhà của MCK, Cầu Giấy, Phố Quan Hoa, Hà Nội', '', 9842666.66, 'newest', 'COD', '2026-03-25 22:22:21', '2026-03-25 22:22:21'),
(21, 1, 'ORD-2026-5D842', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', 'Nhà của MCK, Cầu Giấy, Phố Quan Hoa, Hà Nội', '', 4921333.33, 'newest', 'COD', '2026-03-25 22:22:50', '2026-03-25 22:22:50'),
(22, 1, 'ORD-2026-6E7A0', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', 'Nhà của MCK, Cầu Giấy, Phố Quan Hoa, Hà Nội', '', 7626000.00, 'deliveried', 'COD', '2026-03-25 22:24:06', '2026-03-26 07:08:00'),
(23, 1, 'ORD-2026-D9B8E', 'Nghiêm Vũ Hoàng Long', '(012) 345-6789', 'nghiemtong@gmail.com', 'Nhà của MCK, Cầu Giấy, Phố Quan Hoa, Hà Nội', 'zzz', 3900.00, 'deliveried', 'COD', '2026-03-26 07:59:41', '2026-03-26 08:00:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `original_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `unit_price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `original_price`, `discount_percent`, `unit_price`) VALUES
(23, 17, 15, 1, 2083333.33, 0.00, 2083333.33),
(24, 17, 15, 1, 2083333.33, 0.00, 2083333.33),
(25, 18, 12, 1, 5040000.00, 5.00, 4788000.00),
(26, 19, 11, 1, 7800000.00, 0.00, 7800000.00),
(27, 20, 15, 2, 2083333.33, 0.00, 2083333.33),
(28, 20, 13, 2, 2838000.00, 0.00, 2838000.00),
(29, 21, 15, 1, 2083333.33, 0.00, 2083333.33),
(30, 21, 13, 1, 2838000.00, 0.00, 2838000.00),
(31, 22, 13, 1, 2838000.00, 0.00, 2838000.00),
(32, 22, 12, 1, 5040000.00, 5.00, 4788000.00),
(33, 23, 18, 3, 1300.00, 0.00, 1300.00);

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
  `stock_quantity` int(11) DEFAULT 0,
  `status` enum('visible','hidden') DEFAULT 'visible',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_name`, `category_id`, `brand_id`, `product_images`, `summary_description`, `detailed_overview`, `cost_price`, `profit_margin`, `discount_percent`, `selling_price`, `highlight_1_title`, `highlight_1_content`, `highlight_2_title`, `highlight_2_content`, `highlight_3_title`, `highlight_3_content`, `highlight_4_title`, `highlight_4_content`, `accessories`, `stock_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Taylor A12E', 1, 2, 'taylor-a12e-1.jpg,taylor-a12e-2.jpg', '', '', 3100000.00, 30.00, 0.00, 4030000.00, '', '', '', '', '', '', '', '', '[]', 15, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:50:29'),
(2, 'Ba đờn C100', 2, 3, 'ba-don-c100-1.jpg,ba-don-c100-2.jpg,ba-don-c100-3.jpg,ba-don-c100-4.jpg,ba-don-c100-5.jpg,ba-don-c100-6.jpg', '', '', 1300000.00, 42.00, 12.00, 1846000.00, '', '', '', '', '', '', '', '', '[]', 25, 'visible', '2026-03-24 11:42:46', '2026-03-26 08:18:37'),
(3, 'Ba Đờn C150', 2, 3, 'ba-don-c150-1.jpg', NULL, NULL, 2200000.00, 38.00, 0.00, 3036000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:50:29'),
(4, 'Ba Đờn C170', 2, 3, 'ba-don-c170-1.jpg', '', '', 1172727.27, 27.00, 0.00, 1489363.64, '', '', '', '', '', '', '', '', '[]', 22, 'visible', '2026-03-24 11:42:46', '2026-04-03 17:29:44'),
(5, 'Ba Đờn C250', 2, 3, 'ba-don-c250-1.jpg', '', '', 0.00, 25.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', 0, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:48:17'),
(6, 'Yamaha C40mii', 2, 4, 'yamaha-c40mii-1.jpg,yamaha-c40mii-2.jpg,yamaha-c40mii-3.jpg,yamaha-c40mii-4.jpg', '', '', 10000000.00, 30.00, 0.00, 13000000.00, '', '', '', '', '', '', '', '', '[]', 1, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:42:33'),
(7, 'Yamaha GC42S', 2, 4, 'yamaha-gc42s-1.jpg,yamaha-gc42s-2.jpg,yamaha-gc42s-3.jpg', '', '', 7000000.00, 28.00, 15.00, 8960000.00, '', '', '', '', '', '', '', '', '[]', 8, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:42:33'),
(8, 'Yamaha GL1', 2, 4, 'yamaha-gl1-1.jpg,yamaha-gl1-2.jpg,yamaha-gl1-3.jpg,yamaha-gl1-4.jpg,yamaha-gl1-5.jpg,yamaha-gl1-6.jpg', '', '', 5000000.00, 50.00, 0.00, 7500000.00, '', '', '', '', '', '', '', '', '[]', 4, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:42:33'),
(9, 'Saga SS 8CE', 1, 1, 'saga-ss-8ce-1.jpg', '', '', 0.00, 28.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '[]', 0, 'visible', '2026-03-24 11:42:46', '2026-03-30 06:04:29'),
(10, 'Enya EA X2', 1, 5, 'enya-ea-x2-1.jpg', '', '', 3200000.00, 30.00, 0.00, 4160000.00, '', '', '', '', '', '', '', '', '[]', 12, 'visible', '2026-03-24 11:42:46', '2026-03-25 19:50:29'),
(11, 'Enya EGA X0 PRO', 1, 5, 'enya-ega-x0-pro-1.jpg,enya-ega-x0-pro-2.jpg,enya-ega-x0-pro-3.jpg,enya-ega-x0-pro-4.jpg,enya-ega-x0-pro-5.jpg,enya-ega-x0-pro-6.jpg', '', '', 6000000.00, 30.00, 0.00, 7800000.00, '', '', '', '', '', '', '', '', '[]', 4, 'visible', '2026-03-24 11:42:46', '2026-03-25 22:19:05'),
(12, 'Enya EM X1 SP1', 1, 5, 'enya-em-x1-sp1-1.jpg', '', '', 4000000.00, 26.00, 5.00, 5040000.00, '', '', '', '', '', '', '', '', '[\"Dây đàn rỉ sét\"]', 13, 'visible', '2026-03-24 11:42:46', '2026-03-25 22:24:06'),
(13, 'Taylor 110E', 1, 2, 'taylor-110e-1.jpg', NULL, NULL, 2200000.00, 29.00, 0.00, 2838000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'visible', '2026-03-24 11:42:46', '2026-03-25 22:24:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `sound_rating` tinyint(4) NOT NULL DEFAULT 5,
  `specs_rating` tinyint(4) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_purchased` tinyint(4) DEFAULT 0,
  `status` enum('visible','hidden') DEFAULT 'visible',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `sound_rating`, `specs_rating`, `comment`, `image_path`, `is_purchased`, `status`, `created_at`) VALUES
(2, 10, 1, 5, 5, 5, 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', NULL, 0, 'visible', '2026-03-25 16:36:26'),
(3, 10, 23, 5, 5, 5, 'SẢn phẩm này bủh bủh lmao quá, thích', 'assets/img/reviews/review_23_10_1774456888_0.jpg,assets/img/reviews/review_23_10_1774456888_1.jpg,assets/img/reviews/review_23_10_1774456888_2.jpg', 0, 'visible', '2026-03-25 16:41:28'),
(4, 1, 23, 1, 1, 2, 'Sản phẩm này k phù hợp với huy', 'assets/img/reviews/review_23_1_1774460383_0.png,assets/img/reviews/review_23_1_1774460383_1.jpg,assets/img/reviews/review_23_1_1774460383_2.jpeg', 0, 'visible', '2026-03-25 17:39:43'),
(5, 4, 23, 5, 5, 5, 'ngon đấy shop iu ơi, ủng hộ nè', 'assets/img/reviews/review_23_4_1774460890_0.jpg', 0, 'visible', '2026-03-25 17:48:10'),
(6, 3, 23, 5, 5, 5, 'Thay vì để 5.0, bạn nên để \"Chưa có đánh giá\" hoặc hiển thị 5 sao màu xám nhạt kèm số (0). Nếu vẫn muốn dùng số, hãy dùng 0.0 (0) hoặc - (0).', NULL, 0, 'visible', '2026-03-25 17:48:40'),
(27, 1, 1, 4, 4, 4, 'Thiết kế đẹp, phù hợp mang đi dã ngoại vì size nhỏ gọn. Tiếng hơi đanh nhưng chơi quạt chả rất lực.', NULL, 0, 'visible', '2026-03-26 02:15:00'),
(28, 2, 23, 5, 5, 5, 'Shop tư vấn siêu nhiệt tình, mình xin thêm pick gảy shop cũng cho luôn. Cần đàn thẳng tắp, dễ bấm cực kỳ.', NULL, 1, 'visible', '2026-03-26 03:20:15'),
(29, 3, 1, 3, 3, 4, 'Chất lượng cũng tạm ổn trong tầm giá. Nước sơn không đều lắm ở viền đàn, nhưng mua về tập vọc vạch thì OK.', NULL, 0, 'visible', '2026-03-26 04:30:45'),
(31, 5, 23, 4, 4, 4, 'Giao hàng cực kỳ nhanh. Đàn xịn, gõ thùng nghe rất ấm, đáng đồng tiền bát gạo nhưng khóa đàn lúc đầu hơi rít.', NULL, 0, 'visible', '2026-03-26 07:10:05'),
(33, 7, 23, 5, 5, 5, 'Cắm ra amply test thử nghe hú hồn luôn, pickup bắt tiếng trong vắt, EQ chỉnh mượt, tuyệt vời!', NULL, 1, 'visible', '2026-03-26 09:05:00'),
(35, 6, 1, 1, 1, 2, 'Giao nhầm mãng màu rồi shop ơi. Mình đặt bản màu đen nhám mà giao màu tự nhiên, inb không thấy rep.', NULL, 1, 'visible', '2026-03-26 11:22:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('mega_sale_desc', 'Nếu bạn đã lỡ tay hoặc vô tình đập đi cây đàn yêu dấu của mình thì đừng buồn, những con số dưới đây biểu hiện cho thời điểm để bạn mua và trải nghiệm một cây đàn cao cấp với mức giá siêu hời.'),
('mega_sale_end_date', '2027/02/09'),
('mega_sale_title', 'Đếm ngược ngày đại ưu đãi'),
('warning_threshold', '5');

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
(1, 'rpt.mckkk', 'mck', '2026-03-23 18:27:11', 'Nghiêm Vũ Hoàng Long', 'nghiemtong@gmail.com', '(012) 345-6789', 'Nhà của MCK', 'Hà Nội', 'Phố Quan Hoa', 'Cầu Giấy', 'assets/img/person/mckhutthuocbangchan.jpeg', 0, NULL),
(22, 'wxrdie', 'wxrdie', '2026-03-23 18:27:11', 'Phạm Nam Hải', 'wrxdie@gmail.com', '(012) 345-1111', 'Nhà của MCK', 'Hà Nội', 'Phố Quan Hoa', 'Cầu Giấy', 'assets/img/avatars/1774078406_wxrdie.jpg', 0, NULL),
(23, 'tlinh', 'tlinh', '2026-03-23 18:27:11', 'Nguyễn Thảo Linh', 'tlinh@gmail.com', '(012) 345-2222', NULL, NULL, NULL, NULL, 'assets/img/avatars/1774079282_tlinhdautroc.jpg', 0, NULL),
(24, 'longchimloi', 'long123', '2026-03-23 18:27:11', 'Nguyễn Hoàng Long', 'longchimloi@gmail.com', '0912345678', '12 Nguyễn Trãi', 'Hồ Chí Minh', 'Quận 1', 'Phường Bến Thành', 'assets/img/person/longchimloi.jpg', 1, 'Nghi ngờ gian lận / lừa đảo'),
(25, 'wxrdie2', 'wxr123', '2026-03-23 18:27:11', 'Trần Minh Khoa', 'minhkhoa@gmail.com', '0923456789', '45 Lê Lợi', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/wxrdie.jpg', 0, NULL),
(26, 'gdragon_vn', 'gd123', '2026-03-23 18:27:11', 'Kwon Ji Young', 'gdragon@gmail.com', '0934567890', '7 Phạm Ngũ Lão', 'Hồ Chí Minh', 'Quận 1', 'Phường Phạm Ngũ Lão', 'assets/img/person/gdragon.png', 0, NULL),
(27, 'jackj97', 'jack123', '2026-03-23 18:27:11', 'Trịnh Trần Phương Tuấn', 'jackj97@gmail.com', '0945678901', '99 Cách Mạng Tháng 8', 'Hồ Chí Minh', 'Quận 10', 'Phường 5', 'assets/img/person/jack.png', 0, NULL),
(28, 'soicodoc2', 'soi123', '2026-03-23 18:27:11', 'Nguyễn Văn Sói', 'soicodoc@gmail.com', '0956789012', '33 Đinh Tiên Hoàng', 'Hà Nội', 'Hoàn Kiếm', 'Phường Tràng Tiền', 'assets/img/person/soicodoc.jpg', 0, NULL),
(29, 'namperfect2', 'nam123', '2026-03-23 18:27:11', 'Trần Nam Perfect', 'namperfect@gmail.com', '0967890123', '88 Bà Triệu', 'Hà Nội', 'Hai Bà Trưng', 'Phường Bùi Thị Xuân', 'assets/img/person/namperfect.jpg', 0, NULL),
(30, 'datvantay2', 'dat123', '2026-03-23 18:27:11', 'Nguyễn Đạt Văn Tây', 'datvantay@gmail.com', '0978901234', '15 Nguyễn Huệ', 'Đà Nẵng', 'Hải Châu', 'Phường Thạch Thang', 'assets/img/person/datvantay.jpg', 0, NULL),
(31, 'dangrangcom', 'dang123', '2026-03-23 18:27:11', 'Đặng Rang Cơm', 'dangrangcom@gmail.com', '0989012345', '22 Trần Phú', 'Đà Nẵng', 'Hải Châu', 'Phường Nam Dương', 'assets/img/person/dangrangcom.jpg', 0, NULL),
(32, 'anhnhancobap', 'anh123', '2026-03-23 18:27:11', 'Lê Văn Nhân', 'anhnhancobap@gmail.com', '0990123456', '56 Hùng Vương', 'Cần Thơ', 'Ninh Kiều', 'Phường Tân An', 'assets/img/person/anhnhancobap.jpg', 0, NULL),
(33, 'chautinhtri2', 'chau123', '2026-03-23 18:27:11', 'Châu Tinh Trì Fan', 'chautinhtri@gmail.com', '0901234567', '100 Võ Văn Tần', 'Hồ Chí Minh', 'Quận 3', 'Phường 6', 'assets/img/person/chautinhtri.jpg', 0, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brand_category`
--
ALTER TABLE `brand_category`
  ADD PRIMARY KEY (`brand_id`,`category_id`),
  ADD KEY `fk_bc_category` (`category_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipt_code` (`receipt_code`);

--
-- Chỉ mục cho bảng `import_receipt_details`
--
ALTER TABLE `import_receipt_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_receipt` (`receipt_id`),
  ADD KEY `fk_detail_product` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_brand` (`brand_id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

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
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `import_receipt_details`
--
ALTER TABLE `import_receipt_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `brand_category`
--
ALTER TABLE `brand_category`
  ADD CONSTRAINT `fk_bc_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bc_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `import_receipt_details`
--
ALTER TABLE `import_receipt_details`
  ADD CONSTRAINT `fk_real_detail_receipt` FOREIGN KEY (`receipt_id`) REFERENCES `import_receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
