-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 12:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `felix-api-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nameBn` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `created_at`, `updated_at`, `nameBn`) VALUES
(1, 'Block', '2023-12-05 04:48:09', '2023-12-05 04:48:09', NULL),
(2, 'Red', '2023-12-05 04:48:26', '2023-12-05 04:48:26', NULL),
(3, 'Blue', '2023-12-05 04:48:42', '2023-12-05 04:48:42', NULL),
(4, 'Gray', '2023-12-05 04:48:52', '2023-12-05 04:48:52', NULL),
(5, 'Green', '2023-12-05 04:49:01', '2023-12-05 04:49:01', NULL),
(6, 'Black', '2023-12-05 04:52:45', '2023-12-05 04:52:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `mobile`, `email`, `name`, `address`, `created_at`, `updated_at`) VALUES
(1, '01722734299', 'hmezbah99@gmail.com', 'Mezbah99', 'Dhaka', '2023-12-05 04:50:33', '2023-12-05 04:50:33'),
(2, '01722734288', 'hmezbah88@gmail.com', 'Mezbah88', 'Dhaka', '2023-12-05 04:50:51', '2023-12-05 04:50:51'),
(3, '01722734277', 'hmezbah77@gmail.com', 'Mezbah77', 'Dhaka', '2023-12-05 04:51:10', '2023-12-05 04:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(31, '2014_10_12_000000_create_users_table', 1),
(32, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(33, '2019_08_19_000000_create_failed_jobs_table', 1),
(34, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(35, '2023_11_30_103430_alter_users_table', 1),
(36, '2023_11_30_110629_alert_users_table', 1),
(37, '2023_11_30_123814_create_units_table', 1),
(38, '2023_12_02_072037_create_colors_table', 1),
(39, '2023_12_02_090341_create_products_table', 1),
(40, '2023_12_02_095652_create_customers_table', 1),
(42, '2023_12_03_103308_create_product_stocks_table', 1),
(43, '2023_12_03_120917_alter_colors_table', 1),
(44, '2023_12_05_102956_create_orders_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `shipping_charge` double DEFAULT NULL,
  `total_price` double(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'Unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `product_id`, `quantity`, `shipping_charge`, `total_price`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 50, 500.00, 'Pending', 'Unpaid', '2023-12-05 04:57:20', '2023-12-05 04:57:20'),
(2, 1, 2, 2, 50, 100.00, 'Pending', 'Unpaid', '2023-12-05 04:58:26', '2023-12-05 04:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'MyApp', '15422a57056611bea90a0c27debe733b7887cec2df835f8d69a4987854ba1cda', '[\"*\"]', NULL, NULL, '2023-12-05 04:40:50', '2023-12-05 04:40:50'),
(2, 'App\\Models\\User', 2, 'MyApp', 'a6a2bfd892ef7507df51bf3e44e7907b08b4d7d455d2ab1875d1e2446cee93e2', '[\"*\"]', NULL, NULL, '2023-12-05 04:41:13', '2023-12-05 04:41:13'),
(3, 'App\\Models\\User', 3, 'MyApp', '60d8350d9664d5cdd1e694d57b272557dee1799c181443530454c81933976be6', '[\"*\"]', NULL, NULL, '2023-12-05 04:41:26', '2023-12-05 04:41:26'),
(4, 'App\\Models\\User', 1, 'MyApp', 'feff4f883a4662686a68e5afa4e66fad1a0974e75ade36ef5bace6aeb4f993a7', '[\"*\"]', NULL, NULL, '2023-12-05 04:49:21', '2023-12-05 04:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `barcode`, `qty`, `size`, `type`, `price`, `unit_id`, `color_id`, `created_at`, `updated_at`) VALUES
(1, 'jama', '1335', 40, 'full', 'solid', 2000.00, 1, 6, '2023-12-05 04:52:45', '2023-12-05 04:54:22'),
(2, 'Shirt', '1234', 50, 'full', 'solid', 2000.00, 1, 6, '2023-12-05 04:53:16', '2023-12-05 04:53:16'),
(3, 'Mobile', '1235', 50, 'full', 'solid', 2000.00, 1, 6, '2023-12-05 04:53:43', '2023-12-05 04:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('increase','decrease') NOT NULL,
  `qty` int(11) NOT NULL,
  `stock_date` date NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_no` varchar(255) NOT NULL,
  `sales_invoice_no` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `chalan_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `product_id`, `action`, `qty`, `stock_date`, `purchase_date`, `purchase_no`, `sales_invoice_no`, `remarks`, `supplier_name`, `chalan_no`, `created_at`, `updated_at`) VALUES
(1, 1, 'increase', 20, '2004-12-23', '2004-12-23', '1111', '111', 'Book', 'panjeri', '222', '2023-12-05 04:54:22', '2023-12-05 04:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `nameBn` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `nameBn`, `created_at`, `updated_at`) VALUES
(1, 'Amount', NULL, '2023-12-05 04:44:11', '2023-12-05 04:44:11'),
(2, 'Bottle', NULL, '2023-12-05 04:44:40', '2023-12-05 04:44:40'),
(3, 'Box', NULL, '2023-12-05 04:44:55', '2023-12-05 04:44:55'),
(4, 'Feet', NULL, '2023-12-05 04:45:12', '2023-12-05 04:45:12'),
(5, 'Kg', NULL, '2023-12-05 04:45:23', '2023-12-05 04:45:23'),
(6, 'Km', NULL, '2023-12-05 04:45:33', '2023-12-05 04:45:33'),
(7, 'Ltr', NULL, '2023-12-05 04:45:44', '2023-12-05 04:45:44'),
(8, 'Meter', NULL, '2023-12-05 04:45:55', '2023-12-05 04:45:55'),
(9, 'Tk', NULL, '2023-12-05 04:46:15', '2023-12-05 04:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `store` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `store`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `address`) VALUES
(1, 'Mezbah', '01722734209', 'Bismillah', NULL, '$2y$12$/rlYXD7IXJOkhe./JKgsXuZDqZnXfzL2s9KY63ak3jfrQLqzVBaPy', NULL, '2023-12-05 04:40:50', '2023-12-05 04:40:50', 'Dhaka'),
(2, 'Mezbah8', '01722734208', 'Bismillah8', NULL, '$2y$12$uRFRZlQXGqrC6i67hI9M1eSOWphp3YQGSRQR9OGXmb3g/QTsNFpQy', NULL, '2023-12-05 04:41:12', '2023-12-05 04:41:12', 'Dhaka'),
(3, 'Mezbah7', '01722734207', 'Bismillah7', NULL, '$2y$12$WKaaQ81GLngLK9/UDehgJeKZJElShFhXlJW4CKiQ3C0/f31de4uAG', NULL, '2023-12-05 04:41:26', '2023-12-05 04:41:26', 'Dhaka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`),
  ADD KEY `products_color_id_foreign` (`color_id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD CONSTRAINT `product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
