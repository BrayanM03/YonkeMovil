CREATE DATABASE IF NOT EXISTS yonkemovil CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE yonkemovil;

CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY uk_roles_nombre (nombre)
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    apellido VARCHAR(120) DEFAULT '',
    usuario VARCHAR(80) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(180) DEFAULT NULL,
    puesto VARCHAR(120) DEFAULT NULL,
    rol_id INT UNSIGNED NOT NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    foto_perfil VARCHAR(255) DEFAULT NULL,
    fecha_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_usuarios_usuario (usuario),
    CONSTRAINT fk_usuarios_roles FOREIGN KEY (rol_id) REFERENCES roles(id)
);

CREATE TABLE IF NOT EXISTS permisos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    permiso VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY uk_permisos_slug (slug)
);

CREATE TABLE IF NOT EXISTS permisos_roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    rol_id INT UNSIGNED NOT NULL,
    permiso_id INT UNSIGNED NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY uk_permiso_rol (rol_id, permiso_id),
    CONSTRAINT fk_pr_roles FOREIGN KEY (rol_id) REFERENCES roles(id),
    CONSTRAINT fk_pr_permisos FOREIGN KEY (permiso_id) REFERENCES permisos(id)
);

CREATE TABLE IF NOT EXISTS permisos_usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    permiso_id INT UNSIGNED NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY uk_permiso_usuario (usuario_id, permiso_id),
    CONSTRAINT fk_pu_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_pu_permisos FOREIGN KEY (permiso_id) REFERENCES permisos(id)
);

CREATE TABLE IF NOT EXISTS yonkes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    nombre VARCHAR(160) NOT NULL,
    telefono VARCHAR(25) DEFAULT NULL,
    direccion VARCHAR(255) DEFAULT NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_yonkes_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS catalogo_autos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    anio SMALLINT UNSIGNED NOT NULL,
    marca VARCHAR(80) NOT NULL,
    modelo VARCHAR(120) NOT NULL,
    UNIQUE KEY uk_catalogo_auto (anio, marca, modelo),
    KEY idx_catalogo_anio_marca (anio, marca)
);

CREATE TABLE IF NOT EXISTS vehiculos_inventario (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    yonke_id INT UNSIGNED NOT NULL,
    anio SMALLINT UNSIGNED NOT NULL,
    marca VARCHAR(80) NOT NULL,
    modelo VARCHAR(120) NOT NULL,
    cantidad INT UNSIGNED NOT NULL DEFAULT 1,
    stock INT UNSIGNED NOT NULL DEFAULT 1,
    foto_principal VARCHAR(255) DEFAULT NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_vi_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_vi_yonkes FOREIGN KEY (yonke_id) REFERENCES yonkes(id)
);

CREATE TABLE IF NOT EXISTS vehiculos_fotos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vehiculo_id INT UNSIGNED NOT NULL,
    foto_path VARCHAR(255) NOT NULL,
    orden SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_vf_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos_inventario(id) ON DELETE CASCADE
);

INSERT INTO roles (id, nombre, estatus) VALUES
(1, 'cliente', 1),
(2, 'admin', 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), estatus = VALUES(estatus);

INSERT INTO permisos (id, permiso, slug, descripcion, estatus) VALUES
(1, 'Ver panel admin', 'ver_panel_admin', 'Acceso al dashboard administrativo', 1),
(2, 'Ver panel cliente', 'ver_panel_cliente', 'Acceso al panel de cliente', 1),
(3, 'Ver usuarios', 'ver_usuarios', 'Acceso al modulo de usuarios', 1),
(4, 'Ver yonkes', 'ver_yonkes', 'Acceso al modulo de yonkes', 1),
(5, 'Gestionar autos cliente', 'gestionar_autos_cliente', 'Alta y baja de autos del cliente', 1),
(6, 'Ver catalogo autos', 'ver_catalogo_autos', 'Acceso al modulo de catalogo de autos', 1),
(7, 'Ver mi inventario', 'ver_mi_inventario', 'Acceso al modulo de inventario', 1)
ON DUPLICATE KEY UPDATE permiso = VALUES(permiso), descripcion = VALUES(descripcion), estatus = VALUES(estatus);

INSERT INTO permisos_roles (rol_id, permiso_id, activo) VALUES
(2, 1, 1),
(2, 3, 1),
(2, 4, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1),
(1, 2, 1),
(1, 5, 1),
(1, 7, 1)
ON DUPLICATE KEY UPDATE activo = VALUES(activo);

INSERT INTO usuarios (id, nombre, apellido, usuario, contrasena, correo, puesto, rol_id, estatus, foto_perfil) VALUES
(1, 'Admin', 'YonkeMovil', 'admin', '$2y$10$/b4eyKHTwjRIibzd7N2NZu6dauS3HzARKMBqJZFuknZGWj4I9zLTS', 'admin@yonkemovil.local', 'Administrador', 2, 1, NULL),
(2, 'Cliente', 'Demo', 'cliente', '$2y$10$yn5z4fn.QYYe.VhP.nHG5eb7Mc9ZIMcpXf8ZRFkVW14s0D9OiWeIq', 'cliente@yonkemovil.local', 'Propietario de yonke', 1, 1, NULL)
ON DUPLICATE KEY UPDATE
nombre = VALUES(nombre), apellido = VALUES(apellido), correo = VALUES(correo), puesto = VALUES(puesto), rol_id = VALUES(rol_id), estatus = VALUES(estatus);

INSERT INTO yonkes (id, usuario_id, nombre, telefono, direccion, estatus) VALUES
(1, 2, 'Yonke Centro', '6641234567', 'Tijuana Centro', 1),
(2, 2, 'Yonke Otay', '6642345678', 'Otay Universidad', 1)
ON DUPLICATE KEY UPDATE
usuario_id = VALUES(usuario_id), nombre = VALUES(nombre), telefono = VALUES(telefono), direccion = VALUES(direccion), estatus = VALUES(estatus);

INSERT INTO catalogo_autos (anio, marca, modelo) VALUES
(2018, 'Nissan', 'Versa'),
(2018, 'Nissan', 'Sentra'),
(2019, 'Toyota', 'Corolla'),
(2019, 'Toyota', 'Yaris'),
(2020, 'Honda', 'Civic'),
(2020, 'Honda', 'Accord'),
(2021, 'Chevrolet', 'Aveo'),
(2021, 'Chevrolet', 'Spark'),
(2022, 'Ford', 'Ranger'),
(2022, 'Ford', 'F-150'),
(2023, 'Kia', 'Rio'),
(2023, 'Kia', 'Forte')
ON DUPLICATE KEY UPDATE modelo = VALUES(modelo);
