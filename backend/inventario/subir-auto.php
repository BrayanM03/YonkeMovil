<?php
require_once __DIR__ . '/../../backend/bootstrap.php';
require_once __DIR__ . '/../../backend/app_data.php';

header('Content-Type: application/json; charset=utf-8');

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_MI_INVENTARIO);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $userId = app_current_user_id();
    $yonkeId = (int) ($_POST['yonke_id'] ?? 0);
    $anio = (int) ($_POST['anio'] ?? 0);
    $marca = trim((string) ($_POST['marca'] ?? ''));
    $modelo = trim((string) ($_POST['modelo'] ?? ''));
    $cantidad = max(1, (int) ($_POST['cantidad'] ?? 1));

    if ($yonkeId <= 0 || $anio < 1930 || $anio > 2035 || $marca === '' || $modelo === '') {
        throw new RuntimeException('Datos inválidos para registrar el auto.');
    }

    $vehiculoId = app_inventario_crear_con_fotos(
        $userId,
        $yonkeId,
        $anio,
        $marca,
        $modelo,
        $cantidad,
        $_FILES['fotos'] ?? []
    );

    echo json_encode(['ok' => true, 'message' => 'Auto registrado correctamente', 'vehiculo_id' => $vehiculoId]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
}
