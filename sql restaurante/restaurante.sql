-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-08-2026 a las 06:19:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@admin.com|127.0.0.1', 'i:1;', 1785548694),
('laravel-cache-admin@admin.com|127.0.0.1:timer', 'i:1785548694;', 1785548694),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:40:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"categorias.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:16:\"categorias.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:17:\"categorias.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:19:\"categorias.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"cajas.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"cajas.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"cajas.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"cajas.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"cajas.cerrar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"cajas.movimientos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:13:\"productos.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"productos.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:16:\"productos.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:18:\"productos.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:9:\"mesas.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:11:\"mesas.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"mesas.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"mesas.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:11:\"ordenes.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"ordenes.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"ordenes.cobrar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:10:\"ventas.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:15:\"ventas.reportes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:19:\"payment_methods.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:21:\"payment_methods.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:22:\"payment_methods.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:24:\"payment_methods.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:10:\"gastos.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:12:\"gastos.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:13:\"gastos.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"gastos.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"gastos.reportes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"usuarios.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"usuarios.crear\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"usuarios.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:17:\"usuarios.eliminar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"empresa.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:15:\"empresa.tablero\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:9:\"roles.ver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"roles.editar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:6:\"cajero\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"cocinero\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:6:\"mesero\";s:1:\"c\";s:3:\"web\";}}}', 1787533609);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cash_registers`
--

CREATE TABLE `cash_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `opening_amount` decimal(15,2) NOT NULL,
  `current_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `opened_by` bigint(20) UNSIGNED NOT NULL,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `opened_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `closed_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cash_registers`
--

INSERT INTO `cash_registers` (`id`, `name`, `opening_amount`, `current_amount`, `status`, `opened_by`, `closed_by`, `opened_at`, `closed_at`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Caja Principal', 100.00, 98.50, 'open', 1, NULL, '2026-07-24 00:55:33', NULL, 'en efectivo', '2026-07-24 00:55:33', '2026-07-24 19:28:10', '2026-07-24 19:28:10'),
(2, 'Caja Principal', 50.00, 225.00, 'closed', 1, NULL, '2026-07-24 19:28:43', '2026-07-25 05:28:27', 'Caja Principal - Unico', '2026-07-24 19:28:43', '2026-07-25 05:28:27', NULL),
(3, 'Caja Principal', 100.00, 976.00, 'closed', 5, NULL, '2026-07-25 05:29:07', '2026-07-26 05:14:34', 'Caja Principal en soles', '2026-07-25 05:29:07', '2026-07-26 05:14:34', NULL),
(4, 'Caja Principal', 80.00, 432.00, 'closed', 5, NULL, '2026-07-26 05:16:20', '2026-07-31 22:36:01', 'Con Sencillo', '2026-07-26 05:16:20', '2026-07-31 22:36:01', NULL),
(5, 'eduardo', 50.00, 100.80, 'open', 5, NULL, '2026-08-23 01:16:10', NULL, 'moneda', '2026-08-23 01:16:10', '2026-08-23 01:18:46', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ceviches', '2026-07-24 05:24:07', '2026-07-25 15:56:19', '2026-07-25 15:56:19'),
(2, 'Tiraditos', '2026-07-24 05:24:07', '2026-07-25 15:56:29', '2026-07-25 15:56:29'),
(3, 'Entradas', '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL),
(4, 'Bebidas Calientes', '2026-07-24 05:24:07', '2026-07-25 15:56:50', NULL),
(5, 'Jugos', '2026-07-24 05:24:07', '2026-07-25 15:57:03', NULL),
(6, 'Tragos', '2026-07-24 05:24:07', '2026-07-25 15:57:46', NULL),
(7, 'Platos criollos', '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL),
(8, 'Bebidas Heladas', '2026-07-24 05:24:07', '2026-07-25 15:57:56', NULL),
(9, 'Cervezas', '2026-07-24 05:24:07', '2026-07-25 15:56:08', '2026-07-25 15:56:08'),
(10, 'Postres', '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL),
(11, 'Pizza', '2026-07-24 01:00:34', '2026-07-24 01:00:34', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash_register_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `concept` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `expenses`
--

INSERT INTO `expenses` (`id`, `cash_register_id`, `payment_method_id`, `user_id`, `concept`, `description`, `amount`, `expense_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Compro Vasos Descartable', 'Compra Vasos Descartable (Blanco)', 1.50, '2026-07-23 19:55:00', '2026-07-24 19:31:41', '2026-07-24 00:57:00', '2026-07-24 19:31:41'),
(2, 2, 1, 1, 'Bolsa Blanca de 2x3', 'Bolsa Blanca de 2x3 cm ', 3.00, '2026-07-24 19:06:00', NULL, '2026-07-25 00:07:01', '2026-07-25 00:07:01'),
(3, 4, 1, 5, 'Delivery', 'Delivery a santa rosa', 4.00, '2026-07-26 00:27:00', NULL, '2026-07-26 05:28:05', '2026-07-26 05:28:05'),
(4, 4, 1, 1, 'VASOS DESCAR', 'BLAMCO', 2.00, '2026-07-31 16:11:00', NULL, '2026-07-31 21:12:10', '2026-07-31 21:12:10'),
(5, 5, 1, 5, 'compro bolsa', 'se fue al mercado', 1.20, '2026-08-22 20:18:00', NULL, '2026-08-23 01:18:46', '2026-08-23 01:18:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
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
-- Estructura de tabla para la tabla `jobs`
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
-- Estructura de tabla para la tabla `job_batches`
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
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000003_create_categories_table', 1),
(5, '2025_02_17_021817_create_payment_methods_table', 1),
(6, '2025_02_17_021914_create_cash_registers_table', 1),
(7, '2026_01_16_135701_create_settings_table', 1),
(8, '2026_02_17_031007_create_permission_tables', 1),
(9, '2026_04_02_141959_create_products_table', 1),
(10, '2026_04_02_142009_create_tables_table', 1),
(11, '2026_04_02_142022_create_orders_table', 1),
(12, '2026_04_02_142034_create_order_details_table', 1),
(13, '2026_04_10_140247_create_sales_table', 1),
(14, '2026_04_10_140538_create_sale_details_table', 1),
(15, '2026_04_10_141517_create_payments_table', 1),
(16, '2026_05_25_164520_create_expenses_table', 1),
(17, '2026_07_25_101440_create_product_sizes_table', 2),
(18, '2026_07_25_125525_add_product_size_id_to_order_details_table', 3),
(19, '2026_07_25_142521_add_product_size_id_to_sale_details_table', 4),
(20, '2026_07_25_182159_add_order_code_to_orders_table', 5),
(21, '2026_07_26_010051_add_sale_code_to_sales_table', 6),
(22, '2026_07_31_154706_add_color_to_tables_table', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `status` enum('abierto','cerrado','cancelado') NOT NULL DEFAULT 'abierto',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amount_pending` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `table_id`, `customer_id`, `user_id`, `customer_name`, `customer_phone`, `status`, `total`, `amount_pending`, `created_at`, `updated_at`) VALUES
(1, 'PD-0001', 1, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 100.00, 0.00, '2026-07-24 01:03:26', '2026-07-25 23:23:17'),
(2, 'PD-0002', 2, NULL, 1, 'Consumidor Final', NULL, 'cerrado', 78.00, 0.00, '2026-07-24 19:17:25', '2026-07-25 23:23:17'),
(3, 'PD-0003', 5, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 43.00, 0.00, '2026-07-25 05:53:16', '2026-07-25 23:23:17'),
(5, 'PD-0005', 1, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 54.00, 0.00, '2026-07-25 05:59:28', '2026-07-25 23:23:17'),
(6, 'PD-0006', 8, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 178.00, 0.00, '2026-07-25 17:37:33', '2026-07-25 23:23:17'),
(7, 'PD-0007', 7, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 59.00, 0.00, '2026-07-25 18:29:20', '2026-07-25 23:23:17'),
(8, 'PD-0008', 4, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 106.00, 0.00, '2026-07-25 18:59:38', '2026-07-25 23:23:17'),
(9, 'PD-0009', 1, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 152.00, 0.00, '2026-07-25 19:33:13', '2026-07-25 23:23:17'),
(10, 'PD-0010', 2, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 6.00, 0.00, '2026-07-25 23:15:26', '2026-07-25 23:29:59'),
(11, 'PD-0011', 3, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 45.00, 0.00, '2026-07-25 23:15:55', '2026-07-25 23:28:48'),
(12, 'PD-0012', 7, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 53.00, 0.00, '2026-07-25 23:56:54', '2026-07-26 05:16:58'),
(13, 'PD-0013', 7, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 72.00, 0.00, '2026-07-26 05:23:46', '2026-07-26 05:24:57'),
(14, 'PD-0014', 1, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 62.00, 0.00, '2026-07-26 06:25:29', '2026-07-26 06:26:20'),
(15, 'PD-0015', 4, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 56.00, 0.00, '2026-07-26 06:57:30', '2026-07-27 03:47:23'),
(16, 'PD-0016', NULL, NULL, 1, 'Consumidor Final', NULL, 'cerrado', 0.00, 0.00, '2026-07-31 04:01:17', '2026-07-31 04:30:48'),
(17, 'PD-0017', 5, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 0.00, 0.00, '2026-07-31 04:04:29', '2026-07-31 04:30:48'),
(18, 'PD-0018', 1, NULL, 2, 'Consumidor Final', NULL, 'cerrado', 36.00, 0.00, '2026-07-31 04:10:37', '2026-07-31 04:12:26'),
(19, 'PD-0019', 5, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 37.00, 0.00, '2026-07-31 21:08:41', '2026-07-31 21:10:16'),
(20, 'PD-0020', 8, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 0.00, 0.00, '2026-07-31 21:13:46', '2026-07-31 21:14:09'),
(21, 'PD-0021', 8, NULL, 6, 'Consumidor Final', NULL, 'cerrado', 32.00, 0.00, '2026-07-31 21:14:46', '2026-07-31 21:16:07'),
(22, 'PD-0022', 8, NULL, 5, 'Consumidor Final', NULL, 'cerrado', 52.00, 0.00, '2026-08-23 01:13:54', '2026-08-23 01:16:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `requires_kitchen` tinyint(1) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `cooking_status` enum('pending','in_progress','ready','served','cancelled') NOT NULL DEFAULT 'pending',
  `is_printed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_size_id`, `quantity`, `requires_kitchen`, `price`, `tax`, `subtotal`, `notes`, `cooking_status`, `is_printed`, `created_at`, `updated_at`) VALUES
(31, 8, 23, 4, 1, 1, 30.00, 0.00, 30.00, NULL, 'cancelled', 0, '2026-07-25 18:59:38', '2026-07-25 19:01:43'),
(32, 8, 24, 30, 1, 1, 62.00, 0.00, 62.00, NULL, 'cancelled', 0, '2026-07-25 18:59:38', '2026-07-25 19:01:30'),
(35, 8, 30, 12, 1, 1, 62.00, 0.00, 62.00, NULL, 'cancelled', 0, '2026-07-25 18:59:38', '2026-07-25 19:00:41'),
(36, 9, 13, NULL, 1, 1, 6.00, 0.00, 6.00, NULL, 'cancelled', 0, '2026-07-25 19:33:13', '2026-07-25 19:33:53'),
(38, 9, 24, 28, 1, 1, 32.00, 0.00, 32.00, NULL, 'cancelled', 0, '2026-07-25 19:33:13', '2026-07-25 19:33:44'),
(48, 13, 14, NULL, 1, 1, 5.00, 0.00, 5.00, NULL, 'cancelled', 0, '2026-07-26 05:23:46', '2026-07-26 05:24:08'),
(53, 16, 22, NULL, 1, 0, 8.00, 0.00, 8.00, NULL, 'cancelled', 0, '2026-07-31 04:01:17', '2026-07-31 04:09:30'),
(54, 16, 36, 46, 1, 1, 50.00, 0.00, 50.00, NULL, 'cancelled', 0, '2026-07-31 04:01:17', '2026-07-31 04:09:33'),
(55, 17, 15, NULL, 1, 1, 4.00, 0.00, 4.00, NULL, 'cancelled', 0, '2026-07-31 04:04:29', '2026-07-31 04:09:28'),
(56, 17, 21, 33, 1, 1, 72.00, 0.00, 72.00, NULL, 'cancelled', 0, '2026-07-31 04:04:29', '2026-07-31 04:09:21'),
(57, 17, 13, NULL, 1, 0, 6.00, 0.00, 6.00, NULL, 'cancelled', 0, '2026-07-31 04:06:58', '2026-07-31 04:09:26'),
(58, 17, 14, NULL, 1, 0, 5.00, 0.00, 5.00, NULL, 'cancelled', 0, '2026-07-31 04:06:58', '2026-07-31 04:09:13'),
(59, 17, 20, NULL, 1, 1, 35.00, 0.00, 35.00, NULL, 'cancelled', 0, '2026-07-31 04:07:30', '2026-07-31 04:09:18'),
(60, 17, 14, NULL, 2, 0, 5.00, 0.00, 10.00, NULL, 'cancelled', 0, '2026-07-31 04:07:30', '2026-07-31 04:09:08'),
(65, 20, 27, 20, 1, 1, 40.00, 0.00, 40.00, NULL, 'cancelled', 0, '2026-07-31 21:13:46', '2026-07-31 21:14:09'),
(69, 22, 18, NULL, 1, 0, 5.00, 0.00, 5.00, NULL, 'cancelled', 0, '2026-08-23 01:13:54', '2026-08-23 01:15:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('eduardoapsti20@gmail.com', '$2y$12$DgJdqJj6Y1Cz9S0XhTldtO.4pscakbBq/Md3mIxl24U3q42BroAM2', '2026-07-25 14:33:49'),
('Keni@gmail.com', '$2y$12$qnTP4knlviggLLhMZnl9lOOV3RL3vZGfdHaeUY.mxlyzYegAozYPC', '2026-07-25 14:33:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `received_amount` decimal(10,2) DEFAULT NULL,
  `returned_amount` decimal(10,2) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `sale_id`, `payment_method_id`, `amount`, `received_amount`, `returned_amount`, `reference`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 78.00, 80.00, 2.00, '', '2026-07-25 00:05:41', '2026-07-25 00:05:41'),
(2, 2, 1, 100.00, 100.00, 0.00, 'En soles me dio', '2026-07-25 00:29:57', '2026-07-25 00:29:57'),
(3, 3, 6, 20.00, 20.00, 0.00, '', '2026-07-25 06:02:52', '2026-07-25 06:02:52'),
(4, 4, 1, 38.00, 40.00, 2.00, '', '2026-07-25 06:03:29', '2026-07-25 06:03:29'),
(5, 5, 1, 43.00, 45.00, 2.00, '', '2026-07-25 06:05:07', '2026-07-25 06:05:07'),
(6, 6, 6, 350.00, 350.00, 0.00, '', '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(7, 7, 1, 8.00, 10.00, 2.00, '', '2026-07-25 18:45:43', '2026-07-25 18:45:43'),
(8, 8, 1, 147.00, 150.00, 3.00, '', '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(9, 9, 6, 50.00, 50.00, 0.00, '', '2026-07-25 19:14:44', '2026-07-25 19:14:44'),
(10, 10, 1, 8.00, 10.00, 2.00, '', '2026-07-25 19:20:04', '2026-07-25 19:20:04'),
(11, 11, 3, 48.00, 48.00, 0.00, '', '2026-07-25 19:20:38', '2026-07-25 19:20:38'),
(12, 12, 3, 80.00, 80.00, 0.00, '', '2026-07-25 19:35:14', '2026-07-25 19:35:14'),
(13, 13, 1, 80.00, 80.00, 0.00, '', '2026-07-25 19:36:30', '2026-07-25 19:36:30'),
(14, 14, 1, 45.00, 45.00, 0.00, '', '2026-07-25 23:28:48', '2026-07-25 23:28:48'),
(15, 15, 6, 10.00, 10.00, 0.00, '', '2026-07-25 23:29:59', '2026-07-25 23:29:59'),
(16, 16, 6, 53.00, 53.00, 0.00, '', '2026-07-26 05:16:57', '2026-07-26 05:16:57'),
(17, 17, 1, 72.00, 80.00, 8.00, '', '2026-07-26 05:24:57', '2026-07-26 05:24:57'),
(18, 18, 1, 72.00, 80.00, 8.00, '', '2026-07-26 06:26:20', '2026-07-26 06:26:20'),
(19, 19, 6, 60.00, 60.00, 0.00, '', '2026-07-27 03:47:23', '2026-07-27 03:47:23'),
(20, 20, 1, 36.00, 40.00, 4.00, '', '2026-07-31 04:12:26', '2026-07-31 04:12:26'),
(21, 21, 1, 37.00, 40.00, 3.00, '', '2026-07-31 21:10:16', '2026-07-31 21:10:16'),
(22, 22, 1, 32.00, 40.00, 8.00, '', '2026-07-31 21:16:07', '2026-07-31 21:16:07'),
(23, 23, 1, 52.00, 60.00, 8.00, '', '2026-08-23 01:16:59', '2026-08-23 01:16:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_efectivo` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `is_efectivo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Efectivo', 1, '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL),
(2, 'Tarjeta credito', 0, '2026-07-24 05:24:07', '2026-07-31 22:32:18', NULL),
(3, 'Tarjeta debito', 0, '2026-07-24 05:24:07', '2026-07-31 22:32:27', NULL),
(4, 'Transferencia bancaria', 0, '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL),
(5, 'Cheque', 0, '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL),
(6, 'Pago movil', 0, '2026-07-24 05:24:07', '2026-07-31 22:32:35', NULL),
(7, 'Criptomonedas', 0, '2026-07-24 05:24:07', '2026-07-24 05:24:07', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'categorias.ver', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(2, 'categorias.crear', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(3, 'categorias.editar', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(4, 'categorias.eliminar', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(5, 'cajas.ver', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(6, 'cajas.crear', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(7, 'cajas.editar', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(8, 'cajas.eliminar', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(9, 'cajas.cerrar', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(10, 'cajas.movimientos', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(11, 'productos.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(12, 'productos.crear', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(13, 'productos.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(14, 'productos.eliminar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(15, 'mesas.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(16, 'mesas.crear', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(17, 'mesas.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(18, 'mesas.eliminar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(19, 'ordenes.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(20, 'ordenes.crear', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(21, 'ordenes.cobrar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(22, 'ventas.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(23, 'ventas.reportes', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(24, 'payment_methods.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(25, 'payment_methods.crear', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(26, 'payment_methods.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(27, 'payment_methods.eliminar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(28, 'gastos.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(29, 'gastos.crear', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(30, 'gastos.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(31, 'gastos.eliminar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(32, 'gastos.reportes', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(33, 'usuarios.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(34, 'usuarios.crear', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(35, 'usuarios.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(36, 'usuarios.eliminar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(37, 'empresa.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(38, 'empresa.tablero', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(39, 'roles.ver', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(40, 'roles.editar', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `requires_kitchen` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `stock`, `status`, `image`, `requires_kitchen`, `created_at`, `updated_at`) VALUES
(13, 8, 'Camu camu', 6.00, 21, 1, 'products/LSAMTn8OcUKsgNzsXRwM2B5zw4KTtXOCcpgk0hG6.jpg', 0, '2026-07-24 05:24:07', '2026-07-31 04:10:37'),
(14, 8, 'Limonada', 5.00, 23, 1, 'products/WXXGcRUC0DGhUUkjV8RDEIokkuuZrspuqlNUgigc.jpg', 0, '2026-07-24 05:24:07', '2026-07-31 04:09:13'),
(15, 8, 'Maracuya', 4.00, 25, 1, 'products/52OrbuXN5LPRxJKgZiTLMJwteLBbJm42RQrg5wQC.jpg', 0, '2026-07-24 05:24:07', '2026-07-31 04:09:28'),
(18, 10, 'Queque de Chocolate', 5.00, 23, 1, 'products/Zr23vl6MqCHqwh7zVXD4coK6PfUQmhAc1mO7x74K.jpg', 0, '2026-07-24 05:24:07', '2026-08-23 01:15:07'),
(20, 11, 'Pizza Margarita', 35.00, 5, 1, 'products/iWnYzoXZ494IlpskxTMYHVFyqxFnd9mvhoW6sEbZ.jpg', 1, '2026-07-24 01:02:51', '2026-07-31 04:09:18'),
(21, 11, 'Pizza Peperoni', 35.00, 21, 1, 'products/YhUhndtDtiizK4hwpDYW8bdkwk5Of8GXC2X8o7Jl.jpg', 1, '2026-07-24 01:05:50', '2026-08-23 01:13:54'),
(22, 8, 'Inka Kola 1Litro', 8.00, 2, 1, 'products/fFy1NpOvhvoxghgrRIJeIC2ABowIY2CQRKQbulZx.jpg', 0, '2026-07-24 19:24:45', '2026-08-23 01:13:54'),
(23, 11, 'Pizza Americana', 30.00, 20, 1, 'products/dQhVaWzUmLQLTHL4i6ocnM639E54EidSn0jZ2hc4.jpg', 1, '2026-07-25 14:47:26', '2026-07-31 04:10:37'),
(24, 11, 'Pizza Oriental', 32.00, 25, 1, 'products/NgPhuhV5fhIejBNTLzCRdRsRqgtFrccAREdyFg34.jpg', 1, '2026-07-25 14:50:42', '2026-07-25 19:33:44'),
(25, 11, 'Pizza Hawaiana', 32.00, 23, 1, 'products/eKPFL3lSZfp4Fsy5Dl5rwp0Z1NjUx4yqmCi5NQm1.webp', 1, '2026-07-25 14:56:25', '2026-07-31 21:08:41'),
(26, 11, 'Pizza Vegetariana', 32.00, 23, 1, 'products/H1axc25py6una6hTEI0c1cdOlS9jxKSVdq00f9DH.jpg', 1, '2026-07-25 14:58:16', '2026-07-31 21:14:46'),
(27, 11, 'Pizza Francesa', 32.00, 22, 1, 'products/hnP4F6g32cXDzZrmiiAkwhmoVS5dNoW9n1UbY8Zw.webp', 1, '2026-07-25 15:00:47', '2026-07-31 21:14:09'),
(28, 11, 'Pizza Delicia', 32.00, 24, 1, 'products/yXoLZuCuOoJC2MTUZE7Wff2scF39vmelb3r3ccQO.jpg', 1, '2026-07-25 15:03:13', '2026-07-26 06:57:30'),
(29, 11, 'Pizza Mozzarella', 32.00, 24, 1, 'products/gHYqvNh1ICHpvqgcHfXjA3vJQWUrzRyACo9s9yXd.jpg', 1, '2026-07-25 15:04:56', '2026-07-25 18:59:38'),
(30, 11, 'Pizza Jamon', 32.00, 25, 1, 'products/ZxTowQcttIZktqK7HXilhk9Pb1FtXJzMLHy72PHy.jpg', 1, '2026-07-25 15:07:03', '2026-07-25 19:00:41'),
(31, 11, 'Pizza Salame', 32.00, 25, 1, 'products/N4UdvBe470b5h1RVmA90lBICeX18pOjjRSnt1AmC.jpg', 1, '2026-07-25 15:07:29', '2026-07-25 15:37:09'),
(32, 11, 'Pizza Continental', 40.00, 25, 1, 'products/aH7C0XAhWjLpOE1ZV3yKuwoOxkZN6nWlga3pfGvP.jpg', 1, '2026-07-25 15:45:46', '2026-07-25 18:22:08'),
(33, 11, 'Pizza Tropical', 37.00, 25, 1, 'products/mshwoldwD3OiohxHU60LnoT2wQS77Zez59sMU9ud.jpg', 1, '2026-07-25 15:49:29', '2026-07-25 15:49:29'),
(34, 11, 'Pizza Selvatica', 40.00, 25, 1, 'products/CvLkG7TVESbablir7V3EWGLhMS6yjjToOWii8QLY.jpg', 1, '2026-07-25 15:50:59', '2026-07-25 15:50:59'),
(35, 11, 'Pizza California', 45.00, 25, 1, 'products/s1PFnH5BrTCXlHJbQ9AmYCUK1BrYIQ6z8tidT4bu.webp', 1, '2026-07-25 15:52:45', '2026-07-25 15:52:45'),
(36, 11, 'Pizza Full Carne', 50.00, 25, 1, 'products/6xbNAhmSZu9Ezk91wNdf3brKJnBS5A8nA6voXHYr.webp', 1, '2026-07-25 15:55:06', '2026-07-31 04:09:33'),
(37, 11, 'Pizza Zu??iga Especial', 50.00, 25, 1, 'products/wHioj0NJ5aH1ctW6ZyOjwBEJDoqnt3iRUNEMEFGH.jpg', 1, '2026-07-25 15:55:46', '2026-07-25 15:55:46'),
(38, 8, 'Quito Quito', 15.00, 25, 1, 'products/bTG9bkmMgceIYoaR0gPrzhGwlR7wGuvxTwMMiwOb.jpg', 1, '2026-07-25 16:21:35', '2026-07-25 17:29:49'),
(39, 8, 'Guanabana', 5.00, 24, 1, 'products/3OiFOZ84FkWakJvjOxvkrQrIGn51FfoJF3fN7PPK.jpg', 1, '2026-07-25 16:22:58', '2026-07-31 21:08:41'),
(40, 4, 'Cafe', 4.00, 25, 1, 'products/k1ApREpp8LhkUCDTsaHPuoDtrDS8nlWcsvQWKl4k.jpg', 1, '2026-07-25 16:23:32', '2026-07-25 17:30:04'),
(41, 4, 'Capuchino', 5.00, 25, 1, 'products/2aiiFZl5WDq7fGOuLJpygeCGATA1NbJLuoavsqW3.jpg', 1, '2026-07-25 16:23:59', '2026-07-25 17:30:10'),
(42, 4, 'Cafe c/ Leche', 5.00, 25, 1, 'products/CY1yuAAcIrmITOlwns27mlfHcEoExBAM5oIP3sFT.jpg', 1, '2026-07-25 16:24:35', '2026-07-25 17:30:16'),
(43, 4, 'Te', 3.00, 25, 1, 'products/WXevlhKQlETvr52Vcd8JIDNF8U3hpCtUjYAVW7DR.jpg', 1, '2026-07-25 16:25:03', '2026-07-25 17:30:22'),
(44, 4, 'Anis', 3.00, 25, 1, 'products/y2nfAlP1yoDKpPiDi6Ri1phNC2LzjPJx96RD9xlv.jpg', 1, '2026-07-25 16:25:25', '2026-07-25 17:30:29'),
(45, 4, 'Manzanilla', 3.00, 25, 1, 'products/KvGGgyTtpwMEgqlWIdbxib7FnIRqZ0bZw80d0DF5.jpg', 1, '2026-07-25 16:25:55', '2026-07-25 17:30:36'),
(46, 5, 'Pi??a', 8.00, 25, 1, 'products/lvswlEXwqSdxntdE2NB6i25lDyQOHPGb1nm7PJ55.jpg', 1, '2026-07-25 16:27:40', '2026-07-25 17:30:47'),
(47, 5, 'Papaya', 8.00, 22, 1, 'products/BGfEfcNj3rv2SiF2tEcRDrqpdIHRRHMFxpldpuqV.jpg', 1, '2026-07-25 16:28:03', '2026-07-26 06:57:30'),
(48, 5, 'Fresa', 8.00, 25, 1, 'products/RE8WmL1iXbqPfRkYDXKrg14PJGdoWSMbYSyTZP4I.jpg', 1, '2026-07-25 16:28:31', '2026-07-25 17:31:01'),
(49, 6, 'Pisco Sour', 15.00, 25, 1, 'products/X3BU0p0kuZimHr1OsECMxPxJwPcNa9vaYGqmfcBd.jpg', 1, '2026-07-25 16:30:32', '2026-07-25 17:31:07'),
(50, 6, 'Mojito', 15.00, 25, 1, 'products/GgLIU1dRZT7jMuqiTTZd0CETULgBlHSt2vD2tYYb.jpg', 1, '2026-07-25 16:30:55', '2026-07-25 17:31:17'),
(51, 6, 'Pi??a colada', 15.00, 25, 1, 'products/9y1q40Qv46mo2qywwe8gmsFgaWO2MtPGJFvx5X3T.jpg', 1, '2026-07-25 16:31:23', '2026-07-25 17:31:43'),
(52, 6, 'Machupichu', 15.00, 25, 1, 'products/DLyeCo3819QxBfPF6BxjBR3AHRzv2VPzT5ZLBy0L.jpg', 1, '2026-07-25 16:31:50', '2026-07-25 18:25:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `name`, `price`, `order`, `created_at`, `updated_at`) VALUES
(4, 23, 'Familiar', 30.00, 0, '2026-07-25 15:30:03', '2026-07-25 15:30:03'),
(5, 23, 'Grande', 40.00, 1, '2026-07-25 15:30:03', '2026-07-25 15:30:03'),
(6, 23, 'XL', 62.00, 2, '2026-07-25 15:30:03', '2026-07-25 15:30:03'),
(7, 31, 'Familiar', 32.00, 0, '2026-07-25 15:37:09', '2026-07-25 15:37:09'),
(8, 31, 'Grande', 40.00, 1, '2026-07-25 15:37:09', '2026-07-25 15:37:09'),
(9, 31, 'XL', 62.00, 2, '2026-07-25 15:37:09', '2026-07-25 15:37:09'),
(10, 30, 'Familiar', 32.00, 0, '2026-07-25 15:38:11', '2026-07-25 15:38:11'),
(11, 30, 'Grande', 40.00, 1, '2026-07-25 15:38:11', '2026-07-25 15:38:11'),
(12, 30, 'XL', 62.00, 2, '2026-07-25 15:38:11', '2026-07-25 15:38:11'),
(16, 28, 'Familiar', 32.00, 0, '2026-07-25 15:39:33', '2026-07-25 15:39:33'),
(17, 28, 'Grande', 40.00, 1, '2026-07-25 15:39:33', '2026-07-25 15:39:33'),
(18, 28, 'XL', 62.00, 2, '2026-07-25 15:39:33', '2026-07-25 15:39:33'),
(19, 27, 'Familiar', 32.00, 0, '2026-07-25 15:39:53', '2026-07-25 15:39:53'),
(20, 27, 'Grande', 40.00, 1, '2026-07-25 15:39:53', '2026-07-25 15:39:53'),
(21, 27, 'XL', 62.00, 2, '2026-07-25 15:39:53', '2026-07-25 15:39:53'),
(22, 26, 'Familiar', 32.00, 0, '2026-07-25 15:40:12', '2026-07-25 15:40:12'),
(23, 26, 'Grande', 40.00, 1, '2026-07-25 15:40:12', '2026-07-25 15:40:12'),
(24, 26, 'XL', 62.00, 2, '2026-07-25 15:40:12', '2026-07-25 15:40:12'),
(25, 25, 'Familiar', 32.00, 0, '2026-07-25 15:40:34', '2026-07-25 15:40:34'),
(26, 25, 'Grande', 40.00, 1, '2026-07-25 15:40:34', '2026-07-25 15:40:34'),
(27, 25, 'XL', 62.00, 2, '2026-07-25 15:40:34', '2026-07-25 15:40:34'),
(28, 24, 'Familiar', 32.00, 0, '2026-07-25 15:40:51', '2026-07-25 15:40:51'),
(29, 24, 'Grande', 40.00, 1, '2026-07-25 15:40:51', '2026-07-25 15:40:51'),
(30, 24, 'XL', 62.00, 2, '2026-07-25 15:40:51', '2026-07-25 15:40:51'),
(31, 21, 'Familiar', 35.00, 0, '2026-07-25 15:42:47', '2026-07-25 15:42:47'),
(32, 21, 'Grande', 44.00, 1, '2026-07-25 15:42:47', '2026-07-25 15:42:47'),
(33, 21, 'XL', 72.00, 2, '2026-07-25 15:42:47', '2026-07-25 15:42:47'),
(34, 32, 'Familiar', 40.00, 0, '2026-07-25 15:45:46', '2026-07-25 15:45:46'),
(35, 32, 'Grande', 50.00, 1, '2026-07-25 15:45:46', '2026-07-25 15:45:46'),
(36, 32, 'XL', 72.00, 2, '2026-07-25 15:45:46', '2026-07-25 15:45:46'),
(37, 33, 'Familiar', 37.00, 0, '2026-07-25 15:49:29', '2026-07-25 15:49:29'),
(38, 33, 'Grande', 47.00, 1, '2026-07-25 15:49:29', '2026-07-25 15:49:29'),
(39, 33, 'XL', 72.00, 2, '2026-07-25 15:49:29', '2026-07-25 15:49:29'),
(40, 34, 'Familiar', 40.00, 0, '2026-07-25 15:50:59', '2026-07-25 15:50:59'),
(41, 34, 'Grande', 50.00, 1, '2026-07-25 15:50:59', '2026-07-25 15:50:59'),
(42, 34, 'XL', 77.00, 2, '2026-07-25 15:50:59', '2026-07-25 15:50:59'),
(43, 35, 'Familiar', 45.00, 0, '2026-07-25 15:52:45', '2026-07-25 15:52:45'),
(44, 35, 'Grande', 55.00, 1, '2026-07-25 15:52:45', '2026-07-25 15:52:45'),
(45, 35, 'XL', 75.00, 2, '2026-07-25 15:52:45', '2026-07-25 15:52:45'),
(46, 36, 'Familiar', 50.00, 0, '2026-07-25 15:55:06', '2026-07-25 15:55:06'),
(47, 36, 'Grande', 60.00, 1, '2026-07-25 15:55:06', '2026-07-25 15:55:06'),
(48, 36, 'XL', 85.00, 2, '2026-07-25 15:55:06', '2026-07-25 15:55:06'),
(49, 37, 'Familiar', 50.00, 0, '2026-07-25 15:55:46', '2026-07-25 15:55:46'),
(50, 37, 'Grande', 60.00, 1, '2026-07-25 15:55:46', '2026-07-25 15:55:46'),
(51, 37, 'XL', 85.00, 2, '2026-07-25 15:55:46', '2026-07-25 15:55:46'),
(52, 29, 'Familiar', 32.00, 0, '2026-07-25 16:06:26', '2026-07-25 16:06:26'),
(53, 29, 'Grande', 40.00, 1, '2026-07-25 16:06:26', '2026-07-25 16:06:26'),
(54, 29, 'XL', 62.00, 2, '2026-07-25 16:06:26', '2026-07-25 16:06:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-07-24 05:24:07', '2026-07-24 05:24:07'),
(2, 'cajero', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(3, 'cocinero', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08'),
(4, 'mesero', 'web', '2026-07-24 05:24:08', '2026-07-24 05:24:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(15, 4),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(20, 1),
(20, 4),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_code` varchar(255) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_register_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tip` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `change` decimal(10,2) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `sale_code`, `order_id`, `cash_register_id`, `subtotal`, `tax`, `tip`, `total`, `paid_amount`, `change`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 'VT-001', 2, 2, 78.00, 0.00, 0.00, 78.00, 80.00, 2.00, '2026-07-25 00:05:41', '2026-07-25 00:05:41', '2026-07-26 06:04:55'),
(2, 'VT-002', 1, 2, 100.00, 0.00, 0.00, 100.00, 100.00, 0.00, '2026-07-25 00:29:57', '2026-07-25 00:29:57', '2026-07-26 06:04:55'),
(3, 'VT-003', 5, 3, 16.00, 0.00, 0.00, 16.00, 20.00, 4.00, '2026-07-25 06:02:52', '2026-07-25 06:02:52', '2026-07-26 06:04:56'),
(4, 'VT-004', 5, 3, 38.00, 0.00, 0.00, 38.00, 40.00, 2.00, '2026-07-25 06:03:29', '2026-07-25 06:03:29', '2026-07-26 06:04:56'),
(5, 'VT-005', 3, 3, 43.00, 0.00, 0.00, 43.00, 45.00, 2.00, '2026-07-25 06:05:07', '2026-07-25 06:05:07', '2026-07-26 06:04:56'),
(6, 'VT-006', 6, 3, 315.00, 0.00, 0.00, 315.00, 350.00, 35.00, '2026-07-25 18:33:58', '2026-07-25 18:33:58', '2026-07-26 06:04:56'),
(7, 'VT-007', 7, 3, 8.00, 0.00, 0.00, 8.00, 10.00, 2.00, '2026-07-25 18:45:43', '2026-07-25 18:45:43', '2026-07-26 06:04:56'),
(8, 'VT-008', 7, 3, 147.00, 0.00, 0.00, 147.00, 150.00, 3.00, '2026-07-25 18:46:39', '2026-07-25 18:46:39', '2026-07-26 06:04:56'),
(9, 'VT-009', 8, 3, 50.00, 0.00, 0.00, 50.00, 50.00, 0.00, '2026-07-25 19:14:44', '2026-07-25 19:14:44', '2026-07-26 06:04:56'),
(10, 'VT-010', 8, 3, 8.00, 0.00, 0.00, 8.00, 10.00, 2.00, '2026-07-25 19:20:04', '2026-07-25 19:20:04', '2026-07-26 06:04:56'),
(11, 'VT-011', 8, 3, 48.00, 0.00, 0.00, 48.00, 48.00, 0.00, '2026-07-25 19:20:38', '2026-07-25 19:20:38', '2026-07-26 06:04:56'),
(12, 'VT-012', 9, 3, 72.00, 0.00, 0.00, 72.00, 80.00, 8.00, '2026-07-25 19:35:14', '2026-07-25 19:35:14', '2026-07-26 06:04:56'),
(13, 'VT-013', 9, 3, 80.00, 0.00, 0.00, 80.00, 80.00, 0.00, '2026-07-25 19:36:30', '2026-07-25 19:36:30', '2026-07-26 06:04:56'),
(14, 'VT-014', 11, 3, 45.00, 0.00, 0.00, 45.00, 45.00, 0.00, '2026-07-25 23:28:48', '2026-07-25 23:28:48', '2026-07-26 06:04:56'),
(15, 'VT-015', 10, 3, 6.00, 0.00, 0.00, 6.00, 10.00, 4.00, '2026-07-25 23:29:59', '2026-07-25 23:29:59', '2026-07-26 06:04:56'),
(16, 'VT-016', 12, 4, 53.00, 0.00, 0.00, 53.00, 53.00, 0.00, '2026-07-26 05:16:57', '2026-07-26 05:16:57', '2026-07-26 06:04:56'),
(17, 'VT-017', 13, 4, 72.00, 0.00, 0.00, 72.00, 80.00, 8.00, '2026-07-26 05:24:57', '2026-07-26 05:24:57', '2026-07-26 06:04:56'),
(18, 'VT-018', 14, 4, 62.00, 0.00, 10.00, 72.00, 80.00, 8.00, '2026-07-26 06:26:20', '2026-07-26 06:26:20', '2026-07-26 06:26:20'),
(19, 'VT-019', 15, 4, 56.00, 0.00, 0.00, 56.00, 60.00, 4.00, '2026-07-27 03:47:23', '2026-07-27 03:47:23', '2026-07-27 03:47:23'),
(20, 'VT-020', 18, 4, 36.00, 0.00, 0.00, 36.00, 40.00, 4.00, '2026-07-31 04:12:26', '2026-07-31 04:12:26', '2026-07-31 04:12:26'),
(21, 'VT-021', 19, 4, 37.00, 0.00, 0.00, 37.00, 40.00, 3.00, '2026-07-31 21:10:16', '2026-07-31 21:10:16', '2026-07-31 21:10:16'),
(22, 'VT-022', 21, 4, 32.00, 0.00, 0.00, 32.00, 40.00, 8.00, '2026-07-31 21:16:06', '2026-07-31 21:16:07', '2026-07-31 21:16:07'),
(23, 'VT-023', 22, 5, 52.00, 0.00, 0.00, 52.00, 60.00, 8.00, '2026-08-23 01:16:59', '2026-08-23 01:16:59', '2026-08-23 01:16:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `product_id`, `product_size_id`, `quantity`, `price`, `tax`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 20, NULL, 2, 35.00, 0.00, 70.00, NULL, '2026-07-25 00:05:41', '2026-07-25 00:05:41'),
(2, 1, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 00:05:41', '2026-07-25 00:05:41'),
(3, 2, 20, NULL, 2, 35.00, 0.00, 70.00, NULL, '2026-07-25 00:29:57', '2026-07-25 00:29:57'),
(4, 2, 21, NULL, 1, 30.00, 0.00, 30.00, NULL, '2026-07-25 00:29:57', '2026-07-25 00:29:57'),
(5, 3, 22, NULL, 2, 8.00, 0.00, 16.00, NULL, '2026-07-25 06:02:52', '2026-07-25 06:02:52'),
(6, 4, 21, NULL, 1, 30.00, 0.00, 30.00, NULL, '2026-07-25 06:03:29', '2026-07-25 06:03:29'),
(7, 4, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 06:03:29', '2026-07-25 06:03:29'),
(8, 5, 20, NULL, 1, 35.00, 0.00, 35.00, NULL, '2026-07-25 06:05:07', '2026-07-25 06:05:07'),
(9, 5, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 06:05:07', '2026-07-25 06:05:07'),
(10, 6, 21, NULL, 1, 44.00, 0.00, 44.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(11, 6, 23, NULL, 1, 62.00, 0.00, 62.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(12, 6, 47, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(13, 6, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(14, 6, 32, NULL, 1, 40.00, 0.00, 40.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(15, 6, 52, NULL, 1, 15.00, 0.00, 15.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(16, 6, 21, NULL, 1, 44.00, 0.00, 44.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(17, 6, 27, NULL, 1, 32.00, 0.00, 32.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(18, 6, 26, NULL, 1, 62.00, 0.00, 62.00, NULL, '2026-07-25 18:33:58', '2026-07-25 18:33:58'),
(19, 7, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 18:45:43', '2026-07-25 18:45:43'),
(20, 8, 27, NULL, 1, 62.00, 0.00, 62.00, NULL, '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(21, 8, 15, NULL, 1, 4.00, 0.00, 4.00, NULL, '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(22, 8, 23, NULL, 1, 30.00, 0.00, 30.00, NULL, '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(23, 8, 25, NULL, 1, 40.00, 0.00, 40.00, NULL, '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(24, 8, 13, NULL, 1, 6.00, 0.00, 6.00, NULL, '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(25, 8, 14, NULL, 1, 5.00, 0.00, 5.00, NULL, '2026-07-25 18:46:39', '2026-07-25 18:46:39'),
(26, 9, 13, NULL, 1, 6.00, 0.00, 6.00, NULL, '2026-07-25 19:14:44', '2026-07-25 19:14:44'),
(27, 9, 21, NULL, 1, 44.00, 0.00, 44.00, NULL, '2026-07-25 19:14:44', '2026-07-25 19:14:44'),
(28, 10, 47, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 19:20:04', '2026-07-25 19:20:04'),
(29, 11, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 19:20:38', '2026-07-25 19:20:38'),
(30, 11, 29, NULL, 1, 40.00, 0.00, 40.00, NULL, '2026-07-25 19:20:38', '2026-07-25 19:20:38'),
(31, 12, 21, 33, 1, 72.00, 0.00, 72.00, NULL, '2026-07-25 19:35:14', '2026-07-25 19:35:14'),
(32, 13, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-25 19:36:30', '2026-07-25 19:36:30'),
(33, 13, 27, 19, 1, 32.00, 0.00, 32.00, NULL, '2026-07-25 19:36:30', '2026-07-25 19:36:30'),
(34, 13, 27, 20, 1, 40.00, 0.00, 40.00, NULL, '2026-07-25 19:36:30', '2026-07-25 19:36:30'),
(35, 14, 14, NULL, 1, 5.00, 0.00, 5.00, NULL, '2026-07-25 23:28:48', '2026-07-25 23:28:48'),
(36, 14, 23, 5, 1, 40.00, 0.00, 40.00, NULL, '2026-07-25 23:28:48', '2026-07-25 23:28:48'),
(37, 15, 13, NULL, 1, 6.00, 0.00, 6.00, NULL, '2026-07-25 23:29:59', '2026-07-25 23:29:59'),
(38, 16, 18, NULL, 1, 5.00, 0.00, 5.00, NULL, '2026-07-26 05:16:57', '2026-07-26 05:16:57'),
(39, 16, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-07-26 05:16:57', '2026-07-26 05:16:57'),
(40, 16, 23, 5, 1, 40.00, 0.00, 40.00, NULL, '2026-07-26 05:16:57', '2026-07-26 05:16:57'),
(41, 17, 21, 33, 1, 72.00, 0.00, 72.00, NULL, '2026-07-26 05:24:57', '2026-07-26 05:24:57'),
(42, 18, 26, 24, 1, 62.00, 0.00, 62.00, NULL, '2026-07-26 06:26:20', '2026-07-26 06:26:20'),
(43, 19, 47, NULL, 2, 8.00, 0.00, 16.00, NULL, '2026-07-27 03:47:23', '2026-07-27 03:47:23'),
(44, 19, 28, 17, 1, 40.00, 0.00, 40.00, NULL, '2026-07-27 03:47:23', '2026-07-27 03:47:23'),
(45, 20, 13, NULL, 1, 6.00, 0.00, 6.00, 'Helada quiere el cliente', '2026-07-31 04:12:26', '2026-07-31 04:12:26'),
(46, 20, 23, 4, 1, 30.00, 0.00, 30.00, 'lo quiere grande,', '2026-07-31 04:12:26', '2026-07-31 04:12:26'),
(47, 21, 25, 25, 1, 32.00, 0.00, 32.00, NULL, '2026-07-31 21:10:16', '2026-07-31 21:10:16'),
(48, 21, 39, NULL, 1, 5.00, 0.00, 5.00, NULL, '2026-07-31 21:10:16', '2026-07-31 21:10:16'),
(49, 22, 26, 22, 1, 32.00, 0.00, 32.00, NULL, '2026-07-31 21:16:07', '2026-07-31 21:16:07'),
(50, 23, 21, 32, 1, 44.00, 0.00, 44.00, NULL, '2026-08-23 01:16:59', '2026-08-23 01:16:59'),
(51, 23, 22, NULL, 1, 8.00, 0.00, 8.00, NULL, '2026-08-23 01:16:59', '2026-08-23 01:16:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
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
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aM6nlP8mKE9z1FcvrYRXjkHthYxoBLp0gmtARZrK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTGc1S0hoS29PRXBFd0h6djZJN3B5RXhGZmU0UDRCcm5yWWwxUlNRYyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAxL29yZGVycy9jaGVmIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS91c2VycyI7czo1OiJyb3V0ZSI7czoxMToidXNlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1785537483),
('eDAjAj4JQVL54SgqXcPh6U24qP2RGDnKtPR4F6Rw', 6, '10.219.196.174', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMEVZWjh1N29aSUU0SEFtdEV0UUtJQmE4WG42MnVOaEg1SURjZ3FpbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMC4yMTkuMTk2LjEzOjgwMDEvcHJvZHVjdHMiO3M6NToicm91dGUiO3M6MTQ6InByb2R1Y3RzLmluZGV4Ijt9czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEwLjIxOS4xOTYuMTM6ODAwMS9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1785532771),
('hrZSKba6N2Kmqz5ZVe5TFLzRfT84YloNs7mjTrNh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.134.0 Chrome/148.0.7778.280 Electron/42.8.1 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFBrd3BVVlJPVzJoUUV2TGpYMkRnS2QwWVY5U3B6cDNSVXRSQ20yMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787447178),
('J6PqAP6fCjVkRfaZ0U0Zl32ZXEzirIe9YeZIhw0F', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiempQd2d4OVFDSkUzN0dGNWdYUW1PZnN6NmxMQmxFcEpSNGsxTW90bSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYm94ZXMvZXlKcGRpSTZJbnByUzA1RVJFdEpZa05tTUd4UmFERXJkR28zU0djOVBTSXNJblpoYkhWbElqb2lVV2NyVVdabVYxRkhSMFoxYjNVd016TmliMjVxUVQwOUlpd2liV0ZqSWpvaU5ERXlPVGRtT0dVMk9Ea3lObVZrTW1WaVpHUmlOak0zTmpJMFptSXlNR0l5TXpjeU5USTFaVFl5WWpBeE5HWTFPR0l4TURZNVl6WXhNak5rT0dWa1pDSXNJblJoWnlJNklpSjkiO3M6NToicm91dGUiO3M6MTU6ImJveGVzLm1vdmVtZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1787447966),
('L2SBWxX6dF65qck2sRnq2aM6QdRZ0HSCkwLSikJy', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiS1M5QWx6bEluM2tpbGlmakZld05pR2RoS0owUUE5Q0x4YjkyWUF5YiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787458347),
('OQb3Gt4EYkPdARxNwft4t8N3L9sTkw1P95QxI8hv', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidEZ3bXNtWlpzMGUxMzFGZGdvZjNoakNRRk5BV1hackg2d3hYRVY5RCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9wcm9kdWN0cyI7czo1OiJyb3V0ZSI7czoxNDoicHJvZHVjdHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1785537514),
('rvNP78Tx69JP1c5dy0kuP25PGAmejW01SA1SSrVn', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0kySTlqdWpaSVlOM09ySmlQbHFtOVl1TWFIU3E1OW5KRDNrbWVYaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvcmVzdGF1cmFudGUvcHVibGljL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787447141),
('SiuH5YBKkxnzIRnL3bLz0NwaPtDHNwIkLe9ZYUiy', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic1lqa0NIMm5FRFhxYTgwbmxwRlY4M0ZqVTRIcXhjODZZZjVrZmNOMiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAxL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvc2FsZXMiO3M6NToicm91dGUiO3M6MTE6InNhbGVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1785548705);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL DEFAULT 'HelpDesk',
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `currency_simbol` varchar(255) NOT NULL DEFAULT 'S/',
  `logo_path` varchar(255) DEFAULT NULL,
  `favicon_path` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'UTC',
  `social_networks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_networks`)),
  `direct_printing` tinyint(1) NOT NULL DEFAULT 0,
  `separate_orders` tinyint(1) NOT NULL DEFAULT 0,
  `printer_name` varchar(255) DEFAULT NULL COMMENT 'Impresora de Caja / Barra / Bebidas',
  `kitchen_printer_name` varchar(255) DEFAULT NULL COMMENT 'Impresora de Cocina',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_email`, `company_phone`, `company_address`, `tax_id`, `currency_simbol`, `logo_path`, `favicon_path`, `timezone`, `social_networks`, `direct_printing`, `separate_orders`, `printer_name`, `kitchen_printer_name`, `created_at`, `updated_at`) VALUES
(1, 'Pizzeria Zuñiga', 'PizzeriaZuniga@gmail.com', '+51 901082031', 'Jr. Miraflores', 'RUC 20739960342', 'S/', 'branding/COn4aMOZQAQyhCfGqgvVCpOEJ31AwfXGeaWWya2n.jpg', 'branding/CgEfm5ULAcHBBAp8Rzpum5iMekB25KfspXfJgsUQ.png', 'America/Lima', '{\"facebook\":\"https:\\/\\/facebook.com\\/ceviche\",\"instagram\":\"https:\\/\\/instagram.com\\/ceviche\",\"linkedin\":\"https:\\/\\/linkedin.com\\/company\\/ceviche\",\"whatsapp\":\"https:\\/\\/wa.me\\/51987654321\"}', 0, 1, NULL, NULL, '2026-07-24 05:24:10', '2026-07-31 03:54:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `x_pos` int(11) DEFAULT NULL,
  `y_pos` int(11) DEFAULT NULL,
  `status` enum('libre','ocupada','reservada') NOT NULL DEFAULT 'libre',
  `color` varchar(20) NOT NULL DEFAULT '#f97316',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tables`
--

INSERT INTO `tables` (`id`, `name`, `capacity`, `x_pos`, `y_pos`, `status`, `color`, `created_at`, `updated_at`) VALUES
(1, 'MESA 1', 4, -40, 4, 'libre', '#f97316', '2026-07-24 00:31:42', '2026-07-31 21:06:32'),
(2, 'MESA 2', 4, -20, 416, 'libre', '#f97316', '2026-07-24 00:32:04', '2026-07-31 21:06:26'),
(3, 'MESA 3', 4, 372, 4, 'libre', '#f97316', '2026-07-24 00:32:26', '2026-07-31 21:06:54'),
(4, 'MESA 4', 4, 598, 4, 'libre', '#f97316', '2026-07-24 00:32:42', '2026-07-31 21:06:53'),
(5, 'MESA 5', 4, 516, 354, 'libre', '#f97316', '2026-07-24 00:33:03', '2026-07-31 21:10:16'),
(7, 'DELIVERY', 1, 992, 21, 'libre', '#8b5cf6', '2026-07-24 00:34:35', '2026-07-31 20:53:41'),
(8, 'PEDIDO', 1, 992, 392, 'libre', '#10b981', '2026-07-25 17:16:12', '2026-08-23 01:16:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `document_number` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `type` enum('user','client') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `document_number`, `phone`, `type`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrador', 'admin@gmail.com', NULL, '$2y$12$0Thz8N6lTypCQflqFEJWN.3VvJkxC2S4zA1cQwyywuW7fZVqbZ6qu', NULL, NULL, 'user', NULL, '2026-07-24 05:24:09', '2026-07-24 05:24:09', NULL),
(2, 'Sarai Carbajal', 'saraicarbajal@gmail.com', NULL, '$2y$12$9/OrXzsZaLxocXBdI4o7Oe6QRhw9emQXbmDEXq2m53KPhdbz3WfGe', NULL, NULL, 'user', NULL, '2026-07-24 05:24:09', '2026-07-31 04:03:19', NULL),
(3, 'cocinero', 'cocinero@gmail.com', NULL, '$2y$12$JFCCkSVYnQCPjR5xrpC4A.Oo2lhpyak7r8MvdZIzWMxgdLPOeAOIK', NULL, NULL, 'user', NULL, '2026-07-24 05:24:10', '2026-07-31 22:38:03', NULL),
(4, 'Cajero', 'cajero@gmail.com', NULL, '$2y$12$83QcyWf/e86E4OU2FsJwHuqquuMPxbDtb9ftB26M2MsafB8UqBCCO', NULL, NULL, 'user', NULL, '2026-07-24 05:24:10', '2026-07-31 22:34:21', NULL),
(5, 'Eduardo', 'eduardoapsti20@gmail.com', NULL, '$2y$12$RS8LOjXIWlUpgxGtgZIzretMe4pNRXUr6eLStPaulZmWs/ZxXA4lS', NULL, NULL, 'user', NULL, '2026-07-25 00:35:34', '2026-07-25 00:35:34', NULL),
(6, 'Keni', 'Keni@gmail.com', NULL, '$2y$12$nLr1.HjUQWCGUhS/ZcnZ8.iB93gefY3n3EHlK2RG2woDlkIoqlC8C', NULL, NULL, 'user', NULL, '2026-07-25 05:56:11', '2026-07-26 05:22:55', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_registers_opened_by_foreign` (`opened_by`),
  ADD KEY `cash_registers_closed_by_foreign` (`closed_by`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_cash_register_id_foreign` (`cash_register_id`),
  ADD KEY `expenses_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_table_id_foreign` (`table_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`),
  ADD KEY `order_details_product_size_id_foreign` (`product_size_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_sale_id_foreign` (`sale_id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sizes_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_sale_code_unique` (`sale_code`),
  ADD KEY `sales_order_id_foreign` (`order_id`),
  ADD KEY `sales_cash_register_id_foreign` (`cash_register_id`);

--
-- Indices de la tabla `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_details_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_details_product_id_foreign` (`product_id`),
  ADD KEY `sale_details_product_size_id_foreign` (`product_size_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cash_registers`
--
ALTER TABLE `cash_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD CONSTRAINT `cash_registers_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cash_registers_opened_by_foreign` FOREIGN KEY (`opened_by`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_cash_register_id_foreign` FOREIGN KEY (`cash_register_id`) REFERENCES `cash_registers` (`id`),
  ADD CONSTRAINT `expenses_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_size_id_foreign` FOREIGN KEY (`product_size_id`) REFERENCES `product_sizes` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payments_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_cash_register_id_foreign` FOREIGN KEY (`cash_register_id`) REFERENCES `cash_registers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sale_details_product_size_id_foreign` FOREIGN KEY (`product_size_id`) REFERENCES `product_sizes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
