-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 23:25:18
-- Versión del servidor: 5.7.39
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yonkemovil`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_autos`
--

CREATE TABLE `catalogo_autos` (
  `id` int(10) UNSIGNED NOT NULL,
  `anio` smallint(5) UNSIGNED NOT NULL,
  `marca` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `catalogo_autos`
--

INSERT INTO `catalogo_autos` (`id`, `anio`, `marca`, `modelo`) VALUES
(2, 2018, 'Nissan', 'Sentra'),
(1, 2018, 'Nissan', 'Versa'),
(3, 2019, 'Toyota', 'Corolla'),
(4, 2019, 'Toyota', 'Yaris'),
(6, 2020, 'Honda', 'Accord'),
(5, 2020, 'Honda', 'Civic'),
(7, 2021, 'Chevrolet', 'Aveo'),
(8, 2021, 'Chevrolet', 'Spark'),
(10, 2022, 'Ford', 'F-150'),
(9, 2022, 'Ford', 'Ranger'),
(12, 2023, 'Kia', 'Forte'),
(11, 2023, 'Kia', 'Rio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(10) UNSIGNED NOT NULL,
  `permiso` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `permiso`, `slug`, `descripcion`, `estatus`) VALUES
(1, 'Ver panel admin', 'ver_panel_admin', 'Acceso al dashboard administrativo', 1),
(2, 'Ver panel cliente', 'ver_panel_cliente', 'Acceso al panel de cliente', 1),
(3, 'Ver usuarios', 'ver_usuarios', 'Acceso al modulo de usuarios', 1),
(4, 'Ver yonkes', 'ver_yonkes', 'Acceso al modulo de yonkes', 1),
(5, 'Gestionar autos cliente', 'gestionar_autos_cliente', 'Alta y baja de autos del cliente', 1),
(6, 'Ver inventario', 'ver_mi_inventario', 'Alta y baja de autos en el invetario', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_roles`
--

CREATE TABLE `permisos_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `permiso_id` int(10) UNSIGNED NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos_roles`
--

INSERT INTO `permisos_roles` (`id`, `rol_id`, `permiso_id`, `activo`) VALUES
(1, 2, 1, 1),
(2, 2, 3, 1),
(3, 2, 4, 1),
(4, 2, 5, 1),
(5, 1, 2, 1),
(6, 1, 5, 1),
(7, 2, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_usuarios`
--

CREATE TABLE `permisos_usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `permiso_id` int(10) UNSIGNED NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `estatus`) VALUES
(1, 'cliente', 1),
(2, 'admin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `usuario` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puesto` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_id` int(10) UNSIGNED NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1',
  `foto_perfil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `usuario`, `contrasena`, `correo`, `puesto`, `rol_id`, `estatus`, `foto_perfil`, `fecha_ingreso`) VALUES
(1, 'Admin', 'YonkeMovil', 'admin_yonkemovil', '$2y$10$y5YcC.bckFQWY7bGyaFo1Oi10wftKBWGLhgE15k4YEpewXSZyknyC', 'admin@yonkemovil.local', 'Administrador', 2, 1, NULL, '2026-02-21 09:34:37'),
(2, 'Cliente', 'Demo', 'cliente', '$2y$10$yn5z4fn.QYYe.VhP.nHG5eb7Mc9ZIMcpXf8ZRFkVW14s0D9OiWeIq', 'cliente@yonkemovil.local', 'Propietario de yonke', 1, 1, NULL, '2026-02-21 09:34:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_fotos`
--

CREATE TABLE `vehiculos_fotos` (
  `id` int(10) UNSIGNED NOT NULL,
  `vehiculo_id` int(10) UNSIGNED NOT NULL,
  `foto_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vehiculos_fotos`
--

INSERT INTO `vehiculos_fotos` (`id`, `vehiculo_id`, `foto_path`, `orden`, `fecha_registro`) VALUES
(3, 2, 'frontend/recursos/img/autos/auto_20260221_193436_d266ef52.jpg', 0, '2026-02-21 13:34:36'),
(4, 2, 'frontend/recursos/img/autos/auto_20260221_193436_18f52d69.jpg', 1, '2026-02-21 13:34:36'),
(5, 3, 'frontend/recursos/img/autos/auto_20260221_193510_17bfc6cb.jpg', 0, '2026-02-21 13:35:10'),
(6, 3, 'frontend/recursos/img/autos/auto_20260221_193510_eddf205b.jpg', 1, '2026-02-21 13:35:10'),
(7, 4, 'frontend/recursos/img/autos/auto_20260221_193603_dc654426.webp', 0, '2026-02-21 13:36:03'),
(8, 4, 'frontend/recursos/img/autos/auto_20260221_193603_c7de8a67.webp', 1, '2026-02-21 13:36:03'),
(9, 5, 'frontend/recursos/img/autos/auto_20260221_193657_d93dfa8b.webp', 0, '2026-02-21 13:36:57'),
(10, 5, 'frontend/recursos/img/autos/auto_20260221_193657_de7fe83b.webp', 1, '2026-02-21 13:36:57'),
(11, 6, 'frontend/recursos/img/autos/auto_20260221_193812_f72d9a24.webp', 0, '2026-02-21 13:38:12'),
(12, 6, 'frontend/recursos/img/autos/auto_20260221_193812_d33ac659.webp', 1, '2026-02-21 13:38:12'),
(13, 7, 'frontend/recursos/img/autos/auto_20260221_193944_7e3d79da.webp', 0, '2026-02-21 13:39:44'),
(14, 7, 'frontend/recursos/img/autos/auto_20260221_193944_711e916f.webp', 1, '2026-02-21 13:39:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_inventario`
--

CREATE TABLE `vehiculos_inventario` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `yonke_id` int(10) UNSIGNED NOT NULL,
  `anio` smallint(5) UNSIGNED NOT NULL,
  `marca` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `foto_principal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vehiculos_inventario`
--

INSERT INTO `vehiculos_inventario` (`id`, `usuario_id`, `yonke_id`, `anio`, `marca`, `modelo`, `cantidad`, `stock`, `foto_principal`, `estatus`, `fecha_registro`) VALUES
(2, 2, 2, 2013, 'Chevrolet', 'Spark LT', 1, 1, 'frontend/recursos/img/autos/auto_20260221_193436_d266ef52.jpg', 1, '2026-02-21 13:34:36'),
(3, 2, 1, 2014, 'Chevrolet', 'Spark GT', 1, 1, 'frontend/recursos/img/autos/auto_20260221_193510_17bfc6cb.jpg', 1, '2026-02-21 13:35:10'),
(4, 2, 2, 2000, 'GMC', 'Sierra', 1, 1, 'frontend/recursos/img/autos/auto_20260221_193603_dc654426.webp', 1, '2026-02-21 13:36:03'),
(5, 2, 1, 2008, 'GMC', 'Sierra', 1, 1, 'frontend/recursos/img/autos/auto_20260221_193657_d93dfa8b.webp', 1, '2026-02-21 13:36:57'),
(6, 2, 1, 2024, 'Toyota', 'Tacoma', 1, 1, 'frontend/recursos/img/autos/auto_20260221_193812_f72d9a24.webp', 1, '2026-02-21 13:38:12'),
(7, 2, 1, 2004, 'Chevrolet', 'Silverado', 1, 1, 'frontend/recursos/img/autos/auto_20260221_193944_7e3d79da.webp', 1, '2026-02-21 13:39:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `yonkes`
--

CREATE TABLE `yonkes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `yonkes`
--

INSERT INTO `yonkes` (`id`, `usuario_id`, `nombre`, `telefono`, `direccion`, `estatus`, `fecha_registro`) VALUES
(1, 2, 'Yonke Centro', '6641234567', 'Tijuana Centro', 1, '2026-02-21 09:34:37'),
(2, 2, 'Yonke Otay', '6642345678', 'Otay Universidad', 1, '2026-02-21 09:34:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo_autos`
--
ALTER TABLE `catalogo_autos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_catalogo_auto` (`anio`,`marca`,`modelo`),
  ADD KEY `idx_catalogo_anio_marca` (`anio`,`marca`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_permisos_slug` (`slug`);

--
-- Indices de la tabla `permisos_roles`
--
ALTER TABLE `permisos_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_permiso_rol` (`rol_id`,`permiso_id`),
  ADD KEY `fk_pr_permisos` (`permiso_id`);

--
-- Indices de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_permiso_usuario` (`usuario_id`,`permiso_id`),
  ADD KEY `fk_pu_permisos` (`permiso_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_roles_nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_usuarios_usuario` (`usuario`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- Indices de la tabla `vehiculos_fotos`
--
ALTER TABLE `vehiculos_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vf_vehiculo` (`vehiculo_id`);

--
-- Indices de la tabla `vehiculos_inventario`
--
ALTER TABLE `vehiculos_inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vi_usuarios` (`usuario_id`),
  ADD KEY `fk_vi_yonkes` (`yonke_id`);

--
-- Indices de la tabla `yonkes`
--
ALTER TABLE `yonkes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_yonkes_usuarios` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo_autos`
--
ALTER TABLE `catalogo_autos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permisos_roles`
--
ALTER TABLE `permisos_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculos_fotos`
--
ALTER TABLE `vehiculos_fotos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `vehiculos_inventario`
--
ALTER TABLE `vehiculos_inventario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `yonkes`
--
ALTER TABLE `yonkes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permisos_roles`
--
ALTER TABLE `permisos_roles`
  ADD CONSTRAINT `fk_pr_permisos` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`),
  ADD CONSTRAINT `fk_pr_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  ADD CONSTRAINT `fk_pu_permisos` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`),
  ADD CONSTRAINT `fk_pu_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `vehiculos_fotos`
--
ALTER TABLE `vehiculos_fotos`
  ADD CONSTRAINT `fk_vf_vehiculo` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos_inventario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos_inventario`
--
ALTER TABLE `vehiculos_inventario`
  ADD CONSTRAINT `fk_vi_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_vi_yonkes` FOREIGN KEY (`yonke_id`) REFERENCES `yonkes` (`id`);

--
-- Filtros para la tabla `yonkes`
--
ALTER TABLE `yonkes`
  ADD CONSTRAINT `fk_yonkes_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
