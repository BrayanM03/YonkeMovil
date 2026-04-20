<?php
require_once __DIR__ . '/../models/Permiso.php';

class PermisoController
{
    private Permiso $model;

    public function __construct()
    {
        $this->model = new Permiso();
    }

    public function verificarSesion(): void
    {
        if (empty($_SESSION['id'])) {
            header('Location: login.php');
            exit;
        }
    }

    public function validarAcceso(int $tipoResp, string $slugPermiso): ?array
    {
        $idUsuario = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;
        $idRol = isset($_SESSION['rol']) ? (int) $_SESSION['rol'] : 0;

        
        if (!$idUsuario || !$idRol) {
            header('Location: login.php');
            exit;
        }

        try {
            $response = $this->model->verificarPermiso($idRol, $idUsuario, $slugPermiso);
        } catch (Throwable $e) {
            $response = $this->validarAccesoDemo($idRol, $slugPermiso);
        }

        if (!$response['estatus'] && $tipoResp !== 2) {
            http_response_code(403);
            echo 'No tienes permisos para acceder a este modulo.';
            exit;
        }

        if ($tipoResp === 2) {
            return $response;
        }

        return null;
    }

    private function validarAccesoDemo(int $rolId, string $slugPermiso): array
    {
        $permisosPorRol = [
            2 => [
                CPermiso::VER_PANEL_ADMIN,
                CPermiso::VER_YONKES,
                CPermiso::VER_USUARIOS,
                CPermiso::VER_CATALOGO_AUTOS,
                CPermiso::VER_MI_INVENTARIO,
            ],
            1 => [
                CPermiso::VER_PANEL_CLIENTE,
                CPermiso::GESTIONAR_AUTOS_CLIENTE,
                CPermiso::VER_MI_INVENTARIO,
            ],
        ];

        $permitidos = $permisosPorRol[$rolId] ?? [];
        $ok = in_array($slugPermiso, $permitidos, true);
        return ['estatus' => $ok, 'mensaje' => $ok ? 'Tiene permiso (demo)' : 'No tiene permiso'];
    }
}
