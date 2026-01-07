-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 05:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakso_pak_timan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` enum('bakso','mie','minuman') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `status` enum('tersedia','habis') NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `nama_menu`, `harga`, `deskripsi`, `kategori`, `foto`, `stok`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Bakso H', 2000, 'punya reza', 'bakso', NULL, 24, 'tersedia', '2025-12-22 08:07:20', '2026-01-07 08:33:40'),
(3, 'Es Tes', 3000, 'Teh Tawar', 'minuman', NULL, 100, 'tersedia', '2025-12-22 09:28:11', '2025-12-23 01:30:07'),
(5, 'Bakso Urat', 35000, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'bakso', 'menus/LlgpY2bs80lMLqB0047VBqgYLxNnu9OXVLfXJvka.png', 99, 'tersedia', '2025-12-23 07:53:46', '2026-01-07 08:33:40'),
(6, 'Bakso Halus', 29000, NULL, 'bakso', 'menus/UR6wrPEIr51qOE7K5howDM5f7fbuzDyvy9xGPxZV.png', 98, 'tersedia', '2025-12-26 02:54:01', '2026-01-07 08:33:40'),
(7, 'Es Jeruk', 5000, 'es jeruk segar', 'minuman', NULL, 100, 'tersedia', '2026-01-07 07:45:51', '2026-01-07 07:45:51');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_22_131633_add_role_to_users_table', 1),
(5, '2025_12_22_133003_create_menus_table', 1),
(6, '2025_12_22_163801_create_orders_table', 2),
(7, '2025_12_22_164001_create_order_items_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `total_qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `grand_total` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cash',
  `paid_amount` int(11) NOT NULL DEFAULT 0,
  `change_amount` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total_qty`, `subtotal`, `discount`, `grand_total`, `payment_method`, `paid_amount`, `change_amount`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-12-22 16:56:01', 1, 3000, 0, 3000, 'cash', 4000, 1000, '2025-12-22 09:56:01', '2025-12-22 09:56:01'),
(2, 1, '2025-12-22 17:31:54', 5, 15000, 0, 15000, 'cash', 15000, 0, '2025-12-22 10:31:54', '2025-12-22 10:31:54'),
(3, 1, '2025-12-22 17:35:10', 17, 51000, 2000, 49000, 'cash', 100000, 51000, '2025-12-22 10:35:10', '2025-12-22 10:35:10'),
(4, 1, '2025-12-22 17:38:16', 30, 60000, 0, 60000, 'qris', 80000, 20000, '2025-12-22 10:38:16', '2025-12-22 10:38:16'),
(5, 1, '2025-12-22 17:41:58', 5, 12000, 0, 12000, 'qris', 12000, 0, '2025-12-22 10:41:58', '2025-12-22 10:41:58'),
(6, 1, '2025-12-22 18:11:38', 1, 6000, 0, 6000, 'cash', 10000, 4000, '2025-12-22 11:11:38', '2025-12-22 11:11:38'),
(7, 1, '2025-12-22 18:22:17', 4, 13000, 0, 13000, 'cash', 13000, 0, '2025-12-22 11:22:17', '2025-12-22 11:22:17'),
(8, 1, '2025-12-22 18:29:58', 6, 18000, 0, 18000, 'cash', 18000, 0, '2025-12-22 11:29:58', '2025-12-22 11:29:58'),
(9, 1, '2025-12-22 18:30:13', 6, 36000, 0, 36000, 'cash', 0, -36000, '2025-12-22 11:30:13', '2025-12-22 11:30:13'),
(10, 1, '2025-12-22 19:19:30', 3, 11000, 0, 11000, 'cash', 11000, 0, '2025-12-22 12:19:30', '2025-12-22 12:19:30'),
(11, 1, '2025-12-23 07:02:13', 10, 20000, 0, 20000, 'cash', 20000, 0, '2025-12-23 00:02:13', '2025-12-23 00:02:13'),
(12, 1, '2025-12-23 07:02:53', 6, 18000, 0, 18000, 'cash', 10000, -8000, '2025-12-23 00:02:53', '2025-12-23 00:02:53'),
(13, 1, '2025-12-23 07:09:24', 6, 12000, 0, 12000, 'cash', 10000, -2000, '2025-12-23 00:09:24', '2025-12-23 00:09:24'),
(14, 1, '2025-12-23 07:20:24', 7, 14000, 0, 14000, 'cash', 50000, 36000, '2025-12-23 00:20:24', '2025-12-23 00:20:24'),
(15, 1, '2025-12-23 07:38:53', 4, 8000, 0, 8000, 'cash', 8000, 0, '2025-12-23 00:38:53', '2025-12-23 00:38:53'),
(16, 1, '2025-12-23 07:43:32', 6, 12000, 0, 12000, 'cash', 12000, 0, '2025-12-23 00:43:32', '2025-12-23 00:43:32'),
(17, 1, '2025-12-26 09:51:17', 6, 12000, 0, 12000, 'cash', 50000, 38000, '2025-12-26 02:51:17', '2025-12-26 02:51:17'),
(18, 1, '2026-01-07 15:33:40', 4, 95000, 0, 95000, 'cash', 100000, 5000, '2026-01-07 08:33:40', '2026-01-07 08:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 3000, 3000, '2025-12-22 09:56:01', '2025-12-22 09:56:01'),
(2, 2, 3, 5, 3000, 15000, '2025-12-22 10:31:54', '2025-12-22 10:31:54'),
(3, 3, 3, 17, 3000, 51000, '2025-12-22 10:35:10', '2025-12-22 10:35:10'),
(4, 4, 2, 30, 2000, 60000, '2025-12-22 10:38:16', '2025-12-22 10:38:16'),
(5, 5, 2, 3, 2000, 6000, '2025-12-22 10:41:58', '2025-12-22 10:41:58'),
(6, 5, 3, 2, 3000, 6000, '2025-12-22 10:41:58', '2025-12-22 10:41:58'),
(8, 7, 3, 1, 3000, 3000, '2025-12-22 11:22:17', '2025-12-22 11:22:17'),
(10, 7, 2, 2, 2000, 4000, '2025-12-22 11:22:17', '2025-12-22 11:22:17'),
(11, 8, 3, 6, 3000, 18000, '2025-12-22 11:29:58', '2025-12-22 11:29:58'),
(13, 10, 2, 1, 2000, 2000, '2025-12-22 12:19:30', '2025-12-22 12:19:30'),
(14, 10, 3, 1, 3000, 3000, '2025-12-22 12:19:30', '2025-12-22 12:19:30'),
(16, 11, 2, 10, 2000, 20000, '2025-12-23 00:02:13', '2025-12-23 00:02:13'),
(17, 12, 3, 6, 3000, 18000, '2025-12-23 00:02:53', '2025-12-23 00:02:53'),
(18, 13, 2, 6, 2000, 12000, '2025-12-23 00:09:24', '2025-12-23 00:09:24'),
(19, 14, 2, 7, 2000, 14000, '2025-12-23 00:20:24', '2025-12-23 00:20:24'),
(20, 15, 2, 4, 2000, 8000, '2025-12-23 00:38:53', '2025-12-23 00:38:53'),
(21, 16, 2, 6, 2000, 12000, '2025-12-23 00:43:32', '2025-12-23 00:43:32'),
(22, 17, 2, 6, 2000, 12000, '2025-12-26 02:51:17', '2025-12-26 02:51:17'),
(23, 18, 2, 1, 2000, 2000, '2026-01-07 08:33:40', '2026-01-07 08:33:40'),
(24, 18, 6, 2, 29000, 58000, '2026-01-07 08:33:40', '2026-01-07 08:33:40'),
(25, 18, 5, 1, 35000, 35000, '2026-01-07 08:33:40', '2026-01-07 08:33:40');

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8xmlPGCAk8ogx0S6OHMWp18yLY3uKTwD4rAxKLkB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjlqTHk2SUhCWXZibXJEbkxkdExvblQ4Z3NVdVFVRno5QTJPVVU4VyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMzoia2F0YWxvZy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767796509),
('TC971Fo9zYdX0gxP0YguTdMz7nIZN7tDapiagrbh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGZMZHEzMUJCaEk2TkhtalV1a3RWOHM1NlZzWVNiVVZRcXg2OWpCOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMzoia2F0YWxvZy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1767802284);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pak Timan', 'admin@pak-timan.com', 'admin', NULL, '$2y$12$f5Dj2OxN5jhJY8GP2hj0ee4x.wc1XqjAaaDj8tvXtI4kwNMYOpMsK', NULL, '2025-12-22 06:34:56', '2025-12-22 07:30:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
