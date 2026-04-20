<?php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/../app_data.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['estado' => 0, 'mensaje' => 'Metodo no permitido']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$pass = (string) ($_POST['password'] ?? $_POST['pass'] ?? '');

try {
    $auth = new AuthController();
    $response = $auth->login($username, $pass);
} catch (Throwable $e) {
    http_response_code(500);
    $response = [
        'estado' => 0,
        'mensaje' => 'Error de conexion o consulta a base de datos.',
        'detalle' => $e->getMessage(),
    ];
}

echo json_encode($response);
