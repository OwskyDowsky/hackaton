-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2025 a las 00:00:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `josedbcoreui`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Resistencias', 'Resistencias de todo tipo seramicas', '2024-11-30 07:27:24', '2024-11-30 07:27:24'),
(2, 'Leds', 'leds de todo color', '2024-11-30 07:53:44', '2024-11-30 07:53:44'),
(3, 'Protoboards', 'Protoboards de tamaños y materiales', '2024-11-30 21:05:57', '2024-11-30 21:05:57'),
(4, 'Microcontroladores', 'Arduino, Arduino nano, ESP32, NodeMCU, ESP8266', '2024-11-30 21:08:08', '2024-11-30 21:08:08'),
(5, 'cables', 'cables conductores de todo tipo', '2024-11-30 22:04:24', '2024-11-30 22:04:24'),
(6, 'Baterias', 'baterias y pilas', '2024-12-03 09:36:29', '2024-12-03 09:36:29'),
(7, 'Motores', 'motores', '2024-12-03 09:37:34', '2024-12-03 09:37:34');

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
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `imageable_id` int(11) NOT NULL,
  `imageable_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`id`, `url`, `imageable_id`, `imageable_type`, `created_at`, `updated_at`) VALUES
(3, 'productos/674ab4e4835dd.jpg', 3, 'App\\Models\\Productos', '2024-11-30 10:47:00', '2024-11-30 10:47:00'),
(4, 'productos/674ab5d98bc50.jpg', 4, 'App\\Models\\Productos', '2024-11-30 10:51:05', '2024-11-30 10:51:05'),
(5, 'productos/674ab992cbfb6.jpg', 1, 'App\\Models\\Productos', '2024-11-30 11:06:58', '2024-11-30 11:06:58'),
(6, 'categorias/674b45f5e4c73.jpg', 3, 'App\\Models\\Categorias', '2024-11-30 21:05:58', '2024-11-30 21:05:58'),
(7, 'categorias/674b4678c0983.png', 4, 'App\\Models\\Categorias', '2024-11-30 21:08:08', '2024-11-30 21:08:08'),
(8, 'cateegorias/674b50e8a11b8.jpg', 1, 'App\\Models\\Categorias', '2024-11-30 21:52:40', '2024-11-30 21:52:40'),
(9, 'cateegorias/674b513371784.jpg', 2, 'App\\Models\\Categorias', '2024-11-30 21:53:55', '2024-11-30 21:53:55'),
(10, 'productos/674b52121cabe.jpg', 5, 'App\\Models\\Productos', '2024-11-30 21:57:38', '2024-11-30 21:57:38'),
(11, 'productos/674b5299f23ee.jpg', 6, 'App\\Models\\Productos', '2024-11-30 21:59:54', '2024-11-30 21:59:54'),
(12, 'productos/674b52b434264.jpg', 7, 'App\\Models\\Productos', '2024-11-30 22:00:20', '2024-11-30 22:00:20'),
(13, 'categorias/674b53a879843.jpg', 5, 'App\\Models\\Categorias', '2024-11-30 22:04:24', '2024-11-30 22:04:24'),
(14, 'productos/674b53d415c70.jpg', 8, 'App\\Models\\Productos', '2024-11-30 22:05:08', '2024-11-30 22:05:08'),
(15, 'paquetes/674e836cf398a.png', 5, 'App\\Models\\Paquetes', '2024-12-03 08:05:01', '2024-12-03 08:05:01'),
(16, 'categorias/674e98dd71214.jpg', 6, 'App\\Models\\Categorias', '2024-12-03 09:36:29', '2024-12-03 09:36:29'),
(17, 'productos/674e98fdeedf5.jpg', 9, 'App\\Models\\Productos', '2024-12-03 09:37:01', '2024-12-03 09:37:01'),
(18, 'categorias/674e991ed9aea.jpg', 7, 'App\\Models\\Categorias', '2024-12-03 09:37:34', '2024-12-03 09:37:34'),
(19, 'productos/674e9944448f7.jpg', 10, 'App\\Models\\Productos', '2024-12-03 09:38:12', '2024-12-03 09:38:12'),
(20, 'productos/674e996922bcf.jpg', 11, 'App\\Models\\Productos', '2024-12-03 09:38:49', '2024-12-03 09:38:49'),
(21, 'productos/674e9a252d2c9.jpg', 12, 'App\\Models\\Productos', '2024-12-03 09:41:57', '2024-12-03 09:41:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_paquetes`
--

CREATE TABLE `items_paquetes` (
  `id` int(11) NOT NULL,
  `productos_id` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `paquetes_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `items_paquetes`
--

INSERT INTO `items_paquetes` (`id`, `productos_id`, `cantidad`, `precio`, `paquetes_id`, `created_at`, `updated_at`) VALUES
(6, '1', 10, 1.00, 5, '2024-12-03 08:05:01', '2024-12-03 08:05:01'),
(7, '4', 10, 1.00, 5, '2024-12-03 08:05:01', '2024-12-03 08:05:01'),
(8, '5', 1, 25.00, 5, '2024-12-03 08:05:01', '2024-12-03 08:05:01'),
(9, '8', 10, 5.00, 5, '2024-12-03 08:05:01', '2024-12-03 08:05:01'),
(10, '6', 1, 125.00, 6, '2024-12-03 08:08:34', '2024-12-03 08:08:34'),
(11, '7', 1, 60.00, 6, '2024-12-03 08:08:34', '2024-12-03 08:08:34'),
(12, '6', 1, 125.00, 7, '2024-12-03 08:33:38', '2024-12-03 08:33:38'),
(13, '7', 1, 60.00, 7, '2024-12-03 08:33:38', '2024-12-03 08:33:38'),
(14, '8', 5, 5.00, 7, '2024-12-03 08:33:38', '2024-12-03 08:33:38'),
(15, '6', 1, 125.00, 8, '2024-12-03 08:33:39', '2024-12-03 08:33:39'),
(16, '7', 1, 60.00, 8, '2024-12-03 08:33:39', '2024-12-03 08:33:39'),
(17, '8', 5, 5.00, 8, '2024-12-03 08:33:39', '2024-12-03 08:33:39');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_02_17_034249_create_permission_tables', 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cant_productos` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `nombre`, `descripcion`, `precio`, `cant_productos`, `created_at`, `updated_at`) VALUES
(5, 'Paquete inicial', 'paquete inicial para estudiantes con kits basicos', 100.00, 4, '2024-12-03 08:05:00', '2024-12-03 08:05:00'),
(6, 'Paquete microcontroladores', 'microcontroladores', 210.00, 2, '2024-12-03 08:08:34', '2024-12-03 08:08:34'),
(7, 'paquete 2', 'desc', 300.00, 3, '2024-12-03 08:33:38', '2024-12-03 08:33:38'),
(8, 'paquete 2', 'desc', 300.00, 3, '2024-12-03 08:33:39', '2024-12-03 08:33:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `categoria_id` int(11) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `stock`, `categoria_id`, `tipo`, `precio`, `created_at`, `updated_at`) VALUES
(1, 'Resistencia 220', 'resistencia seramida', 10, 1, 'resistencia para componentes', 1.00, '2024-11-30 08:01:10', '2024-11-30 08:01:10'),
(3, 'Led Rojo', 'led rojo pequeno', 10, 2, 'rojo', 1.00, '2024-11-30 09:41:02', '2024-11-30 09:41:02'),
(4, 'Led amarillo', 'amarillo', 11, 2, 'amarillo', 1.00, '2024-11-30 09:41:36', '2024-11-30 10:51:05'),
(5, 'Protoboard(plastico)', 'protoboard de plastico', 20, 3, 'plastico', 25.00, '2024-11-30 21:57:38', '2024-11-30 21:57:38'),
(6, 'Arduino Mega', 'Arduino mega', 2, 4, 'metal', 125.00, '2024-11-30 21:59:53', '2024-11-30 21:59:53'),
(7, 'Esp8266', 'nodemcu', 2, 4, 'metal', 60.00, '2024-11-30 22:00:20', '2024-11-30 22:00:20'),
(8, 'jumpers hembra macho', 'hembra macho paquete de 5', 100, 5, 'conductor', 5.00, '2024-11-30 22:05:08', '2024-11-30 22:05:08'),
(9, 'Bateria duracell', 'duracell', 30, 6, 'bateria de 2 polos', 12.00, '2024-12-03 09:37:01', '2024-12-03 09:37:01'),
(10, 'Motor paso a paso', 'motor paso a paso con cable', 2, 7, 'motor viejo', 50.00, '2024-12-03 09:38:12', '2024-12-03 09:38:12'),
(11, 'Servo motor', 'servo motor color azul de 20kg', 10, 7, 'motor pequeno', 48.00, '2024-12-03 09:38:49', '2024-12-03 09:38:49'),
(12, 'Capacitor', 'capacitor de 500 uh', 20, 2, 'capacitor de 2 pines', 2.00, '2024-12-03 09:41:57', '2024-12-03 09:41:57');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'img/default-avatar.jpg',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `username`, `email`, `mobile`, `gender`, `date_of_birth`, `email_verified_at`, `password`, `avatar`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'Super', 'Admin', '100001', 'super@admin.com', '+1-918-730-8429', 'Other', '1985-12-23', '2024-10-18 01:53:08', '$2y$10$rZQ.D/Ko/MQJAaRw/rHnN.ub4U.ki95E/S5X/3Dg1OlO7J47UsC4W', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:53:08', '2024-10-18 01:53:08', NULL),
(2, 'Admin Istrator', 'Admin', 'Istrator', '100002', 'admin@admin.com', '+1.580.215.7424', 'Male', '1979-10-23', '2024-10-18 01:53:08', '$2y$10$A8s3zbHSK3JfxuN4J6ZKwuvCBM/MjO9du1yi/mKDC3C7/ehIVaGSy', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:53:08', '2024-10-18 01:53:08', NULL),
(3, 'Manager', 'Manager', 'User User', '100003', 'manager@manager.com', '1-980-366-8395', 'Female', '1972-10-29', '2024-10-18 01:53:08', '$2y$10$x0gkYyhnAQqaIunTGzCJIO7P/phenztZaLzJXYU1jPXcQcWQRnSA.', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:53:08', '2024-10-18 01:53:08', NULL),
(4, 'Executive User', 'Executive', 'User', '100004', 'executive@executive.com', '(331) 725-5337', 'Female', '2001-06-08', '2024-10-18 01:53:08', '$2y$10$njD5IPD8XFToV0hibuhax.dT6R6qVoTiJ0o0O8ItcUJ8aA3epPCX.', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:53:08', '2024-10-18 01:53:08', NULL),
(5, 'General User', 'General', 'User', '100005', 'user@user.com', '+1-279-816-0257', 'Other', '1976-11-15', '2024-10-18 01:53:08', '$2y$10$CTuc/aZ8OUhfqHpAYhT02eiZxkRvVWvAHv.aUPCaKZVZdqBNL1vF.', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:53:08', '2024-10-18 01:53:08', NULL),
(6, 'Owen Terceros', 'Owen', 'Terceros', '100006', 'owen@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$EnIMPoIpCclp1aYS9YCcR.EWes05UgZegoZ1BP9OmVSlw3T.bqeJG', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:55:51', '2024-10-18 01:58:49', '2024-10-18 01:58:49'),
(7, 'Oscar Terceros', 'Oscar', 'Terceros', '100007', 'oscar@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$i7/XXQx7kohLQqv/CApFmOj.p39RaPamYbSg5IGdJLHnPUyNRAn8q', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:56:46', '2024-10-18 01:58:55', '2024-10-18 01:58:55'),
(8, 'Owen Terceros', 'Owen', 'Terceros', '100008', 'owenoscar@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$x2Vw.Q8HQ911tVg7QqwyIOAEpB0b1fACntt5kXO5YeTZpV2sZLDQK', 'img/default-avatar.jpg', 1, NULL, '2024-10-18 01:57:54', '2024-10-18 01:57:54', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `items_paquetes`
--
ALTER TABLE `items_paquetes`
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
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

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
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `items_paquetes`
--
ALTER TABLE `items_paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
