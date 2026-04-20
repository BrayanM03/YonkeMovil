<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/permisos.php';
require_once __DIR__ . '/../controllers/PermisoController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller_permiso = new PermisoController();
